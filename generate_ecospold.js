function generate_data_set(){
  //generate a data set for the untreated ecospold file
  var activity_name      = url.searchParams.get('activity_name')||"activity name"; //ok
  var geography          = url.searchParams.get('geography')||"GLO"; //ok
  var untreated_fraction = Geographies.find(g=>g.shortcut===geography).value; //ok "https://stackoverflow.com/questions/13964155/get-javascript-object-from-array-of-objects-by-value-of-property"
  var PV                 = {value:Activity.Q, unit:"m3/d"}; //ok
  var CSO_particulate    = {value:WWTPs.map(w=> w.CSO_particulate*w.perc_PE/100).reduce((p,c)=>p+c), unit:"%"}; //ok
  var CSO_soluble        = {value:WWTPs.map(w=> w.CSO_soluble    *w.perc_PE/100).reduce((p,c)=>p+c), unit:"%"}; //ok
  var tool_use_type      = url.searchParams.get('wwtp_type')||'average'; //ok
  var WW_type            = url.searchParams.get('wwtp_type')||'average'; //ok
  var PV_comment         = 'Some PV comment';
  var electricity        = 0;
  var FeCl3              = 0;
  var acrylamide         = 0;
  var NaHCO3             = 0;
  var WW_properties            = []; //Activity; //{Q,T,COD,TKN,TP...}
  var CSO_amounts              = []; //discharged amounts
  var WWTP_influent_properties = []; //properties after CSO
  var WWTP_emissions_water     = [];
  var WWTP_emissions_air       = [];
  var sludge_properties        = [];
  var technologies_averaged    = {
    0: {
        'fraction':0.4,
        'technology_str': "The auto_generated string representing tech 0",
        'capacity': "Class 1 (over 100,000 per-capita equivalents)",
        'location': 'Spain',
      },
    1: {
        'fraction':0.6,
        'technology_str': "The auto_generated string representing tech 1",
        'capacity': "Class 2 (50,000 to 100,000 per-capita equivalents)",
        'location': 'Spain',
      },
  }
  var data_set = {
    activity_name,
    tool_use_type,
    untreated_fraction,
    CSO_particulate,
    CSO_amounts,
    CSO_dissolved,
    WW_type,
    geography,
    PV,
    WW_properties,
    WWTP_influent_properties,
    WWTP_emissions_water,
    WWTP_emissions_water,
    sludge_amount,
    sludge_properties,
    technologies_averaged,
    electricity,
    FeCl3,
    acrylamide,
    NaHCO3,
  };

  //fill 'WW_properties'
  Object.keys(Activity).forEach(key=>{
    if(Activity[key]) //consider only > 0
      WW_properties.push({
        value: Activity[key],
        unit: Inputs.find(i=>i.id==key).unit,
        descr: Inputs.find(i=>i.id==key).descr,
      });
  });
  //------------------------------------------

  //remove 'tech' attribute from CSO discharged amounts
  data_set.CSO_amounts.forEach(v=>{delete v.tech});

  //remove value==0 emissions
  data_set.CSO_amounts   = data_set.CSO_amounts.filter(  el=>{return el.value>0});
  data_set.WW_properties = data_set.WW_properties.filter(el=>{return el.value>0});

  //convert g/m3 to kg/m3
  data_set.CSO_amounts.concat(data_set.WW_properties).forEach(el=>{
    if(el.unit.includes("g/m3")){
      el.value/=1000;
      el.unit=el.unit.replace("g/m3","kg/m3");
    }
  });

  //add ecoinvent id (if found)
  data_set.WW_properties.forEach(el=>{
    var ecoinvent_id = Ecoinvent_ids.inputs[el.id];
    el.ecoinvent_id  = ecoinvent_id;

    if(!ecoinvent_id){
      console.warn("ecoinvent id not found for "+el.id)
    }
  });
  data_set.CSO_amounts.forEach(el=>{
    var ecoinvent_id = Ecoinvent_ids.water_emissions[el.id.replace('_discharged','').replace('elem_','')];
    el.ecoinvent_id  = ecoinvent_id;

    if(!ecoinvent_id){
      console.warn("ecoinvent id not found for "+el.id)
    }
  });

  Object.keys(data_set).forEach(key=>{
    console.log(key,data_set[key]);
  });
}

function generate_ecospold(){
  var data_set = generate_data_set();
  generate_untreated_ecospold(data_set);
  generate_treated_ecospold(data_set);
}

function generate_untreated_ecospold(data_set) {
  var data_set_string=JSON.stringify(data_set);
  post('generate_untreated_ecospold.php', data_set_string);
}

function generate_treated_ecospold(data_set) {
  var data_set_string=JSON.stringify(data_set);
  //post('generate_treated_ecospold.php', data_set_string);
}

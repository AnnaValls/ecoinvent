//create a JSON sent to the python scripts that generate the ecospold files
function generate_json_for_ecospold(result){
  //json file fields
    //inputs
      var activity_name      = url.searchParams.get('activity_name')||"activity name"; //ok
      var geography          = url.searchParams.get('geography')||"GLO"; //ok
      var untreated_fraction = Geographies.find(g=>g.shortcut===geography).RQ; //ok "https://stackoverflow.com/questions/13964155/get-javascript-object-from-array-of-objects-by-value-of-property"
      var tool_use_type      = url.searchParams.get('wwtp_type')||'average'; //ok
      var PV                 = {value:Activity.Q, unit:"m3/d"}; //ok
      var PV_comment         = 'some PV comment'; //ok
      var CSO_particulate    = {value:WWTPs.map(w=> w.CSO_particulate*w.perc_PE/100).reduce((p,c)=>p+c), unit:"%"}; //ok
      var CSO_soluble        = {value:WWTPs.map(w=> w.CSO_soluble    *w.perc_PE/100).reduce((p,c)=>p+c), unit:"%"}; //ok
      var fraction_C_fossil  = {value:WWTPs.map(w=> w.fossil_CO2_percent*w.perc_PE/100).reduce((p,c)=>p+c), unit:"%"}; //ok
      var technologies_averaged = [];
      var capacity = {value:WWTPs.map(w=> w.PEq*w.perc_PE/100).reduce((p,c)=>p+c), unit:"population equivalents"}; //ok
      var WW_properties      = []; //Activity

      //FILL ARRAYS
      //1. technologies_averaged
      WWTPs.forEach(wwtp=>{
        technologies_averaged.push({
          fraction:wwtp.perc_PE/100,
          capacity:wwtp.PEq,
          location:geography,
          technology_level_1:"aerobic intensive",          //fixed for now
          technology_level_2:Tec_mix_encoder.encode(wwtp), //"binary string"
        });
      });
      //2. fill WW_properties
      Object.keys(Activity).forEach(key=>{
        if(Activity[key]) { //consider only > 0
          var ecoinvent_id=Ecoinvent_ids.inputs[key]||false;
          WW_properties.push({
            id    : key,
            value : Activity[key],
            unit  : Inputs.find(i=>i.id==key).unit,
            descr : Inputs.find(i=>i.id==key).descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("ecoinvent id not found for input '"+key+"' in 'inputs'");}
        }
      });

    //outputs
      var chemicals = {
        NaHCO3     : {
          for_nitrification:   result.weighted_contribution.chemicals.alkalinity_added,
          for_denitrification: result.weighted_contribution.chemicals.Mass_of_alkalinity_needed,
        },
        acrylamide : result.weighted_contribution.chemicals.Dewatering_polymer, //{value,unit,descr}
        FeCl3      : result.weighted_contribution.chemicals.FeCl3_volume,       //{value,unit,descr}
      };
      var electricity              = result.weighted_contribution.Ene.total_daily_energy; //{value,unit,descr}
      var carbon_content           = result.weighted_contribution.other.TOC_content;      //{value,unit,descr}
      var CSO_amounts              = []; //discharged amounts
      var WWTP_influent_properties = []; //properties after CSO
      var WWTP_emissions_water     = []; //properties after treatment
      var WWTP_emissions_air       = []; //properties after treatment
      var sludge_properties        = []; //properties after treatment
      var untreated_as_emissions   = []; //same as CSO, with 100% for both particulates and dissolved

      //FILL ARRAYS
      //1. CSO_amounts discharged by CSO
      Object.keys(result.weighted_contribution.CSO).forEach(key=>{
        var item=result.weighted_contribution.CSO[key];
        if(item.unit.includes("kg/d") && item.value){
          var key_replaced = key.replace('elem_','').replace('_discharged_kgd','');
          var ecoinvent_id=Ecoinvent_ids.water_emissions[key_replaced]||false;
          CSO_amounts.push({
            id    : key,
            value : item.value,
            unit  : item.unit,
            descr : item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("ecoinvent id not found for '"+key+"' in 'water_emissions'");}
        }
      });

      //2. WWTP_influent_properties: properties after CSO
      Object.keys(result.weighted_contribution.inputs_after_CSO).forEach(key=>{
        var item=result.weighted_contribution.inputs_after_CSO[key];
        var ecoinvent_id=Ecoinvent_ids.inputs[key]||false;
        if(item.value){
          WWTP_influent_properties.push({
            id:key,
            value:item.value,
            unit:item.unit,
            descr:item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("ecoinvent id not found for '"+key+"' in 'inputs'");}
        }
      });

      //3. WWTP_emissions_water      //properties after treatment
      Object.keys(result.weighted_contribution.Outputs).filter(key=>key.includes('effluent_water')).forEach(key=>{
        var item=result.weighted_contribution.Outputs[key];
        var key_replaced = key.replace('elem_','').replace('_effluent_water','');
        var ecoinvent_id=Ecoinvent_ids.water_emissions[key_replaced]||false;
        if(item.value){
          WWTP_emissions_water.push({
            id:key,
            value:item.value/1000, //convert to kg/d from g/d
            unit:"kg/d",
            descr:item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("ecoinvent id not found for '"+key_replaced+"' in 'water_emissions'");}
        }
      });

      //4. WWTP_emissions_air        //properties after treatment
      Object.keys(result.weighted_contribution.Outputs).filter(key=>key.includes('effluent_air')).forEach(key=>{
        var item=result.weighted_contribution.Outputs[key];
        var key_replaced = key.replace('elem_','').replace('_effluent_air','');
        var ecoinvent_id=Ecoinvent_ids.air_emissions[key_replaced]||false;
        if(item.value){
          WWTP_emissions_air.push({
            id:key,
            value:item.value/1000, //convert to kg/d from g/d
            unit:"kg/d",
            descr:item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("ecoinvent id not found for '"+key_replaced+"' in 'air_emissions'");}
        }
      });

      //5. sludge_properties         //properties after treatment
      Object.keys(result.weighted_contribution.sludge_composition).forEach(key=>{
        var item=result.weighted_contribution.sludge_composition[key];
        var key_replaced = key.replace('','');
        var ecoinvent_id=Ecoinvent_ids.sludge_emissions[key_replaced]||false;
        if(item.value){
          sludge_properties.push({
            id:key,
            value:item.value,
            unit:item.unit,
            descr:item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("ecoinvent id not found for '"+key_replaced+"' in 'sludge_emissions'");}
        }
      });
      //TODO
      //6. untreated_as_emissions //same as CSO, with 100% for both particulates and dissolved

  //JSON sent to the python scripts that generate the ecospold files
  var data_set = {
    //inputs
    inputs:{
      activity_name,
      geography,
      untreated_fraction,
      tool_use_type,
      PV,
      PV_comment,
      CSO_particulate,
      CSO_soluble,
      fraction_C_fossil,
      technologies_averaged,
      capacity,
      WW_properties,
      url:(new URL(window.location)).href,
    },
    //outputs
    outputs:{
      chemicals,
      electricity,
      carbon_content,
      CSO_amounts,
      WWTP_influent_properties,
      WWTP_emissions_water,
      WWTP_emissions_air,
      sludge_properties,
      untreated_as_emissions,
    },
  };

  //return
  console.log(data_set);
  return data_set;
}

function generate_ecospold(result){
  var data_set = generate_json_for_ecospold(result);
  var data_set_string=JSON.stringify(data_set);
  post('generate_ecospold.php', data_set_string, true);
}

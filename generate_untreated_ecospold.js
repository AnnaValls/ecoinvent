function generate_untreated_ecospold() {
  //generate a data set for the untreated ecospold file
  var data_set = {
    activity_name:       document.querySelector('#activity_name').value,
    geography:           document.querySelector('#geography').value,
    untreated_fraction:  parseFloat(document.querySelector('#RQ').getAttribute('value')),
    PV:                  {value:parseFloat(document.querySelector('#PV').value), unit:"m3/year"},

    CSO_particulate:     {value:getInput('CSO_particulate').value,   unit:"%"},
    CSO_soluble:         {value:getInput('CSO_soluble').value,       unit:"%"},
    CSO_amounts:         [], //discharged amounts from "cso_removal.js"
    WW_properties:       [], //ww inputs before cso
  };

  //check inputs
  if(isNaN(data_set.untreated_fraction)){ data_set.untreated_fraction="not available"; }
  if(data_set.activity_name==""){         data_set.activity_name="undefined"; }

  //get WW properties
  //get cso discharged elements
  data_set.WW_properties = Inputs.filter(i=>{ return !i.isParameter});
  data_set.CSO_amounts   = Variables.filter(v=>{ return v.tech=="CSO"});

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
    var ecoinvent_id = Ecoinvent_ids[el.id];
    el.ecoinvent_id  = ecoinvent_id;
  });
  data_set.CSO_amounts.forEach(el=>{
    var ecoinvent_id = Ecoinvent_ids[el.id.replace('_discharged','').replace('elem_','')];
    el.ecoinvent_id  = ecoinvent_id;
  });

  //stringify data_set
  var data_set_string=JSON.stringify(data_set);

  //generate a POST to another page and go there
  post('generate_untreated_ecospold.php', data_set_string);

  //debug
  //console.log(data_set);
}

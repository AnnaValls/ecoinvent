function generate_untreated_ecospold(){
  //generate a data set for the untreated ecospold file
  var data_set = {
    activity_name:       document.querySelector('#activity_name').value,
    geography:           document.querySelector('#geography').value,
    untreated_fraction:  parseFloat(document.querySelector('#RQ').getAttribute('value')),
    CSO_particulate:     {value:getInput('CSO_particulate').value, unit:"%"},
    CSO_soluble:         {value:getInput('CSO_soluble').value,     unit:"%"},
    PV:                  {value:getInput('Q').value*365.25,        unit:"m3/year"},
    CSO_amounts:         [],
    WW_properties:       [],
  };

  //user input checks
  if(isNaN(data_set.untreated_fraction)){
    data_set.untreated_fraction="not available"; }

  if(data_set.activity_name==""){
    data_set.activity_name="not specified"; }

  //get WW properties
  //get cso discharged elements
  data_set.WW_properties = Inputs.filter(i=>{return !i.isParameter});
  data_set.CSO_amounts   = Variables.filter(v=>{return v.tech=="CSO"});

  //remove 'tech' attribute
  data_set.CSO_amounts.forEach(v=>{delete v.tech});

  //add ecoinvent id (if found)
  data_set.WW_properties.forEach(el=>{
    var ecoinvent_id = Ecoinvent_ids[el.id];
    el.ecoinvent_id  =  ecoinvent_id;
  });
  data_set.CSO_amounts.forEach(el=>{
    var ecoinvent_id = Ecoinvent_ids[el.id.replace('_discharged','').replace('elem_','')];
    el.ecoinvent_id  =  ecoinvent_id;
  });

  //stringify data_set
  var data_set_string=JSON.stringify(data_set);

  //debug
  //console.log(data_set);

  //generate a POST to another page and go there
  post('generate_untreated_ecospold.php', data_set_string);
}

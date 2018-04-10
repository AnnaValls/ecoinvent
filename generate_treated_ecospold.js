function generate_treated_ecospold() {

  //generate a data set for the treated ecospold file
  var data_set = {
    WWTP_influent_properties  :  {},
    tool_use_type             :  {},
    WW_type                   :  {},
    technologies_averaged     :  {},
    WWTP_emissions_water      :  {},
    WWTP_emissions_air        :  {},
    sludge_amount             :  {},
    sludge_properties         :  {},
    electricity               :  {},
    FeCl3                     :  {},
    acrylamide                :  {},
    NaHCO3                    :  {},
  };

  //TODO fill here

  //stringify data_set
  var data_set_string=JSON.stringify(data_set);

  //generate a POST to another page and go there
  //post('generate_untreated_ecospold.php', data_set_string);

  //debug
  console.log(data_set);
}

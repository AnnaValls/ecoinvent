/**
  * Main backend function for 'multiple plant model' (see 'n-wwtp.php' for frontend)
  */

//get 2 influents and mix them
function mix_influents(activity, reference){
  //activity:  dict
  //reference: dict
  var rv={
    Q: activity.Q + reference.Q,
  };
  //combine wastewater characteristics
  Object.keys(activity).filter(key=>{return key!="Q"}).forEach(key=>{
    rv[key]=(activity.Q*activity[key]+reference.Q*reference[key])/rv.Q;
  });
  //get design parameters from reference
  Object.keys(reference).filter(key=>{return getInputById(key).isParameter}).forEach(key=>{
    rv[key]=reference[key];
  });
  //get technologies from reference
  Object.keys(Technologies).filter(key=>{return !Technologies[key].notActivable}).forEach(key=>{
    rv["is_"+key+"_active"]=reference["is_"+key+"_active"];
  });
  return rv;
}

//perform a marginal approach
function marginal_approach(activity, reference){
  //activity:  dict
  //reference: dict
  var outputs_reference = compute_elementary_flows(reference).Outputs;
  //console.log(outputs_reference);
  var mixed_influent = mix_influents(activity, reference);
  //console.log(mixed_influent);
  var outputs_mixed  = compute_elementary_flows(mixed_influent).Outputs;
  //console.log(outputs_mixed);

  //calculate contribution
  var contribution = {};
  Object.keys(outputs_mixed).forEach(key=>{
    //total contribution (g/d) or (g/m3)
    contribution[key] = (outputs_mixed[key].value - outputs_reference[key].value);///activity.Q;
  });
  //console.log(contribution);
  return { contribution, outputs_mixed };
}

//perform all simulations
function n_wwtps_simulation(activity, WWTPs){
  var contributions=[];
  var outputs_mixed=[];

  //perform n marginal approaches
  WWTPs.forEach(wwtp=>{
    var ma_result = marginal_approach(activity,wwtp);
    contributions.push(ma_result.contribution);
    outputs_mixed.push(ma_result.outputs_mixed);
  });
  //console.log(contributions);
  //console.log(outputs_mixed);

  //average all the contributions weighted by "perc_PE" value
  var weighted_contribution = {};
  var weighted_output_mixed = {};
  Object.keys(contributions[0]).forEach(key=>{
    weighted_contribution[key] = 0;
    weighted_output_mixed[key] = 0;
    WWTPs.forEach((wwtp,i)=>{
      weighted_contribution[key] += wwtp.perc_PE/100 * contributions[i][key];
      weighted_output_mixed[key] += wwtp.perc_PE/100 * outputs_mixed[i][key].value;
    });
  });

  //console.log(weighted_contribution);
  //console.log(weighted_output_mixed);
  return {weighted_contribution, weighted_output_mixed};
}

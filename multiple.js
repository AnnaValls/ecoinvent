/**
  * Main backend function for 'multiple plant model' (see 'n-wwtp.php' for frontend)
  *
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
  return rv; //{Q, T, COD, TKN, ...}
}

//perform a marginal approach
function marginal_approach(activity, reference){
  //activity:  {Q, T, COD, TKN, ...}
  //reference: {Q, T, COD, TKN, ...}

  //mix influents
  var mixed_influent = mix_influents(activity, reference);

  //run reference WWTP
  //run mixed influents
  var results_reference = compute_elementary_flows(reference);      //{Fra,BOD,CSO,Nit,Outputs...}
  var results_mixed     = compute_elementary_flows(mixed_influent); //{Fra,BOD,CSO,Nit,Outputs...}

  return {results_reference, results_mixed};
}

//calculate a contribution (='mixed' minus 'reference')
function calculate_contribution(results_reference, results_mixed){
  //calculate contribution from activity
  var contribution = {}; //{} same structure as result
  //tec: BOD, Nit, Fra, CSO, Pri...
  //key: COD, TKN, P_X_bio, etc depending on technology

  //copy structure from results to contributions
  Object.keys(results_reference).forEach(tec=>{
    contribution[tec]={};
    Object.keys(results_reference[tec]).forEach(key=>{
      //mixed - reference
      var value = (results_mixed[tec][key].value - results_reference[tec][key].value);
      contribution[tec][key] = {value, unit:results_mixed[tec][key].unit, descr:results_mixed[tec][key].descr};
    });
  });
  return contribution;
}

//PERFORM ALL SIMULATIONS
function n_wwtps_simulation(activity, WWTPs){
  var results_reference =[]; //store all n results from reference wwtps
  var results_mixed     =[]; //store all n results from mixed influents (activity+wwtp1, activity+wwtp2, ...)
  var contributions     =[]; //store all n contributions from activity to the n wwtps

  //run n marginal approaches
  WWTPs.forEach(wwtp=>{
    var mr = marginal_approach(activity,wwtp); //marginal results: {results_reference, results_mixed}
    //store results
    results_reference.push(mr.results_reference);
    results_mixed.push(mr.results_mixed);
    //calculate activity contributions for wwtp i
    var con = calculate_contribution(mr.results_reference, mr.results_mixed);
    contributions.push(con);
  });

  //weight average all the contributions and outputs weighted by "perc_PE" value
  var weighted_contribution = {};
  var weighted_reference    = {};
  var weighted_mixed        = {};

  //WEIGHT AVERAGE ALL CONTRIBUTIONS AND RESULTS (MIXED AND REFERENCE)
  //first: all contribution objects have all 'tec' strings, but not all tec strings have all keys inside 
  //because that technology may be inactive: 
  //The object will be empty, and won't be displayed in "all_contributions" table in gui
  //we have to solve this: if one contribution has keys inside, has to be copied with a default value of 0
  (function(){
    Object.keys(contributions[0]).forEach(tec=>{
      var tec_lengths=[];//check the number of outputs for the technology 'tec'
      contributions.forEach(con=>{ tec_lengths.push(Object.keys(con[tec]).length); });
      //look if array has at least one zero and at least one greater than zero
      if(tec_lengths.find(x=>x==0)==0 && tec_lengths.find(x=>x>0)){
        console.log('tech',tec,'is special case');
        //find wwtp index > 0 (means: wwtp that has technology active)
        var active_wwtp_index = tec_lengths.indexOf(tec_lengths.find(x=>x>0));
        console.log('wwtp with active',tec,':',active_wwtp_index);
        //find indexs at 0 and create the keys inside
        while(true){
          var inactive_wwtp_index=tec_lengths.indexOf(0);
          if(inactive_wwtp_index==-1){break;}
          console.log('wwtp with inactive',tec,':',inactive_wwtp_index);
          Object.keys(contributions[active_wwtp_index][tec]).forEach(key=>{
            contributions[inactive_wwtp_index][tec][key] = {
              value:0,
              unit: contributions[active_wwtp_index][tec][key].unit,
              descr:contributions[active_wwtp_index][tec][key].descr,
            };
            results_reference[inactive_wwtp_index][tec][key] = {
              value:0,
              unit: contributions[active_wwtp_index][tec][key].unit,
              descr:contributions[active_wwtp_index][tec][key].descr,
            };
            results_mixed[inactive_wwtp_index][tec][key] = {
              value:0,
              unit: contributions[active_wwtp_index][tec][key].unit,
              descr:contributions[active_wwtp_index][tec][key].descr,
            };
          });
          tec_lengths[inactive_wwtp_index]='solved!';
        }
      }
    });
  })();

  //actual average weighting code
  Object.keys(contributions[0]).forEach(tec=>{
    weighted_contribution[tec] = {};
    weighted_reference[tec]    = {};
    weighted_mixed[tec]        = {};
    Object.keys(contributions[0][tec]).forEach(key=>{
      weighted_contribution[tec][key] = {value:0, unit:contributions[0][tec][key].unit, descr:contributions[0][tec][key].descr};
      weighted_reference[tec][key]    = {value:0, unit:contributions[0][tec][key].unit, descr:contributions[0][tec][key].descr};
      weighted_mixed[tec][key]        = {value:0, unit:contributions[0][tec][key].unit, descr:contributions[0][tec][key].descr};
      WWTPs.forEach((wwtp,i)=>{
        //'key' should exist altough 'tec' is inactive
        weighted_contribution[tec][key].value += wwtp.perc_PE/100 * contributions[i][tec][key].value;
        weighted_reference[tec][key].value    += wwtp.perc_PE/100 * results_reference[i][tec][key].value;
        weighted_mixed[tec][key].value        += wwtp.perc_PE/100 * results_mixed[i][tec][key].value;
      });
    });
  });

  var rv={
    weighted_contribution, //{Fra,BOD,CSO,Pri,Nit,SST,Met,Ene,other}
    weighted_reference,    //{Fra,BOD,CSO,Pri,Nit,SST,Met,Ene,other}
    weighted_mixed,        //{Fra,BOD,CSO,Pri,Nit,SST,Met,Ene,other}
  }
  return rv;
}

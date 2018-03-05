/**
  * Remove a fraction of the two particulate fractions of COD (biodeg + nonbiodeg)
  * TODO not implemented
  */
function primary_settler(bpCOD, nbpCOD, fraction_bp, fraction_nbp){
  var new_bpCOD  = fraction_bp  * bpCOD;
  var new_nbpCOD = fraction_nbp * nbpCOD;
  return {
    bpCOD:  {value:new_bpCOD,  unit:"g/m3_as_O2", descr:"Biodegradable_particulate_COD"},
    nbpCOD: {value:new_nbpCOD, unit:"g/m3_as_O2", descr:"Nonbiodegradable_particulate_COD"},
  }
}

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var bpCOD        = 112;
  var nbpCOD       = 56;
  var fraction_bp  = 0.5;
  var fraction_nbp = 0.5;
  console.log(
    primary_settler(bpCOD, nbpCOD, fraction_bp, fraction_nbp)
  );
})();

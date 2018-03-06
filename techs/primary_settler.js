/**
  * Remove a fraction of the two particulate fractions of COD (biodeg + nonbiodeg)
  *
  */
function primary_settler(bpCOD, nbpCOD, removal_bp, removal_nbp){

  //apply removal rates to pCOD fractions (%)
  var bpCOD_removed   = 0.01*removal_bp  * bpCOD;
  var nbpCOD_removed  = 0.01*removal_nbp * nbpCOD;
  var pCOD_removed    = bpCOD_removed + nbpCOD_removed;

  return {
    bpCOD_removed:   {value:bpCOD_removed,   unit:"g/m3_as_O2",  descr:"Removed_bpCOD_by_primary_settler"},
    nbpCOD_removed:  {value:nbpCOD_removed,  unit:"g/m3_as_O2",  descr:"Removed_nbpCOD_by_primary_settler"},
    pCOD_removed:    {value:pCOD_removed,    unit:"g/m3_as_O2",  descr:"Removed_pCOD_by_primary_settler"},
  }
}

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var bpCOD       = 112;
  var nbpCOD      = 56;
  var removal_bp  = 50;
  var removal_nbp = 50;
  console.log(
    primary_settler(bpCOD, nbpCOD, removal_bp, removal_nbp)
  );
})();

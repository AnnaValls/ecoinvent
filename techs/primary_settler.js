/**
  * Remove a fraction of the two particulate fractions of COD (biodeg + nonbiodeg)
  *
  */
function primary_settler(Q,bpCOD, nbpCOD, iTSS, removal_bp, removal_nbp, removal_iss){

  //apply removal rates to pCOD fractions (%)
  var bpCOD_removed   = 0.01*removal_bp  * bpCOD;  //g/m3
  var nbpCOD_removed  = 0.01*removal_nbp * nbpCOD; //g/m3
  var iTSS_removed    = 0.01*removal_iss * iTSS;   //g/m3

  var pCOD_removed     = bpCOD_removed + nbpCOD_removed; //g/m3
  var pCOD_removed_kgd = Q*pCOD_removed/1000;            //kg/d

  return {
    bpCOD_removed:     {value:bpCOD_removed,    unit:"g/m3_as_O2", descr:"Removed_bpCOD_by_primary_settler"},
    nbpCOD_removed:    {value:nbpCOD_removed,   unit:"g/m3_as_O2", descr:"Removed_nbpCOD_by_primary_settler"},
    iTSS_removed:      {value:iTSS_removed,     unit:"g/m3",       descr:"Removed_iTSS_by_primary_settler"},
    pCOD_removed:      {value:pCOD_removed,     unit:"g/m3_as_O2", descr:"Removed_pCOD_by_primary_settler"},
    pCOD_removed_kg_d: {value:pCOD_removed_kgd, unit:"kg/d_as_O2", descr:"Removed_pCOD_by_primary_settler"},
  }
}

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var Q           = 22700;
  var bpCOD       = 112;
  var nbpCOD      = 56;
  var iTSS        = 10;

  var removal_bp  = 40;
  var removal_nbp = 60;
  var removal_iss = 70;

  console.log(
    primary_settler(Q,bpCOD, nbpCOD, iTSS, removal_bp, removal_nbp, removal_iss)
  );
})();

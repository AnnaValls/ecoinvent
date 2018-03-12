/**
  * Remove a fraction of the two particulate fractions of COD (biodeg + nonbiodeg)
  *
  */
function primary_settler(Q,bpCOD,nbpCOD,iTSS,ON,OP, removal_bpCOD,removal_nbpCOD,removal_iTSS,removal_ON,removal_OP){

  //apply removal rates to pCOD fractions (%)
  var bpCOD_removed   = 0.01*removal_bpCOD  * bpCOD;  //g/m3
  var nbpCOD_removed  = 0.01*removal_nbpCOD * nbpCOD; //g/m3
  var iTSS_removed    = 0.01*removal_iTSS   * iTSS;   //g/m3
  var ON_removed      = 0.01*removal_ON     * ON;     //g/m3
  var OP_removed      = 0.01*removal_OP     * OP;     //g/m3

  var pCOD_removed     = bpCOD_removed + nbpCOD_removed; //g/m3
  var pCOD_removed_kgd = Q*pCOD_removed/1000;            //kg/d

  /* George Ekama mail:
      I suggest that for the municipal wastewater:
      Settled WW TKN = (TKN – NH4)/3 + NH4
      Settled WW TP  = (TP  – PO4)/3 + PO4
      Where FSA = NH4 =  Free and saline ammonia concentration (FSA is dissolved so is
      the same in raw and settled WW)
      And PO4 =  Ortho phosphate concetration (PO4 is dissolved and so is the same in raw and settled WW).
      This approach assumes that 2/3rd of the raw WW Org N (TKN minus FSA) and
      2/3rd of the raw WW Org P (TP minus OP) are removed by the PST.
  */
  var pON_removed = 0;
  var pOP_removed = 0;

  return {
    bpCOD_removed:     {value:bpCOD_removed,    unit:"g/m3_as_O2", descr:"Removed_bpCOD_by_primary_settler"},
    nbpCOD_removed:    {value:nbpCOD_removed,   unit:"g/m3_as_O2", descr:"Removed_nbpCOD_by_primary_settler"},
    pCOD_removed:      {value:pCOD_removed,     unit:"g/m3_as_O2", descr:"Removed_pCOD_by_primary_settler"},
    pCOD_removed_kg_d: {value:pCOD_removed_kgd, unit:"kg/d_as_O2", descr:"Removed_pCOD_by_primary_settler"},
    iTSS_removed:      {value:iTSS_removed,     unit:"g/m3",       descr:"Removed_iTSS_by_primary_settler"},

    ON_removed:        {value:ON_removed,       unit:"g/m3",       descr:"Removed_ON_by_primary_settler"},
    OP_removed:        {value:OP_removed,       unit:"g/m3",       descr:"Removed_OP_by_primary_settler"},
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
  var ON          = 10;
  var OP          = 1;

  var removal_bpCOD  = 40;
  var removal_nbpCOD = 60;
  var removal_iTSS   = 70;
  var removal_ON     = 66;
  var removal_OP     = 66;

  console.log(
    primary_settler(Q,bpCOD,nbpCOD,iTSS,ON,OP,removal_bpCOD,removal_nbpCOD,removal_iTSS,removal_ON,removal_OP)
  );
})();

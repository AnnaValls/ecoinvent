/*
 * Technology: Fractionation of the influent
 * Metcalf & Eddy, Wastewater Engineering, 5th ed., 2014:
 * page 756
 *
 */

function fractionation(BOD,sBOD,COD,bCOD,sCOD,TSS,VSS){
  /*
    | Inputs         | example values |
    |----------------+----------------+
    | BOD            |       140 g/m3 |
    | sBOD           |        70 g/m3 |
    | COD            |       300 g/m3 |
    | bCOD           |       224 g/m3 |
    | sCOD           |       132 g/m3 |
    | TSS            |        70 g/m3 |
    | VSS            |        60 g/m3 |
  */

  /*SOLUTION*/
  var bCOD_BOD_ratio = bCOD/BOD || 0;                    //1.6 g bCOD/g BOD
  bCOD_BOD_ratio     = isFinite(bCOD_BOD_ratio) ? bCOD_BOD_ratio : 0; //avoid infinity if BOD==0

  var nbCOD   = Math.max(COD - bCOD, 0);                 // 76 g/m3
  var nbsCODe = Math.max(sCOD - bCOD_BOD_ratio*sBOD, 0); // 20 g/m3
  var nbpCOD  = Math.max(COD - bCOD - nbsCODe, 0);       // 56 g/m3

  var VSS_COD = (COD-sCOD)/VSS || 0;                     //2.8 g_COD/g_VSS
  VSS_COD     = isFinite(VSS_COD) ? VSS_COD : 0;         //avoid infinity when VSS==0

  var nbVSS   = nbpCOD/VSS_COD || 0;                     // 20 g/m3
  nbVSS       = isFinite(nbVSS) ? nbVSS : 0;             //avoid infinity when VSS_COD==0

  var iTSS    = Math.max(TSS - VSS, 0);                  // 10 g/m3

  //return results object
  return {
    bCOD_BOD_ratio:{value:bCOD_BOD_ratio, unit:"g_bCOD/g_BOD", descr:"bCOD/BOD ratio"},
    nbCOD:         {value:nbCOD,          unit:"g/m3",         descr:"Nonbiodegradable_COD"},
    nbsCODe:       {value:nbsCODe,        unit:"g/m3",         descr:"Nonbiodegradable_soluble_COD_effluent"},
    nbpCOD:        {value:nbpCOD,         unit:"g/m3",         descr:"Nonbiodegradable_particulate_COD"},
    VSS_COD:       {value:VSS_COD,        unit:"g_COD/g_VSS",  descr:"pCOD/VSS ratio"},
    nbVSS:         {value:nbVSS,          unit:"g/m3",         descr:"Nonbiodegradable_VSS"},
    iTSS:          {value:iTSS,           unit:"g/m3",         descr:"Inert TSS"},
  };
};

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var BOD            = 140;
  var sBOD           = 70;
  var COD            = 300;
  var bCOD           = 224;
  var sCOD           = 132;
  var TSS            = 70;
  var VSS            = 60;
  console.log(
    fractionation(BOD,sBOD,COD,bCOD,sCOD,TSS,VSS)
  );
})();

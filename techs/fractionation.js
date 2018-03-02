/*
 * Technology: Fractionation of the influent
 * Metcalf & Eddy, Wastewater Engineering, 5th ed., 2014:
 * page 756
 *
 */

function fractionation(BOD,sBOD,COD,bCOD,sCOD,TSS,VSS,TKN,NH4_eff,TP){
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
    | TKN            |        35 g/m3 |
    | NH4_eff        |       0.5 g/m3 |
    | TP             |         6 g/m3 |
  */

  /*SOLUTION*/

  //1. COD fractions
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

  //2. TKN fractions
  var nbpON   = Math.min(TKN, 0.064*nbVSS);           //g/m3
  var nbsON   = Math.min(TKN, 0.3);                   //g/m3
  var TKN_N2O = 0.001*TKN;                            //g/m3
  var bTKN    = Math.max(0, TKN-nbpON-nbsON-TKN_N2O); //g/m3
  var sTKNe   = NH4_eff + nbsON;                      //g/m3 -- sTKNe (used only in TKN effluent)

  //3. TP fractions
  var nbpP   = Math.min(TP, 0.025*nbVSS); //g/m3
  var aP     = Math.max( 0, TP - nbpP);   //g/m3 == PO4_in

  //return results object
  return {
    bCOD_BOD_ratio: {value:bCOD_BOD_ratio, unit:"g_bCOD/g_BOD", descr:"bCOD/BOD ratio"},
    nbCOD:          {value:nbCOD,          unit:"g/m3_as_O2",   descr:"Nonbiodegradable_COD"},
    nbsCODe:        {value:nbsCODe,        unit:"g/m3_as_O2",   descr:"Nonbiodegradable_soluble_COD_effluent"},
    nbpCOD:         {value:nbpCOD,         unit:"g/m3_as_O2",   descr:"Nonbiodegradable_particulate_COD"},
    VSS_COD:        {value:VSS_COD,        unit:"g_COD/g_VSS",  descr:"pCOD/VSS ratio"},
    nbVSS:          {value:nbVSS,          unit:"g/m3",         descr:"Nonbiodegradable_VSS"},
    iTSS:           {value:iTSS,           unit:"g/m3",         descr:"Inert TSS"},
    nbpON:          {value:nbpON,          unit:"g/m3_as_N",    descr:"Nonbiodegradable particulate ON"},
    nbsON:          {value:nbsON,          unit:"g/m3_as_N",    descr:"Nonbiodegradable soluble ON"},
    TKN_N2O:        {value:TKN_N2O,        unit:"g/m3_as_N",    descr:"TKN N2O (0.1% of TKN)"},
    bTKN:           {value:bTKN,           unit:"g/m3_as_N",    descr:"Niodegradable TKN"},
    sTKNe:          {value:sTKNe,          unit:"g/m3_as_N",    descr:"Soluble TKN effluent"},
    nbpP:           {value:nbpP,           unit:"g/m3_as_P",    descr:"Nonbiodegradable particulate P"},
    aP:             {value:aP,             unit:"g/m3_as_P",    descr:"Available P"},
  };
};

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var BOD     = 140;
  var sBOD    = 70;
  var COD     = 300;
  var bCOD    = 224;
  var sCOD    = 132;
  var TSS     = 70;
  var VSS     = 60;
  var TKN     = 35;
  var NH4_eff = 0.5;
  var TP      = 6;
  console.log(
    fractionation(BOD,sBOD,COD,bCOD,sCOD,TSS,VSS,TKN,NH4_eff,TP)
  );
})();

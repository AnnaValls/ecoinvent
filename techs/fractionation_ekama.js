/**
  * Technology: Fractionation of the influent (G. Ekama version)
  * These equations are meant to overwrite the ones in "fractionation.js"
  *
  *        /- BS: biodg & soluble ==  bsCOD -\
  *        |                                  |--> sCOD
  *        |- US: nonbg & soluble == nbsCOD -/
  * COD -->|
  *        |- BP: biodg & particl ==  bpCOD -\
  *        |                                  |--> pCOD
  *        \- UP: nonbg & particl == nbpCOD -/
  *
  *              BS: biodg & soluble ==  bsCOD -\
  *           /- US: nonbg & soluble == nbsCOD   |--> bCOD
  * nbCOD -->|   BP: biodg & particl ==  bpCOD -/
  *           \- UP: nonbg & particl == nbpCOD
  *
*/

function fractionation_ekama(COD,sCOD,fSus,fSup,BOD,sBOD,TSS,VSS){
  /**
    * | Inputs | example values |
    * |--------+----------------|
    * | COD    | 750 g/m3       |
    * | sCOD   | 199 g/m3       |
    * | fSus   |   7 %          | (nbsCOD/COD)
    * | fSup   |  15 %          | (nbpCOD/COD)
    *
  */
  /*
    COD
      - bCOD = bsCOD + bpCOD
      - uCOD = usCOD + upCOD

      - sCOD = bsCOD + usCOD
      - pCOD = bpCOD + upCOD
  */

  /*SOLUTION*/
  var pCOD = COD - sCOD; //551 g/m3 (BP+UP)
  var US   = fSus*COD;   // 53 g/m3
  var BS   = sCOD - US;  //146 g/m3
  var UP   = fSup*COD;   //113 g/m3
  var BP   = pCOD - UP;  //438 g/m3

  //adapt to metcalf & eddy notation
  var bsCOD    = BS;
  var nbsCOD   = US;
  var bpCOD    = BP;
  var nbpCOD   = UP;
  var bCOD     = BS+BP;
  var nbCOD    = US+UP;

  //M&E equations
  var bCOD_BOD_ratio = bCOD/BOD;
  var nbsCODe        = sCOD - bCOD_BOD_ratio*sBOD; //g/m3
  var VSS_COD        = (COD - sCOD)/VSS;           //g_COD/g_VSS
  var nbVSS          = nbpCOD/VSS_COD;             //g/m3
  var iTSS           = TSS - VSS;                  //g/m3

  //return results object
  return {
    bsCOD:           {value:bsCOD,           unit:"g/m3",         descr:"Biodegradable_Soluble_COD"},
    nbsCOD:          {value:nbsCOD,          unit:"g/m3",         descr:"Nonbiodegradable_Soluble_COD"},
    bpCOD:           {value:bpCOD,           unit:"g/m3",         descr:"Biodegradable_Particulate_COD"},
    nbpCOD:          {value:nbpCOD,          unit:"g/m3",         descr:"Nonbiodegradable_Particulate_COD"},
    bCOD:            {value:bCOD,            unit:"g/m3",         descr:"Biodegradable_COD"},
    pCOD:            {value:pCOD,            unit:"g/m3",         descr:"Particulate_COD"},
    nbCOD:           {value:nbCOD,           unit:"g/m3",         descr:"Nonbiodegradable_COD"},
    bCOD_BOD_ratio:  {value:bCOD_BOD_ratio,  unit:"g_bCOD/g_COD", descr:"bCOD/BOD_ratio"},
    nbsCODe:         {value:nbsCODe,         unit:"g/m3",         descr:"Nonbiodegradable_Soluble_COD_effluent"},
    VSS_COD:         {value:VSS_COD,         unit:"g_COD/g_VSS",  descr:"pCOD/VSS_ratio"},
    nbVSS:           {value:nbVSS,           unit:"g/m3",         descr:"Nonbiodegradable_VSS"},
    iTSS:            {value:iTSS,            unit:"g/m3",         descr:"Inert_TSS"},
  };
};

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var COD  = 300;
  var sCOD = 132;
  var fSus = 0.066667;
  var fSup = 0.186667;
  var BOD  = 140;
  var sBOD = 70;
  var TSS  = 70;
  var VSS  = 60;
  console.log(
    fractionation_ekama(COD,sCOD,fSus,fSup,BOD,sBOD,TSS,VSS)
  );
})();

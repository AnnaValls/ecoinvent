/*
 * Technology: Fractionation of the influent
 * Metcalf & Eddy, Wastewater Engineering, 5th ed., 2014:
 * page 756
 *
 */

function fractionation(BOD,sBOD,COD,bCOD,sCOD,TSS,VSS,TKN,NH4,NH4_eff,TP,PO4){
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
    | NH4            |        25 g/m3 |
    | NH4_eff        |       0.5 g/m3 |
    | TP             |         6 g/m3 |
    | PO4            |         5 g/m3 |
  */

  //0.ratios
  var bCOD_BOD_ratio = BOD==0 ? 0 : bCOD/BOD; //1.6 g bCOD/g BOD
  var COD_BOD_ratio  = BOD==0 ? 0 : COD/BOD;  //usually 1.9-2.0 g COD/g BOD

  //pBOD
  var pBOD = Math.max(0, BOD - sBOD); //70 g/m3

  //1. COD fractions
  var nbCOD   = Math.max(COD - bCOD, 0);                 // 76 g/m3
  var nbsCODe = Math.max(sCOD - bCOD_BOD_ratio*sBOD, 0); // 20 g/m3
  var nbpCOD  = Math.max(COD - bCOD - nbsCODe, 0);       // 56 g/m3

  //1.2 George Ekama fractions (USO, UPO)
  var fSus = COD==0 ? 0 : 100*(nbsCODe/COD); // USO fraction (%)
  var fSup = COD==0 ? 0 : 100*(nbpCOD/COD);  // UPO fraction (%)
  /*
    George mail:
    TODO raw nbpCOD/COD: between 8% and 25% à warning: out of range:
    if you get values outside of the range… it is likely that the COD/BOD ratio
    is wrong… normally COD/BOD we would expect for raw WW like 1.8 to 2.1; and for
    settled WW like 1.7 to 2; either change the total COD or the BOD so that these
    values fall within range;
    Settled à nbpCOD/totalCOD must be equal or greater than 0 and less than 10%
    Raw à nbsCOD/totalCOD from 0 to 10%
    settled à nbsCOD/totalCOD from 0 to 15%
  */

  //more COD fractions (not in M&E book)
  var pCOD  = Math.max(0, COD - sCOD);
  var bsCOD = Math.max(0, COD - pCOD - nbsCODe);
  var bpCOD = Math.max(0, COD - nbCOD - bsCOD);
  //end of COD fractions

  //TSS and VSS
  var VSS_COD = VSS     ==0 ? 0 : pCOD/VSS;       //2.8 g_pCOD/g_VSS
  var nbVSS   = VSS_COD ==0 ? 0 : nbpCOD/VSS_COD; // 20 g/m3
  var iTSS    = Math.max(0, TSS - VSS);           // 10 g/m3

  //2. TKN fractions
  //TODO review these should be done by G. Ekama & Y. Comeau
  var ON    = Math.max(0,   TKN-NH4);

  var nbpON = Math.min(TKN, 0.064*nbVSS);           //g/m3
  var nbsON = Math.min(TKN, 0.3);                   //g/m3
  var nbON  = nbpON + nbsON;

  var TKN_N2O = 0.001*TKN;                            //g/m3
  var bTKN    = Math.max(0, TKN-nbpON-nbsON-TKN_N2O); //g/m3
  var sTKNe   = NH4_eff + nbsON;                      //g/m3 -- sTKNe (used only in TKN effluent)

  //new ones
  var bON   = 0; //TODO
  var sON   = 0; //TODO
  var pON   = 0; //TODO
  var bsON  = 0; //TODO
  var nbsON = 0; //TODO
  var bpON  = 0; //TODO

  //3. TP fractions
  var OP   = Math.max(0,  TP-PO4);

  var nbpP = Math.min(TP, 0.015*nbVSS); //g/m3
  var aP   = Math.max( 0, TP - nbpP);   //g/m3 == PO4_in

  //new ones
  var bOP   = 0; //TODO
  var nbOP  = 0; //TODO
  var sOP   = 0; //TODO
  var pOP   = 0; //TODO

  var bsOP  = 0; //TODO
  var nbsOP = 0; //TODO
  var bpOP  = 0; //TODO
  var nbpOP = 0; //TODO

  //return results object
  return {
    //ratios
    bCOD_BOD_ratio: {value:bCOD_BOD_ratio, unit:"g_bCOD/g_BOD", descr:"bCOD/BOD_ratio"},
    COD_BOD_ratio:  {value:COD_BOD_ratio,  unit:"g_COD/g_BOD",  descr:"COD/BOD_ratio"},
    fSus:           {value:fSus,           unit:"%",            descr:"Unbiodegradable & soluble fraction (USO/COD)"},
    fSup:           {value:fSup,           unit:"%",            descr:"Unbiodegradable & particulate fraction (UPO/COD)"},
    VSS_COD:        {value:VSS_COD,        unit:"g_pCOD/g_VSS", descr:"pCOD/VSS ratio"},

    //COD fractions (s/p/b/nb)
    COD:            {value:COD,            unit:"g/m3_as_O2",   descr:"Total_COD"},
    bCOD:           {value:bCOD,           unit:"g/m3_as_O2",   descr:"Biodegradable_COD"},
    nbCOD:          {value:nbCOD,          unit:"g/m3_as_O2",   descr:"Nonbiodegradable_COD"},
    sCOD:           {value:sCOD,           unit:"g/m3_as_O2",   descr:"Soluble_COD"},
    pCOD:           {value:pCOD,           unit:"g/m3_as_O2",   descr:"Particulate_COD"},

    //COD fractions (b/nb & s/p)
    bsCOD:          {value:bsCOD,          unit:"g/m3_as_O2",   descr:"Biodegradable_soluble_COD_(=rbCOD)"},
    nbsCODe:        {value:nbsCODe,        unit:"g/m3_as_O2",   descr:"Nonbiodegradable_soluble_COD_effluent"},
    bpCOD:          {value:bpCOD,          unit:"g/m3_as_O2",   descr:"Biodegradable_particulate_COD"},
    nbpCOD:         {value:nbpCOD,         unit:"g/m3_as_O2",   descr:"Nonbiodegradable_particulate_COD"},

    //BOD
    BOD:            {value:BOD,            unit:"g/m3_as_O2",   descr:"Total_BOD"},
    sBOD:           {value:sBOD,           unit:"g/m3_as_O2",   descr:"Soluble_BOD"},
    pBOD:           {value:pBOD,           unit:"g/m3_as_O2",   descr:"Particulate_BOD"},

    //suspended solids
    TSS:            {value:TSS,            unit:"g/m3",         descr:"TSS"},
    VSS:            {value:VSS,            unit:"g/m3",         descr:"VSS"},
    nbVSS:          {value:nbVSS,          unit:"g/m3",         descr:"Nonbiodegradable_VSS"},
    iTSS:           {value:iTSS,           unit:"g/m3",         descr:"Inert TSS"},

    //Nitrogen fractions
    TKN:            {value:TKN,            unit:"g/m3_as_N",    descr:"Total Kjedahl nitrogen"},
    NH4:            {value:NH4,            unit:"g/m3_as_N",    descr:"Ammonia influent"},
    ON:             {value:ON,             unit:"g/m3_as_N",    descr:"Organic N"},

    bON:            {value:bON,            unit:"g/m3_as_N",    descr:"Biodegradable ON"},
    nbON:           {value:nbON,           unit:"g/m3_as_N",    descr:"Nonbiodegradable ON"},
    sON:            {value:sON,            unit:"g/m3_as_N",    descr:"Soluble ON"},
    pON:            {value:pON,            unit:"g/m3_as_N",    descr:"Particulate ON"},

    bsON:           {value:bsON,           unit:"g/m3_as_N",    descr:"Biodegradable soluble ON"},
    nbsON:          {value:nbsON,          unit:"g/m3_as_N",    descr:"Nonbiodegradable soluble ON"},
    bpON:           {value:bpON,           unit:"g/m3_as_N",    descr:"Biodegradable particulate ON"},
    nbpON:          {value:nbpON,          unit:"g/m3_as_N",    descr:"Nonbiodegradable particulate ON"},

    TKN_N2O:        {value:TKN_N2O,        unit:"g/m3_as_N",    descr:"TKN N2O (0.1% of TKN)"},
    bTKN:           {value:bTKN,           unit:"g/m3_as_N",    descr:"Niodegradable TKN"},
    sTKNe:          {value:sTKNe,          unit:"g/m3_as_N",    descr:"Soluble TKN effluent"},

    //Phosphorus fractions
    TP:             {value:TP,             unit:"g/m3_as_P",    descr:"Total phosphorus"},
    PO4:            {value:PO4,            unit:"g/m3_as_P",    descr:"Ortophosphate influent"},
    OP:             {value:OP,             unit:"g/m3_as_P",    descr:"Organic P"},

    bOP:            {value:bOP,            unit:"g/m3_as_N",    descr:"Biodegradable OP"},
    nbOP:           {value:nbOP,           unit:"g/m3_as_N",    descr:"Nonbiodegradable OP"},
    sOP:            {value:sOP,            unit:"g/m3_as_N",    descr:"Soluble OP"},
    pOP:            {value:pOP,            unit:"g/m3_as_N",    descr:"Particulate OP"},

    bsOP:           {value:bsOP,           unit:"g/m3_as_N",    descr:"Biodegradable soluble OP"},
    nbsOP:          {value:nbsOP,          unit:"g/m3_as_N",    descr:"Nonbiodegradable soluble OP"},
    bpOP:           {value:bpOP,           unit:"g/m3_as_N",    descr:"Biodegradable particulate OP"},
    nbpOP:          {value:nbpOP,          unit:"g/m3_as_N",    descr:"Nonbiodegradable particulate OP"},

    nbpP:           {value:nbpP,           unit:"g/m3_as_P",    descr:"Nonbiodegradable particulate P"},
    aP:             {value:aP,             unit:"g/m3_as_P",    descr:"Available P (TP-nbpP)"},
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
  var NH4     = 25;
  var NH4_eff = 0.5;
  var TP      = 6;
  var PO4     = 5;
  console.log(
    fractionation(BOD,sBOD,COD,bCOD,sCOD,TSS,VSS,TKN,NH4,NH4_eff,TP,PO4)
  );
})();

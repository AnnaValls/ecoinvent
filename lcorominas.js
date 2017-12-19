/*
 * lcorominas pdf equations summarized
 *
 */

/* Outputs: COD CO2 CH4 TKN NOx N2 N2O TP TS */
var Outputs={
  COD:{influent:0,effluent:{air:0,water:0,sludge:0}},
  CO2:{influent:0,effluent:{air:0,water:0,sludge:0}},
  CH4:{influent:0,effluent:{air:0,water:0,sludge:0}},
  TKN:{influent:0,effluent:{air:0,water:0,sludge:0}},
  NOx:{influent:0,effluent:{air:0,water:0,sludge:0}},
  N2 :{influent:0,effluent:{air:0,water:0,sludge:0}},
  N2O:{influent:0,effluent:{air:0,water:0,sludge:0}},
  TP :{influent:0,effluent:{air:0,water:0,sludge:0}},
  TS :{influent:0,effluent:{air:0,water:0,sludge:0}},
};

//constants needed
var YH = 0.45;
var fd = 0.15;

//active technologies
var is_BOD_active = true;
var is_Nit_active = true;
var is_Des_active = true;
var is_BiP_active = true;
var is_ChP_active = true;

//fx: compute pdf equations
function lcorominas(
  COD,
  C_PO4_eff,
  MLSS_X_TSS,
  NO3_eff,
  NOx,
  Ne,
  P_X_bio,
  Q,
  S,
  S0,
  SRT,
  TKN,
  TP,
  TS,
  TSSe,
  V_aerobic,
  V_anaerobic,
  V_anoxic,
  X_R,
  bCOD,
  bHT,
  nbVSS,
  nbpCOD,
  nbsCODe,
  nbsCODe,
  sCOD
){
  //equations block 1
  var rbCOD        = sCOD - nbsCODe;                //g/m3 (input!)
  var VFA          = 0.15 * rbCOD;                  //g/m3 (input!)
  var nbpON        = 0.064 * nbVSS;                 //g/m3
  var nbsON        = 0.3;                           //g/m3
  var TKN_N2O      = 0.001 * TKN;                   //g/m3
  var bTKN         = TKN - nbpON - nbsON - TKN_N2O; //g/m3

  //equations block 2
  var VSSe            = TSSe*0.85;                 //g/m3
  var sCODe           = Q*(nbsCODe + S);           //g/d
  var nbpP            = 0.025*nbVSS;               //g/m3
  var aP              = TP - nbpP;                 //g/m3 == PO4_in
  var aPchem          = aP - 0.015*P_X_bio*1000/Q; //g/m3 == PO4_in
  var C_PO4_inf       = aPchem;                    //g/m3 (input!)

  //equations block 3
  var V_total = V_aerobic + V_anoxic + V_anaerobic;          //m3
  var Qwas = (V_total*MLSS_X_TSS/SRT - Q*TSSe)/(X_R - TSSe); //m3/d
  var Qe = Q - Qwas;                                         //m3/d
  var sTKNe = Qe*(Ne + nbsON);                               //g/d

  /*Outputs: COD CO2 CH4 TKN NOx N2 N2O TP TS*/

  //Outputs.COD
  Outputs.COD.influent        = Q*COD;
  Outputs.COD.effluent.water  = sCODe + Qe*VSSe*1.42;
  Outputs.COD.effluent.air    = 0;
  Outputs.COD.effluent.sludge = (function(){
    var A = P_X_bio*1000;
    var B = Qwas*sCODe/Q;
    var C = Q*nbpCOD;
    var D = Qe*VSSe*1.42;
    return A+B+C-D;
  })();

  //Outputs.CO2
  Outputs.CO2.influent       = 0;
  Outputs.CO2.effluent.water = 0;
  Outputs.CO2.effluent.air   = (function(){
    var k_CO2_COD = 0.99;
    var k_CO2_bio = 1.03;
    var air = k_CO2_COD*Q*(1-YH)*(S0-S) + k_CO2_bio*Q*YH*(S0-S)*bHT*SRT/(1+bHT*SRT)*(1-fd) - 4.49*NOx;
    return air;
  })();
  Outputs.CO2.effluent.sludge = 0;

  //Outputs.CH4
  Outputs.CH4.influent        = 0;
  Outputs.CH4.effluent.water  = 0;
  Outputs.CH4.air             = (function(){ //TODO
    var is_Anaer_treatment = false; 
    if(is_Anaer_treatment){
      return 0.95*Q*bCOD;
    }else{
      return 0;
    }
  })();
  Outputs.CH4.effluent.sludge = 0;

  //Outputs.TKN
  Outputs.TKN.influent = Q*TKN;
  Outputs.TKN.effluent.water = (function(){
    if(is_Nit_active){ 
      return Qe*Ne + Qe*nbsON + Qe*VSSe*0.12 
    }else{
      return Q*(TKN - nbpON - TKN_N2O) + Qe*VSSe*0.12 - 0.12*P_X_bio*1000 
    }
  })();
  Outputs.TKN.effluent.air    = 0;
  Outputs.TKN.effluent.sludge = (function(){
    var A = 0.12*P_X_bio*1000;
    var B = Qwas*sTKNe/Qe;
    var C = Q*nbpON;
    var D = Qe*VSSe*0.12;
    return A+B+C-D;
  })();

  //Outputs.NOx
  Outputs.NOx.influent       = Q*NOx;
  Outputs.NOx.effluent.water = (function(){
    if     (is_Nit_active==false){ return 0}
    else if(is_Des_active){        return Qe*NO3_eff}
    else if(is_Des_active==false){ return Q*bTKN - Qe*Ne - 0.12*P_X_bio*1000 }
  })();
  Outputs.NOx.effluent.air = 0;
  Outputs.NOx.effluent.sludge = (function(){
    if     (is_Nit_active==false){ return 0}
    else if(is_Des_active){        return Qwas*NO3_eff}
    else if(is_Des_active==false){ return Qwas*NOx}
  })();

  //Outputs.N2
  Outputs.N2.influent       = 0;
  Outputs.N2.effluent.water = 0;
  Outputs.N2.effluent.air   = (function(){
    if(is_Des_active){
      return Q*(NOx - NO3_eff);
    }else{
      return 0;
    }
  })();
  Outputs.N2.effluent.sludge = 0;

  //Outputs.N2O
  Outputs.N2O.influent        = 0;
  Outputs.N2O.effluent.water  = 0;
  Outputs.N2O.effluent.air    = Q*TKN_N2O;
  Outputs.N2O.effluent.sludge = 0;

  //Outputs.TP
  Outputs.TP.influent = Q*TP;
  Outputs.TP.effluent.water = (function(){
    if      (is_BiP_active==false && is_ChP_active==false){
      return Q*aPchem + Qe*VSSe*0.015
    }else if(is_BiP_active        && is_ChP_active==false){ 
      return Q*(Result.BiP.Effluent_P.value - nbpP) + Qe*VSSe*0.015;
    }else if(is_BiP_active==false && is_ChP_active){ 
      return Q*C_PO4_eff + Qe*VSSe*0.015 + Qe*VSSe*(C_PO4_eff-C_PO4_inf)/(P_X_VSS*1000)
    }else{                                                  
      return 0; //not defined
    }
  })();
  Outputs.TP.effluent.air = 0;
  Outputs.TP.effluent.sludge = (function(){
    var B = Qwas*C_PO4_eff;
    var C = Q*nbpP;
    var D = Qe*VSSe*0.015;
    if      (is_BiP_active==false && is_ChP_active==false){ 
      return (0.015*P_X_bio*1000) + B + C - D
    }else if(is_BiP_active        && is_ChP_active==false){ 
      return Q*Result.BiP.P_removal.value + B + C - D
    }else if(is_BiP_active==false && is_ChP_active){ 
      return (0.015*P_X_bio*1000) + Q*(aPchem - C_PO4_eff) + B + C - D
    }else{
      return 0; //not defined
    }
  })();

  //Outputs.TS
  Outputs.TS.influent        = Q*TS;
  Outputs.TS.effluent.water  = 0;
  Outputs.TS.effluent.air    = 0;
  Outputs.TS.effluent.sludge = 0;

  //return object
  return {
    C_PO4_inf,
    Qe,
    Qwas,
    TKN_N2O,
    VFA,
    VSSe,
    V_total,
    aP,
    aPchem,
    bTKN,
    nbpON,
    nbpP,
    nbsON,
    rbCOD,
    sCODe,
    sTKNe,
  };
}

//debugging
(function(){
  var COD=300;
  var C_PO4_eff=0;
  var MLSS_X_TSS=0;
  var NO3_eff=0;
  var NOx=0;
  var Ne=0;
  var P_X_bio=0;
  var Q=0;
  var S=0;
  var S0=0;
  var SRT=0;
  var TKN=0;
  var TP=0;
  var TS=0;
  var TSSe=0;
  var V_aerobic=0;
  var V_anaerobic=0;
  var V_anoxic=0;
  var X_R=0;
  var bCOD=0;
  var bHT=0;
  var nbVSS=0;
  var nbpCOD=0;
  var nbsCODe=0;
  var nbsCODe=0;
  var sCOD=0;
  var result=lcorominas(
    COD, C_PO4_eff, MLSS_X_TSS, NO3_eff, NOx, Ne, P_X_bio, Q, S, S0, SRT, TKN, TP,
    TS, TSSe, V_aerobic, V_anaerobic, V_anoxic, X_R, bCOD, bHT, nbVSS, nbpCOD, nbsCODe, nbsCODe, sCOD
  )
  console.log(result);
})()

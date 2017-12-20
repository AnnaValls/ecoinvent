/*
 * lcorominas pdf equations implementation
 * 
 */

function pdf(
  nbVSS,
  TKN,
  TSSe,
  nbsCODe,
  S,
  TP,
  P_X_bio,
  Q,
  V_aer,
  V_nox,
  V_ana,
  MLSS_X_TSS,
  SRT,
  X_R,
  Ne
){
  //lcorominas - equations block 1
  var nbpON   = 0.064 * nbVSS;                 //g/m3
  var nbsON   = 0.3;                           //g/m3
  var TKN_N2O = 0.001 * TKN;                   //g/m3
  var bTKN    = TKN - nbpON - nbsON - TKN_N2O; //g/m3

  //lcorominas - equations block 2
  //var rbCOD = sCOD - nbsCODe; //g/m3 (input!)
  //var VFA   = 0.15 * rbCOD;   //g/m3 (input!)

  //lcorominas - equations block 3
  var VSSe      = TSSe*0.85;               //g/m3
  var sCODe     = Q*(nbsCODe+S);           //g/d
  var nbpP      = 0.025*nbVSS;             //g/m3
  var aP        = TP-nbpP;                 //g/m3 == PO4_in
  var aPchem    = aP-0.015*P_X_bio*1000/Q; //g/m3 == PO4_in
  var C_PO4_inf = aPchem;                  //g/m3 (input!)

  //lcorominas - equations block 4
  var V_total = V_aer + V_nox + V_ana;                       //m3
  var Qwas = (V_total*MLSS_X_TSS/SRT - Q*TSSe)/(X_R - TSSe); //m3/d
  var Qe = Q - Qwas;                                         //m3/d
  var sTKNe = Qe*(Ne + nbsON);                               //g/d

  //end
  return {
    nbpON      :{ value:nbpON,      unit:"",  descr:""},
    nbsON      :{ value:nbsON,      unit:"",  descr:""},
    TKN_N2O    :{ value:TKN_N2O,    unit:"",  descr:""},
    bTKN       :{ value:bTKN,       unit:"",  descr:""},
    VSSe       :{ value:VSSe,       unit:"",  descr:""},
    sCODe      :{ value:sCODe,      unit:"",  descr:""},
    nbpP       :{ value:nbpP,       unit:"",  descr:""},
    aP         :{ value:aP,         unit:"",  descr:""},
    aPchem     :{ value:aPchem,     unit:"",  descr:""},
    C_PO4_inf  :{ value:C_PO4_inf,  unit:"",  descr:""},
    V_total    :{ value:V_total,    unit:"",  descr:""},
    Qwas       :{ value:Qwas,       unit:"",  descr:""},
    Qe         :{ value:Qe,         unit:"",  descr:""},
    sTKNe      :{ value:sTKNe,      unit:"",  descr:""},
  }
}

/* create outputs */
function fill_Outputs(){
  //Outputs.COD
  Outputs.COD.influent        = Q*COD;
  Outputs.COD.effluent.water  = sCODe + Qe*VSSe*1.42;
  Outputs.COD.effluent.air    = (function(){
    if(is_Des_active){
      return Result.Des.OTRf.value*24*1000; //OTRf is kg/h
    }else{
      return Result.BOD.OTRf.value*24*1000; //OTRf is kg/h
    }
  })();
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
      return Qe*Ne + Qe*nbsON + Qe*VSSe*0.12;
    }else{
      return Q*(TKN - nbpON - TKN_N2O) + Qe*VSSe*0.12 - 0.12*P_X_bio*1000;
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
  Outputs.NOx.effluent.air = (function(){return 0})();
  Outputs.NOx.effluent.sludge = (function(){
    if     (is_Nit_active==false){ return 0}
    else if(is_Des_active){        return Qwas*NO3_eff}
    else if(is_Des_active==false){ return Qwas*NOx}
  })();

  //Outputs.N2
  Outputs.N2.influent       = 0;
  Outputs.N2.effluent.water = 0;
  Outputs.N2.effluent.air   = (function(){
    if(is_Des_active) { 
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
    if(is_BiP_active==false && is_ChP_active==false){
      return Q*aPchem + Qe*VSSe*0.015;
    }else if(is_BiP_active  && is_ChP_active==false){
      return Q*(Result.BiP.Effluent_P.value - nbpP) + Qe*VSSe*0.015;
    }else if(is_BiP_active==false && is_ChP_active){
      return Q*C_PO4_eff + Qe*VSSe*0.015 + Qe*VSSe*(C_PO4_eff-C_PO4_inf)/(P_X_VSS*1000);
    }else{
      return 0; //chem+bio p removal not seen in practice (G. Ekama)
    }
  })();
  Outputs.TP.effluent.air = 0;
  Outputs.TP.effluent.sludge = (function(){
    var B = Qwas*C_PO4_eff;
    var C = Q*nbpP;
    var D = Qe*VSSe*0.015;
    if(is_BiP_active==false && is_ChP_active==false){
      return (0.015*P_X_bio*1000) + B + C - D;
    }else if(is_BiP_active  && is_ChP_active==false){ 
      return Q*Result.BiP.P_removal.value + B + C - D;
    }else if(is_BiP_active==false && is_ChP_active){ 
      return (0.015*P_X_bio*1000) + Q*(aPchem - C_PO4_eff) + B + C - D
    }else{
      return 0; //chem+bio p removal not seen in practice (G. Ekama)
    }
  })();

  //Outputs.TS
  Outputs.TS.influent        = Q*TS;
  Outputs.TS.effluent.water  = 0;
  Outputs.TS.effluent.air    = 0;
  Outputs.TS.effluent.sludge = 0;
}

//debugging
pdf()

fill_Outputs()

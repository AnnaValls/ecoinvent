/**
  *
  * Main backend function (table 3.1)
  *
*/
function compute_elementary_flows(Input_set){
  //process-inputs
    var is=Input_set;
    //technologies activated
    var is_BOD_active = is.is_BOD_active;
    var is_Nit_active = is.is_Nit_active;
    var is_Des_active = is.is_Des_active;
    var is_BiP_active = is.is_BiP_active;
    var is_ChP_active = is.is_ChP_active;
    //ww characteristics
    var Q              = is.Q;
    var T              = is.T;
    var COD            = is.COD;
    var sCOD           = is.sCOD;
    var BOD            = is.BOD;
    var sBOD           = is.sBOD;
    var bCOD_BOD_ratio = is.bCOD_BOD_ratio;
    var TSS            = is.TSS;
    var VSS            = is.VSS;
    var TKN            = is.TKN;
    var Alkalinity     = is.Alkalinity;
    var TP             = is.TP;
    var TS             = is.TS;
    //influent metals
    var Ag = is.Ag;
    var Al = is.Al;
    var As = is.As;
    var B =  is.B;
    var Ba = is.Ba;
    var Be = is.Be;
    var Br = is.Br;
    var Ca = is.Ca;
    var Cd = is.Cd;
    var Cl = is.Cl;
    var Co = is.Co;
    var Cr = is.Cr;
    var Cu = is.Cu;
    var F  = is.F;
    var Fe = is.Fe;
    var Hg = is.Hg;
    var I  = is.I;
    var K  = is.K;
    var Mg = is.Mg;
    var Mn = is.Mn;
    var Mo = is.Mo;
    var Na = is.Na;
    var Ni = is.Ni;
    var Pb = is.Pb;
    var Sb = is.Sb;
    var Sc = is.Sc;
    var Se = is.Se;
    var Si = is.Si;
    var Sn = is.Sn;
    var Sr = is.Sr;
    var Ti = is.Ti;
    var Tl = is.Tl;
    var V  = is.V;
    var W  = is.W;
    var Zn = is.Zn;

    //design parameters
    var SRT                  = is.SRT;
    var MLSS_X_TSS           = is.MLSS_X_TSS;
    var zb                   = is.zb;
    var Pressure             = is.Pressure;
    var Df                   = is.Df;
    var C_L                  = is.DO; //caution of name change
    var SF                   = is.SF;
    var Ne                   = is.Ne;
    var sBODe                = is.sBODe;
    var TSSe                 = is.TSSe;
    var Anoxic_mixing_energy = is.Anoxic_mixing_energy;
    var NO3_eff              = is.NO3_eff;
    var SOR                  = is.SOR;
    var X_R                  = is.X_R;
    var clarifiers           = is.clarifiers;
    var TSS_removal_wo_Fe    = is.TSS_removal_wo_Fe;
    var TSS_removal_w_Fe     = is.TSS_removal_w_Fe;
    var C_PO4_eff            = is.C_PO4_eff;
    var FeCl3_solution       = is.FeCl3_solution;
    var FeCl3_unit_weight    = is.FeCl3_unit_weight;
    var days                 = is.days;
    //these three inputs had an equation but they are now inputs again
    var rbCOD = is.rbCOD;
    var VFA   = is.VFA;
    //var C_PO4_inf = is.C_PO4_inf;
  //end-process-inputs

  //reset Variables object
  Variables=[];

  //starting point: bod removal has to be always active. If not: do nothing
  if(is_BOD_active==false){
    console.log('BOD REMOVAL IS INACTIVE: nothing will be calculated');
    Inputs_to_be_hidden=[];
    return;
  }

  //new empty object to store each technology results
  var Result={Fra:{},BOD:{},Nit:{},SST:{},Des:{},BiP:{},ChP:{},Met:{}};

  //APPLY TECHNOLOGIES + lcorominas equations
  /*0. SOLVE FRACTIONATION */
  Result.Fra=fractionation(BOD,sBOD,COD,sCOD,TSS,VSS,bCOD_BOD_ratio);
  addResults('Fra',Result.Fra);

  /*1. SOLVE BOD REMOVAL*/
  Result.BOD=bod_removal_only(BOD,sBOD,COD,sCOD,TSS,VSS,bCOD_BOD_ratio,Q,T,SRT,MLSS_X_TSS,zb,Pressure,Df,C_L);
  addResults('BOD',Result.BOD);

  //get variables for lcorominas pdf equations block 1
  var bCOD    = Result.Fra.bCOD.value;    //g/m3
  var nbsCODe = Result.Fra.nbsCODe.value; //g/m3
  var nbpCOD  = Result.Fra.nbpCOD.value;  //g/m3
  var nbVSS   = Result.Fra.nbVSS.value;   //g/m3
  var iTSS    = Result.Fra.iTSS.value;    //10 g/m3
  var S0      = bCOD;                     //g/m3
  var bHT     = Result.BOD.bHT.value;     //1/d

  //lcorominas equations block 1
  var nbpON   = 0.064*nbVSS;             //g/m3
  var nbsON   = 0.3;                     //g/m3
  var TKN_N2O = 0.001*TKN;               //g/m3
  var bTKN    = TKN-nbpON-nbsON-TKN_N2O; //g/m3

  //block 1 - equations for actual inputs
  //var rbCOD = sCOD - nbsCODe; //g/m3 (input!)
  //var VFA   = 0.15 * rbCOD;   //g/m3 (input!)

  /*2. SOLVE NITRIFICATION*/
  if(is_Nit_active){
    //to correct NOx and P_X_bio from Metcalf use bTKN instead of TKN
    //         nitrification(----------------------------------------------TKN----------------------------------------------------------)
    Result.Nit=nitrification(BOD,bCOD_BOD_ratio,sBOD,COD,sCOD,TSS,VSS,Q,T,bTKN,SF,zb,Pressure,Df,MLSS_X_TSS,Ne,sBODe,TSSe,Alkalinity,C_L);
    addResults('Nit',Result.Nit);
  }

  //get variables after nitrification for equations block 2
  var S       = is_Nit_active ? Result.Nit.S.value           : Result.BOD.S.value;       //g/m3
  var NOx     = is_Nit_active ? Result.Nit.NOx.value         : 0;                        //g/m3
  var P_X_bio = is_Nit_active ? Result.Nit.P_X_bio_VSS.value : Result.BOD.P_X_bio.value; //kg/d
  var P_X_VSS = is_Nit_active ? Result.Nit.P_X_VSS.value     : Result.BOD.P_X_VSS.value; //kg/d
  var b_AOB_T = is_Nit_active ? Result.Nit.b_AOB_T.value     : 0;                        //1/d

  //get SRT from Nit results if Nit is active
  SRT = is_Nit_active ? Result.Nit.SRT_design.value : SRT; //d

  //lcorominas - equations block 2
  var VSSe      = TSSe*0.85;                 //g/m3
  var sCODe     = Q*(nbsCODe+S);             //g/d
  var nbpP      = 0.025*nbVSS;               //g/m3
  var aP        = TP - nbpP;                 //g/m3 == PO4_in
  var aPchem    = aP - 0.015*P_X_bio*1000/Q; //g/m3 == PO4_in
  var C_PO4_inf = aPchem;                    //g/m3 (input!)

  //lcorominas requested hiding these inputs from frontend.
  //I've moved them to Variables
  Inputs_to_be_hidden=[
    //{id:'rbCOD',      value:rbCOD      },
    //{id:'VFA',        value:VFA        },
    {id:'C_PO4_inf',  value:C_PO4_inf, },
    {id:'sBODe',      value:sBODe,     invisible:true},
  ];

  /*3. SOLVE SST*/
  Result.SST=sst_sizing(Q,SOR,X_R,clarifiers,MLSS_X_TSS);
  addResults('SST',Result.SST);

  /*4. SOLVE DENITRIFICATION*/
  if(is_Nit_active && is_Des_active){
    var MLVSS                 = Result.Nit.MLVSS.value;      //2370 g/m3
    var Aerobic_SRT           = Result.Nit.SRT_design.value; //21 d
    var Aeration_basin_volume = Result.Nit.V.value;          //13410 m3
    var Aerobic_T             = Result.Nit.tau.value;        //14.2 h
    var RAS                   = Result.SST.RAS.value;        //0.6 unitless
    var R0                    = Result.Nit.OTRf.value;       //275.9 kg O2/h
    Result.Des=N_removal(Q,T,BOD,bCOD,rbCOD,NOx,Alkalinity,MLVSS,Aerobic_SRT,Aeration_basin_volume,Aerobic_T,Anoxic_mixing_energy,RAS,R0,NO3_eff,Df,zb,C_L,Pressure);
    addResults('Des',Result.Des);
  }

  /*5. SOLVE BIO P*/
  if(is_BiP_active){
    Result.BiP=bio_P_removal(Q,bCOD,rbCOD,VFA,nbVSS,iTSS,TP,T,SRT,NOx,NO3_eff);
    addResults('BiP',Result.BiP);
  }

  /*5. SOLVE CHEM P*/
  if(is_ChP_active){
    Result.ChP=chem_P_removal(Q,TSS,TSS_removal_wo_Fe,TSS_removal_w_Fe,TP,C_PO4_inf,C_PO4_eff,FeCl3_solution,FeCl3_unit_weight,days);
    addResults('ChP',Result.ChP);
  }
  //end technologies from metcalf and eddy

  /*6. Metals (from G. Doka)*/
  Result.Met=metals_doka(Ag,Al,As,B,Ba,Be,Br,Ca,Cd,Cl,Co,Cr,Cu,F,Fe,Hg,I,K,Mg,Mn,Mo,Na,Ni,Pb,Sb,Sc,Se,Si,Sn,Sr,Ti,Tl,V,W,Zn);
  addResults('Met',Result.Met);

  /*
   * Calc total volumes:
   *  V_total = V_aerobic + V_anoxic + V_anaerobic
   */
  var V_total = is_Nit_active ? Result.Nit.V.value : Result.BOD.V.value; //aerobic m3
  if(is_Des_active){ V_total += Result.Des.V_nox.value } //anoxic m3
  if(is_BiP_active){ V_total += Result.BiP.V.value } //anaerobic m3

  //Qwas: lcorominas equation wastage flowrate
  //Qe: lcorominas equation Q(effluent) flowrate
  //sTKNe (used only in TKN effluent)
  var Qwas = (V_total*MLSS_X_TSS/SRT - Q*TSSe)/(X_R - TSSe); //m3/d
  var Qe = Q - Qwas; //m3/d
  var sTKNe = Qe*(Ne + nbsON); //g/d

  var SOTR = is_Des_active ? Result.Des.SOTR.value : (is_Nit_active ? Result.Nit.SOTR.value : Result.BOD.SOTR.value);
  var SAE  = 4; //kgO2/kWh TBD

  var P_X_TSS = is_BiP_active ? Result.BiP.P_X_TSS.value : (is_Nit_active ? Result.Nit.P_X_TSS.value : Result.BOD.P_X_TSS.value); 

  //manually add equations from lcorominas pdf to Result
  Result.summary={
    'V_total': {value:V_total,  unit:"m3",        descr:"Total reactor volume"},
    'Qwas':    {value:Qwas,     unit:"m3/d",      descr:"Wastage flow"},
    'SRT':     {value:SRT,      unit:"d",         descr:getInputById('SRT').descr},
    'SAE':     {value:SAE,      unit:"kg_O2/kWh", descr:"Conversion from kgO2 to kWh"},
    'O2_power':{value:SOTR/SAE, unit:"kW",        descr:"Power needed for aeration (=SOTR/SAE)"},
    'P_X_TSS': {value:P_X_TSS,  unit:"kg/d",      descr:"Total sludge produced per day"},
  };
  addResults('summary',Result.summary);

  /**
    * OUTPUTS by phase (water, air, sludge)
    *
    ***********************************************************************************************
    * IMPORTANT: ALL OUTPUTS MUST BE IN [G/D]: THEY ARE CONVERTED TO [KG/D] OR [G/M3] IN FRONTEND *
    ***********************************************************************************************
    *
    * | TECHNOLOGY         | IN/ACTIVE var | RESULTS OBJECT |
    * |--------------------+---------------+----------------|
    * | fractionation      | N/A           | Result.Fra     |
    * | bod removal        | is_BOD_active | Result.BOD     |
    * | nitrification      | is_Nit_active | Result.Nit     |
    * | sst sizing         | N/A           | Result.SST     |
    * | denitrification    | is_Des_active | Result.Des     |
    * | bio P removal      | is_BiP_active | Result.BiP     |
    * | chemical P removal | is_ChP_active | Result.ChP     |
    * | metals             | N/A           | Result.Met     |
  ***/

  //Outputs.COD
  Outputs.COD.influent       = Q*COD;
  Outputs.COD.effluent.water = sCODe + Qe*VSSe*1.42;
  Outputs.COD.effluent.air   = (function(){
    /*
     * CARBONACEOUS DEMAND
     */
    //this expression (from aeration paper lcorominas found) makes mass balance close
    //return Q*(1-YH)*(S0-S) + Q*YH*(S0-S)*bHT*SRT/(1+bHT*SRT)*(1-fd) - 4.49*NOx;
    // COD equations for carbonaceous demand to be revised
    //
    // | technology       | error  |
    // |------------------+--------|
    // | denitrification  | 5.88%  |
    // | nitrification    | 5.89%  |
    // | bod removal only | 10.32% |
    //debug info
    //console.log("CARBONACEOUS DEMAND DISCUSSION");
    var Oxygen_credit = 2.86*Q*(NOx-NO3_eff);
    //console.log("  O2 credit: "+Oxygen_credit/1000+" kg/d");
    var QNOx457 = 4.57*Q*NOx;
    //console.log("  4.57·Q·NOx: "+QNOx457/1000+" kg/d");
    //in all 3 equations: P_X_bio = Q*YH*(S0-S)/(1+bHT*SRT) + fd*bHT*Q*YH*(S0-S)*SRT/(1+bHT*SRT)
    if(is_Des_active){
      return Result.Des.OTRf.value*24*1000 - 4.57*Q*NOx + 2.86*Q*(NOx-NO3_eff); //from kg/h to g/d
      //  OTRf          = Q*(S0-S) - 1.42*P_X_bio + 4.57*Q*NOx - Oxygen_credit;
      //  Oxygen_credit = 2.86*Q*(NOx-Ne);
    }else if(is_Nit_active){
      return Result.Nit.OTRf.value*24*1000 - 4.57*Q*NOx; //from kg/h to g/d
      //  OTRf          = Q*(S0-S) - 1.42*P_X_bio + 4.57*Q*NOx
    }else if(is_BOD_active){
      return Result.BOD.OTRf.value*24*1000; //from kg/h to g/d
      //  OTRf          = Q*(S0-S) - 1.42*P_X_bio
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
  Outputs.CH4.influent       = 0;
  Outputs.CH4.effluent.water = 0;
  Outputs.CH4.air            = (function(){
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
  Outputs.NOx.influent       = 0;
  Outputs.NOx.effluent.water = (function(){
    if     (is_Nit_active==false){return 0;}
    else if(is_Des_active){       return Qe*NO3_eff;}
    else if(is_Des_active==false){return Q*bTKN - Qe*Ne - 0.12*P_X_bio*1000;}
  })();
  Outputs.NOx.effluent.air = (function(){return 0})();
  Outputs.NOx.effluent.sludge = (function(){
    if     (is_Nit_active==false){return 0;}
    else if(is_Des_active){       return Qwas*NO3_eff;}
    else if(is_Des_active==false){return Qwas*NOx;}
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

  //Outputs METALS
  Outputs.Ag.influent=Q*Ag;Outputs.Ag.effluent.water=Q*Result.Met.Ag_water.value;Outputs.Ag.effluent.sludge=Q*Result.Met.Ag_sludge.value;
  Outputs.Al.influent=Q*Al;Outputs.Al.effluent.water=Q*Result.Met.Al_water.value;Outputs.Al.effluent.sludge=Q*Result.Met.Al_sludge.value;
  Outputs.As.influent=Q*As;Outputs.As.effluent.water=Q*Result.Met.As_water.value;Outputs.As.effluent.sludge=Q*Result.Met.As_sludge.value;
  Outputs.Ba.influent=Q*Ba;Outputs.Ba.effluent.water=Q*Result.Met.Ba_water.value;Outputs.Ba.effluent.sludge=Q*Result.Met.Ba_sludge.value;
  Outputs.Be.influent=Q*Be;Outputs.Be.effluent.water=Q*Result.Met.Be_water.value;Outputs.Be.effluent.sludge=Q*Result.Met.Be_sludge.value;
  Outputs.Br.influent=Q*Br;Outputs.Br.effluent.water=Q*Result.Met.Br_water.value;Outputs.Br.effluent.sludge=Q*Result.Met.Br_sludge.value;
  Outputs.Ca.influent=Q*Ca;Outputs.Ca.effluent.water=Q*Result.Met.Ca_water.value;Outputs.Ca.effluent.sludge=Q*Result.Met.Ca_sludge.value;
  Outputs.Cd.influent=Q*Cd;Outputs.Cd.effluent.water=Q*Result.Met.Cd_water.value;Outputs.Cd.effluent.sludge=Q*Result.Met.Cd_sludge.value;
  Outputs.Cl.influent=Q*Cl;Outputs.Cl.effluent.water=Q*Result.Met.Cl_water.value;Outputs.Cl.effluent.sludge=Q*Result.Met.Cl_sludge.value;
  Outputs.Co.influent=Q*Co;Outputs.Co.effluent.water=Q*Result.Met.Co_water.value;Outputs.Co.effluent.sludge=Q*Result.Met.Co_sludge.value;
  Outputs.Cr.influent=Q*Cr;Outputs.Cr.effluent.water=Q*Result.Met.Cr_water.value;Outputs.Cr.effluent.sludge=Q*Result.Met.Cr_sludge.value;
  Outputs.Cu.influent=Q*Cu;Outputs.Cu.effluent.water=Q*Result.Met.Cu_water.value;Outputs.Cu.effluent.sludge=Q*Result.Met.Cu_sludge.value;
  Outputs.Fe.influent=Q*Fe;Outputs.Fe.effluent.water=Q*Result.Met.Fe_water.value;Outputs.Fe.effluent.sludge=Q*Result.Met.Fe_sludge.value;
  Outputs.Hg.influent=Q*Hg;Outputs.Hg.effluent.water=Q*Result.Met.Hg_water.value;Outputs.Hg.effluent.sludge=Q*Result.Met.Hg_sludge.value;
  Outputs.Mg.influent=Q*Mg;Outputs.Mg.effluent.water=Q*Result.Met.Mg_water.value;Outputs.Mg.effluent.sludge=Q*Result.Met.Mg_sludge.value;
  Outputs.Mn.influent=Q*Mn;Outputs.Mn.effluent.water=Q*Result.Met.Mn_water.value;Outputs.Mn.effluent.sludge=Q*Result.Met.Mn_sludge.value;
  Outputs.Mo.influent=Q*Mo;Outputs.Mo.effluent.water=Q*Result.Met.Mo_water.value;Outputs.Mo.effluent.sludge=Q*Result.Met.Mo_sludge.value;
  Outputs.Na.influent=Q*Na;Outputs.Na.effluent.water=Q*Result.Met.Na_water.value;Outputs.Na.effluent.sludge=Q*Result.Met.Na_sludge.value;
  Outputs.Ni.influent=Q*Ni;Outputs.Ni.effluent.water=Q*Result.Met.Ni_water.value;Outputs.Ni.effluent.sludge=Q*Result.Met.Ni_sludge.value;
  Outputs.Pb.influent=Q*Pb;Outputs.Pb.effluent.water=Q*Result.Met.Pb_water.value;Outputs.Pb.effluent.sludge=Q*Result.Met.Pb_sludge.value;
  Outputs.Sb.influent=Q*Sb;Outputs.Sb.effluent.water=Q*Result.Met.Sb_water.value;Outputs.Sb.effluent.sludge=Q*Result.Met.Sb_sludge.value;
  Outputs.Sc.influent=Q*Sc;Outputs.Sc.effluent.water=Q*Result.Met.Sc_water.value;Outputs.Sc.effluent.sludge=Q*Result.Met.Sc_sludge.value;
  Outputs.Se.influent=Q*Se;Outputs.Se.effluent.water=Q*Result.Met.Se_water.value;Outputs.Se.effluent.sludge=Q*Result.Met.Se_sludge.value;
  Outputs.Si.influent=Q*Si;Outputs.Si.effluent.water=Q*Result.Met.Si_water.value;Outputs.Si.effluent.sludge=Q*Result.Met.Si_sludge.value;
  Outputs.Sn.influent=Q*Sn;Outputs.Sn.effluent.water=Q*Result.Met.Sn_water.value;Outputs.Sn.effluent.sludge=Q*Result.Met.Sn_sludge.value;
  Outputs.Sr.influent=Q*Sr;Outputs.Sr.effluent.water=Q*Result.Met.Sr_water.value;Outputs.Sr.effluent.sludge=Q*Result.Met.Sr_sludge.value;
  Outputs.Ti.influent=Q*Ti;Outputs.Ti.effluent.water=Q*Result.Met.Ti_water.value;Outputs.Ti.effluent.sludge=Q*Result.Met.Ti_sludge.value;
  Outputs.Tl.influent=Q*Tl;Outputs.Tl.effluent.water=Q*Result.Met.Tl_water.value;Outputs.Tl.effluent.sludge=Q*Result.Met.Tl_sludge.value;
  Outputs.Zn.influent=Q*Zn;Outputs.Zn.effluent.water=Q*Result.Met.Zn_water.value;Outputs.Zn.effluent.sludge=Q*Result.Met.Zn_sludge.value;

  Outputs.B.influent=Q*B; Outputs.B.effluent.water=Q*Result.Met.B_water.value; Outputs.B.effluent.sludge=Q*Result.Met.B_sludge.value;
  Outputs.F.influent=Q*F; Outputs.F.effluent.water=Q*Result.Met.F_water.value; Outputs.F.effluent.sludge=Q*Result.Met.F_sludge.value;
  Outputs.I.influent=Q*I; Outputs.I.effluent.water=Q*Result.Met.I_water.value; Outputs.I.effluent.sludge=Q*Result.Met.I_sludge.value;
  Outputs.K.influent=Q*K; Outputs.K.effluent.water=Q*Result.Met.K_water.value; Outputs.K.effluent.sludge=Q*Result.Met.K_sludge.value;
  Outputs.V.influent=Q*V; Outputs.V.effluent.water=Q*Result.Met.V_water.value; Outputs.V.effluent.sludge=Q*Result.Met.V_sludge.value;
  Outputs.W.influent=Q*W; Outputs.W.effluent.water=Q*Result.Met.W_water.value; Outputs.W.effluent.sludge=Q*Result.Met.W_sludge.value;
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

  /*utilities*/
  //fx: utility to add a technology result to the Variables object
  function addResults(tech,result){
    /*inputs:
      tech: string representing a technology
      result: object returned from a technology
    */
    for(var res in result){
      var value = result[res].value;
      var unit  = result[res].unit;
      var descr = result[res].descr;

      //if a variable with the same id and unit already exists replace it
      var candidates=Variables.filter(v=>{return (v.id==res && v.unit==unit)});
      if(candidates.length){
        candidates.forEach(c=>{
          var index=Variables.indexOf(c);
          Variables.splice(index,1);
        });
      }

      //add a new variable object to "Variables"
      Variables.push({id:res,value,unit,descr,tech});
    }
  }

  return Result;
}

/*
 * Auxiliar Data Structures
 */
//[]: for storing input ids (strings) that have equations in lcorominas pdf equations
var Inputs_to_be_hidden=[]; //declared here to be visible by frontend

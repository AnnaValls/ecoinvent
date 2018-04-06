/**
  *
  * Main backend function (table 3.1)
  *
*/
function compute_elementary_flows(Input_set){
  //process-inputs
    var is=Input_set; //shorten name

    //technologies activated
      var is_Pri_active = is.is_Pri_active;
      var is_BOD_active = is.is_BOD_active;
      var is_Nit_active = is.is_Nit_active;
      var is_Des_active = is.is_Des_active;
      var is_BiP_active = is.is_BiP_active;
      var is_ChP_active = is.is_ChP_active;
      var is_Met_active = is.is_Met_active;

    //ww characteristics
      var Q          = is.Q;
      var T          = is.T;
      var BOD        = is.BOD;
      var sBOD       = is.sBOD;
      var COD        = is.COD;
      var sCOD       = is.sCOD;
      var bCOD       = is.bCOD;
      var rbCOD      = is.rbCOD;
      var VFA        = is.VFA;
      var TSS        = is.TSS;
      var VSS        = is.VSS;
      var TKN        = is.TKN;
      var NH4        = is.NH4;
      var TP         = is.TP;
      var PO4        = is.PO4;
      var Alkalinity = is.Alkalinity;

    //influent metals are picked when 'metals_doka' is called

    //design parameters
      var CSO_particulate      = is.CSO_particulate;
      var CSO_soluble          = is.CSO_soluble;
      var removal_bpCOD        = is.removal_bpCOD;
      var removal_nbpCOD       = is.removal_nbpCOD;
      var removal_iTSS         = is.removal_iTSS;
      var removal_ON           = is.removal_ON;
      var removal_OP           = is.removal_OP;
      var SRT                  = is.SRT;
      var MLSS_X_TSS           = is.MLSS_X_TSS;
      var zb                   = is.zb;
      var Pressure             = is.Pressure;
      var Df                   = is.Df;
      var h_settler            = is.h_settler;
      var DO                   = is.DO;
      var SF                   = is.SF;
      var NH4_eff              = is.NH4_eff;
      var sBODe                = is.sBODe;
      var TSSe                 = is.TSSe;
      var Anoxic_mixing_energy = is.Anoxic_mixing_energy;
      var NO3_eff              = is.NO3_eff;
      var SOR                  = is.SOR;
      var X_R                  = is.X_R;
      var clarifiers           = is.clarifiers;
      var PO4_eff              = is.PO4_eff;
      var FeCl3_solution       = is.FeCl3_solution;
      var FeCl3_unit_weight    = is.FeCl3_unit_weight;
      var days                 = is.days;
      var influent_H           = is.influent_H;
  //end-process-inputs

  //make that effluent designed cannot be higher than influent observed concentrations
  NH4_eff = Math.min(NH4_eff, TKN);
  NO3_eff = Math.min(NO3_eff, TKN);
  PO4_eff = Math.min(PO4_eff, TP);

  //reset Variables object
  Variables=[];
  /*
    new empty object to store each technology results
      + "other" (for some values not related to any tech)
      + "summary" (for selected variables results oriented)
  */
  var Result={Fra:{},Pri:{},BOD:{},Nit:{},SST:{},Des:{},BiP:{},ChP:{},Met:{},other:{},summary:{}};

  /*APPLY TECHNOLOGIES + lcorominas equations*/

  /*0. SOLVE FRACTIONATION AND PRIMARY SETTLER */

  //fractionation of raw wastewater (before CSO and primary settler)
  Result.Fra=fractionation(BOD,sBOD,COD,bCOD,sCOD,rbCOD,TSS,VSS,TKN,NH4,NH4_eff,TP,PO4);

  //apply CSO discharge
  (function(){
    //inputs for cso: fractionation, metals and CSO removal rates (particulate and soluble)
    (function(){
      Result.CSO=cso_removal(Result.Fra, is, CSO_particulate, CSO_soluble);
      addResults('CSO',Result.CSO);
    })();

    //update inputs
    BOD   = Result.Fra.BOD.value;
    sBOD  = Result.Fra.sBOD.value;
    COD   = Result.Fra.COD.value;
    sCOD  = Result.Fra.sCOD.value;
    bCOD  = Result.Fra.bCOD.value;
    rbCOD = Result.Fra.rbCOD.value;
    TSS   = Result.Fra.TSS.value;
    VSS   = Result.Fra.VSS.value;
    TKN   = Result.Fra.TKN.value;
    NH4   = Result.Fra.NH4.value;
    TP    = Result.Fra.TP.value;
    PO4   = Result.Fra.PO4.value;
    //recalculate fractionation
    Result.Fra=fractionation(BOD,sBOD,COD,bCOD,sCOD,rbCOD,TSS,VSS,TKN,NH4,NH4_eff,TP,PO4);
  })();

  //apply primary settler + fractionation again
  if(is_Pri_active){
    //get pCOD fractions from first fractionation
    var bpCOD          = Result.Fra.bpCOD.value;  //g/m3
    var nbpCOD         = Result.Fra.nbpCOD.value; //g/m3
    var pCOD           = Result.Fra.pCOD.value;   //g/m3
    var iTSS           = Result.Fra.iTSS.value;   //g/m3
    var ON             = Result.Fra.ON.value;     //g/m3
    var OP             = Result.Fra.OP.value;     //g/m3
    var bCOD_BOD_ratio = Result.Fra.bCOD_BOD_ratio.value; //g/g
    var VSS_COD        = Result.Fra.VSS_COD.value; //g_pCOD/g_VSS

    //apply primary settler    ----pCOD---- ------removal-rates-----
    Result.Pri=primary_settler(Q,bpCOD,nbpCOD,iTSS,ON,OP,VSS_COD,removal_bpCOD,removal_nbpCOD,removal_iTSS,removal_ON,removal_OP);
    addResults('Pri',Result.Pri);

    //get removed amounts (g/m3)
    var bpCOD_removed  = Result.Pri.bpCOD_removed.value;  //g/m3
    var nbpCOD_removed = Result.Pri.nbpCOD_removed.value; //g/m3
    var pCOD_removed   = Result.Pri.pCOD_removed.value;   //g/m3
    var iTSS_removed   = Result.Pri.iTSS_removed.value;   //g/m3
    var ON_removed     = Result.Pri.ON_removed.value;     //g/m3
    var OP_removed     = Result.Pri.OP_removed.value;     //g/m3

    //modify inputs to recalculate fractionation
    bCOD -= bpCOD_removed;
    COD  -= (bpCOD_removed + nbpCOD_removed);
    pCOD -= pCOD_removed;
    iTSS -= iTSS_removed;
    TKN  -= ON_removed;
    TP   -= OP_removed;

    //adjust BOD, VSS and TSS again
    BOD = bCOD_BOD_ratio==0 ? 0 : bCOD/bCOD_BOD_ratio;
    VSS = VSS_COD==0        ? 0 : pCOD/VSS_COD;
    TSS = VSS + iTSS;

    //RECALCULATE FRACTIONATION
    Result.Fra=fractionation(BOD,sBOD,COD,bCOD,sCOD,rbCOD,TSS,VSS,TKN,NH4,NH4_eff,TP,PO4)
  }else{
    //call it just to see "0 g/m3 removed"
    //         primary_settler(Q,bpCOD,nbpCOD,iTSS,ON,OP,VSS_COD,removal_bpCOD,removal_nbpCOD,removal_iTSS,removal_ON,removal_OP);
    Result.Pri=primary_settler(0,    0,     0,   0, 0, 0,      0,            0,             0,           0,         0,         0);
    addResults('Pri',Result.Pri);
  }

  //exception regarding TKN_N2O
  if(is_Nit_active==false){ Result.Fra.TKN_N2O.value=0; }

  addResults('Fra',Result.Fra);

  //get fractionated values
  var bCOD_BOD_ratio = Result.Fra.bCOD_BOD_ratio.value; //g/g
  var nbCOD          = Result.Fra.nbCOD.value;   //g/m3
  var pCOD           = Result.Fra.pCOD.value;    //g/m3
  var bsCOD          = Result.Fra.bsCOD.value;   //g/m3
  var nbsCODe        = Result.Fra.nbsCODe.value; //g/m3
  var bpCOD          = Result.Fra.bpCOD.value;   //g/m3
  var nbpCOD         = Result.Fra.nbpCOD.value;  //g/m3
  var VSS_COD        = Result.Fra.VSS_COD.value; //g_pCOD/g_VSS
  var nbVSS          = Result.Fra.nbVSS.value;   //g/m3
  var iTSS           = Result.Fra.iTSS.value;    //g/m3
  var nbpON          = Result.Fra.nbpON.value;   //g/m3
  var nbsON          = Result.Fra.nbsON.value;   //g/m3
  var TKN_N2O        = Result.Fra.TKN_N2O.value; //g/m3
  var bTKN           = Result.Fra.bTKN.value;    //g/m3
  var sTKNe          = Result.Fra.sTKNe.value;   //g/m3 | sTKNe = NH4_eff + nbsON | only used in TKN effluent sludge
  var nbpOP          = Result.Fra.nbpOP.value;   //g/m3
  var aP             = Result.Fra.aP.value;      //g/m3 | aP = TP - nbpOP         | only used to compute aPchem

  //bod removal has to be always active. If not: do nothing
  if(is_BOD_active==false){
    console.log('BOD REMOVAL IS INACTIVE: nothing will be calculated');
    return Result;
  }

  /*1. SOLVE BOD REMOVAL*/
  Result.BOD=bod_removal_only(BOD,nbVSS,TSS,VSS,bCOD_BOD_ratio,Q,T,SRT,MLSS_X_TSS,zb,Pressure,Df,DO);
  addResults('BOD',Result.BOD);

  //get variables for lcorominas pdf equations block 1
  var bHT = Result.BOD.bHT.value;     //1/d
  var S0  = bCOD;                     //g/m3

  /*2. SOLVE NITRIFICATION*/
  if(is_Nit_active){
    //to correct NOx and P_X_bio from Metcalf use bTKN instead of TKN
    //         nitrification(--------------------------------------TKN----------------------------------------------------------)
    Result.Nit=nitrification(BOD,bCOD_BOD_ratio,nbVSS,TSS,VSS,Q,T,bTKN,SF,zb,Pressure,Df,MLSS_X_TSS,NH4_eff,sBODe,TSSe,Alkalinity,DO);
    addResults('Nit',Result.Nit);
  }

  //get variables after nitrification for equations block 2
  var S       = is_Nit_active ? Result.Nit.S.value       : Result.BOD.S.value;       //g/m3
  var NOx     = is_Nit_active ? Result.Nit.NOx.value     : 0;                        //g/m3

  //get SRT from Nit results if Nit is active
  if(is_Nit_active){
    SRT=Result.Nit.SRT_design.value;//d
  }

  /*3. SOLVE SST*/
  Result.SST=sst_sizing(Q,SOR,X_R,clarifiers,MLSS_X_TSS);
  addResults('SST',Result.SST);

  var RAS = Result.SST.RAS.value; //0.6 unitless

  /*4. SOLVE DENITRIFICATION*/
  if(is_Nit_active && is_Des_active){
    var MLVSS                 = Result.Nit.MLVSS.value;      //2370 g/m3
    var Aerobic_SRT           = Result.Nit.SRT_design.value; //21 d
    var Aeration_basin_volume = Result.Nit.V_aer.value;      //13410 m3
    var Aerobic_T             = Result.Nit.tau.value;        //14.2 h
    var R0                    = Result.Nit.OTRf.value;       //275.9 kg O2/h
    Result.Des=N_removal(Q,T,BOD,bCOD,rbCOD,NOx,Alkalinity,MLVSS,Aerobic_SRT,Aeration_basin_volume,Aerobic_T,Anoxic_mixing_energy,RAS,R0,NO3_eff,Df,zb,DO,Pressure);
    addResults('Des',Result.Des);
  }
  var IR = is_Des_active ? Result.Des.IR.value : 0;

  /*5. SOLVE BIO P*/
  if(is_BiP_active){
    var tau_aer = 0.75; //h -- "tau must be between 0.50 and 1.00 h (M&EA)"

    Result.BiP=bio_P_removal(Q,bCOD,rbCOD,VFA,nbVSS,iTSS,aP,T,SRT,NOx,NO3_eff,tau_aer,RAS);
  //Result.BiP=bio_P_removal(Q,bCOD,rbCOD,VFA,nbVSS,iTSS,TP      ,T,SRT,NOx,NO3_eff,tau_aer,RAS);

    addResults('BiP',Result.BiP);
  }

  /*5. SOLVE CHEM P*/
  if(is_ChP_active){
  //Result.ChP=chem_P_removal(Q,TSS,TP,PO4,PO4_eff,FeCl3_solution,FeCl3_unit_weight,days);
    Result.ChP=chem_P_removal(Q,TSS,TP,aP ,PO4_eff,FeCl3_solution,FeCl3_unit_weight,days);
    addResults('ChP',Result.ChP);
  }
  //===END TECHNOLOGIES FROM METCALF AND EDDY=============================================

  /*6. Metals (from G. Doka excel tool)*/
  if(is_Met_active){
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
    Result.Met=metals_doka(Ag,Al,As,B,Ba,Be,Br,Ca,Cd,Cl,Co,Cr,Cu,F,Fe,Hg,I,K,Mg,Mn,Mo,Na,Ni,Pb,Sb,Sc,Se,Si,Sn,Sr,Ti,Tl,V,W,Zn);
    addResults('Met',Result.Met);
  }

  /*ADDITIONAL VARIABLES "other"*/
  /**
    * Calc total reactor volume (m3):
    * V_total = V_aerobic + V_anoxic + V_anaerobic
    */
  var V_aer   = select_value('V_aer',['Nit','BOD']);
  var V_nox   = select_value('V_nox',['Des']);
  var V_ana   = select_value('V_ana',['BiP']);
  var V_total = V_aer + V_nox + V_ana;

  //Qwas equation wastage flowrate
  var Qwas = (V_total*MLSS_X_TSS/SRT - Q*TSSe)/(X_R - TSSe) ||0; //m3/d
  Qwas = isFinite(Qwas) ? Qwas : 0; //avoid infinite
  var Qe = Q - Qwas; //m3/d

  //VSSe and sCODe
  var VSSe  = Math.min(COD, TSSe*0.85); //g/m3
  var sCODe = nbsCODe+S; //g/m3 (used only in COD effluent (water and sludge))

  var tau                       = select_value('tau',                       ['Des','Nit','BOD']);
  var MLVSS                     = select_value('MLVSS',                     ['Nit','BOD']);
  //var BOD_loading               = select_value('BOD_loading',               ['Nit','BOD']);
  var TSS_removed_kgd           = select_value('TSS_removed_kgd',           ['Pri']);

  var P_X_bio                   = select_value('P_X_bio',                   ['BiP','Nit','BOD']);
  var P_X_VSS                   = select_value('P_X_VSS',                   ['BiP','Nit','BOD']);
  var P_X_TSS                   = select_value('P_X_TSS',                   ['BiP','Nit','BOD']);

  var Y_obs_TSS                 = select_value('Y_obs_TSS',                 ['Nit','BOD'])
  var Y_obs_VSS                 = select_value('Y_obs_VSS',                 ['Nit','BOD'])
  var air_flowrate              = select_value('air_flowrate',              ['Des','Nit','BOD']);
  var OTRf                      = select_value('OTRf',                      ['Des','Nit','BOD']);
  var SOTR                      = select_value('SOTR',                      ['Des','Nit','BOD']);
  var SDNR                      = select_value('SDNR',                      ['Des']);
  var clarifier_diameter        = select_value('clarifier_diameter',        ['SST']);
  var alkalinity_added          = select_value('alkalinity_added',          ['Nit']);
  var Mass_of_alkalinity_needed = select_value('Mass_of_alkalinity_needed', ['Des']);
  var FeCl3_volume              = select_value('FeCl3_volume',              ['ChP']);
  var storage_req_15_d          = select_value('storage_req_15_d',          ['ChP']);

  //lcorominas - aPchem
  var P_synth = 0.015*P_X_bio*1000/Q || 0; //g/m3
  var aPchem  = aP - P_synth;              //g/m3

  /*recalculate PO4_eff*/
  if(is_BiP_active) {
    //if Bio P removal: calculated
    PO4_eff = Result.BiP.Effluent_P.value;
  }
  else if(is_ChP_active) {
    //if Chem P removal: imposed in design
    PO4_eff = PO4_eff; //"do nothing"
  }
  else {
    //if NO P removal: calculated as PO4_eff = aP - P_synth
    PO4_eff = aP - P_synth; //g/m3
  }

  //Pack all calculations outside technologies
  Result.other={
    //things calculated out of technologies
    "PO4_eff": {value:PO4_eff, unit:"g/m3_as_P", descr:"Effluent PO4"},
    'V_total': {value:V_total, unit:"m3",        descr:"Total reactor volume (aerobic+anoxic+anaerobic)"},
    'Qwas':    {value:Qwas,    unit:"m3/d",      descr:"Wastage flow"},
    'Qe':      {value:Qe,      unit:"m3/d",      descr:"Qe = Q - Qwas"},
    'VSSe':    {value:VSSe,    unit:"g/m3",      descr:"Volatile Suspended Solids at effluent"},

    //useful values to see
    'COD_in_VSSe__(1.42)':  {value:VSSe*1.42,     unit:"g_O2/m3", descr:"content of COD in VSSe    (1.42  gO2/gVSSe)"},
    'N___in_VSSe__(0.12)':  {value:VSSe*0.12,     unit:"g_N/m3",  descr:"content of N   in VSSe    (0.12  gN/gVSSe)"},
    'P___in_VSSe__(0.015)': {value:VSSe*0.015,    unit:"g_P/m3",  descr:"content of P   in VSSe    (0.12  gP/gVSSe"},
    'COD_in_PXbio_(1.42)':  {value:P_X_bio*1.42,  unit:"kg_O2/d", descr:"content of COD in biomass (1.42  gO2/gX)"},
    'N___in_PXbio_(0.12)':  {value:P_X_bio*0.12,  unit:"kg_N/d",  descr:"content of N   in biomass (0.12  gN/gX)"},
    'P___in_PXbio_(0.015)': {value:P_X_bio*0.015, unit:"kg_P/d",  descr:"content of P   in biomass (0.015 gP/gX)"},

    //other
    'sCODe':   {value:sCODe,   unit:"g/m3", descr:"Soluble COD at effluent"},
    'aP':      {value:aP,      unit:"g/m3", descr:"Available P (=PO4 + bOP)"},
    'P_synth': {value:P_synth, unit:"g/m3", descr:"P used for biomass synthesis"},
    'aPchem':  {value:aPchem,  unit:"g/m3", descr:"Available P - P_synth"},
  };
  addResults('other',Result.other);

  /*ENERGY*/
  //energy related variables (could go inside a new Result.energy object)
  //TODO: pack these equations into a new technology file

  //1. AERATION power
  var SAE            = 4;            //kgO2/kWh (taken from Oliver Schraa's aeration book)
  var aeration_power = OTRf/SAE ||0; //kW

  //2. MIXING power (anoxic, denitrification)
  var mixing_power = select_value('Power',['Des']); //kW

  //3. PUMPING power
  var PE_Qr   = 0.008; //kWh/m3 -- external recirculation factor
  var PE_Qint = 0.004; //kWh/m3 -- internal recirculation (anoxic, denitri) factor
  var PE_Qw   = 0.050; //kWh/m3 -- wastage factor
  var Pumping = {
    external: Q*RAS*PE_Qr,  //kWh/d
    internal: Q*IR*PE_Qint, //kWh/d
    wastage : Qwas*PE_Qw,   //kWh/d
    influent:function(){
      var rho = 1000;       //kg/m3 (density)
      var H   = influent_H; //m     (head)
      return rho*g*Q*H/1000/(24*3600); //kW -- divided by 1000 to have kW (from W) and m3/d converted to m3/s
      /*
        Influent pumping power P = rho.g.Q.H where (P in in Watts)
        rho is density of water = 1000 kg/m^3
        g = gravitation constant = 9.81 m/s^2
        Q is flow in m^3/s
        H is water lift height and friction head in m.
        You can use a standard lift height of 10 m.
        User can change it if they have a better height.
        With Archimedian screw pumps I think the friction head
        is probably about 10% of the static head.
        P excludes losses in gear box and electrical
        inefficiency. So for electrical power consumption
        these losses increase the power consumption.
        Archimedian screw pumps draw power proportional to the flux of water
        lifted, i.e draw low power at low flow and high power at high flow. This means
        you can use the average dry wearther flow as the kWh/d because the power
        balanaces out over a 24h day.
      */
    },//kW
  };
  var pumping_power_influent = Pumping.influent();  //kW
  var pumping_power_external = Pumping.external/24; //kW
  var pumping_power_internal = Pumping.internal/24; //kW
  var pumping_power_wastage  = Pumping.wastage/24;  //kW
  var pumping_power = pumping_power_influent + pumping_power_external + pumping_power_internal + pumping_power_wastage;

  //4. DEWATERING power
  var dewatering_factor = 20;                                //kWh/tDM (tone dry matter)
  var dewatering_power  = P_X_TSS/1000*dewatering_factor/24; //kW

  //5. OTHER power: regression equations from lcorominas
  var other_power = (function(){
    if(is_Pri_active){
      return 0.0124*Q + 337.77; //kWh/d
    }else{
      return 0.0165*Q + 337.59; //kWh/d
    }
  })()/24; //converted to kW dividing by 24

  //6. TOTAL power
  var total_power = aeration_power + mixing_power + pumping_power + dewatering_power + other_power;

  Result.energy={
    'SAE':                     {value:SAE,                     unit:"kg_O2/kWh",  descr:"kg O2 that can be aerated with 1 kWh of energy"},
    'aeration_power':          {value:aeration_power,          unit:"kW",         descr:"Power needed for aeration (=OTRf/SAE)"},
    'mixing_power':            {value:mixing_power,            unit:"kW",         descr:"Power needed for anoxic mixing"},
    'pumping_power_influent':  {value:pumping_power_influent,  unit:"kW",         descr:"Power needed for pumping influent"},
    'pumping_power_external':  {value:pumping_power_external,  unit:"kW",         descr:"Power needed for pumping (external recirculation)"},
    'pumping_power_internal':  {value:pumping_power_internal,  unit:"kW",         descr:"Power needed for pumping (internal recirculation)"},
    'pumping_power_wastage':   {value:pumping_power_wastage,   unit:"kW",         descr:"Power needed for pumping (wastage recirculation)"},
    'pumping_power':           {value:pumping_power,           unit:"kW",         descr:"Power needed for pumping (ext+int+was)"},
    'dewatering_power':        {value:dewatering_power,        unit:"kW",         descr:"Power needed for dewatering"},
    'other_power':             {value:other_power,             unit:"kW",         descr:"Power needed for 'other' (20% of total)"},
    'total_power':             {value:total_power,             unit:"kW",         descr:"Total power needed"},
    'total_daily_energy':      {value:total_power*24,          unit:"kWh/d",      descr:"Total daily energy needed"},
    'total_energy_per_m3':     {value:total_power*24/Q||0,     unit:"kWh/m3",     descr:"Total energy needed per m3"},
  };
  addResults('energy',Result.energy);

  /*Variables needed for SUMMARY TABLE*/

  /*polymer for dewatering (chemical)*/
  var Dewatering_polymer = 0.01*P_X_TSS; //kg polymer/d -- (0.01 is kg polymer/kg sludge)

  /*CONCRETE*/
  var Concrete={
    density:3, //t/m3
    reactor:function(volume,h,w,ww,wg){
      h=h   ||7;   //m -- depth of tank
      w=w   ||9;   //m -- width of tank
      ww=ww ||0.3; //m -- width of wall
      wg=wg ||0.5; //m -- width of basement plate
      return this.density*(
        2*(volume/(h*w) + w)*h*ww + volume/(h*w)*w*wg
      ); //m3 concrete
    },
    settler:function(volume,h,w,ww,wg){
      h=h   ||4;     //m  -- depth of tank
      ww=ww ||0.3;   //m  -- width of wall
      wg=wg ||0.5;   //m  -- width of basement plate
      return this.density*(
        2*Math.PI*Math.sqrt(volume/(Math.PI*h))*h*ww + volume/h*wg
      ); //m3 concrete
    },
  };

  //volume of secondary settlers/clarifiers
  var V_settler = h_settler * Result.SST.Area.value;

  /*Sludge elementary composition [C,H,O,N,S,P] */
  //TODO create a new technology (not activable by the user)
  var Sludge={
    /*
      Dear  Lluis,
      If the COD/VSS (f_CV=1.42), C/VSS (f_C=0.51), N/VSS (f_N=0.12) and P/VSS (f_P=0.015) are known
      then the O/VSS (F_O) And H/VSS (f_H) can be calcylated with che following equations:

      f_O = 16/18 ( 1- f_CV/8 - 8/12 f_C  – 17/14 f_N – 26/31 f_P)
      f_H = 2/18  ( 1+ f_CV  - 44/12 f_C +  10/14 f_N – 71/31 f_P)

      So for f_CV = 1.42; f_C = 0.51 , f_N=0.12 and f_P = 0.015,
      f_O=0.288 and f_H=0.067.

      We can include S in this but there is no need. There are no S
      transformations taking place in he AS system anyway.
      The elements from Cl down in the table below are inorganics and so should
      not be expressed with respect to the VSS (as in the table).
      They should be calculated as % of the ISS (TSS-VSS) because the make up
      the ash content of the sludge.
      George
    */
    f_CV: 1.42,  //g_COD/g_VSS
    f_C:  0.51,  //g_C  /g_VSS
    f_N:  0.12,  //g_N  /g_VSS
    f_P:  0.015, //g_P  /g_VSS
    f_O:function(){return 16/18*(1 - this.f_CV/8 -  8/12*this.f_C - 17/14*this.f_N - 26/31*this.f_P)}, //g_O/g_VSS
    f_H:function(){return  2/18*(1 + this.f_CV   - 44/12*this.f_C + 10/14*this.f_N - 71/31*this.f_P)}, //g_H/g_VSS
  };

  var sludge_C = Sludge.f_C*P_X_VSS;   //kg_C/d
  var sludge_H = Sludge.f_H()*P_X_VSS; //kg_H/d
  var sludge_O = Sludge.f_O()*P_X_VSS; //kg_O/d
  var sludge_N = Sludge.f_N*P_X_VSS;   //kg_N/d
  var sludge_P = Sludge.f_P*P_X_VSS;   //kg_P/d

  //additional sludge from chemical P removal
  var Excess_sludge_kg = select_value('Excess_sludge_kg', ['ChP']);

  //===============================================================================================
  //OUTPUTS effluent
  (function(){
    /**
      * OUTPUTS by phase (water, air, sludge)
      ***********************************************************************************************
      * IMPORTANT: ALL OUTPUTS MUST BE IN [G/D]: THEY ARE CONVERTED TO [KG/D] OR [G/M3] IN FRONTEND *
      ***********************************************************************************************
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
      */

    //Outputs.COD
    Outputs.COD.influent       = Q*COD;
    Outputs.COD.effluent.water = Qe*sCODe + Qe*VSSe*1.42;
    Outputs.COD.effluent.air   = (function(){
      /* CARBONACEOUS DEMAND */
      //this expression (from aeration paper lcorominas found) makes mass balance close
      //return Q*(1-YH)*(S0-S) + Q*YH*(S0-S)*bHT*SRT/(1+bHT*SRT)*(1-fd) - 4.49*NOx;
      // COD equations for carbonaceous demand to be revised
      //debug info
      //console.log("CARBONACEOUS DEMAND DISCUSSION");
      var Oxygen_credit = 2.86*Q*(NOx-NO3_eff);
      //console.log("  O2 credit: "+Oxygen_credit/1000+" kg/d");
      var QNOx457 = 4.57*Q*NOx;
      //console.log("  4.57·Q·NOx: "+QNOx457/1000+" kg/d");
      //in all 3 equations: P_X_bio = Q*YH*(S0-S)/(1+bHT*SRT) + fd*bHT*Q*YH*(S0-S)*SRT/(1+bHT*SRT)
      if(is_Des_active){
        return Result.Des.OTRf.value*24*1000 - 4.57*Q*NOx + 2.86*Q*(NOx-NO3_eff); //from kg/h to g/d
        // OTRf          = Q*(S0-S) - 1.42*P_X_bio + 4.57*Q*NOx - Oxygen_credit;
        // Oxygen_credit = 2.86*Q*(NOx-NH4_eff);
      }else if(is_Nit_active){
        return Result.Nit.OTRf.value*24*1000 - 4.57*Q*NOx; //from kg/h to g/d
        // OTRf          = Q*(S0-S) - 1.42*P_X_bio + 4.57*Q*NOx
      }else if(is_BOD_active){
        return Result.BOD.OTRf.value*24*1000; //from kg/h to g/d
        // OTRf          = Q*(S0-S) - 1.42*P_X_bio
      }
    })();
    Outputs.COD.effluent.sludge = (function(){
      var A = 1.42*P_X_bio*1000; //g O2/d
      var B = 0;//Qwas*sCODe;        //g O2/d
      var C = Q*nbpCOD;          //g O2/d
      var D = Qe*1.42*VSSe;      //g O2/d
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
    Outputs.CH4.effluent.air   = (function(){
      var is_Anaer_treatment = false; //TBD to be added in the future
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
        return Qe*(NH4_eff + VSSe*0.12) + Q*nbsON;
      }else{
        return Q*(TKN - nbpON - TKN_N2O) + Qe*VSSe*0.12 - 0.12*P_X_bio*1000;
      }
    })();
    Outputs.TKN.effluent.air    = 0;
    Outputs.TKN.effluent.sludge = (function(){
      var A = 0.12*P_X_bio*1000;
      var B = 0;//Qwas*sTKNe;
      var C = Q*nbpON;
      var D = Qe*VSSe*0.12;
      return A+B+C-D;
    })();

    //Outputs.NOx
    Outputs.NOx.influent       = 0;
    Outputs.NOx.effluent.water = (function(){
      if     (is_Nit_active==false){return 0;}
      else if(is_Des_active){       return Qe*NO3_eff;}
      else if(is_Des_active==false){return Qe*NOx}
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

    //Outputs.TP //TODO revise with lcorominas
    Outputs.TP.influent = Q*TP;
    Outputs.TP.effluent.water = (function(){
      if(is_BiP_active==false && is_ChP_active==false){ //NO P removal
        return Q*PO4_eff + Qe*VSSe*0.015; //g/d
      }
      else if(is_BiP_active && is_ChP_active==false){   //bio P removal
        //recalculate the 0.015 factor, in bio P removal changes
        var g_P_VSS_new = (Q*PO4-Qe*PO4_eff)/(P_X_VSS*1000); //g_P/g_VSS
        return Qe*PO4_eff + Qe*VSSe*g_P_VSS_new;
      }
      else if(is_BiP_active==false && is_ChP_active){   //chem P removal
        //recalculate the 0.015 factor, in bio P removal changes
        var g_P_VSS_new = (Q*PO4-Qe*PO4_eff)/(P_X_VSS*1000); //g_P/g_VSS
        return Qe*PO4_eff + Qe*VSSe*g_P_VSS_new;
      }
      else{ //both P removals are not seen in practice (G. Ekama)
        return 0;
      }
    })();
    Outputs.TP.effluent.air = 0;
    Outputs.TP.effluent.sludge = (function(){
      var B = 0;//Qwas*PO4_eff;  //g/d
      var C = Q*nbpOP;       //g/d
      var D = Qe*VSSe*0.015; //g/d
      if(is_BiP_active==false && is_ChP_active==false){ //NO P removal
        return 0.015*P_X_bio*1000 + B + C - D; //g/d
      }
      else if(is_BiP_active && is_ChP_active==false){   //bio P removal
        //recalculate the 0.015 factor, in bio P removal changes
        var g_P_VSS_new = (Q*PO4-Qe*PO4_eff)/(P_X_VSS*1000); //g_P/g_VSS "PAO VSS"
        return Q*Result.BiP.P_removal.value + B + C - Qe*VSSe*g_P_VSS_new; 
      }
      else if(is_BiP_active==false && is_ChP_active){  //chem P removal
        //recalculate the 0.015 factor, in bio P removal changes
        var g_P_VSS_new = (Q*PO4-Qe*PO4_eff)/(P_X_VSS*1000); //g_P/g_VSS
        return (0.015*P_X_bio*1000) + Q*(aPchem - PO4_eff) + B + C - Qe*VSSe*g_P_VSS_new; 
      }
      else{ //both P removals are not seen in practice (G. Ekama)
        return 0;
      }
    })();

    //Outputs METALS
    (function(){
    })();
    if(is_Met_active){
      Outputs.Ag.influent=Q*Ag; Outputs.Ag.effluent.water=Q*Result.Met.Ag_water.value; Outputs.Ag.effluent.sludge=Q*Result.Met.Ag_sludge.value;
      Outputs.Al.influent=Q*Al; Outputs.Al.effluent.water=Q*Result.Met.Al_water.value; Outputs.Al.effluent.sludge=Q*Result.Met.Al_sludge.value;
      Outputs.As.influent=Q*As; Outputs.As.effluent.water=Q*Result.Met.As_water.value; Outputs.As.effluent.sludge=Q*Result.Met.As_sludge.value;
      Outputs.Ba.influent=Q*Ba; Outputs.Ba.effluent.water=Q*Result.Met.Ba_water.value; Outputs.Ba.effluent.sludge=Q*Result.Met.Ba_sludge.value;
      Outputs.Be.influent=Q*Be; Outputs.Be.effluent.water=Q*Result.Met.Be_water.value; Outputs.Be.effluent.sludge=Q*Result.Met.Be_sludge.value;
      Outputs.Br.influent=Q*Br; Outputs.Br.effluent.water=Q*Result.Met.Br_water.value; Outputs.Br.effluent.sludge=Q*Result.Met.Br_sludge.value;
      Outputs.Ca.influent=Q*Ca; Outputs.Ca.effluent.water=Q*Result.Met.Ca_water.value; Outputs.Ca.effluent.sludge=Q*Result.Met.Ca_sludge.value;
      Outputs.Cd.influent=Q*Cd; Outputs.Cd.effluent.water=Q*Result.Met.Cd_water.value; Outputs.Cd.effluent.sludge=Q*Result.Met.Cd_sludge.value;
      Outputs.Cl.influent=Q*Cl; Outputs.Cl.effluent.water=Q*Result.Met.Cl_water.value; Outputs.Cl.effluent.sludge=Q*Result.Met.Cl_sludge.value;
      Outputs.Co.influent=Q*Co; Outputs.Co.effluent.water=Q*Result.Met.Co_water.value; Outputs.Co.effluent.sludge=Q*Result.Met.Co_sludge.value;
      Outputs.Cr.influent=Q*Cr; Outputs.Cr.effluent.water=Q*Result.Met.Cr_water.value; Outputs.Cr.effluent.sludge=Q*Result.Met.Cr_sludge.value;
      Outputs.Cu.influent=Q*Cu; Outputs.Cu.effluent.water=Q*Result.Met.Cu_water.value; Outputs.Cu.effluent.sludge=Q*Result.Met.Cu_sludge.value;
      Outputs.Fe.influent=Q*Fe; Outputs.Fe.effluent.water=Q*Result.Met.Fe_water.value; Outputs.Fe.effluent.sludge=Q*Result.Met.Fe_sludge.value;
      Outputs.Hg.influent=Q*Hg; Outputs.Hg.effluent.water=Q*Result.Met.Hg_water.value; Outputs.Hg.effluent.sludge=Q*Result.Met.Hg_sludge.value;
      Outputs.Mg.influent=Q*Mg; Outputs.Mg.effluent.water=Q*Result.Met.Mg_water.value; Outputs.Mg.effluent.sludge=Q*Result.Met.Mg_sludge.value;
      Outputs.Mn.influent=Q*Mn; Outputs.Mn.effluent.water=Q*Result.Met.Mn_water.value; Outputs.Mn.effluent.sludge=Q*Result.Met.Mn_sludge.value;
      Outputs.Mo.influent=Q*Mo; Outputs.Mo.effluent.water=Q*Result.Met.Mo_water.value; Outputs.Mo.effluent.sludge=Q*Result.Met.Mo_sludge.value;
      Outputs.Na.influent=Q*Na; Outputs.Na.effluent.water=Q*Result.Met.Na_water.value; Outputs.Na.effluent.sludge=Q*Result.Met.Na_sludge.value;
      Outputs.Ni.influent=Q*Ni; Outputs.Ni.effluent.water=Q*Result.Met.Ni_water.value; Outputs.Ni.effluent.sludge=Q*Result.Met.Ni_sludge.value;
      Outputs.Pb.influent=Q*Pb; Outputs.Pb.effluent.water=Q*Result.Met.Pb_water.value; Outputs.Pb.effluent.sludge=Q*Result.Met.Pb_sludge.value;
      Outputs.Sb.influent=Q*Sb; Outputs.Sb.effluent.water=Q*Result.Met.Sb_water.value; Outputs.Sb.effluent.sludge=Q*Result.Met.Sb_sludge.value;
      Outputs.Sc.influent=Q*Sc; Outputs.Sc.effluent.water=Q*Result.Met.Sc_water.value; Outputs.Sc.effluent.sludge=Q*Result.Met.Sc_sludge.value;
      Outputs.Se.influent=Q*Se; Outputs.Se.effluent.water=Q*Result.Met.Se_water.value; Outputs.Se.effluent.sludge=Q*Result.Met.Se_sludge.value;
      Outputs.Si.influent=Q*Si; Outputs.Si.effluent.water=Q*Result.Met.Si_water.value; Outputs.Si.effluent.sludge=Q*Result.Met.Si_sludge.value;
      Outputs.Sn.influent=Q*Sn; Outputs.Sn.effluent.water=Q*Result.Met.Sn_water.value; Outputs.Sn.effluent.sludge=Q*Result.Met.Sn_sludge.value;
      Outputs.Sr.influent=Q*Sr; Outputs.Sr.effluent.water=Q*Result.Met.Sr_water.value; Outputs.Sr.effluent.sludge=Q*Result.Met.Sr_sludge.value;
      Outputs.Ti.influent=Q*Ti; Outputs.Ti.effluent.water=Q*Result.Met.Ti_water.value; Outputs.Ti.effluent.sludge=Q*Result.Met.Ti_sludge.value;
      Outputs.Tl.influent=Q*Tl; Outputs.Tl.effluent.water=Q*Result.Met.Tl_water.value; Outputs.Tl.effluent.sludge=Q*Result.Met.Tl_sludge.value;
      Outputs.Zn.influent=Q*Zn; Outputs.Zn.effluent.water=Q*Result.Met.Zn_water.value; Outputs.Zn.effluent.sludge=Q*Result.Met.Zn_sludge.value;
      Outputs.B.influent =Q*B;  Outputs.B.effluent.water =Q*Result.Met.B_water.value;  Outputs.B.effluent.sludge =Q*Result.Met.B_sludge.value;
      Outputs.F.influent =Q*F;  Outputs.F.effluent.water =Q*Result.Met.F_water.value;  Outputs.F.effluent.sludge =Q*Result.Met.F_sludge.value;
      Outputs.I.influent =Q*I;  Outputs.I.effluent.water =Q*Result.Met.I_water.value;  Outputs.I.effluent.sludge =Q*Result.Met.I_sludge.value;
      Outputs.K.influent =Q*K;  Outputs.K.effluent.water =Q*Result.Met.K_water.value;  Outputs.K.effluent.sludge =Q*Result.Met.K_sludge.value;
      Outputs.V.influent =Q*V;  Outputs.V.effluent.water =Q*Result.Met.V_water.value;  Outputs.V.effluent.sludge =Q*Result.Met.V_sludge.value;
      Outputs.W.influent =Q*W;  Outputs.W.effluent.water =Q*Result.Met.W_water.value;  Outputs.W.effluent.sludge =Q*Result.Met.W_sludge.value;
    }
  })();

  Result.summary={
    'SRT':                        {value:SRT,                        unit:"d",               descr:getInputById('SRT').descr},
    'tau':                        {value:tau,                        unit:"h",               descr:""},
    'MLVSS':                      {value:MLVSS,                      unit:"g/m3",            descr:""},
    //'BOD_loading':                {value:BOD_loading,                unit:"kg/m3·d",         descr:""},

    //sludge
    'TSS_removed_kgd': {value:TSS_removed_kgd,  unit:"kg_TSS/d", descr:"Primary_settler_sludge_produced_per_day"},
    'P_X_TSS':  {value:P_X_TSS,  unit:"kg_TSS/d", descr:"Total_sludge_produced_per_day"},
    'P_X_VSS':  {value:P_X_VSS,  unit:"kg_VSS/d", descr:"Volatile suspended solids produced per day"},

    'sludge_C': {value:sludge_C, unit:"kg_C/d",   descr:""},
    'sludge_H': {value:sludge_H, unit:"kg_H/d",   descr:""},
    'sludge_O': {value:sludge_O, unit:"kg_O/d",   descr:""},
    'sludge_N': {value:sludge_N, unit:"kg_N/d",   descr:""},
    'sludge_P': {value:sludge_P, unit:"kg_P/d",   descr:""},

    'Excess_sludge_kg': {value:Excess_sludge_kg, unit:"kg/d",   descr:"from Chemical P removal"},

    'Y_obs_TSS':                  {value:Y_obs_TSS,                  unit:"g_TSS/g_BOD",     descr:""},
    'Y_obs_VSS':                  {value:Y_obs_VSS,                  unit:"g_VSS/g_BOD",     descr:""},

    'air_flowrate':               {value:air_flowrate,               unit:"m3/min",          descr:""},
    'OTRf':                       {value:OTRf,                       unit:"kg_O2/h",         descr:""},
    'SOTR':                       {value:SOTR,                       unit:"kg_O2/h",         descr:""},

    'SDNR':                       {value:SDNR,                       unit:"g/g·d",           descr:""},
    'RAS':                        {value:RAS,                        unit:"&empty;",         descr:""},
    'clarifiers':                 {value:clarifiers,                 unit:"clarifiers",      descr:""},
    'clarifier_diameter':         {value:clarifier_diameter,         unit:"m",               descr:""},

    'V_aer':                      {value:V_aer,                      unit:"m3",              descr:""},
    'V_nox':                      {value:V_nox,                      unit:"m3",              descr:""},
    'V_ana':                      {value:V_ana,                      unit:"m3",              descr:""},
    'V_total':                    {value:V_total,                    unit:"m3",              descr:"Total_reactor_volume_(aerobic+anoxic+anaerobic)"},

    'alkalinity_added':           Result.Nit.alkalinity_added,
    'Mass_of_alkalinity_needed':  Result.Des.Mass_of_alkalinity_needed,

    'FeCl3_volume':               {value:FeCl3_volume,               unit:"L/d",             descr:""},
    'storage_req_15_d':           {value:storage_req_15_d,           unit:"m3",              descr:""},
    'Dewatering_polymer':         {value:Dewatering_polymer,         unit:"kg/d",            descr:""},

    //concrete
    'concrete_reactor':           {value:Concrete.reactor(V_total),             unit:"m3 concrete",    descr:""},
    'concrete_settler':           {value:Concrete.settler(V_settler,h_settler), unit:"m3 concrete",    descr:""},

    'aeration_power':             {value:aeration_power,             unit:"kW",              descr:"Power needed for aeration (=OTRf/SAE)"},
    'mixing_power':               {value:mixing_power,               unit:"kW",              descr:"Power needed for anoxic mixing"},
    'pumping_power_influent':     {value:pumping_power_influent,     unit:"kW",              descr:"Power needed for pumping influent"},
    'pumping_power_external':     {value:pumping_power_external,     unit:"kW",              descr:"Power needed for pumping (external recirculation)"},
    'pumping_power_internal':     {value:pumping_power_internal,     unit:"kW",              descr:"Power needed for pumping (internal recirculation)"},
    'pumping_power_wastage':      {value:pumping_power_wastage,      unit:"kW",              descr:"Power needed for pumping (wastage recirculation)"},
    'pumping_power':              {value:pumping_power,              unit:"kW",              descr:"Power needed for pumping (ext+int+was)"},
    'dewatering_power':           {value:dewatering_power,           unit:"kW",              descr:"Power needed for dewatering"},
    'other_power':                {value:other_power,                unit:"kW",              descr:"Power needed for 'other' (20% of total)"},
    'total_power':                {value:total_power,                unit:"kW",              descr:"Total power needed"},
    'total_daily_energy':         {value:total_power*24,             unit:"kWh/d",           descr:"Total daily energy needed"},
    'total_energy_per_m3':        {value:total_power*24/Q||0,        unit:"kWh/m3",          descr:"Total energy needed per m3"},

    //fossil co2
    'nonbiogenic_CO2': {value:0.036*Outputs.CO2.effluent.air/1000, unit:"kg/d", descr:""},
    'biogenic_CO2':    {value:0.964*Outputs.CO2.effluent.air/1000, unit:"kg/d", descr:""},
  };
  //addResults('summary',Result.summary); //if added, they will be visible in the "Variables" table

  /*utilities*/
    //fx: utility to add a technology result to the "Variables" object (calculated variables)
    function addResults(tech,result){
      /*inputs:
        tech: string representing a technology
        result: object returned from a technology
      */
      for(var res in result){
        var id    = res;
        var value = result[id].value;
        var unit  = result[id].unit;
        var descr = result[id].descr;

        //if a variable with the same id and unit already exists replace it (unless tech==summar)
        if(tech!='summary'){
          var candidates=Variables.filter(v=>{return (v.id==id && v.unit==unit)});
          if(candidates.length){
            candidates.forEach(c=>{
              var index=Variables.indexOf(c);
              Variables.splice(index,1);
            });
          }
        }

        //add a new variable object to "Variables"
        Variables.push({tech,id,value,unit,descr});
      }
    }

    //select a calculated variable from an array of possible technologies that calculate the same variable
    function select_value(id,tec_array){
      var value=0;
      for(var i=0;i<tec_array.length;i++){
        if(Result[tec_array[i]][id]){
          return Result[tec_array[i]][id].value;
          break;
        }
      }
      return value;
    }
  /*end utilities*/

  return Result;
}

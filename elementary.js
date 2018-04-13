/**
  * Main backend function for 'single plant model' (see 'elementary.php' for frontend)
  */

function compute_elementary_flows(input_set){
  //process inputs
    var is=input_set;
    //unpack technologies
      var is_Pri_active = is.is_Pri_active;
      var is_BOD_active = is.is_BOD_active;
      var is_Nit_active = is.is_Nit_active;
      var is_Des_active = is.is_Des_active;
      var is_BiP_active = is.is_BiP_active;
      var is_ChP_active = is.is_ChP_active;
    //unpack ww composition
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

  //make effluent designed not higher than influent observed concentrations
  NH4_eff = Math.min(NH4_eff, TKN);
  NO3_eff = Math.min(NO3_eff, TKN);
  PO4_eff = Math.min(PO4_eff, TP);

  //Variables (global). It is filled using "function addResults()" that uses the object "Result"
  Variables=[];
  /**
    new empty object to store each technology results
      + "other" (for some values not related to any tech)
      + "summary" (for selected variables results oriented)
  */
  var Result={Fra:{},Pri:{},BOD:{},Nit:{},SST:{},Des:{},BiP:{},ChP:{},Met:{},Ene:{},other:{},summary:{},Outputs:{}};

  /*APPLY TECHNOLOGIES MODULES*/

  /*0. SOLVE FRACTIONATION AND PRIMARY SETTLER */
  //call fractionation of raw wastewater (before CSO and primary settler)
  Result.Fra=fractionation(BOD,sBOD,COD,bCOD,sCOD,rbCOD,TSS,VSS,TKN,NH4,NH4_eff,TP,PO4);

  //apply cso removal
  (function(){
    //inputs: fractionation, metals and CSO removal rates (particulate and soluble)
    (function(){
      Result.CSO=cso_removal(Result.Fra, is, CSO_particulate, CSO_soluble);
      addResults('CSO',Result.CSO);
    })();

    //update input values (these are the ones entering the plant)
    COD   = Result.Fra.COD.value;
    TKN   = Result.Fra.TKN.value;
    TP    = Result.Fra.TP.value;
    BOD   = Result.Fra.BOD.value;
    sBOD  = Result.Fra.sBOD.value;
    sCOD  = Result.Fra.sCOD.value;
    bCOD  = Result.Fra.bCOD.value;
    rbCOD = Result.Fra.rbCOD.value;
    VSS   = Result.Fra.VSS.value;
    TSS   = Result.Fra.TSS.value;
    NH4   = Result.Fra.NH4.value;
    PO4   = Result.Fra.PO4.value;

    //recalculate fractionation with updated inputs
    Result.Fra=fractionation(BOD,sBOD,COD,bCOD,sCOD,rbCOD,TSS,VSS,TKN,NH4,NH4_eff,TP,PO4);
  })();

  //apply primary settler
  if(is_Pri_active){
    //get particulated fractions ONLY (the ones that the settler removes)
    var bpCOD          = Result.Fra.bpCOD.value;  //g/m3
    var nbpCOD         = Result.Fra.nbpCOD.value; //g/m3
    var pCOD           = Result.Fra.pCOD.value;   //g/m3
    var iTSS           = Result.Fra.iTSS.value;   //g/m3
    var ON             = Result.Fra.ON.value;     //g/m3
    var OP             = Result.Fra.OP.value;     //g/m3
    var bCOD_BOD_ratio = Result.Fra.bCOD_BOD_ratio.value; //g/g
    var VSS_COD        = Result.Fra.VSS_COD.value; //g_pCOD/g_VSS
    var bpCOD_bVSS     = Result.Fra.bpCOD_bVSS.value; //g_bpCOD/g_bVSS

    //apply primary settler      ----fractions---------- ----ratios-------- ----removal-rates----------------------------------------------
    Result.Pri=primary_settler(Q,bpCOD,nbpCOD,iTSS,ON,OP,VSS_COD,bpCOD_bVSS,removal_bpCOD,removal_nbpCOD,removal_iTSS,removal_ON,removal_OP);
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
    //         primary_settler(Q,bpCOD,nbpCOD,iTSS,ON,OP,VSS_COD,bpCOD_bVSS,removal_bpCOD,removal_nbpCOD,removal_iTSS,removal_ON,removal_OP);
    Result.Pri=primary_settler(0,    0,     0,   0, 0, 0,      0,         0,            0,             0,           0,         0,         0);
    addResults('Pri',Result.Pri);
  }
  //console.log(BOD); //see BOD after primary settler

  //exception regarding TKN_N2O
  if(is_Nit_active==false){ Result.Fra.TKN_N2O.value=0; }

  addResults('Fra',Result.Fra);

  //get fractionated values available for further technologies
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

  //bod removal has to be always active. If not: stop here
  if(is_BOD_active==false){
    console.log('BOD REMOVAL IS INACTIVE: no more technologies will be applied');
    return Result;
  }

  /*1. SOLVE BOD REMOVAL*/
  Result.BOD=bod_removal_only(BOD,nbVSS,TSS,VSS,bCOD_BOD_ratio,Q,T,SRT,MLSS_X_TSS,zb,Pressure,Df,DO);
  addResults('BOD',Result.BOD);

  /*2. SOLVE NITRIFICATION*/
  if(is_Nit_active){
    //to correct NOx and P_X_bio from Metcalf use bTKN instead of TKN
    //         nitrification(--------------------------------------TKN----------------------------------------------------------)
    Result.Nit=nitrification(BOD,bCOD_BOD_ratio,nbVSS,TSS,VSS,Q,T,bTKN,SF,zb,Pressure,Df,MLSS_X_TSS,NH4_eff,sBODe,TSSe,Alkalinity,DO);
    addResults('Nit',Result.Nit);
  }

  //get NOx after nitrification (for denitrification, bio P removal and Outputs)
  var NOx = is_Nit_active ? Result.Nit.NOx.value : 0; //g/m3

  //update SRT value if nitrification is active
  if(is_Nit_active){SRT=Result.Nit.SRT_design.value;/*days*/}

  /*3. SOLVE SST*/
  Result.SST=sst_sizing(Q,SOR,X_R,clarifiers,MLSS_X_TSS);
  addResults('SST',Result.SST);

  //get RAS ratio (for denitrification and bio P removal)
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

  /*5. SOLVE BIO P*/
  if(is_BiP_active){
    var tau_aer = 0.75; //h -- "tau must be between 0.50 and 1.00 h (M&EA)"
    //         bio_P_removal(Q,bCOD,rbCOD,VFA,nbVSS,iTSS,TP,T,SRT,NOx,NO3_eff,tau_aer,RAS);
    Result.BiP=bio_P_removal(Q,bCOD,rbCOD,VFA,nbVSS,iTSS,aP,T,SRT,NOx,NO3_eff,tau_aer,RAS);
    addResults('BiP',Result.BiP);
  }

  /*5. SOLVE CHEM P*/
  if(is_ChP_active){
    //         chem_P_removal(Q,TSS,TP,PO4,PO4_eff,FeCl3_solution,FeCl3_unit_weight,days);
    Result.ChP=chem_P_removal(Q,TSS,TP,aP ,PO4_eff,FeCl3_solution,FeCl3_unit_weight,days);
    addResults('ChP',Result.ChP);
  }
  //--END TECHNOLOGIES FROM METCALF AND EDDY----------------------------------------------

  /*6. Metals (from G. Doka excel tool)*/
  (function(){
    //unpack metals from input set
    var Ag = is.Ag - Result.CSO.elem_Ag_discharged.value;
    var Al = is.Al - Result.CSO.elem_Al_discharged.value;
    var As = is.As - Result.CSO.elem_As_discharged.value;
    var B =  is.B  - Result.CSO.elem_B_discharged.value;
    var Ba = is.Ba - Result.CSO.elem_Ba_discharged.value;
    var Be = is.Be - Result.CSO.elem_Be_discharged.value;
    var Br = is.Br - Result.CSO.elem_Br_discharged.value;
    var Ca = is.Ca - Result.CSO.elem_Ca_discharged.value;
    var Cd = is.Cd - Result.CSO.elem_Cd_discharged.value;
    var Cl = is.Cl - Result.CSO.elem_Cl_discharged.value;
    var Co = is.Co - Result.CSO.elem_Co_discharged.value;
    var Cr = is.Cr - Result.CSO.elem_Cr_discharged.value;
    var Cu = is.Cu - Result.CSO.elem_Cu_discharged.value;
    var F  = is.F  - Result.CSO.elem_F_discharged.value;
    var Fe = is.Fe - Result.CSO.elem_Fe_discharged.value;
    var Hg = is.Hg - Result.CSO.elem_Hg_discharged.value;
    var I  = is.I  - Result.CSO.elem_I_discharged.value;
    var K  = is.K  - Result.CSO.elem_K_discharged.value;
    var Mg = is.Mg - Result.CSO.elem_Mg_discharged.value;
    var Mn = is.Mn - Result.CSO.elem_Mn_discharged.value;
    var Mo = is.Mo - Result.CSO.elem_Mo_discharged.value;
    var Na = is.Na - Result.CSO.elem_Na_discharged.value;
    var Ni = is.Ni - Result.CSO.elem_Ni_discharged.value;
    var Pb = is.Pb - Result.CSO.elem_Pb_discharged.value;
    var Sb = is.Sb - Result.CSO.elem_Sb_discharged.value;
    var Sc = is.Sc - Result.CSO.elem_Sc_discharged.value;
    var Se = is.Se - Result.CSO.elem_Se_discharged.value;
    var Si = is.Si - Result.CSO.elem_Si_discharged.value;
    var Sn = is.Sn - Result.CSO.elem_Sn_discharged.value;
    var Sr = is.Sr - Result.CSO.elem_Sr_discharged.value;
    var Ti = is.Ti - Result.CSO.elem_Ti_discharged.value;
    var Tl = is.Tl - Result.CSO.elem_Tl_discharged.value;
    var V  = is.V  - Result.CSO.elem_V_discharged.value;
    var W  = is.W  - Result.CSO.elem_W_discharged.value;
    var Zn = is.Zn - Result.CSO.elem_Zn_discharged.value;
    Result.Met=metals_doka(Ag,Al,As,B,Ba,Be,Br,Ca,Cd,Cl,Co,Cr,Cu,F,Fe,Hg,I,K,Mg,Mn,Mo,Na,Ni,Pb,Sb,Sc,Se,Si,Sn,Sr,Ti,Tl,V,W,Zn);
    addResults('Met',Result.Met);
  })();
  //--------------------------------------------------------------------------------------

  /*OTHER VARIABLES*/

  //BOD per person per day
  var BOD_person_day = Q*is.BOD/is.PEq; //g/person/day

  //C content
  var TOC_content = is.COD/is.COD_TOC_ratio; //gC/m3

  //S, VSSe and sCODe
  var S     = select_value('S', ['Nit','BOD']); //g/m3 -- bCOD effluent
  var sCODe = nbsCODe+S;                        //g/m3 -- soluble COD effluent
  var VSSe  = Math.min(VSS, TSSe*0.85);         //g/m3 -- VSS effluent

  //recalculate PO4_eff
  var P_X_bio = select_value('P_X_bio', ['BiP','Nit','BOD']);
  var P_synth = 0.015*P_X_bio*1000/Q || 0; //g/m3
  var aPchem  = aP - P_synth;              //g/m3

  //if bio P removal: PO4_eff is calculated
  if     (is_BiP_active) { PO4_eff = Result.BiP.Effluent_P.value; }
  //if chem P removal: PO4_eff is imposed in design (user input) "do nothing"
  else if(is_ChP_active) { PO4_eff = PO4_eff; }
  //if NO P removal: PO4_eff is calculated as PO4_eff = aP - P_synth
  else                   { PO4_eff = aP - P_synth; }

  //total reactor volume (m3): V_total = V_aerobic + V_anoxic + V_anaerobic
  var V_aer   = select_value('V_aer',['Nit','BOD']);
  var V_nox   = select_value('V_nox',['Des']);
  var V_ana   = select_value('V_ana',['BiP']);
  var V_total = V_aer + V_nox + V_ana;

  //Qwas and Qe equations (wastage and effluent flowrates)
  var Qwas = (V_total*MLSS_X_TSS/SRT - Q*TSSe)/(X_R - TSSe) ||0; //m3/d
  Qwas = Math.max(0, Qwas);         //avoid negative
  Qwas = isFinite(Qwas) ? Qwas : 0; //avoid infinite
  var Qe = Q - Qwas; //m3/d

  /*ENERGY consumption*/
  var OTRf         = select_value('OTRf',    ['Des','Nit','BOD']); //kg/h
  var mixing_power = select_value('Power',   ['Des']); //kW
  var IR           = select_value('IR',      ['Des']); //unitless
  var P_X_TSS      = select_value('P_X_TSS', ['BiP','Nit','BOD']); //kg/d
  Result.Ene=energy_consumption(Q, Qwas, RAS, OTRf, mixing_power, IR, P_X_TSS, influent_H, is_Pri_active);

  //Pack 'other' variables
  Result.other={
    'BOD_person_day': {value:BOD_person_day, unit:"g/person/day_as_O2", descr:"BOD5 per person per day"},
    'TOC_content':    {value:TOC_content,    unit:"g/m3_as_C",          descr:"TOC content"},
    'S':              {value:S,              unit:"g/m3_as_O2",         descr:"bCOD at the effluent"},
    'sCODe':          {value:sCODe,          unit:"g/m3_as_O2",         descr:"Soluble COD at the effluent"},
    'VSSe':           {value:VSSe,           unit:"g/m3",               descr:"Volatile Suspended Solids at the effluent"},
    'P_X_bio':        {value:P_X_bio,        unit:"kg/d",               descr:"Biomass production"},
    'aP':             {value:aP,             unit:"g/m3",               descr:"Available P (=PO4 + bOP)"},
    'P_synth':        {value:P_synth,        unit:"g/m3",               descr:"P used for biomass synthesis"},
    'aPchem':         {value:aPchem,         unit:"g/m3",               descr:"Available P - P_synth"},
    'PO4_eff':        {value:PO4_eff,        unit:"g/m3_as_P",          descr:"Effluent PO4"},
    'V_total':        {value:V_total,        unit:"m3",                 descr:"Total reactor volume (aerobic+anoxic+anaerobic)"},
    'Qwas':           {value:Qwas,           unit:"m3/d",               descr:"Wastage flow"},
    'Qe':             {value:Qe,             unit:"m3/d",               descr:"Qe = Q - Qwas"},
  };
  addResults('Ene',Result.Ene);
  addResults('other',Result.other);

  /*SUMMARY TABLE*/

  /*polymer for dewatering (chemical)*/
  var Dewatering_polymer = 0.01*P_X_TSS; //kg polymer/d -- (0.01 is kg polymer/kg sludge)

  /*concrete*/
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

  //sludge composition module
    var VSS_removed      = select_value('VSS_removed',      ['Pri']); //g/m3
    var nbVSS_removed    = select_value('nbVSS_removed',    ['Pri']); //g/m3
    var bVSS_removed     = select_value('bVSS_removed',     ['Pri']); //g/m3
    var VSS_COD          = select_value('VSS_COD',          ['Fra']); //g/m3
    var bpCOD_bVSS       = select_value('bpCOD_bVSS',       ['Fra']); //g/m3
    var Excess_sludge_kg = select_value('Excess_sludge_kg', ['ChP']); //kg iSS/d
    var Fe_P_mole_ratio  = select_value('Fe_P_mole_ratio',  ['ChP']); //moles Fe / moles P
    var P_X_VSS          = select_value('P_X_VSS',          ['BiP','Nit','BOD']); //kg/d
    //call sludge composition module
    var sludge_primary       = sludge_composition.primary(VSS_removed, nbVSS_removed, bVSS_removed, VSS_COD, bpCOD_bVSS);
    var sludge_secondary     = sludge_composition.secondary(P_X_VSS);
    var sludge_precipitation = sludge_composition.precipitation(Excess_sludge_kg, Fe_P_mole_ratio);
    //unpack sludge composition values
    var sludge_primary_C_content        = sludge_primary.C_content/1000*Q; //kg C/d
    var sludge_primary_H_content        = sludge_primary.H_content/1000*Q; //kg H/d
    var sludge_primary_O_content        = sludge_primary.O_content/1000*Q; //kg O/d
    var sludge_primary_N_content        = sludge_primary.N_content/1000*Q; //kg N/d
    var sludge_primary_P_content        = sludge_primary.P_content/1000*Q; //kg P/d
    var sludge_secondary_C_content      = sludge_secondary.C_content;      //kg C/d
    var sludge_secondary_H_content      = sludge_secondary.H_content;      //kg H/d
    var sludge_secondary_O_content      = sludge_secondary.O_content;      //kg O/d
    var sludge_secondary_N_content      = sludge_secondary.N_content;      //kg N/d
    var sludge_secondary_P_content      = sludge_secondary.P_content;      //kg P/d
    var sludge_precipitation_Fe_content = sludge_precipitation.Fe_content; //kg Fe/d
    var sludge_precipitation_H_content  = sludge_precipitation.H_content;  //kg H/d
    var sludge_precipitation_P_content  = sludge_precipitation.P_content;  //kg P/d
    var sludge_precipitation_O_content  = sludge_precipitation.O_content;  //kg O/d

  /*OUTPUTS (global)*/
  (function(){
    /**
      * OUTPUTS by phase (water, air, sludge)
      ***********************************************************************************************
      * IMPORTANT: ALL OUTPUTS MUST BE IN [G/D]: THEY ARE CONVERTED TO [KG/D] OR [G/M3] IN FRONTEND *
      ***********************************************************************************************
      *  TECHNOLOGY         | IN/ACTIVE var | RESULTS OBJECT |
      * --------------------+---------------+----------------|
      *  fractionation      | N/A           | Result.Fra     |
      *  bod removal        | is_BOD_active | Result.BOD     |
      *  nitrification      | is_Nit_active | Result.Nit     |
      *  sst sizing         | N/A           | Result.SST     |
      *  denitrification    | is_Des_active | Result.Des     |
      *  bio P removal      | is_BiP_active | Result.BiP     |
      *  chemical P removal | is_ChP_active | Result.ChP     |
      *  metals             | N/A           | Result.Met     |
      *  energy             | N/A           | Result.Ene     |
      */

    //get variables for lcorominas pdf equations
    var bHT = Result.BOD.bHT.value;     //1/d

    //Outputs.COD
    Outputs.COD.influent       = Q*COD;
    Outputs.COD.effluent.water = Qe*sCODe + Qe*VSSe*1.42;
    Outputs.COD.effluent.air   = (function(){
      /* CARBONACEOUS DEMAND */
      //this expression (from aeration paper lcorominas found) makes mass balance close
      //return Q*(1-YH)*(bCOD-S) + Q*YH*(bCOD-S)*bHT*SRT/(1+bHT*SRT)*(1-fd) - 4.49*NOx;
      // COD equations for carbonaceous demand to be revised
      //debug info
      //console.log("CARBONACEOUS DEMAND DISCUSSION");
      var Oxygen_credit = 2.86*Q*(NOx-NO3_eff);
      //console.log("  O2 credit: "+Oxygen_credit/1000+" kg/d");
      var QNOx457 = 4.57*Q*NOx;
      //console.log("  4.57·Q·NOx: "+QNOx457/1000+" kg/d");
      //in all 3 equations: P_X_bio = Q*YH*(bCOD-S)/(1+bHT*SRT) + fd*bHT*Q*YH*(bCOD-S)*SRT/(1+bHT*SRT)
      if(is_Des_active){
        return Result.Des.OTRf.value*24*1000 - 4.57*Q*NOx + 2.86*Q*(NOx-NO3_eff); //from kg/h to g/d
        // OTRf          = Q*(bCOD-S) - 1.42*P_X_bio + 4.57*Q*NOx - Oxygen_credit;
        // Oxygen_credit = 2.86*Q*(NOx-NH4_eff);
      }else if(is_Nit_active){
        return Result.Nit.OTRf.value*24*1000 - 4.57*Q*NOx; //from kg/h to g/d
        // OTRf          = Q*(bCOD-S) - 1.42*P_X_bio + 4.57*Q*NOx
      }else if(is_BOD_active){
        return Result.BOD.OTRf.value*24*1000; //from kg/h to g/d
        // OTRf          = Q*(bCOD-S) - 1.42*P_X_bio
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
      var air = k_CO2_COD*Q*(1-YH)*(bCOD-S) + k_CO2_bio*Q*YH*(bCOD-S)*bHT*SRT/(1+bHT*SRT)*(1-fd) - 4.49*NOx;
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
        var g_P_VSS_new = P_X_VSS==0 ? 0 : (Q*PO4-Qe*PO4_eff)/(P_X_VSS*1000); //g_P/g_VSS
        return Qe*PO4_eff + Qe*VSSe*g_P_VSS_new;
      }
      else if(is_BiP_active==false && is_ChP_active){   //chem P removal
        //recalculate the 0.015 factor, in bio P removal changes
        var g_P_VSS_new = P_X_VSS==0 ? 0 : (Q*PO4-Qe*PO4_eff)/(P_X_VSS*1000); //g_P/g_VSS
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
        var g_P_VSS_new = P_X_VSS==0 ? 0 : (Q*PO4-Qe*PO4_eff)/(P_X_VSS*1000); //g_P/g_VSS
        return Q*Result.BiP.P_removal.value + B + C - Qe*VSSe*g_P_VSS_new; 
      }
      else if(is_BiP_active==false && is_ChP_active){  //chem P removal
        //recalculate the 0.015 factor, in bio P removal changes
        var g_P_VSS_new = P_X_VSS==0 ? 0 : (Q*PO4-Qe*PO4_eff)/(P_X_VSS*1000); //g_P/g_VSS
        return (0.015*P_X_bio*1000) + Q*(aPchem - PO4_eff) + B + C - Qe*VSSe*g_P_VSS_new; 
      }
      else{ //both P removals are not seen in practice (G. Ekama)
        return 0;
      }
    })();

    //Outputs METALS
    (function(){
      Inputs.filter(i=>{return i.isMetal}).forEach(i=>{
        var metal=i.id;
        Outputs[metal].influent = Q*(is[metal]-Result.CSO['elem_'+metal+'_discharged'].value);
        ['water','sludge'].forEach(part=>{
          Outputs[metal].effluent[part] = Q*Result.Met[metal+"_"+part].value;
        });
      });
    })();
  })();

  //'summary' variables
  var tau                       = select_value('tau',                       ['Des','Nit','BOD']);
  var MLVSS                     = select_value('MLVSS',                     ['Nit','BOD']);
  var TSS_removed_kgd           = select_value('TSS_removed_kgd',           ['Pri']);
  var VSS_removed_kgd           = select_value('VSS_removed_kgd',           ['Pri']);
  var Y_obs_TSS                 = select_value('Y_obs_TSS',                 ['Nit','BOD'])
  var Y_obs_VSS                 = select_value('Y_obs_VSS',                 ['Nit','BOD'])
  var air_flowrate              = select_value('air_flowrate',              ['Des','Nit','BOD']);
  var SOTR                      = select_value('SOTR',                      ['Des','Nit','BOD']);
  var SDNR                      = select_value('SDNR',                      ['Des']);
  var clarifier_diameter        = select_value('clarifier_diameter',        ['SST']);
  var alkalinity_added          = select_value('alkalinity_added',          ['Nit']);
  var Mass_of_alkalinity_needed = select_value('Mass_of_alkalinity_needed', ['Des']);
  var FeCl3_volume              = select_value('FeCl3_volume',              ['ChP']);
  var storage_req_15_d          = select_value('storage_req_15_d',          ['ChP']);
  //end summary

  Result.summary={
    'SRT':                        {value:SRT,                        unit:"d",               descr:getInputById('SRT').descr},
    'tau':                        {value:tau,                        unit:"h",               descr:""},
    'MLVSS':                      {value:MLVSS,                      unit:"g/m3",            descr:""},
    //sludge
    'TSS_removed_kgd':  {value:TSS_removed_kgd,  unit:"kg_TSS/d", descr:"Primary_settler_sludge_produced_per_day"},
    'VSS_removed_kgd':  {value:VSS_removed_kgd,  unit:"kg_VSS/d", descr:"Primary_settler_VSS_produced_per_day"},
    'P_X_TSS':          {value:P_X_TSS,          unit:"kg_TSS/d", descr:"Total_sludge_produced_per_day"},
    'P_X_VSS':          {value:P_X_VSS,          unit:"kg_VSS/d", descr:"Volatile suspended solids produced per day"},
    'Excess_sludge_kg': {value:Excess_sludge_kg, unit:"kg_iSS/d", descr:"from Chemical P removal"},
    sludge_primary_C_content        : {value:sludge_primary_C_content       , unit:"kg_C/d",  descr:""},
    sludge_primary_H_content        : {value:sludge_primary_H_content       , unit:"kg_H/d",  descr:""},
    sludge_primary_O_content        : {value:sludge_primary_O_content       , unit:"kg_O/d",  descr:""},
    sludge_primary_N_content        : {value:sludge_primary_N_content       , unit:"kg_N/d",  descr:""},
    sludge_primary_P_content        : {value:sludge_primary_P_content       , unit:"kg_P/d",  descr:""},
    sludge_secondary_C_content      : {value:sludge_secondary_C_content     , unit:"kg_C/d",  descr:""},
    sludge_secondary_H_content      : {value:sludge_secondary_H_content     , unit:"kg_H/d",  descr:""},
    sludge_secondary_O_content      : {value:sludge_secondary_O_content     , unit:"kg_O/d",  descr:""},
    sludge_secondary_N_content      : {value:sludge_secondary_N_content     , unit:"kg_N/d",  descr:""},
    sludge_secondary_P_content      : {value:sludge_secondary_P_content     , unit:"kg_P/d",  descr:""},
    sludge_precipitation_Fe_content : {value:sludge_precipitation_Fe_content, unit:"kg_Fe/d", descr:""},
    sludge_precipitation_H_content  : {value:sludge_precipitation_H_content , unit:"kg_H/d",  descr:""},
    sludge_precipitation_P_content  : {value:sludge_precipitation_P_content , unit:"kg_P/d",  descr:""},
    sludge_precipitation_O_content  : {value:sludge_precipitation_O_content , unit:"kg_O/d",  descr:""},
    //design summary
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
    //chemicals
    'alkalinity_added':           Result.Nit.alkalinity_added,
    'Mass_of_alkalinity_needed':  Result.Des.Mass_of_alkalinity_needed,
    'FeCl3_volume':               {value:FeCl3_volume,               unit:"L/d",             descr:""},
    'storage_req_15_d':           {value:storage_req_15_d,           unit:"m3",              descr:""},
    'Dewatering_polymer':         {value:Dewatering_polymer,         unit:"kg/d",            descr:""},
    'concrete_reactor':           {value:Concrete.reactor(V_total),             unit:"m3 concrete",    descr:""},
    'concrete_settler':           {value:Concrete.settler(V_settler,h_settler), unit:"m3 concrete",    descr:""},
    //energy
    'aeration_power':         Result.Ene.aeration_power,
    'mixing_power':           Result.Ene.mixing_power,
    'pumping_power_influent': Result.Ene.pumping_power_influent,
    'pumping_power_external': Result.Ene.pumping_power_external,
    'pumping_power_internal': Result.Ene.pumping_power_internal,
    'pumping_power_wastage':  Result.Ene.pumping_power_wastage,
    'pumping_power':          Result.Ene.pumping_power,
    'dewatering_power':       Result.Ene.dewatering_power,
    'other_power':            Result.Ene.other_power,
    'total_power':            Result.Ene.total_power,
    'total_daily_energy':     Result.Ene.total_daily_energy,
    'total_energy_per_m3':    Result.Ene.total_energy_per_m3,
    //CO2 fossil or biogenic
    'nonbiogenic_CO2': {value:is.fossil_CO2_percent/100    *Outputs.CO2.effluent.air/1000, unit:"kg/d", descr:""},
    'biogenic_CO2':    {value:(1-is.fossil_CO2_percent/100)*Outputs.CO2.effluent.air/1000, unit:"kg/d", descr:""},
  };
  //addResults('summary',Result.summary); //if added, they will be visible in the "Variables" table

  //pack here Outputs instead of global variable
  Result.Outputs={
    //key components
    COD_influent         :  {value:Outputs.COD.influent,         unit:"g/d",  },
    COD_effluent_water   :  {value:Outputs.COD.effluent.water,   unit:"g/d",  },
    COD_effluent_air     :  {value:Outputs.COD.effluent.air,     unit:"g/d",  },
    COD_effluent_sludge  :  {value:Outputs.COD.effluent.sludge,  unit:"g/d",  },
    CO2_influent         :  {value:Outputs.CO2.influent,         unit:"g/d",  },
    CO2_effluent_water   :  {value:Outputs.CO2.effluent.water,   unit:"g/d",  },
    CO2_effluent_air     :  {value:Outputs.CO2.effluent.air,     unit:"g/d",  },
    CO2_effluent_sludge  :  {value:Outputs.CO2.effluent.sludge,  unit:"g/d",  },
    CH4_influent         :  {value:Outputs.CH4.influent,         unit:"g/d",  },
    CH4_effluent_water   :  {value:Outputs.CH4.effluent.water,   unit:"g/d",  },
    CH4_effluent_air     :  {value:Outputs.CH4.effluent.air,     unit:"g/d",  },
    CH4_effluent_sludge  :  {value:Outputs.CH4.effluent.sludge,  unit:"g/d",  },
    TKN_influent         :  {value:Outputs.TKN.influent,         unit:"g/d",  },
    TKN_effluent_water   :  {value:Outputs.TKN.effluent.water,   unit:"g/d",  },
    TKN_effluent_air     :  {value:Outputs.TKN.effluent.air,     unit:"g/d",  },
    TKN_effluent_sludge  :  {value:Outputs.TKN.effluent.sludge,  unit:"g/d",  },
    NOx_influent         :  {value:Outputs.NOx.influent,         unit:"g/d",  },
    NOx_effluent_water   :  {value:Outputs.NOx.effluent.water,   unit:"g/d",  },
    NOx_effluent_air     :  {value:Outputs.NOx.effluent.air,     unit:"g/d",  },
    NOx_effluent_sludge  :  {value:Outputs.NOx.effluent.sludge,  unit:"g/d",  },
    N2_influent          :  {value:Outputs.N2.influent,          unit:"g/d",  },
    N2_effluent_water    :  {value:Outputs.N2.effluent.water,    unit:"g/d",  },
    N2_effluent_air      :  {value:Outputs.N2.effluent.air,      unit:"g/d",  },
    N2_effluent_sludge   :  {value:Outputs.N2.effluent.sludge,   unit:"g/d",  },
    N2O_influent         :  {value:Outputs.N2O.influent,         unit:"g/d",  },
    N2O_effluent_water   :  {value:Outputs.N2O.effluent.water,   unit:"g/d",  },
    N2O_effluent_air     :  {value:Outputs.N2O.effluent.air,     unit:"g/d",  },
    N2O_effluent_sludge  :  {value:Outputs.N2O.effluent.sludge,  unit:"g/d",  },
    TP_influent          :  {value:Outputs.TP.influent,          unit:"g/d",  },
    TP_effluent_water    :  {value:Outputs.TP.effluent.water,    unit:"g/d",  },
    TP_effluent_air      :  {value:Outputs.TP.effluent.air,      unit:"g/d",  },
    TP_effluent_sludge   :  {value:Outputs.TP.effluent.sludge,   unit:"g/d",  },

    //metals and other elements
    "Ag_influent"         :  {value:Outputs.Ag.influent,         unit:"g/d",  },
    "Ag_effluent_water"   :  {value:Outputs.Ag.effluent.water,   unit:"g/d",  },
    "Ag_effluent_air"     :  {value:Outputs.Ag.effluent.air,     unit:"g/d",  },
    "Ag_effluent_sludge"  :  {value:Outputs.Ag.effluent.sludge,  unit:"g/d",  },
    "Al_influent"         :  {value:Outputs.Al.influent,         unit:"g/d",  },
    "Al_effluent_water"   :  {value:Outputs.Al.effluent.water,   unit:"g/d",  },
    "Al_effluent_air"     :  {value:Outputs.Al.effluent.air,     unit:"g/d",  },
    "Al_effluent_sludge"  :  {value:Outputs.Al.effluent.sludge,  unit:"g/d",  },
    "As_influent"         :  {value:Outputs.As.influent,         unit:"g/d",  },
    "As_effluent_water"   :  {value:Outputs.As.effluent.water,   unit:"g/d",  },
    "As_effluent_air"     :  {value:Outputs.As.effluent.air,     unit:"g/d",  },
    "As_effluent_sludge"  :  {value:Outputs.As.effluent.sludge,  unit:"g/d",  },
    "B_influent"          :  {value:Outputs.B.influent,          unit:"g/d",  },
    "B_effluent_water"    :  {value:Outputs.B.effluent.water,    unit:"g/d",  },
    "B_effluent_air"      :  {value:Outputs.B.effluent.air,      unit:"g/d",  },
    "B_effluent_sludge"   :  {value:Outputs.B.effluent.sludge,   unit:"g/d",  },
    "Ba_influent"         :  {value:Outputs.Ba.influent,         unit:"g/d",  },
    "Ba_effluent_water"   :  {value:Outputs.Ba.effluent.water,   unit:"g/d",  },
    "Ba_effluent_air"     :  {value:Outputs.Ba.effluent.air,     unit:"g/d",  },
    "Ba_effluent_sludge"  :  {value:Outputs.Ba.effluent.sludge,  unit:"g/d",  },
    "Be_influent"         :  {value:Outputs.Be.influent,         unit:"g/d",  },
    "Be_effluent_water"   :  {value:Outputs.Be.effluent.water,   unit:"g/d",  },
    "Be_effluent_air"     :  {value:Outputs.Be.effluent.air,     unit:"g/d",  },
    "Be_effluent_sludge"  :  {value:Outputs.Be.effluent.sludge,  unit:"g/d",  },
    "Br_influent"         :  {value:Outputs.Br.influent,         unit:"g/d",  },
    "Br_effluent_water"   :  {value:Outputs.Br.effluent.water,   unit:"g/d",  },
    "Br_effluent_air"     :  {value:Outputs.Br.effluent.air,     unit:"g/d",  },
    "Br_effluent_sludge"  :  {value:Outputs.Br.effluent.sludge,  unit:"g/d",  },
    "Ca_influent"         :  {value:Outputs.Ca.influent,         unit:"g/d",  },
    "Ca_effluent_water"   :  {value:Outputs.Ca.effluent.water,   unit:"g/d",  },
    "Ca_effluent_air"     :  {value:Outputs.Ca.effluent.air,     unit:"g/d",  },
    "Ca_effluent_sludge"  :  {value:Outputs.Ca.effluent.sludge,  unit:"g/d",  },
    "Cd_influent"         :  {value:Outputs.Cd.influent,         unit:"g/d",  },
    "Cd_effluent_water"   :  {value:Outputs.Cd.effluent.water,   unit:"g/d",  },
    "Cd_effluent_air"     :  {value:Outputs.Cd.effluent.air,     unit:"g/d",  },
    "Cd_effluent_sludge"  :  {value:Outputs.Cd.effluent.sludge,  unit:"g/d",  },
    "Cl_influent"         :  {value:Outputs.Cl.influent,         unit:"g/d",  },
    "Cl_effluent_water"   :  {value:Outputs.Cl.effluent.water,   unit:"g/d",  },
    "Cl_effluent_air"     :  {value:Outputs.Cl.effluent.air,     unit:"g/d",  },
    "Cl_effluent_sludge"  :  {value:Outputs.Cl.effluent.sludge,  unit:"g/d",  },
    "Co_influent"         :  {value:Outputs.Co.influent,         unit:"g/d",  },
    "Co_effluent_water"   :  {value:Outputs.Co.effluent.water,   unit:"g/d",  },
    "Co_effluent_air"     :  {value:Outputs.Co.effluent.air,     unit:"g/d",  },
    "Co_effluent_sludge"  :  {value:Outputs.Co.effluent.sludge,  unit:"g/d",  },
    "Cr_influent"         :  {value:Outputs.Cr.influent,         unit:"g/d",  },
    "Cr_effluent_water"   :  {value:Outputs.Cr.effluent.water,   unit:"g/d",  },
    "Cr_effluent_air"     :  {value:Outputs.Cr.effluent.air,     unit:"g/d",  },
    "Cr_effluent_sludge"  :  {value:Outputs.Cr.effluent.sludge,  unit:"g/d",  },
    "Cu_influent"         :  {value:Outputs.Cu.influent,         unit:"g/d",  },
    "Cu_effluent_water"   :  {value:Outputs.Cu.effluent.water,   unit:"g/d",  },
    "Cu_effluent_air"     :  {value:Outputs.Cu.effluent.air,     unit:"g/d",  },
    "Cu_effluent_sludge"  :  {value:Outputs.Cu.effluent.sludge,  unit:"g/d",  },
    "F_influent"          :  {value:Outputs.F.influent,          unit:"g/d",  },
    "F_effluent_water"    :  {value:Outputs.F.effluent.water,    unit:"g/d",  },
    "F_effluent_air"      :  {value:Outputs.F.effluent.air,      unit:"g/d",  },
    "F_effluent_sludge"   :  {value:Outputs.F.effluent.sludge,   unit:"g/d",  },
    "Fe_influent"         :  {value:Outputs.Fe.influent,         unit:"g/d",  },
    "Fe_effluent_water"   :  {value:Outputs.Fe.effluent.water,   unit:"g/d",  },
    "Fe_effluent_air"     :  {value:Outputs.Fe.effluent.air,     unit:"g/d",  },
    "Fe_effluent_sludge"  :  {value:Outputs.Fe.effluent.sludge,  unit:"g/d",  },
    "Hg_influent"         :  {value:Outputs.Hg.influent,         unit:"g/d",  },
    "Hg_effluent_water"   :  {value:Outputs.Hg.effluent.water,   unit:"g/d",  },
    "Hg_effluent_air"     :  {value:Outputs.Hg.effluent.air,     unit:"g/d",  },
    "Hg_effluent_sludge"  :  {value:Outputs.Hg.effluent.sludge,  unit:"g/d",  },
    "I_influent"          :  {value:Outputs.I.influent,          unit:"g/d",  },
    "I_effluent_water"    :  {value:Outputs.I.effluent.water,    unit:"g/d",  },
    "I_effluent_air"      :  {value:Outputs.I.effluent.air,      unit:"g/d",  },
    "I_effluent_sludge"   :  {value:Outputs.I.effluent.sludge,   unit:"g/d",  },
    "K_influent"          :  {value:Outputs.K.influent,          unit:"g/d",  },
    "K_effluent_water"    :  {value:Outputs.K.effluent.water,    unit:"g/d",  },
    "K_effluent_air"      :  {value:Outputs.K.effluent.air,      unit:"g/d",  },
    "K_effluent_sludge"   :  {value:Outputs.K.effluent.sludge,   unit:"g/d",  },
    "Mg_influent"         :  {value:Outputs.Mg.influent,         unit:"g/d",  },
    "Mg_effluent_water"   :  {value:Outputs.Mg.effluent.water,   unit:"g/d",  },
    "Mg_effluent_air"     :  {value:Outputs.Mg.effluent.air,     unit:"g/d",  },
    "Mg_effluent_sludge"  :  {value:Outputs.Mg.effluent.sludge,  unit:"g/d",  },
    "Mn_influent"         :  {value:Outputs.Mn.influent,         unit:"g/d",  },
    "Mn_effluent_water"   :  {value:Outputs.Mn.effluent.water,   unit:"g/d",  },
    "Mn_effluent_air"     :  {value:Outputs.Mn.effluent.air,     unit:"g/d",  },
    "Mn_effluent_sludge"  :  {value:Outputs.Mn.effluent.sludge,  unit:"g/d",  },
    "Mo_influent"         :  {value:Outputs.Mo.influent,         unit:"g/d",  },
    "Mo_effluent_water"   :  {value:Outputs.Mo.effluent.water,   unit:"g/d",  },
    "Mo_effluent_air"     :  {value:Outputs.Mo.effluent.air,     unit:"g/d",  },
    "Mo_effluent_sludge"  :  {value:Outputs.Mo.effluent.sludge,  unit:"g/d",  },
    "Na_influent"         :  {value:Outputs.Na.influent,         unit:"g/d",  },
    "Na_effluent_water"   :  {value:Outputs.Na.effluent.water,   unit:"g/d",  },
    "Na_effluent_air"     :  {value:Outputs.Na.effluent.air,     unit:"g/d",  },
    "Na_effluent_sludge"  :  {value:Outputs.Na.effluent.sludge,  unit:"g/d",  },
    "Ni_influent"         :  {value:Outputs.Ni.influent,         unit:"g/d",  },
    "Ni_effluent_water"   :  {value:Outputs.Ni.effluent.water,   unit:"g/d",  },
    "Ni_effluent_air"     :  {value:Outputs.Ni.effluent.air,     unit:"g/d",  },
    "Ni_effluent_sludge"  :  {value:Outputs.Ni.effluent.sludge,  unit:"g/d",  },
    "Pb_influent"         :  {value:Outputs.Pb.influent,         unit:"g/d",  },
    "Pb_effluent_water"   :  {value:Outputs.Pb.effluent.water,   unit:"g/d",  },
    "Pb_effluent_air"     :  {value:Outputs.Pb.effluent.air,     unit:"g/d",  },
    "Pb_effluent_sludge"  :  {value:Outputs.Pb.effluent.sludge,  unit:"g/d",  },
    "Sb_influent"         :  {value:Outputs.Sb.influent,         unit:"g/d",  },
    "Sb_effluent_water"   :  {value:Outputs.Sb.effluent.water,   unit:"g/d",  },
    "Sb_effluent_air"     :  {value:Outputs.Sb.effluent.air,     unit:"g/d",  },
    "Sb_effluent_sludge"  :  {value:Outputs.Sb.effluent.sludge,  unit:"g/d",  },
    "Sc_influent"         :  {value:Outputs.Sc.influent,         unit:"g/d",  },
    "Sc_effluent_water"   :  {value:Outputs.Sc.effluent.water,   unit:"g/d",  },
    "Sc_effluent_air"     :  {value:Outputs.Sc.effluent.air,     unit:"g/d",  },
    "Sc_effluent_sludge"  :  {value:Outputs.Sc.effluent.sludge,  unit:"g/d",  },
    "Se_influent"         :  {value:Outputs.Se.influent,         unit:"g/d",  },
    "Se_effluent_water"   :  {value:Outputs.Se.effluent.water,   unit:"g/d",  },
    "Se_effluent_air"     :  {value:Outputs.Se.effluent.air,     unit:"g/d",  },
    "Se_effluent_sludge"  :  {value:Outputs.Se.effluent.sludge,  unit:"g/d",  },
    "Si_influent"         :  {value:Outputs.Si.influent,         unit:"g/d",  },
    "Si_effluent_water"   :  {value:Outputs.Si.effluent.water,   unit:"g/d",  },
    "Si_effluent_air"     :  {value:Outputs.Si.effluent.air,     unit:"g/d",  },
    "Si_effluent_sludge"  :  {value:Outputs.Si.effluent.sludge,  unit:"g/d",  },
    "Sn_influent"         :  {value:Outputs.Sn.influent,         unit:"g/d",  },
    "Sn_effluent_water"   :  {value:Outputs.Sn.effluent.water,   unit:"g/d",  },
    "Sn_effluent_air"     :  {value:Outputs.Sn.effluent.air,     unit:"g/d",  },
    "Sn_effluent_sludge"  :  {value:Outputs.Sn.effluent.sludge,  unit:"g/d",  },
    "Sr_influent"         :  {value:Outputs.Sr.influent,         unit:"g/d",  },
    "Sr_effluent_water"   :  {value:Outputs.Sr.effluent.water,   unit:"g/d",  },
    "Sr_effluent_air"     :  {value:Outputs.Sr.effluent.air,     unit:"g/d",  },
    "Sr_effluent_sludge"  :  {value:Outputs.Sr.effluent.sludge,  unit:"g/d",  },
    "Ti_influent"         :  {value:Outputs.Ti.influent,         unit:"g/d",  },
    "Ti_effluent_water"   :  {value:Outputs.Ti.effluent.water,   unit:"g/d",  },
    "Ti_effluent_air"     :  {value:Outputs.Ti.effluent.air,     unit:"g/d",  },
    "Ti_effluent_sludge"  :  {value:Outputs.Ti.effluent.sludge,  unit:"g/d",  },
    "Tl_influent"         :  {value:Outputs.Tl.influent,         unit:"g/d",  },
    "Tl_effluent_water"   :  {value:Outputs.Tl.effluent.water,   unit:"g/d",  },
    "Tl_effluent_air"     :  {value:Outputs.Tl.effluent.air,     unit:"g/d",  },
    "Tl_effluent_sludge"  :  {value:Outputs.Tl.effluent.sludge,  unit:"g/d",  },
    "V_influent"          :  {value:Outputs.V.influent,          unit:"g/d",  },
    "V_effluent_water"    :  {value:Outputs.V.effluent.water,    unit:"g/d",  },
    "V_effluent_air"      :  {value:Outputs.V.effluent.air,      unit:"g/d",  },
    "V_effluent_sludge"   :  {value:Outputs.V.effluent.sludge,   unit:"g/d",  },
    "W_influent"          :  {value:Outputs.W.influent,          unit:"g/d",  },
    "W_effluent_water"    :  {value:Outputs.W.effluent.water,    unit:"g/d",  },
    "W_effluent_air"      :  {value:Outputs.W.effluent.air,      unit:"g/d",  },
    "W_effluent_sludge"   :  {value:Outputs.W.effluent.sludge,   unit:"g/d",  },
    "Zn_influent"         :  {value:Outputs.Zn.influent,         unit:"g/d",  },
    "Zn_effluent_water"   :  {value:Outputs.Zn.effluent.water,   unit:"g/d",  },
    "Zn_effluent_air"     :  {value:Outputs.Zn.effluent.air,     unit:"g/d",  },
    "Zn_effluent_sludge"  :  {value:Outputs.Zn.effluent.sludge,  unit:"g/d",  },
  };
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

  //return
  //console.log(Result); //debugging
  return Result;
}

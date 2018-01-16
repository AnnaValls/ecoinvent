/*
 * Main backend function for outputs (table 3.1)
 * TODO: refactoring needed to execute "n" simulations
 */

function compute_elementary_flows() {
  //get the technologies that the user has activated
  var is_BOD_active = getInput("BOD",true).value;
  var is_Nit_active = getInput("Nit",true).value;
  var is_Des_active = getInput("Des",true).value;
  var is_BiP_active = getInput("BiP",true).value;
  var is_ChP_active = getInput("ChP",true).value;

  //reset Variables object
  Variables=[];

  //starting point: bod removal has to be always active. If not: do nothing
  if(is_BOD_active==false){
    console.log('BOD REMOVAL IS INACTIVE: nothing will be calculated');
    Inputs_to_be_hidden=[];
    return;
  }

  //new empty object to store results for each technology
  var Result = { Fra:{}, BOD:{}, Nit:{}, SST:{}, Des:{}, BiP:{}, ChP:{} }; 

  //get all ww characteristics
  var Q              = getInput('Q').value; //22700
  var T              = getInput('T').value; //12
  var COD            = getInput('COD').value; //300
  var sCOD           = getInput('sCOD').value; //132
  var BOD            = getInput('BOD').value; //140
  var sBOD           = getInput('sBOD').value; //70
  var bCOD_BOD_ratio = getInput('bCOD_BOD_ratio').value; //1.6
  var TSS            = getInput('TSS').value; //70
  var VSS            = getInput('VSS').value; //60
  var TKN            = getInput('TKN').value; //35
  var Alkalinity     = getInput('Alkalinity').value; //140
  var TP             = getInput('TP').value; //6
  var TS             = getInput('TS').value; //0 for now

  //get all design parameters
  var SRT                  = getInput('SRT').value; //5
  var MLSS_X_TSS           = getInput('MLSS_X_TSS').value; //3000
  var zb                   = getInput('zb').value; //500
  var Pressure             = getInput('Pressure').value; //95600
  var Df                   = getInput('Df').value; //4.4
  var C_L                  = getInput('DO').value; //2.0 warning: name changed to "DO"
  var SF                   = getInput('SF').value; //1.5
  var Ne                   = getInput('Ne').value; //0.50
  var sBODe                = getInput('sBODe').value; //3
  var TSSe                 = getInput('TSSe').value; //10
  var Anoxic_mixing_energy = getInput('Anoxic_mixing_energy').value; //5
  var NO3_eff              = getInput('NO3_eff').value; //6
  var SOR                  = getInput('SOR').value; //24
  var X_R                  = getInput('X_R').value; //8000
  var clarifiers           = getInput('clarifiers').value; //3
  var TSS_removal_wo_Fe    = getInput('TSS_removal_wo_Fe').value; //60
  var TSS_removal_w_Fe     = getInput('TSS_removal_w_Fe').value; //75
  var C_PO4_eff            = getInput('C_PO4_eff').value; //0.1
  var FeCl3_solution       = getInput('FeCl3_solution').value; //37
  var FeCl3_unit_weight    = getInput('FeCl3_unit_weight').value; //1.35
  var days                 = getInput('days').value; //15

  //these three inputs had an equation but they are now inputs again
  var rbCOD                = getInput('rbCOD').value; //80 g/m3
  var VFA                  = getInput('VFA').value; //15 g/m3
  //var C_PO4_inf          = getInput('C_PO4_inf').value; //5 g/m3

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

  //lcorominas requested hiding these inputs from frontend. I've moved them to Variables
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

  /* 
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
   */

  //Outputs.COD
  Outputs.COD.influent       = Q*COD;
  Outputs.COD.effluent.water = sCODe + Qe*VSSe*1.42;
  Outputs.COD.effluent.air   = (function(){
    /* 
     * CARBONACEOUS DEMAND
     * TO BE REVISED | CODED IN 2018-01-16
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
    console.log("CARBONACEOUS DEMAND DISCUSSION");
    var Oxygen_credit = 2.86*Q*(NOx-NO3_eff);
    console.log("  O2 credit: "+Oxygen_credit/1000+" kg/d");
    var QNOx457 = 4.57*Q*NOx;
    console.log("  4.57·Q·NOx: "+QNOx457/1000+" kg/d");

    if(is_Des_active){
      return Result.Des.OTRf.value*24*1000 - 4.57*Q*NOx + 2.86*Q*(NOx-NO3_eff); //from kg/h to g/d
      //  OTRf                            = Q*(S0-S) - 1.42*P_X_bio_VSS_without_nitrifying + 4.57*Q*NOx - Oxygen_credit;
      //  P_X_bio_VSS_without_nitrifying  = Q*YH*(S0-S)/(1+bHT*SRT) + fd*bHT*Q*YH*(S0-S)*SRT/(1+bHT*SRT)
      //  Oxygen_credit                   = 2.86*Q*(NOx-Ne);
    }
    else if(is_Nit_active){ //error: 5.89%
      return Result.Nit.OTRf.value*24*1000 - 4.57*Q*NOx; //from kg/h to g/d
      //  OTRf                            = Q*(S0-S) - 1.42*P_X_bio_VSS_without_nitrifying + 4.57*Q*NOx
      //  P_X_bio_VSS_without_nitrifying  = Q*YH*(S0-S)/(1+bHT*SRT) + fd*bHT*Q*YH*(S0-S)*SRT/(1+bHT*SRT)
    }else if(is_BOD_active){ //error: 10.32%
      return Result.BOD.OTRf.value*24*1000; //from kg/h to g/d
      //  OTRf                            = Q*(S0-S) - 1.42*P_X_bio
      //  P_X_bio                         = Q*YH*(S0-S)/(1+bHT*SRT) + fd*bHT*Q*YH*(S0-S)*SRT/(1+bHT*SRT)
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

  //fill summary tables (section 3.3) (TODO move to frontend: refactoring needed)
  (function fill_summary_tables(){
    //fill a element id from div#summary with a Result[tec][field].value 
    function fill(id,tec,field){
      var value = Result[tec][field] ? Result[tec][field].value : 0;
      var el=document.querySelector('div#summary #'+id);

      if(value==0){
        el.innerHTML=0;
        el.parentNode.style.color='#aaa'; 
        return;
      }
      else el.parentNode.style.color='';

      var unit  = Result[tec][field] ? Result[tec][field].unit  : "";
      if(el)el.innerHTML=format(value)+" "+unit.prettifyUnit();
    }

    //fill design summary elements
    (function(){
      //calc auxiliary technology results
      var SOTR = is_Des_active? Result.Des.SOTR.value : (is_Nit_active ? Result.Nit.SOTR.value : Result.BOD.SOTR.value);
      var SAE = 4; //kgO2/kWh

      //manually add equations from lcorominas pdf to Result
      Result.lcorominas={
        'Qwas':    {value:Qwas,     unit:"m3/d",      descr:"Wastage flow"},
        'SRT':     {value:SRT,      unit:"d",         descr:getInputById('SRT').descr},
        'SAE':     {value:SAE,      unit:"kg_O2/kWh", descr:"Conversion from kgO2 to kWh"},
        'O2_power':{value:SOTR/SAE, unit:"kW",        descr:"Power needed for aeration"},
        'V_total': {value:V_total,  unit:"m3",        descr:"Total reactor volume"},
      };

      fill('V_aer', (is_Nit_active?'Nit':'BOD'), 'V');
      fill('V_nox','Des','V_nox'); //V anoxic
      fill('V_ana','BiP','V'); //V anaerobic
      fill('V_total','lcorominas','V_total'); //V total
      fill('Area','SST','Area'); //Settler
      fill('Qwas','lcorominas', 'Qwas'); //lcorominas
      fill('SRT','lcorominas', 'SRT'); //lcorominas
      fill('QR','SST','QR');
      fill('alkalinity_added',   'Nit', 'alkalinity_added');
      fill('Mass_of_alkalinity_needed','Des', 'Mass_of_alkalinity_needed');
      fill('FeCl3_volume','ChP','FeCl3_volume');
      fill('storage_req_15_d','ChP','storage_req_15_d');
      fill('air_flowrate',is_Des_active?'Des':(is_Nit_active?'Nit':'BOD'),'air_flowrate');
      fill('OTRf',        is_Des_active?'Des':(is_Nit_active?'Nit':'BOD'),'OTRf');
      fill('SOTR',        is_Des_active?'Des':(is_Nit_active?'Nit':'BOD'),'SOTR');
      fill('SAE','lcorominas','SAE');
      fill('O2_power','lcorominas','O2_power');
      fill('SDNR','Des','SDNR');
      fill('Power','Des','Power');
    })();
  })();

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
}

/*
 * Auxiliar Data Structures
 */
//[]: for storing input ids (strings) that have equations in lcorominas pdf equations
var Inputs_to_be_hidden=[]; //declared here to be visible by frontend

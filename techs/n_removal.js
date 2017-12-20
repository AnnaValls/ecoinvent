/* 
 * Technology: N removal
 * Metcalf & Eddy, Wastewater Engineering, 5th ed., 2014:
 * page 810
 */
function N_removal(Q,T,BOD,bCOD,rbCOD,NOx,Alkalinity,MLVSS,Aerobic_SRT,Aeration_basin_volume,Aerobic_T,Anoxic_mixing_energy,RAS,Ro,NO3_eff,Df,zb,C_L,Pressure){
  /*
    | Inputs                 | example values | unit 
    |------------------------+----------------+-----------------------------
    | Q                      | 22700          | m3/d
    | T                      | 12             | ºC
    | BOD                    | 140            | g/m3
    | bCOD                   | 224            | g/m3
    | rbCOD                  | 80             | g/m3
    | NOx                    | 28.9           | g/m3
    | Alkalinity             | 140            | g/m3 as CaCO3
    | MLVSS                  | 2370           | g/m3
    | Aerobic_SRT            | 21             | d
    | Aeration_basin_volume  | 13410          | m3
    | Aerobic_T              | 14.2           | h (tau detention time)
    | Anoxic_mixing_energy   | 5              | kW/1000 m3
    | RAS                    | 0.6            | unitless
    | Ro                     | 275.9          | kgO2/h
    | NO3_eff                | 6              | g/m3 (nitrate at effluent)
    | Df                     | 4.4            | m
    | zb                     | 500            | m
    | C_L                    | 2.0            | mg/L
    | Pressure               | 95600          | Pa
    |------------------------+----------------+-----------------------------
  */

  /*SOLUTION*/

  //name change for effluent N
  var Ne=NO3_eff; 

  //correct bH by temperature
  var bHT=bH*Math.pow(1.04,T - 20); //1/d

  //1 -- determine active biomass concentration (eq. 7-42)
  var Xb = Q*Aerobic_SRT*YH*bCOD/(1 + bHT*Aerobic_SRT)/Aeration_basin_volume; //1267 g/m3

  //2 -- determine IR ratio
  var IR = NOx/Ne - 1 - RAS; //3.2 (unitless)

  //3 -- determine the amount of NO3-N fed to the anoxic tank
  var Flowrate_to_anoxic_tank = Q*(IR + RAS); //82,260 m3/d
  var NOx_feed = Flowrate_to_anoxic_tank*Ne; //517,560 g/d

  //4 -- determine the anoxic volume ("V_nox=tau*Q"). 
  //First approximation for tau (detention time) is 20% of Aerobic tau.
  //next section is for finding an appropiate tau that satisfies NOx_feed ~ NO_r  
  //this is useful for finding a correct reactor volume (since "V_nox=tau*Q")

  //initialize some variables 
  var tau,V_nox,FM_b,b0=0,b1=0,SDNR_b,SDNR_T,SDNR_adj,SDNR,NO_r;
  var difference_NOr_NOx;

  (function(){
    //first approximation: tau is 20% of the Aerobic tau (page 811)
    tau = 0.20*Aerobic_T/24; //d

    //approximation of V_nox
    V_nox = tau*Q; //m3

    //now we have V_nox: we can calculate NO_r and compare it to NOx_feed, and repeat this process until they are similar

    //counters for iterations
    var iterations=0; 
    var max_iterations=100;

    //loop until tau makes NO_r similar to NOx_feed (between 0% and 20%)
    while(true){
      console.log('New iteration -- V_nox sizing (iteration: '+iterations+')');

      //recalculate tau from V_nox
      tau = V_nox/Q;
      console.log('  V_nox: '+V_nox+' m3');
      console.log('  tau: '+tau+' days');

      //check if tau is positive
      if(tau<0){
        console.error('tau cannot be negative. unexpected error. please report');
        break;
      }

      //5 -- determine F/Mb using (eq. 8-56)
      FM_b = Q*BOD/(V_nox*Xb); //g/g·d
      console.log("F/Mb = "+FM_b);

      //6 -- determine SDNR using (eq. 8-57)
      if(FM_b>0.50){
        //table 8-22, page 806:
        //get b0 and b1 from the percentage of rbCOD/bCOD
        //b0 and b1 are used to calculate SDNR_b
        var Table8_22=[
          {rbCOD:0 ,b0:0.186,b1:0.078},
          {rbCOD:10,b0:0.186,b1:0.078},
          {rbCOD:20,b0:0.213,b1:0.118},
          {rbCOD:30,b0:0.235,b1:0.141},
          {rbCOD:40,b0:0.242,b1:0.152}, //note: G. Ekama has b0:0.252 instead of 0.242
          {rbCOD:50,b0:0.270,b1:0.162},
        ];

        //compute the fraction of rbCOD to find b0 and b1 in the table 8-22
        var Fraction_of_rbCOD = Math.max(0,Math.min(50,Math.floor(100*rbCOD/bCOD))); //min:0, max:50 (for the lookup table)

        //round the fraction of rbCOD to 0, 10, 20, 30, 40 or 50.
        Fraction_of_rbCOD -= Fraction_of_rbCOD%10; 
        //console.log("Fraction of rbCOD (rounded): "+Fraction_of_rbCOD+"%");

        //fetch b0 and b1 from the table. it will work always because Fraction is 0,10,20,30,40 or 50
        b0=Table8_22.filter(row=>{return row.rbCOD==Fraction_of_rbCOD})[0].b0;
        b1=Table8_22.filter(row=>{return row.rbCOD==Fraction_of_rbCOD})[0].b1;
        //console.log(" b0: "+b0);
        //console.log(" b1: "+b1);

        SDNR_b = b0 + b1*Math.log(FM_b); //gNO3-N/gMLVSS,biomass·d
        //note: Math.log(x) in javascript is equal to ln(x)
      }else{
        console.log('since [F/M_b]<0.50  -->  SDNR_b = 0.24*[F/M_b]');
        SDNR_b = 0.24*FM_b; //gNO3-N/gMLVSS,biomass·d
      }

      /*IR and temperature correction for SDNR (page 808)*/

      //temperature correction
      SDNR_T = SDNR_b * Math.pow(1.026,T-20) //g/g·d

      //note: book says 'if F/Mb is less than or equal to 1.0 no correction is required'
      if(FM_b<=1.0){
        SDNR_adj = SDNR_T; //g/g·d [no correction required]
      }else{
        if(IR<=2){
          SDNR_adj = SDNR_T - 0.0166*Math.log(FM_b) - 0.078; //g/g·d (Eq. 8.59)
        }else{
          SDNR_adj = SDNR_T - 0.0290*Math.log(FM_b) - 0.012; //g/g·d  (Eq. 8-60)
        }
      }

      //7 -- overall SDNR based on MLVSS
      SDNR = SDNR_adj*Xb/MLVSS; //g/g·d

      //8 -- amount of NO3-N that can be reduced (eq. 8-51)
      NO_r = V_nox*SDNR_adj*Xb; //g/d

      //calculate difference between NO_r and NOx_feed (percentage)
      //NO_r should be greater than NO_x feed because NO_r is the amount of NO3-N that can be reduced by the system
      //and NOx_feed is the NO3-N that goes into
      //(if difference is negative => NOx_feed > NO_r)
      difference_NOr_NOx = (1 - NOx_feed/NO_r)*100;
      //debugging info
      console.log("NOx_feed vs NO_r - difference: "+difference_NOr_NOx+" %");

      //check if we did too much iterations
      iterations++;
      if(iterations>max_iterations){
        console.warn('max iterations reached ('+max_iterations+')');
        break;
      }

      //check difference to decide if we can exit the loop
      //"the difference should be between 0% and 20%" (page 812, section 8)
      //  if it's under 0%, we should increase V_nox (increase tau), so the system can remove at least "NOx_feed"
      //  if it's over 20%, we should decrease V_nox (decrease tau).
      var delta_V_nox=25; //m3 (make iterations in steps of 'delta' m3 (increase/decrease depending on difference))
      var accepted_max_difference=5; //% I'm trying 5% instead of 20%. This is the max percentage that NO_r can be above NOx_feed
      
      if(0 <= difference_NOr_NOx && difference_NOr_NOx <= accepted_max_difference){
        //exit the loop: we are ok
        console.log("Difference[NOr][NOx] is acceptable ("+difference_NOr_NOx+" %)")
        break;
      }else if(difference_NOr_NOx < 0){
        //increase V_nox
        V_nox+=delta_V_nox;
      }else if(difference_NOr_NOx > accepted_max_difference){
        //decrease V_nox
        V_nox-=delta_V_nox;
      }
    }
  })();//end loop for finding V_nox volume (m3)

  //9
  var Oxygen_credit = 2.86*(NOx-Ne)*Q/1000/24; //kg/h
  var Net_O2_required = Ro - Oxygen_credit; //kg/h

  //Aeration
  //9 bis -- (expansion for solving SOTR (to find air flow rate, m3/min))
  //find: OTRf,SOTR,and air_flowrate

  //ON EVALUATION OF ALPHA CORRECTION FACTOR FOR SOTR
  //page 424: Values of alpha vary with the type of aeration device, the concentration of MLVSS,
  //the basin geometry,the degree of mixing, and other wastewater characteristics, [...].
  //Values of alpha vary from about 0.3 to 1.2. Typically values for diffused and mechanical aeration
  //equipment, discussed in the following section, are in the range of 0.4 to 0.8, and 0.6 to 1.2,
  //respectively. EPA's design manual -fine pore aeration systems (US EPA, 1989) includes alpha
  //values collected during full scale tests on fine pore aeration systems. If the basin geometry in which the aeration
  //device is to be used is significantly different from that used to test the device, great care must
  //be exercised in selecting the appropiate alpha value.
  //
  // FORMULA: alpha = kLa[wastewater] / kLa[tap_water]
  //
  var alpha = 0.65; //ask George Ekama for this value. TODO
  var beta = 0.95; //value 0.95 is ok

  //page 761
  var C_T = air_solubility_of_oxygen(T,0); //elevation is 0 meters - TableE-1, Appendix E, implemented in "utils.js"
  var OTRf = Net_O2_required; //kg/h
  var C_inf_20 = C_s_20 * (1+de*Df/Pa); //mgO2/L
  var Pb = Pa*Math.exp(-g*M*(zb-0)/(R*(273.15+T))); //pressure at plant site (m)
  var SOTR = (OTRf/alpha/F)*(C_inf_20/(beta*C_T/C_s_20*Pb/Pa*C_inf_20-C_L))*(Math.pow(1.024,20-T)); //kg/h
  var kg_O2_per_m3_air = density_of_air(T,Pressure)*0.2318; //oxygen in air by weight is 23.18%, by volume is 20.99%
  var air_flowrate = SOTR/(E*60*kg_O2_per_m3_air);

  //10
  var Alkalinity_used = 7.14*NOx; //g/m3
  var Alkalinity_produced = 3.57*(NOx-Ne); //g/m3
  var Alk_to_be_added = 70 - Alkalinity + Alkalinity_used - Alkalinity_produced; //g/m3
  var Mass_of_alkalinity_needed = Alk_to_be_added * Q /1000; //kg/d as CaCO3

  //11
  var Power = V_nox * Anoxic_mixing_energy / 1000; //kW

  //end N removal

  return {
    Xb:                         {value:Xb,                         unit:"g/m3",           descr:"Active biomass concentration"},
    IR:                         {value:IR,                         unit:"&empty;",        descr:"IR ratio"},
    Flowrate_to_anoxic_tank:    {value:Flowrate_to_anoxic_tank,    unit:"m3/d",           descr:"Flowrate_to_anoxic_tank"},
    NOx_feed:                   {value:NOx_feed,                   unit:"g/d",            descr:"Amount of NO3-N fed to the anoxic tank"},
    tau:                        {value:tau,                        unit:"d",              descr:"tau detention time"},
    V_nox:                      {value:V_nox,                      unit:"m3",             descr:"Anoxic volume"},
    FM_b:                       {value:FM_b,                       unit:"g/g·d",          descr:"F/Mb"},
    Fraction_of_rbCOD:          {value:100*rbCOD/bCOD,             unit:"%",              descr:"Fraction_of_rbCOD"},
    b0:                         {value:b0,                         unit:"g/g·d",          descr:"b0 (needed for SDNR)"},
    b1:                         {value:b1,                         unit:"g/g·d",          descr:"b1 (needed for SDNR)"},
    SDNR_b:                     {value:SDNR_b,                     unit:"g/g·d",          descr:"SDNR_b"},
    SDNR_T:                     {value:SDNR_T,                     unit:"g/g·d",          descr:"SDNR_T (corrected by temperature)"},
    SDNR_adj:                   {value:SDNR_adj,                   unit:"g/g·d",          descr:"SDNR_adj (applied recycle correction)"},
    SDNR:                       {value:SDNR,                       unit:"g/g·d",          descr:"Overall SDNR based on MLVSS"},
    NO_r:                       {value:NO_r,                       unit:"g/d",            descr:"Amount of NO3-N that can be reduced"},
    difference_NOr_NOx:         {value:difference_NOr_NOx,         unit:"%",              descr:"Difference between NO_r and NOx_feed (should be between 0% and 20%)"},
    C_T:                        {value:C_T,                        unit:"mg_O2/L",        descr:"Saturated_DO_at_sea_level_and_operating_tempreature"},
    Pb:                         {value:Pb,                         unit:"m",              descr:"Pressure_at_the_plant_site_based_on_elevation,_m"},
    C_inf_20:                   {value:C_inf_20,                   unit:"mg_O2/L",        descr:"Saturated_DO_value_at_sea_level_and_20ºC_for_diffused_aeartion"},
    OTRf:                       {value:OTRf,                       unit:"kg_O2/h",        descr:"O2_demand"},
    SOTR:                       {value:SOTR,                       unit:"kg_O2/h",        descr:"Standard_Oxygen_Transfer_Rate"},
    kg_O2_per_m3_air:           {value:kg_O2_per_m3_air,           unit:"kg_O2/m3",       descr:"kg_O2_per_m3_air"},
    air_flowrate:               {value:air_flowrate,               unit:"m3/min",         descr:"Air_flowrate"},
    Mass_of_alkalinity_needed:  {value:Mass_of_alkalinity_needed,  unit:"kg/d_as_CaCO3",  descr:"Mass_of_alkalinity_needed"},
    Power:                      {value:Power,                      unit:"kW",             descr:"Anoxic zone mixing energy"},
  }
}

/*debugging*/
(function(){
  var debug=false;
  if(debug==false)return;
  var Q                      = 22700;
  var T                      = 12;
  var BOD                    = 140;
  var bCOD                   = 224;
  var rbCOD                  = 80;
  var NOx                    = 28.9;
  var Alkalinity             = 140;
  var MLVSS                  = 2370;
  var Aerobic_SRT            = 21;
  var Aeration_basin_volume  = 13410;
  var Aerobic_T              = 14.2;
  var Anoxic_mixing_energy   = 5;
  var RAS                    = 0.6;
  var Ro                     = 275.9;
  var NO3_eff                = 6;
  var Df                     = 4.4;
  var zb                     = 500;
  var C_L                    = 2.0;
  var Pressure               = 95600;
  var result = N_removal(Q,T,BOD,bCOD,rbCOD,NOx,Alkalinity,MLVSS,Aerobic_SRT,Aeration_basin_volume,Aerobic_T,Anoxic_mixing_energy,RAS,Ro,NO3_eff,Df,zb,C_L,Pressure);
  console.log(result);
})();

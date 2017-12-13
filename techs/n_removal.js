/* 
 * Technology: N removal
 * Metcalf & Eddy, Wastewater Engineering, 5th ed., 2014:
 * page 810
 */
function N_removal(Q,T,BOD,bCOD,rbCOD,NOx,Alkalinity,MLVSS,Aerobic_SRT,Aeration_basin_volume,Aerobic_T,Anoxic_mixing_energy,RAS,Ro,NO3_eff,Df,zb,C_L,Pressure){
	/*
		Inputs                 example values 
		---------------------------------------
		Q                      22700  m3/d
		T                      12     ºC
		BOD                    140    g/m3
		bCOD                   224    g/m3
		rbCOD                  80     g/m3
		NOx                    28.9   g/m3
		Alkalinity             140    g/m3 as CaCO3
		MLVSS                  2370   g/m3
		Aerobic_SRT            21     d
		Aeration_basin_volume  13410  m3
		Aerobic_T              14.2   h (tau detention time)
		Anoxic_mixing_energy   5      kW/1000 m3
		RAS                    0.6    unitless
		Ro                     275.9  kgO2/h
		NO3_eff                6      g/m3 (nitrate at effluent)

    Df              4.4    m
    zb              500    m
    C_L             2.0    mg/L
    Pressure        95600  Pa
		---------------------------------------
	*/

	/*SOLUTION*/

	//name change
	var Ne=NO3_eff; 

	//correct bH by temperature
	var bHT=bH*Math.pow(1.04,T - 20); 
	
	//1
	var Xb = Q*Aerobic_SRT*YH*bCOD/(1 + bHT*Aerobic_SRT)/Aeration_basin_volume; //g/m3
	//2
	var IR = NOx/Ne - 1 - RAS;
	//3
	var Flowrate_to_anoxic_tank = Q*(IR + RAS); //m3/d
	var NOx_feed = Flowrate_to_anoxic_tank*Ne; //g/d
	//4
	var tau = (0.20*Aerobic_T)/24; //d
	var V_nox = tau*Q; //m3
	//5
	var FM_b = Q*BOD/(V_nox*Xb); //g/g·d

	//6
	if(FM_b>0.50){
		//table 8-22, page 806
		var Table8_22=[
			{rbCOD:0 ,b0:0.186,b1:0.078},
			{rbCOD:10,b0:0.186,b1:0.078},
			{rbCOD:20,b0:0.213,b1:0.118},
			{rbCOD:30,b0:0.235,b1:0.141},
			{rbCOD:40,b0:0.242,b1:0.152},
			{rbCOD:50,b0:0.270,b1:0.162},
		];
		//compute the fraction of rbCOD to find b0 and b1 in the table 8-22
		var Fraction_of_rbCOD = Math.max(0,Math.min(50,Math.floor(100*rbCOD/bCOD))); //min:0, max:50 (for the lookup table)
		Fraction_of_rbCOD -= Fraction_of_rbCOD%10; //round to 0,10,20,30,40, or 50.
		console.log("Fraction of rbCOD (rounded): "+Fraction_of_rbCOD+"%");
		//lookup the value in the table
		var b0=Table8_22.filter(row=>{return row.rbCOD==Fraction_of_rbCOD})[0].b0;
		var b1=Table8_22.filter(row=>{return row.rbCOD==Fraction_of_rbCOD})[0].b1;
		console.log(" b0: "+b0);
		console.log(" b1: "+b1);
		var SDNR_b = b0 + b1*Math.log(FM_b); //gNO3-N/gMLVSS,biomass·d
	}else{
		console.log('F/M_b<0.50 => equation for SDNR_b = 0.24*F/M_b');
		var b0=0;//not used
		var b1=0;//not used
		var SDNR_b = 0.24*FM_b;
	}

	//temperature correction
	var SDNR_T = SDNR_b * Math.pow(1.026,T-20) //g/g·d

	//correction for SNDR (page 808)
	if(IR<=1){
		var SDNR_adj = SDNR_T; //g/g·d
	}else if(IR<=3){
		var SDNR_adj = SDNR_T - 0.0166*Math.log(FM_b) - 0.078; //g/g·d (Eq. 8.59)
	}else{
		var SDNR_adj = SDNR_T - 0.0290*Math.log(FM_b) - 0.012; //g/g·d  (Eq. 8-60)
	}

	//7
	var SDNR = SDNR_adj*Xb/MLVSS; //g/g·d
	//8
	var NO_r = V_nox*SDNR_adj*Xb; //g/d
	//9
	var Oxygen_credit = 2.86*(NOx-Ne)*Q/1000/24; //kg/h
	var Net_O2_required = Ro - Oxygen_credit; //kg/h

  //9 -- expansion for solving SOTR
  //Aeration: OTRf,SOTR
  var alpha = 0.65; //verify values from book TODO
  var beta = 0.95; //verify values from book TODO
  var C_T = air_solubility_of_oxygen(T,0); //elevation=0 TableE-1, Appendix E, implemented in "utils.js"
  var OTRf = Net_O2_required; //kg/h
  var C_inf_20 = C_s_20 * (1+de*Df/Pa); //mgO2/L
  var Pb = Pa*Math.exp(-g*M*(zb-0)/(R*(273.15+T))); //pressure at plant site (m)
  var SOTR = (OTRf/alpha/F)*(C_inf_20/(beta*C_T/C_s_20*Pb/Pa*C_inf_20-C_L))*(Math.pow(1.024,20-T)); //kg/h
  var kg_O2_per_m3_air = density_of_air(T,Pressure)*0.2318 //oxygen in air by weight is 23.18%, by volume is 20.99%
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
		NOx_feed:                   {value:NOx_feed,                   unit:"g/d",            descr:"NOx_feed"},
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
    C_T:                        {value:C_T,               unit:"mg_O2/L",      descr:"Saturated_DO_at_sea_level_and_operating_tempreature"},
    Pb:                         {value:Pb,                unit:"m",            descr:"Pressure_at_the_plant_site_based_on_elevation,_m"},
    C_inf_20:                   {value:C_inf_20,          unit:"mg_O2/L",      descr:"Saturated_DO_value_at_sea_level_and_20ºC_for_diffused_aeartion"},
    OTRf:                       {value:OTRf,              unit:"kg_O2/h",      descr:"O2_demand"},
    SOTR:                       {value:SOTR,              unit:"kg_O2/h",      descr:"Standard_Oxygen_Transfer_Rate"},
    kg_O2_per_m3_air:           {value:kg_O2_per_m3_air,  unit:"kg_O2/m3",     descr:"kg_O2_per_m3_air"},
    air_flowrate:               {value:air_flowrate,      unit:"m3/min",       descr:"Air_flowrate"},
		Mass_of_alkalinity_needed:  {value:Mass_of_alkalinity_needed,  unit:"kg/d_as_CaCO3",  descr:"Mass_of_alkalinity_needed"},
		Power:                      {value:Power,                      unit:"kW",             descr:"Anoxic zone mixing energy"},
	}
}

/*node debugging*/
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

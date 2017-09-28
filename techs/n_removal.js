/** 
	Technology: N removal
**/
function N_removal(Q,T,BOD,bCOD,rbCOD,NOx,TP,Alkalinity,MLSS,MLVSS,Aerobic_SRT,Aeration_basin_volume,Aerobic_T,Anoxic_mixing_energy,RAS,Ro,Ne){
	/*
		Inputs                   example values 
		---------------------------------------
			Q                      22700  m3/d
			T                      12     ºC
			BOD                    140    g/m3
			bCOD                   224    g/m3
			rbCOD                  80     g/m3
			NOx                    28.9   g/m3
			TP                     6      g/m3
			Alkalinity             140    g/m3 as CaCO3
			MLSS                   3000   g/m3
			MLVSS                  2370   g/m3
			Aerobic_SRT            21     d
			Aeration_basin_volume  13410  m3
			Aerobic_T              14.2   h (tau detention time)
			Anoxic_mixing_energy   5      kW
			RAS                    0.6    unitless
			Ro                     275.9  kgO2/h
			Ne                     6      g/m3 (nitrate at effluent)
		---------------------------------------
	*/

	//calculated parameters in previous implementations
	var bHT = bH*Math.pow(1.04, T - 20); //correct bH by temperature
	
	//1
	var Xb = Q*Aerobic_SRT*YH*bCOD/(1+bHT*Aerobic_SRT)/Aeration_basin_volume; //g/m3
	//2
	var IR = NOx/Ne - 1 - RAS;
	//3
	var Flowrate_to_anoxic_tank = Q*(IR+RAS); //m3/d
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
	//10
	var Alkalinity_used = 7.14*NOx; //g/m3
	var Alkalinity_produced = 3.57*(NOx-Ne); //g/m3
	var Alk_to_be_added = 70 - Alkalinity + Alkalinity_used - Alkalinity_produced; //g/m3
	var Mass_of_alkalinity_needed = Alk_to_be_added * Q /1000; //kg/d as CaCO3
	//11
	var Power = V_nox * Anoxic_mixing_energy / 1000; //kW
	//end N removal

	//results
	return {
		Xb:                         Xb,
		IR:                         IR,
		Flowrate_to_anoxic_tank:    Flowrate_to_anoxic_tank,
		NOx_feed:                   NOx_feed,
		tau:                        tau,
		V_nox:                      V_nox,
		FM_b:                       FM_b,
		Fraction_of_rbCOD:          100*rbCOD/bCOD,
		b0:                         b0,
		b1:                         b1,
		SDNR_b:                     SDNR_b,
		SDNR_T:                     SDNR_T,
		SDNR_adj:                   SDNR_adj,
		SDNR:                       SDNR,
		NO_r:                       NO_r,
		Net_O2_required:            Net_O2_required,
		Mass_of_alkalinity_needed:  Mass_of_alkalinity_needed,
		Power:                      Power,
	}
}

/*node debugging
*/
(function(){
	var debug=false;
	if(debug==false)return;
	var Q                      = 22700;
	var T                      = 12   ;
	var BOD                    = 140  ;
	var bCOD                   = 224  ;
	var rbCOD                  = 80   ;
	var NOx                    = 28.9 ;
	var TP                     = 6    ;
	var Alkalinity             = 140  ;
	var MLSS                   = 3000 ;
	var MLVSS                  = 2370 ;
	var Aerobic_SRT            = 21   ;
	var Aeration_basin_volume  = 13410;
	var Aerobic_T              = 14.2 ;
	var Anoxic_mixing_energy   = 5    ;
	var RAS                    = 0.6  ;
	var Ro                     = 275.9;
	var Ne                     = 6    ;
	var result=N_removal(Q,T,BOD,bCOD,rbCOD,NOx,TP,Alkalinity,MLSS,MLVSS,Aerobic_SRT,Aeration_basin_volume,Aerobic_T,Anoxic_mixing_energy,RAS,Ro,Ne);
	console.log(result);
})();

/** 
Technology: nitrification
**/
function nitrification(BOD,bCOD_BOD_ratio,sBOD,COD,sCOD,TSS,VSS,Q,T,TKN,SF,zb,Pressure,Df,MLSS_X_TSS,Ne,sBODe,TSSe,Alkalinity){
	/*
		Inputs            example values 
		--------------------------------
			BOD             140 g/m3
			bCOD_BOD_ratio  1.6 g bCOD/g BOD
			sBOD            70 g/m3
			COD             300 g/m3
			sCOD            132 g/m3
			TSS             70 g/m3
			VSS             60 g/m3
			Q               22700 m3/d
			T               12 ºC
			TKN             35 g/m3
			SF              1.5 (unitless)
			zb              500 m
			Pressure        95600 Pa
			Df              4.4 m
			MLSS_X_TSS      3000 g/m3 (design)
			Ne              0.50 g/m3 [NH4 at effluent] (design)
			sBODe           3 g/m3 (design)
			TSSe            10 g/m3 (design)
			Alkalinity      140 g/m3 as CaCO3
		--------------------------------
	*/

	//parameters
		var alpha = 0.65; //8.b
		var beta  = 0.95; //8.b
		var C_T   = air_solubility_of_oxygen(T,0); //elevation=0 TableE-1, Appendix E, implemented in "utils.js"
	//end

	//9 start nitrification
	var bCOD = bCOD_BOD_ratio * BOD;
	var nbCOD = COD - bCOD;
	var nbsCODe = sCOD - bCOD_BOD_ratio * sBOD;
	var nbpCOD = COD - bCOD - nbsCODe;
	var VSS_COD = (COD-sCOD)/VSS;
	var nbVSS = nbpCOD/VSS_COD;

	var mu_max_AOB_T = mu_max_AOB * Math.pow(1.072,T-20);
	var b_AOB_T = b_AOB* Math.pow(1.029,T-20);
	var S_NH4 = Ne;
	var mu_AOB = mu_max_AOB_T * (S_NH4/(S_NH4+K_NH4)) * (C_L/(C_L+K_o_AOB)) - b_AOB_T;

	//10
	var SRT_theoretical = 1/mu_AOB;
	var SRT_design = SF*SRT_theoretical;

	//11
	var bHT = bH * Math.pow(1.04, T - 20); 
	var mu_mT = mu_m * Math.pow(1.07, T - 20);
	var S = Ks * (1+bHT*SRT_design) / (SRT_design*(mu_mT-bHT)-1);
	var NOx = 0.80 * TKN; //aproximation for nitrate, prior to iteration (80% of TKN)

	//biomass first approximation with first NOx concentration aproximation
	var S0 = bCOD;
	var P_X_bio_VSS = Q*YH*(S0-S)/(1+bHT*SRT_design) + fd*bHT*Q*YH*(S0-S)*SRT_design/(1+bHT*SRT_design) + Q*Yn*NOx/(1+b_AOB_T*SRT_design);
	P_X_bio_VSS/=1000;

	//12 iteration for finding more accurate value of NOx (nitrogen oxidized to nitrate)
	var NOx = TKN - Ne - 0.12*P_X_bio_VSS/Q*1000;

	//recalc PXbioVSS with accurate NOx (one iteration)
	var P_X_bio_VSS = Q*YH*(S0-S)/(1+bHT*SRT_design) + fd*bHT*Q*YH*(S0-S)*SRT_design/(1+bHT*SRT_design) + Q*Yn*NOx/(1+b_AOB_T*SRT_design);
	P_X_bio_VSS/=1000;

	//loop for NOx and PXBioVSS calculation
	(function(){
		console.log("=======================================")
		console.log("LOOP FOR NOx and PXbioVSS approximation")
		console.log("=======================================")

		//arrays for approximations
		var NOx_array = [NOx];
		var P_X_bio_VSS_array = [P_X_bio_VSS];

		//max difference
		var tolerance = 0.0001;

		//loop until difference < tolerance
		while(true){
			console.log("- new iteration")
			//increase accuracy of NOx from P_X_bio_VSS
			var last_NOx = TKN - Ne - 0.12*P_X_bio_VSS_array[P_X_bio_VSS_array.length-1]/Q*1000;
			NOx_array.push(last_NOx);
			//recalculate P_X_bio_VSS with NOx approximation
			var last_PX=(Q*YH*(S0-S)/(1+bHT*SRT_design)+fd*bHT*Q*YH*(S0-S)*SRT_design/(1+bHT*SRT_design)+Q*Yn*(last_NOx)/(1+b_AOB_T*SRT_design))/1000
			P_X_bio_VSS_array.push(last_PX);
			console.log("  NOx approximations: "+NOx_array);
			console.log("  PXbioVSS approximations: "+P_X_bio_VSS_array);
			//length of NOx approximations
			var l = NOx_array.length;
			var difference = Math.abs(NOx_array[l-1]-NOx_array[l-2]);
			if(difference<tolerance){
				NOx         = last_NOx;
				P_X_bio_VSS = last_PX;
				console.log('loop finished: difference is small enough ('+difference+')');
				break;
			}
		}
	})();

	//13
	var P_X_VSS = P_X_bio_VSS + Q*nbVSS/1000;
	var P_X_TSS = P_X_bio_VSS/0.85 + Q*nbVSS/1000 + Q*(TSS-VSS)/1000;
	var X_VSS_V = P_X_VSS * SRT_design;
	var X_TSS_V = P_X_TSS * SRT_design;

	//14
	var V = X_TSS_V*1000 / MLSS_X_TSS ;
	var tau = V/Q*24;
	var MLVSS = X_VSS_V/X_TSS_V * MLSS_X_TSS;
	//15
	var FM = Q*BOD/MLVSS/V;
	var BOD_loading = Q*BOD/V/1000;
	//16
	var bCOD_removed = Q*(S0-S)/1000;
	var Y_obs_TSS = P_X_TSS/bCOD_removed*bCOD_BOD_ratio;
	var Y_obs_VSS = P_X_TSS/bCOD_removed*(X_VSS_V/X_TSS_V)*bCOD_BOD_ratio;
	//17
	var P_X_bio_VSS_without_nitrifying = Q*YH*(S0-S)/(1+bHT*SRT_design) + fd*bHT*Q*YH*(S0-S)*SRT_design/(1+bHT*SRT_design);
	P_X_bio_VSS_without_nitrifying /= 1000;
	var R0 = Q*(S0-S)/1000 -1.42*P_X_bio_VSS_without_nitrifying + 4.57*Q*NOx/1000;
	R0 /= 24;
	//18
	var OTRf = R0;
	var C_inf_20 = C_s_20 * (1+de*Df/Pa);
	var Pb = Pa*Math.exp(-g*M*(zb-0)/(R*(273.15+T))); //pressure at plant site (m)
	var SOTR = (OTRf/alpha/F)*(C_inf_20/(beta*C_T/C_s_20*Pb/Pa*C_inf_20-C_L))*(Math.pow(1.024,20-T));
	var kg_O2_per_m3_air = density_of_air(T,Pressure)*0.2318 //oxygen in air by weight is 23.18%, by volume is 20.99%
	var air_flowrate = SOTR/(E*60*kg_O2_per_m3_air);
	//19 alkalinity 
	var alkalinity_to_be_added = 0;
	(function(){
		var alkalinity_used_for_nitrification = 7.14*NOx //g/m3 used as CaCO3
		alkalinity_to_be_added = 70-Alkalinity+alkalinity_used_for_nitrification; //g/m3 as CaCO3
		alkalinity_to_be_added*=Q/1000; // kg/d as CaCO3
		alkalinity_to_be_added*=(84/50); // kg/d as NaHCO3
	})();
	//20 estimate effluent BOD (TODO no incloure a resultats per estalviar un input (sBODe))
	var BOD_eff = sBODe + 0.85*0.85*TSSe;

	return {
		bCOD:                            bCOD,
		nbCOD:                           nbCOD,
		nbsCODe:                         nbsCODe,
		nbpCOD:                          nbpCOD,
		VSS_COD:                         VSS_COD,
		nbVSS:                           nbVSS,
		mu_max_AOB_T:                    mu_max_AOB_T,
		b_AOB_T:                         b_AOB_T,
		mu_AOB:                          mu_AOB,
		SRT_theoretical:                 SRT_theoretical,
		SRT_design:                      SRT_design,
		bHT:                             bHT,
		mu_mT:                           mu_mT,
		S:                               S,
		P_X_bio_VSS:                     P_X_bio_VSS,
		NOx:                             NOx,
		P_X_VSS:                         P_X_VSS,
		P_X_TSS:                         P_X_TSS,
		X_VSS_V:                         X_VSS_V,
		X_TSS_V:                         X_TSS_V,
		V:                               V,
		tau:                             tau,
		MLVSS:                           MLVSS,
		FM:                              FM,
		BOD_loading:                     BOD_loading,
		bCOD_removed:                    bCOD_removed,
		Y_obs_TSS:                       Y_obs_TSS,
		Y_obs_VSS:                       Y_obs_VSS,
		P_X_bio_VSS_without_nitrifying:  P_X_bio_VSS_without_nitrifying,
		OTRf:                            OTRf,
		C_inf_20:                        C_inf_20,
		Pb:                              Pb,
		SOTR:                            SOTR,
		kg_O2_per_m3_air:                kg_O2_per_m3_air,
		air_flowrate:                    air_flowrate,
		alkalinity_to_be_added:          alkalinity_to_be_added,
		BOD_eff:                         BOD_eff,
	};
}

/*node debugging
*/
(function(){
	var debug=false;
	if(debug==false)return;
	var BOD             = 140;
	var bCOD_BOD_ratio  = 1.6;
	var sBOD            = 70;
	var COD             = 300;
	var sCOD            = 132;
	var TSS             = 70;
	var VSS             = 60;
	var Q               = 22700;
	var T               = 12;
	var TKN             = 35;
	var SF              = 1.5;
	var zb              = 500;
	var Pressure        = 95600;
	var Df              = 4.4;
	var MLSS_X_TSS      = 3000;
	var Ne              = 0.50;
	var sBODe           = 3;
	var TSSe            = 10;
	var Alkalinity      = 140;
	var result = nitrification(BOD,bCOD_BOD_ratio,sBOD,COD,sCOD,TSS,VSS,Q,T,TKN,SF,zb,Pressure,Df,MLSS_X_TSS,Ne,sBODe,TSSe,Alkalinity);
	console.log(result);
})();

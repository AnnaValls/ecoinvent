/** 
	Technology: BOD removal only 
**/

function bod_removal_only(BOD,sBOD,COD,sCOD,TSS,VSS,bCOD_BOD_ratio,Q,T,SRT,MLSS_X_TSS,zb,Pressure,Df){
	/*
		inputs (14): 
			BOD            g/m3
			sBOD           g/m3
			COD            g/m3
			sCOD           g/m3
			TSS            g/m3
			VSS            g/m3
			bCOD_BOD_ratio g bCOD / g BOD
			Q              m3/d
			T              ºC
			SRT            d
			MLSS_X_TSS     g/m3
			zb             m
			Pressure       Pa
			Df             m
	*/
	//tabulated parameters (constants)
		var YH     = 0.45;
		var Ks     = 8;
		var mu_m   = 6;
		var bH     = 0.12;
		var fd     = 0.15;
		var Pa     = 10.33; //m standard pressure at sea level
		var R      = 8314;  //kg*m2/s2*kmol*K (ideal gases constant)
		var g      = 9.81;  //m/s2 (gravity)
		var M      = 28.97; //g/mol (air molecular weight)
		var alpha  = 0.50;  //8.b
		var beta   = 0.95;  //8.b
		var F      = 0.9;   //8.b fouling factor
		var C_s_20 = 9.09;  //8.b sat DO at sea level at 20ºC
		var de     = 0.40;  //8.b mid-depth correction factor (range: 0.25 - 0.45)
		var C_L    = 2.0;   //DO in aeration basin (mg/L)
		var E      = 0.35;  //O2 transfer efficiency
		var C_T    = air_solubility_of_oxygen(T,0); //elevation=0 TableE-1, Appendix E, implemented in "utils.js"
	//end

	/*compute results*/
	//part A: bod removal without nitrification
		var bCOD = bCOD_BOD_ratio * BOD;
		var nbCOD = COD - bCOD;
		var nbsCODe = sCOD - bCOD_BOD_ratio * sBOD;
		var nbpCOD = COD - bCOD - nbsCODe;
		var VSS_COD = (COD-sCOD)/VSS;
		var nbVSS = nbpCOD/VSS_COD;
		var iTSS = TSS - VSS;
		var S0 = bCOD;
		var mu_mT = mu_m * Math.pow(1.07, T - 20);
		var bHT = bH * Math.pow(1.04, T - 20); 
		var S = Ks*(1+bHT*SRT)/(SRT*(mu_mT-bHT)-1);
		var P_X_bio = (Q*YH*(S0 - S) / (1 + bHT*SRT) + (fd*bHT*Q*YH*(S0 - S)*SRT) / (1 + bHT*SRT))/1000;
		//3
		var P_X_VSS = P_X_bio + Q*nbVSS/1000;
		var P_X_TSS = P_X_bio/0.85 + Q*nbVSS/1000 + Q*(TSS-VSS)/1000;
		//4
		var X_VSS_V = P_X_VSS*SRT;
		var X_TSS_V = P_X_TSS*SRT;
		var V = X_TSS_V*1000/MLSS_X_TSS;
		var tau = V*24/Q;
		var MLVSS = X_VSS_V/X_TSS_V * MLSS_X_TSS;
		//5
		var FM = Q*BOD/MLVSS/V;
		var BOD_loading = Q*BOD/V/1000;
		//6
		var bCOD_removed = Q*(S0-S)/1000;
		var Y_obs_TSS = P_X_TSS/bCOD_removed*bCOD_BOD_ratio;
		var Y_obs_VSS = P_X_TSS/bCOD_removed*(X_VSS_V/X_TSS_V)*bCOD_BOD_ratio;
		//7
		var NOx=0;
		var R0 = (Q*(S0-S)/1000 -1.42*P_X_bio)/24 + 0; //NOx is zero here
		//8
		var Pb = Pa*Math.exp(-g*M*(zb-0)/(R*(273.15+T))); //pressure at plant site
		var C_inf_20 = C_s_20 * (1+de*Df/Pa);
		var OTRf = R0;
		var SOTR = (OTRf/(alpha*F))*(C_inf_20/(beta*C_T/C_s_20*Pb/Pa*C_inf_20-C_L))*(Math.pow(1.024,20-T));
		var kg_O2_per_m3_air = density_of_air(T,Pressure)*0.2318 //oxygen in air by weight is 23.18%, by volume is 20.99%
		var air_flowrate = SOTR/(E*60*kg_O2_per_m3_air);
	//end part A

	//create return object
	var Results={
		bCOD:             bCOD,
		nbCOD:            nbCOD,
		nbsCODe:          nbsCODe,
		nbpCOD:           nbpCOD,
		VSS_COD:          VSS_COD,
		nbVSS:            nbVSS,
		iTSS:             iTSS,
		mu_mT:            mu_mT,
		bHT:              bHT,
		S:                S,
		P_X_bio:          P_X_bio,
		P_X_VSS:          P_X_VSS,
		P_X_TSS:          P_X_TSS,
		X_VSS_V:          X_VSS_V,
		X_TSS_V:          X_TSS_V,
		V:                V,
		tau:              tau,
		MLVSS:            MLVSS,
		FM:               FM,
		BOD_loading:      BOD_loading,
		bCOD_removed:     bCOD_removed,
		Y_obs_TSS:        Y_obs_TSS,
		Y_obs_VSS:        Y_obs_VSS,
		Pb:               Pb,
		C_inf_20:         C_inf_20,
		OTRf:             OTRf,
		SOTR:             SOTR,
		kg_O2_per_m3_air: kg_O2_per_m3_air,
		air_flowrate:     air_flowrate,
	};
	return Result;
};

//test
(function(){
	var BOD            = 140;
	var sBOD           = 70;
	var COD            = 300;
	var sCOD           = 132;
	var TSS            = 70;
	var VSS            = 60;
	var bCOD_BOD_ratio = 1.6;
	var Q              = 22700;
	var T              = 12;
	var SRT            = 5;
	var MLSS_X_TSS     = 3000;
	var zb             = 500;
	var Pressure       = 95600;
	var Df             = 4.4;
	var result = bod_removal_only(BOD,sBOD,COD,sCOD,TSS,VSS,bCOD_BOD_ratio,Q,T,SRT,MLSS_X_TSS,zb,Pressure,Df);
	console.log(result)
}

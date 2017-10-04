/** 
Technology: BOD removal only 
**/
function bod_removal_only(BOD,sBOD,COD,sCOD,TSS,VSS,bCOD_BOD_ratio,Q,T,SRT,MLSS_X_TSS,zb,Pressure,Df){
	/*
		Inputs            example values 
		--------------------------------
			BOD             140    g/m3
			sBOD            70     g/m3
			COD             300    g/m3
			sCOD            132    g/m3
			TSS             70     g/m3
			VSS             60     g/m3
			bCOD_BOD_ratio  1.6    g bCOD/g BOD
			Q               22700  m3/d
			T               12     ºC
			SRT             5      d
			MLSS_X_TSS      3000   g/m3
			zb              500    m
			Pressure        95600  Pa
			Df              4.4    m
		--------------------------------
	*/
	//parameters
		var alpha  = 0.50;  //8.b
		var beta   = 0.95;  //8.b
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
		var C_T = air_solubility_of_oxygen(T,0); //elevation=0 TableE-1, Appendix E, implemented in "utils.js"
		var Pb = Pa*Math.exp(-g*M*(zb-0)/(R*(273.15+T))); //pressure at plant site
		var C_inf_20 = C_s_20 * (1+de*Df/Pa);
		var OTRf = R0;
		var SOTR = (OTRf/(alpha*F))*(C_inf_20/(beta*C_T/C_s_20*Pb/Pa*C_inf_20-C_L))*(Math.pow(1.024,20-T));
		var kg_O2_per_m3_air = density_of_air(T,Pressure)*0.2318 //oxygen in air by weight is 23.18%, by volume is 20.99%
		var air_flowrate = SOTR/(E*60*kg_O2_per_m3_air);
	//end part A

	//return object
	return {
		bCOD:              bCOD,
		nbCOD:             nbCOD,
		nbsCODe:           nbsCODe,
		nbpCOD:            nbpCOD,
		VSS_COD:           VSS_COD,
		nbVSS:             nbVSS,
		iTSS:              iTSS,
		mu_mT:             mu_mT,
		bHT:               bHT,
		S:                 S,
		P_X_bio:           P_X_bio,
		P_X_VSS:           P_X_VSS,
		P_X_TSS:           P_X_TSS,
		X_VSS_V:           X_VSS_V,
		X_TSS_V:           X_TSS_V,
		V:                 V,
		tau:               tau,
		MLVSS:             MLVSS,
		FM:                FM,
		BOD_loading:       BOD_loading,
		bCOD_removed:      bCOD_removed,
		Y_obs_TSS:         Y_obs_TSS,
		Y_obs_VSS:         Y_obs_VSS,
		C_T:               C_T,
		Pb:                Pb,
		C_inf_20:          C_inf_20,
		OTRf:              OTRf,
		SOTR:              SOTR,
		kg_O2_per_m3_air:  kg_O2_per_m3_air,
		air_flowrate:      air_flowrate,
	};
};

/*node debugging
*/
(function(){
	var debug=false;
	if(debug==false)return;
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
	console.log(result);
})();

/** 
Technology: Biological P removal
Metcalf & Eddy, Wastewater Engineering, 5th ed., 2014:
page 880
**/
function bio_P_removal(Q,BOD,bCOD,rbCOD,VFA,nbVSS,iTSS,TKN,TP,T,SRT,RAS,rbCOD_NO3_ratio,NOx,NO3_eff){
	/*
		Inputs            example values 
		--------------------------------
			Q                4000  m3/d
			BOD              160   g/m3
			bCOD             250   g/m3
			rbCOD            75    g/m3
			VFA              15    g/m3
			nbVSS            20    g/m3
			iTSS             10    g/m3
			TKN              35    g/m3
			TP               6     g/m3
			T                12    ºC
			SRT              8     d
			RAS              0.5   unitless
			rbCOD_NO3_ratio  5.2   g_rbCOD/g_NO3
			NOx              28    g/m3
			NO3_eff          6     g/m3
		--------------------------------
	*/

	/*SOLUTION*/
	//1
	var Q_rbCOD = Q*rbCOD; //300,000 g/d
	var RQ_NO3_N = 0.50*Q*NO3_eff; //12,000 g/d
	var rbCOD_used_by_NO3 = rbCOD_NO3_ratio * RQ_NO3_N; //62,400 g/d
	var rbCOD_available = Q_rbCOD - rbCOD_used_by_NO3; //237,600 g/d
	//2
	var VFA_rbCOD_ratio = VFA / rbCOD; //0.20 no unit
	var rbCOD_P_ratio = get_rbCOD_P_ratio(VFA_rbCOD_ratio); //15: implemented fig 8-38 at "utils.js"
	var rbCOD_available_normalized = rbCOD_available/Q; //59.4 g/m3
	var P_removal_EBPR = rbCOD_available_normalized/rbCOD_P_ratio; //4 g/m3 (page 881)
	//3
	var bHT = bH*Math.pow(1.04,T-20); //0.088 1/d
	var bnT = bn*Math.pow(1.029,T-20); //0.135 1/d
	var P_X_bio = Q*YH*bCOD/(1+bHT*SRT) + fd*bHT*Q*YH*bCOD*SRT/(1+bHT*SRT) + Q*Yn*NOx/(1+bnT*SRT); //334,134 g/d
	//P_X_bio = 334134; //TODO in metcalf is wrong
	var P_removal_synthesis = 0.015*P_X_bio; //5012 g/d
	var P_removal_synthesis_n = P_removal_synthesis/Q; //1.2 g/m3
	//4
	var Effluent_P = TP - P_removal_EBPR - P_removal_synthesis_n; //0.80 g/m3
	//5
	var P_X_TSS = P_X_bio/0.85 + Q*nbVSS + Q*(iTSS); //433,099 g/d
	//P_X_TSS = 433099; //TODO in metcalf is wrong
	var P_removal_gday = (TP - Effluent_P)*Q; //20,800 g/d
	var P_in_waste_sludge = 100*P_removal_gday/P_X_TSS; //4.8 %

	var P_removal = (TP - Effluent_P); //5 g/m3
	/*end solution*/

	return {
		Q_rbCOD:                     Q_rbCOD,
		RQ_NO3_N:                    RQ_NO3_N,
		rbCOD_used_by_NO3:           rbCOD_used_by_NO3,
		rbCOD_available:             rbCOD_available,
		VFA_rbCOD_ratio:             VFA_rbCOD_ratio,
		rbCOD_P_ratio:               rbCOD_P_ratio,
		rbCOD_available_normalized:  rbCOD_available_normalized,
		P_removal_EBPR:              P_removal_EBPR,
		bHT:                         bHT,
		bnT:                         bnT,
		P_X_bio:                     P_X_bio,
		P_removal_synthesis:         P_removal_synthesis,
		P_removal_synthesis_n:       P_removal_synthesis_n,
		Effluent_P:                  Effluent_P,
		P_X_TSS:                     P_X_TSS,
		P_removal_gday:              P_removal_gday,
		P_in_waste_sludge:           P_in_waste_sludge,
		P_removal:                   P_removal,
	}
}

/*node debugging
*/
(function(){
	var debug=false;
	if(debug==false)return;
	var Q                = 4000;
	var BOD              = 160;
	var bCOD             = 250;
	var rbCOD            = 75;
	var VFA              = 15;
	var nbVSS            = 20;
	var iTSS             = 10;
	var TKN              = 35;
	var TP               = 6;
	var T                = 12;
	var SRT              = 8;
	var RAS              = 0.5;
	var rbCOD_NO3_ratio  = 5.2;
	var NOx              = 28;
	var NO3_eff          = 6;
	var result = bio_P_removal(Q,BOD,bCOD,rbCOD,VFA,nbVSS,iTSS,TKN,TP,T,SRT,RAS,rbCOD_NO3_ratio,NOx,NO3_eff);
	console.log(result);
})();

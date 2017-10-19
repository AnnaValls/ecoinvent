/* 
 * Technology: Biological P removal
 * Metcalf & Eddy, Wastewater Engineering, 5th ed., 2014:
 * page 880
 */
function bio_P_removal(Q,bCOD,rbCOD,VFA,nbVSS,iTSS,TP,T,SRT,rbCOD_NO3_ratio,NOx,NO3_eff){
	/*
		Inputs            example values 
		--------------------------------
			Q                4000  m3/d
			bCOD             250   g/m3
			rbCOD            75    g/m3
			VFA              15    g/m3
			nbVSS            20    g/m3
			iTSS             10    g/m3
			TP               6     g/m3
			T                12    ºC
			SRT              8     d
			rbCOD_NO3_ratio  5.2   g_rbCOD/g_NO3
			NOx              28    g/m3
			NO3_eff          6     g/m3
		--------------------------------
	*/

	var V_anaerobic = 0.75 * Q / 24; //709.4 m3 (tau=0.75h from exercise statement)

	/*SOLUTION*/
	//1
	var Q_rbCOD = Q*rbCOD; //300,000 g/d
	var RQ_NO3_N = 0.50*Q*NO3_eff; //12,000 g/d
	var rbCOD_used_by_NO3 = rbCOD_NO3_ratio * RQ_NO3_N; //62,400 g/d
	var rbCOD_available = Q_rbCOD - rbCOD_used_by_NO3; //237,600 g/d

	//2
	var VFA_rbCOD_ratio = VFA / rbCOD; //0.20 no unit (0.15 in biowin)
	var rbCOD_P_ratio = get_rbCOD_P_ratio(VFA_rbCOD_ratio); //15: implemented fig 8-38 at "utils.js"
	var rbCOD_available_normalized = rbCOD_available/Q; //59.4 g/m3
	var P_removal_EBPR = rbCOD_available_normalized/rbCOD_P_ratio; //4 g/m3 (page 881)

	//3 removal by other heterotrophic bacteria
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

	/*part B 1 skipped, not relevant */
	var P_removal = P_removal_EBPR + P_removal_synthesis_n; //5 g/m3
	/*end solution*/

	return {
		Q_rbCOD:               {value:Q_rbCOD,                     unit:"g/d",      descr:"rbCOD in influent"},
		RQ_NO3_N:              {value:RQ_NO3_N,                    unit:"g/d",      descr:"NO3-N fed to the anaerobic contact zone"},
		rbCOD_used_by_NO3:     {value:rbCOD_used_by_NO3,           unit:"g/d",      descr:"rbCOD_used_by_NO3-N"},
		rbCOD_available:       {value:rbCOD_available,             unit:"g/d",      descr:"rbCOD_available"},
		rbCOD_available_norm:  {value:rbCOD_available_normalized,  unit:"g/m3",     descr:"rbCOD_available_normalized"},
		VFA_rbCOD_ratio:       {value:VFA_rbCOD_ratio,             unit:"&empty;",  descr:"influent_VFA/rbCOD_ratio"},
		rbCOD_P_ratio:         {value:rbCOD_P_ratio,               unit:"&empty;",  descr:"rbCOD/P ratio"},
		P_removal_EBPR:        {value:P_removal_EBPR,              unit:"g/m3",     descr:"P removal by EBPR"},
		bHT:                   {value:bHT,                         unit:"1/d",      descr:"bH corrected by temperature"},
		bnT:                   {value:bnT,                         unit:"1/d",      descr:"bn corrected by temperature"},
		P_X_bio:               {value:P_X_bio,                     unit:"g/d",      descr:"Biomass production"},
		P_removal_synthesis:   {value:P_removal_synthesis,         unit:"g/d",      descr:"P removal (synthesis)"},
		P_removal_synthesis_n: {value:P_removal_synthesis_n,       unit:"g/m3",     descr:"P removal (synthesis) normalized to flowrate"},
		Effluent_P:            {value:Effluent_P,                  unit:"g/m3",     descr:"Effluent P (influent-P_EBPR-P_synth)"},
		P_X_TSS:               {value:P_X_TSS,                     unit:"g/d",      descr:"Total sludge production"},
		P_removal_gday:        {value:P_removal_gday,              unit:"g/d",      descr:"P_removal (g/day)"},
		P_in_waste_sludge:     {value:P_in_waste_sludge,           unit:"%",        descr:"P_in_waste_sludge"},
		P_removal:             {value:P_removal,                   unit:"g/m3",     descr:"Total P removal"},
		V:                     {value:V_anaerobic,                 unit:"m3",       descr:"Anaerobic volume"},
	}
}

/*node debugging */
(function(){
	var debug=false;
	if(debug==false)return;
	var Q                = 4000;
	var bCOD             = 250;
	var rbCOD            = 75;
	var VFA              = 15;
	var nbVSS            = 20;
	var iTSS             = 10;
	var TP               = 6;
	var T                = 12;
	var SRT              = 8;
	var rbCOD_NO3_ratio  = 5.2;
	var NOx              = 28;
	var NO3_eff          = 6;
	var result = bio_P_removal(Q,bCOD,rbCOD,VFA,nbVSS,iTSS,TP,T,SRT,rbCOD_NO3_ratio,NOx,NO3_eff);
	console.log(result);
})();

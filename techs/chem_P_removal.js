/* 
 * Technology: Chemical P removal
 * Metcalf & Eddy, Wastewater Engineering, 5th ed., 2014:
 * page 484
 */
function chem_P_removal(Q,TSS,TSS_removal_wo_Fe,TSS_removal_w_Fe,TP,C_PO4_inf,C_PO4_eff,FeCl3_solution,FeCl3_unit_weight,days){
	/*
		Inputs               example values 
		--------------------------------
			Q                  3800  m3/d
			TSS                220   mg/L
			TSS_removal_wo_Fe  60    %     [not used!]
			TSS_removal_w_Fe   75    %     [not used!]
			TP                 7     mg/L
			C_PO4_inf          5     mg/L
			C_PO4_eff          0.1   mg/L
			FeCl3_solution     37    %
			FeCl3_unit_weight  1.35  kg/L
			days               15    days
		--------------------------------
	*/

	/*parameters*/
	var Fe_P_mole_ratio                  = 3.3; //TODO check if figure 6-13 can be implemented to get this value
	var Raw_sludge_specific_gravity      = 1.03;
	var Raw_sludge_moisture_content      = 94;
	var Chemical_sludge_specific_gravity = 1.05
	var Chemical_sludge_moisture_content = 92.5;

	/*SOLUTION*/
	//1
	var Fe_III_dose = Fe_P_mole_ratio*(C_PO4_inf-C_PO4_eff)*M_Fe/M_P; //mg/L
	//2
	var primary_eff_P = TP - (C_PO4_inf - C_PO4_eff); //mg/L
	//3
	var Fe_dose = Q*Fe_III_dose/1000; //kg/d
	//4
	var percent_Fe_in_FeCl3 = 100*M_Fe/162.3; //%
	var amount_FeCl3_solution = Fe_dose/percent_Fe_in_FeCl3*100; //kg/d
	var FeCl3_volume = amount_FeCl3_solution/(FeCl3_solution/100*FeCl3_unit_weight); //L/d 
	var storage_req_15_d = FeCl3_volume/1000*days; //m3
	//5
	var Additional_sludge = 0.15*TSS*Q/1000; //kg/d   (? 0.15)
	var Fe_dose_M = Fe_III_dose/1000/M_Fe; //M (mol/L)
	var P_removed = (C_PO4_inf - C_PO4_eff)/1000/M_P; //M(mol/L)
	var FeH2PO4OH_sludge = P_removed*251*1000; //mg/L (251 is FeH2PO4OH molecular weight)
	var Excess_Fe_added = Fe_dose_M - 1.6*P_removed; //M (mol/L) (? 1.6)
	var FeOH3_sludge = Excess_Fe_added*(106.8)*1000; //mg/L (106.8 is FeCl3 molecular weight)
	var Excess_sludge = FeH2PO4OH_sludge + FeOH3_sludge; //mg/L
	var Excess_sludge_kg = Q*Excess_sludge/1000; //kg/d
	var Total_excess_sludge = Additional_sludge + Excess_sludge_kg; //kg/d
	//6
	var sludge_production_wo_chemical_addition = Q*TSS*0.6/1000; //kg/d (? 0.6)
	var sludge_production_w_chemical_addition = sludge_production_wo_chemical_addition + Total_excess_sludge; //kg/d
	//7
	var Vs_without = sludge_production_wo_chemical_addition/(Raw_sludge_specific_gravity*1000*(1-Raw_sludge_moisture_content/100)); //m3/d
	//8
	var Vs = sludge_production_w_chemical_addition/(Chemical_sludge_specific_gravity*1000*(1-Chemical_sludge_moisture_content/100)); //m3/d
	/*end solution*/

	return {
		Fe_III_dose:            {value:Fe_III_dose,                             unit:"mg/L",  descr:"Fe_III_dose"},
		primary_eff_P:          {value:primary_eff_P,                           unit:"mg/L",  descr:"primary_effluent"},
		Fe_dose:                {value:Fe_dose,                                 unit:"kg/d",  descr:"Fe_dose_required"},
		percent_Fe_in_FeCl3:    {value:percent_Fe_in_FeCl3,                     unit:"%",     descr:"percent_Fe_in_FeCl3"},
		amount_FeCl3_solution:  {value:amount_FeCl3_solution,                   unit:"kg/d",  descr:"amount_FeCl3_solution"},
		FeCl3_volume:           {value:FeCl3_volume,                            unit:"L/d",   descr:"FeCl3_volume"},
		storage_req_15_d:       {value:storage_req_15_d,                        unit:"m3",    descr:"storage_req_15_d"},
		Additional_sludge:      {value:Additional_sludge,                       unit:"kg/d",  descr:"Additional_sludge"},
		Fe_dose_M:              {value:Fe_dose_M,                               unit:"M",     descr:"Fe_dose_M"},
		P_removed:              {value:P_removed,                               unit:"M",     descr:"P_removed"},
		FeH2PO4OH_sludge:       {value:FeH2PO4OH_sludge,                        unit:"mg/L",  descr:"FeH2PO4OH_sludge"},
		Excess_Fe_added:        {value:Excess_Fe_added,                         unit:"M",     descr:"Excess_Fe_added"},
		FeOH3_sludge:           {value:FeOH3_sludge,                            unit:"mg/L",  descr:"FeOH3_sludge"},
		Excess_sludge:          {value:Excess_sludge,                           unit:"mg/L",  descr:"Excess_sludge"},
		Excess_sludge_kg:       {value:Excess_sludge_kg,                        unit:"kg/d",  descr:"Excess_sludge_kg"},
		Total_excess_sludge:    {value:Total_excess_sludge,                     unit:"kg/d",  descr:"Total_excess_sludge"},
		sludge_prod_without:    {value:sludge_production_wo_chemical_addition,  unit:"kg/d",  descr:"sludge_production_wo_chemical_addition"},
		sludge_prod:            {value:sludge_production_w_chemical_addition,   unit:"kg/d",  descr:"sludge_production_w_chemical_addition"},
		Vs_without:             {value:Vs_without,                              unit:"m3/d",  descr:"Vs_without"},
		Vs:                     {value:Vs,                                      unit:"m3/d",  descr:"Vs"},
	};
}

/*node debugging
*/
(function(){
	var debug=false;
	if(debug==false)return;
	var Q                  = 3800
	var TSS                = 220 
	var TSS_removal_wo_Fe  = 60  
	var TSS_removal_w_Fe   = 75  
	var TP                 = 7   
	var C_PO4_inf          = 5   
	var C_PO4_eff          = 0.1 
	var FeCl3_solution     = 37  
	var FeCl3_unit_weight  = 1.35
	var days               = 15  
	var result = chem_P_removal(Q,TSS,TSS_removal_wo_Fe,TSS_removal_w_Fe,TP,C_PO4_inf,C_PO4_eff,FeCl3_solution,FeCl3_unit_weight,days);
	console.log(result);
})();

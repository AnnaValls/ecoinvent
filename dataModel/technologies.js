/*
 * Data structure
 * Technologies (6):
 *   BOD: bod removal                  (always)
 *   SST: sizing of the clarifier      (always)
 *   Nit: nitrification                (optional)
 *   Des: desnitrification (N removal) (optional)
 *   BiP: biological P removal         (optional)
 *   ChP: chemical P removal           (optional)
 *
 * "Inputs" have the input id list for each tech (see "inputs.js" for more details)
 */

var Technologies = {
	"BOD":{
		Name:"BOD removal",
		File:"bod_removal_only.js",
		Inputs:[ 
			"BOD", "sBOD", "COD", "sCOD", "TSS", "VSS", "bCOD_BOD_ratio",
			"Q", "T", "SRT", "MLSS_X_TSS", "zb", "Pressure", "Df",
		],
	},
	"SST":{
		Name:"SST sizing",
		File:"sst_sizing.js",
		Inputs:[ 
			"Q","SOR","X_R","clarifiers","MLSS_X_TSS",
		],
	},
	"Nit":{
		Name:"Nitrification",
		File:"nitrification.js",
		Inputs:[ 
			"BOD", "bCOD_BOD_ratio", "sBOD", "COD", "sCOD", "TSS", "VSS",
			"Q", "T", "TKN", "SF", "zb", "Pressure",
			"Df", "MLSS_X_TSS", "Ne", "sBODe", "TSSe", "Alkalinity",
		],
	},
	"Des":{
		Name:"Denitrification",
		File:"n_removal.js",
		Inputs:[ 
			"Q", "T", "BOD", "bCOD", "rbCOD", "NOx", "TP", "Alkalinity",
			"MLVSS", "Aerobic_SRT", "Aeration_basin_volume", "Aerobic_T",
			"Anoxic_mixing_energy", "RAS", "Ro", "Ne",
		],
	},
	"BiP":{
		Name:"Bio P removal",
		File:"bio_P_removal.js",
		Inputs:[ 
			"Q", "BOD", "bCOD", "rbCOD", "VFA", "nbVSS", "iTSS", "TKN",
			"TP", "T", "SRT", "RAS", "rbCOD_NO3_ratio", "NOx", "NO3_eff"
		],
	},
	"ChP":{
		Name:"Chem P removal",
		File:"chem_P_removal.js",
		Inputs:[ 
			"Q", "TSS", "TSS_removal_wo_Fe", "TSS_removal_w_Fe", "TP",
			"C_PO4_inf", "C_PO4_eff", "Alkalinity", "FeCl3_solution",
			"FeCl3_unit_weight", "days"
		],
	},
}

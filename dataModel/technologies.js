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
			"BOD", "sBOD", "COD", "sCOD", "TSS", "VSS", 
			"bCOD_BOD_ratio",
			"Q", "T", "SRT", 
			"MLSS_X_TSS", 
			"zb", 
			"Pressure", 
			"Df",
		],
	},
	"Nit":{
		Name:"Nitrification",
		File:"nitrification.js",
		Inputs:[ 
			"BOD", "bCOD_BOD_ratio", "sBOD", "COD", "sCOD", "TSS", "VSS",
			"Q", "T", "zb", "Pressure", "Df", "MLSS_X_TSS", 
			"TKN", 
			"SF", 
			"Ne", 
			"sBODe", 
			"TSSe", 
			"Alkalinity",
		],
	},
	"SST":{
		Name:"SST sizing",
		File:"sst_sizing.js",
		Inputs:[ 
			"Q", "MLSS_X_TSS",
			"SOR",
			"X_R",
			"clarifiers",
		],
	},
	"Des":{
		Name:"Denitrification",
		File:"n_removal.js",
		Inputs:[ 
			"Q", "T", "BOD", "Ne",
			"rbCOD", 
			"Anoxic_mixing_energy", 
			"NO3_eff",
		],
	},
	"BiP":{
		Name:"Bio P removal",
		File:"bio_P_removal.js",
		Inputs:[ 
			"Q", 
			"rbCOD", 
			"VFA", 
			"TP", 
			"T", 
			"SRT",
			"rbCOD_NO3_ratio", 
			"NO3_eff",
		],
	},
	"ChP":{
		Name:"Chem P removal",
		File:"chem_P_removal.js",
		Inputs:[ 
			"Q", 
			"TSS", 
			"TP",
			"TSS_removal_w_Fe", 
			"TSS_removal_wo_Fe", 
			"C_PO4_inf", 
			"C_PO4_eff", 
			"FeCl3_solution",
			"FeCl3_unit_weight", 
			"days"
		],
	},
}

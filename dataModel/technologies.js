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
		Implemented_in:"bod_removal_with_nitrification.php",
		Inputs:[ 
			"Q", 
			"T", 
			"BOD", 
			"sBOD", 
			"COD", 
			"sCOD", 
			"TSS", 
			"VSS", 
			"bCOD_BOD_ratio",
			"SRT", 
			"MLSS_X_TSS", 
			"zb", 
			"Pressure", 
			"Df",
			"C_L",
		],
	},
	"Nit":{
		Name:"Nitrification",
		File:"nitrification.js",
		Implemented_in:"bod_removal_with_nitrification.php",
		Inputs:[ 
			"Q",
			"T",
			"BOD",
			"sBOD",
			"COD",
			"sCOD",
			"TSS",
			"VSS",
			"Alkalinity",
			"bCOD_BOD_ratio",
			"MLSS_X_TSS", 
			"zb",
			"Pressure",
			"Df",
			"TKN", 
			"SF", 
			"Ne", 
			"sBODe", 
			"TSSe", 
			"C_L",
		],
	},
	"SST":{
		Name:"SST sizing",
		File:"sst_sizing.js",
		Implemented_in:"bod_removal_with_nitrification.php",
		Inputs:[ 
			"Q", 
			"MLSS_X_TSS",
			"X_R",
			"SOR",
			"clarifiers",
		],
	},
	"Des":{
		Name:"Denitrification",
		File:"n_removal.js",
		Implemented_in:"N_removal.php",
		Inputs:[ 
			"Q", "T", "BOD", "Ne",
			"rbCOD", 
			"Anoxic_mixing_energy", 
			"NO3_eff",
		],
	},
	"BiP":{
		Name:"Biological P removal",
		File:"bio_P_removal.js",
		Implemented_in:"bio_P_removal.php",
		Inputs:[ 
			"Q", 
			"T", 
			"rbCOD", 
			"VFA", 
			"TP", 
			"SRT",
			"rbCOD_NO3_ratio", 
			"NO3_eff",
		],
	},
	"ChP":{
		Name:"Chemical P removal",
		File:"chem_P_removal.js",
		Implemented_in:"chem_P_removal.php",
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

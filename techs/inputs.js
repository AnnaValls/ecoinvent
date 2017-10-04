/*
 * All inputs organized by technology combination
 * Technologies:
 *   BOD: bod removal
 *   Nit: nitrification
 *   Des: desnitrification (N removal)
 *   BiP: biological P removal
 *   ChP: chemical P removal
 *
 */

/*Inputs by technology alone*/
var Inputs={
	"BOD":[
		"BOD",
		"sBOD",
		"COD",
		"sCOD",
		"TSS",
		"VSS",
		"bCOD_BOD_ratio",
		"Q",
		"T",
		"SRT",
		"MLSS_X_TSS",
		"zb",
		"Pressure",
		"Df",
	],
	"Nit":[
		"BOD",
		"bCOD_BOD_ratio",
		"sBOD",
		"COD",
		"sCOD",
		"TSS",
		"VSS",
		"Q",
		"T",
		"TKN",
		"SF",
		"zb",
		"Pressure",
		"Df",
		"MLSS_X_TSS",
		"Ne",
		"sBODe",
		"TSSe",
		"Alkalinity",
	],
	"Des":[
		"Q",
		"T",
		"BOD",
		"bCOD",
		"rbCOD",
		"NOx",
		"TP",
		"Alkalinity",
		"MLVSS",
		"Aerobic_SRT",
		"Aeration_basin_volume",
		"Aerobic_T",
		"Anoxic_mixing_energy",
		"RAS",
		"Ro",
		"Ne",
	],
	"BiP":[
		"Q",
		"BOD",
		"bCOD",
		"rbCOD",
		"Acetate",
		"nbVSS",
		"iTSS",
		"TKN",
		"P",
		"T",
		"SRT",
		"RAS",
		"tau_aerobic",
		"rbCOD_NO3_ratio",
		"NOx",
		"NO3_eff"
	],
	"ChP":[
		"Q",
		"TSS",
		"TSS_removal_wo_Fe",
		"TSS_removal_w_Fe",
		"C_P_inf",
		"C_PO4_inf",
		"C_PO4_eff",
		"Alkalinity",
		"FeCl3_solution",
		"FeCl3_unit_weight",
		"days"
	],
};

/*Utils*/
//remove duplicate elements in arrays
function uniq(arr){return Array.from(new Set(arr));}
/**/

/*Inputs by technology combination*/
var Combinations={
	"BOD":              Inputs.BOD,
	"BOD+Nit":          uniq(Inputs.BOD.concat(Inputs.Nit)),
	"BOD+Nit+Des":      uniq(Inputs.BOD.concat(Inputs.Nit).concat(Inputs.Des)),
	"BOD+Nit+Des+BiP":  uniq(Inputs.BOD.concat(Inputs.Nit).concat(Inputs.Des).concat(Inputs.BiP)),
	"BOD+Nit+Des+ChP":  uniq(Inputs.BOD.concat(Inputs.Nit).concat(Inputs.Des).concat(Inputs.ChP)),
	"BOD+BiP":          uniq(Inputs.BOD.concat(Inputs.BiP)),
	"BOD+ChP":          uniq(Inputs.BOD.concat(Inputs.ChP)),
};

/*test: count inputs to check if duplicates are removed

for(var tech in Inputs){
	console.log(tech+": "+(Inputs[tech].length+" inputs"));
}
console.log("------------------------");
for(var comb in Combinations){
	console.log(comb+": "+(Combinations[comb].length+" inputs"));
}

*/

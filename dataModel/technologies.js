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
  "Fra":{
    Name:"Fractionation",
    File:"fractionation.js",
    Implemented_in:"bod_removal_with_nitrification.php",
    value:false,
    notActivable:true,
    Inputs:[
      "BOD",
      "sBOD",
      "COD",
      "sCOD",
      "TSS",
      "VSS",
      "bCOD_BOD_ratio",
    ],
  },
	"BOD":{
		Name:"BOD removal",
		File:"bod_removal_only.js",
		Implemented_in:"bod_removal_with_nitrification.php",
    value:true,
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
			"DO",
		],
	},
	"Nit":{
		Name:"Nitrification",
		File:"nitrification.js",
		Implemented_in:"bod_removal_with_nitrification.php",
    value:false,
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
			"DO",
		],
	},
	"Des":{
		Name:"Denitrification",
		File:"n_removal.js",
		Implemented_in:"N_removal.php",
    value:false,
		Inputs:[ 
			"Q", "T", "BOD", "Ne",
			"rbCOD", 
			"Anoxic_mixing_energy", 
			"NO3_eff",
      "Df",
      "zb",
      "DO",
      "Pressure",
		],
	},
	"BiP":{
		Name:"Biological P removal",
		File:"bio_P_removal.js",
		Implemented_in:"bio_P_removal.php",
    value:false,
		Inputs:[ 
			"Q", 
			"T", 
			"rbCOD", 
			"VFA", 
			"TP", 
			"SRT",
			"NO3_eff",
		],
	},
	"ChP":{
		Name:"Chemical P removal",
		File:"chem_P_removal.js",
		Implemented_in:"chem_P_removal.php",
    value:false,
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
  "SST":{
    Name:"SST sizing",
    File:"sst_sizing.js",
    Implemented_in:"bod_removal_with_nitrification.php",
    value:false,
    notActivable:true,
    Inputs:[ 
      "Q", 
      "MLSS_X_TSS",
      "X_R",
      "SOR",
      "clarifiers",
    ],
  },
}

var Technologies_selected = [];
/*
 fix for making it an array like:
 var Technologies_selected=[
   {id:"Fra", value:false, descr:"Fractionation"       }, //not a "real" technology, it turns automatically on with BOD removal
   {id:"BOD", value:true,  descr:"BOD removal"         },
   {id:"Nit", value:false, descr:"Nitrification"       },
   {id:"SST", value:false, descr:"SST sizing"          }, //not a "real" technology, it turns automatically on with BOD removal
   {id:"Des", value:false, descr:"Denitrification"     },
   {id:"BiP", value:false, descr:"Biological P removal"},
   {id:"ChP", value:false, descr:"Chemical P removal"  },
 ];
*/
(function(){
  for(var id in Technologies){
    var value=Technologies[id].value;
    var descr=Technologies[id].Name;
    var notActivable=Technologies[id].notActivable;
    Technologies_selected.push({id,value,notActivable,descr});
  }
})();

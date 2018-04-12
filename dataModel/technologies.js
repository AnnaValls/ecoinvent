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
  "CSO":{
    Name:"Combined Sewer Overflow",
    File:"cso_removal.js",
    Implemented_in:"",
    value:true,
    notActivable:true,
    Inputs:getParamNames(cso_removal),
  },
  "Fra":{
    Name:"Fractionation",
    File:"fractionation.js",
    Implemented_in:"bod_removal_with_nitrification.php",
    value:true,
    notActivable:true,
    Inputs:getParamNames(fractionation), //["BOD","sBOD","COD","bCOD","sCOD","TSS","VSS"]
  },
  "Pri":{
    //Name:"Primary settler <small><issue class=under_dev></issue></small>",
    Name:"Primary settler",
    File:"primary_settler.js",
    Implemented_in:"",
    value:true,
    Inputs:getParamNames(primary_settler),
  },
	"BOD":{
		Name:"BOD removal",
		File:"bod_removal_only.js",
		Implemented_in:"bod_removal_with_nitrification.php",
    value:true,
    Inputs:getParamNames(bod_removal_only),
	},
	"Nit":{
		Name:"Nitrification",
		File:"nitrification.js",
		Implemented_in:"bod_removal_with_nitrification.php",
    value:false,
    Inputs:getParamNames(nitrification),
	},
	"Des":{
		Name:"Denitrification",
		File:"n_removal.js",
		Implemented_in:"N_removal.php",
    value:false,
    Inputs:getParamNames(N_removal),
	},
	"BiP":{
		Name:"Biological P removal",
		File:"bio_P_removal.js",
		Implemented_in:"bio_P_removal.php",
    value:false,
    Inputs:getParamNames(bio_P_removal),
	},
	"ChP":{
		Name:"Chemical P removal",
    comments:"coprecipitation only",
		File:"chem_P_removal.js",
		Implemented_in:"chem_P_removal.php",
    value:false,
    Inputs:getParamNames(chem_P_removal),
	},
  "SST":{
    Name:"Secondary settler sizing",
    File:"sst_sizing.js",
    Implemented_in:"bod_removal_with_nitrification.php",
    value:false,
    notActivable:true,
    Inputs:getParamNames(sst_sizing),
  },
  "Met":{
    Name:"Metals and other elements",
    File:"metals_doka.js",
    Implemented_in:"",
    value:true,
    notActivable:true,
    Inputs:getParamNames(metals_doka),
  },
  "Ene":{
    Name:"Energy consumption",
    File:"energy_consumption.js",
    Implemented_in:"",
    value:true,
    notActivable:true,
    Inputs:getParamNames(energy_consumption),
  },
}

var Technologies_selected = [];
//transform this object into an array of objects (could be better coded using Object.keys(Technologies).forEach
(function(){
  for(var id in Technologies){
    var value=Technologies[id].value;
    var descr=Technologies[id].Name;
    var notActivable=Technologies[id].notActivable;
    var comments=Technologies[id].comments;
    Technologies_selected.push({id,value,notActivable,descr,comments});
  }
})();

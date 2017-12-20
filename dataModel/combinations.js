
/*Possible Technology combinations*/
var Combinations=[
	["BOD","Fra","SST"],
	["BOD","Fra","SST","Nit"],
	["BOD","Fra","SST","Nit","Des"],
	["BOD","Fra","SST","Nit","Des","BiP"],
	["BOD","Fra","SST","Nit","Des","ChP"],
	["BOD","Fra","SST","Nit","Des","BiP","ChP"],
	["BOD","Fra","SST","BiP"],
	["BOD","Fra","SST","ChP"],
	["BOD","Fra","SST","BiP","ChP"],
];

// util: remove duplicate elements in arrays
function uniq(arr){return Array.from(new Set(arr));}

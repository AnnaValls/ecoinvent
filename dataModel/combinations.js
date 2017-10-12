
/*Possible Technology combinations*/
var Combinations=[
	["BOD","SST"],
	["BOD","SST","Nit"],
	["BOD","SST","Nit","Des"],
	["BOD","SST","Nit","Des","BiP"],
	["BOD","SST","Nit","Des","ChP"],
	["BOD","SST","BiP"],
	["BOD","SST","ChP"],
];

// util: remove duplicate elements in arrays
function uniq(arr){return Array.from(new Set(arr));}

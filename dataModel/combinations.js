
/*Possible Technology combinations*/
var Combinations=[
	["BOD","Fra","SST","Met"],
	["BOD","Fra","SST","Met","Nit"],
	["BOD","Fra","SST","Met","Nit","Des"],
	["BOD","Fra","SST","Met","Nit","Des","BiP"],
	["BOD","Fra","SST","Met","Nit","Des","ChP"],
  ["BOD","Fra","SST","Met","Nit","BiP"],
  ["BOD","Fra","SST","Met","Nit","ChP"],
	["BOD","Fra","SST","Met","BiP"],
	["BOD","Fra","SST","Met","ChP"],
];

// util: remove duplicate elements in arrays
function uniq(arr){return Array.from(new Set(arr));}

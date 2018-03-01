
/*Possible Technology combinations*/
var Combinations=[
  [],
  ['BOD'],
  ['BOD','Nit'],
  ['BOD','BiP'],
  ['BOD','ChP'],
  ['BOD','Met'],
  ['BOD','Nit','Des'],
  ['BOD','Nit','BiP'],
  ['BOD','Nit','ChP'],
  ['BOD','Nit','Met'],
  ['BOD','BiP','Met'],
  ['BOD','ChP','Met'],
  ['BOD','Nit','Des','BiP'],
  ['BOD','Nit','Des','ChP'],
  ['BOD','Nit','Des','Met'],
  ['BOD','Nit','Des','BiP','Met'],
  ['BOD','Nit','Des','ChP','Met'],
];

// util: remove duplicate elements in arrays
function uniq(arr){return Array.from(new Set(arr));}

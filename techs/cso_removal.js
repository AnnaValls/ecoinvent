/**
  * Remove a soluble fraction and a particulate fraction of the influent
  * due to combined sewer overflows
  */

function cso_removal(CSO_particulate, CSO_soluble ){
  /*
    | Inputs     | example values |
    |------------+----------------|
    | Q          | 22700   m3/d   |
  */

  //apply removal rates
  var bpCOD_removed = 0.01*removal_bpCOD * bpCOD; //g/m3
  var bpCOD_removed = 0.01*removal_bpCOD * bpCOD; //g/m3

  return {
    bpCOD_removed: {value:bpCOD_removed, unit:"g/m3_as_O2", descr:"Removed_bpCOD_by_primary_settler"},
    bpCOD_removed: {value:bpCOD_removed, unit:"g/m3_as_O2", descr:"Removed_bpCOD_by_primary_settler"},
  }
}

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var removal_OP = 66;
  console.log(
    cso_removal()
  );
})();


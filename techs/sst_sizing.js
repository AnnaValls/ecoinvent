/*  
 * Technology: sst sizing
 * Metcalf & Eddy, Wastewater Engineering, 5th ed., 2014:
 * page 767
 */
function sst_sizing(Q,SOR,X_R,clarifiers,MLSS_X_TSS){
  /*
    Inputs:
      SOR (hydraulic application rate)     24 m3/m2·d
      X_R                                8000 g/m3
      clarifiers                            3 clarifiers
      MLSS_X_TSS                         3000 g/m3
      Q                                 22700 m3/d
  */
  /*
    note for SOR (hydraulic application rate)
    assume 24 m3/m2·d (from table 8-34, page 890, range 16-28 m3/m2·d)
    "settling following air activated sludge, excluding extended aeration"
  */

  /*SOLUTION*/
  var RAS = MLSS_X_TSS/(X_R - MLSS_X_TSS); //unitless (return sludge recycle ratio)
  var QR = Q*RAS; //m3/d (Q return)
  var Area = Q/SOR; //m2
  var area_per_clarifier = Area/clarifiers; //m2/clarifier
  var clarifier_diameter = Math.sqrt(area_per_clarifier*4/Math.PI); //meters
  var Solids_loading = (1+RAS)*Q*MLSS_X_TSS/1000/(Area*24); //kg MLSS/m2·h

  return {
    RAS:                 {value:RAS,                 unit:"&empty;",       descr:"Return sludge recycle ratio"},
    QR:                  {value:QR,                  unit:"m3/d",          descr:"Recirculation flow"},
    Area:                {value:Area,                unit:"m2",            descr:"Total area needed"},
    area_per_clarifier:  {value:area_per_clarifier,  unit:"m2/clarifier",  descr:"Area_per_clarifier"},
    clarifier_diameter:  {value:clarifier_diameter,  unit:"m",             descr:"Clarifier_diameter"},
    Solids_loading:      {value:Solids_loading,      unit:"kg_MLSS/m2·h",  descr:"Solids_loading"},
  }
}

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var Q   = 22700;
  var SOR = 24;
  var X_R = 8000;
  var clarifiers = 3;
  var MLSS_X_TSS = 3000;
  var result = sst_sizing(Q, SOR, X_R, clarifiers, MLSS_X_TSS);
  console.log(result);
})();

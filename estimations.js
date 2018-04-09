/**
  * Estimations for inputs that the user might not know
  * Default values from BioWin 5.2
*/

function estimations(COD,TKN,TP){
  //intermediate variables
  var CS_U  = 0.050*COD;
  var S_VFA = 0.024*COD;
  var S_F   = 0.136*COD;
  var C_B   = 0.170*COD;
  var X_B   = 0.470*COD;
  var X_H   = 0.020*COD;
  var X_U   = 0.130*COD;
  var X_COD = X_B + X_H + X_U;
  var CS_B  = C_B + S_VFA + S_F;
  var X_BH  = X_B + X_H;

  //pack variables inside an object
  var variables = { CS_U, S_VFA, S_F, C_B, X_B, X_H, X_U, X_COD, CS_B, X_BH };

  //outputs (return value)
  var sCOD       = CS_U + S_VFA + S_F + C_B;
  var bCOD       = COD - X_U - CS_U;
  var rbCOD      = S_VFA + S_F;
  var BOD        = COD/2.04;
  var sBOD       = sCOD/2.04;
  var VFA        = S_VFA;
  var VSS        = X_COD/1.6;
  var TSS        = 45 + VSS;
  var NH4        = 0.66*TKN;
  var PO4        = 0.50*TP;
  var Alkalinity = 300;

  //pack outputs inside an object
  var outputs = { BOD, sBOD, sCOD, bCOD, rbCOD, VFA, VSS, TSS, NH4, PO4, Alkalinity };

  //return value
  var rv = { variables, outputs };
  return rv;
}

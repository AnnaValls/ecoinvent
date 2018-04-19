/**
  * Estimations module for inputs that the user might not know
  * Default values from BioWin 5.2 (provided by Y. Comeau)

  TODO industrial types default values

    symbols:      [brewery, pig manure, tanning, thmechP&P ]
      fCSU_COD    [   0.04,       0.05,    0.04,     0.33  ]
      fSB_COD     [   0.61,       0.20,    0.28,     0.28  ]
      fVFA_SB     [   0.55,       0.30,    0.00,     0.00  ]

      fCOD_cBOD5  [   1.71,        3.0,    2.50,      2.2  ]
      fXCB_COD    [   0.26,       0.70,    0.39,     0.34  ]
      fXB_XCB     [   0.65,       0.75,    0.60,     0.88  ]
      fXCOD_VSS   [   1.51,       1.48,    2.18,     1.37  ]
      fXU_COD     [   0.09,       0.05,    0.29,     0.05  ]
      XIg         [    100,       6500,    1315,      135  ]
      fXH_XCOD    [   0.11,       0.02,    0.00,     0.00  ]
      fSNH4_TKN   [   0.10,       0.55,    0.57,        0  ]
      fSPO4_TP    [   0.93,       0.18,    0.00,        0  ]
      SAlk        [   3000,        100,    1100,        2  ]
  */

function estimations(COD,TKN,TP){
  //intermediate variables
  var CS_U  = 0.050*COD; // CS_U  = fCSU_COD*COD;
  var S_VFA = 0.024*COD; // S_VFA = fSB_COD * fVFA_SB* COD;
  var S_F   = 0.136*COD; // S_F   = fSB_COD - S_VFA * COD;
  var C_B   = 0.170*COD; // C_B   = (1-fXB_XCB)*fXCB_COD*COD;
  var X_B   = 0.470*COD; // X_B   = fXB_XCB*fXCB_COD*COD;
  var X_H   = 0.020*COD; // X_H   = fXH_XCOD*COD;
  var X_U   = 0.130*COD; // X_U   = fXU_COD*COD;
  var X_COD = X_B + X_H + X_U;
  var CS_B  = C_B + S_VFA + S_F;
  var X_BH  = X_B + X_H;

  //pack variables inside an object
  var variables = { CS_U, S_VFA, S_F, C_B, X_B, X_H, X_U, X_COD, CS_B, X_BH };

  //outputs (return value)
  var sCOD       = CS_U + S_VFA + S_F + C_B; //
  var bCOD       = COD - X_U - CS_U;         //
  var rbCOD      = S_VFA + S_F;              //
  var BOD        = COD/2.04;                 //  BOD        = COD/fCOD_cBOD5; TODO
  var sBOD       = sCOD/2.04;                //  sBOD       = sCOD/fCOD_cBOD5; TODO
  var VFA        = S_VFA;                    //
  var VSS        = X_COD/1.6;                //  VSS        = X_COD/fXCOD_VSS; TODO
  var TSS        = 45 + VSS;                 //  TSS        = XIg + VSS; TODO
  var NH4        = 0.66*TKN;                 //  NH4        = fSNH4_TKN*TKN; TODO
  var PO4        = 0.50*TP;                  //  PO4        = fSPO4_TP*TP; TODO
  var Alkalinity = 300;                      //  Alkalinity = SAlk; TODO

  //pack outputs inside an object
  var outputs = { BOD, sBOD, sCOD, bCOD, rbCOD, VFA, VSS, TSS, NH4, PO4, Alkalinity };

  //return value
  var rv = { variables, outputs };
  return rv;
}

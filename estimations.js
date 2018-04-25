/**
  * Estimations module for inputs that the user might not know
  * Default values from BioWin 5.2 (provided by Y. Comeau)

    symbols:      [municipal, brewery, pig manure, tanning, thmechP&P ]
      fCOD_cBOD5  [     2.04,    1.71,       3.00,    2.50,     2.20  ]
      fSB_COD     [     0.16,    0.61,       0.20,    0.28,     0.28  ]
      fVFA_SB     [     0.15,    0.55,       0.30,    0.00,     0.00  ]
      fXCB_COD    [     0.64,    0.26,       0.70,    0.39,     0.34  ]
      fXB_XCB     [     0.73,    0.65,       0.75,    0.60,     0.88  ]
      fXCOD_VSS   [     1.60,    1.51,       1.48,    2.18,     1.37  ]
      fXU_COD     [     0.13,    0.09,       0.05,    0.29,     0.05  ]
      XIg         [       45,     100,       6500,    1315,      135  ]
      fXH_XCOD    [     0.02,    0.11,       0.02,    0.00,     0.00  ]
      fCSU_COD    [     0.05,    0.04,       0.05,    0.04,     0.33  ]
      fSNH4_TKN   [     0.66,    0.10,       0.55,    0.57,        0  ]
      fSPO4_TP    [     0.50,    0.93,       0.18,    0.00,        0  ]
      SAlk        [      300,    3000,        100,    1100,        2  ]

      <option value="muni"> Type 0: Municipal
      <option value="hshd"> Type 1: Highly soluble     - high degradability (beverages industry wastewater)
      <option value="hphd"> Type 2: Highly particulate - high degradability (pig manure)
      <option value="hsld"> Type 3: Highly soluble     - low degradability  (tanning wastewater)
      <option value="hpld"> Type 4: Highly particulate - low degradability  (thermomechanical pulp and paper wastewater)
  */

function estimations(COD, TKN, TP, ww_type){
  ww_type = ww_type || 'muni';
  var ww_types = ['muni','hshd','hphd','hsld','hpld'];
  var index=ww_types.indexOf(ww_type);
  if(index==-1)index=0;

  //ww type depending factors
  var fCOD_cBOD5 = [ 2.04,  1.71,  3.00,  2.50,  2.20 ][index];
  var fSB_COD    = [ 0.16,  0.61,  0.20,  0.28,  0.28 ][index];
  var fVFA_SB    = [ 0.15,  0.55,  0.30,  0.00,  0.00 ][index];
  var fXCB_COD   = [ 0.64,  0.26,  0.70,  0.39,  0.34 ][index];
  var fXB_XCB    = [ 0.73,  0.65,  0.75,  0.60,  0.88 ][index];
  var fXCOD_VSS  = [ 1.60,  1.51,  1.48,  2.18,  1.37 ][index];
  var fXU_COD    = [ 0.13,  0.09,  0.05,  0.29,  0.05 ][index];
  var XIg        = [   45,   100,  6500,  1315,   135 ][index];
  var fXH_XCOD   = [ 0.02,  0.11,  0.02,  0.00,  0.00 ][index];
  var fCSU_COD   = [ 0.05,  0.04,  0.05,  0.04,  0.33 ][index];
  var fSNH4_TKN  = [ 0.66,  0.10,  0.55,  0.57,     0 ][index];
  var fSPO4_TP   = [ 0.50,  0.93,  0.18,  0.00,     0 ][index];
  var SAlk       = [  300,  3000,   100,  1100,     2 ][index];

  //intermediate variables
  var CS_U  = fCSU_COD*COD;
  var S_VFA = fSB_COD*fVFA_SB*COD;
  var S_F   = fSB_COD*(1 - fVFA_SB)*COD;
  var C_B   = (1 - fXB_XCB)*fXCB_COD*COD;
  var X_B   = fXB_XCB*fXCB_COD*COD;
  var X_H   = fXH_XCOD*COD;
  var X_U   = fXU_COD*COD;
  var X_COD = X_B + X_H + X_U;
  var CS_B  = C_B + S_VFA + S_F;
  var X_BH  = X_B + X_H;

  //pack variables inside an object
  var variables = { CS_U, S_VFA, S_F, C_B, X_B, X_H, X_U, X_COD, CS_B, X_BH };

  //outputs (return value)
  var sCOD       = CS_U + S_VFA + S_F + C_B;
  var bCOD       = COD - X_U - CS_U;
  var rbCOD      = S_VFA + S_F;
  var BOD        = COD/fCOD_cBOD5;
  var sBOD       = sCOD/fCOD_cBOD5;
  var VFA        = S_VFA;
  var VSS        = X_COD/fXCOD_VSS;
  var TSS        = XIg + VSS;
  var NH4        = fSNH4_TKN*TKN;
  var PO4        = fSPO4_TP*TP;
  var Alkalinity = SAlk;

  //pack outputs inside an object
  var outputs = { BOD, sBOD, sCOD, bCOD, rbCOD, VFA, VSS, TSS, NH4, PO4, Alkalinity };

  //return value
  var rv = { variables, outputs };
  return rv;
}

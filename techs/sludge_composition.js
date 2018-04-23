/**
  * SLUDGE COMPOSITION
  * 1. primary    sludge (from primary settler)
  * 2. secondary  sludge (from secondary treatment)
  * 3. additional sludge (from FeCl3 precipitation)

  //George mail: TODO
  Dear Lluis,
    This other ISS is sand, silt and clay. In WWT we are not interested in its composiition because it is inert.
    But if you need its elemental composition you can assume it to be a mixture of metal silicates.
    Abundances of the Elements in the Earth's Crust
    -----------------------------
    Element    Approx % by weight
    -----------------------------
    Oxygen     46.6
    Silicon    27.7
    Aluminum   8.4
    Iron       5.3
    Calcium    3.9
    Sodium     3.1
    Potassium  2.8
    Magnesium  2.3
    -----------------------------
  */
var sludge_composition={
  //1. PRIMARY SLUDGE COMPOSITION
  primary: function(VSS_removed, nbVSS_removed, bVSS_removed, VSS_COD, bpCOD_bVSS){
    //factors
    var factors = {
      f_CV_nbp: VSS_COD,    //g_pCOD/g_VSS
      f_CV_bp:  bpCOD_bVSS, //g_bpCOD/g_bVSS
      f_C:      0.51,       //g_C  /g_VSS
      f_N_nbp:  0.12,       //g_N  /g_VSS
      f_N_bp:   0.06,       //g_N  /g_VSS
      f_P_nbp:  0.015,      //g_P  /g_VSS
      f_P_bp:   0.010,      //g_P  /g_VSS
      f_O_nbp:  function(){return 16/18*(1 - this.f_CV_nbp/8 -  8/12*this.f_C - 17/14*this.f_N_nbp - 26/31*this.f_P_nbp)}, //g_O/g_VSS
      f_O_bp:   function(){return 16/18*(1 - this.f_CV_bp/8  -  8/12*this.f_C - 17/14*this.f_N_bp  - 26/31*this.f_P_bp)},  //g_O/g_VSS
      f_H_nbp:  function(){return  2/18*(1 + this.f_CV_nbp   - 44/12*this.f_C + 10/14*this.f_N_nbp - 71/31*this.f_P_nbp)}, //g_H/g_VSS
      f_H_bp:   function(){return  2/18*(1 + this.f_CV_bp    - 44/12*this.f_C + 10/14*this.f_N_bp  - 71/31*this.f_P_bp)},  //g_H/g_VSS
    };
    //calculated variables
    var C_content = factors.f_C * VSS_removed;
    var H_content = nbVSS_removed*factors.f_H_nbp() + bVSS_removed*factors.f_H_bp();
    var O_content = nbVSS_removed*factors.f_O_nbp() + bVSS_removed*factors.f_O_bp();
    var N_content = nbVSS_removed*factors.f_N_nbp   + bVSS_removed*factors.f_N_bp;
    var P_content = nbVSS_removed*factors.f_P_nbp   + bVSS_removed*factors.f_P_bp;
    //results
    var rv = { C_content, H_content, O_content, N_content, P_content };
    //console.log(rv);
    return rv;
  },

  //2. SECONDARY SLUDGE COMPOSITION
  secondary: function(P_X_VSS){
    var factors={
      /*
        Dear  Lluis,
        If the COD/VSS (f_CV=1.42), C/VSS (f_C=0.51), N/VSS (f_N=0.12) and P/VSS (f_P=0.015) are known
        then the O/VSS (F_O) And H/VSS (f_H) can be calcylated with che following equations:
        f_O = 16/18 ( 1- f_CV/8 - 8/12 f_C  – 17/14 f_N – 26/31 f_P)
        f_H = 2/18  ( 1+ f_CV  - 44/12 f_C +  10/14 f_N – 71/31 f_P)
        So for f_CV = 1.42; f_C = 0.51 , f_N=0.12 and f_P = 0.015,
        f_O=0.288 and f_H=0.067.
        We can include S in this but there is no need. There are no S
        transformations taking place in he AS system anyway.
        The elements from Cl down in the table below are inorganics and so should
        not be expressed with respect to the VSS (as in the table).
        They should be calculated as % of the ISS (TSS-VSS) because the make up
        the ash content of the sludge.
        George
      */
      f_CV: 1.42,  //g_COD/g_VSS
      f_C:  0.51,  //g_C  /g_VSS
      f_N:  0.12,  //g_N  /g_VSS
      f_P:  0.015, //g_P  /g_VSS
      f_O:function(){return 16/18*(1 - this.f_CV/8 -  8/12*this.f_C - 17/14*this.f_N - 26/31*this.f_P)}, //g_O/g_VSS
      f_H:function(){return  2/18*(1 + this.f_CV   - 44/12*this.f_C + 10/14*this.f_N - 71/31*this.f_P)}, //g_H/g_VSS
    };
    var C_content = factors.f_C   * P_X_VSS; //kg_C/d
    var H_content = factors.f_H() * P_X_VSS; //kg_H/d
    var O_content = factors.f_O() * P_X_VSS; //kg_O/d
    var N_content = factors.f_N   * P_X_VSS; //kg_N/d
    var P_content = factors.f_P   * P_X_VSS; //kg_P/d
    var rv = { C_content, H_content, O_content, N_content, P_content };
    //console.log(rv);
    return rv;
  },

  //3. PRECIPITATION SLUDGE COMPOSITION
  precipitation: function(extra_iSS, Fe_P_mole_ratio){
    //input 1: extra_iSS       (kg/d)
    //input 2: Fe_P_mole_ratio (mole Fe/mole P)
    //molecular weights of Fe and P
    const M_Fe = 55.845;     //g/mol (Fe molecular weight)
    const M_P  = 30.974;     //g/mol (P molecular weight)
    //shorten name of Fe/P mole ratio
    var x = Fe_P_mole_ratio;
    //fractions
    var Fe_content = extra_iSS * M_Fe*x/(106.8*x + 80);
    var H_content  = extra_iSS * (3*x + 1)/(106.8*x + 80);
    var P_content  = extra_iSS * M_P/(106.8*x + 80);
    var O_content  = extra_iSS * 48*(x + 1)/(106.8*x + 80);
    //total
    var rv = { Fe_content, H_content, P_content, O_content };
    //console.log(rv);
    return rv;
  },
};

//tests
  /*
  sludge_composition.primary(28, 12, 16, 2.8, 2.8);
  sludge_composition.secondary(100);
  sludge_composition.precipitation(100, 1.7);
  sludge_composition.precipitation(100, 3.3);
  */

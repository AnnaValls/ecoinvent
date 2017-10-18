/*
	Constants (global variables)
	used in technologies
*/

//physics (universal)
const Pa     = 10.33;  //m (standard pressure at sea level)
const R      = 8314;   //kg*m2/s2*kmol*K (ideal gases constant)
const g      = 9.81;   //m/s2 (gravity)
const M      = 28.97;  //g/mol (air molecular weight)
const M_Fe   = 55.845; //g/mol (Fe molecular weight)
const M_P    = 30.974; //g/mol (P molecular weight)

//bod removal related
const YH     = 0.45; //TODO add description
const Ks     = 8;    //TODO add description
const mu_m   = 6;    //TODO add description
const bH     = 0.12; //TODO add description
const fd     = 0.15; //TODO add description

//aeration related
const F      = 0.90;  //8.b fouling factor
const C_s_20 = 9.09;  //8.b sat DO at sea level at 20ºC
const de     = 0.40;  //8.b mid-depth correction factor (range: 0.25 - 0.45)
const E      = 0.35;  //oxygen transfer efficiency

//nitrification related
const mu_max_AOB = 0.90; //table 8-14 at 20ºC
const b_AOB      = 0.17; //table 8-14 at 20ºC
const K_NH4      = 0.50; //table 8-14 at 20ºC
const K_o_AOB    = 0.50; //table 8-14 at 20ºC
const Yn         = 0.15; //table 8-14

//bio P removal
const bn              =  0.17;  //1/d
const P_content_het_X =  0.015; //g_P/g_X

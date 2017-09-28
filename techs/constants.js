/*
	Constants (global variables)
	used in technologies
*/

//bod removal related
const YH     = 0.45; //
const Ks     = 8;    //
const mu_m   = 6;    //
const bH     = 0.12; //
const fd     = 0.15; //

//physics
const Pa     = 10.33;  //m (standard pressure at sea level)
const R      = 8314;   //kg*m2/s2*kmol*K (ideal gases constant)
const g      = 9.81;   //m/s2 (gravity)
const M      = 28.97;  //g/mol (air molecular weight)
const M_Fe   = 55.845; //g/mol (Fe molecular weight)
const M_P    = 30.974; //g/mol (P molecular weight)

//aeration related
const C_L    = 2.0;   //DO in aeration basin (mg/L)
const F      = 0.9;   //8.b fouling factor
const C_s_20 = 9.09;  //8.b sat DO at sea level at 20ºC
const de     = 0.40;  //8.b mid-depth correction factor (range: 0.25 - 0.45)
const E      = 0.35;  //O2 transfer efficiency

//nitrification related
const mu_max_AOB = 0.90; //table 8-14 at 20ºC
const b_AOB      = 0.17; //table 8-14 at 20ºC
const K_NH4      = 0.50; //table 8-14 at 20ºC
const K_o_AOB    = 0.50; //table 8-14 at 20ºC
const Yn         = 0.15; //table 8-14

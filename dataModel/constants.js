/*
 *
 * Constants (global variables) used in technologies' equations (see the folder "techs" to see each technology's equations)
 *
 */

//COD, N, P content of heterotrophic bacteria
const COD_content_het_X = 1.42;  //g_COD/g_X
const N_content_het_X   = 0.12;  //g_N/g_X
const P_content_het_X   = 0.015; //g_P/g_X

//physics (universal)
const Pa     = 10.33;  //m (standard pressure at sea level)
const R      = 8314;   //kg*m2/s2*kmol*K (ideal gases constant*1000)
const g      = 9.81;   //m/s2 (gravity)
const M      = 28.97;  //g/mol (air molecular weight)
const M_Fe   = 55.845; //g/mol (Fe molecular weight)
const M_P    = 30.974; //g/mol (P molecular weight)

//AS kinetic coefficients for Heterotrophic Bacteria at 20ºC
//column COD oxidation
//Table 8-14, page 755
const mu_m   = 6;    //1/d
const Ks     = 8;    //g_bCOD/m3
const YH     = 0.45; //g_VSS/g_bCOD
const bH     = 0.12; //1/d
const fd     = 0.15; //unitless

//AS nitrification kinetic coefficients at 20ºC
//Table 8-14, page 755
const mu_max_AOB = 0.90; //1/d
const K_NH4      = 0.50; //g_NH4-N/m3
const Yn         = 0.15; //g_VSS/g_NH4-N
const b_AOB      = 0.17; //1/d
const K_o_AOB    = 0.50; //unitless

//aeration related
const C_s_20 = 9.09;  //8.b sat DO at sea level at 20ºC
const F      = 0.90;  //8.b fouling factor
const de     = 0.40;  //8.b mid-depth correction factor (range: 0.25 - 0.45)
const E      = 0.35;  //oxygen transfer efficiency

//bio P removal
const bn              =  0.17;  //1/d
const rbCOD_NO3_ratio =  5.2;   //g rbCOD/g NO3 -- page 879 (2.86/(1-1.42*0.32))


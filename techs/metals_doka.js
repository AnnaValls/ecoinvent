/*
 * Technology: Metals in WWTPs effluents
 * From G. Doka document table 4.19
 * page 25
 */

function metals_doka(Al,As,Cd,Cr,Co,Cu,Pb,Mn,Hg,Ni,Ag,Sn,Zn){
  /*
    | Inputs | example values
    |--------+---------------
    | Al     | 1 g/m3
    | As     | 1 g/m3
    | Cd     | 1 g/m3
    | Cr     | 1 g/m3
    | Co     | 1 g/m3
    | Cu     | 1 g/m3
    | Pb     | 1 g/m3
    | Mn     | 1 g/m3
    | Hg     | 1 g/m3
    | Ni     | 1 g/m3
    | Ag     | 1 g/m3
    | Sn     | 1 g/m3
    | Zn     | 1 g/m3
  */

  //apply table 4.19
  var Al={sludge:0.95*Al, water:0.05*Al };
  var As={sludge:0.22*As, water:0.78*As };
  var Cd={sludge:0.50*Cd, water:0.50*Cd };
  var Cr={sludge:0.50*Cr, water:0.50*Cr };
  var Co={sludge:0.50*Co, water:0.50*Co };
  var Cu={sludge:0.75*Cu, water:0.25*Cu };
  var Pb={sludge:0.90*Pb, water:0.10*Pb };
  var Mn={sludge:0.50*Mn, water:0.50*Mn };
  var Hg={sludge:0.70*Hg, water:0.30*Hg };
  var Ni={sludge:0.40*Ni, water:0.60*Ni };
  var Ag={sludge:0.75*Ag, water:0.25*Ag };
  var Sn={sludge:0.59*Sn, water:0.41*Sn };
  var Zn={sludge:0.70*Zn, water:0.30*Zn };

  //return results object
  return {
    Al_sludge: {value:Al.sludge, unit:"g/m3", descr:"Aluminium in effluent sludge" },
    Al_water:  {value:Al.water,  unit:"g/m3", descr:"Aluminium in effluent water"  },
    As_sludge: {value:As.sludge, unit:"g/m3", descr:"Arsenic in effluent sludge"   },
    As_water:  {value:As.water,  unit:"g/m3", descr:"Arsenic in effluent water"    },
    Cd_sludge: {value:Cd.sludge, unit:"g/m3", descr:"Cadmium in effluent sludge"   },
    Cd_water:  {value:Cd.water,  unit:"g/m3", descr:"Cadmium in effluent water"    },
    Cr_sludge: {value:Cr.sludge, unit:"g/m3", descr:"Chromium in effluent sludge"  },
    Cr_water:  {value:Cr.water,  unit:"g/m3", descr:"Chromium in effluent water"   },
    Co_sludge: {value:Co.sludge, unit:"g/m3", descr:"Cobalt in effluent sludge"    },
    Co_water:  {value:Co.water,  unit:"g/m3", descr:"Cobalt in effluent water"     },
    Cu_sludge: {value:Cu.sludge, unit:"g/m3", descr:"Copper in effluent sludge"    },
    Cu_water:  {value:Cu.water,  unit:"g/m3", descr:"Copper in effluent water"     },
    Pb_sludge: {value:Pb.sludge, unit:"g/m3", descr:"Lead in effluent sludge"      },
    Pb_water:  {value:Pb.water,  unit:"g/m3", descr:"Lead in effluent water"       },
    Mn_sludge: {value:Mn.sludge, unit:"g/m3", descr:"Manganese in effluent sludge" },
    Mn_water:  {value:Mn.water,  unit:"g/m3", descr:"Manganese in effluent water"  },
    Hg_sludge: {value:Hg.sludge, unit:"g/m3", descr:"Mercury in effluent sludge"   },
    Hg_water:  {value:Hg.water,  unit:"g/m3", descr:"Mercury in effluent water"    },
    Ni_sludge: {value:Ni.sludge, unit:"g/m3", descr:"Nickel in effluent sludge"    },
    Ni_water:  {value:Ni.water,  unit:"g/m3", descr:"Nickel in effluent water"     },
    Ag_sludge: {value:Ag.sludge, unit:"g/m3", descr:"Silver in effluent sludge"    },
    Ag_water:  {value:Ag.water,  unit:"g/m3", descr:"Silver in effluent water"     },
    Sn_sludge: {value:Sn.sludge, unit:"g/m3", descr:"Tin in effluent sludge"       },
    Sn_water:  {value:Sn.water,  unit:"g/m3", descr:"Tin in effluent water"        },
    Zn_sludge: {value:Zn.sludge, unit:"g/m3", descr:"Zinc in effluent sludge"      },
    Zn_water:  {value:Zn.water,  unit:"g/m3", descr:"Zinc in effluent water"       },
  };
};

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var Al = 1;
  var As = 1;
  var Cd = 1;
  var Cr = 1;
  var Co = 1;
  var Cu = 1;
  var Pb = 1;
  var Mn = 1;
  var Hg = 1;
  var Ni = 1;
  var Ag = 1;
  var Sn = 1;
  var Zn = 1;
  console.log(
    metals_doka(Al,As,Cd,Cr,Co,Cu,Pb,Mn,Hg,Ni,Ag,Sn,Zn)
  );
})();

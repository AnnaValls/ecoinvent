/*
 * Technology: Metals in WWTPs effluents
 * From G. Doka document table 4.19
 * page 25
 *
 * there are 35 metals in the influent, that go out to effluent water and effluent sludge,
 * meaning 35*2 = 70 outputs
 */

function metals_doka(Ag,Al,As,B,Ba,Be,Br,Ca,Cd,Cl,Co,Cr,Cu,F,Fe,Hg,I,K,Mg,Mn,Mo,Na,Ni,Pb,Sb,Sc,Se,Si,Sn,Sr,Ti,Tl,V,W,Zn){
  /*
    | Inputs | example values
    |--------+---------------
    | Al     | 1 g/m3
    | As     | 1 g/m3
    | Cd     | 1 g/m3
    | Cr     | 1 g/m3
    | [...]  | 1 g/m3 (until 35 metals)
  */

  //apply table 4.19
  var Ag={sludge:0.75*Ag, water:0.25*Ag };
  var Al={sludge:0.95*Al, water:0.05*Al };
  var As={sludge:0.22*As, water:0.78*As };
  var B ={sludge:0.50*B , water:0.50*B  };
  var Ba={sludge:0.95*Ba, water:0.05*Ba };
  var Be={sludge:0.50*Be, water:0.50*Be };
  var Br={sludge:0.00*Br, water:1.00*Br };
  var Ca={sludge:0.10*Ca, water:0.90*Ca };
  var Cd={sludge:0.50*Cd, water:0.50*Cd };
  var Cl={sludge:0.00*Cl, water:1.00*Cl };
  var Co={sludge:0.50*Co, water:0.50*Co };
  var Cr={sludge:0.50*Cr, water:0.50*Cr };
  var Cu={sludge:0.75*Cu, water:0.25*Cu };
  var F ={sludge:0.00*F , water:1.00*F  };
  var Fe={sludge:0.50*Fe, water:0.50*Fe };
  var Hg={sludge:0.70*Hg, water:0.30*Hg };
  var I ={sludge:0.00*I , water:1.00*I  };
  var K ={sludge:0.00*K , water:1.00*K  };
  var Mg={sludge:0.10*Mg, water:0.90*Mg };
  var Mn={sludge:0.50*Mn, water:0.50*Mn };
  var Mo={sludge:0.50*Mo, water:0.50*Mo };
  var Na={sludge:0.00*Na, water:1.00*Na };
  var Ni={sludge:0.40*Ni, water:0.60*Ni };
  var Pb={sludge:0.90*Pb, water:0.10*Pb };
  var Sb={sludge:0.50*Sb, water:0.50*Sb };
  var Sc={sludge:0.50*Sc, water:0.50*Sc };
  var Se={sludge:0.50*Se, water:0.50*Se };
  var Si={sludge:0.95*Si, water:0.05*Si };
  var Sn={sludge:0.59*Sn, water:0.41*Sn };
  var Sr={sludge:0.50*Sr, water:0.50*Sr };
  var Ti={sludge:0.50*Ti, water:0.50*Ti };
  var Tl={sludge:0.50*Tl, water:0.50*Tl };
  var V ={sludge:0.50*V , water:0.50*V  };
  var W ={sludge:0.50*W , water:0.50*W  };
  var Zn={sludge:0.70*Zn, water:0.30*Zn };

  //return results object
  return {
    Ag_sludge:  {value:Ag.sludge,  unit:"g/m3",  descr:"Silver      in  effluent  sludge"  },
    Ag_water:   {value:Ag.water,   unit:"g/m3",  descr:"Silver      in  effluent  water"   },
    Al_sludge:  {value:Al.sludge,  unit:"g/m3",  descr:"Aluminium   in  effluent  sludge"  },
    Al_water:   {value:Al.water,   unit:"g/m3",  descr:"Aluminium   in  effluent  water"   },
    As_sludge:  {value:As.sludge,  unit:"g/m3",  descr:"Arsenic     in  effluent  sludge"  },
    As_water:   {value:As.water,   unit:"g/m3",  descr:"Arsenic     in  effluent  water"   },
    B_sludge:   {value:B.sludge,   unit:"g/m3",  descr:"Boron       in  effluent  sludge"   },
    B_water:    {value:B.water,    unit:"g/m3",  descr:"Boron       in  effluent  water"   },
    Ba_sludge:  {value:Ba.sludge,  unit:"g/m3",  descr:"Barium      in  effluent  sludge"  },
    Ba_water:   {value:Ba.water,   unit:"g/m3",  descr:"Barium      in  effluent  water"   },
    Be_sludge:  {value:Be.sludge,  unit:"g/m3",  descr:"Berilium    in  effluent  sludge"  },
    Be_water:   {value:Be.water,   unit:"g/m3",  descr:"Berilium    in  effluent  water"   },
    Br_sludge:  {value:Br.sludge,  unit:"g/m3",  descr:"Bromine     in  effluent  sludge"  },
    Br_water:   {value:Br.water,   unit:"g/m3",  descr:"Bromine     in  effluent  water"   },
    Ca_sludge:  {value:Ca.sludge,  unit:"g/m3",  descr:"Calcium     in  effluent  sludge"  },
    Ca_water:   {value:Ca.water,   unit:"g/m3",  descr:"Calcium     in  effluent  water"   },
    Cd_sludge:  {value:Cd.sludge,  unit:"g/m3",  descr:"Cadmium     in  effluent  sludge"  },
    Cd_water:   {value:Cd.water,   unit:"g/m3",  descr:"Cadmium     in  effluent  water"   },
    Cl_sludge:  {value:Cl.sludge,  unit:"g/m3",  descr:"Chlorine    in  effluent  sludge"  },
    Cl_water:   {value:Cl.water,   unit:"g/m3",  descr:"Chlorine    in  effluent  water"   },
    Co_sludge:  {value:Co.sludge,  unit:"g/m3",  descr:"Cobalt      in  effluent  sludge"  },
    Co_water:   {value:Co.water,   unit:"g/m3",  descr:"Cobalt      in  effluent  water"   },
    Cr_sludge:  {value:Cr.sludge,  unit:"g/m3",  descr:"Chromium    in  effluent  sludge"  },
    Cr_water:   {value:Cr.water,   unit:"g/m3",  descr:"Chromium    in  effluent  water"   },
    Cu_sludge:  {value:Cu.sludge,  unit:"g/m3",  descr:"Copper      in  effluent  sludge"  },
    Cu_water:   {value:Cu.water,   unit:"g/m3",  descr:"Copper      in  effluent  water"   },
    F_sludge:   {value:F.sludge,   unit:"g/m3",  descr:"Fluorine    in  effluent  sludge"  },
    F_water:    {value:F.water,    unit:"g/m3",  descr:"Fluorine    in  effluent  water"   },
    Fe_sludge:  {value:Fe.sludge,  unit:"g/m3",  descr:"Iron        in  effluent  sludge"  },
    Fe_water:   {value:Fe.water,   unit:"g/m3",  descr:"Iron        in  effluent  water"   },
    Hg_sludge:  {value:Hg.sludge,  unit:"g/m3",  descr:"Mercury     in  effluent  sludge"  },
    Hg_water:   {value:Hg.water,   unit:"g/m3",  descr:"Mercury     in  effluent  water"   },
    I_sludge:   {value:I.sludge,   unit:"g/m3",  descr:"Iodine      in  effluent  sludge"  },
    I_water:    {value:I.water,    unit:"g/m3",  descr:"Iodine      in  effluent  water"   },
    K_sludge:   {value:K.sludge,   unit:"g/m3",  descr:"Potassium   in  effluent  sludge"  },
    K_water:    {value:K.water,    unit:"g/m3",  descr:"Potassium   in  effluent  water"   },
    Mg_sludge:  {value:Mg.sludge,  unit:"g/m3",  descr:"Magnesium   in  effluent  sludge"  },
    Mg_water:   {value:Mg.water,   unit:"g/m3",  descr:"Magnesium   in  effluent  water"   },
    Mn_sludge:  {value:Mn.sludge,  unit:"g/m3",  descr:"Manganese   in  effluent  sludge"  },
    Mn_water:   {value:Mn.water,   unit:"g/m3",  descr:"Manganese   in  effluent  water"   },
    Mo_sludge:  {value:Mo.sludge,  unit:"g/m3",  descr:"Molybdenum  in  effluent  sludge"  },
    Mo_water:   {value:Mo.water,   unit:"g/m3",  descr:"Molybdenum  in  effluent  water"   },
    Na_sludge:  {value:Na.sludge,  unit:"g/m3",  descr:"Sodium      in  effluent  sludge"  },
    Na_water:   {value:Na.water,   unit:"g/m3",  descr:"Sodium      in  effluent  water"   },
    Ni_sludge:  {value:Ni.sludge,  unit:"g/m3",  descr:"Nickel      in  effluent  sludge"  },
    Ni_water:   {value:Ni.water,   unit:"g/m3",  descr:"Nickel      in  effluent  water"   },
    Pb_sludge:  {value:Pb.sludge,  unit:"g/m3",  descr:"Lead        in  effluent  sludge"  },
    Pb_water:   {value:Pb.water,   unit:"g/m3",  descr:"Lead        in  effluent  water"   },
    Sb_sludge:  {value:Sb.sludge,  unit:"g/m3",  descr:"Antimony    in  effluent  sludge"  },
    Sb_water:   {value:Sb.water,   unit:"g/m3",  descr:"Antimony    in  effluent  water"   },
    Sc_sludge:  {value:Sc.sludge,  unit:"g/m3",  descr:"Scandium    in  effluent  sludge"  },
    Sc_water:   {value:Sc.water,   unit:"g/m3",  descr:"Scandium    in  effluent  water"   },
    Se_sludge:  {value:Se.sludge,  unit:"g/m3",  descr:"Selenium    in  effluent  sludge"  },
    Se_water:   {value:Se.water,   unit:"g/m3",  descr:"Selenium    in  effluent  water"   },
    Si_sludge:  {value:Si.sludge,  unit:"g/m3",  descr:"Silicon     in  effluent  sludge"  },
    Si_water:   {value:Si.water,   unit:"g/m3",  descr:"Silicon     in  effluent  water"   },
    Sn_sludge:  {value:Sn.sludge,  unit:"g/m3",  descr:"Tin         in  effluent  sludge"  },
    Sn_water:   {value:Sn.water,   unit:"g/m3",  descr:"Tin         in  effluent  water"   },
    Sr_sludge:  {value:Sr.sludge,  unit:"g/m3",  descr:"Strontium   in  effluent  sludge"  },
    Sr_water:   {value:Sr.water,   unit:"g/m3",  descr:"Strontium   in  effluent  water"   },
    Ti_sludge:  {value:Ti.sludge,  unit:"g/m3",  descr:"Titanium    in  effluent  sludge"  },
    Ti_water:   {value:Ti.water,   unit:"g/m3",  descr:"Titanium    in  effluent  water"   },
    Tl_sludge:  {value:Tl.sludge,  unit:"g/m3",  descr:"Thallium    in  effluent  sludge"  },
    Tl_water:   {value:Tl.water,   unit:"g/m3",  descr:"Thallium    in  effluent  water"   },
    V_sludge:   {value:V.sludge,   unit:"g/m3",  descr:"Vanadium    in  effluent  sludge"  },
    V_water:    {value:V.water,    unit:"g/m3",  descr:"Vanadium    in  effluent  water"   },
    W_sludge:   {value:W.sludge,   unit:"g/m3",  descr:"Tungsten    in  effluent  sludge"   },
    W_water:    {value:W.water,    unit:"g/m3",  descr:"Tungsten    in  effluent  water"   },
    Zn_sludge:  {value:Zn.sludge,  unit:"g/m3",  descr:"Zinc        in  effluent  sludge"  },
    Zn_water:   {value:Zn.water,   unit:"g/m3",  descr:"Zinc        in  effluent  water"   },
  };
};

/*test*/
(function(){
  var debug=false;
  if(debug==false)return;
  var Ag=1;
  var Al=1;
  var As=1;
  var B =1;
  var Ba=1;
  var Be=1;
  var Br=1;
  var Ca=1;
  var Cd=1;
  var Cl=1;
  var Co=1;
  var Cr=1;
  var Cu=1;
  var F =1;
  var Fe=1;
  var Hg=1;
  var I =1;
  var K =1;
  var Mg=1;
  var Mn=1;
  var Mo=1;
  var Na=1;
  var Ni=1;
  var Pb=1;
  var Sb=1;
  var Sc=1;
  var Se=1;
  var Si=1;
  var Sn=1;
  var Sr=1;
  var Ti=1;
  var Tl=1;
  var V =1;
  var W =1;
  var Zn=1;
  console.log(
    metals_doka(Ag,Al,As,B,Ba,Be,Br,Ca,Cd,Cl,Co,Cr,Cu,F,Fe,Hg,I,K,Mg,Mn,Mo,Na,Ni,Pb,Sb,Sc,Se,Si,Sn,Sr,Ti,Tl,V,W,Zn)
  );
})();

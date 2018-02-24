/*
 * Lists of all possible inputs for all technologies
 *
 * 1) Notation has been changed:
 *   TSS_was = X_R
 *   NO3_eff = NOx_e
 *
 * 2) The "color" field is for frontend (orange and red means 'advanced knowledge required')
 *
 */
var Inputs = [

{id:"Q",          value:22700, unit:"m3/d",                   descr:"Flowrate"},
{id:"T",          value:12,    unit:"ºC",                     descr:"Temperature"},

//fractionation
{id:"COD",        value:300,   unit:"g/m3",                   descr:"Total chemical oxygen demand"},
{id:"sCOD",       value:132,   unit:"g/m3",                   descr:"Soluble COD"},
{id:"BOD",        value:140,   unit:"g/m3",                   descr:"Total 5d biochemical oxygen demand"},
{id:"sBOD",       value:70,    unit:"g/m3",                   descr:"Soluble BOD"},
{id:"TSS",        value:70,    unit:"g/m3",                   descr:"Total suspended solids"},
{id:"VSS",        value:60,    unit:"g/m3",                   descr:"Volatile suspended solids"},

//bod removal
{id:"MLSS_X_TSS", value:3000,  unit:"g/m3", isParameter:true, descr:"Mixed liquor suspended solids"},
{id:"DO",         value:2.0,   unit:"mg/L", isParameter:true, descr:"DO in aeration basin (generally: 1.5 to 2) (symbol in book is C_L)"},
{id:"clarifiers", value:3, unit:"clarifiers", isParameter:true, descr:"Number of clarifiers that will be used"},

//nitrification
{id:"TKN",        value:35,   unit:"g_N/m3",                         descr:"Total Kjedahl nitrogen"},
{id:"Ne",         value:0.50, unit:"g/m3",         isParameter:true, descr:"Effluent design NH4"},
{id:"sBODe",      value:3,    unit:"g/m3",         isParameter:true, descr:"Effluent design Soluble BOD"},
{id:"Alkalinity", value:140,  unit:"g/m3_as_CaCO3",                  descr:"Influent alkalinity"},

//N removal
{id:"rbCOD",   value:80, unit:"g/m3",                   descr:"Readily biodegradable COD"},
{id:"NO3_eff", value:6,  unit:"g/m3", isParameter:true, descr:"Effluent design NO3 concentration"},

//bio P
{id:"VFA", value:15, unit:"g/m3",   descr:"Volatile Fatty Acids (Acetate)"},
{id:"TP",  value:6,  unit:"g_P/m3", descr:"Total phosphorus"},

//chem P
{id:"TSS_removal_wo_Fe", value:60,   unit:"%",    isParameter:true, descr:"% TSS removal without iron addition"},
{id:"TSS_removal_w_Fe",  value:75,   unit:"%",    isParameter:true, descr:"% TSS removal with iron addition"},
{id:"C_PO4_inf",         value:5,    unit:"g/m3", descr:"Influent PO4(3-)"},
{id:"C_PO4_eff",         value:0.1,  unit:"g/m3", isParameter:true, descr:"Effluent design PO4(3-)"},

//Sulfur (not used for now)
{id:"TS", value:0, unit:"g_S/m3", descr:"Total Sulfur in influent" },

//metals
{id:"Ag",  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Silver"     },
{id:"Al",  value:1.0379,  unit:"g/m3", isMetal:true, descr:"Influent Aluminium"  },
{id:"As",  value:0.0009,  unit:"g/m3", isMetal:true, descr:"Influent Arsenic"    },
{id:"B" ,  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Boron"      },
{id:"Ba",  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Barium"     },
{id:"Be",  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Berilium"   },
{id:"Br",  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Bromine"    },
{id:"Ca",  value:50.834,  unit:"g/m3", isMetal:true, descr:"Influent Calcium"    },
{id:"Cd",  value:0.0003,  unit:"g/m3", isMetal:true, descr:"Influent Cadmium"    },
{id:"Cl",  value:30.031,  unit:"g/m3", isMetal:true, descr:"Influent Chlorine"   },
{id:"Co",  value:0.0016,  unit:"g/m3", isMetal:true, descr:"Influent Cobalt"     },
{id:"Cr",  value:0.0122,  unit:"g/m3", isMetal:true, descr:"Influent Chromium"   },
{id:"Cu",  value:0.0374,  unit:"g/m3", isMetal:true, descr:"Influent Copper"     },
{id:"F" ,  value:0.0328,  unit:"g/m3", isMetal:true, descr:"Influent Fluorine"   },
{id:"Fe",  value:7.0928,  unit:"g/m3", isMetal:true, descr:"Influent Iron"       },
{id:"Hg",  value:0.0002,  unit:"g/m3", isMetal:true, descr:"Influent Mercury"    },
{id:"I" ,  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Iodine"     },
{id:"K" ,  value:0.3989,  unit:"g/m3", isMetal:true, descr:"Influent Potassium"  },
{id:"Mg",  value:5.7071,  unit:"g/m3", isMetal:true, descr:"Influent Magnesium"  },
{id:"Mn",  value:0.0530,  unit:"g/m3", isMetal:true, descr:"Influent Manganese"  },
{id:"Mo",  value:0.0010,  unit:"g/m3", isMetal:true, descr:"Influent Molybdenum" },
{id:"Na",  value:2.1860,  unit:"g/m3", isMetal:true, descr:"Influent Sodium"     },
{id:"Ni",  value:0.0066,  unit:"g/m3", isMetal:true, descr:"Influent Nickel"     },
{id:"Pb",  value:0.0086,  unit:"g/m3", isMetal:true, descr:"Influent Lead"       },
{id:"Sb",  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Antimony"   },
{id:"Sc",  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Scandium"   },
{id:"Se",  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Selenium"   },
{id:"Si",  value:3.1263,  unit:"g/m3", isMetal:true, descr:"Influent Silicon"    },
{id:"Sn",  value:0.0034,  unit:"g/m3", isMetal:true, descr:"Influent Tin"        },
{id:"Sr",  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Strontium"  },
{id:"Ti",  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Titanium"   },
{id:"Tl",  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Thallium"   },
{id:"V" ,  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Vanadium"   },
{id:"W" ,  value:0.0000,  unit:"g/m3", isMetal:true, descr:"Influent Tungsten"   },
{id:"Zn",  value:0.1094,  unit:"g/m3", isMetal:true, descr:"Influent Zinc"       },

//orange and red inputs (advanced knowledge required)
{id:"bCOD_BOD_ratio",       value:1.6,   unit:"g_bCOD/g_BOD", color:"red",                      descr:"bCOD/BOD ratio"},
{id:"zb",                   value:500,   unit:"m",            color:"orange", isParameter:true, descr:"Site elevation above sea level (Affects O2 solubility)"},
{id:"Pressure",             value:95600, unit:"Pa",           color:"orange", isParameter:true, descr:"Pressure at site elevation"},
{id:"Df",                   value:4.4,   unit:"m",            color:"orange", isParameter:true, descr:"Liquid depth for aeration basin minus distance between tank bottom and point of air release for the  diffusers.  For  example:  4.9  m  -  0.5  m = 4.4 m"},
{id:"X_R",                  value:8000,  unit:"g/m3",         color:"orange", isParameter:true, descr:"Return sludge mass concentration"},
{id:"TSSe",                 value:1,     unit:"g/m3",         color:"orange", isParameter:true, descr:"Effluent design Total suspended solids"},
{id:"SRT",                  value:5,     unit:"d",            color:"red",    isParameter:true, descr:"Solids Retention Time"},
{id:"SOR",                  value:24,    unit:"m3/m2·d",      color:"red",    isParameter:true, descr:"Hydraulic application rate"},
{id:"SF",                   value:1.5,   unit:"&empty;",      color:"red",    isParameter:true, descr:"Peak to average TKN load : Safety factor for compute a design SRT (= SF·SRT_theoretical), (where  SRT_theoretical  =  1/µAOB)",  },
{id:"Anoxic_mixing_energy", value:5,     unit:"kW/1000_m3",   color:"red",    isParameter:true, descr:"Mixing energy for anoxic reactor"},
{id:"FeCl3_solution",       value:37,    unit:"%",            color:"red",    isParameter:true, descr:"Ferric chloride solution (%)"},
{id:"FeCl3_unit_weight",    value:1.35,  unit:"kg/L",         color:"red",    isParameter:true, descr:"Ferric chloride unit weight"},
{id:"days",                 value:15,    unit:"d",            color:"red",    isParameter:true, descr:"Time for the supply to be stored at the treatment facility" },

];

//getter function
function getInputById(id) {
	var ret=Inputs.filter(el=>{return id==el.id});
	if(ret.length==0){
		//console.error('Input id "'+id+'" not found');
		return false;
	}
	else if(ret.length>1){
		console.error('Input id is not unique. Please report this problem');
		return false;
	}
	return ret[0];
}

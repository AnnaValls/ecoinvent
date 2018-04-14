/**
  * Lists of all possible inputs for all technologies
  * 2) The "color" field is for frontend (orange and red means 'advanced knowledge required')
  */

var Inputs = [

//always required Q and T
{id:"Q", value:22700, unit:"m3/d", descr:"Flowrate",    },
{id:"T", value:12,    unit:"ºC",   descr:"Temperature", },

//always required 3 inputs: COD, TKN, TP
{id:"COD", value:300,  unit:"g/m3_as_O2", descr:"Total chemical oxygen demand", },
{id:"TKN", value:35,   unit:"g/m3_as_N",  descr:"Total Kjedahl nitrogen",       },
{id:"TP",  value:6,    unit:"g/m3_as_P",  descr:"Total phosphorus",             },

//inputs that can be estimated from COD TKN and TP
  {id:"BOD",         value:140,  unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Total 5d biochemical oxygen demand",                   },
  {id:"sBOD",        value:70,   unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Soluble BOD",                                          },
  {id:"sCOD",        value:132,  unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Soluble COD",                                          },
  {id:"bCOD",        value:224,  unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Biodegradable COD (a typical value is: bCOD=1.6·BOD)", },
  {id:"rbCOD",       value:80,   unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Readily biodegradable COD (bsCOD=complex+VFA)",        },
  {id:"VFA",         value:15,   unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Volatile Fatty Acids (Acetate)",                       },
  {id:"VSS",         value:60,   unit:"g/m3",          canBeEstimated:true, descr:"Volatile suspended solids",                            },
  {id:"TSS",         value:70,   unit:"g/m3",          canBeEstimated:true, descr:"Total suspended solids",                               },
  {id:"NH4",         value:25,   unit:"g/m3_as_N",     canBeEstimated:true, descr:"Ammonia influent",                                     },
  {id:"PO4",         value:5,    unit:"g/m3_as_P",     canBeEstimated:true, descr:"Ortophosphate influent",                               },
  {id:"Alkalinity",  value:140,  unit:"g/m3_as_CaCO3", canBeEstimated:true, descr:"Influent alkalinity",                                  },

//metals and other elements
  {id:"Ag", value:0.0000, unit:"g/m3_as_Ag", isMetal:true, descr:"Influent Silver",     },
  {id:"Al", value:1.0379, unit:"g/m3_as_Al", isMetal:true, descr:"Influent Aluminium",  },
  {id:"As", value:0.0009, unit:"g/m3_as_As", isMetal:true, descr:"Influent Arsenic",    },
  {id:"B" , value:0.0000, unit:"g/m3_as_B",  isMetal:true, descr:"Influent Boron",      },
  {id:"Ba", value:0.0000, unit:"g/m3_as_Ba", isMetal:true, descr:"Influent Barium",     },
  {id:"Be", value:0.0000, unit:"g/m3_as_Be", isMetal:true, descr:"Influent Beryllium",  },
  {id:"Br", value:0.0000, unit:"g/m3_as_Br", isMetal:true, descr:"Influent Bromine",    },
  {id:"Ca", value:50.834, unit:"g/m3_as_Ca", isMetal:true, descr:"Influent Calcium",    },
  {id:"Cd", value:0.0003, unit:"g/m3_as_Cd", isMetal:true, descr:"Influent Cadmium",    },
  {id:"Cl", value:30.031, unit:"g/m3_as_Cl", isMetal:true, descr:"Influent Chlorine",   },
  {id:"Co", value:0.0016, unit:"g/m3_as_Co", isMetal:true, descr:"Influent Cobalt",     },
  {id:"Cr", value:0.0122, unit:"g/m3_as_Cr", isMetal:true, descr:"Influent Chromium",   },
  {id:"Cu", value:0.0374, unit:"g/m3_as_Cu", isMetal:true, descr:"Influent Copper",     },
  {id:"F" , value:0.0328, unit:"g/m3_as_F",  isMetal:true, descr:"Influent Fluorine",   },
  {id:"Fe", value:7.0928, unit:"g/m3_as_Fe", isMetal:true, descr:"Influent Iron",       },
  {id:"Hg", value:0.0002, unit:"g/m3_as_Hg", isMetal:true, descr:"Influent Mercury",    },
  {id:"I" , value:0.0000, unit:"g/m3_as_I",  isMetal:true, descr:"Influent Iodine",     },
  {id:"K" , value:0.3989, unit:"g/m3_as_K",  isMetal:true, descr:"Influent Potassium",  },
  {id:"Mg", value:5.7071, unit:"g/m3_as_Mg", isMetal:true, descr:"Influent Magnesium",  },
  {id:"Mn", value:0.0530, unit:"g/m3_as_Mn", isMetal:true, descr:"Influent Manganese",  },
  {id:"Mo", value:0.0010, unit:"g/m3_as_Mo", isMetal:true, descr:"Influent Molybdenum", },
  {id:"Na", value:2.1860, unit:"g/m3_as_Na", isMetal:true, descr:"Influent Sodium",     },
  {id:"Ni", value:0.0066, unit:"g/m3_as_Ni", isMetal:true, descr:"Influent Nickel",     },
  {id:"Pb", value:0.0086, unit:"g/m3_as_Pb", isMetal:true, descr:"Influent Lead",       },
  {id:"Sb", value:0.0000, unit:"g/m3_as_Sb", isMetal:true, descr:"Influent Antimony",   },
  {id:"Sc", value:0.0000, unit:"g/m3_as_Sc", isMetal:true, descr:"Influent Scandium",   },
  {id:"Se", value:0.0000, unit:"g/m3_as_Se", isMetal:true, descr:"Influent Selenium",   },
  {id:"Si", value:3.1263, unit:"g/m3_as_Si", isMetal:true, descr:"Influent Silicon",    },
  {id:"Sn", value:0.0034, unit:"g/m3_as_Sn", isMetal:true, descr:"Influent Tin",        },
  {id:"Sr", value:0.0000, unit:"g/m3_as_Sr", isMetal:true, descr:"Influent Strontium",  },
  {id:"Ti", value:0.0000, unit:"g/m3_as_Ti", isMetal:true, descr:"Influent Titanium",   },
  {id:"Tl", value:0.0000, unit:"g/m3_as_Tl", isMetal:true, descr:"Influent Thallium",   },
  {id:"V" , value:0.0000, unit:"g/m3_as_V",  isMetal:true, descr:"Influent Vanadium",   },
  {id:"W" , value:0.0000, unit:"g/m3_as_W",  isMetal:true, descr:"Influent Tungsten",   },
  {id:"Zn", value:0.1094, unit:"g/m3_as_Zn", isMetal:true, descr:"Influent Zinc",       },

//CSO removal rates
{id:"CSO_particulate",  value:1, unit:"%", isParameter:true,  descr:"Removal of particulate fractions by Combined Sewer Overflow", },
{id:"CSO_soluble",      value:2, unit:"%", isParameter:true,  descr:"Removal of soluble fractions by Combined Sewer Overflow",     },

//primary settler removal rates
{id:"removal_bpCOD",   value:40,    unit:"%", isParameter:true,  descr:"Primary settler bpCOD removal rate (25 to 60% for municipal wastewater)",   },
{id:"removal_nbpCOD",  value:60,    unit:"%", isParameter:true,  descr:"Primary settler nbpCOD removal rate (40 to 80% for municipal wastewater)",  },
{id:"removal_ON",      value:66.6,  unit:"%", isParameter:true,  descr:"Primary settler ON removal rate (66% for municipal wastewater)",            },
{id:"removal_OP",      value:66.6,  unit:"%", isParameter:true,  descr:"Primary settler OP removal rate (66% for municipal wastewater)",            },
{id:"removal_iTSS",    value:70,    unit:"%", isParameter:true,  descr:"Primary settler iTSS removal rate (50 to 90% for municipal wastewater)",    },

//Population equivalents
{id:"PEq", value:50000, unit:"population equivalents", isParameter:true, descr:"Population equivalents", },

//effluent design parameters
{id:"NH4_eff", value:0.50, unit:"g/m3_as_N", isParameter:true, descr:"Effluent design NH4",                                                       },
{id:"NO3_eff", value:6,    unit:"g/m3_as_N", isParameter:true, descr:"Effluent design NO3 concentration", },
{id:"PO4_eff", value:0.5,  unit:"g/m3_as_P", isParameter:true, descr:"Effluent design_PO4(3-). It is only imposed in case we have Chemical P removal. Otherwise, it will be calculated", },

//COD/TOC ratio for: COD/ratio = carbon content
{id:"COD_TOC_ratio", value:3.0,  unit:"g_COD/g_TOC", isParameter:true, descr:"COD to TOC ratio. It is used to calculate the TOC content of the wastewater", },

//emitted CO2 fossil fraction
{id:"fossil_CO2_percent", value:3.6,  unit:"%", isParameter:true, descr:"Percentage of CO2 emitted which is non-biogenic (fossil)", },

//bod removal design parameters
{id:"MLSS_X_TSS", value:3000,  unit:"g/m3",        isParameter:true,  descr:"Mixed liquor suspended solids",                                             },
{id:"DO",         value:2.0,   unit:"g/m3_as_O2",  isParameter:true,  descr:"DO in aeration basin (generally: 1.5 to 2) (notation in book is 'C_L')",    },
{id:"clarifiers", value:3,     unit:"clarifiers",  isParameter:true,  descr:"Number of clarifiers that will be used",                                    },

//orange and red design parameters
//("color" means "advanced knowledge required" in frontend)

//nitrification dp
{id:"sBODe",                value:3,     unit:"g/m3_as_O2", color:"orange", isParameter:true, descr:"Effluent design Soluble BOD", },
{id:"TSSe",                 value:1,     unit:"g/m3",       color:"orange", isParameter:true, descr:"Effluent design total suspended solids", },
{id:"zb",                   value:500,   unit:"m",          color:"orange", isParameter:true, descr:"Site elevation above sea level (affects O2 solubility)", },
{id:"Pressure",             value:95600, unit:"Pa",         color:"orange", isParameter:true, descr:"Pressure at site elevation (affects O2 solubility)", },
{id:"Df",                   value:4.4,   unit:"m",          color:"orange", isParameter:true, descr:"Liquid depth for aeration basin minus distance between tank bottom and point of air release for the diffusers. For example: 4.9 m - 0.5 m = 4.4 m", },
{id:"h_settler",            value:4,     unit:"m",          color:"orange", isParameter:true, descr:"Height of secondary settler", },
{id:"X_R",                  value:8000,  unit:"g/m3",       color:"orange", isParameter:true, descr:"Return sludge mass concentration", },
{id:"SRT",                  value:5,     unit:"d",          color:"red",    isParameter:true, descr:"Solids Retention Time", },
{id:"SOR",                  value:24,    unit:"m3/m2·d",    color:"red",    isParameter:true, descr:"Surface Overflow Rate or Hydraulic application rate", },
{id:"SF",                   value:1.5,   unit:"&empty;",    color:"red",    isParameter:true, descr:"Peak to average TKN load: nitrification safety factor (sf) for computing the design SRT (=SF·1/µAOB)",  },
{id:"Anoxic_mixing_energy", value:5,     unit:"kW/1000_m3", color:"red",    isParameter:true, descr:"Mixing energy for anoxic reactor (denitrification)", },
{id:"FeCl3_solution",       value:40,    unit:"%",          color:"red",    isParameter:true, descr:"Ferric chloride solution (%) (for chemical P removal)", },
{id:"FeCl3_unit_weight",    value:1.35,  unit:"kg/L",       color:"red",    isParameter:true, descr:"Ferric chloride unit weight (for chemical P removal)", },
{id:"days",                 value:15,    unit:"d",          color:"red",    isParameter:true, descr:"Time for the FeCl3 supply to be stored at the treatment facility (for chemical P removal)" },

//influent pumping
{id:"influent_H",           value:10,    unit:"m",          color:"red",    isParameter:true, descr:"Influent pumping water lift height and friction head in m", },

/*inputs end*/];

//getter function
function getInputById(id){
	var ret=Inputs.filter(el=>{return id==el.id});
	if(ret.length==0){
		return false;
	}else if(ret.length>1){
		console.error('Input id is not unique. Please report this problem');
		return false;
	}
	return ret[0];
}

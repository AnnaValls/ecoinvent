/**
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

//Q and T
{id:"Q", value:22700, unit:"m3/d", descr:"Flowrate",    },
{id:"T", value:12,    unit:"ºC",   descr:"Temperature", },

//fractionation
{id:"COD", value:300,  unit:"g/m3_as_O2", descr:"Total_chemical_oxygen_demand", },
{id:"TKN", value:35,   unit:"g/m3_as_N",  descr:"Total_Kjedahl_nitrogen",       },
{id:"TP",  value:6,    unit:"g/m3_as_P",  descr:"Total_phosphorus",             },

//inputs that can be estimated from COD TKN and TP
{id:"BOD",         value:140,  unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Total_5d_biochemical_oxygen_demand",                   },
{id:"sBOD",        value:70,   unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Soluble_BOD",                                          },
{id:"sCOD",        value:132,  unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Soluble_COD",                                          },
{id:"bCOD",        value:224,  unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Biodegradable_COD_(a_typical_value_is:_bCOD=1.6·BOD)", },
{id:"rbCOD",       value:80,   unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Readily_biodegradable_COD_(bsCOD=complex+VFA)",        },
{id:"VFA",         value:15,   unit:"g/m3_as_O2",    canBeEstimated:true, descr:"Volatile_Fatty_Acids_(Acetate)",                       },
{id:"VSS",         value:60,   unit:"g/m3",          canBeEstimated:true, descr:"Volatile_suspended_solids",                            },
{id:"TSS",         value:70,   unit:"g/m3",          canBeEstimated:true, descr:"Total_suspended_solids",                               },
{id:"NH4",         value:25,   unit:"g/m3_as_N",     canBeEstimated:true, descr:"Ammonia_influent",                                     },
{id:"PO4",         value:5,    unit:"g/m3_as_P",     canBeEstimated:true, descr:"Ortophosphate_influent",                               },
{id:"Alkalinity",  value:140,  unit:"g/m3_as_CaCO3", canBeEstimated:true, descr:"Influent_alkalinity",                                  },

//CSO removal
{id:"CSO_particulate",  value:1, unit:"%", isParameter:true,  descr:"Removal_of_particulate_fractions_by_Combined_Sewer_Overflow", },
{id:"CSO_soluble",      value:2, unit:"%", isParameter:true,  descr:"Removal_of_soluble_fractions_by_Combined_Sewer_Overflow",     },

//primary settler
{id:"removal_bpCOD",   value:40,    unit:"%", isParameter:true,  descr:"Primary_settler_bpCOD_removal_rate_(25_to_60%_for_municipal_wastewater)",   },
{id:"removal_nbpCOD",  value:60,    unit:"%", isParameter:true,  descr:"Primary_settler_nbpCOD_removal_rate_(40_to_80%_for_municipal_wastewater)",  },
{id:"removal_ON",      value:66.6,  unit:"%", isParameter:true,  descr:"Primary_settler_ON_removal_rate_(66%_for_municipal_wastewater)",            },
{id:"removal_OP",      value:66.6,  unit:"%", isParameter:true,  descr:"Primary_settler_OP_removal_rate_(66%_for_municipal_wastewater)",            },
{id:"removal_iTSS",    value:70,    unit:"%", isParameter:true,  descr:"Primary_settler_iTSS_removal_rate_(50_to_90%_for_municipal_wastewater)",    },

//Population equivalents
{id:"PEq", value:50000, unit:"population equivalents", isParameter:true, descr:"Population equivalents", },

//effluent design parameters
{id:"NH4_eff", value:0.50, unit:"g/m3_as_N", isParameter:true, descr:"Effluent_design_NH4",                                                       },
{id:"NO3_eff", value:6,    unit:"g/m3_as_N", isParameter:true, descr:"Effluent_design_NO3_concentration", },
{id:"PO4_eff", value:0.5,  unit:"g/m3_as_P", isParameter:true, descr:"Effluent_design_PO4(3-)._It_is_only_imposed_in_case_we_have_Chemical_P_removal._Otherwise,_it_will_be_calculated", },

//COD/TOC ratio for: COD/ratio = carbon content
{id:"COD_TOC_ratio", value:3.0,  unit:"g_COD/g_TOC", isParameter:true, descr:"COD to TOC ratio. It is used to calculate the TOC content of the wastewater", },

//bod removal dp
{id:"MLSS_X_TSS", value:3000,  unit:"g/m3",        isParameter:true,  descr:"Mixed_liquor_suspended_solids",                                             },
{id:"DO",         value:2.0,   unit:"g/m3_as_O2",  isParameter:true,  descr:"DO_in_aeration_basin_(generally:_1.5_to_2)_(notation_in_book_is_'C_L')",    },
{id:"clarifiers", value:3,     unit:"clarifiers",  isParameter:true,  descr:"Number_of_clarifiers_that_will_be_used",                                    },

//metals
  {id:"Ag", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Silver",     },
  {id:"Al", value:1.0379, unit:"g/m3", isMetal:true, descr:"Influent_Aluminium",  },
  {id:"As", value:0.0009, unit:"g/m3", isMetal:true, descr:"Influent_Arsenic",    },
  {id:"B" , value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Boron",      },
  {id:"Ba", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Barium",     },
  {id:"Be", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Beryllium",  },
  {id:"Br", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Bromine",    },
  {id:"Ca", value:50.834, unit:"g/m3", isMetal:true, descr:"Influent_Calcium",    },
  {id:"Cd", value:0.0003, unit:"g/m3", isMetal:true, descr:"Influent_Cadmium",    },
  {id:"Cl", value:30.031, unit:"g/m3", isMetal:true, descr:"Influent_Chlorine",   },
  {id:"Co", value:0.0016, unit:"g/m3", isMetal:true, descr:"Influent_Cobalt",     },
  {id:"Cr", value:0.0122, unit:"g/m3", isMetal:true, descr:"Influent_Chromium",   },
  {id:"Cu", value:0.0374, unit:"g/m3", isMetal:true, descr:"Influent_Copper",     },
  {id:"F" , value:0.0328, unit:"g/m3", isMetal:true, descr:"Influent_Fluorine",   },
  {id:"Fe", value:7.0928, unit:"g/m3", isMetal:true, descr:"Influent_Iron",       },
  {id:"Hg", value:0.0002, unit:"g/m3", isMetal:true, descr:"Influent_Mercury",    },
  {id:"I" , value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Iodine",     },
  {id:"K" , value:0.3989, unit:"g/m3", isMetal:true, descr:"Influent_Potassium",  },
  {id:"Mg", value:5.7071, unit:"g/m3", isMetal:true, descr:"Influent_Magnesium",  },
  {id:"Mn", value:0.0530, unit:"g/m3", isMetal:true, descr:"Influent_Manganese",  },
  {id:"Mo", value:0.0010, unit:"g/m3", isMetal:true, descr:"Influent_Molybdenum", },
  {id:"Na", value:2.1860, unit:"g/m3", isMetal:true, descr:"Influent_Sodium",     },
  {id:"Ni", value:0.0066, unit:"g/m3", isMetal:true, descr:"Influent_Nickel",     },
  {id:"Pb", value:0.0086, unit:"g/m3", isMetal:true, descr:"Influent_Lead",       },
  {id:"Sb", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Antimony",   },
  {id:"Sc", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Scandium",   },
  {id:"Se", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Selenium",   },
  {id:"Si", value:3.1263, unit:"g/m3", isMetal:true, descr:"Influent_Silicon",    },
  {id:"Sn", value:0.0034, unit:"g/m3", isMetal:true, descr:"Influent_Tin",        },
  {id:"Sr", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Strontium",  },
  {id:"Ti", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Titanium",   },
  {id:"Tl", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Thallium",   },
  {id:"V" , value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Vanadium",   },
  {id:"W" , value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Tungsten",   },
  {id:"Zn", value:0.1094, unit:"g/m3", isMetal:true, descr:"Influent_Zinc",       },

//orange and red design parameters
//("color" means "advanced knowledge required" in frontend)

//nitrification dp
{id:"sBODe",   value:3,    unit:"g/m3_as_O2", color:"orange", isParameter:true, descr:"Effluent_design_Soluble_BOD",                                               },
{id:"TSSe",    value:1,    unit:"g/m3",       color:"orange", isParameter:true, descr:"Effluent design total suspended solids", },

{id:"zb",                   value:500,   unit:"m",          color:"orange", isParameter:true, descr:"Site elevation above sea level (affects O2 solubility)", },
{id:"Pressure",             value:95600, unit:"Pa",         color:"orange", isParameter:true, descr:"Pressure at site elevation (affects O2 solubility)", },
{id:"Df",                   value:4.4,   unit:"m",          color:"orange", isParameter:true, descr:"Liquid depth for aeration basin minus distance between tank bottom and point of air release for the  diffusers.  For  example:  4.9  m  -  0.5  m = 4.4 m", },

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

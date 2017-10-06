/*
 * Lists of all possible inputs for all technologies
 * To confirm:
 *   TSS_was is X_R ? 
 *   NO3_eff is NOx_e ?
 */
var Inputs = [

//bod removal
{id:"Q",              value:22700, unit:"m3/d", descr:"Flowrate"                           },
{id:"T",              value:12,    unit:"ºC",   descr:"Temperature"                        },
{id:"SRT",            value:5,     unit:"d",    descr:"Solids Retention Time"              },
{id:"BOD",            value:140,   unit:"g/m3", descr:"Total 5d biochemical oxygen demand" },
{id:"sBOD",           value:70,    unit:"g/m3", descr:"Soluble BOD"                        },
{id:"COD",            value:300,   unit:"g/m3", descr:"Total chemical oxygen demand"       },
{id:"sCOD",           value:132,   unit:"g/m3", descr:"Soluble COD"                        },
{id:"TSS",            value:70,    unit:"g/m3", descr:"Total suspended solids"             },
{id:"VSS",            value:60,    unit:"g/m3", descr:"Volatile suspended solids"          },
{id:"bCOD_BOD_ratio", value:1.6,   unit:"g/g",  descr:"bCOD/BOD ratio"                     },
{id:"MLSS_X_TSS",     value:3000,  unit:"g/m3", descr:"Mixed liquor suspended solids"      },
{id:"zb",             value:500,   unit:"m",    descr:"Site elevation"                     },
{id:"Pressure",       value:95600, unit:"Pa",   descr:"Pressure at site elevation"         },
{id:"Df",             value:4.4,   unit:"m",    descr:"Liquid depth for aeration basin minus distance between tank bottom and point of air release for the  diffusers.  For  example:  4.9  m  -  0.5  m  =  4.4  m" },

//nitrification
{id:"TKN",        value:35,   unit:"g/m3",          descr:"Total Kjedahl nitrogen"                 },
{id:"SF",         value:1.5,  unit:"&empty;",       descr:"Peak to average TKN load : Safety factor for compute a design SRT (= SF·SRT_theoretical), (where  SRT_theoretical  =  1/µAOB)",  },
{id:"Ne",         value:0.50, unit:"g/m3",          descr:"Effluent design NH4"                    },
{id:"sBODe",      value:3,    unit:"g/m3",          descr:"Effluent design Soluble BOD"            },
{id:"TSSe",       value:10,   unit:"g/m3",          descr:"Effluent design Total suspended solids" },
{id:"Alkalinity", value:140,  unit:"g/m3_as_CaCO3", descr:"Influent alkalinity"                    },

//N removal
{id:"bCOD",                  value:224,   unit:"g/m3",       descr:"Biodegradable COD"                },
{id:"rbCOD",                 value:80,    unit:"g/m3",       descr:"Readily biodegradable COD"        },
{id:"NOx",                   value:28.9,  unit:"g/m3",       descr:"Nitrogen oxidized to nitrate"     },
{id:"MLVSS",                 value:2370,  unit:"g/m3",       descr:"Mixed Liquor VSS"                 },
{id:"Aerobic_SRT",           value:21,    unit:"d",          descr:""                                 },
{id:"Aeration_basin_volume", value:13410, unit:"m3",         descr:""                                 },
{id:"Aerobic_T",             value:14.2,  unit:"h",          descr:"Aerobic detention time"           },
{id:"Anoxic_mixing_energy",  value:5,     unit:"kW/1000_m3", descr:"Mixing energy for anoxic reactor" },
{id:"RAS",                   value:0.6,   unit:"&empty;",    descr:"Return sludge recycle ratio"      },
{id:"Ro",                    value:275.9, unit:"kg_O2/h",    descr:"O2 demand"                        },

//sst
{id:"SOR",        value:24,   unit:"m3/m2·d",    descr:"Hydraulic application rate"             },
{id:"X_R",        value:8000, unit:"g/m3",       descr:"Return sludge mass concentration"       },
{id:"clarifiers", value:3,    unit:"clarifiers", descr:"Number of clarifiers that will be used" },

//bio P
{id:"VFA",             value:15,  unit:"g/m3", descr:"Volatile Fatty Acids (Acetate)"    },
{id:"nbVSS",           value:20,  unit:"g/m3", descr:"Nonbiodegradable VSS"              },
{id:"iTSS",            value:10,  unit:"g/m3", descr:"Inert TSS"                         },
{id:"TP",              value:6,   unit:"g/m3", descr:"Total phosphorus"                  },
{id:"rbCOD_NO3_ratio", value:5.2, unit:"g/g",  descr:"rbCOD/NO3-N ratio"                 },
{id:"NO3_eff",         value:6,   unit:"g/m3", descr:"Effluent design NO3 concentration" },

//chem P
{id:"TSS_removal_w_Fe",  value:75,   unit:"%",    descr:"% TSS removal with iron addition"                           },
{id:"TSS_removal_wo_Fe", value:60,   unit:"%",    descr:"% TSS removal without iron addition"                        },
{id:"C_PO4_inf",         value:5,    unit:"g/m3", descr:"Influent PO4(3-)"                                           },
{id:"C_PO4_eff",         value:0.1,  unit:"g/m3", descr:"Effluent design PO4(3-)"                                    },
{id:"FeCl3_solution",    value:37,   unit:"%",    descr:"Ferric chloride solution (%)"                               },
{id:"FeCl3_unit_weight", value:1.35, unit:"kg/L", descr:"Ferric chloride unit weight"                                },
{id:"days",              value:15,   unit:"d",    descr:"Time for the supply to be stored at the treatment facility" },

];
//end Inputs

//getter
function getInputById(id)
{
	var ret=Inputs.filter(el=>{return id==el.id});
	if(ret.length==0){ 
		console.error('Input id not found'); 
		return false;
	}
	else if(ret.length>1){ 
		console.error('Input id is not unique. Please report this problem');
		return false;
	}
	return ret[0];
}


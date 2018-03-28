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
{id:"Q",  value:22700,  unit:"m3/d",  descr:"Flowrate",     },
{id:"T",  value:12,     unit:"ºC",    descr:"Temperature",  },

//fractionation
{id:"BOD",         value:140,  unit:"g/m3_as_O2",     descr:"Total_5d_biochemical_oxygen_demand",                    ecoinvent_id:"dd13a45c-ddd8-414d-821f-dfe31c7d2868",   },
{id:"sBOD",        value:70,   unit:"g/m3_as_O2",     descr:"Soluble_BOD",                                           ecoinvent_id:null,                                     },
{id:"COD",         value:300,  unit:"g/m3_as_O2",     descr:"Total_chemical_oxygen_demand",                          ecoinvent_id:"3f469e9e-267a-4100-9f43-4297441dc726",   },
{id:"sCOD",        value:132,  unit:"g/m3_as_O2",     descr:"Soluble_COD",                                           ecoinvent_id:null},
{id:"bCOD",        value:224,  unit:"g/m3_as_O2",     descr:"Biodegradable_COD_(a_typical_value_is:_bCOD=1.6·BOD)",  ecoinvent_id:null},
{id:"rbCOD",       value:80,   unit:"g/m3_as_O2",     descr:"Readily_biodegradable_COD_(bsCOD=complex+VFA)",         ecoinvent_id:null},
{id:"VFA",         value:15,   unit:"g/m3_as_O2",     descr:"Volatile_Fatty_Acids_(Acetate)",                        ecoinvent_id:null},
{id:"VSS",         value:60,   unit:"g/m3",           descr:"Volatile_suspended_solids",                             ecoinvent_id:null},
{id:"TSS",         value:70,   unit:"g/m3",           descr:"Total_suspended_solids",                                ecoinvent_id:null},
{id:"TKN",         value:35,   unit:"g/m3_as_N",      descr:"Total_Kjedahl_nitrogen",                                ecoinvent_id:null},
{id:"NH4",         value:25,   unit:"g/m3_as_N",      descr:"Ammonia_influent",                                      ecoinvent_id:"f7fa53fa-ee5f-4a97-bcd8-1b0851afe9a6"},
{id:"TP",          value:6,    unit:"g/m3_as_P",      descr:"Total_phosphorus",                                      ecoinvent_id:"8e73d3fb-bb81-4c42-bfa6-8be4ff13125d"},
{id:"PO4",         value:5,    unit:"g/m3_as_P",      descr:"Ortophosphate_influent",                                ecoinvent_id:"7fe01cf6-6e7b-487f-b37e-32388640a8a4"},
{id:"Alkalinity",  value:140,  unit:"g/m3_as_CaCO3",  descr:"Influent_alkalinity",                                   ecoinvent_id:null},

//CSO removal
{id:"CSO_particulate",  value:1,     unit:"%",           isParameter:true,  descr:"Removal_of_particulate_fractions_by_Combined_Sewer_Overflow",               },
{id:"CSO_soluble",      value:2,     unit:"%",           isParameter:true,  descr:"Removal_of_soluble_fractions_by_Combined_Sewer_Overflow",                   },

//primary settler
{id:"removal_bpCOD",    value:40,    unit:"%",           isParameter:true,  descr:"Primary_settler_bpCOD_removal_rate_(25_to_60%_for_municipal_wastewater)",   },
{id:"removal_nbpCOD",   value:60,    unit:"%",           isParameter:true,  descr:"Primary_settler_nbpCOD_removal_rate_(40_to_80%_for_municipal_wastewater)",  },
{id:"removal_ON",       value:66.6,  unit:"%",           isParameter:true,  descr:"Primary_settler_ON_removal_rate_(66%_for_municipal_wastewater)",            },
{id:"removal_OP",       value:66.6,  unit:"%",           isParameter:true,  descr:"Primary_settler_OP_removal_rate_(66%_for_municipal_wastewater)",            },
{id:"removal_iTSS",     value:70,    unit:"%",           isParameter:true,  descr:"Primary_settler_iTSS_removal_rate_(50_to_90%_for_municipal_wastewater)",    },

//bod removal dp
{id:"MLSS_X_TSS",       value:3000,  unit:"g/m3",        isParameter:true,  descr:"Mixed_liquor_suspended_solids",                                             },
{id:"DO",               value:2.0,   unit:"g/m3_as_O2",  isParameter:true,  descr:"DO_in_aeration_basin_(generally:_1.5_to_2)_(notation_in_book_is_'C_L')",    },
{id:"clarifiers",       value:3,     unit:"clarifiers",  isParameter:true,  descr:"Number_of_clarifiers_that_will_be_used",                                    },

//nitrification dp
{id:"sBODe",            value:3,     unit:"g/m3_as_O2",  isParameter:true,  descr:"Effluent_design_Soluble_BOD",                                               },
{id:"NH4_eff",          value:0.50,  unit:"g/m3_as_N",   isParameter:true,  descr:"Effluent_design_NH4",                                                       },

//N removal dp
{id:"NO3_eff", value:6,   unit:"g/m3_as_N", isParameter:true, descr:"Effluent_design_NO3_concentration", },

//chem P dp
{id:"PO4_eff", value:0.1, unit:"g/m3_as_P", isParameter:true, descr:"Effluent_design_PO4(3-)._It_is_only_imposed_in_case_we_have_Chemical_P_removal._Otherwise,_it_will_be_calculated", },

//metals
{id:"Ag", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Silver",     ecoinvent_id:"dcdc6c7b-0b72-4174-bc90-f51ed66426d5", },
{id:"Al", value:1.0379, unit:"g/m3", isMetal:true, descr:"Influent_Aluminium",  ecoinvent_id:"77154d2e-4b05-48f2-a89a-789acd170497", },
{id:"As", value:0.0009, unit:"g/m3", isMetal:true, descr:"Influent_Arsenic",    ecoinvent_id:"b321f120-4db7-4e7c-a196-82a231023052", },
{id:"B" , value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Boron",      ecoinvent_id:"c0447419-7139-44fe-a855-ea71e2b78585", },
{id:"Ba", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Barium",     ecoinvent_id:"33976f6b-2575-4410-8f60-d421bdf3e554", },
{id:"Be", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Berilium",   ecoinvent_id:"d21c7c5c-b2c2-43ae-8575-c377cc0b0495", },
{id:"Br", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Bromine",    ecoinvent_id:"e4504511-88b5-4b01-a537-e049f056668c", },
{id:"Ca", value:50.834, unit:"g/m3", isMetal:true, descr:"Influent_Calcium",    ecoinvent_id:"ddbab0d1-b156-41bc-98e5-fb680285d7cd", },
{id:"Cd", value:0.0003, unit:"g/m3", isMetal:true, descr:"Influent_Cadmium",    ecoinvent_id:"1111ac7e-20df-4ab4-9e02-57821894372c", },
{id:"Cl", value:30.031, unit:"g/m3", isMetal:true, descr:"Influent_Chlorine",   ecoinvent_id:"468e50e8-1960-4eba-bc1a-a9938a301694", },
{id:"Co", value:0.0016, unit:"g/m3", isMetal:true, descr:"Influent_Cobalt",     ecoinvent_id:"2f7030b9-bafc-4b43-8504-deb8b5044130", },
{id:"Cr", value:0.0122, unit:"g/m3", isMetal:true, descr:"Influent_Chromium",   ecoinvent_id:"bca4bb32-f701-46bb-ba1e-bad477c19f7f", },
{id:"Cu", value:0.0374, unit:"g/m3", isMetal:true, descr:"Influent_Copper",     ecoinvent_id:"e7451d8a-77af-44e0-86cf-ccd17ac84509", },
{id:"F" , value:0.0328, unit:"g/m3", isMetal:true, descr:"Influent_Fluorine",   ecoinvent_id:"763a698f-54d7-4e2a-84a7-9cc8c0271b6a", },
{id:"Fe", value:7.0928, unit:"g/m3", isMetal:true, descr:"Influent_Iron",       ecoinvent_id:"ebf21bca-b7cf-45d0-9d82-bfb80519a970", },
{id:"Hg", value:0.0002, unit:"g/m3", isMetal:true, descr:"Influent_Mercury",    ecoinvent_id:"a102e6f8-ebc7-450b-a39b-794be96558b7", },
{id:"I" , value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Iodine",     ecoinvent_id:"e9164ff3-fd2d-4050-895d-0e0a42317be2", },
{id:"K" , value:0.3989, unit:"g/m3", isMetal:true, descr:"Influent_Potassium",  ecoinvent_id:"8b49eeb7-9caf-4101-b516-eb0aef30d530", },
{id:"Mg", value:5.7071, unit:"g/m3", isMetal:true, descr:"Influent_Magnesium",  ecoinvent_id:"d26c0a60-86aa-41c8-80ee-3acabc4a5095", },
{id:"Mn", value:0.0530, unit:"g/m3", isMetal:true, descr:"Influent_Manganese",  ecoinvent_id:"8d27623b-147c-44e8-93cc-2183eac22991", },
{id:"Mo", value:0.0010, unit:"g/m3", isMetal:true, descr:"Influent_Molybdenum", ecoinvent_id:"aa897226-0a91-40e5-aa05-4bae3b9e4213", },
{id:"Na", value:2.1860, unit:"g/m3", isMetal:true, descr:"Influent_Sodium",     ecoinvent_id:"7b656e1b-bc07-41cd-bad4-a5b51b6287da", },
{id:"Ni", value:0.0066, unit:"g/m3", isMetal:true, descr:"Influent_Nickel",     ecoinvent_id:"8b574e85-ff07-46bf-a753-f1271299dcf7", },
{id:"Pb", value:0.0086, unit:"g/m3", isMetal:true, descr:"Influent_Lead",       ecoinvent_id:"71bc04b9-abfe-4f30-ab8f-ba654c7ad296", },
{id:"Sb", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Antimony",   ecoinvent_id:"3759d833-560a-4dbb-949e-afc63c0ade26", },
{id:"Sc", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Scandium",   ecoinvent_id:"1325d7f9-2fe2-4226-9304-ad9e5371e08f", },
{id:"Se", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Selenium",   ecoinvent_id:"c35265a9-fd3e-468c-af8e-f4e020c38fc0", },
{id:"Si", value:3.1263, unit:"g/m3", isMetal:true, descr:"Influent_Silicon",    ecoinvent_id:"67065577-4705-4ece-a892-6dd1d7ecd1e5", },
{id:"Sn", value:0.0034, unit:"g/m3", isMetal:true, descr:"Influent_Tin",        ecoinvent_id:"ff888459-10c3-4700-afce-3a024aaf89cf", },
{id:"Sr", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Strontium",  ecoinvent_id:"d574cc22-07f2-4202-b564-1116ab197692", },
{id:"Ti", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Titanium",   ecoinvent_id:"abc78955-bd5f-4b1a-9607-0448dd75ebf2", },
{id:"Tl", value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Thallium",   ecoinvent_id:"79baac3d-9e62-45ef-8f41-440dea32f11f", },
{id:"V" , value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Vanadium",   ecoinvent_id:"0b686a86-c506-4ad3-81fd-c3f39f05247d", },
{id:"W" , value:0.0000, unit:"g/m3", isMetal:true, descr:"Influent_Tungsten",   ecoinvent_id:"058d6d50-172b-4a8a-97da-0cee759eca7d", },
{id:"Zn", value:0.1094, unit:"g/m3", isMetal:true, descr:"Influent_Zinc",       ecoinvent_id:"6cc518c8-4769-40df-b2cf-03f9fe00b759", },

//orange and red design parameters
//("color" means "advanced knowledge required" in frontend)
{id:"zb",                   value:500,   unit:"m",          color:"orange", isParameter:true, descr:"Site elevation above sea level (affects O2 solubility)", },
{id:"Pressure",             value:95600, unit:"Pa",         color:"orange", isParameter:true, descr:"Pressure at site elevation (affects O2 solubility)", },
{id:"Df",                   value:4.4,   unit:"m",          color:"orange", isParameter:true, descr:"Liquid depth for aeration basin minus distance between tank bottom and point of air release for the  diffusers.  For  example:  4.9  m  -  0.5  m = 4.4 m", },
{id:"h_settler",            value:4,     unit:"m",          color:"orange", isParameter:true, descr:"Height of secondary settler", },
{id:"X_R",                  value:8000,  unit:"g/m3",       color:"orange", isParameter:true, descr:"Return sludge mass concentration", },
{id:"TSSe",                 value:1,     unit:"g/m3",       color:"orange", isParameter:true, descr:"Effluent design total suspended solids", },
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

//create a JSON sent to the python scripts that generate the ecospold files

function generate_ecospold(result){
  console.log('generating ecospold...');
  var data_set = generate_json_for_ecospold(result);
  var data_set_string=JSON.stringify(data_set);
  post('generate_ecospold.php', data_set_string, false);
}

function generate_json_for_ecospold(result){
  //json file fields
    //inputs
      var activity_name         = url.searchParams.get('activity_name')||"no name"; //ok
      var geography             = url.searchParams.get('geography')||"GLO";         //ok
      var untreated_fraction    = Geographies.find(g=>g.shortcut===geography).RQ;   //ok
      var tool_use_type         = url.searchParams.get('wwtp_type')||'specific';    //ok
      var PV                    = {value:Activity.Q*365.25, unit:"m3/year"};        //ok
      var CSO_particulate       = {value:WWTPs.map(w=>w.CSO_particulate*w.perc_PE/100).reduce((p,c)=>p+c)/100,    unit:"ratio"}; //ok
      var CSO_soluble           = {value:WWTPs.map(w=>w.CSO_soluble    *w.perc_PE/100).reduce((p,c)=>p+c)/100,    unit:"ratio"}; //ok
      var fraction_C_fossil     = {value:WWTPs.map(w=>w.fossil_CO2_percent*w.perc_PE/100).reduce((p,c)=>p+c)/100, unit:"ratio"}; //ok
      var COD_TOC_ratio         = {value:WWTPs.map(w=>w.COD_TOC_ratio  *w.perc_PE/100).reduce((p,c)=>p+c),        unit:Inputs.find(i=>i.id=='COD_TOC_ratio').unit}; //ok
      var technologies_averaged = []; //each reference wwtp data
      var WW_properties         = []; //Activity inputs

      //FILL ARRAYS
      //1. technologies_averaged
      WWTPs.forEach(wwtp=>{
        //implement ecoinvent classes 1,2,3a,3b,4,5
        var wwtp_class = (function(){
          var PEq = wwtp.PEq;
          if     (PEq>=100e3){return 'wastewater treatment facility, capacity class 1, greater than 100,000 PE';}
          else if(PEq>= 50e3){return 'wastewater treatment facility, capacity class 2, between 50,000 and 100,000 PE';}
          else if(PEq>= 20e3){return 'wastewater treatment facility, capacity class 3a, between 20,000 and 50,000 PE';}
          else if(PEq>= 10e3){return 'wastewater treatment facility, capacity class 3b, between 10,000 and 20,000 PE';}
          else if(PEq>=  2e3){return 'wastewater treatment facility, capacity class 4, between 2,000 and 10,000 PE';}
          else               {return 'wastewater treatment facility, capacity class 5, less than 2,000 PE';}
        })();
        //
        technologies_averaged.push({
          fraction: wwtp.perc_PE/100,
          capacity: wwtp.PEq,
          class: wwtp_class,
          location: "GLO",                                  //TODO we still don't have a database of wwtp by country/region
          technology_level_1: "aerobic intensive",          //fix for now
          technology_level_2: Tec_mix_encoder.encode(wwtp), //"binary string" see 'technology_mix_encoder.js'
        });
      });

      //2. WW_properties (ONLY g/m3)
      Object.keys(Activity).forEach(key=>{
        //first check the units of 'key'
        var unit=Inputs.find(i=>i.id==key).unit
        //           only g/m3   and value>0
        if(unit.includes('g/m3')) {
          var ecoinvent_id=Ecoinvent_ids.inputs[key]||false;
          WW_properties.push({
            id    : key,
            value : Activity[key]/1000, //convert g/m3 to kg/m3
            unit  : Inputs.find(i=>i.id==key).unit.replace('g/m3','kg/m3'),
            descr : Inputs.find(i=>i.id==key).descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("no ecoinvent id for '"+key+"' in 'inputs' (WW_properties)");}
        }
      });

    //outputs
      var chemicals = {
        NaHCO3 : {
          value: result.weighted_contribution.chemicals.alkalinity_added.value/Activity.Q,
          unit:  result.weighted_contribution.chemicals.alkalinity_added.unit.replace('kg/d','kg/m3'),
          descr: "NaHCO3 needed to maintain alkalinity",
        },
        acrylamide : {
          value: result.weighted_contribution.chemicals.Dewatering_polymer.value/Activity.Q,
          unit:  result.weighted_contribution.chemicals.Dewatering_polymer.unit.replace('kg/d','kg/m3'),
          descr: result.weighted_contribution.chemicals.Dewatering_polymer.descr,
        },
        FeCl3 : {
          value: result.weighted_contribution.chemicals.FeCl3_volume.value/Activity.Q,
          unit:  result.weighted_contribution.chemicals.FeCl3_volume.unit.replace('L/d','L/m3'),
          descr: result.weighted_contribution.chemicals.FeCl3_volume.descr,
        },
      };
      var electricity = {
        value: result.weighted_contribution.Ene.total_daily_energy.value/Activity.Q,
        unit:  result.weighted_contribution.Ene.total_daily_energy.unit.replace('kWh/d','kWh/m3'),
        descr: result.weighted_contribution.Ene.total_daily_energy.descr,
      };
      var CSO_amounts              = []; //discharged amounts
      var WWTP_influent_properties = []; //properties after CSO
      var WWTP_emissions_water     = []; //properties after treatment
      var WWTP_emissions_air       = []; //properties after treatment
      var WWTP_emissions_sludge    = []; //properties after treatment
      var sludge_properties        = []; //properties after treatment see 'techs/sludge_composition.js'
      var untreated_as_emissions   = []; //same as CSO, with 100% for both particulates and dissolved

      //FILL ARRAYS
      //1. CSO_amounts -- discharged by CSO
      Object.keys(result.weighted_contribution.CSO).forEach(key=>{
        var item=result.weighted_contribution.CSO[key];
        if(item.value && item.unit.includes("kg/d")){
          var key_replaced = key.replace('elem_','').replace('_discharged_kgd','');
          var ecoinvent_id=Ecoinvent_ids.water_emissions[key_replaced]||false;
          CSO_amounts.push({
            id    : key,
            value : item.value/Activity.Q,
            unit  : item.unit.replace('kg/d','kg/m3'),
            descr : item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("no ecoinvent id for '"+key_replaced+"' in 'water_emissions' (CSO_amounts)");}
        }
      });

      //2. WWTP_influent_properties: properties after CSO
      Object.keys(result.weighted_contribution.inputs_after_CSO).forEach(key=>{
        var item=result.weighted_contribution.inputs_after_CSO[key];
        var ecoinvent_id=Ecoinvent_ids.inputs[key]||false;
        if(true){
          WWTP_influent_properties.push({
            id:key,
            value:item.value/Activity.Q,
            unit:item.unit.replace('kg/d','kg/m3'),
            descr:item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("no ecoinvent id for '"+key+"' in 'inputs' (WWTP_influent_properties)");}
        }
      });

      //3. WWTP_emissions_water: properties after treatment
      Object.keys(result.weighted_contribution.Outputs).filter(key=>key.includes('effluent_water')).forEach(key=>{
        var item=result.weighted_contribution.Outputs[key];
        var key_replaced = key.replace('elem_','').replace('_effluent_water','');
        var ecoinvent_id=Ecoinvent_ids.water_emissions[key_replaced]||false;
        if(item.value){
          WWTP_emissions_water.push({
            id:key,
            value:item.value/1000/Activity.Q, //convert to kg/m3 from g/d
            unit:"kg/m3",
            descr:item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("no ecoinvent id for '"+key_replaced+"' in 'water_emissions' (WWTP_emissions_water)");}
        }
      });

      //4. WWTP_emissions_air: properties after treatment
      Object.keys(result.weighted_contribution.Outputs).filter(key=>key.includes('effluent_air')).forEach(key=>{
        var item=result.weighted_contribution.Outputs[key];
        var key_replaced = key.replace('elem_','').replace('_effluent_air','');
        var ecoinvent_id=Ecoinvent_ids.air_emissions[key_replaced]||false;
        if(item.value){
          WWTP_emissions_air.push({
            id:key,
            value:item.value/1000/Activity.Q, //convert to kg/m3 from g/d
            unit:"kg/m3",
            descr:item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("no ecoinvent id for '"+key_replaced+"' in 'air_emissions' (WWTP_emissions_air)");}
        }
      });

      //5. WWTP_emissions_sludge: properties after treatment
      Object.keys(result.weighted_contribution.Outputs).filter(key=>key.includes('effluent_sludge')).forEach(key=>{
        var item=result.weighted_contribution.Outputs[key];
        var key_replaced = key.replace('elem_','').replace('_effluent_sludge','');
        var ecoinvent_id=Ecoinvent_ids.sludge_emissions[key_replaced]||false;
        if(item.value){
          WWTP_emissions_sludge.push({
            id:key,
            value:item.value/1000/Activity.Q, //convert to kg/m3 from g/d
            unit:"kg/m3",
            descr:item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("no ecoinvent id for '"+key_replaced+"' in 'sludge_emissions' (WWTP_emissions_sludge)");}
        }
      });

      //6. sludge_properties: properties after treatment
      Object.keys(result.weighted_contribution.sludge_composition).forEach(key=>{
        var item=result.weighted_contribution.sludge_composition[key];
        var key_replaced = key
          .replace('_removed_kgd','')
          .replace('P_X_','')
          .replace('sludge_primary_','')
          .replace('sludge_secondary_','')
          .replace('_content','');
        var ecoinvent_id=Ecoinvent_ids.sludge_emissions[key_replaced]||false;
        if(item.value){
          sludge_properties.push({
            id:key,
            value:item.value/Activity.Q,
            unit:item.unit.replace('kg/d','kg/m3'),
            descr:item.descr,
            ecoinvent_id,
          });
          if(!ecoinvent_id){console.warn("no ecoinvent id for '"+key_replaced+"' in 'sludge_emissions' (sludge_properties)");}
        }
      });

      //7. untreated_as_emissions: same as CSO_amounts, with 100% for both particulates and dissolved
      (function(){
        //calculate a fractionation with just the activity and set the cso removal to 100%
        var A=Activity;
        var fra_activity=fractionation(A.BOD,A.sBOD,A.COD,A.bCOD,A.sCOD,A.rbCOD,A.TSS,A.VSS,A.TKN,A.NH4,A.TP,A.PO4);
        var cso_activity=cso_removal(fra_activity,Activity,100,100);
        Object.keys(cso_activity).filter(key=>cso_activity[key].unit.includes('g/m3')).forEach(key=>{
          var item = cso_activity[key];
          if(item.value){
            var key_replaced = key.replace('elem_','').replace('_discharged','');
            var ecoinvent_id=Ecoinvent_ids.water_emissions[key_replaced]||false;
            untreated_as_emissions.push({
              id:    key_replaced,
              value: item.value/1000, //convert g/m3 to kg/m3
              unit:  (Inputs.find(i=>i.id==key_replaced)||fra_activity[key_replaced]).unit.replace('g/m3','kg/m3'),
              descr: "untreated as emission for "+key_replaced,
              ecoinvent_id,
            });
            if(!ecoinvent_id){console.warn("no ecoinvent id for '"+key_replaced+"' in 'water_emissions' (untreated_as_emissions)");}
          }
        });
      })();

  //JSON sent to the python scripts that generate the ecospold files
  var data_set = {
    //inputs
    inputs:{
      activity_name,
      geography,
      untreated_fraction,
      tool_use_type,
      PV,
      CSO_particulate,
      CSO_soluble,
      fraction_C_fossil,
      COD_TOC_ratio,
      url:(new URL(window.location)).href,
      technologies_averaged,
      WW_properties,
    },
    //outputs
    outputs:{
      chemicals,
      electricity,
      CSO_amounts,
      WWTP_influent_properties,
      WWTP_emissions_water,
      WWTP_emissions_air,
      WWTP_emissions_sludge,
      sludge_properties,
      untreated_as_emissions,
    },
  };

  //return
  //console.log(data_set); //debugging
  return data_set;
}

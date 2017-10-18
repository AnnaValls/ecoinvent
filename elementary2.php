<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Elementary Flows 2</title>
	<!--backend function-->
	<script>
		var tech_BOD_default = true;
		function compute_elementary_flows(){
			//technology booleans
			var is_Pri_active = getInput("Pri",true).value; //tech
			var is_BOD_active = getInput("BOD",true).value; //tech
			var is_Nit_active = getInput("Nit",true).value; //tech
			var is_SST_active = getInput("SST",true).value; //tech
			var is_Des_active = getInput("Des",true).value; //tech
			var is_BiP_active = getInput("BiP",true).value; //tech
			var is_ChP_active = getInput("ChP",true).value; //tech

			//add result to Variables after a technology resolves
			function showResults(tech,result){
				//tech: string, result: object
				for(var res in result){
					var value=result[res].value;
					var unit =result[res].unit;
					var descr = result[res].descr;
					//if a variable with same id, unit and value already exists don't add it
					if(
						Variables.filter(v=>{return (v.id==res && v.unit==unit && format(v.value)==format(value))}).length>0
					){continue}
					//add to variables
					Variables.push({id:res,value,unit,descr,tech});
				}
			}

			/* TECHNOLOGY COMPOSITION CALLING */
			//here results for each technology resolved are stored
			var Result = { BOD:{}, Nit:{}, SST:{}, Des:{}, BiP:{}, ChP:{} }; 

			//bod removal
			if(is_BOD_active){
				var BOD            = getInput('BOD').value; //140;
				var sBOD           = getInput('sBOD').value; //70;
				var COD            = getInput('COD').value; //300;
				var sCOD           = getInput('sCOD').value; //132;
				var TSS            = getInput('TSS').value; //70;
				var VSS            = getInput('VSS').value; //60;
				var bCOD_BOD_ratio = getInput('bCOD_BOD_ratio').value; //1.6;
				var Q              = getInput('Q').value; //22700;
				var T              = getInput('T').value; //12;
				var SRT            = getInput('SRT').value; //5;
				var MLSS_X_TSS     = getInput('MLSS_X_TSS').value; //3000;
				var zb             = getInput('zb').value; //500;
				var Pressure       = getInput('Pressure').value; //95600;
				var Df             = getInput('Df').value; //4.4;
				var C_L            = getInput('C_L').value; //2.0
				var NOx            = 0;
				Result.BOD=bod_removal_only(BOD,sBOD,COD,sCOD,TSS,VSS,bCOD_BOD_ratio,Q,T,SRT,MLSS_X_TSS,zb,Pressure,Df,C_L);
				showResults('BOD',Result.BOD);

				//Nit --- bod + nitrification
				if(is_Nit_active){
					var TKN        = getInput('TKN').value; //35
					var SF         = getInput('SF').value; //1.5;
					var Ne         = getInput('Ne').value; //0.50;
					var sBODe      = getInput('sBODe').value; //3;
					var TSSe       = getInput('TSSe').value; //10;
					var Alkalinity = getInput('Alkalinity').value; //140;
					Result.Nit=nitrification(BOD,bCOD_BOD_ratio,sBOD,COD,sCOD,TSS,VSS,Q,T,TKN,SF,zb,Pressure,Df,MLSS_X_TSS,Ne,sBODe,TSSe,Alkalinity,C_L);
					showResults('Nit',Result.Nit);
				}

				//SST --- bod + (nitrification) + sst
				if(is_SST_active){
					var SOR        = getInput('SOR').value;
					var X_R        = getInput('X_R').value;
					var clarifiers = getInput('clarifiers').value;
					Result.SST=sst_sizing(Q,SOR,X_R,clarifiers,MLSS_X_TSS);
					showResults('SST',Result.SST);
				}

				//Des --- bod + nitrification + sst + denitrification
				if(is_Nit_active && is_SST_active && is_Des_active){
					var bCOD                  = Result.BOD.bCOD.value; //224
					var rbCOD                 = getInput('rbCOD').value; //80
					var NOx                   = Result.Nit.NOx.value; //28.9
					var Alkalinity            = getInput('Alkalinity').value; //140;
					var MLVSS                 = Result.Nit.MLVSS.value;//2370
					var Aerobic_SRT           = Result.Nit.SRT_design.value; //21
					var Aeration_basin_volume = Result.Nit.V.value; //13410
					var Aerobic_T             = Result.Nit.tau.value; //14.2
					var Anoxic_mixing_energy  = getInput('Anoxic_mixing_energy').value; //5
					var RAS                   = Result.SST.RAS.value; //0.6
					var R0                    = Result.Nit.OTRf.value; //275.9;
					var NO3_eff               = getInput('NO3_eff').value; //6
					Result.Des=N_removal(Q,T,BOD,bCOD,rbCOD,NOx,Alkalinity,MLVSS,Aerobic_SRT,Aeration_basin_volume,Aerobic_T,Anoxic_mixing_energy,RAS,R0,NO3_eff);
					showResults('Des',Result.Des);
				}

				//BiP --- bod + (nitrification) + sst + (denitrification) + bioP
				if(is_BiP_active){
					var bCOD            = Result.BOD.bCOD.value;             //250
					var rbCOD           = getInput('rbCOD').value;           //80
					var VFA             = getInput('VFA').value;             //15
					var nbVSS           = Result.BOD.nbVSS.value;            //20
					var iTSS            = Result.BOD.iTSS.value;             //10
					var TP              = getInput('TP').value;              //6
					var rbCOD_NO3_ratio = getInput('rbCOD_NO3_ratio').value; //5.2
					var NOx             = is_Nit_active ? Result.Nit.NOx.value : 0; //28.9
					var NO3_eff         = getInput('NO3_eff').value; //6
					Result.BiP=bio_P_removal(Q,bCOD,rbCOD,VFA,nbVSS,iTSS,TP,T,SRT,rbCOD_NO3_ratio,NOx,NO3_eff);
					showResults('BiP',Result.BiP);
				}

				//ChP --- bod + (nitrification) + sst + (denitrification) + (bioP) + chemP
				if(is_ChP_active){
					var TSS_removal_wo_Fe = getInput('TSS_removal_wo_Fe').value; //60  
					var TSS_removal_w_Fe  = getInput('TSS_removal_w_Fe').value; //75  
					var TP                = getInput('TP').value; //6
					var C_PO4_inf         = getInput('C_PO4_inf').value; //5   
					var C_PO4_eff         = getInput('C_PO4_eff').value; //0.1 
					var FeCl3_solution    = getInput('FeCl3_solution').value; //37  
					var FeCl3_unit_weight = getInput('FeCl3_unit_weight').value; //1.35
					var days              = getInput('days').value; //15  
					Result.ChP=chem_P_removal(Q,TSS,TSS_removal_wo_Fe,TSS_removal_w_Fe,TP,C_PO4_inf,C_PO4_eff,FeCl3_solution,FeCl3_unit_weight,days);
					showResults('ChP',Result.ChP);
				}
			}else if(is_BOD_active==false){
				console.log('WARNING: BOD removal is not active');
			}

			/*
				OUTPUTS by phase (water, air, sludge)
				---IMPORTANT---: all Outputs should be in g/d,
				because frontend functions will turn them to kg/d
			*/

			/*
				Technology         | In/active     | Results object
				-------------------+---------------+---------------
				primary treatment  | is_Pri_active | (no results)
				bod removal        | is_BOD_active | Result.BOD
				nitrification      | is_Nit_active | Result.Nit
				sst sizing         | is_SST_active | Result.SST
				denitrification    | is_Des_active | Result.Des
				bio P removal      | is_BiP_active | Result.BiP
				chemical P removal | is_ChP_active | Result.ChP
			*/

			//at least bod removal should be active before next part
			if(is_BOD_active==false){return}

			//RESULTS USED FOR OUTPUTS TABLE

			//equations NOT FROM METCALF
			var nbsCODe      = Result.BOD.nbsCODe.value; //g/m3
			var nbpCOD       = Result.BOD.nbpCOD.value;  //g/m3
			var S0           = Result.BOD.bCOD.value;    //g/m3
			var bHT          = Result.BOD.bHT.value;     //1/d
			var nbVSS        = Result.BOD.nbVSS.value;   //g/m3

			var S            = is_Nit_active ? Result.Nit.S.value           : Result.BOD.S.value; //g/m3
			var P_X_bio      = is_Nit_active ? Result.Nit.P_X_bio_VSS.value : Result.BOD.P_X_bio.value; //kg/d
			var V            = is_Nit_active ? Result.Nit.V.value           : Result.BOD.V.value; //m3
			var NOx          = is_Nit_active ? Result.Nit.NOx.value         : 0;                  //g/m3

			//if not defined, take default value
			var TSSe         = is_Nit_active ? TSSe    : getInputById('TSSe').value;    //g/m3
			var Ne           = is_Nit_active ? Ne      : getInputById('Ne').value;      //g/m3
			var TKN          = is_Nit_active ? TKN     : getInputById('TKN').value;     //g/m3
			var NO3_eff      = is_Des_active ? NO3_eff : getInputById('NO3_eff').value; //g/m3
			var TP = (is_BiP_active || is_ChP_active) ? TP : getInputById('TP').value;  //g/m3

			var C_PO4_eff = (function(){
				return 0.1; 
				//TODO ask what happens if both techs are simulataneous, because this happens:
				//in chem P this is C_PO4_eff             (input)
				//in bio  P this is Result.BiP.Effluent_P (output)
			})();

			//lcorominas pdf starts here
			var TSS_was      = X_R;                                          //g/m3
			var VSSe         = TSSe*0.85;                                    //g/m3
			var Qwas         = (V*MLSS_X_TSS/SRT - Q*TSSe)/(TSS_was - TSSe); //m3
			var sCODe        = Q*(nbsCODe + S);                              //g/d
			var biomass_CODe = 1.42*Q*VSSe;                                  //g/d
			var nbpON        = 0.064*nbVSS;                                  //g/m3
			var nbsON        = 0.3;                                          //g/m3
			var TKN_N2O      = 0.001*TKN;                                    //g/m3
			var bTKN         = TKN - nbpON - nbsON - TKN_N2O;                //g/m3
			var sTKNe        = Q*(Ne + nbsON);                               //g/d

			//Outputs.COD
			Outputs.COD.influent = Q*COD;
			Outputs.COD.effluent.water  = (function(){return sCODe + biomass_CODe})();
			Outputs.COD.effluent.air    = (function(){return 0})();
			Outputs.COD.effluent.sludge = (function(){
				var A = P_X_bio*1000;
				var B = Qwas*sCODe/Q;
				var C = Q*nbpCOD;
				return A+B+C;
			})();

			//Outputs.CO2
			Outputs.CO2.influent       = (function(){return 0})();
			Outputs.CO2.effluent.water = (function(){return 0})();
			Outputs.CO2.effluent.air   = (function(){
				var k_CO2_COD = 0.99;
				var k_CO2_bio = 1.03;
				var air = k_CO2_COD*Q*(1-YH)*(S0-S) + k_CO2_bio*Q*YH*(S0-S)*bHT*SRT/(1+bHT*SRT)*(1-fd) - 4.49*NOx;
				return air;
			})();
			Outputs.CO2.effluent.sludge = (function(){return 0})();

			//Outputs.CH4 TODO
			Outputs.CH4.influent        = (function(){return 0})();
			Outputs.CH4.effluent.water  = (function(){return 0})();
			Outputs.CH4.effluent.air    = (function(){return 0})();
			Outputs.CH4.effluent.sludge = (function(){return 0})();

			//Outputs.TKN
			Outputs.TKN.influent = Q*TKN;
			Outputs.TKN.effluent.water = (function(){
				if(is_Nit_active){
					return sTKNe + Q*VSSe*0.12;
				}else{
					//corrected 2017-10-13
					return Q*(TKN - nbpON - TKN_N2O + 0.12*VSSe) - 0.12*P_X_bio*1000;
				}
			})();
			Outputs.TKN.effluent.air = (function(){return 0})();
			Outputs.TKN.effluent.sludge = (function(){
				var A = 0.12*P_X_bio*1000;
				var B = Qwas*sTKNe/Q;
				var C = Q*nbpON;
				return A+B+C;
			})();

			//Outputs.NOx
			Outputs.NOx.influent = Q*NOx;
			Outputs.NOx.effluent.water  = (function(){
				if(is_Nit_active==false){
					return 0;
				}else if(is_Des_active){
					return Q*NO3_eff;
				}else if(is_Des_active==false){ 
					return Q*(bTKN - Ne) - 0.12*P_X_bio*1000;
				}
			})();
			Outputs.NOx.effluent.air = (function(){return 0})();
			Outputs.NOx.effluent.sludge = (function(){
				if(is_Nit_active==false) {
					return 0;
				}else if(is_Des_active){
					return Qwas*NO3_eff;
				}else if(is_Des_active==false){
					return Qwas*NOx;
				}
			})();

			//Outputs.N2
			Outputs.N2.influent        = (function(){return 0})();
			Outputs.N2.effluent.water  = (function(){return 0})();
			Outputs.N2.effluent.air    = (function(){
				if(is_Des_active) {
					return Q*(NOx - NO3_eff);
				}else{
					return 0;
				}
			})();
			Outputs.N2.effluent.sludge = (function(){return 0})();

			//Outputs.N2O
			Outputs.N2O.influent        = (function(){return 0})();
			Outputs.N2O.effluent.water  = (function(){return 0})();
			Outputs.N2O.effluent.air    = (function(){
				return Q*TKN_N2O;
			})();
			Outputs.N2O.effluent.sludge = (function(){return 0})();

			//Outputs.TP continue here TODO
			Outputs.TP.influent        = Q*TP;
			Outputs.TP.effluent.water  = (function(){
				if(is_BiP_active==false && is_ChP_active==false){
					return Q*TP;
				}else{
					return Q*C_PO4_eff;
				}
			})();
			Outputs.TP.effluent.air = (function(){return 0})();
			Outputs.TP.effluent.sludge = (function(){
				if(is_BiP_active==false && is_ChP_active==false){
					return 0;
				}
				var A=0.015*P_X_bio*1000;
				var B=Qwas*C_PO4_eff;
				if(is_BiP_active && is_ChP_active==false){
					var C = 0 //continue here
				}

			})();

			//Outputs.TS
			if(typeof(TS)=="undefined"){var TS=0;}
			Outputs.TS.influent        = Q*TS;
			Outputs.TS.effluent.water  = (function(){
				return 0; //TODO
			})();
			Outputs.TS.effluent.air    = (function(){
				return 0; //TODO
			})();
			Outputs.TS.effluent.sludge = (function(){
				return 0; //TODO
			})();
		}
	</script>

	<!--data structures-->
	<script>
		/*
		 * Structure: Technologies used (first inputs)
		 * Structure: Inputs for wastewater observed (they are generated)
		 * Structure: Design Inputs for design choices
		 * Structure: Variables (intermediate calculations)
		 */
		var Technologies_selected=[
			{id:"Pri", value:false, descr:"Primary treatment"    }, //not a real technology, just modifies [rbCOD = Pri ? 0.32*bCOD : 0.32*bCOD]
			{id:"BOD", value:tech_BOD_default, descr:"BOD removal"          },
			{id:"Nit", value:false, descr:"Nitrification"        },
			{id:"SST", value:false, descr:"SST sizing"           }, //not a "real" technology, should be always true
			{id:"Des", value:false, descr:"Denitrification"      },
			{id:"BiP", value:false, descr:"Biological P removal" },
			{id:"ChP", value:false, descr:"Chemical P removal"   },
		];
		var Inputs_current_combination=[ ]; //filled in frontend
		var Design=[ ];                     //filled in frontend

		/* Get an input or technology by id */
		function getInput(id,isTechnology){
			isTechnology=isTechnology||false;
			var ret;
			if(isTechnology){
				ret=Technologies_selected.filter(el=>{return id==el.id});
			}else{
				ret=Inputs_current_combination.concat(Design).filter(el=>{return id==el.id});
			}
			if(ret.length==0){ 
				console.error('Input id "'+id+'" not found'); 
				return false;
			}
			else if(ret.length>1){ 
				console.error('Input id is not unique');
				return false;
			}
			return ret[0];
		}

		/* Set an input or technology by id */
		function setInput(id,newValue,isTechnology){
			isTechnology=isTechnology||false;
			if(isTechnology) getInput(id,isTechnology).value=newValue;
			else             getInput(id,isTechnology).value=parseFloat(newValue);
			init();

			//focus again after init()
			setTimeout(function(){
				if(!isTechnology){document.getElementById(id).select()}
			},10);
		}

		/* Toggle technology active/inactive by id */
		function toggleTech(id){
			var currValue=getInput(id,true).value;
			setInput(id,!currValue,true);
			console.log(id+" "+(!currValue).toString());
		}

		/*
		 * Structure 3: Intermediate variables calculations
		 */
		var Variables=[];

		/* Get a variable by id */
		function getVariable(id){
			var ret;
			ret=Variables.filter(el=>{return id==el.id});
			if(ret.length==0){ 
				console.error('Variable id not found'); 
				return false;
			}
			else if(ret.length>1){ 
				console.error('Variable id is not unique');
				return false;
			}
			return ret[0];
		}

		/* Set a variable by id */
		function setVariable(id,newValue){
			getVariable(id).value=newValue;
		}
	</script>

	<!--init & frontend-->
	<script>
		function init(){
			/*
			 * call backend functions
			 */
			(function reset_all_outputs(){
				for(var out in Outputs){
					Outputs[out].influent=0;
					Outputs[out].effluent.water=0;
					Outputs[out].effluent.air=0;
					Outputs[out].effluent.sludge=0;
				}
			})();

			(function disable_impossible_options(){
				//if bod removal is false
				// disable nitrification 
				// disable sst sizing
				// disable denitri
				// disable bioP
				// disable chemP
				if(getInput('BOD',true).value==false){
					getInput('SST',true).value=false;
					getInput('Nit',true).value=false;
					getInput('Des',true).value=false;
					getInput('BiP',true).value=false;
					getInput('ChP',true).value=false;
				}
				else{
					getInput('SST',true).value=true;
				}

				//denitri only if nitri
				if(getInput('Nit',true).value==false){
					getInput('Des',true).value=false;
				}
			})();

			(function set_current_inputs(){
				//find current inputs from the technology combination
				var current_combination=['Pri','BOD','SST','Nit','Des','BiP','ChP'].filter(tec=>{return getInput(tec,true).value});
				var input_codes=[];
				current_combination.forEach(tec=> {
					if(!Technologies[tec]) return;
					input_codes=input_codes.concat(Technologies[tec].Inputs)
				});

				input_codes=uniq(input_codes);

				//reset current inputs
				Inputs_current_combination = [ ];
				input_codes.filter(code=>{return !getInputById(code).isParameter}).forEach(code=>{
					Inputs_current_combination.push(getInputById(code));
				});

				//reset design inputs
				Design = [ ];
				input_codes.filter(code=>{return getInputById(code).isParameter}).forEach(code=>{
					Design.push(getInputById(code));
				});
			})();

			Variables = [ ];
			compute_elementary_flows();

			/*
			 * frontend functions
			 */
			document.querySelector('#input_amount').innerHTML=Inputs_current_combination.concat(Design).length;
			document.querySelector('#variable_amount').innerHTML=Variables.length;

			(function updateViews(){
				//update technologies table
				(function(){
					var table=document.querySelector('table#inputs_tech');
					while(table.rows.length>0){table.deleteRow(-1);}
					Technologies_selected.forEach(tec=> {
						if(tec.id=="SST") return; //SST always on
						var newRow=table.insertRow(-1);
						//tec name
						newRow.insertCell(-1).innerHTML="<small>"+tec.descr;
						//checkbox
						var checked = getInput(tec.id,true).value ? "checked" : "";
						newRow.insertCell(-1).innerHTML="<input type=checkbox "+checked+" onchange=\"toggleTech('"+tec.id+"')\" tech='"+tec.id+"'>";
						//implementation link
						if(Technologies[tec.id]){
							newRow.insertCell(-1).innerHTML="<small><a href='techs/"+Technologies[tec.id].File+"' target=_blank>see equations</a>";
						}
					});
				})();

				//update inputs table
				(function(){
					var table=document.querySelector('table#inputs');
					while(table.rows.length>1){table.deleteRow(-1)}
					if(Inputs_current_combination.length==0){
						table.insertRow(-1).insertCell(-1).outerHTML="<td colspan=3><i><small>~Activate technologies first";
					}
					Inputs_current_combination.forEach(i=>{
						var newRow=table.insertRow(-1);
						newRow.title=i.descr;
						newRow.insertCell(-1).outerHTML="<td class=help><small>"+i.id;
						newRow.insertCell(-1).innerHTML="<input id='"+i.id+"' value='"+i.value+"' type=number step=any onchange=setInput('"+i.id+"',this.value) min=0>"
						newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
					});
				})();

				//update design parameters table
				(function(){
					var table=document.querySelector('table#design');
					while(table.rows.length>1){table.deleteRow(-1)}
					if(Design.length==0){
						table.insertRow(-1).insertCell(-1).outerHTML="<td colspan=3><i><small>~Activate technologies first";
					}
					Design.forEach(i=>{
						var newRow=table.insertRow(-1);
						newRow.title=i.descr;
						newRow.insertCell(-1).outerHTML="<td class=help><small>"+i.id;
						newRow.insertCell(-1).innerHTML="<input id='"+i.id+"' value='"+i.value+"' type=number step=any onchange=setInput('"+i.id+"',this.value) min=0>"
						newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
					});
				})();

				//update variables table
				(function(){
					var table=document.querySelector('table#variables');
					while(table.rows.length>1){table.deleteRow(-1)}
					if(Variables.length==0){
						table.insertRow(-1).insertCell(-1).outerHTML="<td colspan=4><i><small>~Activate technologies first";
					}
					Variables.forEach(i=>{
						var newRow=table.insertRow(-1);
						newRow.setAttribute('tech',i.tech);
						newRow.insertCell(-1).outerHTML="<td title='"+Technologies[i.tech].Name+"'><small>"+i.tech+"</small>";
						newRow.insertCell(-1).outerHTML="<td class=help title='"+i.descr.replace(/_/g,' ')+"'><small>"+i.id;
						newRow.insertCell(-1).outerHTML="<td class=number>"+format(i.value);
						newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
					});
				})();

				//update outputs
				(function(){
					var table=document.querySelector('table#outputs');
					while(table.rows.length>2){table.deleteRow(-1)}
					for(var output in Outputs) {
						var newRow=table.insertRow(-1);
						newRow.insertCell(-1).innerHTML=output.prettifyUnit();
						newRow.insertCell(-1).outerHTML="<td class=number>"+format(Outputs[output].effluent.water/1000);
						newRow.insertCell(-1).outerHTML="<td class=number>"+format(Outputs[output].effluent.air/1000);
						newRow.insertCell(-1).outerHTML="<td class=number>"+format(Outputs[output].effluent.sludge/1000);
					}
				})();
			})();

			//disable checkboxes for impossible technology combinations
			(function(){
				function disable_checkbox(tech){
					var el=document.querySelector('#inputs_tech input[tech='+tech+']')
					el.disabled=true;
					el.parentNode.parentNode.style.color='#ccc';
					
				}
				if(getInput('BOD',true).value==false) {
					disable_checkbox('Nit');
					disable_checkbox('Des');
					disable_checkbox('BiP');
					disable_checkbox('ChP');
				}
				if(getInput('Nit',true).value==false) {
					disable_checkbox('Des');
				}
			})();

			//set scroll link visibility for each tech
			(function(){
				function set_scroll_link_visibility(tec){
					var el=document.querySelector('#variable_scrolling a[tech='+tec+']')
					if(el){
						el.style.display=getInput(tec,true).value ? "":"none";
					}
				}
				Technologies_selected.forEach(t=>{
					set_scroll_link_visibility(t.id)
				});
			})();

			//MASS BALANCES (end part)
			(function do_mass_balances(){
				function setBalance(element,influent,water,air,sludge){
					document.querySelector('#mass_balances #'+element+' td[phase=influent]').innerHTML=format(influent/1000);
					document.querySelector('#mass_balances #'+element+' td[phase=water]').innerHTML=format(water/1000);
					document.querySelector('#mass_balances #'+element+' td[phase=air]').innerHTML=format(air/1000);
					document.querySelector('#mass_balances #'+element+' td[phase=sludge]').innerHTML=format(sludge/1000);

					//actual balance: output/input should be aprox 1
					var el=document.querySelector('#mass_balances #'+element+' td[phase=balance]')
					var percent = influent==0 ? 0 : Math.abs(100*(1-(water+air+sludge)/influent));
					el.innerHTML = format(percent,2)+" %";

					//red warning if percent is greater than 5%
					if(percent>3){el.style.color='red'}else{el.style.color='green'}
				}

				var table=document.querySelector('table#mass_balances');
				//C
					var influent = Outputs.COD.influent;
					var water    = Outputs.COD.effluent.water;
					var air      = Outputs.CO2.effluent.air;
					var sludge   = Outputs.COD.effluent.sludge;
					setBalance('C',influent,water,air,sludge);
				//N
					var influent = Outputs.TKN.influent;
					var water    = Outputs.TKN.effluent.water  + Outputs.NOx.effluent.water;
					var air      = Outputs.N2.effluent.air     + Outputs.N2O.effluent.air;
					var sludge   = Outputs.TKN.effluent.sludge + Outputs.NOx.effluent.sludge;
					setBalance('N',influent,water,air,sludge);
				//P
					var influent = Outputs.TP.influent;
					var water    = Outputs.TP.effluent.water;
					var air      = Outputs.TP.effluent.air;
					var sludge   = Outputs.TP.effluent.sludge;
					setBalance('P',influent,water,air,sludge);
				//S
					var influent = Outputs.TS.influent;
					var water    = Outputs.TS.effluent.water;
					var air      = Outputs.TS.effluent.air;
					var sludge   = Outputs.TS.effluent.sludge;
					setBalance('S',influent,water,air,sludge);
				//end
			})();
		}
	</script>
</head><body onload="init()">
<?php include'navbar.php'?>
<div id=root>
<h1>Elementary Flows</h1>
<p>Under development:</p>
	<ul>
		<li>outputs for P removal
		<li>outputs for Sulfur
	</ul>
<hr>

<!--inputs and outputs scaffold-->
<div style="display:flex;flex-wrap:wrap">
	<!--inputs-->
	<div>
		<p><b>1. User Inputs</b></p>
		<!--enter technologies-->
		<div>
			<p>1.1. Activate technologies of your plant</p>
			<table id=inputs_tech border=1></table>
		</div>
		<!--input amount-->
		<p> Inputs required: <span id=input_amount>0</span> </p>
		<!--enter ww characteristics-->
		<div>
			<p>1.2. Enter wastewater characteristics</p>
			<table id=inputs border=1>
				<tr><th>Input<th>Value<th>Unit
			</table>
			<p>1.3. Adjust design parameters</p>
			<table id=design border=1>
				<tr><th>Input<th>Value<th>Unit
			</table>
		</div>
	</div><hr>

	<!--intermediate variables-->
	<div>
		<p><b>2. Variables (grouped by technology)</b></p>
		<p>Variables calculated: <span id=variable_amount>0</span></p>
		<div id=variable_scrolling>
			<small>
				<script>
					//frontend function
					function scroll2tec(a){
						var tec=a.getAttribute('tech');
						var els=document.querySelectorAll('#variables tr[tech='+tec+']');
						//els[0].scrollIntoView({behavior:'smooth'});
						els[0].scrollIntoView();
						//mini animation
						for(var i=0;i<els.length;i++) {
							els[i].style.transition='background 0.4s';
							els[i].style.background='lightblue';
						}
						setTimeout(function(){
							for(var i=0;i<els.length;i++) {
								els[i].style.background='white';
							}
						},800);
					}
				</script>
				Scroll to &rarr;
				<a tech=BOD href=# onclick="scroll2tec(this);return false">BOD</a>
				<a tech=Nit href=# onclick="scroll2tec(this);return false">Nit</a>
				<a tech=SST href=# onclick="scroll2tec(this);return false">SST</a>
				<a tech=Des href=# onclick="scroll2tec(this);return false">Des</a>
				<a tech=BiP href=# onclick="scroll2tec(this);return false">BiP</a>
				<a tech=ChP href=# onclick="scroll2tec(this);return false">ChP</a>
			</small>
		</div>
		<table id=variables border=1><tr>
			<th>Tech
			<th>Variable
			<th>Result
			<th>Unit
		</table>
	</div><hr>

	<!--outputs-->
	<div>
		<p><b>3. Outputs</b> (not finished)</p>
		<!--effluent phases-->
		<div>
			<p>3.1. Effluent</p>
			<table id=outputs border=1 cellpadding=2>
				<tr>
					<th rowspan=2>Compound
					<th colspan=3>Effluent <small>(kg/d)</small>
				<tr> <th>Water<th>Air<th>Sludge
			</table>
		</div>

		<!--mass balances-->
		<div>
			<p>3.2. Mass balances</p>
			<table id=mass_balances border=1>
				<tr>
					<th rowspan=2>Element<th rowspan=2>Influent<br><small>(kg/d)</small><th colspan=3>Effluent <small>(kg/d)</small>
					<th rowspan=2>|Error| <small>(%)</small>
				<tr>
					<th>Water<th>Air<th>Sludge  
				<tr id=C><th>C <td phase=influent>Q·COD <td phase=water>1:1     <td phase=air>2:2     <td phase=sludge>1:3     <td phase=balance>A-B-C-D
				<tr id=N><th>N <td phase=influent>Q·TKN <td phase=water>4:1+5:1 <td phase=air>6:2+7:2 <td phase=sludge>4:3+5:3 <td phase=balance>A-B-C-D
				<tr id=P><th>P <td phase=influent>Q·TP  <td phase=water>8:1     <td phase=air>-       <td phase=sludge>8:3     <td phase=balance>A-B-C-D
				<tr id=S><th>S <td phase=influent>Q·TS  <td phase=water>9:1     <td phase=air>-       <td phase=sludge>9:3     <td phase=balance>A-B-C-D
			</table>
		</div>

		<!--pending tables-->
		<div>
			<p>3.3. Design summary
				<ul>
					<li>Reactor volume
					<li>Settler volume
					<li>Purge flow (Qw)
					<li>SRT
					<li>Recirculation flow
					<li>kg concrete
				</ul>
			<p>3.4. Technosphere
				<ul>
					<li>chemicals consumed from chem P
				</ul>
			<p>3.5. Aeration &amp; energy consumed</p>
		</div>

		<!--generate ecospold file-->
		<div style=margin-top:10px>
			<a href=ecospold.php> Save results as ecoSpold file </a>
		</div>
	</div>
</div>

<style>
	#root th{
		background:#eee;
	}
	#root input[type=number]{
		text-align:right;
	}
	#root #mass_balances [phase]{
		text-align:right;
	}
	.help:hover{
		text-decoration:underline;
	}
</style>

<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Elementary Flows 2</title>
	<!--backend function-->
	<script>
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
				var NOx            = 0;
				Result.BOD=bod_removal_only(BOD,sBOD,COD,sCOD,TSS,VSS,bCOD_BOD_ratio,Q,T,SRT,MLSS_X_TSS,zb,Pressure,Df);
				showResults('BOD',Result.BOD);

				//Nit --- bod + nitrification
				if(is_Nit_active){
					var TKN        = getInput('TKN').value; //35
					var SF         = getInput('SF').value; //1.5;
					var Ne         = getInput('Ne').value; //0.50;
					var sBODe      = getInput('sBODe').value; //3;
					var TSSe       = getInput('TSSe').value; //10;
					var Alkalinity = getInput('Alkalinity').value; //140;
					Result.Nit=nitrification(BOD,bCOD_BOD_ratio,sBOD,COD,sCOD,TSS,VSS,Q,T,TKN,SF,zb,Pressure,Df,MLSS_X_TSS,Ne,sBODe,TSSe,Alkalinity);
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
				important: all Outputs should be in g/d (frontend functions turn them to kg/d)
			*/
			if(typeof(Q)=='undefined'){var Q=0}

			//Outputs.COD
			if(typeof(COD)=="undefined"){var COD=0;}
			Outputs.COD.influent        = Q*COD;
			Outputs.COD.effluent.water  = 0;
			Outputs.COD.effluent.air    = 0;
			Outputs.COD.effluent.sludge = 0;

			//Outputs.CO2
			Outputs.CO2.influent        = 0;
			Outputs.CO2.effluent.water  = 0;
			Outputs.CO2.effluent.air    = 0;
			Outputs.CO2.effluent.sludge = 0;

			//Outputs.CH4
			Outputs.CH4.influent        = 0;
			Outputs.CH4.effluent.water  = 0;
			Outputs.CH4.effluent.air    = 0;
			Outputs.CH4.effluent.sludge = 0;

			//Outputs.TKN
			if(typeof(TKN)=="undefined"){var TKN=0;}
			Outputs.TKN.influent        = Q*TKN;
			Outputs.TKN.effluent.water  = 0;
			Outputs.TKN.effluent.air    = 0;
			Outputs.TKN.effluent.sludge = 0;

			//Outputs.NOx
			Outputs.NOx.influent        = 0;
			Outputs.NOx.effluent.water  = 0;
			Outputs.NOx.effluent.air    = 0;
			Outputs.NOx.effluent.sludge = 0;

			//Outputs.N2
			Outputs.N2.influent        = 0;
			Outputs.N2.effluent.water  = 0;
			Outputs.N2.effluent.air    = 0;
			Outputs.N2.effluent.sludge = 0;

			//Outputs.N2O
			Outputs.N2O.influent        = 0;
			Outputs.N2O.effluent.water  = 0;
			Outputs.N2O.effluent.air    = 0;
			Outputs.N2O.effluent.sludge = 0;

			//Outputs.TP
			if(typeof(TP)=="undefined"){var TP=0;}
			Outputs.TP.influent        = Q*TP;
			Outputs.TP.effluent.water  = 0;
			Outputs.TP.effluent.air    = 0;
			Outputs.TP.effluent.sludge = 0;

			//Outputs.TS
			if(typeof(TS)=="undefined"){var TS=0;}
			Outputs.TS.influent        = Q*TS;
			Outputs.TS.effluent.water  = 0;
			Outputs.TS.effluent.air    = 0;
			Outputs.TS.effluent.sludge = 0;
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
			{id:"BOD", value:false, descr:"BOD removal"          },
			{id:"Nit", value:false, descr:"Nitrification"        },
			{id:"SST", value:false, descr:"SST sizing"           }, //not a "real" technology, should be always true
			{id:"Des", value:false, descr:"Denitrification"      },
			{id:"BiP", value:false, descr:"Biological P removal" },
			{id:"ChP", value:false, descr:"Chemical P removal"   },
		];
		var Inputs_current_combination=[ ]; //filled in frontend
		var Design=[ ];                     //TODO filled in frontend

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
			if(isTechnology==false){document.getElementById(id).select()}
		}

		/* Toggle technology active/inactive by id */
		function toggleTech(id) {
			var currValue=getInput(id,true).value;
			setInput(id,!currValue,true);
			console.log(id+" "+(!currValue).toString());
		}

		/*
		 * Structure 3: Intermediate variables calculations
		 */
		var Variables=[ ];

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
			 * backend functions
			 */
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
				//update technologies
				(function(){
					var table=document.querySelector('table#inputs_tech');
					while(table.rows.length>0){table.deleteRow(-1);}
					Technologies_selected.forEach(tec=> {
						if(tec.id=="SST") return; //SST always on
						var newRow=table.insertRow(-1);
						newRow.title=tec.id;
						newRow.insertCell(-1).innerHTML=tec.descr;
						var checked = getInput(tec.id,true).value ? "checked" : "";
						newRow.insertCell(-1).innerHTML="<input type=checkbox "+checked+" onchange=\"toggleTech('"+tec.id+"')\" tech='"+tec.id+"'>";
					});
				})();

				//update inputs table
				(function(){
					var table=document.querySelector('table#inputs');
					while(table.rows.length>1){table.deleteRow(-1)}
					if(Inputs_current_combination.length==0){
						table.insertRow(-1).insertCell(-1).outerHTML="<td colspan=3><i><small>~Activate some technologies first";
					}
					Inputs_current_combination.forEach(i=>{
						var newRow=table.insertRow(-1);
						newRow.title=i.descr;
						if(i.descr=="") newRow.classList.add('no_description');
						else            newRow.classList.add('help');
						newRow.insertCell(-1).innerHTML="<small>"+i.id;
						newRow.insertCell(-1).innerHTML="<input id='"+i.id+"' value='"+i.value+"' type=number onchange=setInput('"+i.id+"',this.value) min=0>"
						newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
					});
				})();

				//update design parameters table
				(function(){
					var table=document.querySelector('table#design');
					while(table.rows.length>1){table.deleteRow(-1)}
					if(Design.length==0){
						table.insertRow(-1).insertCell(-1).outerHTML="<td colspan=3><i><small>~Activate some technologies first";
					}
					Design.forEach(i=>{
						var newRow=table.insertRow(-1);
						newRow.title=i.descr;
						if(i.descr=="") newRow.classList.add('no_description');
						else            newRow.classList.add('help');
						newRow.insertCell(-1).innerHTML="<small>"+i.id;
						newRow.insertCell(-1).innerHTML="<input id='"+i.id+"' value='"+i.value+"' type=number onchange=setInput('"+i.id+"',this.value) min=0>"
						newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
					});
				})();

				//update variables
				(function(){
					var table=document.querySelector('table#variables');
					while(table.rows.length>1){table.deleteRow(-1)}
					if(Variables.length==0){
						table.insertRow(-1).insertCell(-1).outerHTML="<td colspan=4><i><small>~Activate some technologies first";
					}
					Variables.forEach(i=>{
						var newRow=table.insertRow(-1);
						if(i.descr=="") newRow.classList.add('no_description');
						else            newRow.classList.add('help');
						newRow.style.background=str2color(i.tech+i.tech);
						newRow.insertCell(-1).outerHTML="<td title='"+Technologies[i.tech].Name+"'><small>"+i.tech+"</small>";
						newRow.insertCell(-1).outerHTML="<td class=help title='"+i.descr+"'><small>"+i.id;
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
					if(percent>5){el.style.color='red'}else{el.style.color='green'}
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

<!--TASKS-->
<div id=tasks><hr> 
	<p>
		<b>Tasks and questions</b>
		<button onclick="document.querySelector('#tasks').style.display='none';">hide tasks and questions</button>
	</p>

	<p><b>This page</b></p>
	<ul>
		<li>[TO DO] Calculate outputs
		<li>[TO DO] Implement primary treatment
	</ul>

	<p><b>Questions for experts</b></p>
	<ul>
		<li>Regarding these equations not from Metcalf (still not implemented): reference required (book, pages)
			<ul>
				<li>rbCOD   = 0.32*bCOD (if primary effluent)
				<li>rbCOD   = 0.2*bCOD  (if not primary effluent)
				<li>VFA     = 0.15*rbCOD
				<li>problem : in metcalf Bio P removal a parameter VFA/rbCOD is calculated, is not a constant
			</ul>
		</li>
	</ul>
</div><hr> 

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
			<p>1.3. Enter design parameters [TO DO]</p>
			<table id=design border=1>
				<tr><th>Input<th>Value<th>Unit
			</table>
		</div>
	</div><hr>

	<!--intermediate variables-->
	<div>
		<p><b>2. Variables (grouped by technology)</b></p>
		<p>Number of variables: <span id=variable_amount>0</span></p>
		<table id=variables border=1><tr>
			<th>Tech
			<th>Variable
			<th>Value
			<th>Unit
		</table>
	</div><hr>

	<!--outputs-->
	<div>
		<p><b>3. Outputs</b></p>
		<!--effluent phases-->
		<div>
			<p>3.1. Effluent [TO DO]</p>
			<table id=outputs border=1 cellpadding=2>
				<tr>
					<th rowspan=2>Compound
					<th colspan=3>Effluent phase (kg/d)
				<tr> <th>Water<th>Air<th>Sludge
			</table>
		</div>

		<!--mass balances-->
		<div>
			<p>3.2. Mass balances [TO DO]</p>
			<table id=mass_balances border=1>
				<tr><th rowspan=2>Element<th rowspan=2>Influent (kg/d)<th colspan=3>Effluent (kg/d)
					<th rowspan=2>
						|Difference| <br>mass balance (%) <br>
						<small> 1-[water+air+sludge]/Influent </small>
					</th>
				<tr><th>Water<th>Air<th>Sludge  
				<tr id=C><td align=center>C <td phase=influent>Q·COD <td phase=water>1:1     <td phase=air>2:2     <td phase=sludge>1:3     <td phase=balance>A-B-C-D
				<tr id=N><td align=center>N <td phase=influent>Q·TKN <td phase=water>4:1+5:1 <td phase=air>6:2+7:2 <td phase=sludge>4:3+5:3 <td phase=balance>A-B-C-D
				<tr id=P><td align=center>P <td phase=influent>Q·TP  <td phase=water>8:1     <td phase=air>-       <td phase=sludge>8:3     <td phase=balance>A-B-C-D
				<tr id=S><td align=center>S <td phase=influent>Q·TS  <td phase=water>9:1     <td phase=air>-       <td phase=sludge>9:3     <td phase=balance>A-B-C-D
			</table>
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
	.no_description:after {
		content:"(no description, please provide)";
		font-size:11px;
		color:red;
	}
	#root #mass_balances [phase]{
		text-align:right;
	}
</style>

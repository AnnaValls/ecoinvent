<!doctype html><html><head>
<!-- vim * shortcuts: 
backend_implementation_of_"docs/Elementaryflows_20170927evening.pdf"]
-->
	<?php include'imports.php'?>
	<title>Elementary Flows</title>

	<!--data structures-->
	<script>
		/*
		 * Structure: Technologies used (first inputs)
		 * Structure: Inputs for wastewater observed (they are generated)
		 * Structure: Design Inputs for design choices
		 * Structure: Variables (intermediate calculations)
		 */
		var Technologies_selected=[
			{id:"Pri", value:false, descr:"Primary treatment" },
			{id:"BOD", value:true , descr:"BOD removal" },
			{id:"SST", value:true , descr:"SST sizing" },
			{id:"Nit", value:false, descr:"Nitrification" },
			{id:"Des", value:false, descr:"Denitrification" },
			{id:"BiP", value:false, descr:"Biological P removal" },
			{id:"ChP", value:false, descr:"Chemical P removal" },
		];
		var Inputs_current_combination = [ ]; //filled in frontend
		var Design = [ ];                     //filled in frontend

		/* Get an input or technology by id */
		function getInput(id,isTechnology)
		{
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
		function setInput(id,newValue,isTechnology)
		{
			isTechnology=isTechnology||false;

			if(isTechnology)
				getInput(id,isTechnology).value=newValue;
			else
				getInput(id,isTechnology).value=parseFloat(newValue);

			init();
			//focus again after modification
			if(isTechnology==false){
				document.getElementById(id).select();
			}
		}

		/* Toggle technology active/inactive by id */
		function toggleTech(id)
		{
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

	<!--backend (equations)-->
	<script>
		function set_current_inputs(){
			//find current inputs from the technology combination
			var current_combination = ['Pri','BOD','SST','Nit','Des','BiP','ChP'].filter(tec=>{return getInput(tec,true).value});
			var input_codes = [];
			current_combination.forEach(tec=>
			{
				if(!Technologies[tec]) return;
				input_codes = input_codes.concat(Technologies[tec].Inputs)
			});
			input_codes=uniq(input_codes);

			//reset current inputs
			Inputs_current_combination = [ ];
			//add found inputs 
			input_codes.forEach(code=>{
				Inputs_current_combination.push(getInputById(code));
			});
		}

		//[backend_implementation_of_"docs/Elementaryflows_20170927evening.pdf"]
		function compute_elementary_flows(){
			//technology booleans
				var is_Pri_active = getInput("Pri",true).value; //tech
				var is_BOD_active = getInput("BOD",true).value; //tech
				var is_SST_active = getInput("SST",true).value; //tech
				var is_Nit_active = getInput("Nit",true).value; //tech
				var is_Des_active = getInput("Des",true).value; //tech
				var is_BiP_active = getInput("BiP",true).value; //tech
				var is_ChP_active = getInput("ChP",true).value; //tech
			//end

			//show results after a technology resolves
			function showResults(result){
				//variable{id:"bCOD", value:0, unit:"g/m3", descr:"Biodegradable COD"},
				for(var res in result){
					Variables.push({id:res, value:result[res], unit:"TODO", descr:"TODO"})
				}
			}

			//CALL TECHNOLOGIES HERE 
				if(is_BOD_active) {
					var BOD            = 140;
					var sBOD           = 70;
					var COD            = 300;
					var sCOD           = 132;
					var TSS            = 70;
					var VSS            = 60;
					var bCOD_BOD_ratio = 1.6;
					var Q              = 22700;
					var T              = 12;
					var SRT            = 5;
					var MLSS_X_TSS     = 3000;
					var zb             = 500;
					var Pressure       = 95600;
					var Df             = 4.4;
					var result = bod_removal_only(BOD,sBOD,COD,sCOD,TSS,VSS,bCOD_BOD_ratio,Q,T,SRT,MLSS_X_TSS,zb,Pressure,Df);
					console.log(result);
					showResults(result)
				}


			//end

			/*
				OUTPUTS
				IMPORTANT: all Outputs should be in g/d
			*/

			//send all variables to view
			(function(){
			})();

			//Outputs.COD
			Outputs.COD.water  = 0;
			Outputs.COD.air    = 0;
			Outputs.COD.sludge = 0;

			//Outputs.CO2
			Outputs.CO2.water  = 0;
			Outputs.CO2.air    = 0;
			Outputs.CO2.sludge = 0;

			//Outputs.CH4
			Outputs.CH4.water  = 0;
			Outputs.CH4.air    = 0;
			Outputs.CH4.sludge = 0;

			//Outputs.TKN
			Outputs.TKN.water  = 0;
			Outputs.TKN.air    = 0;
			Outputs.TKN.sludge = 0;

			//Outputs.NOx
			Outputs.NOx.water  = 0;
			Outputs.NOx.air    = 0;
			Outputs.NOx.sludge = 0;

			//Outputs.N2
			Outputs.N2.water  = 0;
			Outputs.N2.air    = 0;
			Outputs.N2.sludge = 0;

			//Outputs.N2O
			Outputs.N2O.water  = 0;
			Outputs.N2O.air    = 0;
			Outputs.N2O.sludge = 0;

			//Outputs.TP
			Outputs.TP.water  = 0;
			Outputs.TP.air    = 0;
			Outputs.TP.sludge = 0;

			//TS
			Outputs.TS.water  = 0;
			Outputs.TS.air    = 0;
			Outputs.TS.sludge = 0;
		}
	</script>

	<!--init/frontend-->
	<script>
		function init(){
			set_current_inputs();
			document.querySelector('#input_amount').innerHTML=Inputs_current_combination.length;
			compute_elementary_flows();
			updateViews();
			do_mass_balances();
		}

		/*
		 * frontend update views
		 */
		function updateViews(){
			//update inputs table
			(function(){
				var table=document.querySelector('table#inputs');
				while(table.rows.length>1){table.deleteRow(-1)}

				Inputs_current_combination.forEach(i=>{
					var newRow=table.insertRow(-1);
					newRow.title=i.descr;
					if(i.descr=="") newRow.classList.add('no_description');
					else            newRow.classList.add('help');
					newRow.insertCell(-1).innerHTML=i.id;
					newRow.insertCell(-1).innerHTML="<input id='"+i.id+"' value='"+i.value+"' type=number onchange=setInput('"+i.id+"',this.value) min=0>"
					newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.replace('m3','m<sup>3</sup>');
				});
			})();

			//update design parameters table
			(function(){
				var table=document.querySelector('table#design');
				while(table.rows.length>1){table.deleteRow(-1)}

				Design.forEach(i=>{
					var newRow=table.insertRow(-1);
					newRow.title=i.descr;
					if(i.descr=="") newRow.classList.add('no_description');
					else            newRow.classList.add('help');
					newRow.insertCell(-1).innerHTML=i.id;
					newRow.insertCell(-1).innerHTML="<input id='"+i.id+"' value='"+i.value+"' type=number onchange=setInput('"+i.id+"',this.value) min=0>"
					newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.replace('m3','m<sup>3</sup>');
				});
			})();

			//update technologies
			(function() {
				var table=document.querySelector('table#inputs_tech');
				while(table.rows.length>0){table.deleteRow(-1);}
				Technologies_selected.forEach(tec=>
				{
					var newRow=table.insertRow(-1);
					newRow.insertCell(-1).innerHTML=tec.descr
					var checked = getInput(tec.id,true).value ? "checked" : "";
					newRow.insertCell(-1).innerHTML="<input type=checkbox "+checked+" onchange=\"toggleTech('"+tec.id+"')\">";
				});
			})();

			//update variables
			(function(){
				var table=document.querySelector('table#variables');
				while(table.rows.length>1){table.deleteRow(-1)}

				Variables.forEach(i=>{
					var newRow=table.insertRow(-1);
					newRow.title=i.descr;
					if(i.descr=="") newRow.classList.add('no_description');
					else            newRow.classList.add('help');
					newRow.insertCell(-1).innerHTML=i.id;
					newRow.insertCell(-1).outerHTML="<td class=number>"+format(i.value);
					newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.replace('m3','m<sup>3</sup>');
				});
			})();

			//update outputs
			(function(){
				var table=document.querySelector('table#outputs');
				while(table.rows.length>2){table.deleteRow(-1)}
				for(var output in Outputs) {
					var newRow=table.insertRow(-1);
					newRow.insertCell(-1).innerHTML=output
						.replace('O2','O<sub>2</sub>')
						.replace('N2','N<sub>2</sub>')
						.replace('CH4','CH<sub>4</sub>');

					newRow.insertCell(-1).outerHTML="<td class=number>"+format(Outputs[output].water/1000);
					newRow.insertCell(-1).outerHTML="<td class=number>"+format(Outputs[output].air/1000);
					newRow.insertCell(-1).outerHTML="<td class=number>"+format(Outputs[output].sludge/1000);
				}
			})();
		}
	</script>

	<!--mass balances backend+frontend-->
	<script>
		function do_mass_balances()
		{
			function setBalance(element,influent,water,air,sludge)
			{
				document.querySelector('#mass_balances #'+element+' td[phase=influent]').innerHTML=format(influent/1000);
				document.querySelector('#mass_balances #'+element+' td[phase=water]').innerHTML=format(water/1000);
				document.querySelector('#mass_balances #'+element+' td[phase=air]').innerHTML=format(air/1000);
				document.querySelector('#mass_balances #'+element+' td[phase=sludge]').innerHTML=format(sludge/1000);

				//mass balance: output/input should be aprox 1
				var el= document.querySelector('#mass_balances #'+element+' td[phase=balance]')
				var percent = influent==0 ? 0 : Math.abs(100*(1-(water+air+sludge)/influent));
				el.innerHTML=format(percent,2)+" %";

				//warning
				if(percent>5){
					el.style.color='red';
				}else{
					el.style.color='green';
				}
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
		}
	</script>
</head><body onload="init()">
<?php include'navbar.php'?>
<div id=root>
<h1>Elementary Flows</h1>

<!--temporal note-->
<div>
	<span style=color:red>Implementation in progress as <?php echo date("M-d-Y") ?></span> 
</div><hr> 

<div>
	<!-- button toggle sorting 
	<button onclick=toggleSorting()>Sort A-Z</button>
	-->
</div>

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
		<p>
			Inputs with current combination: <span id=input_amount>0</span>
		</p>
		<!--enter ww characteristics-->
		<div>
			<p>1.2. Enter wastewater characteristics</p>
			<table id=inputs border=1>
				<tr><th>Input<th>Value<th>Unit
			</table>
			<p>1.3. Enter design parameters</p>
			<table id=design border=1>
				<tr><th>Input<th>Value<th>Unit
			</table>
			<script>
			</script>
		</div>
	</div><hr>

	<!--intermediate variables-->
	<div>
		<p><b>2. Variables (calculated from inputs)</b></p>
		<table id=variables border=1>
			<tr><th>Variable<th>Value<th>Unit
		</table>
	</div><hr>

	<!--outputs-->
	<div>
		<p><b>3. Outputs</b></p>
		<!--effluent phases-->
		<div>
			<p>3.1. Effluent</p>
			<table id=outputs border=1 cellpadding=2>
				<tr>
					<th rowspan=2>Compound
					<th colspan=3>Effluent phase (kg/d)
				<tr>
					<th>Water<th>Air<th>Sludge
				</tr>
			</table>
		</div>

		<!--mass balances-->
		<div>
			<p>3.2. Mass balances</p>
			<table id=mass_balances border=1>
				<tr><th rowspan=2>Element<th rowspan=2>Influent (kg/d)<th colspan=3>Effluent (kg/d)
					<th rowspan=2>
						|Difference| <br>mass balance (%)
						<br>
						<small>
							1-[water+air+sludge]/Influent
						</small>
				<tr><th>Water<th>Air<th>Sludge  
				<tr id=C><td align=center>C <td phase=influent>Q·COD <td phase=water>1:1     <td phase=air>2:2     <td phase=sludge>1:3     <td phase=balance>A-B-C-D
				<tr id=N><td align=center>N <td phase=influent>Q·TKN <td phase=water>4:1+5:1 <td phase=air>6:2+7:2 <td phase=sludge>4:3+5:3 <td phase=balance>A-B-C-D
				<tr id=P><td align=center>P <td phase=influent>Q·TP  <td phase=water>8:1     <td phase=air>-       <td phase=sludge>8:3     <td phase=balance>A-B-C-D
				<tr id=S><td align=center>S <td phase=influent>Q·TS  <td phase=water>9:1     <td phase=air>-       <td phase=sludge>9:3     <td phase=balance>A-B-C-D
			</table>
		</div>

		<!--generate ecospold file-->
		<div style=margin-top:10px>
			<a href=ecospold.php>
				Save results as ecoSpold file
			</a>
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

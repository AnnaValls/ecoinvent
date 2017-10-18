<!doctype html><html><head>
<!-- vim * shortcuts: 
backend_implementation_of_"docs/Elementaryflows_20170927evening.pdf"]
-->
	<?php include'imports.php'?>
	<title>Elementary Flows</title>

	<!--data structures-->
	<script>
		/*
		 * Structure 1: Inputs for wastewater observed
		 * Structure 2: Inputs for design choices
		 * Structure 3: Variables (intermediate calculations)
		 * Structure 4: Technologies used (also inputs)
		 */
		var Inputs=[
			{id:"Q",              value:22700, unit:"m3/d", descr:"Flowrate"},
			{id:"T",              value:12,    unit:"ºC",   descr:"Temperature"},
			{id:"COD",            value:300,   unit:"g/m3", descr:"Total chemical oxygen demand"},
			{id:"sCOD",           value:132,   unit:"g/m3", descr:"Soluble COD"},
			{id:"BOD",            value:140,   unit:"g/m3", descr:"Total 5d biochemical oxygen demand"},
			{id:"sBOD",           value:70,    unit:"g/m3", descr:"Soluble BOD"},
			{id:"VSS",            value:60,    unit:"g/m3", descr:"Volatile suspended solids"},
			{id:"TSS",            value:70,    unit:"g/m3", descr:"Total suspended solids"},
			{id:"TKN",            value:35,    unit:"g_N/m3", descr:"Total Kjedahl nitrogen"},
			{id:"TP",             value:6,     unit:"g_P/m3", descr:"Total phosphorus"},
			{id:"TS",             value:10,    unit:"g_S/m3", descr:"Total sulfur"},
			{id:"bCOD_BOD_ratio", value:1.6,   unit:"g/g",  descr:"bCOD/BOD ratio"},
		];
		var Design=[
			{id:"SRT",        value:5,    unit:"d",    descr:"Solids Retention Time"},
			{id:"MLSS_X_TSS", value:3000, unit:"g/m3", descr:"Mixed liquor suspended solids"},
			{id:"TSS_was",    value:8000, unit:"g/m3", descr:"MLSS at the bottom of the settler"},
			{id:"TSSe",       value:1,    unit:"g/m3", descr:"Effluent design Total suspended solids"},
			{id:"Ne",         value:0.50, unit:"g_N/m3", descr:"Effluent design NH4"},
			{id:"NOx_e",      value:4,    unit:"g_N/m3", descr:"Effluent design NOx"},
			{id:"PO4_e",      value:2,    unit:"g/m3", descr:"Effluent design PO4"},
		];
		var Technologies=[
			{id:"Pri", value:false, descr:"Primary treatment" },
			{id:"BOD", value:true , descr:"BOD removal" },
			{id:"Nit", value:false, descr:"Nitrification" },
			{id:"Des", value:false, descr:"Denitrification" },
			{id:"BiP", value:false, descr:"Biological P removal" },
			{id:"ChP", value:false, descr:"Chemical P removal" },
		];

		/* Get an input or technology by id */
		function getInput(id,isTechnology){
			isTechnology=isTechnology||false;
			var ret;
			if(isTechnology){
				ret=Technologies.filter(el=>{return id==el.id});
			}else{
				ret=Inputs.concat(Design).filter(el=>{return id==el.id});
			}
			if(ret.length==0){ 
				console.error('Input id not found'); 
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
			getInput(id,isTechnology).value=newValue;
			init();
			//focus again after modification
			if(isTechnology==false){
				document.getElementById(id).select();
			}
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
		var Variables=[
			//table 1 and 2:
			{id:"bCOD",       value:0,  unit:"g/m3",  descr:"Biodegradable COD"},
			{id:"nbCOD",      value:0,  unit:"g/m3",  descr:"Nonbiodegradable COD"},
			{id:"nbsCODe",    value:0,  unit:"g/m3",  descr:"Nonbiodegradable soluble COD"},
			{id:"nbpCOD",     value:0,  unit:"g/m3",  descr:"Nonbiodegradable particulate COD"},
			{id:"VSS_COD",    value:0,  unit:"g/m3",  descr:"VSS/COD ratio"},
			{id:"nbVSS",      value:0,  unit:"g/m3",  descr:"Nonbiodegradable volatile suspended solids"},
			{id:"rbCOD",      value:0,  unit:"g/m3",  descr:"Readily biodegradable COD"},
			{id:"VFA",        value:0,  unit:"g/m3",  descr:"Volatile Fatty Acids"},
			{id:"iTSS",       value:0,  unit:"g/m3",  descr:"Inert TSS"},
			{id:"mu_mT",      value:0,  unit:"1/d",   descr:"µ max corrected by Temperature"},
			{id:"bHT",        value:0,  unit:"1/d",   descr:"b max corrected by Temperature"},
			{id:"S",          value:0,  unit:"g/m3",  descr:"[S]"},
			{id:"P_X_bio",    value:0,  unit:"kg/d",  descr:"Biomass production"},
			{id:"P_X_VSS",    value:0,  unit:"kg/d",  descr:"Sludge production in VSS units"},
			{id:"P_X_TSS",    value:0,  unit:"kg/d",  descr:"Sludge production in TSS units"},
			{id:"X_VSS_V",    value:0,  unit:"kg",    descr:"Mass of VSS"},
			{id:"X_TSS_V",    value:0,  unit:"kg",    descr:"Mass of TSS"},
			{id:"V_reactor",  value:0,  unit:"m3",    descr:"Aeration tank volume"},
			{id:"tau",        value:0,  unit:"h",     descr:"Aeration tank detention time"},
			{id:"MLVSS",      value:0,  unit:"g/m3",  descr:"Mixed Liquor VSS"},
			{id:"VSSe",       value:0,  unit:"g/m3",  descr:"Effluent VSS"},
			{id:"Qwas",       value:0,  unit:"m3/d",  descr:"Wastage flow rate"},
			//table 3:
			{id:"nbpON",      value:0,  unit:"g/m3",  descr:"Nonbiodegradable particulate ON"},
			{id:"nbsON",      value:0,  unit:"g/m3",  descr:"Nonbiodegradable soluble ON"},
			{id:"TKN_N2O",    value:0,  unit:"g/m3",  descr:"N2O / TKN ratio"},
			{id:"bTKN",       value:0,  unit:"g/m3",  descr:"Biodegradable TKN"},
			{id:"NOx",        value:0,  unit:"g/m3",  descr:"Nitrogen oxidized to nitrate"},
			//table 4:
			{id:"nbpP",       value:0,  unit:"g/m3",  descr:"Nonbiodegradable particulate P"},
			{id:"nbsP",       value:0,  unit:"g/m3",  descr:"Nonbiodegradable soluble P"},
			{id:"aP",         value:0,  unit:"g/m3",  descr:"Available P to be accumulated in organisms"},
			{id:"aPchem",     value:0,  unit:"g/m3",  descr:"Available P for chemical removal"},
			//outputs part
			{id:"sCODe",        value:0,  unit:"g/d",  descr:"Effluent Soluble COD"},
			{id:"biomass_CODe", value:0,  unit:"g/d",  descr:"Effluent COD of suspended solids"},
			{id:"sTKNe",        value:0,  unit:"g/d",  descr:"Effluent Soluble TKN"},
		];

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

		/*
		 * Structure 4: Outputs, elementary flows for water, air and sludge (g/d)
		 */
		var Outputs={
			"COD":{water:0, air:0, sludge:0},
			"CO2":{water:0, air:0, sludge:0},
			"CH4":{water:0, air:0, sludge:0},
			"TKN":{water:0, air:0, sludge:0},
			"NOx":{water:0, air:0, sludge:0},
			"N2" :{water:0, air:0, sludge:0},
			"N2O":{water:0, air:0, sludge:0},
			"TP" :{water:0, air:0, sludge:0},
			"TS" :{water:0, air:0, sludge:0},
		};
	</script>

	<!--backend (equations)-->
	<script>
		//[backend_implementation_of_"docs/Elementaryflows_20170927evening.pdf"]
		function compute_elementary_flows(){
			/*get input values and technologies booleans*/
				var Q              = getInput('Q').value;
				var T              = getInput('T').value;
				var SRT            = getInput('SRT').value;
				var COD            = getInput('COD').value;
				var sCOD           = getInput('sCOD').value;
				var BOD            = getInput('BOD').value;
				var sBOD           = getInput('sBOD').value;
				var MLSS_X_TSS     = getInput('MLSS_X_TSS').value;
				var VSS            = getInput('VSS').value;
				var TSS            = getInput('TSS').value;
				var TSSe           = getInput('TSSe').value;
				var TSS_was        = getInput('TSS_was').value;
				var bCOD_BOD_ratio = getInput('bCOD_BOD_ratio').value;
				//technologies booleans
				var Pri = getInput("Pri",true).value; //tech
				var Nit = getInput("Nit",true).value; //tech
				var Des = getInput("Des",true).value; //tech
				var BiP = getInput("BiP",true).value; //tech
				var ChP = getInput("ChP",true).value; //tech
				var primary_effluent_wastewater = Pri;
				var raw_wastewater              = !Pri;
				var nitrification               = Nit;
				var denitrification             = Des;
			//end

			/*equations start*/
			var bCOD = bCOD_BOD_ratio*BOD; 
			var nbCOD = COD - bCOD;        
			var nbsCODe = sCOD - bCOD_BOD_ratio*sBOD;
			var nbpCOD = COD - bCOD - nbsCODe;
			var VSS_COD = (COD-sCOD)/VSS;
			var nbVSS = nbpCOD/VSS_COD;
			if(raw_wastewater){
				var rbCOD = 0.2*bCOD;
			}else if(primary_effluent_wastewater){
				var rbCOD = 0.32*bCOD;
			}
			var VFA = 0.15*rbCOD;
			var iTSS = TSS - VSS;
			var S0 = bCOD;
			var mu_mT = mu_m * Math.pow(1.07, T - 20); //µ
			var bHT   = bH   * Math.pow(1.04, T - 20); 
			var S = Ks*(1+bHT*SRT)/(SRT*(mu_mT-bHT)-1);
			var P_X_bio = (Q*YH*(S0 - S)/(1 + bHT*SRT) + (fd*bHT*Q*YH*(S0 - S)*SRT)/(1 + bHT*SRT))/1000;
			var P_X_VSS = P_X_bio + Q*nbVSS/1000;
			var P_X_TSS = P_X_bio/0.85 + Q*nbVSS/1000 + Q*(TSS-VSS)/1000;
			var X_VSS_V = P_X_VSS*SRT;
			var X_TSS_V = P_X_TSS*SRT;
			var V_reactor = X_TSS_V*1000/MLSS_X_TSS;
			var tau = V_reactor*24/Q;
			var MLVSS = X_VSS_V/X_TSS_V*MLSS_X_TSS;
			var VSSe = TSSe*0.85
			var Qwas = (V_reactor*MLSS_X_TSS/SRT - Q*TSSe)/(TSS_was - TSSe);

			var Qe = Q - Qwas; //TODO use in equations (waiting lcorominas)

			//TABLE 3
			//inputs
			var TKN   = getInput('TKN').value;   //35
			var Ne    = getInput('Ne').value;    //0.50
			var NOx_e = getInput('NOx_e').value; //4

			//equations
			var nbpON = 0.064*nbVSS;
			var nbsON = 0.3;
			var TKN_N2O = 0.001*TKN;
			var bTKN = TKN - nbpON - nbsON - TKN_N2O;

			var NOx = 0;
			if(nitrification==false){
				NOx = 0;
			}else{
				NOx = bTKN - Ne - 0.12*P_X_bio*1000/Q; //g/m3
			}

			//TABLE 4
			var TP    = getInput('TP').value; //6
			var PO4_e = getInput('PO4_e').value; //6

			//equations
			var nbpP = 0.025*nbVSS;
			var nbsP = 0;
			var aP = TP - nbpP - nbsP;
			var aPchem = aP - 0.015*P_X_bio*1000/Q;

			//OUTPUTS table 5 elementary flows-->
			/*
				IMPORTANT: all Outputs should be in g/d
			*/

			//Outputs.COD
			var sCODe = Q*(nbsCODe + S);
			var biomass_CODe = Q*VSSe*1.42;
			Outputs.COD.water = (function(){
				return sCODe + biomass_CODe;
			})(); 
			Outputs.COD.air = 0;
			Outputs.COD.sludge = (function(){
				var A = Q*YH*(S0 - S)/(1 + bHT*SRT) + (fd*bHT*Q*YH*(S0 - S)*SRT)/(1 + bHT*SRT) + 0;
				var B = Qwas*sCODe/Q;
				var C = Q*nbpCOD;
				return A+B+C;
			})();

			//Outputs.CO2
			Outputs.CO2.water=0;
			Outputs.CO2.air=(function(){
				var k_CO2_COD = 0.99;
				var k_CO2_bio = 1.03;
				var air = k_CO2_COD*Q*(1-YH)*(S0-S) + k_CO2_bio*Q*YH*(S0-S)*bHT*SRT/(1+bHT*SRT)*(1-fd) - 4.49*NOx;
				return air;
			})();
			Outputs.CO2.sludge=0;

			//Outputs.CH4
			Outputs.CH4.water  = 0;
			Outputs.CH4.air    = 0; //(bCOD*Q*0.95); //TBD (only in anaerobic treatment)
			Outputs.CH4.sludge = 0;

			//Outputs.TKN
				var sTKNe = Q*(Ne + nbsON); //g/d
				Outputs.TKN.water = (function(){
					if(nitrification){
						return sTKNe + Q*VSSe*0.12;
					}else{
						//corrected 2017-10-13
						return Q*TKN - 0.12*P_X_bio*1000 - Q*nbpON - Q*TKN_N2O + 0.12*Q*VSSe;
					}
				})();
				Outputs.TKN.air=0;
				Outputs.TKN.sludge = (function(){
					var A = 0.12*P_X_bio*1000 
					var B = Qwas*sTKNe/Q;
					var C = Q*nbpON;
					return A+B+C;
				})();

			//Outputs.NOx
			Outputs.NOx.water=(function(){
				if(nitrification==false){
					return 0;
				}else if(denitrification){
					return Q*NOx_e;
				}else if(denitrification==false){ 
					return Q*(bTKN - Ne) - 0.12*P_X_bio*1000;
				}
			})();
			Outputs.NOx.air=0;
			Outputs.NOx.sludge=(function(){
				if(nitrification==false) {
					return 0;
				} else if(denitrification){
					return Qwas*NOx_e;
				}else if(denitrification==false){
					return Qwas*NOx;
				}
			})();

			//Outputs.N2
			Outputs.N2.water=0;
			Outputs.N2.air = (function(){
				if(denitrification) {
					return Q*(NOx - NOx_e);
				}else{
					return 0;
				}
			})();
			Outputs.N2.sludge=0;

			//Outputs.N2O
			Outputs.N2O.water=0;
			Outputs.N2O.air=Q*TKN_N2O;
			Outputs.N2O.sludge=0;

			//Outputs.TP
			Outputs.TP.water=(function(){
				if(BiP==false && ChP==false){
					return Q*TP;
				}else{
					return Q*PO4_e;
				}
			})();
			Outputs.TP.air=0;
			Outputs.TP.sludge=(function(){
				if(BiP==false && ChP==false){
					return 0;
				}else{
					return Q*(TP-PO4_e); //hauria de donar això
				}
				/*
					var P_EBPR = 0;
					var A;
					if     (ChP) A=0.015*P_X_bio*1000 + Q*(aPchem-PO4_e);
					else if(BiP) A=0.015*P_X_bio*1000;
					else         A=0.015*P_X_bio*1000 + P_EBPR;
					var B=Qwas*PO4_e;
					return A+B;
				*/
			})();

			//TS
			Outputs.TS.water=0;
			Outputs.TS.air=0;
			Outputs.TS.sludge=0;

			//set all variables
			(function setAllVariables(){
				setVariable('bCOD',bCOD);
				setVariable('nbCOD',nbCOD);
				setVariable('nbsCODe',nbsCODe);
				setVariable('nbpCOD',nbpCOD);
				setVariable('VSS_COD',VSS_COD);
				setVariable('nbVSS',nbVSS);
				setVariable('rbCOD',rbCOD);
				setVariable('VFA',VFA);
				setVariable('iTSS',iTSS);
				setVariable('mu_mT',mu_mT);
				setVariable('bHT',bHT);
				setVariable('S',S);
				setVariable('P_X_bio',P_X_bio);
				setVariable('P_X_VSS',P_X_VSS);
				setVariable('P_X_TSS',P_X_TSS);
				setVariable('X_VSS_V',X_VSS_V);
				setVariable('X_TSS_V',X_TSS_V);
				setVariable('V_reactor',V_reactor);
				setVariable('tau',tau);
				setVariable('MLVSS',MLVSS);
				setVariable('VSSe',VSSe);
				setVariable('Qwas',Qwas);
				setVariable('nbpON',nbpON);
				setVariable('nbsON',nbsON);
				setVariable('TKN_N2O',TKN_N2O);
				setVariable('bTKN',bTKN);
				setVariable('NOx',NOx);
				setVariable('nbpP',nbpP);
				setVariable('nbsP',nbsP);
				setVariable('aP',aP);
				setVariable('aPchem',aPchem);
				setVariable('sCODe',sCODe);
				setVariable('biomass_CODe',biomass_CODe);
				setVariable('sTKNe',sTKNe);
			})();
		}
	</script>

	<!--init/frontend-->
	<script>
		var sortAZ=false;

		function toggleSorting(){
			sortAZ=!sortAZ;
			init();
		}

		function init(){
			compute_elementary_flows();
			updateViews(sortAZ);
			do_mass_balances();
		}

		/*
		 * frontend update views
		 */
		function updateViews(sortAZ){
			sortAZ=sortAZ||false;

			//update technologies
			(function() {
				var table=document.querySelector('table#inputs_tech');
				while(table.rows.length>0){table.deleteRow(-1);}
				Technologies.forEach(tec=>
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

				//sort by id (A-Z)
				var Sorted = sortAZ ? Variables.sort((a,z)=>{return a.id.localeCompare(z.id)}) : Variables; 

				Sorted.forEach(i=>{
					var newRow=table.insertRow(-1);
					newRow.title=i.descr;
					if(i.descr=="") newRow.classList.add('no_description');
					else            newRow.classList.add('help');
					newRow.insertCell(-1).innerHTML=i.id;
					newRow.insertCell(-1).outerHTML="<td class=number>"+format(i.value);
					newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
				});
			})();

			//update outputs
			(function(){
				var table=document.querySelector('table#outputs');
				while(table.rows.length>2){table.deleteRow(-1)}
				for(var output in Outputs){
					var newRow=table.insertRow(-1);
					newRow.insertCell(-1).innerHTML=output.prettifyUnit();
					newRow.insertCell(-1).outerHTML="<td class=number>"+format(Outputs[output].water/1000);  //g to kg
					newRow.insertCell(-1).outerHTML="<td class=number>"+format(Outputs[output].air/1000);    //g to kg 
					newRow.insertCell(-1).outerHTML="<td class=number>"+format(Outputs[output].sludge/1000); //g to kg 
				}
			})();
		}
	</script>
</head><body onload="init()">
<?php include'navbar.php'?>
<div id=root>
<h1>Elementary Flows</h1>

<!--temporal note-->
<div>
	<span style=color:red>Implementation in progress as <?php echo date("M-d-Y") ?></span> 
	<a target=_blank href="docs/Elementaryflows_20170927evening.pdf">(document here)</a>
	<p>status: Lluís Corominas &amp; Lluís Bosch are verifying mass balance equations</p>
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
		<!--enter ww characteristics-->
		<div>
			<p>1.2. Enter wastewater characteristics</p>
			<table id=inputs border=1>
				<tr><th>Input<th>Value<th>Unit
			</table>
			<script>
				//create inputs table
				(function(){
					var table=document.querySelector('table#inputs');
					while(table.rows.length>1){table.deleteRow(-1)}

					Inputs.forEach(i=>{
						var newRow=table.insertRow(-1);
						newRow.title=i.descr;
						if(i.descr=="") newRow.classList.add('no_description');
						else            newRow.classList.add('help');
						newRow.insertCell(-1).innerHTML=i.id;
						newRow.insertCell(-1).innerHTML="<input id='"+i.id+"' value='"+i.value+"' type=number onchange=setInput('"+i.id+"',this.value) min=0>"
						newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
					});
				})();
			</script>
			<p>1.3. Enter design parameters</p>
			<table id=design border=1>
				<tr><th>Input<th>Value<th>Unit
			</table>
			<script>
				//create inputs table
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
						newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
					});
				})();
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
						|Error|<br>in mass balance (%)
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
						var percent = Math.abs(100*(1-(water+air+sludge)/influent));
						el.innerHTML=format(percent,2)+" %";

						//warning
						if(percent>1){el.style.color='red'}else{el.style.color='green'}
					}

					var table=document.querySelector('table#mass_balances');
					var Q = getInput('Q').value;
					//C
						var COD = getInput('COD').value;
						var influent = Q*COD;
						var water    = Outputs.COD.water;
						var air      = Outputs.CO2.air;
						var sludge   = Outputs.COD.sludge;
						setBalance('C',influent,water,air,sludge);
					//N
						var TKN = getInput('TKN').value;
						var influent = Q*TKN;
						var water    = Outputs.TKN.water  + Outputs.NOx.water;
						var air      = Outputs.N2.air     + Outputs.N2O.air;
						var sludge   = Outputs.TKN.sludge + Outputs.NOx.sludge;
						setBalance('N',influent,water,air,sludge);
					//P
						var TP = getInput('TP').value;
						var influent = Q*TP;
						var water    = Outputs.TP.water;
						var air      = Outputs.TP.air;
						var sludge   = Outputs.TP.sludge;
						setBalance('P',influent,water,air,sludge);
					//S
						var TS = getInput('TS').value;
						var influent = Q*TS;
						var water    = Outputs.TS.water;
						var air      = Outputs.TS.air;
						var sludge   = Outputs.TS.sludge;
						setBalance('S',influent,water,air,sludge);
					//end
				}
			</script>
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

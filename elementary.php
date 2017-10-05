<!doctype html><html><head><?php include'imports.php'?><title>Elementary Flows</title>
	<!--
		vim * shortcuts: 
			[backend_implementation_of_"docs/Elementaryflows_20170927evening.pdf"]
	-->

	<!--data structures-->
	<script>
		/*
		 * Structure 1: Inputs with default values
		 * Structure 2: Technologies used (also inputs)
		 */
		var Inputs = [
			//influent
			{id:"Q",         value:22700, unit:"m3/d", descr:"Flowrate"},
			{id:"T",         value:12,    unit:"ºC",   descr:"Temperature"},
			{id:"SRT",       value:5,     unit:"d",    descr:"Solids Retention Time"},
			{id:"COD",       value:300,   unit:"g/m3", descr:"Total chemical oxygen demand"},
			{id:"sCOD",      value:132,   unit:"g/m3", descr:"Soluble COD"},
			{id:"BOD",       value:140,   unit:"g/m3", descr:"Total 5d biochemical oxygen demand"},
			{id:"sBOD",      value:70,    unit:"g/m3", descr:"Soluble BOD"},
			{id:"MLSS_X_TSS",value:3000,  unit:"g/m3", descr:"Mixed liquor suspended solids"},
			{id:"VSS",       value:60,    unit:"g/m3", descr:"Volatile suspended solids"},
			{id:"TSS",       value:70,    unit:"g/m3", descr:"Total suspended solids"},
			{id:"TSS_was",   value:1,     unit:"g/m3", descr:"Total suspended solids (wastage)"},
			{id:"TKN",       value:35,    unit:"g/m3", descr:"Total Kjedahl nitrogen"},
			{id:"TP",        value:6,     unit:"g/m3", descr:"Total phosphorus"},
			//effluent
			{id:"TSSe",      value:1,     unit:"g/m3", descr:"Effluent design Total suspended solids"},
			{id:"Ne",        value:0.50,  unit:"g/m3", descr:"Effluent design NH4"},
			{id:"NOx_e",     value:1,     unit:"g/m3", descr:"Effluent design NOx"},
			{id:"PO4_e",     value:1,     unit:"g/m3", descr:"Effluent design PO4"},
		];
		var Technologies = [
			{id:"Pri", value:false, descr:"Primary treatment", },
			{id:"BOD", value:true , descr:"BOD removal", },
			{id:"Nit", value:false, descr:"Nitrification", },
			{id:"Des", value:false, descr:"Denitrification or N removal", },
			{id:"BiP", value:false, descr:"Biological P removal", },
			{id:"ChP", value:false, descr:"Chemical P removal", },
		];

		/*
		 * function: Get an input||technology by id
		 */
		function getInput(id,isTechnology){
			isTechnology=isTechnology||false;
			var ret;
			if(isTechnology){
				ret=Technologies.filter(el=>{return id==el.id});
			}else{
				ret=Inputs.filter(el=>{return id==el.id});
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

		/*
		 * function: Set an input||technology by id
		 */
		function setInput(id,newValue,isTechnology){
			isTechnology=isTechnology||false;
			getInput(id,isTechnology).value=newValue;
			init();
		}

		/*
		 * Structure: Outputs, elementary flows for water, air and sludge (g/d)
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
			//inputs and technologies
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

			var Pri = getInput("Pri",true).value; //tech
			var Nit = getInput("Nit",true).value; //tech
			var Des = getInput("Des",true).value; //tech
			var BiP = getInput("BiP",true).value; //tech
			var ChP = getInput("ChP",true).value; //tech

			//technologies booleans
			var primary_effluent_wastewater = Pri;
			var raw_wastewater              = !Pri;
			var nitrification               = Nit;
			var denitrification             = Des;

			/* Equations start */
			var bCOD = 1.6*BOD;
			var nbCOD = COD - bCOD;
			var nbsCODe = sCOD - 1.6*sBOD
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
			var mu_mT = mu_m * Math.pow(1.07, T - 20);
			var bHT = bH * Math.pow(1.04, T - 20); 
			var S = Ks*(1+bHT*SRT)/(SRT*(mu_mT-bHT)-1);
			var P_X_bio = (Q*YH*(S0 - S) / (1 + bHT*SRT) + (fd*bHT*Q*YH*(S0 - S)*SRT) / (1 + bHT*SRT))/1000;
			var P_X_VSS = P_X_bio + Q*nbVSS/1000;
			var P_X_TSS = P_X_bio/0.85 + Q*nbVSS/1000 + Q*(TSS-VSS)/1000;
			var X_VSS_V = P_X_VSS*SRT;
			var X_TSS_V = P_X_TSS*SRT;
			var V_reactor = X_TSS_V*1000/MLSS_X_TSS;
			var tau = V_reactor*24/Q;
			var MLVSS = X_VSS_V/X_TSS_V*MLSS_X_TSS;
			var VSSe = TSSe*0.85
			var Qwas = (V_reactor*MLSS_X_TSS/SRT - TSSe*Q)/(-TSSe + TSS_was);

			//TABLE 3
			//inputs
			var TKN   = getInput('TKN').value;   //35
			var Ne    = getInput('Ne').value;    //0.50
			var NOx_e = getInput('NOx_e').value; //TODO find default value

			//equations
			var nbpON = 0.064*nbVSS;
			var nbsON = 0.3;
			var TKN_N2O = 0.001*TKN;
			var bTKN = TKN - nbpON - nbsON - TKN_N2O;
			var NOx = bTKN - Ne - 0.12*P_X_bio;

			//TABLE 4
			var TP = getInput('TP').value; //6
			//equations
			var nbpP = 0.025*nbVSS;
			var nbsP = 0;
			var aP = TP - nbpP - nbsP;
			var aPchem = aP - 0.015*P_X_bio/Q;

			//OUTPUTS table 5 elementary flows-->
			//COD
			var sCODe = Q*nbsCODe + Q*Ks*(1+fd*SRT)/(SRT*(YH-bHT)-1)
			var biomass_CODe = Q*VSSe*1.42;
			Outputs.COD.water = sCODe + biomass_CODe;
			Outputs.COD.air = 0;
			Outputs.COD.sludge = (function(){
				var A = (Q*YH*(S0-S)/(1+bHT*SRT) + fd*bHT*Q*YH*(S0-S)*SRT/(1+bHT*SRT))/1000;
				var B = Qwas * sCODe;
				return A+B;
			})();

			//CO2
			Outputs.CO2.water=0;
			Outputs.CO2.air=0;
			Outputs.CO2.sludge=0;

			//CH4
			Outputs.CH4.water = 0;
			Outputs.CH4.air = (bCOD*Q*0.95);
			Outputs.CH4.sludge = 0;

			//TKN
			Outputs.TKN.water=0;
			var sTKNe = Ne*Q + nbsON*Q;
			Outputs.TKN.air = (function(){
				if(nitrification){
					return sTKNe + Q*VSSe*0.12;
				}
				else{
					return Q*TKN - 0.12*P_X_bio;
				}
			})();
			Outputs.TKN.sludge = 0.12*P_X_bio + Qwas*sTKNe;

			//NOx
			Outputs.NOx.water=(function(){
				if(denitrification){
					return Q*NOx_e;
				}else{
					return Q*(bTKN - Ne) - 0.12*P_X_bio;
				}
			})();
			Outputs.NOx.air=0;
			Outputs.NOx.sludge=Qwas*NOx_e;

			//N2
			Outputs.N2.water=0;
			Outputs.N2.air = 0.22 * (NOx - NOx_e);
			Outputs.N2.sludge=0;

			//N2O
			Outputs.N2O.water=0;
			Outputs.N2O.air=Q*TKN_N2O;
			Outputs.N2O.sludge=0;

			//TP
			Outputs.TP.sludge=(function(){
				if(BiP || ChP){
					return 0;//TODO	
				}else{
					return TP;
				}
			})();
			Outputs.TP.air=0;
			Outputs.TP.sludge=0;

			//TS
			Outputs.TS.water=0;
			Outputs.TS.air=0;
			Outputs.TS.sludge=0;
		}
	</script>

	<!--init/frontend-->
	<script>
		function init(){
			compute_elementary_flows();
			updateViews();
		}

		/*
		 * frontend update views
		 */
		function updateViews(){
			//update inputs
			var table=document.querySelector('table#inputs');
			while(table.rows.length>1){table.deleteRow(-1)}
			Inputs.forEach(i=>{
				var newRow=table.insertRow(-1);
				newRow.title=i.descr;
				newRow.insertCell(-1).innerHTML=i.id;
				newRow.insertCell(-1).innerHTML="<input id='"+i.id+"' value='"+i.value+"' type=number onchange=setInput('"+i.id+"',this.value)>"
				newRow.insertCell(-1).innerHTML=i.unit.replace('m3','m<sup>3</sup>');
			});

			//update outputs
			var table=document.querySelector('table#outputs');
			while(table.rows.length>2){table.deleteRow(-1)}
			for(var output in Outputs) {
				var newRow=table.insertRow(-1);
				newRow.insertCell(-1).innerHTML=output
					.replace('O2','O<sub>2</sub>')
					.replace('N2','N<sub>2</sub>')
					.replace('CH4','CH<sub>4</sub>');

				newRow.insertCell(-1).innerHTML=format(Outputs[output].water);
				newRow.insertCell(-1).innerHTML=format(Outputs[output].air);
				newRow.insertCell(-1).innerHTML=format(Outputs[output].sludge);
			}
		}
	</script>
</head><body onload="init()">

<!--title-->
<h1>Elementary Flows</h1>

<!--temporal note-->
<p>Implementation in progress as <?php echo date("M-d-Y") ?> <hr>

<!--inputs and outputs scaffold-->
<div id=root>
	<div style="display:flex;flex-wrap:wrap">
		<!--inputs-->
		<div>
			<p>1. Inputs</p>
			<table id=inputs border=1>
				<tr><th>Input<th>Value<th>Unit
			</table>
		</div>

		<!--margin--><div>&emsp;</div>

		<!--outputs-->
		<div>
			<p>2. Outputs</p>
			<table id=outputs border=1 cellpadding=2>
				<tr>
					<th rowspan=2>Compound
					<th colspan=3>Effluent (g/d)
				</tr>
				<tr>
					<th>Water<th>Air<th>Sludge
				</tr>
			</table>
		</div>
	</div><hr>
	<!--mass balances-->
	<div>
		<p>3. Mass balances (pending)</p>
		<table border=1>
			<tr><th>Element <th>Influent (g/d) <th>Effluent (g/d) <th>Air (g/d) <th>Sludge (g/d) <th>Difference in mass balance (g/d)
			<tr><td>C       <td>Q·COD          <td>1:1            <td>2:2       <td>1:3          <td>A-B-C-D
			<tr><td>N       <td>Q·TKN          <td>4:1+5:1        <td>6:2+7:2   <td>4:3+5:3      <td>A-B-C-D
			<tr><td>P       <td>Q·TP           <td>8:1            <td>-         <td>8:3          <td>A-B-C-D
			<tr><td>C       <td>Q·TS           <td>9:1            <td>-         <td>9:3          <td>A-B-C-D
		</table>
	</div>
	<hr>
	<a href=inputs.php>Back</a>
</div>

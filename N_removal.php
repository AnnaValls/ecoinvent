<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Preanxoic denitrification process design</title>
	<script src="format.js"></script>
	<script>
		function init(){
			compute_exercise();
		}
	</script>
	<style>
		body{
			max-width:85em;
			margin:auto;
			margin-bottom:100px;
		}
		.invisible{
			display:none;
		}
		.number, [type=number]{
			text-align:right;
		}
		table{
			border-collapse:collapse;
			border:1px solid #ccc;
			margin:5px auto;
		}
		td,th{
			padding:0.1em 0.3em;
		}
		th{
			text-align:left;
			border-bottom:1px solid black;
		}
		code{
			display:block;
			background:#ddd;
			padding:5px 0;
			padding-left:5px;
		}
		.flex{
			display:flex;
			flex-wrap:wrap;
		}
		.flex li {
			margin-right:30px;
		}
		#calculated_variables span[id] {
			color:blue;
		}
		#btn_calculate{
			display:block;
			font-size:22px;
		}
		[onclick]{
			cursor:pointer;
		}
		input {
			width:100px;
		}
		table[id^=results] span[id]{
			color:blue;
		}
	</style>
</head><body onload="init()">

<!--title-->
<div>
	<h1>Metcalf &amp; Eddy, Wastewater Engineering, 5th ed, 2014</h1>
	<h2>Implementation of Example 8-7 (p. 810)</h2>
	<h3 onclick=document.getElementById('enunciat').classList.toggle('invisible')>
		Preanoxic Denitrification Process Design for MLE Process
	</h3><hr>
</div>

<!--problem statement-->
<div id=enunciat>
	<p>
		Design a preanoxic basin for (a) the CMAS nitrification-secondary clarifiery system described in Example 8-3
		to produce an effluent NH4-N and NO3-N concentration of 0.50 and
		6.0 g/m<sup>3</sup> respectively.
	</p>
	<p> Wastewater characteristics: </p>
	<p><b>Part A - Design for CMAS Process</b></p>
	<div>1. Design conditions</div>
	<div class=flex>
		<table>
			<tr><th>Constituent<th>Concentration (g/m<sup>3</sup> = mg/L)
			<tr><td>BOD             <td class=number>140
			<tr><td>bCOD            <td class=number>224
			<tr><td>rbCOD           <td class=number>80
			<tr><td>NOx             <td class=number>28.9
			<tr><td>TP              <td class=number>6
			<tr><td>Alkalinity      <td class=number>140
		</table>
		<table>
			<tr><th>Constituent<th>Unit<th>Value
			<tr><td>Influent flowrate     <td>m<sup>3</sup>/d<td class=number>22700
			<tr><td>Temperature           <td>ºC<td class=number>12
			<tr><td>MLSS                  <td>g/m<sup>3</sup><td class=number>3000
			<tr><td>MLVSS                 <td>g/m<sup>3</sup><td class=number>2370
			<tr><td>Aerobic SRT           <td>d<td class=number>21
			<tr><td>Aeration basin volume <td>m<sup>3</sup><td class=number>13410
			<tr><td>Aerobic               <td>h<td class=number>14.2
			<tr><td>Anoxic mixing energy  <td>kW/10<sup>3</sup>m<sup>3</sup><td class=number>5
			<tr><td>RAS ratio             <td>&empty;<td class=number>0.6
			<tr><td>R<sub>o</sub>         <td>kg O<sub>2</sub>/h<td class=number>275.9
		</table>
	</div>
	<div>2. Assumptions</div>
	<ul>
		<li>a. Nitrate concentration in RAS = 6 g/m<sup>3</sup>.
		<li>b. Use the same coefficients as the nitrification process design.
		<li>c. Mixing energy for anoxic reactor = 5 kW/10<sup>3</sup> m<sup>3</sup>.
	</ul>
</div><hr>

<!--implementation gui-->
<div><h2>Implementation in Javascript</h2>
	<div> <button id=btn_calculate onclick=compute_exercise() style>Solve</button> </div>
	<ol class=flex>
		<li><div>Inputs</div>
			<table>
				<tr><td>Q               <td><input type=number id=input_Q value=22700> m<sup>3</sup>/d
				<tr><td>T               <td><input type=number id=input_T value=12> ºC
				<tr><td>BOD             <td><input type=number id=input_BOD value=140> g/m<sup>3</sup>
				<tr><td>bCOD            <td><input type=number id=input_bCOD value=224> g/m<sup>3</sup>
				<tr><td>rbCOD           <td><input type=number id=input_rbCOD value=80> g/m<sup>3</sup>
				<tr><td>NOx             <td><input type=number id=input_NOx value=28.9> g/m<sup>3</sup>
				<tr><td>TP              <td><input type=number id=input_TP value=6> g/m<sup>3</sup>
				<tr><td>Alkalinity      <td><input type=number id=input_Alkalinity value=140> as CaCO<sub>3</sub>
				<tr><td colspan=2><b>Inputs from nitrification</b>
				<tr><td>MLSS                  <td><span class=number>3000  g/m<sup>3</sup>                
				<tr><td>MLVSS                 <td><span class=number>2370  g/m<sup>3</sup>                
				<tr><td>Aerobic SRT           <td><span class=number>21    d                              
				<tr><td>Aeration basin volume <td><span class=number>13410 m<sup>3</sup>                  
				<tr><td>Aerobic               <td><span class=number>14.2  h                              
				<tr><td>Anoxic mixing energy  <td><span class=number>5     kW/10<sup>3</sup>m<sup>3</sup> 
				<tr><td>RAS ratio             <td><span class=number>0.6   &empty;                        
				<tr><td>R<sub>o</sub>         <td><span class=number>275.9 kg O<sub>2</sub>/h             
			</table>
			</table>
		</li><li><div>Tabulated parameters</div>
			<table>
				<tr><td>Y<sub>H</sub> <td class=number>0.45<td>%
				<tr><td>&tau;         <td class=number>2.5<td>h
				<tr><td>&theta;       <td class=number>1.026<td> &empty;
				<tr><td> Alkalinity to<br>maintain<br>pH ~ 7
				                      <td class=number>70<td> g/m<sup>3</sup> as CaCO<sub>3</sub>
				</tr>
			</table>
		</li><li><div>Results</div>
			<table id=results>
				<tr><td>X<sub>b</sub>             <td class=number><span id=result_Xb>?</span><td>g/m<sup>3</sup>
				<tr><td>IR                        <td class=number><span id=result_IR>?</span><td>&empty;
				<tr><td>Flowrate to anoxic tank   <td class=number><span id=result_Flowrate_to_anoxic_tank>?</span><td>m3/d
				<tr><td>NO<sub>x</sub> feed       <td class=number><span id=result_NOx_feed>?</span><td>g/d
				<tr><td>V<sub>nox</sub>           <td class=number><span id=result_V_nox>?</span><td>m<sup>3</sup>
				<tr><td>F/M<sub>b</sub>           <td class=number><span id=result_FM_b>?</span><td>g/g·d
				<tr><td>Fraction of rbCOD         <td class=number><span id=result_Fraction_of_rbCOD>?</span><td>%
				<tr><td>b<sub>0</sub> (only if F/M<sub>b</sub>&gt;0.5) <td class=number><span id=result_b0>-</span><td>g/g·d
				<tr><td>b<sub>1</sub> (only if F/M<sub>b</sub>&gt;0.5) <td class=number><span id=result_b1>-</span><td>g/g·d

				<tr><td>SDNR<sub>b</sub>          <td class=number><span id=result_SDNR_b>?</span><td>g/g·d
				<tr><td>SDNR<sub>T</sub>          <td class=number><span id=result_SDNR_T>?</span><td>g/g·d
				<tr><td>SDNR<sub>adj</sub>        <td class=number><span id=result_SDNR_adj>?</span><td>g/g·d
				<tr><td>Overall SDNR              <td class=number><span id=result_SDNR>?</span><td>g/g·d

				<tr><td>NO<sub>r</sub>            <td class=number><span id=result_NO_r>?</span><td>g/d

				<tr><td>Net O<sub>2</sub> required<td class=number><span id=result_Net_O2_required>?</span><td>kg O<sub>2</sub>/h
				<tr><td>Mass of alkalinity needed <td class=number><span id=result_Mass_of_alkalinity_needed>?</span><td> kg/d as CaCO<sub>3</sub>
				<tr><td>Power                     <td class=number><span id=result_Power>?</span><td>kW
			</table>
		</li>
	</ol>
</div>

<!--implementation-->
<script>
	function compute_exercise(){

		//Wastewater characteristics
		var BOD=getInput('input_BOD');
		var bCOD=getInput('input_bCOD');
		var rbCOD=getInput('input_rbCOD');
		var NOx=getInput('input_NOx');
		var TP=getInput('input_TP');
		var Alkalinity=getInput('input_Alkalinity');

		//Design conditions
		var Q = getInput('input_Q');
		var T = getInput('input_T');

		//tabulated parameters
		var YH = 0.45;

		var MLSS = 3000; //g/m3
		var MLVSS = 2370; //g/m3
		var Aerobic_SRT = 21; //d
		var Aeration_basin_volume = 13410; //m3
		var Aerobic = 14.2; //h (?)
		var Anoxic_mixing_energy = 5; //kW
		var RAS = 0.6; //unitless
		var Ro = 275.9; //kgO2/h
		var Ne = 6; //g/m3

		//calculated parameters in previous implementations
		var bH = 0.12*Math.pow(1.04, T - 20); 
		
		//SOLUTIONS
		//1
		var Xb = Q*Aerobic_SRT*YH*bCOD/(1+bH*Aerobic_SRT)/Aeration_basin_volume; //g/m3
		//2
		var IR = NOx/Ne - 1 - RAS;
		//3
		var Flowrate_to_anoxic_tank = Q*(IR+RAS); //m3/d

		var NOx_feed = Flowrate_to_anoxic_tank*Ne; //g/d
		//4
		var Tau = 2.5/24; //d
		var V_nox = Tau*Q; //m3
		//5
		var FM_b = Q*BOD/(V_nox*Xb); //g/g·d

		//6
		if(FM_b>0.50){
			//table 8-22, page 806
			var Table8_22=[
				{rbCOD:0 ,b0:0.186,b1:0.078},
				{rbCOD:10,b0:0.186,b1:0.078},
				{rbCOD:20,b0:0.213,b1:0.118},
				{rbCOD:30,b0:0.235,b1:0.141},
				{rbCOD:40,b0:0.242,b1:0.152},
				{rbCOD:50,b0:0.270,b1:0.162},
			];
			//compute the fraction of rbCOD to find b0 and b1 in the table 8-22
			var Fraction_of_rbCOD = Math.max(0,Math.min(50,Math.floor(100*rbCOD/bCOD))); //min:0, max:50 (for the lookup table)
			Fraction_of_rbCOD -= Fraction_of_rbCOD%10; //round to 0,10,20,30,40, or 50.
			console.log("Fraction of rbCOD (rounded): "+Fraction_of_rbCOD+"%");
			//lookup the value in the table
			var b0=Table8_22.filter(row=>{return row.rbCOD==Fraction_of_rbCOD})[0].b0;
			var b1=Table8_22.filter(row=>{return row.rbCOD==Fraction_of_rbCOD})[0].b1;
			console.log(" b0: "+b0);
			console.log(" b1: "+b1);
			var SDNR_b = b0 + b1*Math.log(FM_b); //gNO3-N/gMLVSS,biomass·d
		}else{
			var b0='-';//not used
			var b1='-';//not used
			var SDNR_b = 0.24*FM_b;
		}

		//temperature correction
		var SDNR_T = SDNR_b * Math.pow(1.026,T-20) //g/g·d

		//correction for SNDR (page 808)
		if(IR<=1){
			var SDNR_adj = SDNR_T; //g/g·d
		}else if(IR<=3){
			var SDNR_adj = SDNR_T - 0.0166*Math.log(FM_b) - 0.078; //g/g·d (Eq. 8.59)
		}else{
			var SDNR_adj = SDNR_T - 0.029*Math.log(FM_b) - 0.012; //g/g·d  (Eq. 8-60)
		}

		//7
		var SDNR = SDNR_adj*Xb/MLVSS; //g/g·d
		//8
		var NO_r = V_nox*SDNR_adj*Xb; //g/d
		//9
		var Oxygen_credit = 2.86*(NOx-Ne)*Q/1000/24; //kg/h
		var Net_O2_required = Ro - Oxygen_credit; //kg/h
		//10
		var Alkalinity_used = 7.14*NOx; //g/m3
		var Alkalinity_produced = 3.57*(NOx-Ne); //g/m3
		var Alk_to_be_added = 70 - Alkalinity + Alkalinity_used - Alkalinity_produced; //g/m3
		var Mass_of_alkalinity_needed = Alk_to_be_added * Q /1000; //kg/d as CaCO3
		//11
		var Power = V_nox * Anoxic_mixing_energy / 1000; //kW

		//show results
		showResult("result_Xb",Xb);
		showResult("result_IR",IR);
		showResult('result_Flowrate_to_anoxic_tank',Flowrate_to_anoxic_tank);
		showResult('result_NOx_feed',NOx_feed);
		showResult("result_V_nox",V_nox);
		showResult("result_FM_b",FM_b);
		showResult('result_Fraction_of_rbCOD',100*rbCOD/bCOD);
		showResult('result_b0',b0);
		showResult('result_b1',b1);
		showResult("result_SDNR_b",SDNR_b);
		showResult("result_SDNR_T",SDNR_T);
		showResult("result_SDNR_adj",SDNR_adj);
		showResult("result_SDNR",SDNR);
		showResult("result_NO_r",NO_r);
		showResult("result_Net_O2_required",Net_O2_required);
		showResult("result_Mass_of_alkalinity_needed",Mass_of_alkalinity_needed);
		showResult("result_Power",Power);
	}

</script>

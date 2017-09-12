<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Preanxoic denitrification process design</title>
	<script>
		function init(){
			//compute_exercise();
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
		.number{
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
			width:100%;
			margin:auto;
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
	</h3>
	<hr>
</div>

<!--btn show hide statement-->

<!--problem statement-->
<div id=enunciat>
	<p>
		Design a preanoxic basin for (a) the CMAS nitrification-secondary clarifiery system described in Example 8-3
		to produce an effluent NH4-N and NO3-N concentration of 0.50 and
		6.0 g/m3 respectively.
	</p>
	<p>
		Wastewater characteristics:
	</p>
	<table>
		<tr><th>Constituent<th>Concentration (g/m3 = mg/L)
		<tr><td>BOD             <td class=number>140
		<tr><td>bCOD            <td class=number>224
		<tr><td>rbCOD           <td class=number>80
		<tr><td>NOx             <td class=number>28.9
		<tr><td>TP              <td class=number>6
		<tr><td>Alkalinity      <td class=number>140
	</table>
	<p>Part A - Design for CMAS Process</p>
	<div>1. Design conditions</div>
	<table>
		<tr><th>Constituent<th>Unit<th>Value
		<tr><td>Influent flowrate     <td>m3/d<td class=number>22700
		<tr><td>Temperature           <td>ºC<td class=number>12
		<tr><td>MLSS                  <td>g/m3<td class=number>3000
		<tr><td>MLVSS                 <td>g/m3<td class=number>2370
		<tr><td>Aerobic SRT           <td>d<td class=number>21
		<tr><td>Aeration basin volume <td>m3<td class=number>13410
		<tr><td>Aerobic               <td>h<td class=number>14.2
		<tr><td>Anoxic mixing energy  <td>kW/10<sup>3</sup>m<sup>3</sup><td class=number>14.2
		<tr><td>RAS ratio             <td>&empty;<td class=number>0.6
		<tr><td>R<sub>o</sub>         <td>kg/hempty;<td class=number>275.9
	</table>
	<div>2. Assumptions</div>
	<DIV style=background:red>CONTINUE HERE</DIV>
</div><hr>

<!--implementation gui-->
<div><h2>Implementation in Javascript</h2>
	<ol class=flex>
		<li><div>Inputs</div>
			<table style=width:100%>
				<tr><td>Q               <td><input type=number class=number id=Q value=22700> m<sup>3</sup>/d
				<tr><td>T               <td><input type=number class=number id=T value=12> ºC
				<tr><td>BOD             <td><input type=number class=number id=BOD value=140> g/m<sup>3</sup>
				<tr><td>bCOD            <td><input type=number class=number id=bCOD value=224> g/m<sup>3</sup>
				<tr><td>rbCOD           <td><input type=number class=number id=rbCOD value=80> g/m<sup>3</sup>
				<tr><td>NOx             <td><input type=number class=number id=NOx value=28.9> g/m<sup>3</sup>
				<tr><td>TP              <td><input type=number class=number id=TP value=6> g/m<sup>3</sup>
				<tr><td>Alkalinity      <td><input type=number class=number id=Alkalinity value=140> as CaCO<sub>3</sub>

				<tr><td><b>Design parameters</b>
				<tr><td>SRT                         <td><input type=number class=number id=parameter_SRT value=5> d
				<tr><td>MLSS<sub>X,TSS</sub>        <td><input type=number class=number id=parameter_MLSS_X_TSS value=3000> g/m<sup>3</sup>
				<tr><td>z<sub>b</sub> (elevation)   <td><input type=number class=number id=parameter_zb value=500> m 
				<tr><td>Pressure (at z<sub>b</sub>) <td><input type=number class=number id=parameter_Pressure value=95600> Pa
				<tr><td>D<sub>f</sub>               <td><input type=number class=number id=parameter_Df value=4.4> m
				<tr><td>sBOD<sub>e</sub>            <td><input type=number class=number id=parameter_sBODe value=3> g/m<sup>3</sup>
				<tr><td>TSS<sub>e</sub>             <td><input type=number class=number id=parameter_TSSe value=10> g/m<sup>3</sup>
				<tr><td>X<sub>R</sub>               <td><input type=number class=number id=parameter_X_R value=8000> g/m<sup>3</sup>
				<tr><td>Hydraulic application rate  <td><input type=number class=number id=parameter_hydraulic_application_rate value=24> m<sup>3</sup>/m<sup>2</sup>·d
				<tr><td>Clarifiers                  <td><input type=number class=number id=parameter_clarifiers value=3> clarifiers
				<tr><td>Clarifier diameter          <td><input type=number class=number id=parameter_clarifier_diameter value=20> m
			</table>
			</table>
			<div>
				<button id=btn_calculate onclick=compute_exercise() style>Solve</button>
			</div>
		</li><li><div>Tabulated parameters</div>
			<table>
				<tr><td>Y<sub>H</sub>                  <td class=number>0.45<td>gVSS/gbCOD
				<tr><td>K<sub>s</sub>                  <td class=number>8<td>g/m<sup>3</sup>
				<tr><td>&mu;<sub>m</sub>               <td class=number>6<td>d<sup>-1</sup>
				<tr><td>b<sub>H</sub>                  <td class=number>0.12<td>d<sup>-1</sup>
				<tr><td>f<sub>d</sub>                  <td class=number>0.15<td>g/g
				<tr><td>Pa                             <td class=number>10.33<td>m
				<tr><td>R                              <td class=number>8314<td>J/K·kmol
				<tr><td>g                              <td class=number>9.81<td>m/s<sup>2</sup>
				<tr><td>M<sub>air</sub>                <td class=number>28.97<td>g/mol
				<tr><td>&alpha;                        <td class=number>0.50<td>&empty;
				<tr><td>&alpha;<sub>nitrification</sub><td class=number>0.65<td>&empty;
				<tr><td>&beta;                         <td class=number>0.95<td>&empty;
				<tr><td>F                              <td class=number>0.9<td>&empty;
				<tr><td>C<sup>*</sup><sub>s,20</sub>   <td class=number>9.09<td>mg/L
				<tr><td>d<sub>e</sub>                  <td class=number>0.40<td>&empty;
				<tr><td>C<sub>L</sub>                  <td class=number>2.0<td>mg/L
				<tr><td>SF                             <td class=number>1.5<td>&empty;
				<tr><td>&mu;<sub>max,AOB</sub>         <td class=number>0.90<td>d<sup>-1</sup>
				<tr><td>b<sub>AOB</sub>                <td class=number>0.17<td>d<sup>-1</sup>
				<tr><td>K<sub>NH<sub>4</sub></sub>     <td class=number>0.50<td>g/m<sup>3</sup>
				<tr><td>K<sub>o,AOB</sub>              <td class=number>0.50<td>g/m<sup>3</sup>
				<tr><td>S<sub>NH<sub>4</sub></sub>     <td class=number>0.50<td>g/m<sup>3</sup>
				<tr><td>Y<sub>n</sub>                  <td class=number>0.15<td>gVSS/gNOx
				<tr><td>N<sub>e</sub>                  <td class=number>0.50<td>g/m<sup>3</sup>
				<tr><td>E                              <td class=number>35<td>%
			</table>
		</li><li><div>Results</div>
			<table id=results>
				<tr><th colspan=3>BOD removal only
				<tr><td>bCOD                <td class=number><span id=part_A_bCOD>?</span><td>g/m<sup>3</sup>
				<tr><td>nbCOD               <td class=number><span id=part_A_nbCOD>?</span><td>g/m<sup>3</sup>
				<tr><td>nbsCODe             <td class=number><span id=part_A_nbsCODe>?</span><td>g/m<sup>3</sup>
				<tr><td>nbVSS               <td class=number><span id=part_A_nbVSS>?</span><td>g/m<sup>3</sup>
				<tr><td>iTSS                <td class=number><span id=part_A_iTSS>?</span><td>g/m<sup>3</sup>
				<tr><td>P<sub>X,Bio</sub>   <td class=number><span id=part_A_P_X_bio>?</span><td>kgVSS/d
				<tr><td>P<sub>X,VSS</sub>   <td class=number><span id=part_A_P_X_VSS>?</span><td>kg/d
				<tr><td>P<sub>X,TSS</sub>   <td class=number><span id=part_A_P_X_TSS>?</span><td>kg/d
				<tr><td>X<sub>VSS</sub>V    <td class=number><span id=part_A_X_VSS_V>?</span><td>kg
				<tr><td>X<sub>TSS</sub>V    <td class=number><span id=part_A_X_TSS_V>?</span><td>kg
				<tr><td>V                   <td class=number><span id=part_A_V>?</span><td>m<sup>3</sup>
				<tr><td>&tau;               <td class=number><span id=part_A_tau>?</span><td>h
				<tr><td>MLVSS               <td class=number><span id=part_A_MLVSS>?</span><td>g/m<sup>3</sup>
				<tr><td>BOD loading         <td class=number><span id=part_A_BOD_loading>?</span><td>kg/m<sup>3</sup>·d
				<tr><td>bCOD removed        <td class=number><span id=part_A_bCOD_removed>?</span><td>kg/d
				<tr><td>O<sub>2</sub> demand<td class=number><span id=part_A_R0>?  </span><td>kgO<sub>2</sub>/h
				<tr><td>P<sub>b</sub>       <td class=number><span id=part_A_Pb>?  </span><td>m
				<tr><td>C<sub>T</sub>       <td class=number><span id=part_C_T>?  </span><td>mg/L
				<tr><td>SOTR                <td class=number><span id=part_A_SOTR>?</span><td>kg/h
				<tr><td>Air flowrate        <td class=number><span id=part_A_air_flowrate>?</span><td>m<sup>3</sup>/min
				<tr><th colspan=3>
				<tr><th colspan=3>BOD removal and nitrification
				<tr><td>&mu;<sub>AOB</sub>      <td class=number><span id=part_B_mu_AOB>?</span><td>d<sup>-1</sup>
				<tr><td>SRT theoretical         <td class=number><span id=part_B_SRT_theoretical>?</span><td>d
				<tr><td>SRT design              <td class=number><span id=part_B_SRT_design>?</span><td>d
				<tr><td>NO<sub>x</sub>          <td class=number><span id=part_B_NOx>?</span><td>g/m<sup>3</sup>
				<tr><td>P<sub>X,Bio,VSS</sub>   <td class=number><span id=part_B_P_X_bio_VSS>?</span><td>kgVSS/d
				<tr><td>P<sub>X,VSS</sub>       <td class=number><span id=part_B_P_X_VSS>?</span><td>kg/d
				<tr><td>P<sub>X,TSS</sub>       <td class=number><span id=part_B_P_X_TSS>?</span><td>kg/d
				<tr><td>X<sub>VSS</sub>V        <td class=number><span id=part_B_X_VSS_V>?</span><td>kg
				<tr><td>X<sub>TSS</sub>V        <td class=number><span id=part_B_X_TSS_V>?</span><td>kg
				<tr><td>V                       <td class=number><span id=part_B_V>?</span><td>m<sup>3</sup>
				<tr><td>&tau;                   <td class=number><span id=part_B_tau>?</span><td>h
				<tr><td>MLVSS                   <td class=number><span id=part_B_MLVSS>?</span><td>g/m<sup>3</sup>
				<tr><td>BOD loading             <td class=number><span id=part_B_BOD_loading>?</span><td>kg/m<sup>3</sup>·d
				<tr><td>bCOD removed            <td class=number><span id=part_B_bCOD_removed>?</span><td>kg/d
				<tr><td>O<sub>2</sub> demand    <td class=number><span id=part_B_R0>?  </span><td>kgO<sub>2</sub>/h
				<tr><td>SOTR                    <td class=number><span id=part_B_SOTR>?</span><td>kg/h
				<tr><td>Air flowrate            <td class=number><span id=part_B_air_flowrate>?</span><td>m<sup>3</sup>/min
				<tr><td>NaHCO<sub>3</sub> added <td class=number><span id=part_B_alkalinity_to_be_added>?</span><td>kg/d as NaHCO<sub>3</sub>
				<tr><td>BOD effluent            <td class=number><span id=part_B_BOD_eff>?</span><td>g/m<sup>3</sup>
				<tr><th colspan=3>
				<tr><th colspan=3>Secondary clarifier sizing
				<tr><td>R                       <td class=number><span id=part_C_R_ratio>?</span><td>&empty;
				<tr><td>Area                    <td class=number><span id=part_C_Area>?</span><td>m<sup>2</sup>
				<tr><td>Area per clarifier      <td class=number><span id=part_C_area_per_clarifier>?</span><td>m<sup>2</sup>/clarifier
				<tr><td>Area of clarifiers      <td class=number><span id=part_C_area_of_clarifiers>?</span><td>m<sup>2</sup>
				<tr><td>Solids loading          <td class=number><span id=part_C_Solids_loading>?</span><td>kg MLSS/m<sup>2</sup>·h
			</table>
		</li>
	</ol>
</div>

<!--implementation-->
<script>
	function compute_exercise(){
		//get inputs
			var BOD            = parseFloat(document.querySelector('#BOD').value);
			var sBOD           = parseFloat(document.querySelector('#sBOD').value);
			var COD            = parseFloat(document.querySelector('#COD').value);
			var sCOD           = parseFloat(document.querySelector('#sCOD').value);
			var rbCOD          = parseFloat(document.querySelector('#rbCOD').value);
			var TSS            = parseFloat(document.querySelector('#TSS').value);
			var VSS            = parseFloat(document.querySelector('#VSS').value);
			var TKN            = parseFloat(document.querySelector('#TKN').value);
			var NH4_N          = parseFloat(document.querySelector('#NH4_N').value);
			var TP             = parseFloat(document.querySelector('#TP').value);
			var Alkalinity     = parseFloat(document.querySelector('#Alkalinity').value);
			var bCOD_BOD_ratio = parseFloat(document.querySelector('#bCOD_BOD_ratio').value);
			var Q              = parseFloat(document.querySelector('#Q').value);
			var T              = parseFloat(document.querySelector('#T').value);
		//end inputs

		//design parameters
			var SRT        = parseFloat(document.querySelector('#parameter_SRT').value); //5
			var MLSS_X_TSS = parseFloat(document.querySelector('#parameter_MLSS_X_TSS').value); //3000
			var zb         = parseFloat(document.querySelector('#parameter_zb').value); //500
			var Pressure   = parseFloat(document.querySelector('#parameter_Pressure').value); //95600
			var Df         = parseFloat(document.querySelector('#parameter_Df').value); //4.4 = 4.9m-0.5m, from design conditions and assumptions (depth of diffusers in basin)

		//tabulated parameters
			var Y = 0.45;
			var Ks = 8;
			var mu_m = 6;
			var bH = 0.12;
			var fd = 0.15;
			var Pa = 10.33; //m standard pressure at sea level
			var R = 8314; //kg*m2/s2*kmol*K (ideal gases constant)
			var g = 9.81;//m/s2 (gravity)
			var M = 28.97;//g/mol (air molecular weight)
			var alpha=0.50;//8.b
			var beta=0.95;//8.b
			var F=0.9;//8.b
			var C_s_20 = 9.09;//8.b sat DO at sea level at 20ºC
			var C_T = air_solubility_of_oxygen(T,0);//elevation=0 //Table E-1, Appendix E, implemented in "utils.js"
			var de=0.40;//8.b mid-depth correction factor (range: 0.25-0.45)
			var C_L=2.0;//DO in aeration basin (mg/L)
			var SF =1.5 //peak to average tkn load (design assumptions)
			var E = 0.35 //O2 transfer efficiency
		//end

		/*compute values*/
		//part A: bod removal without nitrification
			var bCOD = bCOD_BOD_ratio * BOD;
			var nbCOD = COD - bCOD;
			var nbsCODe = sCOD - bCOD_BOD_ratio * sBOD;
			var nbpCOD = COD - bCOD - nbsCODe;
			var VSS_COD = (COD-sCOD)/VSS;
			var nbVSS = nbpCOD/VSS_COD;
			var iTSS = TSS - VSS;
			var S0=bCOD;
			var mu_mT = mu_m * Math.pow(1.07, T - 20);
			var bHT = bH * Math.pow(1.04, T - 20); 
			var S = Ks*(1+bHT*SRT)/(SRT*(mu_mT-bHT)-1);
			var P_X_bio = (Q*Y*(S0 - S) / (1 + bHT*SRT) + (fd*bHT*Q*Y*(S0 - S)*SRT) / (1 + bHT*SRT))/1000;
			//3
			var P_X_VSS = P_X_bio + Q*nbVSS/1000;
			var P_X_TSS = P_X_bio/0.85 + Q*nbVSS/1000 + Q*(TSS-VSS)/1000;
			//4
			var X_VSS_V = P_X_VSS*SRT;
			var X_TSS_V = P_X_TSS*SRT;
			var V = X_TSS_V*1000/MLSS_X_TSS;
			var tau = V*24/Q;
			var MLVSS = X_VSS_V/X_TSS_V * MLSS_X_TSS;
			//5
			var FM = Q*BOD/MLVSS/V;
			var BOD_loading = Q*BOD/V/1000;
			//6
			var bCOD_removed = Q*(S0-S)/1000;
			var Y_obs_TSS = P_X_TSS/bCOD_removed*bCOD_BOD_ratio;
			var Y_obs_VSS = P_X_TSS/bCOD_removed*(X_VSS_V/X_TSS_V)*bCOD_BOD_ratio;
			var NOx=0;
			//7
			var R0 = (Q*(S0-S)/1000 -1.42*P_X_bio)/24 + 4.57*Q*NOx;
			//8
			var Pb = Pa*Math.exp(-g*M*(zb-0)/(R*(273.15+T)));
			var C_inf_20 = C_s_20 * (1+de*Df/Pa);
			var OTRf = R0;
			var SOTR = (OTRf/alpha/F)*(C_inf_20/(beta*C_T/C_s_20*Pb/Pa*C_inf_20-C_L))*(Math.pow(1.024,20-T));
			var kg_O2_per_m3_air = density_of_air(T,Pressure)*0.2318 //oxygen in air by weight is 23.18%, by volume is 20.99%
			var air_flowrate = SOTR/(E*60*kg_O2_per_m3_air);
		//end part A

		//show results for part A
			show_var('part_A_bCOD',bCOD);
			show_var('part_A_nbCOD',nbCOD);
			show_var('part_A_nbsCODe',nbsCODe);
			show_var('part_A_nbVSS',nbVSS);
			show_var('part_A_iTSS',iTSS);
			show_var('part_A_P_X_bio',P_X_bio);
			show_var('part_A_P_X_VSS',P_X_VSS);
			show_var('part_A_P_X_TSS',P_X_TSS);
			show_var('part_A_X_VSS_V',X_VSS_V);
			show_var('part_A_X_TSS_V',X_TSS_V);
			show_var('part_A_V',V);
			show_var('part_A_tau',tau);
			show_var('part_A_MLVSS',MLVSS);
			show_var('part_A_BOD_loading',BOD_loading);
			show_var('part_A_bCOD_removed',bCOD_removed);
			show_var('part_A_R0',R0);
			show_var('part_A_Pb',Pb);
			show_var('part_C_T',C_T);
			show_var('part_A_SOTR',SOTR);
			show_var('part_A_air_flowrate',air_flowrate);
		//end results part A

		//9: part B NITRIFICATION
			//parameters
			var mu_max_AOB = 0.90 //table 8-14 at 20ºC
			var b_AOB = 0.17 // table 8-14 at 20ºC
			var K_NH4 = 0.50 //table 8-14 at 20ºC
			var K_o_AOB = 0.50 //table 8-14 at 20ºC
			var S_NH4 = 0.50 //g/m3 at effluent?
			var Yn = 0.15; //Table 8-14
			var Ne = 0.50; //N at effluent?
			var alpha = 0.65;
			var beta = 0.95;

			//design parameters
			var sBODe = parseFloat(document.querySelector('#parameter_sBODe').value); //assume 3
			var TSSe  = parseFloat(document.querySelector('#parameter_TSSe').value); //assume 10 g/m3

			//9 start nitrification
			var mu_max_AOB_T = mu_max_AOB * Math.pow(1.072,T-20);
			var b_AOB_T = b_AOB* Math.pow(1.029,T-20);
			var mu_AOB = mu_max_AOB_T * (S_NH4/(S_NH4+K_NH4)) * (C_L/(C_L+K_o_AOB)) - b_AOB_T;
			//10
			var SRT_theoretical = 1/mu_AOB;
			var SRT_design = SF*SRT_theoretical;
			//11
			var S = Ks * (1+bHT*SRT_design) / (SRT_design*(mu_mT-bHT)-1);
			var NOx = 0.80 * TKN; //aproximation for nitrate, prior to iteration (80% of TKN)
			//biomass first approximation with first NOx concentration aproximation
			var P_X_bio_VSS = Q*Y*(S0-S)/(1+bHT*SRT_design) + fd*bHT*Q*Y*(S0-S)*SRT_design/(1+bHT*SRT_design) + Q*Yn*NOx/(1+b_AOB_T*SRT_design);
			P_X_bio_VSS/=1000;
			//12 iteration for finding more accurate value of NOx (nitrogen oxidized to nitrate)
			var NOx = TKN - Ne - 0.12*P_X_bio_VSS/Q*1000;
			//recalc PXbioVSS with accurate NOx (one iteration)
			var P_X_bio_VSS = Q*Y*(S0-S)/(1+bHT*SRT_design) + fd*bHT*Q*Y*(S0-S)*SRT_design/(1+bHT*SRT_design) + Q*Yn*NOx/(1+b_AOB_T*SRT_design);
			P_X_bio_VSS/=1000;

			//loop for NOx and PXBioVSS calculation
			(function(){
				console.log("=======================================")
				console.log("LOOP FOR NOx and PXbioVSS approximation")
				console.log("=======================================")
				//max difference
				var tolerance = 0.0001;

				//arrays for approximations
				var NOx_array = [NOx];
				var P_X_bio_VSS_array = [P_X_bio_VSS];

				//loop until difference < tolerance
				while(true){
					console.log("- new iteration")
					//increase accuracy of NOx from P_X_bio_VSS
					var last_NOx = TKN - Ne - 0.12*P_X_bio_VSS_array[P_X_bio_VSS_array.length-1]/Q*1000;
					NOx_array.push(last_NOx);
					//recalculate P_X_bio_VSS with NOx approximation
					var last_PX=(Q*Y*(S0-S)/(1+bHT*SRT_design)+fd*bHT*Q*Y*(S0-S)*SRT_design/(1+bHT*SRT_design)+Q*Yn*(last_NOx)/(1+b_AOB_T*SRT_design))/1000
					P_X_bio_VSS_array.push(last_PX);
					console.log("  NOx approximations: "+NOx_array);
					console.log("  PXbioVSS approximations: "+P_X_bio_VSS_array);
					//length of NOx approximations
					var l = NOx_array.length;
					var difference = Math.abs(NOx_array[l-1]-NOx_array[l-2]);
					if(difference<tolerance){
						NOx         = last_NOx;
						P_X_bio_VSS = last_PX;
						console.log('loop finished: difference is small enough ('+difference+')');
						break;
					}
				}
			})();

			//13
			var P_X_VSS = P_X_bio_VSS + Q*nbVSS/1000;
			var P_X_TSS = P_X_bio_VSS/0.85 + Q*nbVSS/1000 + Q*(TSS-VSS)/1000;
			var X_VSS_V = P_X_VSS * SRT_design;
			var X_TSS_V = P_X_TSS * SRT_design;
			//14
			var V = X_TSS_V*1000 / MLSS_X_TSS ;
			var tau = V/Q*24;
			var MLVSS = X_VSS_V/X_TSS_V * MLSS_X_TSS;
			//15
			var FM = Q*BOD/MLVSS/V
			var BOD_loading = Q*BOD/V/1000;
			//16
			var bCOD_removed = Q*(S0-S)/1000;
			var Y_obs_TSS = P_X_TSS/bCOD_removed*bCOD_BOD_ratio;
			var Y_obs_VSS = P_X_TSS/bCOD_removed*(X_VSS_V/X_TSS_V)*bCOD_BOD_ratio;
			//17
			var P_X_bio_VSS_without_nitrifying = Q*Y*(S0-S)/(1+bHT*SRT_design) + fd*bHT*Q*Y*(S0-S)*SRT_design/(1+bHT*SRT_design);
			P_X_bio_VSS_without_nitrifying /= 1000;
			var R0 = Q*(S0-S)/1000 -1.42*P_X_bio_VSS_without_nitrifying + 4.57*Q*NOx/1000;
			R0 /= 24;
			//18
			var OTRf = R0;
			var SOTR = (OTRf/alpha/F)*(C_inf_20/(beta*C_T/C_s_20*Pb/Pa*C_inf_20-C_L))*(Math.pow(1.024,20-T));
			var kg_O2_per_m3_air = density_of_air(T,Pressure)*0.2318 //oxygen in air by weight is 23.18%, by volume is 20.99%
			var air_flowrate = SOTR/(E*60*kg_O2_per_m3_air);
			//19 alkalinity 
			var alkalinity_to_be_added = 0;
			(function(){
				var alkalinity_used_for_nitrification = 7.14*NOx //g/m3 used as CaCO3
				alkalinity_to_be_added = 70-Alkalinity+alkalinity_used_for_nitrification; //g/m3 as CaCO3
				alkalinity_to_be_added*=Q/1000; // kg/d as CaCO3
				alkalinity_to_be_added*=(84/50); // kg/d as NaHCO3
			})();
			//20 estimate effluent BOD
			var BOD_eff = sBODe + 0.85*0.85*TSSe;
		//end part B

		//show results for part B
			show_var('part_B_mu_AOB',mu_AOB);
			show_var('part_B_SRT_theoretical',SRT_theoretical);
			show_var('part_B_SRT_design',SRT_design);
			show_var('part_B_NOx',NOx);
			show_var('part_B_P_X_bio_VSS',P_X_bio_VSS);
			show_var('part_B_P_X_VSS',P_X_VSS);
			show_var('part_B_P_X_TSS',P_X_TSS);
			show_var('part_B_X_VSS_V',X_VSS_V);
			show_var('part_B_X_TSS_V',X_TSS_V);
			show_var('part_B_V',V);
			show_var('part_B_tau',tau);
			show_var('part_B_MLVSS',MLVSS);
			show_var('part_B_BOD_loading',BOD_loading);
			show_var('part_B_bCOD_removed',bCOD_removed);
			show_var('part_B_R0',R0);
			show_var('part_B_SOTR',SOTR);
			show_var('part_B_air_flowrate',air_flowrate);
			show_var('part_B_alkalinity_to_be_added',alkalinity_to_be_added);
			show_var('part_B_BOD_eff',BOD_eff);
		//end results part B

		//21: part C SECONDARY CLARIFIER SIZING (for both bod removal and nitrification)
			var hydraulic_application_rate = parseFloat(document.querySelector('#parameter_hydraulic_application_rate').value); //assume 24 m3/m2·d (from table 8-34, page 890, range 16-28)
			var X_R                        = parseFloat(document.querySelector('#parameter_X_R').value); //assume 8000 g/m3
			var clarifiers                 = parseFloat(document.querySelector('#parameter_clarifiers').value); //assume 3
			var clarifier_diameter         = parseFloat(document.querySelector('#parameter_clarifier_diameter').value); //assume 20 m

			var R = MLSS_X_TSS/(X_R - MLSS_X_TSS); //calc return sludge recycle ratio
			var Area = Q/hydraulic_application_rate; //m2
			var area_per_clarifier = Area/clarifiers; //m2/clarifier
			var area_of_clarifiers = Math.PI*Math.pow(clarifier_diameter/2,2)*clarifiers; //m2
			var Solids_loading = (1+R)*Q*MLSS_X_TSS/1000/(area_of_clarifiers*24); //kg MLSS/m2·h
		//end part C

		//show results part C
			show_var('part_C_R_ratio',R);
			show_var('part_C_Area',Area);
			show_var('part_C_area_per_clarifier',area_per_clarifier);
			show_var('part_C_area_of_clarifiers',area_of_clarifiers);
			show_var('part_C_Solids_loading',Solids_loading);
		//end results part C
	};

	//util: show a result in the gui
	function show_var(id,value){
		document.querySelector("#"+id).innerHTML=value.toString().substring(0,7);
	}
</script>

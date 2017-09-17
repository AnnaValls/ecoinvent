<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Bio P removal</title>
	<script src="format.js"></script>
	<script src="utils.js"></script>
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
		[onclick]{
			cursor:pointer;
		}
		input {
			width:100px;
		}
		table[id^=results] span[id]{
			color:blue;
		}
		#btn_calculate{
			display:block;
			margin:auto;
			font-size:22px;
		}
		#results td[id]{
			color:blue;
		}
	</style>
</head><body onload="init()">

<!--title-->
<div>
	<h1>Metcalf &amp; Eddy, Wastewater Engineering, 5th ed, 2014</h1>
	<h2>Example 8-13 (p. 880)</h2>
	<h3 onclick=document.getElementById('statement').classList.toggle('invisible')>
		Effect of Nitrate on Enhanced Biological Phosphorus Removal
	</h3><hr>
</div>

<!--problem statement-->
<div id=statement>
	<p>
		An A2O biological nutrient-removal process receives wastewater with the characteristics shown
		below. The system is operated at an 8-d SRT. The RAS recycle ratio, R, is 0.5. The
		anaerobic contact detention time is 0.75 h. Estimate the effluent soluble phosphorus
		concentration and the percent phosphorus content of the waste sludge:
		<ul>
			<li>a) if the RAS contains 6.0 mg/L NO<sub>3</sub>-N
			<li>b) if a JHB EBPR process configuration is used and the RAS contains only 0.30 mg/L NO<sub>3</sub>-N.
		</ul>
	</p>
	<p>Design conditions and assumptions:</p>
	<ul>
		<li>1. Wastewater characteristics
			<table>
				<tr><td>Q                        <td class=number> 4000<td>m<sup>3</sup>/d
				<tr><td>Total BOD                <td class=number>  160<td>g/m<sup>3</sup>
				<tr><td>bCOD                     <td class=number>  250<td>g/m<sup>3</sup>
				<tr><td>rbCOD                    <td class=number>   75<td>g/m<sup>3</sup>
				<tr><td>Acetate                  <td class=number>   15<td>g/m<sup>3</sup>
				<tr><td>nbVSS                    <td class=number>   20<td>g/m<sup>3</sup>
				<tr><td>Inorganic inert matter   <td class=number>   10<td>g/m<sup>3</sup>
				<tr><td>TKN                      <td class=number>   35<td>g/m<sup>3</sup>
				<tr><td>P                        <td class=number>    6<td>g/m<sup>3</sup>
				<tr><td>T                        <td class=number>   12<td>g/m<sup>3</sup>
			</table>
		</li><li>2. rbCOD/NO<sub>3</sub>-ratio = 5.2 g/g
		<li>3. P content of other heterotrophic biomass = 0.015 g P/g X.
		<li>4. Nitrate oxidized (NO<sub>x</sub>) =  28 g/m<sup>3</sup>
		<li>5. Use coefficients from Table 8-14.
</div><hr>

<!--implementation gui-->
<div style=display:><h2>Implementation in Javascript</h2>
	<div>
		<button id=btn_calculate onclick=compute_exercise() style>Solve</button>
	</div>
	<ol class=flex>
		<li><div>Inputs</div>
			<table>
				<tr><td>Q <td><input type=number id=input_Q value=3800> m<sup>3</sup>/d
			</table>
		</li><li><div>Tabulated parameters</div>
			<table>
				<tr><td>Fe/P mole ratio <td class=number>3.3   <td>&empty;
			</table>
		</li><li><div>Results</div>
			<table id=results>
				<tr><td>Fe(III)<sub>dose</sub> <td id=result_Fe_III_dose>? <td>mg/L
			</table>
		</li>
	</ol>
</div>

<!--implementation-->
<script>
	function compute_exercise(){
		/*INPUTS*/
		var Q = 4000;
		var BOD = 160;
		var bCOD = 250;
		var rbCOD = 75;
		var Acetate = 15;
		var nbVSS = 20;
		var Inorganic_inert_matter = 10;
		var TKN = 35;
		var P = 6;
		var T = 12;

		/*PARAMETERS*/
		var SRT = 8;
		var RAS = 0.5;
		var tau_aerobic = 0.75;
		var NO3_e = 6;
		var rbCOD_NO3_ratio = 5.2;
		var P_content_het_X = 0.015;
		var NOx = 28;

		/*SOLUTION*/
			//1
			var Q_rbCOD = Q*rbCOD; //300,000 g/d
			var RQ_NO3_N = 0.50*Q*NO3_e; //12,000 g/d
			var rbCOD_used_by_NO3 = rbCOD_NO3_ratio * RQ_NO3_N; //62,400 g/d
			var rbCOD_available = Q_rbCOD - rbCOD_used_by_NO3; //237,600 g/d
			console.log("---Part A---");
			console.log("---1---");
			console.log(Q_rbCOD);
			console.log(RQ_NO3_N);
			console.log(rbCOD_used_by_NO3);
			console.log(rbCOD_available);

			//2
			var VFA_rbCOD_ratio = Acetate / rbCOD; //0.20 no unit
			var rbCOD_P_ratio = 15; //TODO implement fig 8-38 at "utils.js"
			var rbCOD_available_normalized = rbCOD_available/Q; //59.4 g/m3
			var P_removal_EBPR = rbCOD_available_normalized/rbCOD_P_ratio; //4 g/m3
			console.log("---2---");
			console.log(VFA_rbCOD_ratio);
			console.log(rbCOD_P_ratio);
			console.log(rbCOD_available_normalized);
			console.log(P_removal_EBPR);

			//3
			var YH = 0.45;
			var bH = 0.12;
			var fd = 0.15;
			var Yn = 0.15;
			var bn = 0.17;
			var bHT = bH*Math.pow(1.04,T-20); //0.088 1/d
			var bnT = bn*Math.pow(1.029,T-20); //0.135 1/d
			var P_X_bio = Q*YH*bCOD/(1+bHT*SRT) + fd*bHT*Q*YH*bCOD*SRT/(1+bHT*SRT) + Q*Yn*NOx/(1+bnT*SRT); //334,134 g/d
			//P_X_bio = 334134 TODO in metcalf is wrong
			var P_removal_synthesis = 0.015*P_X_bio; //5012 g/d
			var P_removal_synthesis_n = P_removal_synthesis/Q; //1.2 g/m3
			console.log("---3---");
			console.log(bHT);
			console.log(bnT);
			console.log(P_X_bio);
			console.log(P_removal_synthesis);
			console.log(P_removal_synthesis_n);

			//4
			var Effluent_P = P - P_removal_EBPR - P_removal_synthesis_n; //0.80 g/m3
			console.log("---4---");
			console.log(Effluent_P);

			//5
			var P_X_TSS = P_X_bio/0.85 + Q*nbVSS + Q*(Inorganic_inert_matter); //433,099 g/d
			var P_removal = (P - Effluent_P)*Q; //20,800 g/d
			var P_in_waste_sludge = 100*P_removal/P_X_TSS;
			console.log("---5---");
			console.log(P_X_TSS);
			console.log(P_removal);
			console.log(P_in_waste_sludge);

			//Part B
			//1
			console.log("---Part B---");
			console.log("---in progress---");
			/* TODO 
				continue here
				continue here
				continue here
				continue here
				continue here
			var rbCOD_used_by_NO3 = 0.3/0.6*62400=3120; //g/d
			var rbCOD_available = 300000 - 3120 = 296880; //g/d
			console.log("---1---");
			//2
			var rbCOD_P_ratio = 15;
			var rbCOD_available = 296880 / Q = 74.2; //g/m3
			var P_removal_EBPR = 74.2 / 15 = 4.9; //g/m3
			//3 ebpr+synthesis
			var P_removal = 4.9 + 1.2; //6.1 g/m3
			*/

			/*
				note: the computed value exceeds the influent P concentration. The ebpr process will be kinetically limited for P uptake in the aerobic zone at a low [P].
				depending on the aerobic tank desing the effluent P concentration could be in the range of 0.10 to 0.30 mg/L
			*/
		//end solution

		//show results
		//showResult('asdf',0);
		//end show results
	}
</script>

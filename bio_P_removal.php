<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Bio P removal</title>
	<script src="format.js"></script>
	<script src="utils.js"></script>
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
	<h1 onclick=document.getElementById('statement').classList.toggle('invisible')>
		Effect of Nitrate on Enhanced Biological Phosphorus Removal (EBPR)
	</h1>
	<h2>Example 8-13 (p. 880)</h2> <hr>
</div>

<!--problem statement-->
<div id=statement>
	<p>
		An A<sup>2</sup>O biological nutrient-removal process receives wastewater with the characteristics shown
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
				<tr><td>T                        <td class=number>   12<td>ºC
			</table>
		<li>2. rbCOD/NO<sub>3</sub>-N ratio = 5.2 g/g
		<li>3. P content of other heterotrophic biomass = 0.015 g P/g biomass.
		<li>4. Nitrate oxidized (NO<sub>x</sub>) = 28 g/m<sup>3</sup>
		<li>5. Use coefficients from Table 8-14.
	</ul>
	<hr>
</div>

<!--implementation gui-->
<div><h2>Implementation in Javascript</h2>
	<div>
		<button id=btn_calculate onclick=compute_exercise() style>Solve</button>
	</div>
	<ol class=flex>
		<li><div>Inputs</div>
			<table>
				<tr><td>Q                <td><input type=number id=input_Q       value=4000> m<sup>3</sup>/d
				<tr><td>BOD              <td><input type=number id=input_BOD     value=160> g/m<sup>3</sup>
				<tr><td>bCOD             <td><input type=number id=input_bCOD    value=250> g/m<sup>3</sup>
				<tr><td>rbCOD            <td><input type=number id=input_rbCOD   value=75> g/m<sup>3</sup>
				<tr><td>Acetate<br>(VFA) <td><input type=number id=input_Acetate value=15> g/m<sup>3</sup>
				<tr><td>nbVSS            <td><input type=number id=input_nbVSS   value=20> g/m<sup>3</sup>
				<tr><td>iTSS             <td><input type=number id=input_iTSS    value=10> g/m<sup>3</sup>
				<tr><td>TKN              <td><input type=number id=input_TKN     value=35> g/m<sup>3</sup>
				<tr><td>P                <td><input type=number id=input_P       value=6> g/m<sup>3</sup>
				<tr><td>T                <td><input type=number id=input_T       value=12> ºC
			</table>
		</li><li><div>Tabulated parameters</div>
			<table>
				<tr><td>SRT                  <td class=number>8     <td>d
				<tr><td>RAS                  <td class=number>0.5   <td>&empty;
				<tr><td>&tau; aerobic        <td class=number>0.75  <td>h
				<tr><td>rbCOD/NO<sub>3</sub> ratio <td class=number>5.2   <td>g/g
				<tr><td>P content het X      <td class=number>0.015 <td>g P/g X
				<tr><td>NO<sub>x</sub>       <td class=number>28    <td>g/m<sup>3</sup>
				<tr><td>N<sub>e</sub> case a <td class=number>6     <td>g/m<sup>3</sup>
				<tr><td>N<sub>e</sub> case b <td class=number>0.30  <td>g/m<sup>3</sup>
				<tr><td>Y<sub>H</sub>        <td class=number>0.45  <td>g VSS/g COD
				<tr><td>b<sub>H</sub>        <td class=number>0.12  <td>g/g·d
				<tr><td>f<sub>d</sub>        <td class=number>0.15  <td>g/g
				<tr><td>Y<sub>n</sub>        <td class=number>0.15  <td>g VSS/g NO<sub>x</sub>
				<tr><td>b<sub>n</sub>        <td class=number>0.17  <td>g/g·d
			</table>
		</li><li><div>Results</div>
			<table id=results>
				<tr><th colspan=3> Part A
				<tr><th colspan=3>1.
					<tr><td>Q(rbCOD)                    <td id=result_Q_rbCOD>?                    <td>g/d
					<tr><td>RQ(NO<sub>3</sub>-N)        <td id=result_RQ_NO3_N>?                   <td>g/d
					<tr><td>rbCOD used by NO<sub>3</sub><td id=result_rbCOD_used_by_NO3>?          <td>g/d
					<tr><td>rbCOD available             <td id=result_rbCOD_available>?            <td>g/d
					<tr><th colspan=3>2.
					<tr><td>VFA/rbCOD ratio             <td id=result_VFA_rbCOD_ratio>?            <td>&empty;
					<tr><td>rbCOD/P ratio               <td id=result_rbCOD_P_ratio>?              <td>&empty;
					<tr><td>rbCOD available normalized  <td id=result_rbCOD_available_normalized>? <td>g/m<sup>3</sup>
					<tr><td>P removal by EBPR           <td id=result_P_removal_EBPR>?             <td>g/m<sup>3</sup>
					<tr><th colspan=3>3.
					<tr><td>b<sub>H,T</sub>             <td id=result_bHT>?                        <td>d<sup>-1</sup>
					<tr><td>b<sub>n,T</sub>             <td id=result_bnT>?                        <td>d<sup>-1</sup>
					<tr><td>P<sub>X,bio</sub>           <td id=result_P_X_bio>?                    <td>g VSS/d
					<tr><td>P removal synthesis         <td id=result_P_removal_synthesis>?        <td>g/d
					<tr><td>P removal synthesis norm.   <td id=result_P_removal_synthesis_n>?      <td>g/m<sup>3</sup>
					<tr><th colspan=3>4.
					<tr><td>Effluent [P]                <td id=result_Effluent_P>?                 <td>g/m<sup>3</sup>
					<tr><th colspan=3>5.
					<tr><td>P<sub>X,TSS</sub>           <td id=result_P_X_TSS>?                    <td>g/m<sup>3</sup>
					<tr><td>P removal                   <td id=result_P_removal>?                  <td>g/d
					<tr><td>P in waste sludge           <td id=result_P_in_waste_sludge>?          <td>%
					<tr><th colspan=3>
					<tr><th colspan=3> Part B
					<tr><th colspan=3>1.
					<tr><td>rbCOD used by NO<sub>3</sub><td id=result_B1_rbCOD_used_by_NO3>?       <td>g/d
					<tr><td>rbCOD available             <td id=result_B1_rbCOD_available>?         <td>g/d
					<tr><th colspan=3>2.
					<tr><td>rbCOD available             <td id=result_B2_rbCOD_available>?         <td>g/d
					<tr><td>P removal by EBPR           <td id=result_B2_P_removal_EBPR>?          <td>g/m<sup>3</sup>
					<tr><th colspan=3>3.
					<tr><td>Total P removal (EBPR+synth)<td id=result_B3_P_removal>?               <td>g/d
			</table>
		</li>
	</ol>
</div>

<!--implementation-->
<script>
	function compute_exercise(){
		/*INPUTS*/
		var  Q       = getInput('input_Q');       //4000;
		var  BOD     = getInput('input_BOD');     //160;
		var  bCOD    = getInput('input_bCOD');    //250;
		var  rbCOD   = getInput('input_rbCOD');   //75;
		var  Acetate = getInput('input_Acetate'); //15;
		var  nbVSS   = getInput('input_nbVSS');   //20;
		var  iTSS    = getInput('input_iTSS');    //10;
		var  TKN     = getInput('input_TKN');     //35;
		var  P       = getInput('input_P');       //6;
		var  T       = getInput('input_T');       //12;

		/*PARAMETERS*/
		var SRT             = 8;
		var RAS             = 0.5;
		var tau_aerobic     = 0.75;
		var rbCOD_NO3_ratio = 5.2;
		var P_content_het_X = 0.015;
		var NOx             = 28;
		var YH              = 0.45;
		var bH              = 0.12;
		var fd              = 0.15;
		var Yn              = 0.15;
		var bn              = 0.17;
		var NO3_eff_a       = 6; //case a
		var NO3_eff_b       = 0.30; //case b

		/*SOLUTION*/
			//1
			var Q_rbCOD = Q*rbCOD; //300,000 g/d
			var RQ_NO3_N = 0.50*Q*NO3_eff_a; //12,000 g/d
			var rbCOD_used_by_NO3 = rbCOD_NO3_ratio * RQ_NO3_N; //62,400 g/d
			var rbCOD_available = Q_rbCOD - rbCOD_used_by_NO3; //237,600 g/d
			console.log("---Part A---");
			console.log("---1---");
			showResult('result_Q_rbCOD',Q_rbCOD);
			showResult('result_RQ_NO3_N',RQ_NO3_N);
			showResult('result_rbCOD_used_by_NO3',rbCOD_used_by_NO3);
			showResult('result_rbCOD_available',rbCOD_available);

			//2
			var VFA_rbCOD_ratio = Acetate / rbCOD; //0.20 no unit
			var rbCOD_P_ratio = get_rbCOD_P_ratio(VFA_rbCOD_ratio); //implemented fig 8-38 at "utils.js"
			var rbCOD_available_normalized = rbCOD_available/Q; //59.4 g/m3
			var P_removal_EBPR = rbCOD_available_normalized/rbCOD_P_ratio; //4 g/m3
			console.log("---2---");
			showResult('result_VFA_rbCOD_ratio',VFA_rbCOD_ratio);
			showResult('result_rbCOD_P_ratio',rbCOD_P_ratio);
			showResult('result_rbCOD_available_normalized',rbCOD_available_normalized);
			showResult('result_P_removal_EBPR',P_removal_EBPR);

			//3
			var bHT = bH*Math.pow(1.04,T-20); //0.088 1/d
			var bnT = bn*Math.pow(1.029,T-20); //0.135 1/d
			var P_X_bio = Q*YH*bCOD/(1+bHT*SRT) + fd*bHT*Q*YH*bCOD*SRT/(1+bHT*SRT) + Q*Yn*NOx/(1+bnT*SRT); //334,134 g/d
			//P_X_bio = 334134; //TODO in metcalf is wrong
			var P_removal_synthesis = 0.015*P_X_bio; //5012 g/d
			var P_removal_synthesis_n = P_removal_synthesis/Q; //1.2 g/m3
			console.log("---3---");
			showResult('result_bHT',bHT);
			showResult('result_bnT',bnT);
			showResult('result_P_X_bio',P_X_bio);
			showResult('result_P_removal_synthesis',P_removal_synthesis);
			showResult('result_P_removal_synthesis_n',P_removal_synthesis_n);

			//4
			var Effluent_P = P - P_removal_EBPR - P_removal_synthesis_n; //0.80 g/m3
			console.log("---4---");
			showResult('result_Effluent_P',Effluent_P);

			//5
			var P_X_TSS = P_X_bio/0.85 + Q*nbVSS + Q*(iTSS); //433,099 g/d
			//P_X_TSS = 433099; //TODO in metcalf is wrong
			var P_removal = (P - Effluent_P)*Q; //20,800 g/d
			var P_in_waste_sludge = 100*P_removal/P_X_TSS; //4.8 %
			console.log("---5---");
			showResult('result_P_X_TSS',P_X_TSS);
			showResult('result_P_removal',P_removal);
			showResult('result_P_in_waste_sludge',P_in_waste_sludge);

			//Part B
			//1
			var rbCOD_used_by_NO3 = (NO3_eff_b/NO3_eff_a)*rbCOD_used_by_NO3; //3120 g/d
			var rbCOD_available = Q_rbCOD - rbCOD_used_by_NO3; //296880 g/d
			console.log("---Part B---");
			console.log("---1---");
			showResult('result_B1_rbCOD_used_by_NO3',rbCOD_used_by_NO3);
			showResult('result_B1_rbCOD_available',rbCOD_available);
			//2
			var rbCOD_available = rbCOD_available / Q; //74.2 g/m3
			var P_removal_EBPR = rbCOD_available / rbCOD_P_ratio ; //4.9 g/m3
			console.log("---2---");
			showResult('result_B2_rbCOD_available',rbCOD_available);
			showResult('result_B2_P_removal_EBPR',P_removal_EBPR);
			//3  (ebpr + synthesis)
			var P_removal = P_removal_EBPR + P_removal_synthesis_n; //6.1 g/m3
			console.log("---3---");
			showResult('result_B3_P_removal',P_removal);
		//end solution
	}
</script>

<p>
	<b>Note</b>: the computed value exceeds the influent P concentration. The EBPR process will be kinetically limited for P uptake in the aerobic zone at a low [P].
	depending on the aerobic tank desing the effluent P concentration could be in the range of 0.10 to 0.30 mg/L.
</p>

<hr><div>
	I've found 2 numeric discrepancies in Metcalf and Eddy, regarding to:
	<ul>
		<li>P<sub>X,bio</sub> (334,134 g VSS/d)
		<li>P<sub>X,TSS</sub> (433,099 g/d)
	</ul>
</div>

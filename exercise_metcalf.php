<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Metcalf exercise 8-2 (p. 707)</title>
	<style>
		body{
			max-width:60em;
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
	</style>
	<style>
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
			width:95%;
			margin:auto;
		}
		[onclick]{
			cursor:pointer;
		}
		input {
			width:100px;
		}
	</style>
	<script>
		function init(){
			//compute_exercise();
		}
	</script>
</head><body onload="init()">

<h1>Metcalf exercise 8-2 (p. 707) (fragment) implementation example</h1>

<!--Enunciat-->
<h2 onclick=document.getElementById('enunciat').classList.toggle('invisible')>
	Complete-Mix Activated sludge process design for BOD Removal
</h2>

<div id=enunciat>
	<div>
		Design a complete-mix activated-sludge (CMAS) process to treat 22464 m3/d of primary effluent 
		to (a) meet a BODe concentration less than 30 g/m3 and (b) accomplish BOD removal and nitrification
		with an effluent NH4-N concentration of 0.50 g/m3 and BODe and TSSe &lt; 15 g/m3. Compare the two
		design conditions in a summary table. The aeration basin mixed-liquor temperature is 12ºC.
		<p>
			The following wastewater characteristics and design conditions apply:
		</p>
		<table>
			<tr><th>Constituent<th>Concentration (g/m3 = mg/L)
			<tr><td>BOD            <td class=number> 140
			<tr><td>sBOD           <td class=number> 70
			<tr><td>COD            <td class=number> 300
			<tr><td>sCOD           <td class=number> 132
			<tr><td>rbCOD          <td class=number> 80
			<tr><td>TSS            <td class=number> 70
			<tr><td>VSS            <td class=number> 60
			<tr><td>TKN            <td class=number> 35
			<tr><td>NH4-N          <td class=number> 25
			<tr><td>TP             <td class=number> 6
			<tr><td>Alkalinity     <td class=number> 140 as CaCO3
			<tr><td>bCOD/BOD ratio <td class=number> 1.6
		</table>
		Design conditions and assumptions:
		<ol>
			<li>Fine bubble ceramic diffusers with an aeration clean water O<sub>2</sub> transfer efficiency = 35%
			<li>Liquid depth for the aeration basin = 4.9 m
			<li>The pooint of air release for the ceramic diffusers is 0.5 m above the tank bottom 
			<li>DO in aeration basin = 2.0 g/m3
			<li>Site elevation is 500 m (pressure = 95.6 kPa)
			<li>Aeration &alpha; factor = 0.50 for BOD removal only and 0.65 for nitrification; &beta; = 0.95 for both conditions,
			and diffuser fouling factor <i>F</i> = 0.90
			<li>Use kinetic coefficients given in Tables 8-10 and 8-11
			<li>SRT for BOD removal = 5 d
			<li>Design MLSS X<sub>TSS</sub> concentration = 3000 g/m3; values of 2000 to 3000 g/m3 can be considered
			<li>TKN peak/average factor of safety FS = 1.5
		</ol>
	</div>

	<hr>

	<!--Solution Part A, BOD Removal without Nitrification-->
	<h2>Solution Part A, BOD Removal without Nitrification</h2>
	<ol>
		<li>Develop the wastewater characteristics needed for design
			<ol style=list-style-type:lower-alpha>
				<li>
					Find bCOD
					<code>
						bCOD = 1.6(BOD) = 1.6(140 g/m3) = 224 g/m3
					</code>
				</li>
				<li>
					Find nbCOD
					<code>
						nbCOD = COD - bCOD = (300 - 224) g/m3 = 76 g/m3
					</code>
				</li>
				<li>
					Find effluent sCODe (assumed to be nonbiodegradable).
					<code>
						sCODe = sCOD - 1.6·sBOD
						= (132 g/m3) - (1.6)(70 g/m3) = 20 g/m3
					</code>
				</li>
				<li>
					Find nbVSS
					<code>
						nbVSS = (1 - bpCOD/pCOD)·VSS
						<br>
						bpCOD/pCOD = (bCOD/BOD)(BOD-sBOD)/(COD-sCOD))
						<br>
						bpCOD/pCOD = 1.6(BOD-sBOD)/(COD-sCOD)) = 1.6((140-70) g/m3)/(300-132) g/m3) = 0.67
						<br>
						nbVSS = (1-0.67)(60 g VSS/m3) = 20 g/m3
					</code>
				</li>
				<li>
					Find iTSS
					<code>
						iTSS = TSS - VSS = (70 - 60) g/m3 = 10 g/m3
					</code>
				</li>
			</ol>
		</li>
		<li>Design suspended growth system for BOD removal only
			<ol style=list-style-type:lower-alpha>
				<li>
					Determine biomass production using parts A and B of Eq (8-15)
					<code>
						P<sub>X,VSS</sub> = QY(S0-S)/(1+(k<sub>d</sub>·SRT)) + (fd·k<sub>d</sub>·QY(S0-S)·SRT)/(1+k<sub>d</sub>·SRT)
					</code>
					Define input data for above equation
					<code>
						Q = 22464 m3/d<br>
						Y = 0.40 g VSS/g bCOD (table 8-10)<br>
						S0 = 224 g bCOD/m3 (see step 1)
					</code>
					Determine S from Eq (7-40) in table 8-5. Note Yk = &mu;<sub>m</sub>
					<code>
						S = Ks[1+k<sub>d</sub>·SRT]/[SRT·(&mu;<sub>m</sub>-k<sub>d</sub>)-1]
					</code>
					Use &mu;<sub>m</sub> and k<sub>d</sub> from table 8-10.
					<code>
						Ks = 20 g/m3
						<br>
						&mu;<sub>m,T</sub> = &mu;<sub>m</sub>·&theta;<sup>T-20</sup>
						<br>
						&mu;<sub>m,12ºC</sub> = (6 g/g·d)·(1.07)<sup>12-20</sup> = 3.5 g/g·d
						<br>
						k<sub>d,T</sub> = k<sub>20</sub>&theta;<sup>T-20</sup>
						<br>
						k<sub>d,12ºC</sub> = (0.12 g/g·d)(1.04)<sup>12-20</sup> = 0.088 g/g·d
						<br>
						S = (20 g/m3)[1+(0.088 g/g·d)(5 d)]/[(5 d)[(3.5-0.088) g/g·d - 1]] = 1.8 g bCOD/m3
					</code>
				</li>
				<li>
					Substitute the above values in the expression given above and solve for P<sub>X,VSS</sub>
					<code>
						P<sub>X,VSS</sub> = (22464 m3)(0.40 g/g)[(224-1.8) g/m3]/(1+(0.088 g/g·d)(5 d)))<br>
						+((0.15g/g)·(0.088 g/g·d)·(22464 m3)(0.40 g/g)[(224-1.8) g/m3]·(5 d))/[1+(0.088 g/g·d)(5 d)]
						<br>
						P<sub>X,VSS</sub> = 1479 kg VSS/d
					</code>
				</li>
			</ol>
		</li>
	</ol>
</div>

<hr>

<!--IMPLEMENTATION-->
<h2>Implementation in Javascript</h2>
<ol class=flex>
	<li>
		Inputs
		<table>
			<tr><td>BOD            <td><input class=number id=BOD value=140> g/m3
			<tr><td>sBOD           <td><input class=number id=sBOD value=70> g/m3
			<tr><td>COD	           <td><input class=number id=COD value=300> g/m3
			<tr><td>sCOD           <td><input class=number id=sCOD value=132> g/m3
			<tr><td>rbCOD          <td><input class=number id=rbCOD value=80> g/m3
			<tr><td>TSS	           <td><input class=number id=TSS value=70> g/m3
			<tr><td>VSS	           <td><input class=number id=VSS value=60> g/m3
			<tr><td>bCOD/BOD ratio <td><input class=number id=bCOD_BOD_ratio value=1.6> -
			<tr><td>Q              <td><input class=number id=Q value=22464> m3/d
			<tr><td>T              <td><input class=number id=T value=12> ºC
		</table>
		<div>
			<button id=btn_calculate onclick=compute_exercise()>Solve exercise</button>
		</div>
	</li>
	<li>
		Parameters
		<table>
			<tr><td>SRT   <td class=number>5    <td>d
			<tr><td>Y     <td class=number>0.40 <td>g VSS / g bCOD
			<tr><td>Ks    <td class=number>20   <td>g/m3
			<tr><td>&mu;<sub>m</sub> <td class=number>6    <td>g/g·d
			<tr><td>k<sub>d</sub>    <td class=number>0.12 <td>g/g·d
			<tr><td>fd    <td class=number>0.15 <td>g/g
		</table>
	</li>
	<li>
		Calculated variables
		<table id=calculated_variables>
			<tr><td>bCOD               <td class=number><span id=bCOD>0</span><td>g/m3
			<tr><td>nbCOD              <td class=number><span id=nbCOD>0</span><td>g/m3
			<tr><td>sCODe              <td class=number><span id=sCODe>0</span><td>g/m3
			<tr><td>nbVSS              <td class=number><span id=nbVSS>0</span><td>g/m3
			<tr><td>iTSS               <td class=number><span id=iTSS>0</span><td>g/m3
			<tr><td>S                  <td class=number><span id=S>0</span><td>g/m3
			<tr><td>&mu;<sub>m,T</sub> <td class=number><span id=mu_mT>0</span><td>g/g·d
			<tr><td>k<sub>d,T</sub>    <td class=number><span id=kdT>0</span><td>g/g·d
			<tr><td>P<sub>X,VSS</sub>  <td class=number><span id=P_XVSS_kg>0</span><td>kg VSS/d
		</table>
	</li>
</ol>

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
		var bCOD_BOD_ratio = parseFloat(document.querySelector('#bCOD_BOD_ratio').value);
		var Q              = parseFloat(document.querySelector('#Q').value);
		var T              = parseFloat(document.querySelector('#T').value);

		//parametres
		var SRT  = 5;
		var Y    = 0.40;
		var Ks   = 20;
		var mu_m = 6;
		var kd   = 0.12;
		var fd   = 0.15;

		//compute values
		var bCOD = bCOD_BOD_ratio * BOD;
		var nbCOD = COD - bCOD;
		var sCODe = sCOD - bCOD_BOD_ratio * sBOD;
		var bpCOD_pCOD_ratio = (bCOD/BOD) * (BOD-sBOD) / (COD-sCOD);
		var nbVSS = (1 - bpCOD_pCOD_ratio) * VSS;
		var iTSS = TSS - VSS;
		var mu_mT = mu_m * Math.pow(1.07, T - 20);
		var kdT = kd * Math.pow(1.04, T - 20); 
		var S0 = bCOD;
		var S = Ks * (1 + kdT * SRT) / (SRT * (mu_mT - kdT) - 1);
		var P_XVSS = Q * Y * (S0 - S) / (1 + kdT * SRT) + (fd * kdT * Q * Y * (S0 - S) * SRT) / (1 + kdT * SRT);
		var P_XVSS_kg = P_XVSS/1000;

		//show results inner function
		function show_var(id,value){
			//console.log(id+": "+value);
			document.getElementById(id).innerHTML=value.toString().substring(0,8);
		}
		show_var('bCOD',bCOD);     
		show_var('nbCOD',nbCOD);    
		show_var('sCODe',sCODe);    
		show_var('nbVSS',nbVSS);    
		show_var('iTSS',iTSS);    
		show_var('mu_mT',mu_mT);    
		show_var('kdT',kdT);      
		show_var('S',S);        
		show_var('P_XVSS_kg',P_XVSS_kg);
	};
</script>

<slide></slide>

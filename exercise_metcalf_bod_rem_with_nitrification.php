<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Example 8-3 (p. 756)</title>
	<style>
		body{
			max-width:70em;
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

<h1>Metcalf and Eddy, Wastewater Engineering, 5th ed, 2014</h1>
<h2>Exercise 8-3 (p. 756) implementation</h2>

<!--Enunciat-->
<h3 onclick=document.getElementById('enunciat').classList.toggle('invisible')>
	Complete-Mix Activated Sludge for BOD Removal with Nitrification
</h3>

<div id=enunciat>
	<div>
		Prepare a process design for a complete-mix activated sludge (CMAS) 
		system to treat 22,700 m3/d
		of primary effluent (including recycle flows) to (a) meet a BOD<sub>e</sub> concentration less than
		30 g/m3 and (b) accomplish BOD removal and nitrification with an effluent NH4-N concentration of 0.50 g/m3 and BOD<sub>e</sub>
		and TSS<sub>e</sub> &le; 15 g/m3. Compare the two design conditions in a summary table. The aeration
		basin mixed liquor temperature is 12ºC.

		<p>The following wastewater characteristics and design conditions apply:</p>
		<p>Wastewater characteristics</p>

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
		<p>
			<b>Note:</b> g/m<sup>3</sup> = mg/L
		</p>
		Design conditions and assumptions:
		<ol>
			<li>Fine bubble ceramic diffusers with an aeration clean water O<sub>2</sub> transfer efficiency = 35%
			<li>Liquid depth for the aeration basin = 4.9 m
			<li>The point of air release for the ceramic diffusers is 0.5 m above the tank bottom 
			<li>DO in aeration basin = 2.0 g/m3
			<li>Site elevation is 500 m (pressure = 95.6 kPa)
			<li>Aeration &alpha; factor = 0.50 for BOD removal only and 0.65 for nitrification; &beta; = 0.95 for both conditions,
			and diffuser fouling factor <i>F</i> = 0.90
			<li>Use kinetic coefficients given in Tables 8-14
			<li>SRT for BOD removal = 5 d
			<li>Design MLSS X<sub>TSS</sub> concentration = 3000 g/m3; values of 2000 to 3000 g/m3 can be considered
			<li>Peak to average TKN loading rate ratio = 1.5
		</ol>
	</div>

	<hr>

	<!--Solution Part A, BOD Removal-->
	<h2>Solution Part A, BOD Removal without nitrification</h2>
	<ol>
		<li>Develop the wastewater characteristics needed for design
			<ol style=list-style-type:lower-alpha>
				<li>
					Find bCOD.
					<code>
						bCOD = 1.6(BOD) = 1.6(140 g/m3) = 224 g/m3
					</code>
				</li>
				<li>
					Find nbCOD using Eq. (8-12).
					<code>
						nbCOD = COD - bCOD = (300 - 224) g/m3 = 76 g/m3
					</code>
				</li>
				<li>
					Find effluent nonbiodegradable sCOD (nbsCOD<sub>e</sub>).
					<code>
						nbsCOD<sub>e</sub> = sCOD - 1.6·sBOD
						= (132 g/m3) - (1.6)(70 g/m3) = 20 g/m3
					</code>
				</li>
				<li>
					Find nbVSS using Eq. (8-7, 8-8, and 8-9).
					<code>
						nbpCOD = TCOD - bCOD - nbsCODe<br>
						nbpCOD = (300 - 224 -  20) g/m3 = 56 g/m3<br>
						VSS<sub>COD</sub> = (TCOD-sCOD)/VSS<br>
						VSS<sub>COD</sub> = (300-132)/60= 2.8 gCOD / gVSS<br>
						nbVSS = nbpCOD / VSS<sub>COD</sub><br>
						nbVSS = 56 / 2.8 = 20.0 g nbVSS/m3
					</code>
				</li>
				<li>
					Find the iTSS.
					<code>
						iTSS = TSS - VSS = (70 - 60) g/m3 = 10 g/m3
					</code>
				</li>
			</ol>
		</li>
		<li>Design suspended growth system for BOD removal only
			<ol style=list-style-type:lower-alpha>
				<li>
					Determine biomass production using Eq (8-20) in Table 8-10.
					<code>
						P<sub>X,Bio</sub> = Q·Y<sub>H</sub>(S0-S)/(1+(b<sub>H</sub>·SRT)) + (fd·b<sub>H</sub>·Q·Y<sub>H</sub>·(S0-S)·SRT)/(1+b<sub>H</sub>·SRT)
					</code>
					Define input data for above equation.
					<code>
						Q = 22,700 m3/d<br>
						S0 = 224 g bCOD/m3 (see step 1)
					</code>
					From table 8-14
					<code>
						Y<sub>H</sub> = 0.45 g VSS/g bCOD<br>
						b<sub>H,20</sub> = 0.12 g/g·d<br>
						fd = 0.15
					</code>

					Determine S from Eq (7-46) in table 8-10. Note Yk = &mu;<sub>max</sub>
					<code>
						S = Ks[1+b<sub>H</sub>·SRT]/[SRT·(&mu;<sub>max</sub>-b<sub>H</sub>)-1]
					</code>

					Use &mu;<sub>max</sub>, b, and K at 20ºC from table 8-14<br>
					<code>
						&mu;m,T = &mu;m&theta;<sup>T-20</sup> from Eq. (1-44) in Table 8-1<br>
						&mu;m,12ºC = 6.0 g/g·d (1.07)<sup>12-20</sup>=3.5 g/g·d<br>
						b<sub>H,T</sub> = b<sub>H,20</sub>&theta;<sup>T-20</sup> from Eq. (1-44)<br>
						b<sub>H,12ºC</sub> = (0.12 g/g·d)(1.04)<sup>12-20</sup>=0.088 g/g·d<br>
						S = (80 g/m3)[1+(0.088 g/g·d)(5 d)]/[(5 d)[(3.5-0.088) g/g·d - 1]] = 0.7 g bCOD/m3
					</code>
				</li>
				<li>
					Substitute the above values in the expression given above and solve for P<sub>X,VSS</sub>
					<code>
						P<sub>X,Bio</sub> = (22,700 m3)(0.45 g/g)[(224-0.7) g/m3]/(1+(0.088 g/g·d)(5 d)))<br>
						+((0.15 g/g)·(0.088 g/g·d)·(22,700 m3)(0.45 g/g)[(224-0.7) g/m3]·(5 d))/[1+(0.088 g/g·d)(5 d)]
						<br>
						P<sub>X,Bio</sub> = (1584.0 + 104.5) kg/d = 1688.5 kg VSS/d
					</code>
				</li>
			</ol>
		</li>
		<li>
			Determine the mass in terms of VSS and TSS in the aeration basin. 
			The mass of VSS and TSS can be determined using Eqs. (8-20), (8-21) and (7-57) given in Table 8-10.
			<code>
				Mass = Px·SRT
			</code>
			<ol style=list-style-type:lower-alpha>
				<li>
					Determine PX,VSS and PX,TSS using Eqs. (8-20) including parts A, B, and D. Part C=0 because there is no nitrification.
					<code>
						PX,VSS = PX,bio + Q·nbVSS<br>
						PX,VSS = 1688.5 kg/d + Q·nbVSS<br>
						PX,VSS = 1688.5 kg/d + (22,700 m3/d)·(20 g/m3)<br>
						PX,VSS = 2142.5 kg/d
					</code>
					From Eq. (8-21), PX,TSS is
					<code>
						PX,TSS = [(1688.5 kg/d)/0.85] + (454.0 kg/d) + Q(TSSo-VSSo)<br>
						PX,TSS = 1986.5 kg/d + 454.0 kg/d + 22,700 m3/d)(10 g/m3)<br>
						PX,TSS = 2667.5 kg/d
					</code>
				</li>
				<li style=background:orange>
					page 759 starts here (TO DO)
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
		<div>Inputs</div>
		<table>
			<tr><td>BOD             <td><input type=number class=number id=BOD value=140> g/m3
			<tr><td>sBOD            <td><input type=number class=number id=sBOD value=70> g/m3
			<tr><td>COD	            <td><input type=number class=number id=COD value=300> g/m3
			<tr><td>sCOD            <td><input type=number class=number id=sCOD value=132> g/m3
			<tr><td>rbCOD           <td><input type=number class=number id=rbCOD value=80> g/m3
			<tr><td>TSS	            <td><input type=number class=number id=TSS value=70> g/m3
			<tr><td>VSS	            <td><input type=number class=number id=VSS value=60> g/m3
			<tr><td>TKN             <td><input type=number class=number id=TKN value=35> g/m3
			<tr><td>NH<sub>4</sub>-N<td><input type=number class=number id=NH4_N value=25> g/m3
			<tr><td>TP              <td><input type=number class=number id=TP value=6> g/m3
			<tr><td>Alkalinity      <td><input type=number class=number id=Alkalinity value=140> as CaCO<sub>3</sub>
			<tr><td>bCOD/BOD ratio  <td><input type=number class=number id=bCOD_BOD_ratio value=1.6> -
			<tr><td>Q               <td><input type=number class=number id=Q value=22700> m3/d
			<tr><td>T               <td><input type=number class=number id=T value=12> ºC
		</table>
	</li>
	<li>
		<div>Parameters</div>
		<table>
			<tr><td>SRT   <td class=number>5    <td>d
			<tr><td>Y     <td class=number>0.45 <td>g VSS / g bCOD
			<tr><td>Ks    <td class=number>8   <td>g/m3
			<tr><td>&mu;<sub>m</sub> <td class=number>6    <td>g/g·d
			<tr><td>k<sub>d</sub>    <td class=number>0.12 <td>g/g·d
			<tr><td>fd    <td class=number>0.15 <td>g/g
			<tr><td>NOx   <td class=number>0    <td>?
			<tr><td>zb (elevation)<td class=number>500<td>m 
			<tr><td>Pa <td class=number>10.33<td>m
		</table>
	</li>
	<li>
		<div>Calculated variables</div>
		<div>BOD removal without nitrification</div>
		<table id=results_part_A>
			<tr><td>bCOD                <td class=number><span id=bCOD>?</span><td>g/m3
			<tr><td>nbCOD               <td class=number><span id=nbCOD>?</span><td>g/m3
			<tr><td>nbsCODe             <td class=number><span id=nbsCODe>?</span><td>g/m3
			<tr><td>nbVSS               <td class=number><span id=nbVSS>?</span><td>g/m3
			<tr><td>iTSS                <td class=number><span id=iTSS>?</span><td>g/m3
			<tr><td>P<sub>X,Bio</sub>   <td class=number><span id=P_X_Bio>?</span><td>kg VSS/d
			<tr><td>P<sub>X,VSS</sub>   <td class=number><span id=P_X_VSS>?</span><td>kg/d
			<tr><td>P<sub>X,TSS</sub>   <td class=number><span id=P_X_TSS>?</span><td>kg/d
			<tr><td>X<sub>VSS</sub>V    <td class=number><span id=X_VSS_V>?</span><td>kg
			<tr><td>X<sub>TSS</sub>V    <td class=number><span id=X_TSS_V>?</span><td>kg
			<tr><td>V                   <td class=number><span id=V>?</span><td>m<sup>3</sup>
			<tr><td>&tau;               <td class=number><span id=tau>?</span><td>h
			<tr><td>MLVSS               <td class=number><span id=MLVSS>?</span><td>g/m<sup>3</sup>
			<tr><td>BOD loading         <td class=number><span id=BOD_loading>?</span><td>kg/m<sup>3</sup>·d
			<tr><td>bCOD removed        <td class=number><span id=bCOD_removed>?</span><td>kg/d
			<tr><td>O<sub>2</sub> demand<td class=number><span id=R0>?  </span><td>kgO<sub>2</sub>/h
			<tr><td>SOTR                <td class=number><span id=SOTR>?</span><td>kg/h
			<tr><td>Air flowrate        <td class=number><span id=air_flowrate>?</span><td>m<sup>3</sup>/min
		</table>
		<div>BOD removal and nitrification</div>
		<table id=results_part_B>
			<tr><td>TO DO
		</table>
		<div>
			<button id=btn_calculate onclick=compute_exercise()>Solve exercise</button>
		</div>
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
			var TKN            = parseFloat(document.querySelector('#TKN').value);
			var NH4_N          = parseFloat(document.querySelector('#NH4_N').value);
			var TP             = parseFloat(document.querySelector('#TP').value);
			var Alkalinity     = parseFloat(document.querySelector('#Alkalinity').value);
			var bCOD_BOD_ratio = parseFloat(document.querySelector('#bCOD_BOD_ratio').value);
			var Q              = parseFloat(document.querySelector('#Q').value);
			var T              = parseFloat(document.querySelector('#T').value);
		//end inputs

		//parametres
			var SRT = 5;
			var Y = 0.45;
			var Ks = 8;
			var mu_m = 6;
			var bH = 0.12;
			var fd = 0.15;
			var MLSS_X_TSS = 3000;
			var NOx = 0;
			var zb=500;
			var Pa = 10.33; //m
			var R = 8314; //kg*m2/s2*kmol*K (ideal gases constant)
			var g = 9.81;//m/s2 (gravity)
			var M = 28.97;//g/mol (air molecular weight)
			var alpha=0.50;//8.b
			var beta=0.95;//8.b
			var F=0.9;//8.b
			var C_s_20 = 9.09;//8.b
			var C_12 = 10.777; //tabulated value (implement table will be needed)
			var de=0.40;//8.b
			var Df=4.4;// 4.9m-0.5m, from design conditions and assumptions
			var C_L=2.0;//DO in aeration basin (mg/L)
			var SF =1.5 //peak to average tkn load (design assumptions)
		//end params

		//compute values
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
			var P_XBio = (Q * Y * (S0 - S) / (1 + bHT * SRT) + (fd * bHT * Q * Y * (S0 - S) * SRT) / (1 + bHT * SRT))/1000;
			//3
			var P_XVSS = P_XBio + Q*nbVSS/1000;
			var P_XTSS = P_XBio/0.85 + Q*nbVSS/1000 + Q*(TSS-VSS)/1000;
			//4
			var X_VSS_V = P_XVSS*SRT;
			var X_TSS_V = P_XTSS*SRT;
			var V = X_TSS_V*1000/MLSS_X_TSS
			var tau = V*24/Q
			var MLVSS = X_VSS_V/X_TSS_V * MLSS_X_TSS
			//5
			var FM = Q*BOD/MLVSS/V
			var BOD_loading = Q*BOD/V/1000;
			//6
			var bCOD_removed = Q*(S0-S)/1000;
			var Y_obs_TSS = P_XTSS/bCOD_removed*bCOD_BOD_ratio;
			var Y_obs_VSS = P_XTSS/bCOD_removed*(X_VSS_V/X_TSS_V)*bCOD_BOD_ratio;
			//7
			var R0 = (Q*(S0-S)/1000 -1.42*P_XBio)/24 + 4.57*Q*NOx; // - in the book NOx is not well explained (is = 0)
			//8
			var Pb = Pa*Math.exp(-g*M*(zb-0)/(R*(273.15+T)));
			var C_inf_20 = C_s_20 * (1+de*Df/Pa)
			var OTRf = R0;
			var SOTR = (OTRf/alpha/F)*(C_inf_20/(beta*C_12/C_s_20*Pb/Pa*C_inf_20-C_L))*(Math.pow(1.024,20-T));
			var air_flowrate = SOTR/(0.35*60*0.270);
		//end part A

		//show results for part A
		show_var('bCOD',bCOD);     
		show_var('bCOD',bCOD);
		show_var('nbCOD',nbCOD);
		show_var('nbsCODe',nbsCODe);
		show_var('nbVSS',nbVSS);
		show_var('iTSS',iTSS);
		show_var('P_X_Bio',P_X_Bio);
		show_var('P_X_VSS',P_X_VSS);
		show_var('P_X_TSS',P_X_TSS);
		show_var('X_VSS_V',X_VSS_V);
		show_var('X_TSS_V',X_TSS_V);
		show_var('V',V);
		show_var('tau',tau);
		show_var('MLVSS',MLVSS);
		show_var('BOD_loading',BOD_loading);
		show_var('bCOD_removed',bCOD_removed);
		show_var('R0',R0);
		show_var('SOTR',SOTR);
		show_var('air_flowrate',air_flowrate);

		//9: NITRIFICATION STARTS HERE
			var mu_max_AOB = 0.90 //table 8-14 at 20ºC
			var b_AOB = 0.17 // table 8-14 at 20ºC
			var K_NH4 = 0.50 //table 8-14 at 20ºC
			var K_o_AOB = 0.50 //table 8-14 at 20ºC
			var mu_max_AOB_T = mu_max_AOB * Math.pow(1.072,T-20);
			var b_AOB_T = b_AOB* Math.pow(1.029,T-20);
			var S_NH4 = 0.50 //?not explained where this comes from TODO
			var mu_AOB = mu_max_AOB_T * (S_NH4/(S_NH4+K_NH4)) * (C_L/(C_L+K_o_AOB)) - b_AOB_T;
			//10
			var SRT_theoretical = 1/mu_AOB;
			var SRT_design = SF*SRT_theoretical;
			//11
			var S = Ks * (1+bHT*SRT_design) / (SRT_design*(mu_mT-bHT)-1);
			var Yn = 0.15; //Table 8-14
			var NOx = 0.80 * TKN; //aproximation for nitrate, prior to iteration (80% of TKN)
			//biomass first approximation with first NOx concentration aproximation
			var P_X_bio_VSS = Q*Y*(S0-S)/(1+bHT*SRT_design) + fd*bHT*Q*Y*(S0-S)*SRT_design/(1+bHT*SRT_design) + Q*Yn*NOx/(1+b_AOB_T*SRT_design);
			P_X_bio_VSS/=1000;
			//12 iteration for finding more accurate value of NOx (nitrogen oxidized to nitrate)
			var Ne = 0.50; //not explained TODO
			var NOx = TKN - Ne - 0.12*P_X_bio_VSS/Q*1000;
			//recalc PXBioVSS with accurate NOx TODO iteration
			var P_X_bio_VSS = Q*Y*(S0-S)/(1+bHT*SRT_design) + fd*bHT*Q*Y*(S0-S)*SRT_design/(1+bHT*SRT_design) + Q*Yn*NOx/(1+b_AOB_T*SRT_design);
			P_X_bio_VSS/=1000;
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
			var P_X_bio_VSS = Q*Y*(S0-S)/(1+bHT*SRT_design) + fd*bHT*Q*Y*(S0-S)*SRT_design/(1+bHT*SRT_design);
			P_X_bio_VSS /= 1000;
			var R0 = Q*(S0-S)/1000 -1.42*P_X_bio_VSS + 4.57*Q*NOx/1000;
			R0 /= 24;
			//18
			var OTRf = R0;
			var alpha=0.65;
			var beta=0.95;
			var SOTR = (OTRf/alpha/F)*(C_inf_20/(beta*C_12/C_s_20*Pb/Pa*C_inf_20-C_L))*(Math.pow(1.024,20-T));
			var air_flowrate = SOTR/(0.35*60*0.270);
			//19 alkalinity TODO (not clear in the book how it is calculated)
			//20 estimate effluent BOD
			var sBODe = 3 //assume 3 g/m3
			var TSSe  = 10 //assume 10 g/m3
			var BOD_eff = sBODe + 0.85*0.85*TSSe;
		//end part B (nitrification)

		//show results inner function
		function show_var(id,value){
			var el=document.querySelector("#"+id);
			if(el)el.innerHTML=value.toString().substring(0,7);
		}
	};
</script>

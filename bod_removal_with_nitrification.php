<!doctype html><html><head>
	<meta charset=utf-8>
	<title>BOD removal &amp; nitrification</title>
	<script src="utils.js"></script>
	<script src="format.js"></script>
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
		#calculated_variables span[id] {
			color:blue;
		}
		#btn_calculate{
			display:block;
			font-size:22px;
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
	<h1 onclick=document.getElementById('statement').classList.toggle('invisible')>
		Complete-Mix Activated Sludge for BOD Removal with Nitrification
	</h1>
	<h2>Example 8-3 (p. 756)</h2>
	<hr>
</div>

<!--problem statement-->
<div id=statement>
	<div>
		Prepare a process design for a complete-mix activated sludge (CMAS) 
		system to treat 22,700 m<sup>3</sup>/d
		of primary effluent (including recycle flows) to (a) meet a BOD<sub>e</sub> concentration less than
		30 g/m<sup>3</sup> and (b) accomplish BOD removal and nitrification with an effluent 
		NH<sub>4</sub>-N concentration of 0.50 g/m<sup>3</sup> and BOD<sub>e</sub>
		and TSS<sub>e</sub> &le; 15 g/m<sup>3</sup>. Compare the two design conditions in a summary table. The aeration
		basin mixed liquor temperature is 12ºC.

		<p>The following wastewater characteristics and design conditions apply:</p>
		<p>Wastewater characteristics:</p>

		<table>
			<tr><th>Constituent<th>Concentration (g/m<sup>3</sup>)
			<tr><td>BOD              <td class=number> 140
			<tr><td>sBOD             <td class=number> 70
			<tr><td>COD              <td class=number> 300
			<tr><td>sCOD             <td class=number> 132
			<tr><td>rbCOD            <td class=number> 80
			<tr><td>TSS              <td class=number> 70
			<tr><td>VSS              <td class=number> 60
			<tr><td>TKN              <td class=number> 35
			<tr><td>NH<sub>4</sub>-N <td class=number> 25
			<tr><td>TP               <td class=number> 6
			<tr><td>Alkalinity       <td class=number> 140 as CaCO3
			<tr><td>bCOD/BOD ratio   <td class=number> 1.6
		</table>

		<p> <b>Note:</b> g/m<sup>3</sup> = mg/L </p>

		Design conditions and assumptions:
		<ol>
			<li>Fine bubble ceramic diffusers with an aeration clean water O<sub>2</sub> transfer efficiency = 35%
			<li>Liquid depth for the aeration basin = 4.9 m
			<li>The point of air release for the ceramic diffusers is 0.5 m above the tank bottom 
			<li>DO in aeration basin = 2.0 g/m<sup>3</sup>
			<li>Site elevation is 500 m (pressure = 95.6 kPa)
			<li>Aeration &alpha; factor = 0.50 for BOD removal only and 0.65 for nitrification;<br>
			&beta; = 0.95 for both conditions, and diffuser fouling factor <i>F</i> = 0.90
			<li>Use kinetic coefficients given in Tables 8-14
			<li>SRT for BOD removal = 5 d
			<li>Design MLSS-X<sub>TSS</sub> concentration = 3000 g/m<sup>3</sup>; values of 2000 to 3000 g/m<sup>3</sup> can be considered
			<li>Peak to average TKN loading rate ratio (SF) = 1.5
		</ol>
	</div><hr>

	<!--Solution Part A, BOD Removal-->
	<h2>Solution Part A, BOD Removal without nitrification</h2>
	<ol>
		<li>Develop the wastewater characteristics needed for design
			<ol style=list-style-type:lower-alpha>
				<li>
					Find bCOD.
					<code>
						bCOD = 1.6(BOD) = 1.6(140 g/m<sup>3</sup>) = 224 g/m<sup>3</sup>
					</code>
				</li>
				<li>
					Find nbCOD using Eq. (8-12).
					<code>
						nbCOD = COD - bCOD = (300 - 224) g/m<sup>3</sup> = 76 g/m<sup>3</sup>
					</code>
				</li>
				<li>
					Find effluent nonbiodegradable sCOD (nbsCOD<sub>e</sub>).
					<code>
						nbsCOD<sub>e</sub> = sCOD - 1.6·sBOD
						= (132 g/m<sup>3</sup>) - (1.6)(70 g/m<sup>3</sup>) = 20 g/m<sup>3</sup>
					</code>
				</li>
				<li>
					Find nbVSS using Eq. (8-7, 8-8, and 8-9).
					<code>
						nbpCOD = TCOD - bCOD - nbsCODe<br>
						nbpCOD = (300 - 224 -  20) g/m<sup>3</sup> = 56 g/m<sup>3</sup><br>
						VSS<sub>COD</sub> = (TCOD-sCOD)/VSS<br>
						VSS<sub>COD</sub> = (300-132)/60= 2.8 gCOD / gVSS<br>
						nbVSS = nbpCOD / VSS<sub>COD</sub><br>
						nbVSS = 56 / 2.8 = 20.0 g nbVSS/m<sup>3</sup>
					</code>
				</li>
				<li>
					Find the iTSS.
					<code>
						iTSS = TSS - VSS = (70 - 60) g/m<sup>3</sup> = 10 g/m<sup>3</sup>
					</code>
				</li>
			</ol>
		</li>
		<li>Design suspended growth system for BOD removal only
			<ol style=list-style-type:lower-alpha>
				<li>
					Determine biomass production using Eq (8-20) in Table 8-10.
					<code>
						P<sub>X,Bio</sub> = Q·Y<sub>H</sub>(S0-S)/(1+(b<sub>H</sub>·SRT)) + 
						(f<sub>d</sub>·b<sub>H</sub>·Q·Y<sub>H</sub>·(S0-S)·SRT)/(1+b<sub>H</sub>·SRT)
					</code>
					Define input data for above equation.
					<code>
						Q = 22,700 m<sup>3</sup>/d<br>
						S0 = 224 g bCOD/m<sup>3</sup> (see step 1)
					</code>
					From table 8-14
					<code>
						Y<sub>H</sub> = 0.45 g VSS/g bCOD<br>
						b<sub>H,20</sub> = 0.12 g/g·d<br>
						f<sub>d</sub> = 0.15
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
						S = (80 g/m<sup>3</sup>)[1+(0.088 g/g·d)(5 d)]/[(5 d)[(3.5-0.088) g/g·d - 1]] = 0.7 g bCOD/m<sup>3</sup>
					</code>
				</li>
				<li>
					Substitute the above values in the expression given above and solve for P<sub>X,VSS</sub>
					<code>
						P<sub>X,Bio</sub> = (22,700 m<sup>3</sup>)(0.45 g/g)[(224-0.7) g/m<sup>3</sup>]/(1+(0.088 g/g·d)(5 d)))<br>
						+((0.15 g/g)·(0.088 g/g·d)·(22,700 m<sup>3</sup>)(0.45 g/g)[(224-0.7) g/m<sup>3</sup>]·(5 d))/[1+(0.088 g/g·d)(5 d)]
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
						PX,VSS = 1688.5 kg/d + (22,700 m<sup>3</sup>/d)·(20 g/m<sup>3</sup>)<br>
						PX,VSS = 2142.5 kg/d
					</code>
					From Eq. (8-21), PX,TSS is
					<code>
						PX,TSS = [(1688.5 kg/d)/0.85] + (454.0 kg/d) + Q(TSSo-VSSo)<br>
						PX,TSS = 1986.5 kg/d + 454.0 kg/d + 22,700 m<sup>3</sup>/d)(10 g/m<sup>3</sup>)<br>
						PX,TSS = 2667.5 kg/d
					</code>
				</li>
				<li style=background:orange>
					page 759 starts here (TO DO)
				</li>
			</ol>
		</li>
	</ol><hr>
</div>

<!--implementation gui-->
<div><h2>Implementation in Javascript</h2>
	<div>
		<button id=btn_calculate onclick=compute_exercise() style>Solve</button>
	</div>
	<ol class=flex>
		<li>
			<div>Inputs</div>
			<table style=width:100%>
				<tr><td>Q               <td><input type=number id=input_Q value=22700> m<sup>3</sup>/d
				<tr><td>T               <td><input type=number id=input_T value=12> ºC
				<tr><td>BOD             <td><input type=number id=input_BOD value=140> g/m<sup>3</sup>
				<tr><td>sBOD            <td><input type=number id=input_sBOD value=70> g/m<sup>3</sup>
				<tr><td>COD	            <td><input type=number id=input_COD value=300> g/m<sup>3</sup>
				<tr><td>sCOD            <td><input type=number id=input_sCOD value=132> g/m<sup>3</sup>
				<tr><td>rbCOD           <td><input type=number id=input_rbCOD value=80> g/m<sup>3</sup>
				<tr><td>TSS	            <td><input type=number id=input_TSS value=70> g/m<sup>3</sup>
				<tr><td>VSS	            <td><input type=number id=input_VSS value=60> g/m<sup>3</sup>
				<tr><td>TKN             <td><input type=number id=input_TKN value=35> g/m<sup>3</sup>
				<tr><td>NH<sub>4</sub>-N<td><input type=number id=input_NH4_N value=25> g/m<sup>3</sup>
				<tr><td>TP              <td><input type=number id=input_TP value=6> g/m<sup>3</sup>
				<tr><td>Alkalinity      <td><input type=number id=input_Alkalinity value=140> as CaCO<sub>3</sub>
				<tr><td>bCOD/BOD ratio  <td><input type=number id=input_bCOD_BOD_ratio value=1.6> &empty;
				<tr><td><b>Design parameters</b>
				<tr><td>SRT                         <td><input type=number id=parameter_SRT value=5> d
				<tr><td>MLSS<sub>X,TSS</sub>        <td><input type=number id=parameter_MLSS_X_TSS value=3000> g/m<sup>3</sup>
				<tr><td>z<sub>b</sub> (elevation)   <td><input type=number id=parameter_zb value=500> m 
				<tr><td>Pressure (at z<sub>b</sub>) <td><input type=number id=parameter_Pressure value=95600> Pa
				<tr><td>D<sub>f</sub>               <td><input type=number id=parameter_Df value=4.4> m
				<tr><td>N<sub>e</sub>               <td><input type=number id=parameter_Ne value=0.50> g/m<sup>3</sup>
				<tr><td>sBOD<sub>e</sub>            <td><input type=number id=parameter_sBODe value=3> g/m<sup>3</sup>
				<tr><td>TSS<sub>e</sub>             <td><input type=number id=parameter_TSSe value=10> g/m<sup>3</sup>
				<tr><td>X<sub>R</sub>               <td><input type=number id=parameter_X_R value=8000> g/m<sup>3</sup>
				<tr><td>Hydraulic application rate (16-28) <td><input type=number id=parameter_hydraulic_application_rate value=24> m<sup>3</sup>/m<sup>2</sup>·d
				<tr><td>Clarifiers                  <td><input type=number id=parameter_clarifiers value=3> clarifiers
			</table>
		</li>
		<li><div>Tabulated parameters</div>
			<table>
				<tr><td>Y<sub>H</sub>                  <td class=number>0.45<td>g VSS/g bCOD
				<tr><td>K<sub>s</sub>                  <td class=number>8<td>g/m<sup>3</sup>
				<tr><td>&mu;<sub>m</sub>               <td class=number>6<td>d<sup>-1</sup>
				<tr><td>b<sub>H,20</sub>               <td class=number>0.12<td>d<sup>-1</sup>
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
				<tr><td>Y<sub>n</sub>                  <td class=number>0.15<td>g VSS/g NOx
				<tr><td>E                              <td class=number>35<td>%
			</table>
		</li>
		<li><div>Results</div>
			<table id=results>
				<tr><th colspan=3>BOD removal only
				<tr><td>bCOD                <td class=number><span id=part_A_bCOD>?</span><td>g/m<sup>3</sup>
				<tr><td>nbCOD               <td class=number><span id=part_A_nbCOD>?</span><td>g/m<sup>3</sup>
				<tr><td>nbsCODe             <td class=number><span id=part_A_nbsCODe>?</span><td>g/m<sup>3</sup>
				<tr><td>nbVSS               <td class=number><span id=part_A_nbVSS>?</span><td>g/m<sup>3</sup>
				<tr><td>iTSS                <td class=number><span id=part_A_iTSS>?</span><td>g/m<sup>3</sup>
				<tr><td>P<sub>X,Bio</sub>   <td class=number><span id=part_A_P_X_bio>?</span><td>kg VSS/d
				<tr><td>P<sub>X,VSS</sub>   <td class=number><span id=part_A_P_X_VSS>?</span><td>kg/d
				<tr><td>P<sub>X,TSS</sub>   <td class=number><span id=part_A_P_X_TSS>?</span><td>kg/d
				<tr><td>X<sub>VSS</sub>V    <td class=number><span id=part_A_X_VSS_V>?</span><td>kg
				<tr><td>X<sub>TSS</sub>V    <td class=number><span id=part_A_X_TSS_V>?</span><td>kg
				<tr><td>V<sub>aer tank</sub><td class=number><span id=part_A_V>?</span><td>m<sup>3</sup>
				<tr><td>&tau;               <td class=number><span id=part_A_tau>?</span><td>h
				<tr><td>MLVSS               <td class=number><span id=part_A_MLVSS>?</span><td>g/m<sup>3</sup>
				<tr><td>F/M                 <td class=number><span id=part_A_FM>?</span><td>kg/kg·d
				<tr><td>BOD loading         <td class=number><span id=part_A_BOD_loading>?</span><td>kg/m<sup>3</sup>·d
				<tr><td>bCOD removed        <td class=number><span id=part_A_bCOD_removed>?</span><td>kg/d
				<tr><td>Y<sub>obs,TSS</sub> <td class=number><span id=part_A_Y_obs_TSS>?</span><td>g TSS/g BOD
				<tr><td>Y<sub>obs,VSS</sub> <td class=number><span id=part_A_Y_obs_VSS>?</span><td>g VSS/g BOD
				<tr><td>O<sub>2</sub> demand<td class=number><span id=part_A_R0>?  </span><td>kg O<sub>2</sub>/h
				<tr><td>P<sub>b</sub>       <td class=number><span id=part_A_Pb>?  </span><td>m
				<tr><td>C<sub>T</sub>       <td class=number><span id=part_C_T>?  </span><td>mg O<sub>2</sub>/L
				<tr><td>SOTR                <td class=number><span id=part_A_SOTR>?</span><td>kg/h
				<tr><td>Air flowrate        <td class=number><span id=part_A_air_flowrate>?</span><td>m<sup>3</sup>/min
				<tr><th colspan=3>
				<tr><th colspan=3>BOD removal and nitrification
				<tr><td>&mu;<sub>AOB</sub>      <td class=number><span id=part_B_mu_AOB>?</span><td>d<sup>-1</sup>
				<tr><td>SRT theoretical         <td class=number><span id=part_B_SRT_theoretical>?</span><td>d
				<tr><td>SRT design              <td class=number><span id=part_B_SRT_design>?</span><td>d
				<tr><td>NO<sub>x</sub>          <td class=number><span id=part_B_NOx>?</span><td>g/m<sup>3</sup>
				<tr><td>P<sub>X,Bio,VSS</sub>   <td class=number><span id=part_B_P_X_bio_VSS>?</span><td>kg VSS/d
				<tr><td>P<sub>X,VSS</sub>       <td class=number><span id=part_B_P_X_VSS>?</span><td>kg/d
				<tr><td>P<sub>X,TSS</sub>       <td class=number><span id=part_B_P_X_TSS>?</span><td>kg/d
				<tr><td>X<sub>VSS</sub>V        <td class=number><span id=part_B_X_VSS_V>?</span><td>kg
				<tr><td>X<sub>TSS</sub>V        <td class=number><span id=part_B_X_TSS_V>?</span><td>kg
				<tr><td>V<sub>aer tank</sub>    <td class=number><span id=part_B_V>?</span><td>m<sup>3</sup>
				<tr><td>&tau;                   <td class=number><span id=part_B_tau>?</span><td>h
				<tr><td>MLVSS                   <td class=number><span id=part_B_MLVSS>?</span><td>g/m<sup>3</sup>
				<tr><td>F/M                     <td class=number><span id=part_B_FM>?</span><td>kg/kg·d
				<tr><td>BOD loading             <td class=number><span id=part_B_BOD_loading>?</span><td>kg/m<sup>3</sup>·d
				<tr><td>bCOD removed            <td class=number><span id=part_B_bCOD_removed>?</span><td>kg/d
				<tr><td>Y<sub>obs,TSS</sub>     <td class=number><span id=part_B_Y_obs_TSS>?</span><td>g TSS/g BOD
				<tr><td>Y<sub>obs,VSS</sub>     <td class=number><span id=part_B_Y_obs_VSS>?</span><td>g VSS/g BOD
				<tr><td>O<sub>2</sub> demand    <td class=number><span id=part_B_R0>?  </span><td>kg O<sub>2</sub>/h
				<tr><td>SOTR                    <td class=number><span id=part_B_SOTR>?</span><td>kg/h
				<tr><td>Air flowrate            <td class=number><span id=part_B_air_flowrate>?</span><td>m<sup>3</sup>/min
				<tr><td>NaHCO<sub>3</sub> added <td class=number><span id=part_B_alkalinity_to_be_added>?</span><td>kg/d as NaHCO<sub>3</sub>
				<tr><td>BOD<sub>e</sub> estimate<td class=number><span id=part_B_BOD_eff>?</span><td>g/m<sup>3</sup>
				<tr><th colspan=3>
				<tr><th colspan=3>Secondary clarifier sizing
				<tr><td>RAS                     <td class=number><span id=part_C_RAS>?</span><td>&empty;
				<tr><td>Area                    <td class=number><span id=part_C_Area>?</span><td>m<sup>2</sup>
				<tr><td>Area per clarifier      <td class=number><span id=part_C_area_per_clarifier>?</span><td>m<sup>2</sup>/clarifier
				<tr><td>Clarifier diameter      <td class=number><span id=part_C_clarifier_diameter>?</span><td>m
				<tr><td>Solids loading          <td class=number><span id=part_C_Solids_loading>?</span><td>kg MLSS/m<sup>2</sup>·h
			</table>
		</li>
	</ol>
</div>

<!--implementation-->
<script>
	function compute_exercise(){
		//get inputs
			var BOD            = getInput('input_BOD');
			var sBOD           = getInput('input_sBOD');
			var COD            = getInput('input_COD');
			var sCOD           = getInput('input_sCOD');
			var rbCOD          = getInput('input_rbCOD');
			var TSS            = getInput('input_TSS');
			var VSS            = getInput('input_VSS');
			var TKN            = getInput('input_TKN');
			var NH4_N          = getInput('input_NH4_N');
			var TP             = getInput('input_TP');
			var Alkalinity     = getInput('input_Alkalinity');
			var bCOD_BOD_ratio = getInput('input_bCOD_BOD_ratio');
			var Q              = getInput('input_Q');
			var T              = getInput('input_T');
		//end inputs

		//design parameters
			var SRT        = getInput('parameter_SRT'); //5
			var MLSS_X_TSS = getInput('parameter_MLSS_X_TSS'); //3000
			var zb         = getInput('parameter_zb'); //500
			var Pressure   = getInput('parameter_Pressure'); //95600
			var Df         = getInput('parameter_Df'); //4.4 = 4.9m-0.5m, from design conditions and assumptions (depth of diffusers in basin)

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
			var E = 0.35 //O2 transfer efficiency
			var SF =1.5 //peak to average tkn load (design assumptions)
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
			//7
			var NOx=0;
			var R0 = (Q*(S0-S)/1000 -1.42*P_X_bio)/24 + 0; //NOx is zero here
			//8
			var Pb = Pa*Math.exp(-g*M*(zb-0)/(R*(273.15+T))); //pressure at plant site
			var C_inf_20 = C_s_20 * (1+de*Df/Pa);
			var OTRf = R0;
			var SOTR = (OTRf/(alpha*F))*(C_inf_20/(beta*C_T/C_s_20*Pb/Pa*C_inf_20-C_L))*(Math.pow(1.024,20-T));
			var kg_O2_per_m3_air = density_of_air(T,Pressure)*0.2318 //oxygen in air by weight is 23.18%, by volume is 20.99%
			var air_flowrate = SOTR/(E*60*kg_O2_per_m3_air);
		//end part A

		//show results for part A
			showResult('part_A_bCOD',bCOD);
			showResult('part_A_nbCOD',nbCOD);
			showResult('part_A_nbsCODe',nbsCODe);
			showResult('part_A_nbVSS',nbVSS);
			showResult('part_A_iTSS',iTSS);
			showResult('part_A_P_X_bio',P_X_bio);
			showResult('part_A_P_X_VSS',P_X_VSS);
			showResult('part_A_P_X_TSS',P_X_TSS);
			showResult('part_A_X_VSS_V',X_VSS_V);
			showResult('part_A_X_TSS_V',X_TSS_V);
			showResult('part_A_V',V);
			showResult('part_A_tau',tau);
			showResult('part_A_MLVSS',MLVSS);
			showResult('part_A_FM',FM);
			showResult('part_A_BOD_loading',BOD_loading);
			showResult('part_A_bCOD_removed',bCOD_removed);
			showResult('part_A_Y_obs_TSS',Y_obs_TSS);
			showResult('part_A_Y_obs_VSS',Y_obs_VSS);
			showResult('part_A_R0',R0);
			showResult('part_A_Pb',Pb);
			showResult('part_C_T',C_T);
			showResult('part_A_SOTR',SOTR);
			showResult('part_A_air_flowrate',air_flowrate);
		//end results part A

		//9: part B NITRIFICATION
			//parameters
			var mu_max_AOB = 0.90 //table 8-14 at 20ºC
			var b_AOB = 0.17 // table 8-14 at 20ºC
			var K_NH4 = 0.50 //table 8-14 at 20ºC
			var K_o_AOB = 0.50 //table 8-14 at 20ºC
			var S_NH4 = 0.50 //g/m3 at effluent?
			var Yn = 0.15; //Table 8-14
			var alpha = 0.65;
			var beta = 0.95;

			//design parameters
			var Ne    = getInput('parameter_Ne'); //assume 0.50; N at effluent (g/m3)
			var sBODe = getInput('parameter_sBODe'); //assume 3
			var TSSe  = getInput('parameter_TSSe'); //assume 10 g/m3

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
			var FM = Q*BOD/MLVSS/V;
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
			showResult('part_B_mu_AOB',mu_AOB);
			showResult('part_B_SRT_theoretical',SRT_theoretical);
			showResult('part_B_SRT_design',SRT_design);
			showResult('part_B_NOx',NOx);
			showResult('part_B_P_X_bio_VSS',P_X_bio_VSS);
			showResult('part_B_P_X_VSS',P_X_VSS);
			showResult('part_B_P_X_TSS',P_X_TSS);
			showResult('part_B_X_VSS_V',X_VSS_V);
			showResult('part_B_X_TSS_V',X_TSS_V);
			showResult('part_B_V',V);
			showResult('part_B_tau',tau);
			showResult('part_B_MLVSS',MLVSS);
			showResult('part_B_FM',FM);
			showResult('part_B_BOD_loading',BOD_loading);
			showResult('part_B_bCOD_removed',bCOD_removed);
			showResult('part_B_Y_obs_TSS',Y_obs_TSS);
			showResult('part_B_Y_obs_VSS',Y_obs_VSS);
			showResult('part_B_R0',R0);
			showResult('part_B_SOTR',SOTR);
			showResult('part_B_air_flowrate',air_flowrate);
			showResult('part_B_alkalinity_to_be_added',alkalinity_to_be_added);
			showResult('part_B_BOD_eff',BOD_eff);
		//end results part B

		//21: part C SECONDARY CLARIFIER SIZING (for both bod removal and nitrification)
			var hydraulic_application_rate = getInput('parameter_hydraulic_application_rate'); //assume 24 m3/m2·d (from table 8-34, page 890, range 16-28)
			var X_R                        = getInput('parameter_X_R'); //assume 8000 g/m3
			var clarifiers                 = getInput('parameter_clarifiers'); //assume 3
			var RAS = MLSS_X_TSS/(X_R - MLSS_X_TSS); //calc return sludge recycle ratio
			var Area = Q/hydraulic_application_rate; //m2
			var area_per_clarifier = Area/clarifiers; //m2/clarifier
			var clarifier_diameter = Math.sqrt(area_per_clarifier*4/Math.PI); //meters
			var Solids_loading = (1+RAS)*Q*MLSS_X_TSS/1000/(Area*24); //kg MLSS/m2·h
		//end part C

		//show results part C
			showResult('part_C_RAS',RAS);
			showResult('part_C_Area',Area);
			showResult('part_C_area_per_clarifier',area_per_clarifier);
			showResult('part_C_clarifier_diameter',clarifier_diameter);
			showResult('part_C_Solids_loading',Solids_loading);
		//end results part C
	};
</script>

<div>
	To do:
	<ul>
		<li>Warning if Solids loading is out of range (4-6 kg MLSS/m<sup>2</sup>·h)
	</ul>
</div>


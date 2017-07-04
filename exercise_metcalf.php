<!doctype html>
<html><head>
	<meta charset=utf-8>
	<title>Metcalf exercise 8-2 (p. 707)</title>
	<style>
		body{
			max-width:60em;
		}
		.invisible{
			display:none;
		}
		table{
			border-collapse:collapse;
			border:1px solid #ccc;
			margin:5px 0;
		}
		th {
			text-align:left;
			border-bottom:1px solid black;
		}
		td:nth-child(2){
			text-align:right;
		}
		code{
			display:block;
			background:#ddd;
			padding:5px 0;
			padding-left:5px;
		}
	</style>
	<script>
		//equations
		//[...]
	</script>
</head><body>
<h1>Metcalf exercise 8-2 (p. 707) (unfinished)</h1>

<div id=enunciat>
	<p><b>Complete-Mix Activated sludge process design for BOD Removal</b></p>
	Design a complete-mix activated-sludge (CMAS) process to treat 22464 m3/d of primary effluent 
	to (a) meet a BODe concentration less than 30 g/m3 and (b) accomplish BOD removal and nitrification
	with an effluent NH4-N concentration of 0.50 g/m3 and BODe and TSSe &lt; 15 g/m3. Compare the two
	design conditions in a summary table. The aeration basin mixed-liquor temperature is 12ºC.
	<p>
		<i>Note:</i> Stemps 2 through 8 cover condition (a), BOD removal only; and Stemps 9 through 20
		cover condition (b), BOD removal and nitrification. Clarifier design is discussed in step 21.
	</p>
	The following wastewater characteristics and design conditions apply:
	<table>
		<tr><th>Constituent<th>Concentration (g/m3 = mg/L)
		<tr><td>BOD<td> 140
		<tr><td>sBOD<td> 70
		<tr><td>COD<td> 300
		<tr><td>sCOD<td> 132
		<tr><td>rbCOD<td> 80
		<tr><td>TSS<td> 70
		<tr><td>VSS<td> 60
		<tr><td>TKN<td> 35
		<tr><td>NH4-N<td> 25
		<tr><td>TP<td> 6
		<tr><td>Alkalinity<td> 140 as CaCO3
		<tr><td>bCOD/BOD ratio<td> 1.6
	</table>
	Design conditions and assumptions:
	<ol>
		<li>Fine bubble ceramic diffusers with an aeration clean water O2 transfer efficiency = 35%
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
					P<sub>X,VSS</sub> = QY(S0-S)/(1+(kd·SRT)) + (fd·kd·QY(S0-S)·SRT)/(1+kd·SRT)
				</code>
				Define input data for above equation
				<code>
					Q = 22464 m3/d<br>
					Y = 0.40 g VSS/g bCOD (table 8-10)<br>
					S0 = 224 g bCOD/m3 (see step 1)
				</code>
				Determine S from Eq (7-40) in table 8-5. Note Yk = &mu;m
				<code>
					S = Ks[1+kd·SRT]/[SRT·(&mu;m-kd)-1]
				</code>
				Use &mu;m and kd from table 8-10.
				<code>
					Ks = 20 g/m3
					<br>
					&mu;<sub>m,T</sub> = &mu;m·&theta;<sup>T-20</sup>
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
					P<sub>X,VSS</sub> = 1478 kg VSS/d
				</code>
			</li>
		</ol>
	</li>
</ol>
<hr>
<h2>Implementation in Javascript</h2>
<ol>
	<li>
		Inputs
		<table>
			<tr><td>BOD            <td><input id=BOD value=140> g/m3
			<tr><td>sBOD           <td><input id=sBOD value=70> g/m3
			<tr><td>COD	           <td><input id=COD value=300> g/m3
			<tr><td>sCOD           <td><input id=sCOD value=132> g/m3
			<tr><td>rbCOD          <td><input id=rbCOD value=80> g/m3
			<tr><td>TSS	           <td><input id=TSS value=70> g/m3
			<tr><td>VSS	           <td><input id=VSS value=60> g/m3
			<tr><td>bCOD/BOD ratio <td><input id=bCOD_BOD_ratio value=1.6>
			<tr><td>Q              <td><input id=Q value=22464> m3/d
		</table>
	</li>
	<li>
		Parameters
		<ul>
			<li>aaaa
		</ul>
	</li>
	<li>
		Calculated variables
		<ul>
			<li>bCOD 
			<li>nbCOD 
			<li>sCODe 
			<li>nbVSS
			<li>iTSS
			<li>P<sub>X,VSS</sub>
		</ul>
	</li>
</ol>
<!--end--><div style=margin-bottom:50em></div>


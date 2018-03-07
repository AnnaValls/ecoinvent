<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Chemical P removal</title>
	<script>
		function init(){
			//compute_exercise();
		}
	</script>
	<style>
		body{
			overflow-y:scroll;
			max-width:90em;
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
		Determination of Ferric Chloride Dosage for Phosphorus Removal
	</h1>
	<h2>Example 6-2 (p. 484)</h2>
	<hr>
</div>

<!--tabs-->
<?php include'tabs.php'?>

<!--statement-->
<div id=statement>
	<p>
		Determine the amount of ferric chloride required to precipitate phosphorus from untreated wastewater
		with the characteristics given below. Also determine the required ferric
		chloride storage capacity, if a 15 d supply is to be stored at the treatment facility and the 
		added quantity of sludge generated from the ferric chloride addition.
	</p>
	<table>
		<tr><td>1. Q                                    <td class=number>3800 <td>m<sup>3</sup>/d
		<tr><td>2. TSS                                  <td class=number>220  <td>mg/L
		<tr><td>3. TSS removal w/o iron addition        <td class=number>60   <td>%
		<tr><td>4. TSS removal w/  iron addition        <td class=number>75   <td>%
		<tr><td>5. Influent total P                     <td class=number>7    <td>g/m<sup>3</sup>
		<tr><td>6. Influent PO<sub>4</sub><sup>3-</sup> <td class=number>5    <td>as mg P/L
		<tr><td>7. Effluent PO<sub>4</sub><sup>3-</sup> <td class=number>0.1  <td>as mg P/L
		<tr><td>8. Wastewater alkalinity                <td class=number>240  <td>as mg CaCO<sub>3</sub>/L
		<tr><td>9. Ferric chloride solution             <td class=number>37   <td>%
		<tr><td>10. Ferric chloride, unit weight        <td class=number>1.35 <td>kg/L
		<tr><td>11. Raw sludge properties               <td>                  <td>
		<tr><td>&emsp; Specific gravity                 <td class=number>1.03 <td>&empty;
		<tr><td>&emsp; Moisture content                 <td class=number>94   <td>%
		<tr><td>12. Chemical sludge properties (ch.13)  <td>                  <td>
		<tr><td>&emsp; Specific gravity                 <td class=number>1.05 <td>&empty;
		<tr><td>&emsp; Moisture content                 <td class=number>92.5 <td>%
	</table>

	<div>
		<p><b>Solution</b></p>
		<pre>
			1. Determine the weight of iron required to remove ortophosphate.
				a. From Fig. 6-13 for an effluent PO43- concentration of 0.1 mg/L the required
				<code>
				(Fe/P) mole ratio is approximately 3.3.
				</code>
				b. Using Eq- 6-24, the required ferric chloride dose is
				<code>
				Fe(III) dose = (Fe/P)(CP,in - CP,res)[(55.85 g/mole Fe)/(30.97 g/mole P)]
				Substitute known values and solve for the dose
				Fe(III) dose = (3.3)(5 - 0.1)[(55.85 g/mole Fe)/(30.97 g/mole P)]
				Fe(III) dose = 29.2 mg/L
				</code>
			2. Determine primary effluent P concentration.
			<code>
				P, mg/L = 7 - (5 - 0.1) = 2.1 mg/L
			</code>
			3. Determine the amount of ferric iron required per day
			<code>
				Fe Dose = (3800 m3/d)(29.2 mg/L)(1 kg/1000 g) = 111.0 kg/d
			</code>
			4. Determine the amount of ferric chloride solution required per day and the 15 d storage requirement.
				a. Determine the percent ferric iron in FeCl3.
				<code>
				Percent Fe in FeCl3 = (55.85/162.3)·100 = 34.4%
				</code>
				b. Determine the amount of a 34.4% solution of ferric chloride required per day
				<code>
				FeCl3 solution = [(111.0 kg/d)/0.344] = 322.7 kg/d
				</code>
				c. Determine volume of required FeCl3 solution per day.
				<code>
				FeCl3 volume = [(322.7 kg/d)/(0.37) · 1.35](1 L/kg) = 646.0 L/d
				</code>
				d. Determine 15-d storage requirement based on average flowrate.
				<code>
				15-d storage requirement = (646.0 L/d)(1 m3/1000 L)(15) = 10.3 m3
				</code>
			5. Determine the total maass of sludge on a dry basis resulting	from chemical precipitation.
				a. Estimate the additional TSS removal resulting from the addition of FeCl3 for P removal.
				<code>
				Additional sludge = (0.15)(220 g/m3)(3800 m3/d)(1 kg/1000 g)
				Additional sludge = 125.4 kg/d
				</code>
				b. Estimate the additional sludge resulting from the precipitate formed with P using Eq. (6-21)
				<code>
				1.6Fe3+ + HPO44- + 3.8OH &rarr; Fe1.6·H2PO4(OH)3.8
				Fe dose = (29.2 mg Fe/L)(1 g/1000 mg)/(55.85 g/mole) = 0.00052 M
				P removed = [(5 - 0.1) mg P/L)](1 g/1000 mg)/(30.97 g/mole)
				P removed = 0.00016 M
				Fe1.6·H2PO4(OH)3.8 sludge = (0.00016 M)(251 g/mole)(1000 mg/g)
				Fe1.6·H2PO4(OH)3.8 sludge = 40.2 mg/L
				</code>
				c. Estimate the additional sludge resulting from Fe(OH)3.
				<code>
				Excess Fe added = 0.00052 M - 1.6(0.00016 M) = 0.000264 M
				Fe(OH)3 sludge = 0.000264 M · (106.8 g/mole) = 28.2 mg/L
				</code>
				d. Estimate total chemical sludge resulting FeCl3 addition.
				<code>
				Excess sludge = 40.2 mg/L + 28.2 mg/L = 68.4 mg/L
				Excess sludge = (3800 m3/d)(68.4 mg/L)(1 kg/1000 g) = 259.9 kg/d
				</code>
				e. Estimate total excess sludge resulting FeCl3 addition.
				<code>
				Total excess sludge = 125.4 kg/d + 259.9 kg/d = 385.3 kg/d
				</code>
			6. Compare total sludge production without and with chemical addition.
				a. Without chemical addition 
				<code>
				Sludge = (3800 m3/d)(220.0 mg/L)(0.6)(1 kg/1000 g) = 501.6 kg/d
				</code>
				b. Total with chemical addition
				<code>
				Total = 501.6 kg/d + 385.3 kg/d = 886.9 kg/d
				</code>
			7. Determine the total volume of sludge without chemical precipitation, assuming that the sludge
		  has a specific gravity of 1.03 and a moisture content of 94%.
				<code>
				Vs = (501.6 kg/d)/(1.03·(1000 kg/m3)0.006) = 8.1 m3
				</code>
			8. Determine the total volume of sludge resulting from chemical precipitation, assuming
			that the sludge has a specific gravity of 1.05 and a moisture content of 92.5%
				<code>
				Vs = (886.9 kg/d)/(1.05·(1000 kg/m3)0.075) = 11.3 m3/d
				</code>
			9. The summary table is in the implementation tab
		</pre>
	</div>
</div>

<!--implementation-->
<div id=implement class=invisible>
	<h2>Implementation in Javascript</h2>
	<div> <button id=btn_calculate onclick=compute_exercise() style>Solve</button> </div>
	<ol class=flex>
		<li><div>Inputs</div>
			<table>
				<tr><td>Q                                                      <td><input type=number id=input_Q                 value=3800> m<sup>3</sup>/d
				<tr><td>TSS                                                    <td><input type=number id=input_TSS               value=220 > mg/L
				<tr><td>[P]<sub>influent</sub>                                 <td><input type=number id=input_TP                value=7   > mg/L
				<tr><td>[PO<sub>4</sub>]<sub>influent</sub>                    <td><input type=number id=input_PO4         value=5   > mg/L
				<tr><td>[PO<sub>4</sub>]<sub>effluent</sub>                    <td><input type=number id=input_PO4_eff         value=0.1 > mg/L
				<tr><td>FeCl<sub>3</sub> solution                              <td><input type=number id=input_FeCl3_solution    value=37  > %
				<tr><td>FeCl<sub>3</sub> unit weight                           <td><input type=number id=input_FeCl3_unit_weight value=1.35> kg/L
				<tr><td>Time for supply to be<br>stored at the treatment facility <td><input type=number id=input_days              value=15  > days
			</table>
		</li><li><div>Tabulated parameters</div>
			<table>
				<tr><td>Fe/P mole ratio                  <td class=number>3.3   <td>&empty;
				<tr><td>M<sub>Fe</sub>                   <td class=number>55.845<td>g/mol
				<tr><td>M<sub>P</sub>                    <td class=number>30.974<td>g/mol
				<tr><td>M<sub>Fe</sub>                   <td class=number>55.845<td>g/mol
				<tr><td>M<sub>P</sub>                    <td class=number>30.974<td>g/mol
				<tr><td colspan=3>Raw sludge properties
				<tr><td>&emsp;Specific gravity      <td class=number>1.03  <td>&empty;
				<tr><td>&emsp;Moisture content      <td class=number>94    <td>%
				<tr><td colspan=3>Chemical sludge properties
				<tr><td>&emsp;Specific gravity <td class=number>1.05  <td>&empty;
				<tr><td>&emsp;Moisture content <td class=number>92.5  <td>%
			</table>
		</li><li><div>Results</div>
			<table id=results>
				<tr><td>Fe(III)<sub>dose</sub>               <td id=result_Fe_III_dose>          ?<td>mg/L
				<tr><td>Primary effluent [P]                 <td id=result_primary_eff_P>        ?<td>mg/L
				<tr><td>Fe dose required                     <td id=result_Fe_dose>              ?<td>kg/d
				<tr><td>Amount FeCl<sub>3</sub> solution     <td id=result_amount_FeCl3_solution>?<td>kg/d
				<tr><td>FeCl<sub>3</sub>        volume       <td id=result_FeCl3_volume>         ?<td>L/d
				<tr><td>FeCl<sub>3</sub> storage requirement <td id=result_storage_req_15_d>     ?<td>m<sup>3</sup>
				<tr><td>Additional sludge<sub>precipitation</sub> <td id=result_Additional_sludge>    ?<td>kg/d
				<tr><td>Fe dose                              <td id=result_Fe_dose_M>            ?<td>M
				<tr><td>P removed                            <td id=result_P_removed>            ?<td>M
				<tr><td>Fe<sub>1.6</sub>·H<sub>2</sub>PO<sub>4</sub>(OH)<sub>3.8</sub> sludge <td id=result_FeH2PO4OH_sludge>?<td>mg/L
				<tr><td>Excess Fe added                      <td id=result_Excess_Fe_added>      ?<td>M
				<tr><td>Fe(OH)<sub>3</sub> sludge            <td id=result_FeOH3_sludge>         ?<td>mg/L
				<tr><td>Excess sludge                        <td id=result_Excess_sludge>        ?<td>mg/L
				<tr><td>Excess sludge_kg                     <td id=result_Excess_sludge_kg>     ?<td>kg/d
				<tr><td>Total excess sludge                  <td id=result_Total_excess_sludge>  ?<td>kg/d
				<tr><th colspan=3>
				<tr><td><th colspan=2 style=text-align:center>Sludge
				<tr><th>Treatment<th>Mass (kg/d)<th>Volume (m<sup>3</sup>/d)
				<tr>
					<td>W/o chemical precipitation 
					<td id="sludge_production_wo_chemical_addition">?
					<td id="Vs_without">?
				</tr><tt>
					<td>W/ chemical precipitation 
					<td id="sludge_production_w_chemical_addition">?
					<td id="Vs">?
				</tr>
			</table>
		</li>
	</ol>
</div>

<!--implementation-->
<script>
	function compute_exercise(){
		//inputs
		var Q                 = getInput('input_Q');
		var TSS               = getInput('input_TSS');
		var TP                = getInput('input_TP');
		var PO4         = getInput('input_PO4');
		var PO4_eff         = getInput('input_PO4_eff');
		var FeCl3_solution    = getInput('input_FeCl3_solution');
		var FeCl3_unit_weight = getInput('input_FeCl3_unit_weight');
		var days              = getInput('input_days');

		//solve
		var r = chem_P_removal(Q,TSS,TP,PO4,PO4_eff,FeCl3_solution,FeCl3_unit_weight,days);

		//show results
		showResult('result_Fe_III_dose',                     r.Fe_III_dose.value);
		showResult('result_primary_eff_P',                   r.primary_eff_P.value);
		showResult('result_Fe_dose',                         r.Fe_dose.value);
		showResult('result_amount_FeCl3_solution',           r.amount_FeCl3_solution.value);
		showResult('result_FeCl3_volume',                    r.FeCl3_volume.value);
		showResult('result_storage_req_15_d',                r.storage_req_15_d.value);
		showResult('result_Additional_sludge',               r.Additional_sludge.value);
		showResult('result_Fe_dose_M',                       r.Fe_dose_M.value);
		showResult('result_P_removed',                       r.P_removed.value);
		showResult('result_FeH2PO4OH_sludge',                r.FeH2PO4OH_sludge.value);
		showResult('result_Excess_Fe_added',                 r.Excess_Fe_added.value);
		showResult('result_FeOH3_sludge',                    r.FeOH3_sludge.value);
		showResult('result_Excess_sludge',                   r.Excess_sludge.value);
		showResult('result_Excess_sludge_kg',                r.Excess_sludge_kg.value);
		showResult('result_Total_excess_sludge',             r.Total_excess_sludge.value);
		showResult('sludge_production_wo_chemical_addition', r.sludge_prod_without.value);
		showResult('sludge_production_w_chemical_addition',  r.sludge_prod.value);
		showResult('Vs_without',                             r.Vs_without.value);
		showResult('Vs',                                     r.Vs.value);
	}
</script>

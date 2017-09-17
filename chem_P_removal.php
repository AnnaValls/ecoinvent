<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Chemical P removal</title>
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
	<h2>Example 6-2 (p. 484)</h2>
	<h3 onclick=document.getElementById('statement').classList.toggle('invisible')>
		Determination of Ferric Chloride Dosage for Phosphorus Removal
	</h3><hr>
</div>

<!--problem statement-->
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
</div><hr>

<!--implementation gui-->
<div style=display:><h2>Implementation in Javascript</h2>
	<div> <button id=btn_calculate onclick=compute_exercise() style>Solve</button> </div>
	<ol class=flex>
		<li><div>Inputs</div>
			<table>
				<tr><td>Q                                                      <td><input type=number id=input_Q                 value=3800> m<sup>3</sup>/d
				<tr><td>TSS                                                    <td><input type=number id=input_TSS               value=220 > mg/L
				<tr><td>TSS<sub>rem w/o Fe</sub>                               <td><input type=number id=input_TSS_removal_wo_Fe value=60  > %
				<tr><td>TSS<sub>rem w/ Fe</sub>                                <td><input type=number id=input_TSS_removal_w_Fe  value=75  > %
				<tr><td>[P]<sub>influent</sub>                                 <td><input type=number id=input_C_P_inf           value=7   > mg/L
				<tr><td>[P]<sub>effluent</sub>                                 <td><input type=number id=input_C_PO4_inf         value=5   > mg/L
				<tr><td>[PO<sub>4</sub>]<sub>effluent</sub>                    <td><input type=number id=input_C_PO4_eff         value=0.1 > mg/L
				<tr><td>Alkalinity                                             <td><input type=number id=input_Alkalinity        value=240 > mg/L as CaCO<sub>3</sub>
				<tr><td>FeCl<sub>3</sub> solution                              <td><input type=number id=input_FeCl3_solution    value=37  > %
				<tr><td>FeCl<sub>3</sub> unit weight                           <td><input type=number id=input_FeCl3_unit_weight value=1.35> kg/L
				<tr><td>Time for supply to be stored at the treatment facility <td><input type=number id=input_days              value=15  > days
			</table>
		</li><li><div>Tabulated parameters</div>
			<table>
				<tr><td>Fe/P mole ratio                  <td class=number>3.3   <td>&empty;
				<tr><td>M<sub>Fe</sub>                   <td class=number>55.845<td>g/mol
				<tr><td>M<sub>P</sub>                    <td class=number>30.974<td>g/mol
				<tr><td>M<sub>Fe</sub>                   <td class=number>55.845<td>g/mol
				<tr><td>M<sub>P</sub>                    <td class=number>30.974<td>g/mol
				<tr><td>Raw sludge specific gravity      <td class=number>1.03  <td>&empty;
				<tr><td>Raw sludge moisture content      <td class=number>94    <td>%
				<tr><td>Chemical sludge specific gravity <td class=number>1.05  <td>&empty;
				<tr><td>Chemical sludge moisture content <td class=number>92.5  <td>%
			</table>
		</li><li><div>Results</div>
			<table id=results>
				<tr><td>Fe(III)<sub>dose</sub>               <td id=result_Fe_III_dose>          ?<td>mg/L
				<tr><td>Primary effluent [P]                 <td id=result_primary_eff_P>        ?<td>mg/L
				<tr><td>Fe dose required                     <td id=result_Fe_dose>              ?<td>kg/d
				<tr><td>Amount FeCl<sub>3</sub> solution     <td id=result_amount_FeCl3_solution>?<td>kg/d
				<tr><td>FeCl<sub>3</sub>        volume       <td id=result_FeCl3_volume>         ?<td>L/d
				<tr><td>FeCL<sub>3</sub> storage requirement <td id=result_storage_req_15_d>     ?<td>m<sup>3</sup>
				<tr><td>Additional sludge (precipitation)    <td id=result_Additional_sludge>    ?<td>kg/d
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
		/*INPUTS*/
		var Q                                = getInput('input_Q');
		var TSS                              = getInput('input_TSS');
		var TSS_removal_wo_Fe                = getInput('input_TSS_removal_wo_Fe');
		var TSS_removal_w_Fe                 = getInput('input_TSS_removal_w_Fe');
		var C_P_inf                          = getInput('input_C_P_inf');
		var C_PO4_inf                        = getInput('input_C_PO4_inf');
		var C_PO4_eff                        = getInput('input_C_PO4_eff');
		var Alkalinity                       = getInput('input_Alkalinity');
		var FeCl3_solution                   = getInput('input_FeCl3_solution');
		var FeCl3_unit_weight                = getInput('input_FeCl3_unit_weight');
		var days                             = getInput('input_days');

		/*PARAMETERS*/
		var Fe_P_mole_ratio = 3.3;
		var M_Fe = 55.845; //g/mol
		var M_P = 30.974; //g/mol
		var Raw_sludge_specific_gravity      = 1.03;
		var Raw_sludge_moisture_content      = 94;
		var Chemical_sludge_specific_gravity = 1.05
		var Chemical_sludge_moisture_content = 92.5;

		/*SOLUTION*/
			//1
			var Fe_III_dose = Fe_P_mole_ratio*(C_PO4_inf-C_PO4_eff)*M_Fe/M_P; //mg/L
			console.log(Fe_III_dose);
			//2
			var primary_eff_P = C_P_inf - (C_PO4_inf - C_PO4_eff); //mg/L
			console.log(primary_eff_P);
			//3
			var Fe_dose = Q*Fe_III_dose/1000; //kg/d
			console.log(Fe_dose); 
			//4
			var percent_Fe_in_FeCl3 = 100*M_Fe/162.3; //%
			console.log(percent_Fe_in_FeCl3); 
			var amount_FeCl3_solution = Fe_dose/percent_Fe_in_FeCl3*100; //kg/d
			console.log(amount_FeCl3_solution); 
			var FeCl3_volume = amount_FeCl3_solution/(FeCl3_solution/100*FeCl3_unit_weight); //L/d 
			console.log(FeCl3_volume); 
			var storage_req_15_d = FeCl3_volume/1000*days; //m3
			console.log(storage_req_15_d); 

			//5
			var Additional_sludge = 0.15*TSS*Q/1000; //kg/d   (? 0.15)
			console.log(Additional_sludge); 
			var Fe_dose_M = Fe_III_dose/1000/M_Fe; //M (mol/L)
			console.log(Fe_dose_M); 
			var P_removed = (C_PO4_inf - C_PO4_eff)/1000/M_P; //M(mol/L)
			console.log(P_removed); 
			var FeH2PO4OH_sludge = P_removed*251*1000; //mg/L (251 is FeH2PO4OH molecular weight)
			console.log(FeH2PO4OH_sludge);
			var Excess_Fe_added = Fe_dose_M - 1.6*P_removed; //M (mol/L) (? 1.6)
			console.log(Excess_Fe_added);
			var FeOH3_sludge = Excess_Fe_added*(106.8)*1000; //mg/L (106.8 is FeCl3 molecular weight)
			console.log(FeOH3_sludge);
			var Excess_sludge = FeH2PO4OH_sludge + FeOH3_sludge; //mg/L
			console.log(Excess_sludge);
			var Excess_sludge_kg = Q*Excess_sludge/1000; //kg/d
			console.log(Excess_sludge_kg);
			var Total_excess_sludge = Additional_sludge + Excess_sludge_kg; //kg/d
			console.log(Total_excess_sludge);

			//6
			var sludge_production_wo_chemical_addition = Q*TSS*0.6/1000; //kg/d (? 0.6)
			console.log(sludge_production_wo_chemical_addition);
			var sludge_production_w_chemical_addition = sludge_production_wo_chemical_addition + Total_excess_sludge; //kg/d
			console.log(sludge_production_w_chemical_addition);
			//7
			var Vs_without = sludge_production_wo_chemical_addition/(Raw_sludge_specific_gravity*1000*(1-Raw_sludge_moisture_content/100)); //m3/d
			console.log(Vs_without);
			//8
			var Vs = sludge_production_w_chemical_addition/(Chemical_sludge_specific_gravity*1000*(1-Chemical_sludge_moisture_content/100)); //m3/d
			console.log(Vs);
		//end solution

		//show results
		showResult('result_Fe_III_dose',Fe_III_dose);
		showResult('result_primary_eff_P',primary_eff_P);
		showResult('result_Fe_dose',Fe_dose);
		showResult('result_amount_FeCl3_solution',amount_FeCl3_solution);
		showResult('result_FeCl3_volume',FeCl3_volume);
		showResult('result_storage_req_15_d',storage_req_15_d);
		showResult('result_Additional_sludge',Additional_sludge);
		showResult('result_Fe_dose_M',Fe_dose_M);
		showResult('result_P_removed',P_removed);
		showResult('result_FeH2PO4OH_sludge',FeH2PO4OH_sludge);
		showResult('result_Excess_Fe_added',Excess_Fe_added);
		showResult('result_FeOH3_sludge',FeOH3_sludge);
		showResult('result_Excess_sludge',Excess_sludge);
		showResult('result_Excess_sludge_kg',Excess_sludge_kg);
		showResult('result_Total_excess_sludge',Total_excess_sludge);
		showResult('sludge_production_wo_chemical_addition',sludge_production_wo_chemical_addition);
		showResult('Vs_without',Vs_without);
		showResult('sludge_production_w_chemical_addition',sludge_production_w_chemical_addition);
		showResult('Vs',Vs);
	}
</script>

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
	</style>
</head><body onload="init()">

<!--title-->
<div>
	<h1>Metcalf &amp; Eddy, Wastewater Engineering, 5th ed, 2014</h1>
	<h2>Example 6-2 (p. 484)</h2>
	<h3 onclick=document.getElementById('enunciat').classList.toggle('invisible')>
		Determination of Ferric Chloride Dosage for Phosphorus Removal
	</h3><hr>
</div>

<!--problem statement-->
<div id=enunciat>
	<p>
		Determine the amount of ferric chloride required to precipitat phosphorus from untreated wastewater
		with the characteristics given below. Also determine the required ferric
		chloride storage capacity if a 15 d supply is to be stored at the treatment facility and the 
		added quantity of sludge generated from the ferric chloride addition.
	</p>
	<table>
		<tr><td>1. Q                                <td class=number>3800 <td>m3/d
		<tr><td>2. TSS                              <td class=number>220  <td>mg/L
		<tr><td>3. TSS removal without iron addition<td class=number>60   <td>%
		<tr><td>4. TSS removal with    iron addition<td class=number>75   <td>%
		<tr><td>5. Influent total P                 <td class=number>7    <td>g/m3
		<tr><td>6. Influent PO4(3-)                 <td class=number>5    <td>as mg P/L
		<tr><td>7. Effluent PO4(3-)                 <td class=number>0.1  <td>as mg P/L
		<tr><td>8. Wastewater alkalinity            <td class=number>240  <td>as mg CaCO3/L
		<tr><td>9. Ferric chloride solution         <td class=number>37   <td>%
		<tr><td>10. Ferric chloride, unit weight    <td class=number>1.35 <td>kg/L
		<tr><td>11. Raw sludge properties
		<tr><td>&emsp; Specific gravity             <td class=number>1.03
		<tr><td>&emsp; Moisture content             <td class=number>94   <td>%
		<tr><td>12. Chemical sludge properties (ch.13)
		<tr><td>&emsp; Specific gravity             <td class=number>1.05
		<tr><td>&emsp; Moisture content             <td class=number>92.5 <td>%
	</table>
</div><hr>

<!--implementation gui-->
<div style=display:none><h2>Implementation in Javascript</h2>
	<div> <button id=btn_calculate onclick=compute_exercise() style>Solve</button> </div>
	<ol class=flex>
		<li><div>Inputs</div>
			<table>
				<tr><td>TP              <td><input type=number id=input_TP value=6> g/m<sup>3</sup>
			</table>
		</li><li><div>Tabulated parameters</div>
			<table>
				<tr><td>Y<sub>H</sub>         <td class=number>0.45<td>g VSS/g bCOD
			</table>
		</li><li><div>Results</div>
			<table id=results>
				<tr><td>X<sub>b</sub>             <td class=number><span id=result_Xb>?</span><td>g/m<sup>3</sup>
			</table>
		</li>
	</ol>
</div>

implementation in progress

<!--implementation-->
<script>
	function compute_exercise(){
		/*INPUTS*/
		var Q = 3800;
		var TSS = 220;
		var TSS_removal_wo_Fe = 60;
		var TSS_removal_w_Fe = 75;
		var C_P_inf = 7;
		var C_PO4_inf = 5;
		var C_PO4_eff = 0.1;
		var Alkalinity = 240;
		var FeCl3_solution = 37;
		var FeCl3_unit_weight = 1.35;

		/*PARAMETERS*/
		var M_Fe = 55.845; //g/mol
		var M_P = 30.974; //g/mol
		var days=15;

		/*SOLUTION*/
		//1
		var Fe_P_mole_ratio = 3.3;
		var Fe_III_dose = Fe_P_mole_ratio*(C_PO4_inf-C_PO4_eff)*M_Fe/M_P; //mg/L
		console.log(Fe_III_dose);
		//2
		var primary_eff_P = C_P_inf - (C_PO4_inf - C_PO4_eff); //mg/L
		console.log(primary_eff_P);
		//3
		var Fe_dose = Q * Fe_III_dose / 1000; //kg/d
		console.log(Fe_dose); 
		//4
		var percent_Fe_in_FeCl3 = 100*M_Fe/162.3; //%
		console.log(percent_Fe_in_FeCl3); 
		var amount_FeCl3_solution = Fe_dose / percent_Fe_in_FeCl3 * 100; //kg/d
		console.log(amount_FeCl3_solution); 
		var FeCl3_volume = amount_FeCl3_solution/(FeCl3_solution/100*FeCl3_unit_weight); //L/d 
		console.log(FeCl3_volume); 
		var storage_req_15_d = FeCl3_volume/1000*days; //m3
		console.log(storage_req_15_d); 
		//5
		var Additional_sludge = 0.15*TSS*Q/1000; //kg/d   (? 0.15)
		console.log(Additional_sludge); 
		var Fe_dose_bis = 0;
		console.log(Fe_dose_bis); 
	}

</script>

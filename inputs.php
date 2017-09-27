<!doctype html><html><head>
	<?php include'imports.php'?>
	<script>
		var Technologies=[
			{name:"Aerobic   &mdash; BOD "},
			{name:"Aerobic   &mdash; BOD + nitrification"},
			{name:"Aerobic   &mdash; BOD + nitrification + denitrification"},
			{name:"Aerobic   &mdash; BOD + nitrification + denitrification + BioP"},
			{name:"Aerobic   &mdash; BOD + nitrification + denitrification + ChemP"},
			{name:"Aerobic   &mdash; BOD + BioP"},
			{name:"Aerobic   &mdash; BOD + ChemP"},
			{name:"Anaerobic &mdash; No polishing"},
		];
		var Inputs=[
			{name:"Q",    unit:"m3/d", default:22700},
			{name:"T",    unit:"ºC",   default:12},
			{name:"COD",  unit:"g/m3", default:300},
			{name:"sCOD", unit:"g/m3", default:132},
			{name:"BOD",  unit:"g/m3", default:140},
			{name:"TKN",  unit:"g/m3", default:35},
			{name:"TP",   unit:"g/m3", default:6},
			{name:"TS",   unit:"g/m3", default:0},
			{name:"TSS",  unit:"g/m3", default:70},
			{name:"VSS",  unit:"g/m3", default:60},
		];
		var DesignParameters=[
			{name:"Ne",      unit:"g/m3"},
			{name:"NOx,e",   unit:"g/m3"},
			{name:"PO4,e",   unit:"g/m3"},
		];
	</script>
</head><body>
<h1>Inputs &mdash; single WWTP</h1><hr>

<!--select technology-->
<div>
	<p>1. Select technology</p>
	<table id=technology border=1></table>
	<script>
		var table=document.querySelector('table#technology');
		Technologies.forEach(input=>{
			var newRow=table.insertRow(-1);
			newRow.insertCell(-1).innerHTML="<label><input type=radio name=selected_tech> "+input.name+"</label>";
		})
	</script>
</div><hr>

<!--select primary treatment-->
<div>
	<p>2. Primary treatment exists?</p>
	<table border=1>
		<tr><td><label><input type=radio name=primary_treatment checked> No
			<small>(influent COD fractions use raw wastewater)</small>
		<tr><td><label><input type=radio name=primary_treatment> Yes
			<small>(influent COD fractions use primary effluent)</small>
		</tr>
	</table>
</div><hr>

<!--enter inputs-->
<div>
	<p>3. Influent wastewater flow and composition</p>
	<table id=inputs border=1>
		<tr><th>Compound<th>Unit<th>Value
	</table>
	<script>
		var table=document.querySelector('table#inputs');
		Inputs.forEach(input=>{
			var newRow=table.insertRow(-1);
			newRow.insertCell(-1).innerHTML=input.name;
			newRow.insertCell(-1).innerHTML=input.unit;
			newRow.insertCell(-1).innerHTML="<input type=number value='"+input.default+"'>";
		})
	</script>
</div><hr>

<!--enter design parameters-->
<div>
	<p>4. Design parameters</p>
	<table id=design_parameters border=1>
		<tr><th>Parameter<th>Unit<th>Value
	</table>
	<script>
		var table=document.querySelector('table#design_parameters');
		DesignParameters.forEach(input=>{
			var newRow=table.insertRow(-1);
			newRow.insertCell(-1).innerHTML=input.name;
			newRow.insertCell(-1).innerHTML=input.unit;
			newRow.insertCell(-1).innerHTML="<input type=number value=0>";
		})
	</script>
</div><hr>

<!--end of the page-->
<div>
	<a href=outputs.php>Outputs</a>
</div>

<style>
	table {
	}
	th, td {
		padding:0.2em;
	}
</style>

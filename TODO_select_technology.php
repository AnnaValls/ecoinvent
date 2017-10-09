<?php include'navbar.php'?>

<!--select technology-->
<div>
	<p>1. Select technology combination for your treatment plant</p>
	<table id=technology border=1>
		<tr>
	</table>
	<script>
		/*
		 * Structure: technologies
		 */
		var Technologies=[
			{name:"Aerobic: BOD"},
			{name:"Aerobic: BOD + Nitrification"},
			{name:"Aerobic: BOD + Nitrification + Denitrification"},
			{name:"Aerobic: BOD + Nitrification + Denitrification + Bio P removal"},
			{name:"Aerobic: BOD + Nitrification + Denitrification + Chem P removal"},
			{name:"Aerobic: BOD + Bio P removal"},
			{name:"Aerobic: BOD + Chem P removal"},
			{name:"Anaerobic: No polishing"},
		];
	</script>
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

<a href=elementary.php>Next</a>

<style>
	#root table tr:hover{
		background:#eee;
	}
	label{
		display:block;
		cursor:pointer;
	}
	#root th, td {
		padding:0.15em;
	}
</style>

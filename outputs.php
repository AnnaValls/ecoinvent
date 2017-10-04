<!doctype html><html><head>
	<?php include'imports.php'?>
	<script>
		var Outputs=[
			{name:"COD",  },
			{name:"CO2",  },
			{name:"TKN",  },
			{name:"NOx",  },
			{name:"N2",   },
			{name:"N2O",  },
			{name:"TP",   },
			{name:"TS",   },
			{name:"CH4",  },
		];
	</script>
</head><body>
<h1>Outputs &mdash; single WWTP</h1><hr>

<!--outputs-->
<div>
	<table id=outputs border=1 cellpadding=2>
		<tr>
			<th rowspan=2>Compound
			<th rowspan=2>Influent (g/d)
			<th colspan=3>Effluent (g/d)
		</tr>
		<tr>
			<th>Water<th>Air<th>Sludge
	</table>
	<script>
		var table=document.querySelector('table#outputs');
		Outputs.forEach(output=>{
			var newRow=table.insertRow(-1);
			newRow.insertCell(-1).innerHTML=output.name
				.replace('O2','O<sub>2</sub>')
				.replace('N2','N<sub>2</sub>')
				.replace('CH4','CH<sub>4</sub>');

			newRow.insertCell(-1).innerHTML="10";
			newRow.insertCell(-1).innerHTML="5";
			newRow.insertCell(-1).innerHTML="3";
			newRow.insertCell(-1).innerHTML="2";
		})
	</script>
</div><hr>

<!--mass balances-->
<div>
	mass balances table here
</div><hr>

<a href=inputs.php>Inputs</a>

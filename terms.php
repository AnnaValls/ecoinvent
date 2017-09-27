<!doctype html><html><head>
	<?php include'imports.php'?>
	<script>
		var Terms=[
			{name:"BOD", definition:"Total 5d biochemical oxygen demand"},
			{name:"sBOD", definition:"Soluble BOD"},
			{name:"UBOD", definition:"Ultimate biochemical oxygen demand"},
			{name:"COD", definition:"Total chemical oxygen demand"},
			{name:"bCOD", definition:"Biodegradable COD"},
			{name:"pCOD", definition:"Particulate COD"},
			{name:"sCOD", definition:"Soluble COD"},
			{name:"nbCOD", definition:"Nonbiodegradable COD"},
			{name:"rbCOD", definition:"Readily biodegradable COD"},
			{name:"bsCOD", definition:"Biodegradable soluble COD"},
			{name:"b_col_COD", definition:"Biodegradable colloidal COD"},
			{name:"sbCOD", definition:"Slowly biodegradable COD"},
			{name:"bpCOD", definition:"Biodegradable particulate COD"},
			{name:"npbCOD", definition:"Nonbiodegradable particulate COD"},
			{name:"nbsCOD", definition:"Nonbiodegradable soluble COD"},
			{name:"TKN", definition:"Total Kjedahl nitrogen"},
			{name:"bTKN", definition:"Biodegradable TKN"},
			{name:"sTKN", definition:"Soluble TKN"},
			{name:"ON", definition:"Organic N"},
			{name:"NH4-N", definition:"Ammonia N"},
			{name:"bON", definition:"Biodegradable ON"},
			{name:"nbON", definition:"Nonbiodegradable ON"},
			{name:"pON", definition:"Particulate ON"},
			{name:"bpON", definition:"Biodegradable particulate ON"},
			{name:"nbpON", definition:"Nonbiodegradable particulate ON"},
			{name:"sON", definition:"Soluble ON"},
			{name:"bsON", definition:"Biodegradable soluble ON"},
			{name:"nbsON", definition:"Nonbiodegradable soluble ON"},
			{name:"TP", definition:"Total P"},
			{name:"PO4", definition:"Orthphosphate"},
			{name:"bpP", definition:"Biodegradable particulate P"},
			{name:"nbpP", definition:"Nonbiodegradable particulate P"},
			{name:"bsP", definition:"Biodegradable soluble P"},
			{name:"nbsP", definition:"Nonbiodegradable soluble P"},
			{name:"TSS", definition:"Total suspended solids"},
			{name:"VSS", definition:"Volatile suspended solids"},
			{name:"nbVSS", definition:"Nonbiodegradable volatile suspended solids"},
			{name:"iTSS", definition:"Inter total suspended solids"},
		];
	</script>
</head><body>
<h1>Summary of terms</h1>
<h3>Page 708, Table 8-2, Metcalf &amp; Eddy</h3>

<!--main table-->
<table id=terms>
	<tr><th>Constituent<th>Definition
</table>

<!--table filling script-->
<script>
	(function(){
		var table=document.querySelector('table#terms');
		Terms.forEach(term=>{
			var newRow=table.insertRow(-1);
			newRow.insertCell(-1).innerHTML=term.name;
			newRow.insertCell(-1).innerHTML=term.definition;
		});
	})();
</script>

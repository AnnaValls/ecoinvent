<!doctype html><html><head> <?php include'imports.php'?>
</head><body>
<?php include'navbar.php'?>
<div id=root>

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
			newRow.insertCell(-1).innerHTML=term.descr;
		});
	})();
</script>

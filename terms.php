<!doctype html><html><head> <?php include'imports.php'?>
</head><body>
<?php include'navbar.php'?>
<div id=root>

<h1>Summary of terms</h1>
<h3>Page 708, Table 8-2, Metcalf &amp; Eddy</h3>

<p>
  <small>Note: not all terms listed here are used in the model's equations</small>
</p>

<!--main table-->
<table id=terms>
	<tr><th>Constituent<th>Definition
</table>

<!--table filling script-->
<script>
	(function(){
		var table=document.querySelector('table#terms');
		for(t in Terms){
			var term=Terms[t];
			var newRow=table.insertRow(-1);
			newRow.insertCell(-1).innerHTML=t;
			newRow.insertCell(-1).innerHTML=term.descr;
		};
	})();
</script>

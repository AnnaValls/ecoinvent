<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Ecoinvent</title>
	<!--css at the end-->
</head><body>
<?php include'navbar.php'?>

<div id=root>

<p style=max-width:50em>
	<p style=max-width:50em>
		This is a placeholder for drafting the interface 
		that will request the user's inputs.
		<br>
		The goal is to have a functional backend, and at the end implement a pretty design on top of it.
		<hr>
	</p>

	<div>
		<p>Web parts:</p>
		<ul>
			<li>Single plant configuration
				<ul>
					<li><a href=inputs.php     >1. Select technology combination</a>
					<li><a href=elementary.php >2. Inputs &amp; outputs: elementary flows</a>
					<li><a href=construction   >3. Construction materials   </a>
					<li>4. Chemicals consumed (pending)
					<li>5. Energy consumed (pending)
					<li>6. Generate ecoSpold (pending, connection with python code)
				</ul>
			</li>
			<li>Appendix: <a href=terms.php>Terms</a>
			<li><a href=techs/tests.php>Tests</a>
			<li><a href=future>Future implementations (for "n" WWTPs)</a>
		</ul>
		<hr>
	</div>

	<div>
		<p>Metcalf &amp; Eddy, Wastewater Engineering, 5th ed., 2014, implementations:</p>
		<table style=margin-left:10px border=1>
			<tr><th> <th>Technology<th>Coding status
			<tr>
				<td>0.
				<td><a href="implementations/bod_removal_only.php">BOD removal [example]</a>
				<td>Done
			<tr>
				<td>1.
				<td><a href="implementations/bod_removal_with_nitrification.php">BOD removal w/ &amp; w/o nitrification</a>
				<td>Done
			<tr>
				<td>2.
				<td><a href="implementations/N_removal.php">N removal</a>
				<td>Done
			<tr>
				<td>3.
				<td><a href="implementations/chem_P_removal.php">P removal (chemically)</a>
				<td>Done
			<tr>
				<td>4.
				<td><a href="implementations/bio_P_removal.php">P removal (biologically)</a>
				<td>Done
			<tr>
				<td>5.
				<td><a href="implementations/ekama_sizing.php">Reactor sizing (optim. cost) [G. Ekama]</a>
				<td>Done
			<tr>
				<td>6.
				<td><a href="elementary.php">Elementary flows factors</a>
				<td>In progress as <?php echo date("M-d-Y")?>
			<tr>
				<td>7.
				<td><a>Simple Treat flows factors</a>
				<td>Pending
			</tr>
		</table>
	</div><hr>

	<div>
		<p>Other things:</p>
		<ul>
			<li><a href=docs>Documents</a>
			<li>
				<a target=_blank href="https://docs.google.com/spreadsheets/d/1DiBhDCjxGyw2-umImIfHiZOzY5LJF_psGiD4fEf7Wgk/edit?usp=sharing">
					Google Drive document 
				</a>
			</li>
			<li>This web source code: <a href=//github.com/holalluis/ecoinvent>github.com/holalluis/ecoinvent</a>
			<li>Guillaume's github (for ecoSpold): 
				<a href="//github.com/ecoinvent/wastewater_treatment_tool">github.com/ecoinvent/wastewater_treatment_tool</a>
			</li>
		</ul>
	</div><hr>

	<div>
		ICRA people:
		<ul>
			<li><a target=_blank href=mailto:lbosch@icra.cat>lbosch@icra.cat</a> (Lluís Bosch, ICRA software developer)
			<li><a target=_blank href=mailto:lcorominas@icra.cat>lcorominas@icra.cat</a> (Lluís Corominas, ICRA coordinator)
		</ul>
	</div><hr>
</p>

<!--styles-->
<style>
	/*general*/
	body{
		font-family:sans-serif;
		margin:0;
	}
	h1{
		margin-top:5px;
		font-weight:normal;
	}
	h2{
		font-weight:normal;
	}
	table th{
		border-bottom:1px solid #ccc;
	}

	/*lists*/
	ol{	
		counter-reset:item;
	}
	ol li{
		display:block;
	}
	ol li:before{
		content:counters(item,".") ". "; 
		counter-increment:item;
		font-family:monospace;
	}
	#root {
		margin:5px;
	}
	#root > li {
		margin-top:0.5em;
	}
	#root > li > b{
		font-size:17px;
	}

	.description {
		display:inline-block;
		width:350px;
		font-size:12px;
	}
</style>

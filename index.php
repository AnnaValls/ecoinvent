<!doctype html><html><head>
	<?php include'imports.php'?>
	<!--css styles are at the end-->
	<title>Ecoinvent</title>
</head><body>
<?php include'navbar.php'?>

<div id=root>
<h1>Main menu</h1>

<p style=max-width:50em>
	<p style=max-width:50em>
		This is a placeholder for drafting the user interface.
		The goal is to have a functional backend first, and then implement a 'pretty design' on top of it.
		<hr>
	</p>

	<!--web parts-->
	<div>
		<p><b>Web parts</b></p>
		<ul>
			<li>
				Single plant
				<ul>
					<li><a href=elementary.php >1. [in progress] Elementary flows factors </a>
					<li><a                     >2. [on hold] Simple Treat flows factors </a>
					<li><a href=construction   >3. [done] Construction materials </a>
					<li><a                     >4. [pending] Chemicals consumed 
					<li><a                     >5. [pending] Energy consumed 
					<li><a                     >6. [next] Generate ecoSpold 
				</ul>
			</li>
			<li>
				Appendix
				<ul>
					<li><a href=inputs.php       >All inputs</a>
					<li><a href=technologies.php >All technologies</a>
					<li><a href=terms.php        >All terms</a>
				</ul>
			</li>
			<li><a href=future           >Future implementations (for 'n' plants)</a>
			<li><a href=README.txt       >README (tasks)</a>
		</ul><hr>
	</div>

	<!--implementations-->
	<div>
		<p><b>Metcalf &amp; Eddy, Wastewater Engineering, 5th ed., 2014, technologies implemented:</b></p>
		<table style=margin-left:10px border=1>
			<tr><th>Technology<th>Coding status
			<tr>
				<td>0. <a href="implementations/bod_removal_only.php">BOD removal [example]</a>
				<td>Done
			<tr>
				<td>1. <a href="implementations/bod_removal_with_nitrification.php">BOD removal w/ &amp; w/o nitrification</a>
				<td>Done
			<tr>
				<td>2. <a href="implementations/N_removal.php">N removal</a>
				<td>Done
			<tr>
				<td>3. <a href="implementations/chem_P_removal.php">P removal (chemically)</a>
				<td>Done
			<tr>
				<td>4. <a href="implementations/bio_P_removal.php">P removal (biologically)</a>
				<td>Done
			<tr>
				<td>5. <a href="implementations/ekama_sizing.php">Reactor sizing (optim. cost) [G. Ekama]</a>
				<td>Done
			<tr>
				<td colspan=2 align=center><a href="techs/tests.php">Implementation Tests</a>
			</tr>
		</table>
	</div><hr>

	<!--other things-->
	<div>
		<p><b>Other things:</b></p>
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
</p>

<!--css-->
<style>
	body{
		margin:0;
	}
	#root {
		margin:8px;
	}
</style>

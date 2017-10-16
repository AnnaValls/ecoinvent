<!doctype html><html><head>
	<?php include'imports.php'?>
	<!--css styles are at the end-->
	<title>Ecoinvent</title>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Home page</h1>
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
					<li><a href=elementary.php  >1. [IN PROGRESS] Elementary flows (C, N, P &amp; S) [standalone (from pdf)]
					<li><a href=elementary2.php >1. [IN PROGRESS] Elementary flows (C, N, P &amp; S) [COMPLETE (from metcalf implementations)]
					<li><a href=construction.php>2. [DONE]        Construction materials
					<li><a		                  >3. [PENDING]     Chemicals consumed
					<li><a		                  >4. [PENDING]     Energy consumed
					<li><a href=ecospold.php    >5. [IN PROGRESS] Generate ecoSpold
					<li><a                      >6. [ON HOLD]     Simple Treat flows
				</ul>
			</li>
			<li>
				Appendix
				<ul>
					<li><a href=inputs.php      >All inputs</a>
					<li><a href=technologies.php>All technologies</a>
					<li><a href=IO.php          >I/O overview</a>
					<li><a href=terms.php       >All terms</a>
				</ul>
			</li>
			<li><a href=README.txt>README (tasks)</a>
			<li><a href=future    >Future implementations (for 'n' plants)</a>
		</ul>
	</div><hr>

	<!--implementations-->
	<div>
		<p><b>Metcalf &amp; Eddy, Wastewater Engineering, 5th ed., 2014, technologies implemented:</b></p>
		<table style=margin-left:10px border=1>
			<tr><th>Technology<th>Coding status
			<tr>
				<td>0. <a href="implementations/bod_removal_only.php">BOD removal example</a>
				<td>Done
			<tr>
				<td>1. <a href="implementations/bod_removal_with_nitrification.php">BOD removal w/ &amp; w/o nitrification</a>
				<td>Done
			<tr>
				<td>2. <a href="implementations/N_removal.php">N removal</a>
				<td>Done
			<tr>
				<td>3. <a href="implementations/bio_P_removal.php">P removal (biologically)</a>
				<td>Done
			<tr>
				<td>4. <a href="implementations/chem_P_removal.php">P removal (chemically)</a>
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
				<ul>
					<li>
						<a href="https://github.com/ecoinvent/wastewater_treatment_tool/blob/master/Generating%20ecoSPold%20files%20for%20WWT.ipynb">
							ecospold notebook
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</div><hr>
</p>

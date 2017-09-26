<!doctype html><html><head>
	<?php include'imports.php'?>
</head><body>

<!--navbar--><?php include'navbar.php'?>

<!--root-->
<div id=root> 
	<h2>Activity</h2>

	<div>
		<table>
			<tr>
				<td>Activity
				<td>Steel, RER
			</tr>
			<tr>
				<td>Q (m3/d)
				<td><input value=1000>
			</tr>
			<tr>
				<td>Load per country (%)
				<td><input value="80% CH, 20% ES">
			</tr>
			<tr>
				<td colspan=2>Wastewater components
					<table>
						<tr><th>Compound<th>g/m3
						<tr><td>COD<th><input>
						<tr><td>BOD<th><input>
						<tr><td>COD<th><input>
						<tr><td>TP<th><input>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<hr>
	<div>
		<a href="2-general.php">Back</a>
		<a href="4-ww.php">Next</a>
	</div>

</div>

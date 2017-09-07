<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="ecoinvent">
	<title>WWTP configuration</title>
	<style>
		body div{
			border-bottom:1px solid #ccc;
			padding-bottom:5px;
			margin-bottom:5px;
		}
	</style>
</head><body>

<!--title-->
<div>
	<h1>
		WWTP Configuration
	</h1> 
</div>

<div>
	<h3>1. Primary treatment</h3>
	<table>
		<tr><td><label> <input type=checkbox> Primary clarification </label>
		<tr><td><label> <input type=checkbox> Chemical addition </label>
	</table>
</div>

<div>
	<h3>2. Secondary treatment</h3>
	<table>
		<tr><td> <label><input name=sec_conf type=radio> BOD<sub>5</sub> removal</label>
		<tr><td> <label><input name=sec_conf type=radio> BOD<sub>5</sub> removal &amp; Nitrification</label>
		<tr><td> <label><input name=sec_conf type=radio> BOD<sub>5</sub> removal &amp; Nitrification &amp; N removal</label>
		<tr><td> <label><input name=sec_conf type=radio> BOD<sub>5</sub> removal &amp; Nitrification &amp; N removal &amp; P removal</label>
		<tr><td> <label><input name=sec_conf type=radio> BOD<sub>5</sub> removal &amp; P removal</label>
	</table>
</div>

<div>
	<h3>3. Sludge treatment unit processes</h3>
	<ul>
		<li><label><input type=checkbox> Gravity thickening</label>
		<li><label><input type=checkbox> Conditioning: coagulant and polymer addition</label>
		<li>
			<b>Digestion</b>
			<ul>
				<li><label><input type=checkbox> Anaerobic digestion</label>
				<li><label><input type=checkbox> Aerobic digestion</label>
			</ul>
		</li>
		<li>
			<b>Dewatering</b>
			<ul>
				<li><label><input type=checkbox> Centrifugation</label>
				<li><label><input type=checkbox> Filter pressing</label>
				<li><label><input type=checkbox> Vacuuming</label>
			</ul>
		</li>
		<li>
			<b>Nutrient treatment and recovery</b>
			<ul>
				<li><label><input type=checkbox> Struvite formation</label>
				<li><label><input type=checkbox> Anammox</label>
			</ul>
		</li>
		<li>
			<b>Drying</b>
			<ul>
				<li><label><input type=checkbox> Sludge beds</label>
				<li><label><input type=checkbox> Heat drying</label>
			</ul>
		</li>
		<li>
			<b>Sludge disposal</b>
			<ul>
				<li><label><input type=checkbox> Composting</label>
				<li><label><input type=checkbox> Land application</label>
				<li><label><input type=checkbox> Landfilling</label>
				<li><label><input type=checkbox> Incineration</label>
			</ul>
		</li>
	</ul>
</div>

<div>
	<button>Save</button>
</div>


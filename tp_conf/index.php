<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="ecoinvent">
	<title>WWTP configuration</title>
	<style>
		div[id]{
			border-bottom:1px solid #ccc;
			padding-bottom:5px;
			margin-bottom:5px;
		}
	</style>
</head><body>

<h1>WWTP Configuration</h1>

<!--
<div class=tab_buttons>
	<style>
		/*tab buttons*/
			div.tab_buttons               { padding:0.5em 0;display:flex;justify-content:center}
			div.tab_buttons button        { display:block;padding:6px 10px;border:1px solid #ccc;background:#f5f5f5;outline:none;}
			div.tab_buttons button:hover  { background:#e6e6e6}
			div.tab_buttons button.left   { border-radius:0.5em 0.0em 0.0em 0.5em; border-right-style:none}
			div.tab_buttons button.right  { border-radius:0.0em 0.5em 0.5em 0.0em; }
			div.tab_buttons button.middle { border-right-style:none}
			div.tab_buttons button.single { border-radius:0.5em}
			div.tab_buttons button[disabled] { background-color:#ccc;box-shadow:inset 0 2px 4px rgba(0,0,0,.15),0 1px 2px rgba(0,0,0,.05);}
		/*tab buttons*/
	</style>
	<button class=left>Primary</button>
	<button class=middle>Secondary</button>
	<button class=right>Tertiary</button>
</div>
-->

<div id=primary class=tab>
	<h3>1. Primary treatment</h3>
	<ul>
		<li><input type=checkbox> Primary clarification
		<li><input type=checkbox> Chemical addition
	</ul>
</div>

<div id=secondary class=tab>
	<h3>2. Secondary treatment</h3>
	<table>
		<tr><td><input name=sec_conf type=radio><td>BOD<sub>5</sub> removal
		<tr><td><input name=sec_conf type=radio><td>BOD<sub>5</sub> removal &amp; Nitrification
		<tr><td><input name=sec_conf type=radio><td>BOD<sub>5</sub> removal &amp; Nitrification &amp; N removal
		<tr><td><input name=sec_conf type=radio><td>BOD<sub>5</sub> removal &amp; Nitrification &amp; N removal &amp; P removal
		<tr><td><input name=sec_conf type=radio><td>BOD<sub>5</sub> removal &amp; P removal
	</table>
</div>

<div id=sludge class=tab>
	<h3>3. Sludge treatment unit processes</h3>
	<ul>
		<li><input type=checkbox> Gravity thickening
		<li><input type=checkbox> Conditioning: coagulant and polymer addition
		<li>
			<b>Digestion</b>
			<ul>
				<li><input type=checkbox> Anaerobic digestion
				<li><input type=checkbox> Aerobic digestion
			</ul>
		</li>
		<li>
			<b>Dewatering</b>
			<ul>
				<li><input type=checkbox> Centrifugation
				<li><input type=checkbox> Filter pressing
				<li><input type=checkbox> Vacuuming
			</ul>
		</li>
		<li>
			<b>Nutrient treatment and recovery</b>
			<ul>
				<li><input type=checkbox> Struvite formation
				<li><input type=checkbox> Anammox
			</ul>
		</li>
		<li>
			<b>Drying</b>
			<ul>
				<li><input type=checkbox> Sludge beds
				<li><input type=checkbox> Heat drying
			</ul>
		</li>
		<li>
			<b>Sludge disposal</b>
			<ul>
				<li><input type=checkbox> Composting
				<li><input type=checkbox> Land application
				<li><input type=checkbox> Landfilling
				<li><input type=checkbox> Incineration
			</ul>
		</li>
	</ul>
</div>

<div>
	<button>Save</button>
</div>

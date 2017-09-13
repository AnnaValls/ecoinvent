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
		<tr><td><label><input name=sec_conf type=radio> BOD<sub>5</sub> removal</label>
		<tr><td><label><input name=sec_conf type=radio> BOD<sub>5</sub> removal &amp; Nitrification</label>
		<tr><td><label><input name=sec_conf type=radio> BOD<sub>5</sub> removal &amp; Nitrification &amp; N removal</label>
		<tr><td><label><input name=sec_conf type=radio> BOD<sub>5</sub> removal &amp; Nitrification &amp; N removal &amp; P removal</label>
		<tr><td><label><input name=sec_conf type=radio> BOD<sub>5</sub> removal &amp; P removal</label>
	</table>
</div>

<div>
	<button>Save</button>
</div>


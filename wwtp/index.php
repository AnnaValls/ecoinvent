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
	<h3>2. Secondary treatment (enter percentage of treated flow with each technology)</h3>
	<table>
		<tr> <td> 
			<input value=0 type=number min=0> (m3/d)
			Total treated flow 
		</tr>
		<tr><td> <input type=number value=0 min=0 max=100> % &mdash; BOD<sub>5</sub> removal
		<tr><td> <input type=number value=0 min=0 max=100> % &mdash; BOD<sub>5</sub> removal &amp; Nitrification
		<tr><td> <input type=number value=0 min=0 max=100> % &mdash; BOD<sub>5</sub> removal &amp; Nitrification &amp; N removal
		<tr><td> <input type=number value=0 min=0 max=100> % &mdash; BOD<sub>5</sub> removal &amp; Nitrification &amp; N removal &amp; P removal
		<tr><td> <input type=number value=0 min=0 max=100> % &mdash; BOD<sub>5</sub> removal &amp; P removal
	</table>
</div>

<div>
	<button>Save</button>
</div>


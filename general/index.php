<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="ecoinvent">
	<title>General configuration</title>
	<!--imports-->
	<script src="geographies.js"></script>
</head><body>
<h1>General configuration</h1>
<h2>Geography characteristics</h2>

<ul>
	<li><span>Country</span> 
		<select>
			<script>
				//write file 'geographies.js'
				Geographies.forEach(g=>{
					document.write("<option value='"+g.shortcut+"'>"+g.name)
				});
			</script>
		</select>
	</li>
	<li><span>Population equivalents in terms of BOD<sub>5</sub> loading</span> <input value=1000>
	<li>
		<span>Temperature</span>
		<select> <option>range 1 <option>range 2 <option>[...] </select>
	</li>
	<li>
		<span >Rainfall</span>
		<select> <option>range 1 <option>range 2 <option>[...] </select>
	</li>
	<li>
		<span >Unit per capita domestic pollution loading </span>
		<input value=0>
	</li>
	<li>
		<span >Unit pollution loading from industrial sources</span>
		<input value=0>
	</li>
	<li>
		<span >Water dilution from rainfall, snowmelt</span>
		<input value=0>
	</li>
	<li>
		????
		<input value=0>
	</li>
</ul>

<button>Save</button>

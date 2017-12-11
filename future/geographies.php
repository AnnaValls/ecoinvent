<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="ecoinvent">
	<title>General configuration</title>
	<!--imports-->
	<script src="geographies.js"></script>
</head><body>

<h1>General configuration</h1>
<h2>Geography characteristics</h2> <hr>

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
</ul>

<hr><div><button>Save</button></div>

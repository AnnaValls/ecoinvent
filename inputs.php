<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Inputs</title>
</head><body>
<?php include'navbar.php'?>
<div id=root>

<h1>
	All Inputs
	(<span id=Inputs_length></span>)
	<script>
		document.querySelector('#Inputs_length').innerHTML=Inputs.length
	</script>
</h1>
<p>Move the mouse over an input to see the description</p>

<!--tables-->
<div class=flex>
	<!--inputs-->
	<div>
		<table id=inputs border=1>
			<tr><th>Input<th>Default value<th>Unit<th>Required by <a href=technologies.php>technologies</a>
		</table>
		<script>
			//fill inputs table
			(function()
			{
				function inputRequiredBy(id)
				{
					var ret=[];
					for(var tec in Technologies)
					{
						if(Technologies[tec].Inputs.indexOf(id)+1)
						{
							ret.push(tec)
						}
					}
					return ret;
				}

				var t=document.querySelector('#inputs');
				Inputs.forEach(input=>{
					var newRow=t.insertRow(-1);
					newRow.classList.add('help');
					newRow.title=input.descr;
					newRow.insertCell(-1).innerHTML=input.id;
					newRow.insertCell(-1).innerHTML=input.value;
					newRow.insertCell(-1).outerHTML="<td class=unit>"+input.unit
						.replace('m3','m<sup>3</sup>')
						.replace('m2','m<sup>2</sup>')
						.replace('O2','O<sub>2</sub>')
						.replace('O3','O<sub>3</sub>')
						.replace(/_/g,' ')
						;
					newRow.insertCell(-1).innerHTML=(function(){
						var techs=inputRequiredBy(input.id);
						return techs.toString().replace(/,/g,', ');
					})();
				});
			})();
		</script>
	</div>

	<div>&emsp;</div>

	<!--legend-->
	<div>
		<table id=legend border=1>
			<tr><th colspan=2>Legend
		</table>
		<script>
			//fill legend table
			(function(){
				var t=document.querySelector('#legend');
				for(var tec in Technologies) {
					var el=Technologies[tec];
					var newRow=t.insertRow(-1);
					newRow.insertCell(-1).outerHTML="<th>"+tec;
					newRow.insertCell(-1).innerHTML=el.Name;
				}
			})();
		</script>
	</div>
</div>

<style>
	#inputs, #legend {
		font-family:monospace;
	}
	th {
		background:#eee;
	}
	.help:hover {
		text-decoration:underline;
	}
</style>

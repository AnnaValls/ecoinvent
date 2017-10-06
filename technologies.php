<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Technologies</title>
	<!--css at the end-->
</head><body>

(in development)

<h1>All Technologies</h1>
pending: insert to table links to code:
<ul>
	<li>bio_P_removal.js
	<li>bod_removal_only.js
	<li>chem_P_removal.js
	<li>n_removal.js
	<li>nitrification.js
	<li>sst_sizing.js
</ul>

<div>
	<table id=technologies border=1>
		<tr><th>Technology<th>Name<th><a href=inputs.php>Inputs</a> required
	</table>
	<script>
		//fill technologies table
		(function(){
			var t=document.querySelector('#technologies');
			for(var tec in Technologies)
			{
				var el=Technologies[tec];
				var newRow=t.insertRow(-1);
				newRow.insertCell(-1).innerHTML=tec;
				newRow.insertCell(-1).innerHTML=el.Name;
				newRow.insertCell(-1).innerHTML=( ()=>{
					var str=[]
					el.Inputs.forEach(i=>{
						str.push("<span class=help title='"+getInputById(i).descr+"'>"+i+"</span>")
					});
					return str.join(', ');
				})();
			}
		})();
	</script>
</div>

<h1>All Technology combinations</h1>
<div>
	<table id=combinations border=1>
		<tr><th>Combination<th><a href=inputs.php>Inputs</a> required
	</table>
	<script>
		//fill technologies table
		(function(){
			var t=document.querySelector('#combinations');
			Combinations.forEach(com=>
			{
				var newRow=t.insertRow(-1);
				newRow.insertCell(-1).innerHTML=com.join('+');
				newRow.insertCell(-1).innerHTML=(function()
				{
					var inputs = [ ];
					com.forEach(tec=>
					{
						inputs=inputs.concat(Technologies[tec].Inputs);
					});
					var ret=[];
					uniq(inputs).forEach(i=>
					{
						ret.push("<span class=help title='"+getInputById(i).descr+"'>"+i+"</span>")
					});
					return ret.join(', ');
				})();
			});
		})();
	</script>
</div>

<style>
	#technologies, #combinations {
		font-family:monospace;
	}
	span.help:hover {
		text-decoration:underline;
	}
</style>

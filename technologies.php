<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Technologies</title>
	<!--css at the end-->
</head><body>
<?php include'navbar.php'?>
<div id=root>

<!--technologies table-->
<h1>All Technologies</h1>
<div>
	<table id=technologies border=1>
		<tr><th>Technology<th>Name<th>Implemented in<th><a href=inputs.php>Inputs</a> required
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
				newRow.insertCell(-1).innerHTML="<a href='techs/"+el.File+"'>"+el.File+"</a>";
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

<!--technologt combinations table-->
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
					return uniq(inputs).length+": "+ret.join(', ');
				})();
			});
		})();
	</script>
</div>

<!--css-->
<style>
	#technologies, #combinations {
		font-family:monospace;
	}
	span.help:hover {
		text-decoration:underline;
	}
</style>

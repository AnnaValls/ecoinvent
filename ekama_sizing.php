<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Reactor sizing</title>
	<script src="format.js"></script>
	<script>
		function init(){
			compute_exercise();
		}

		function compute_exercise(){
			//cost reactor
			var MLSS_X_TSS = getInput('input_MLSS_X_TSS'); //kg/m3 <-- value to be looped to find min costs
			var X_TSS_V = getInput('input_X_TSS_V'); //kg
			showResult('result_cost_reactor',cost_reactor(X_TSS_V,MLSS_X_TSS));

			//cost sst
			var Area = getInput('input_Area'); //m2
			showResult('result_cost_sst',cost_sst(Area));
		}

		function cost_reactor(X_TSS_V,MLSS_X_TSS) {
			/*
				Calculate cost of the reactor.
				Inputs:
				1. MLSS_X_TSS: kg/m3
						MLSS_X_TSS is always between 1 and 10 g/l (or kg/m3)
				2. X_TSS_V: kg
			*/
			var V = X_TSS_V / MLSS_X_TSS; //m3 (volume)
			V = V/1000; //conver to megaliters
			return 770*Math.pow(V,0.761); //dollars (?)
			/*
				George Ekama:
				I also set maximum limits, i.e. V>1 ML and < 16ML. 
				If V>16ML, then the plant divides into two parallel modules. 
			*/
		}

		function cost_sst(Area){
			var diameter = Math.sqrt(4*Area/Math.PI);
			return 30*Math.pow(diameter,1.22);
			/*
				Also D >15m and < 40m and again each module is 
				given 1, or 2 or 3 SSTs. 
				
			*/
		}
	</script>
	<style>
		body{
			max-width:90em;
			margin:auto;
			margin-bottom:100px;
		}
		.invisible{
			display:none;
		}
		.number, [type=number]{
			text-align:right;
		}
		table{
			border-collapse:collapse;
			border:1px solid #ccc;
			margin:5px auto;
		}
		td,th{
			padding:0.1em 0.3em;
		}
		th{
			text-align:left;
			border-bottom:1px solid black;
		}
		code{
			display:block;
			background:#ddd;
			padding:5px 0;
			padding-left:5px;
		}
		.flex{
			display:flex;
			flex-wrap:wrap;
		}
		.flex li {
			margin-right:30px;
		}
		[onclick]{
			cursor:pointer;
		}
		input {
			width:100px;
		}
		table[id^=results] span[id]{
			color:blue;
		}
		#btn_calculate{
			display:block;
			margin:auto;
			font-size:22px;
		}
		#results td[id]{
			color:blue;
		}
	</style>
</head><body onload="init()">

<!--title-->
<div>
	<h2> 
		Optimizing activated sludge systems (George A Ekama)
	</h2>
	<a href="docs/reactorSizing_ekama/PG4SSTAS-SSTOptNoBack(2PerPage).pdf">Document</a> 
	<hr>
</div>

<!--view formulas-->
<div>
	<div>
		1. Cost reactor
		<code>
			Volume = X<sub>TSS,V</sub>/MLSS<sub>X,TSS</sub> (m<sup>3</sup>) <br>
			Volume = Volume/1000; (megaliters) <br>
			<br>
			Cost reactor = 770·(Volume)<sup>0.761</sup>
		</code>
	</div>
	<div>
		2. Cost SST
		<code>
			Area = f(MLSS<sub>X,TSS</sub>) (m<sup>2</sup>)
				<span style=background:orange>pending: formula for Area using MLSS<sub>X,TSS</sub> as input</span> <br>
			diameter = (4·Area/&pi;)<sup>0.5</sup> (m)<br>
			<br>
			Cost SST = 30·(diameter)<sup>1.22</sup>
		</code>
	</div>
	<hr>
</div>

<!--view menus-->
<div>
	<h2>Implementation in Javascript</h2>
	<ol class=flex>
		<li><div>Inputs</div>
			<table id=inputs>
				<tr>
					<td>X<sub>TSS</sub>V
					<td><input type=number id=input_X_TSS_V value=40000> kg
				</tr>
				<tr>
					<td>MLSS<sub>X,TSS</sub> 
					<td><input type=number id=input_MLSS_X_TSS value=3> kg/m<sup>3</sup>
				</tr>
				<tr>
					<td>Area SST
					<td><input type=number id=input_Area value=1000> m<sup>2</sup>
				<tr>
			</table>
			<script>
				//add onchange listeners to recompute
				(function(){
					var inputs=document.querySelectorAll('table#inputs input[id]');
					for(var i=0;i<inputs.length;i++){
						inputs[i].onchange=function(){init()};
					}
				})();
			</script>
		</li><li><div>Results</div>
			<table id=results>
				<tr><td>Cost reactor<td id=result_cost_reactor>?<td>$
				<tr><td>Cost sst<td id=result_cost_sst>?<td>$
			</table>
		</li>
	</ol>
</div>

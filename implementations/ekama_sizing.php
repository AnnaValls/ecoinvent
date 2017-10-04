<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Reactor sizing</title>
	<!--css at the end-->
	<script>
		function init(){
			compute_exercise();
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

		function cost_sst(MLSS_X_TSS,Q){
			/*	
				Calculate the cost of the SST 
				Inputs:
				1. MLSS_X_TSS in kg/m3
				2. Q in m3/d
			*/
			//convert MLSS_X_TSS to mg/L
			MLSS_X_TSS*=1000;
			const Vmax=7;//max settling velocity of interface: m/h
			const K=600;//constant, L/mg for AS mixed liquor with SVI=150 (eq 8-86 and 8-87 exist if SVI is different, (not implemented))
			/*equation 8-85: page 895*/
			var Vi=Vmax*Math.exp(-K/1e6*MLSS_X_TSS); //settling velocity of interface: m/h
			/*equation 8-20: page 686 in metcalf 4th ed*/
			var SOR = Vi*24/1.75; //m3/m2·d or m/h 1.75 is safety factor (is the same as hydraulic application rate)
			/*equation 8-20: page 880 in metcalf 5th ed*/
			var Area = Q/SOR; //m2
			var diameter = Math.sqrt(4*Area/Math.PI);
			return 30*Math.pow(diameter,1.22);
			/*
				Also D >15m and < 40m and again each module is 
				given 1, or 2 or 3 SSTs. 
				
			*/
		}

		function total_cost(MLSS_X_TSS){
			var X_TSS_V = getInput('input_X_TSS_V'); //kg
			var reactor = cost_reactor(X_TSS_V,MLSS_X_TSS);
			showResult('result_cost_reactor',reactor);

			//cost sst
			var Q = getInput('input_Q'); //m3/d
			var sst = cost_sst(MLSS_X_TSS,Q);
			showResult('result_cost_sst',sst);

			//total
			var total = reactor+sst;
			return total;
		}

		function compute_exercise(){
			var MLSS_X_TSS = getInput('input_MLSS_X_TSS'); //kg/m3 <-- value to be looped to find min costs
			var total = total_cost(MLSS_X_TSS);
			showResult('result_total',total);
		}

		function optimize_MLSS_X_TSS(){
			//initial values
			var optimum_cost=Infinity;
			var optimum_M=Infinity;
			//loop from 0 to 10 kg/m3
			for(var M=0;M<10;M+=0.01) {
				var current_cost = total_cost(M);
				if(current_cost<optimum_cost){
					optimum_cost=current_cost;
					optimum_M=M;
				}
			}
			console.log("MLSS: "+optimum_M);
			console.log("Cost: "+optimum_cost);
			showResult('result_optimum_M',optimum_M);
			showResult('result_optimum_cost',optimum_cost);
			showResult('result_total',0);
			showResult('result_cost_reactor',0);
			showResult('result_cost_sst',0);
		}
	</script>
</head><body onload="init()">

<!--title-->
<div>
	<h2> 
		Optimizing activated sludge systems (George A Ekama)
	</h2>
	<a target=_blank href="docs/reactorSizing_ekama/PG4SSTAS-SSTOptNoBack(2PerPage).pdf">Document</a> 
	<hr>
</div>

<!--view formulas-->
<div>
	<div>
		1. Cost reactor
		<code>
			Inputs:
			<ul>
				<li>X<sub>TSS,V</sub>: kg of TSS (kg)
				<li>MLSS<sub>X,TSS</sub>: average MLSS concentration (kg/m3)
			</ul>
			Equations:
			<ul>
				<li>Volume = X<sub>TSS,V</sub>/MLSS<sub>X,TSS</sub> (m<sup>3</sup>)
				<li>Volume = Volume/1000; (megaliters) 
				<li><b>Cost reactor = 770·(Volume)<sup>0.761</sup> ($)</b>
			</ul>
		</code>
	</div>
	<div>
		2. Cost SST
		<code>
			Inputs:
			<ul>
				<li>MLSS<sub>X,TSS</sub>: average MLSS concentration (kg/m3)
				<li>Q: flowrate m3/d
			</ul>
			Parameters:
			<ul>
				<li>V<sub>max</sub> = 7 m/h (max settling velocity of interface)
				<li>K = 600 L/mg (constant for AS mixed liquor with SVI=150)
				<li>SF = 1.75 (safety factor)
			</ul>
			Equations:
			<ul>
				<li> V<sub>i</sub> = V<sub>max</sub>·e<sup>(-K/10<sup>6</sup>·MLSS<sub>X,TSS</sub>)</sup> (m/h) (settling velocity of interface)
				<li> SOR = V<sub>i</sub>·24/SF (m/h) (surface overflow rate)
				<li> Area = Q/SOR (m<sup>2</sup>)
				<li> diameter = (4·Area/&pi;)<sup>0.5</sup> (m)
				<li> <b>Cost SST = 30·(diameter)<sup>1.22</sup> ($)</b>
			</ul>
		</code>
	</div>
	<div>
		3. Total cost
		<code>
			<ul>
				<li><b>Total cost = Cost reactor + Cost SST</b>
			</ul>
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
					<td><input type=number id=input_X_TSS_V value=40000 min=0> kg
				</tr>
				<tr>
					<td>MLSS<sub>X,TSS</sub> 
					<td><input type=number id=input_MLSS_X_TSS value=3 min=0> kg/m<sup>3</sup>
				</tr>
				<tr>
					<td>Q
					<td><input type=number id=input_Q value=4000 min=0> m<sup>3</sup>/d
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
		<li><div>Results</div>
			<table id=results>
				<tr><td>Cost reactor<td id=result_cost_reactor>?<td>$
				<tr><td>Cost sst<td id=result_cost_sst>?<td>$
				<tr><td>Total cost<td id=result_total>?<td>$
			</table>
		</li>
	</ol>
	<div>
		3. Find best <b>MLSS<sub>X,TSS</sub></b> that optimizes <b>Total cost</b> (for current X<sub>TSS</sub>V and Q)
		<div>
			<button onclick=optimize_MLSS_X_TSS()>OPTIMIZE</button>
		</div>
		<table id=optim>
			<tr><td>Optimum MLSS<td id=result_optimum_M>?<td>kg/m3
			<tr><td>Optimum cost<td id=result_optimum_cost>?<td>$
		</table>
	</div>
</div>

<style>
	body{
		overflow-y:scroll;
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
	#results td[id],#optim td[id]{
		color:blue;
	}
</style>

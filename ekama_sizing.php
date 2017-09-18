<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Reactor sizing</title>
	<script src="format.js"></script>
	<script>
		function init(){
			compute_exercise();
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
	<h1 onclick=document.getElementById('statement').classList.toggle('invisible')>
		Optimizing activated sludge systems (George A Ekama)
	</h1>
	<a href="docs/reactorSizing_ekama/PG4SSTAS-SSTOptNoBack(2PerPage).pdf">Document</a>
	<hr>
</div>

<!--problem statement-->
<div id=statement>
	<ul>
		<li>1. Estimating reactor TSS concentration
		<li>2. Estimating AS system capacity
	</ul>
	<hr>
	(in progress)
</div>

<!--implementation gui-->
<div style=display:><h2>Implementation in Javascript</h2>
	<div> <button id=btn_calculate onclick=compute_exercise() style>Solve</button> </div>
	<ol class=flex>
		<li><div>Inputs</div>
			<table>
				<tr><td>Q                                                      <td><input type=number id=input_Q                 value=3800> m<sup>3</sup>/d
			</table>
		</li><li><div>Parameters</div>
			<table>
				<tr><td>Parameter <td class=number>3.3   <td>&empty;
			</table>
		</li><li><div>Results</div>
			<table id=results>
				<tr><td>Result k<td id=result_result> ?<td>mg/L
			</table>
		</li>
	</ol>
</div>

<!--implementation-->
<script>
	function compute_exercise(){
		/*
			Lluis, The equations I use are

			V_Reac=MX_TSS/X_TSS 
			and 
			Cost_reac=C_reac(V_reac)^P_reac

			Cost_SST=C_SST(Diam_SST)^P_SST

			where C_reac =770, C_SST=30, P_reac=0.761 and P_SST =1.22. 

			with V in megalitres (ML) and D in m. 

			The powers give the economy of scale. 
			I also set maximum limits, i.e. V>1 ML and < 16ML. 
			If V>16ML, then 
				the plant divides into two parallel modules. 
			
			Also D >15m and < 40m and again each module is 
			given 1, or 2 or 3 SSTs. 
			
			My spreadsheet does this calculation. 
			X_TSS is always between 1 and 10 gTSS/l.
		*/
	}
</script>

<!doctype html><html><head>
	<?php include'imports.php'?>
	<script src="construction/construction.js"></script>
	<script src="format.js"></script>
	<title>Construction</title>
	<script>
		function init(){
			updateTable();
		}

		var cap=0;
		function updateTable(){
			//update capacity
			cap=parseFloat(document.querySelector('input#capacity').value);
			//get table
			var t=document.querySelector('table#construction');
			while(t.rows.length>1)t.deleteRow(-1);
			//go over materials
			for(var material in Construction){
				//new row
				var newRow=t.insertRow(-1);
				//insert material name
				newRow.insertCell(-1).innerHTML=material
				//go over equations and insert values
				for(var equation in Construction[material]){
					var newCell=newRow.insertCell(-1)
					newCell.title=(function(){
						var expression=Construction[material][equation].toString();
						expression=expression.replace(/function ../,'');
						expression=expression.replace(/return/,'');
						expression=expression.replace(/cap/g,'C');
						expression=expression.replace(/  +/g,' ');
						return "equation: "+expression;
					})();
					newCell.innerHTML=(function(){
						var value=Construction[material][equation]();
						if (value == null){
							return "<span style=color:#ccc>N/A</span>";
						}
						else if(typeof value == 'number') {
							return format(Math.max(0,value));
						}
						else if(value.constructor === Array){
							return format(Math.max(0,value[0]))+" &mdash; "+format(Math.max(value[1]));
						}
						else{
							alert('error');
							return null;
						}
					})();
				}
			}
			//move cursor
			document.querySelector('input#capacity').select();
		}
	</script>
	<style>
		table {
			border-collapse:collapse;
			width:100%;
		}
		td:hover{
			background:linear-gradient(to top, #e01a1a, #eb6666);
		}
		th,td {
			padding:0 0.5em;
		}
		td:nth-child(n+2){
			text-align:right;
		}
		tr:first-child {
			border-top:1px solid #ccc;
		}
		tr:last-child, th {
			border-bottom:1px solid #ccc;
		}
		th:first-child, td:first-child {
			border-left:1px solid #ccc;
		}
		th:last-child, th, td:last-child {
			border-right:1px solid #ccc;
		}
		div[id]{
			border-bottom:1px solid #ccc;
			padding-bottom:5px;
			margin-bottom:5px;
		}
	</style>
</head><body onload=init()>
<!--back--><div><a href="../index.php">Back</a></div>
<?php include'navbar.php'?>

<h1>Construction materials</h1>

<!--input capacity of the plant-->
<div>
	Capacity of the plant 
	<input id=capacity value="1500" min=1500 max=21000 onchange="updateTable()" type=number>
	(m<sup>3</sup>/d) 
	(min:1500, max:21000)
</div><hr>

<!--table-->
<table id=construction>
	<tr>
		<th>Material (unit)
		<th>Pretreatment
		<th>Secondary treatment
		<th>Sludge line
		<th>Tube connections
		<th>Buildings
		<th>Urbanization
		<th>Power connection
		<th>Full plant
	</tr>
</table><hr>

<h4>
	Reference: 
	<a target=_blank href="../docs/construction/WR-S-17-01921.pdf">
		Table 4, Morera et al (2017): Up-to-date and modular construction inventories for Life Cycle Assessment of small to medium wastewater treatment plants (page 22)
	</a>
</h4>

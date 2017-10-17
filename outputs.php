<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>All Outputs</title>
	<script>
		function print_io(tech,func){
			var name = Technologies[tech].Name;
			document.write("<table border=1 style=font-size:11px><tr><th colspan=2>"+name);
			document.write(" - <a href='techs/"+Technologies[tech].File+"'>see equations</a>")
			var out = (function(){
				var ret=[];
				var Result = func();
				for(var o in Result){
					ret.push({name:o, unit:Result[o].unit, descr:Result[o].descr});
				}
				return ret;
			})();
			for(var i=0;i<out.length;i++){
				document.write("<tr><td class=help title='"+out[i].descr+"'>"+out[i].name);
				document.write("<td>"+out[i].unit.prettifyUnit());
			}
			document.write("</table>");
		}
	</script>

	<style>
		th {
			background:#eee;
		}
		.help:hover {
			text-decoration:underline;
		}
	</style>
</head><body>
<?php include'navbar.php'?>
<div id=root>

<h1>All Outputs</h1>
<p>Grouped by technology</p>
<hr>
<div class=flex>
	<script>
		print_io('BOD',bod_removal_only);
		print_io('Nit',nitrification);
		print_io('SST',sst_sizing);
		print_io('Des',N_removal);
		print_io('BiP',bio_P_removal);
		print_io('ChP',chem_P_removal);
	</script>
</div>

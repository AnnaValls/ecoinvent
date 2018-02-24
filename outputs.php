<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>All Outputs</title>
	<script>
		function print_io(tech,func,file){
			var name = Technologies[tech].Name;
			document.write("<table border=1 class=tech><tr><th colspan=2>");
			document.write("<a href='implementations/"+Technologies[tech].Implemented_in+"'>"+name+"</a>")
      document.write("<tr><th colspan=2><a href='see.php?path=techs&file="+file+"'>equations</a>");
			var out = (function(){
				var ret=[];
				var Result = func();
				for(var o in Result){
					ret.push({name:o, unit:Result[o].unit, descr:Result[o].descr});
				}
				//sort by name
				var ret = ret.sort((a,z)=>{return a.name.localeCompare(z.name)});
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
    table.tech{
      font-size:11px;
      margin-right:2px;
      border-collapse:collapse;
    }
	</style>
</head><body>
<?php include'navbar.php'?>
<div id=root>

<h1>All Outputs</h1>
<p>Grouped by technology and sorted alphabetically</p> <hr>

<div class=flex>
	<script>
		print_io('Fra',fractionation,'fractionation.js');
    print_io('BOD',bod_removal_only,'bod_removal_only.js');
		print_io('Nit',nitrification,'nitrification.js');
		print_io('SST',sst_sizing,'sst_sizing.js');
		print_io('Des',N_removal,'n_removal.js');
		print_io('BiP',bio_P_removal,'bio_P_removal.js');
		print_io('ChP',chem_P_removal,'chem_P_removal.js');
    print_io('Met',metals_doka,'metals_doka.js');
	</script>
</div>

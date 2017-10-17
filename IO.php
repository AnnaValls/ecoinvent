<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>All Outputs</title>
	<script>
		function print_io(tech,func){
			var name = Technologies[tech].Name;
			document.write("<table border=1 style=font-size:11px><tr><th colspan=2>"+name);
			var out = (function(){
				var ret=[];
				var Result = func();
				for(var o in Result){
					ret.push(o)
				}
				return ret;
			})();
			for(var i=0;i<out.length;i++){
				var output = out[i] || "";
				document.write("<tr><td>"+output);
			}
			document.write("</table>");
		}
	</script>
</head><body>
<?php include'navbar.php'?>
<div id=root>

<h1>All Outputs</h1>
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

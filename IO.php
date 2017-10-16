<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>IO workflow</title>
	<script>
		function print_io(tech,func){
			var name = Technologies[tech].Name;
			document.write("<table border=1><tr><th colspan=2>"+name+"<tr><th>in<th>out");
			var inp = Technologies[tech].Inputs
			var out = (function(){
				var ret=[];
				var Result = func();
				for(var o in Result){
					ret.push(o)
				}
				return ret;
			})();
			var n = Math.max(inp.length, out.length)
			for(var i=0;i<n;i++){
				var input  = inp[i] || "";
				var output = out[i] || "";
				document.write("<tr><td>"+input+"<td>"+output);
			}
			document.write("</table>");
		}
	</script>
</head><body>
<?php include'navbar.php'?>
<div id=root>

<h1>input/output workflow</h1>

<!--IO workflow-->
<div class=flex>
	<script>
		print_io('BOD',bod_removal_only);
		print_io('Nit',nitrification);
	</script>
</div>

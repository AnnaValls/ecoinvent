<!doctype html><html><head>
	<?php include'imports.php'?>
	<title>Elementary Flows</title>
	<script src="createEcospold.js"></script>
</head><body>
<?php include'navbar.php'?>
<div id=root>

<h1>Generate ecoSpold file (XML)</h1>

<p>
  status: Pascal Lesage &amp; Lluís Bosch are doing this part.
</p>

<p>(Note: an empty ecoSpold file is generated for now)</p>

<button style=font-size:20px onclick="createEcospold()">
	Generate
</button>

<hr>

<p>
	Information that will contain the ecoSpold file:
	<ul>
		<li>technology
		<li>capacity
		<li>geography
		<li>time period start
		<li>time period end
    <li>? <issue class=help_wanted></issue>
	</ul>
</p>

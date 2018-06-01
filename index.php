<!doctype html><html><head>
  <?php include'imports.php'?>
  <!--css styles are at the end-->
  <title>Ecoinvent</title>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Home page</h1><hr>
<p style=max-width:50em>

  <!--introduction text-->
  <div style=background:yellow><p>
    Introductory text. Steps:
    <ol>
      <li>Step 1
      <li>Step 2
      <li>Step 3
    </ol>
  <p></div><hr>

  <!--web parts-->
  <div>
    <button
      style="font-size:30px;padding:1em;"
      onclick=window.location="simplified_data_entry.php">
      Access the tool
    </button>
  </div><hr>

  <div>
    <ul>
      <li><a href="">Access the methodological report</a>
      <li><a href="modules_implemented.php">Additional information</a>
    </ul>
  </div>
</p>

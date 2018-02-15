<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Reference Data</title>
</head><body>
<?php include'navbar.php'?>

<h1>WWTP Reference Data</h1>

<p>
  List of WWTP average influents by country:
  <br>
  <p>
  <small>
    <b>note</b>: list of countries and input values needed.
    <issue class=help_wanted></issue>
    <a href="//github.com/holalluis/ecoinvent/tree/master/reference_data">The list is readable here</a>
  </small>
  </p>
</p>

<ul>
<?php
  $folder="reference_data";
  $ls=scandir($folder);

  //loop all files in $folder
  foreach($ls as $file){

    //omit folders
    if(is_dir($file))continue;

    //parse the json and extract the country
    $contents=file_get_contents("$folder/$file");
    $parsed=json_decode($contents);
    $country=$parsed->country;

    //print the link to the json file
    echo "<li><a href='$folder/$file'>$file ($country)</a>";
  }
?>
</ul>

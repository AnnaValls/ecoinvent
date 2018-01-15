<!doctype html>
<html><head> 
  <meta charset=utf-8>
  <title>Reference Data</title>
</head><body>

<h1>WWTP Reference Data</h1>

<p>
  Current list of WWTP configurations (by country) used for evaluating activities:
  <br>
  <p>
  <small>
    <b>note</b>: to add more configurations, create a pull request <a href="//github.com/holalluis/ecoinvent/tree/master/activity/referenceData">here</a>
  </small>
  </p>
</p>

<ul>
<?php
  $folder="referenceData";
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

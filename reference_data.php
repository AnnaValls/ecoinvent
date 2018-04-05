<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Reference Data</title>
</head><body>
<?php include'navbar.php'?>

<h1>WWTP Country Data</h1>

<div>
  Every region needs the following inputs:
  <table style="margin-left:20px">
    <script>
      Inputs.forEach(input=>{
        document.write("<tr title='"+input.descr+"'><td>"+input.id);
        document.write("<td><input type=number value='"+input.value+"'>");
        document.write("<td><small>"+input.unit.prettifyUnit()+"</small>");
      });
    </script>
  </table>
</div>

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

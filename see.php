<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Source file viewer</title>
  <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
  <script>
    function init(){
    }
  </script>
  <style>
    pre.prettyprint {
      border:none;
    }
  </style>
</head><body onload=init()>
<?php include'navbar.php'?>
<?php
//view the source code of path/file
//INPUT
$path=$_GET['path'];
$file=$_GET['file'];
/*TEST
$path="techs";
$file="bio_P_removal.js";
*/
//read file contents and display
$content="
  <head> <title>$file</title> </head>
  <body>
  <h2>file: $file</h2>
    <code>
      <pre class=prettyprint>".htmlspecialchars(file_get_contents("$path/$file"))."</pre>
    </code>";
echo $content;
?>

<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Source code viewer</title>
  <!--prettify code lib-->
  <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
  <style>
    pre.prettyprint { border:none; }
    span.remark { background:yellow; }
  </style>
</head><body>
<?php include'navbar.php'?>

<?php
/**
  * VIEW THE SOURCE CODE OF PATH/FILE and optionally remark a variable
  */

//GET inputs
  $path   = isset($_GET['path'])   ? $_GET['path'] : ".";     //folder or .
  $file   =                          $_GET['file'] ;          //file
  $remark = isset($_GET['remark']) ? $_GET['remark'] : false; //variable highlighted
  /* test
  $path="techs";
  $file="bio_P_removal.js";
*/

//read file contents
$file_content = htmlspecialchars(file_get_contents("$path/$file"));

//add a remarked span to the themarked variable
if($remark){
  $file_content = str_replace($remark, "<span class=remark id=remark>$remark</span>", $file_content);
}

//display content
echo "
  <head> <title>$file</title> </head>
  <body>
  <h2>file: $file</h2>
    <code>
      <pre class=prettyprint>$file_content</pre>
    </code>
";

//scroll automatically to remarked variable
if($remark){
  ?>
  <script>window.location="#remark"</script>
  <?php
}

?>

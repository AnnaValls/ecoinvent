<?php
  /*
   * description
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Generate influent file</title>

  <script>
    function init(){
      //
    }
  </script>
</head><body onload="init()">
<?php include'navbar.php'?>

<div id=root>
<h1>Generate influent file</h1><hr>

<!--1. Inputs-->
<div>
  <p><b><u>1. User Inputs</u></b></p>
  <!--enter technologies-->
  <div>
    <p>1.1. Activate technologies of your plant</p>
    <table id=inputs_tech border=1></table>
  </div>
  <!--enter ww characteristics-->
  <div>
    <p>1.2. Enter influent inputs
      <small>(required: <span id=input_amount>0</span>)</small>
    </p>

    <!--inputs table-->
    <table id=inputs border=1>
      <tr><th>Input<th>Value<th>Unit
    </table>
  </div>
</div><hr>

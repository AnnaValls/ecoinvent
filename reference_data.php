<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Reference Data</title>
</head><body>
<?php include'navbar.php'?>
<h1>WWTP Country Data</h1>
<div>
  Every WWTP that represents a region needs the following inputs:
  <table id=inputs style="margin-left:20px">
    <script>
      Inputs.filter(i=>!i.canBeEstimated).forEach(input=>{
        document.write("<tr title='"+input.descr+"'><td>"+input.id);
        document.write("<td><input type=number value='"+input.value+"'>");
        document.write("<td><small>"+input.unit.prettifyUnit()+"</small>");
      });
    </script>
  </table>
  <style>
    #inputs tr:hover { text-decoration:underline; }
  </style>
</div>

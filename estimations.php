<?php /*
  Estimations for filling inputs
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Estimations</title>
</head><body>
<?php include'navbar.php'?>

<div id=root>
<h1>Estimations</h1>
<p>
  Check the boxes of the inputs you have and click here
  <button>OK</button>
</p>
<div>
  <issue class=under_dev></issue>
</div>
<hr>


<!--inputs table-->
<div>
  <table id=inputs border=1></table>
  <style>
    #root #inputs {
      font-size:small;
      font-family:monospace;
    }
  </style>
</div>

<script>
  //populate inputs
  (function(){
    var t=document.getElementById('inputs');
    function populate_input(i){
      var newRow=t.insertRow(-1);
      newRow.insertCell(-1).innerHTML=i.id;
      newRow.insertCell(-1).innerHTML="<input type=checkbox>";
      newRow.insertCell(-1).innerHTML="<small>"+i.descr+"</small>";
      newRow.insertCell(-1).innerHTML="<small>"+i.unit.prettifyUnit();
    }

    t.insertRow(-1).outerHTML="<tr><th colspan=4>Wastewater characteristics";;
    Inputs
      .filter(i=>{return !i.isParameter && !i.isMetal})
      .forEach(i=>{
        populate_input(i)
    });

    t.insertRow(-1).outerHTML="<tr><th colspan=4>Design parameters";;
    Inputs
      .filter(i=>{return i.isParameter && !i.isMetal})
      .forEach(i=>{
        populate_input(i)
    });
  })();
</script>

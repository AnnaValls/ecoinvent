<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Fractionation (G. Ekama)</title>

  <!--backend definitions: elementary flows and mass balances-->
  <script src="techs/fractionation_ekama.js"></script>

  <!--implementation-->
  <script>
    function init(){
      calculate();
    }

    function calculate(){
      var COD=document.getElementById('COD').value;
      var sCOD=document.getElementById('sCOD').value;
      var fSus=document.getElementById('fSus').value;
      var fSup=document.getElementById('fSup').value;
      var Result=fractionation_ekama(COD,sCOD,fSus,fSup);
      for(var id in Result){
        var handle=document.getElementById(id);
        if(!handle)continue;
        handle.innerHTML=format(Result[id].value);
        handle.innerHTML+=" "+Result[id].unit.prettifyUnit();
      }
    }
  </script>
</head><body onload="init()">
<?php include'navbar.php'?>

<div id=root>
<h1>Fractionation (G. Ekama) implementation</h1>
<hr>
<p>Equations are in <a href="techs/fractionation_ekama.js">fractionation_ekama.js</a></p>
<hr>

<!--inputs and outputs-->
<div class=flex>
  <div>
    <p>Inputs</p>
    <table id=inputs border=1>
      <tr><td>COD <td><input onchange="calculate()" type=number id=COD  value=750> mg/L
      <tr><td>sCOD<td><input onchange="calculate()" type=number id=sCOD value=199> mg/L
      <tr><td>fSus<td><input onchange="calculate()" type=number id=fSus value=0.07 step=0.01> gUS/gCOD
      <tr><td>fSup<td><input onchange="calculate()" type=number id=fSup value=0.15 step=0.01> gUP/gCOD
    </table>
  </div>

  <div style="margin-left:5px"></div>

  <div>
    <p>Outputs</p>
    <table id=outputs border=1>
      <tr><td>COD <td id=pCOD>0
      <tr><td>US<td id=US>0
      <tr><td>BS<td id=BS>0
      <tr><td>UP<td id=UP>0
      <tr><td>BP<td id=BP>0
    </table>
  </div>
</div>

<hr>
<p>
  <b>Note:</b>
  Implementing it here separately will make it easier later to integrate with the rest of the code.
</p>

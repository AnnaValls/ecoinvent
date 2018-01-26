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
      var BOD=document.getElementById('BOD').value;
      var sBOD=document.getElementById('sBOD').value;
      var TSS=document.getElementById('TSS').value;
      var VSS=document.getElementById('VSS').value;
      var Result=fractionation_ekama(COD,sCOD,fSus,fSup,BOD,sBOD,TSS,VSS);
      for(var id in Result){
        var handle=document.getElementById(id);
        if(!handle)continue;
        handle.innerHTML=format(Result[id].value);
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
      <tr><td>COD <td><input onchange="calculate()" type=number id=COD  value="300"> mg/L
      <tr><td>sCOD<td><input onchange="calculate()" type=number id=sCOD value="132"> mg/L
      <tr><td>fSus<td><input onchange="calculate()" type=number id=fSus value="0.066667" step=0.000001> g nbsCOD/g COD
      <tr><td>fSup<td><input onchange="calculate()" type=number id=fSup value="0.186667" step=0.000001> g nbpCOD/g COD
      <tr><td>BOD <td><input onchange="calculate()" type=number id=BOD  value="140"> mg/L
      <tr><td>sBOD<td><input onchange="calculate()" type=number id=sBOD value="70">  mg/L
      <tr><td>TSS <td><input onchange="calculate()" type=number id=TSS  value="70">  mg/L
      <tr><td>VSS <td><input onchange="calculate()" type=number id=VSS  value="60">  mg/L
    </table>
  </div>

  <div style="margin-left:5px"></div>

  <div>
    <p>Outputs</p>
    <table id=outputs border=1>
    </table>
    <script>
      (function(){
        var result=fractionation_ekama();
        var table=document.querySelector('#outputs');
        for(var id in result){
          var newRow=table.insertRow();
          newRow.insertCell(-1).innerHTML=id;
          var newCell=newRow.insertCell(-1)
          newCell.id=id;
          newCell.innerHTML=0;

          newRow.insertCell(-1).innerHTML=result[id].unit.prettifyUnit();
          newRow.insertCell(-1).innerHTML="<small>"+result[id].descr.prettifyUnit()+"</small>";
        }
      })();
    </script>
  </div>
</div>

<hr><p>
  <b>Note:</b>
  Implementing it here separately will make it easier later to integrate with the rest of the code.
</p>

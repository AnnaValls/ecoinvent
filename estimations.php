<?php /*
  Estimations for inputs
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Estimations</title>
  <script>
    function calculate(){
      //inputs
      var COD = parseFloat(document.querySelector('#COD').value);
      var TKN = parseFloat(document.querySelector('#TKN').value);
      var TP  = parseFloat(document.querySelector('#TP').value);

      //call estimations
      var rv = estimations(COD,TKN,TP);

      //add to gui
        [rv.variables, rv.outputs].forEach(o=>{
          Object.keys(o).forEach(el=>{
            document.querySelector('#'+el).innerHTML=format(o[el]);
          });
        });
    }
  </script>
</head><body onload="calculate()">
<?php include'navbar.php'?>
<div id=root>
<h1>Estimations for inputs the user might not know</h1>
<p><b>
  Default values from BioWin 5.2 <br>
  <a href=see.php?file=estimations.js>See equations</a>
</b></p><hr>

<!--tables-->
<div id=main class=flex>
  <!--inputs-->
  <div>
    <p>Required inputs</p>
    <table id=inputs border=1>
      <tr><td>COD <td><input onchange=calculate() id=COD type=number value=500> <td style=font-size:smaller>g/m<sup>3</sup> as O<sub>2</sub>
      <tr><td>TKN <td><input onchange=calculate() id=TKN type=number value=40>  <td style=font-size:smaller>g/m<sup>3</sup> as N
      <tr><td>TP  <td><input onchange=calculate() id=TP  type=number value=10>  <td style=font-size:smaller>g/m<sup>3</sup> as P
    </table>
  </div>

  <!--variables-->
  <div>
    <p>Variables</p>
    <table id=variables border=1>
      <tr><td>CS_U  <td id="CS_U">
      <tr><td>S_VFA <td id="S_VFA">
      <tr><td>S_F   <td id="S_F">
      <tr><td>C_B   <td id="C_B">
      <tr><td>X_B   <td id="X_B">
      <tr><td>X_H   <td id="X_H">
      <tr><td>X_U   <td id="X_U">
      <tr><td>X_COD <td id="X_COD">
      <tr><td>CS_B  <td id="CS_B">
      <tr><td>X_BH  <td id="X_BH">
    </table>
  </div>

  <!--outputs-->
  <div>
    <p>Result: estimated inputs</p>
    <table id=outputs border=1>
      <tr><td>BOD         <td  id="BOD">        <td style=font-size:smaller>g/m<sup>3</sup> as O<sub>2</sub>
      <tr><td>sBOD        <td  id="sBOD">       <td style=font-size:smaller>g/m<sup>3</sup> as O<sub>2</sub>
      <tr><td>sCOD        <td  id="sCOD">       <td style=font-size:smaller>g/m<sup>3</sup> as O<sub>2</sub>
      <tr><td>bCOD        <td  id="bCOD">       <td style=font-size:smaller>g/m<sup>3</sup> as O<sub>2</sub>
      <tr><td>rbCOD       <td  id="rbCOD">      <td style=font-size:smaller>g/m<sup>3</sup> as O<sub>2</sub>
      <tr><td>VFA         <td  id="VFA">        <td style=font-size:smaller>g/m<sup>3</sup> as O<sub>2</sub>
      <tr><td>VSS         <td  id="VSS">        <td style=font-size:smaller>g/m<sup>3</sup>
      <tr><td>TSS         <td  id="TSS">        <td style=font-size:smaller>g/m<sup>3</sup>
      <tr><td>NH4         <td  id="NH4">        <td style=font-size:smaller>g/m<sup>3</sup> as N
      <tr><td>PO4         <td  id="PO4">        <td style=font-size:smaller>g/m<sup>3</sup> as P
      <tr><td>Alkalinity  <td  id="Alkalinity"> <td style=font-size:smaller>g/m<sup>3</sup> as CaCO<sub>3</sub>
    </table>
  </div>

  <style>
    #main #inputs,
    #main #variables,
    #main #outputs
    {
      font-size:small;
      font-family:monospace;
      margin-right:20px;
    }
  </style>
</div>

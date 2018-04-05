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

      //intermediate variables
        var CS_U  = 0.050*COD;
        var S_VFA = 0.024*COD;
        var S_F   = 0.136*COD;
        var C_B   = 0.170*COD;
        var X_B   = 0.470*COD;
        var X_H   = 0.020*COD;
        var X_U   = 0.130*COD;
        var X_COD = X_B + X_H + X_U;
        var CS_B  = C_B + S_VFA + S_F;
        var X_BH  = X_B + X_H;
        var variables={
          CS_U,
          S_VFA,
          S_F,
          C_B,
          X_B,
          X_H,
          X_U,
          X_COD,
          CS_B,
          X_BH,
        };

      //outputs (return value)
        var BOD        = COD/2.04;
        var sCOD       = CS_U + S_VFA + S_F + C_B;
        var sBOD       = sCOD/2.04;
        var bCOD       = COD - X_U - CS_U;
        var rbCOD      = S_VFA + S_F;
        var VFA        = S_VFA;
        var VSS        = X_COD/1.6;
        var TSS        = 45 + VSS;
        var NH4        = 0.66*TKN;
        var PO4        = 0.50*TP;
        var Alkalinity = 300;
        var rv = {
          BOD,
          sCOD,
          sBOD,
          bCOD,
          rbCOD,
          VFA,
          VSS,
          TSS,
          NH4,
          PO4,
          Alkalinity,
        };

      //add to gui
        [rv, variables].forEach(o=>{
          Object.keys(o).forEach(el=>{
            document.querySelector('#'+el).innerHTML=format(o[el]);
          });
        });

      //return
      return rv;
    }
  </script>
</head><body onload="calculate()">
<?php include'navbar.php'?>

<div id=root>
<h1>Estimations for inputs that the user may not know</h1>
<p><b>
Default values for BioWin 5.2
</b></p><hr>

<!--tables-->
<div class=flex>
  <!--inputs-->
  <div>
    <p>Required inputs</p>
    <table id=inputs border=1>
      <tr><td>COD <td><input onchange=calculate() id=COD type=number value=500> mg/L as O<sub>2</sub>
      <tr><td>TKN <td><input onchange=calculate() id=TKN type=number value=40> mg/L as N
      <tr><td>TP  <td><input onchange=calculate() id=TP  type=number value=10> mg/L as P
    </table>
  </div><hr>

  <!--variables-->
  <div>
    <p>Intermediate<br>variables</p>
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
  </div><hr>

  <!--outputs-->
  <div>
    <p>Estimated inputs</p>
    <table id=outputs border=1>
      <tr><td>BOD         <td  id="BOD">        <td style=font-size:smaller>mg/L as O<sub>2</sub>
      <tr><td>sBOD        <td  id="sBOD">       <td style=font-size:smaller>mg/L as O<sub>2</sub>
      <tr><td>sCOD        <td  id="sCOD">       <td style=font-size:smaller>mg/L as O<sub>2</sub>
      <tr><td>bCOD        <td  id="bCOD">       <td style=font-size:smaller>mg/L as O<sub>2</sub>
      <tr><td>rbCOD       <td  id="rbCOD">      <td style=font-size:smaller>mg/L as O<sub>2</sub>
      <tr><td>VFA         <td  id="VFA">        <td style=font-size:smaller>mg/L as O<sub>2</sub>
      <tr><td>VSS         <td  id="VSS">        <td style=font-size:smaller>mg/L
      <tr><td>TSS         <td  id="TSS">        <td style=font-size:smaller>mg/L
      <tr><td>NH4         <td  id="NH4">        <td style=font-size:smaller>mg/L as N
      <tr><td>PO4         <td  id="PO4">        <td style=font-size:smaller>mg/L as P
      <tr><td>Alkalinity  <td  id="Alkalinity"> <td style=font-size:smaller>mg/L as CaCO<sub>3</sub>
    </table>
  </div><hr>

  <style>
    #root #inputs,
    #root #variables,
    #root #outputs
    {
      font-size:small;
      font-family:monospace;
    }
  </style>
</div>

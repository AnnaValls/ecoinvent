<?php /*
  Estimations for filling inputs
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Estimations</title>
  <style>
    #root #inputs,
    #root #outputs
    {
      font-size:small;
      font-family:monospace;
    }
  </style>
</head><body>
<?php include'navbar.php'?>

<div id=root>
<h1>Estimations for inputs that the user may not know</h1>

<p><b>
Default values for BioWin 5.2
</b></p>

<hr>

<!--inputs table-->
<div class=flex>
  <div style=margin-right:8px>
    <p>Required inputs</p>
    <table id=inputs border=1>
      <tr><td>COD <td><input onchange=calculate() id=COD type=number value=500> mg/L as O<sub>2</sub>
      <tr><td>TKN <td><input onchange=calculate() id=TKN type=number value=40> mg/L as N
      <tr><td>TP  <td><input onchange=calculate() id=TP  type=number value=10> mg/L as P
    </table>
  </div>

  <div>
    <p>Estimations</p>
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
  </div>
</div>

<script>
  function calculate(){
    //inputs
    var COD = parseFloat(document.querySelector('#COD').value);
    var TKN = parseFloat(document.querySelector('#TKN').value);
    var TP  = parseFloat(document.querySelector('#TP').value);

    //outputs
    var CS_U        = 0.050*COD;
    var S_VFA       = 0.024*COD;
    var S_F         = 0.136*COD;
    var C_B         = 0.170*COD;
    var X_B         = 0.470*COD;
    var X_H         = 0.020*COD;
    var X_U         = 0.130*COD;
    var X_COD       = X_B + X_H + X_U;
    var CS_B        = C_B + S_VFA + S_F;
    var X_BH        = X_B + X_H;

    console.log({
      CS_U        :CS_U ,
      S_VFA       :S_VFA,
      S_F         :S_F  ,
      C_B         :C_B  ,
      X_B         :X_B  ,
      X_H         :X_H  ,
      X_U         :X_U  ,
      X_COD       :X_COD,
      CS_B        :CS_B ,
      X_BH        :X_BH ,
    });

    var BOD         = COD/2.04;
    var sCOD        = CS_U + S_VFA + S_F + C_B;
    var sBOD        = sCOD/2.04;
    var bCOD        = COD - X_U - CS_U;
    var rbCOD       = S_VFA + S_F;
    var VFA         = S_VFA;
    var VSS         = X_COD/1.6;
    var TSS         = 45 + VSS;
    var NH4         = 0.66*TKN;
    var PO4         = 0.50*TP;
    var Alkalinity  = 300;

    var rv={
      BOD         :BOD         ,
      sBOD        :sBOD        ,
      sCOD        :sCOD        ,
      bCOD        :bCOD        ,
      rbCOD       :rbCOD       ,
      VFA         :VFA         ,
      VSS         :VSS         ,
      TSS         :TSS         ,
      NH4         :NH4         ,
      PO4         :PO4         ,
      Alkalinity  :Alkalinity  ,
    };

    Object.keys(rv).forEach(key=>{
      document.querySelector('#'+key).innerHTML=format(rv[key]);
    });

    return rv;
  }
  calculate();
</script>


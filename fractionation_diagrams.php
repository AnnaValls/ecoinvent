<!doctype html><html><head> <?php include'imports.php'?>
  <title>Fractionation</title>
  <style>
    #root table {
      border-collapse:collapse;
      margin-bottom:5px;
      margin-right:5px;
      width:50%;
    }
    #root td {
      text-align:center;
      padding:0.5em;
      background:white;
    }
    #root td[blank]{
      border:none;
      background:#f5f5f5;
    }
  </style>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Fractionation diagrams</h1><hr>

<!--COD-->
<div class=flex>
  <div>
    <table border=1>
      <tr><th colspan=8>COD
      <tr><td colspan=4>bCOD  <td colspan=4>nbCOD
      <tr><td colspan=2>bsCOD<br>(readily biodg)<td colspan=2>bpCOD<br>(slow biodg)<td colspan=2>nbsCOD<br>(=sCODe)<td colspan=2>nbpCOD
      <tr><td>Complex <td>VFA <td>Colloidal <td>Particulate<td blank><td blank><td blank><td blank>
    </table>
  </div>
  <div>
    <table border=1>
      <tr><th colspan=8>COD
      <tr><td colspan=4>sCOD  <td colspan=4>pCOD
      <tr><td colspan=2>bsCOD<br>(readily biodg)<td colspan=2>nbsCOD<br>(=sCODe)<td colspan=2>bpCOD<br>(slow biodg)<td colspan=2>nbpCOD
      <tr><td>Complex <td>VFA <td blank><td blank> <td>Colloidal <td>Particulate<td blank><td blank>
    </table>
  </div>
</div>

<!--TSS-->
<div>
  <table border=1>
    <tr><th colspan=8>TSS
    <tr><td colspan=4>VSS                  <td colspan=4>iTSS
    <tr><td colspan=2>nbVSS<td colspan=2>bVSS<td colspan=2 blank><td colspan=2 blank>
  </table>
</div>


<!--TKN-->
<div>
  <table border=1>
    <tr><th colspan=8>TKN
    <tr><td colspan=4>NH<sub>4</sub>             <td colspan=4>ON
    <tr><td colspan=2 blank><td colspan=2 blank> <td colspan=2>bON <td colspan=2>nbON
    <tr><td blank><td blank><td blank><td blank> <td>bsON<td>bpON<td>nbsON<td>nbpON
  </table>
</div>

<!--TP-->
<table border=1>
  <tr><th colspan=8>TP
  <tr><td colspan=4>PO<sub>4</sub>             <td colspan=4>OP
  <tr><td colspan=2 blank><td colspan=2 blank> <td colspan=2>bOP <td colspan=2>nbOP
  <tr><td blank><td blank><td blank><td blank><td>bsOP<td>bpOP<td>nbsOP<td>nbpOP
</table>

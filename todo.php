<!doctype html><html><head><?php include'imports.php'?><title>TO DO items</title></head><body><?php include'navbar.php'?>
<div id=root><div><h1>All TO DO items/tasks/doubts/issues/etc</h1>
  <p><em>This page is intended to centralize all issues during development</em></p>
  <p><small>If an item is here is because has been discussed at some point, but Lluís B. has not understood either conceptually and/or how or where to implement it (otherwise, it's under development)</small></p>
  <p><small>
    <?php
      $filepath=$_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
      echo "Last modification: " . date ("F d Y H:i:s.", filemtime($filepath));
    ?>
  </small></p>
</div>

<!--main table--><table class=todo_items border=1><tr><th>Item description<th>Status<th>Added
  <tr><td header colspan=3><button class=toggleView onclick=toggleView(this,'single')>&darr;</button> Single plant model
  <tbody id=single style=display:nonee>
    <tr>
      <td>TOC and DOC: influent amount, effluent emission, C balance
      <td>TBD
      <td>April 20 2018
    <tr>
      <td>BOD effluent equation
      <td>Done (tool only, not in ecospold)
      <td>April 20 2018
    <tr>
      <td>Nitrogen and Phosphorus balances (George E. vs Lluís C. equations) <a href=see.php?file=elementary.js&remark=Outputs.TKN.effluent.sludge>effluent equations</a>
      <td>Discussion with George and Lluís is needed
      <td>April 20 2018
    <tr>
      <td>iSS composition (sand) can be calculated as O+Si+Al+Fe+Ca+Na+K+Mg. the percentages are in <a href=see.php?file=sludge_composition.js&path=techs>sludge_composition.js</a>
      <td>George provided help April 16th
      <td>April 16 2018
    <tr>
      <td>Doubt: is Alkalinity (g/m3 as CaCO3) also discharged/diluted by CSO?
      <td>Help needed
      <td>April 16 2018
    <tr>
      <td>Add more technologies (i.e. Lagoons)
      <td>will not implement in this version
      <td>April 16 2018
    <tr>
      <td>Add a Warnings module for the following variables
        <ul>
          <li>fSus (raw: 0% to 10%. with primary settler: 0% to 15%)
          <li>fSup (raw: 8% to 25%. with primary settler: 0% to 10%)
          <li>difference_NOr_NOx (in denitrification) &lt; 5%
        </ul>
      <td>will not implement in this version
      <td>April 16 2018
    <tr>
      <td>Consider adding NO3 as input (default value = 0 g/m3)
      <td>Help from experts needed
      <td>April 11 2018
    <tr>
      <td>Coarse solids removal
        <br>
        (Pascal knows how to calculate this, Peter may have data)
        <br>
        It is a formula that depends only on the flowrate (Q)
      <td>Lluís B. needs guidance
      <td>April 5 2018
    </tr>
  </tbody>

  <tr><td header colspan=3><button class=toggleView onclick=toggleView(this,'multiple')>&rarr;</button> Multiple plant model
  <tbody id=multiple style=display:none>
    <tr>
      <td>FeCl3 returned is in L/d and ecospold needs kg/m3 contribution
        <a href=see.php?path=techs&file=chem_P_removal.js&remark=FeCl3_volume>equations</a>
      <td>Not sure if Pascal dealt with it
      <td>April 19 2018
    <tr>
      <td>Peter's reference data:
        <ul>
          <li>Brazil
          <li>Switzerland
          <li>India
          <li>South Africa
          <li>Peru
          <li>Colombia
          <li>America
        </ul>
      <td>Data not received (only South Africa received from George)
      <td>April 10 2018
    <tr>
      <td>Show off data: <br>
        The user will be able to see what's happening in terms of equations <br>
        They will be able to acces all the wwtp data
      <td>not sure how to proceed
      <td>April 4 2018
    <tr>
      <td>
        Documentation
        <ul>
          <li>overall approach (?)
          <li>how-to integrated in the tool (?)
          <li>ecospold documentation (?)
        </ul>
      <td>not sure how to proceed, need concrete instructions
      <td>April 4 2018
    <tr>
      <td>User interface
        <ul>
          <li>Block "BOD removal" from being unchecked
          <li>Add a button for Recalculate yves estimations
          <li>Not all tech combinations should be possible to activate (like in single plant model)
        </ul>
      <td>not started
      <td>April 12 2018
  </tbody>

  <tr><td header colspan=3><button class=toggleView onclick=toggleView(this,'server')>&rarr;</button> Server related
  <tbody id=server style=display:none>
    <tr>
      <td>Install python &gt;= 3.5
      <td>Done
      <td>April 23 2018
  </tbody>
</table>

<style>
  table.todo_items {
    margin-bottom:1em;
    border-collapse:collapse;
    width:75%;
  }
  table.todo_items td {
    font-size:smaller;
  }
  table.todo_items td:first-child {
    padding-left:8px;
  }
  table.todo_items td[header] {
    font-weight:bold;
    text-align:left;
    background:#eee;
    padding-left:0;
  }
  /*status cells*/
  table.todo_items td:nth-child(2) {
    background:lightblue;
    font-style:italic;
    padding:0 5px;
  }
</style>

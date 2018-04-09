<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>TO DO items</title>
  </head><body>
  <?php include'navbar.php'?>
  <div id=root>
  <div>
    <h1>All TO DO items/tasks/doubts/issues/etc</h1>
    <p><em>This page is intended to centralize all issues during development</em></p>
    <p style="font-size:smaller">
      If an item is here is because has been discussed at some point, but Lluís B.
      has not understood either conceptually and/or how or where to implement it
      (otherwise, it's under development)
    </p>
</div><hr>
<!--items-->
<table class=todo_items border=1> <tr><th>Item description<th>Status<th>Added
  <!--single plant-->
    <tr><td header colspan=3>Single plant model
    <tr>
      <td>
        Electricity: please use the name "electricity, low voltage", and give the results in kWh/m3 treated activity water <br>
        FeCl3: please use the name "iron (III) chloride", and provide the results in kg active substance (actual FeCl3)/m3 treated activity water.
      <td>Requested by Pascal, TO DO
      <td>April 6th 2018
    <tr>
      <td>  Problem with TP, PO4 (inputs) and aP, PO4_eff (calculated) when no P removal: PO4_eff can get higher than PO4 if TP increases
      <td> help needed from L. Corominas
      <td>April 6th 2018
    <tr>
      <td>Rename NO<sub>x</sub> to NO<sub>3</sub> to match ecoinvent id (there is no NO<sub>2</sub>)
      <td>TO DO
      <td>April 6th 2018
    <tr>
      <td>
        Primary sludge and FeCl3 sludge
        <ul>
          <li>Primary settler sludge composition is unknown
          <li>Additional sludge produced by Chemical P removal composition is unknown
        </ul>
      <td>George to provide help<br>on Apr 10th call (15:00 PM Spain time)
      <td>April 5th 2018
    <tr>
      <td>Coarse solids removal
        <br>
        (Pascal knows how to calculate this, Peter may have data)
        <br>
        It is a formula that depends only on the flowrate (Q)
      <td> Lluís B. needs guidance
      <td>April 5th 2018
    </tr>

  <!--multiple plant--><tr><td header colspan=3>Multiple plant model
    <tr>
      <td>industrial factors [brewery, pig_manure, tanning_ww, thermomechanical_pulp_and_paper_ww]
        <ul>
          <li>CS_U [0.05, 0.08, 0.35, 0.30]
          <li>CS_B [0.80, 0.20, 0.35, 0.10]
          <li>X_B  [0.10, 0.65, 0.10, 0.15]
          <li>X_U  [0.05, 0.15, 0.20, 0.45]
        </ul>
        see <a href=see.php?file=estimations.js>equations here</a>
      <td>TO DO
        <br>(need to discuss user interface
        <br>with Yves and Lluís C.)
      <td>April 9th 2018

    <tr>
      <td>Marginal contribution expressed as /m<sup>3</sup> of activity influent
      <td>TO DO
      <td>April 4th 2018
    <tr>
      <td>Country data for averaging (a list of all inputs needed for each region can be found <a href="reference_data.php">here</a>)
        <br>Peter found typical data for:
        <ul>
          <li>Brazil
          <li>Switzerland
          <li>India
          <li>South Africa
          <li>Peru
          <li>Colombia
          <li>America
        </ul>
      <td>task assigned to Peter
      <td>April 4th 2018
    <tr>
      <td>Ecospold generation is under development <a href="ecospold/wastewater_treatment_tool/">here</a>
        <ul ecospold>
          <li>Develop technology mix "binary keyword 7 bits"
          <li>Differentiate PV from Q, relate to untreated fraction
          <li>The same python dictionary will generate both ecospold files
          <li>Uncertainty is done inside ecospold (Pascal)
          <li>
            Dictionary keys
            <ul>
              <li>"WW_properties"          is for amounts BEFORE CSO
              <li>"WW_influent_properties" is for amounts AFTER  CSO
            </ul>
          </li>
        </ul>
      <td>help provided by Pascal, under development
      <td>April 4th 2018
    <tr>
      <td>Show off data:
        <br>
        The user will be able to see what's happening in terms of equations
        <br>
        They will be able to acces all the wwtp data
      <td>not sure how to proceed, need concrete instructions
      <td>April 4th 2018
    <tr>
      <td>
        Documentation
        <ul>
          <li>overall approach (?)
          <li>how-to integrated in the tool (?)
          <li>ecospold documentation (?)
        </ul>
      <td>not sure how to proceed, need concrete instructions
      <td>April 4th 2018

  <!--gui related-->
    <tr><td header colspan=3>User interface related
    <tr>
      <td>change M&amp;E to M&amp;EA
      <td>done
      <td>April 4th 2018
  <!--server related-->
    <tr><td header colspan=3>Server related
    <tr>
      <td>Install python3 module "pandas"
      <td>done
      <td>April 4th 2018
  <!--new item-->
    <tr><td header colspan=3 style=background:lightgreen>NEW ITEM
    <tr id=new_item_form>
      <td style=padding:0.5em>
        <input id=desc placeholder="item description" value="item description" style=width:90%>
      <td style=padding:0.5em>
        <input id=stat placeholder="status" value="item status"                style=width:90%>
      <td style=text-align:center>
        <button onclick=send_item()>SEND</button>
        <script>
          function send_item(){
            var desc=document.querySelector('#new_item_form #desc').value;
            var stat=document.querySelector('#new_item_form #stat').value;
            if(desc==''||stat==''){return}
            var a=document.createElement('a');
            a.setAttribute('target','_blank');
            a.href='mailto:lbosch@icra.cat?subject=Ecoinvent: New TODO item&body=description: '+desc+'%0D%0A%0D%0Astatus: '+stat;
            document.body.appendChild(a);
            a.click();
          }
        </script>
      </td>
    </tr>
</table>

<style>
  table.todo_items td {
    font-size:smaller;
  }
  table.todo_items{
    margin-bottom:1em;
    border-collapse:collapse;
  }
  table.todo_items td[header]{
    font-weight:bold;
    text-align:left;
    background:#eee;
    font-style:italic;
    padding-left:8px;
  }
  /*description*/
  table.todo_items td:first-child{
    padding:0 1em 0 16px;
  }
  /*status*/
  table.todo_items td:nth-child(2){
    background:lightblue;
    font-style:italic;
    padding:0 5px;
  }
</style>

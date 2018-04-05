<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>TO DO items</title>
  <style>
    table.todo_items{
      margin-bottom:1em;
      border-collapse:collapse;
    }
    table.todo_items td[status]{
      background:lightblue;
      font-style:italic;
      font-size:smaller;
    }
    table.todo_items td[descr]{
      font-size:smaller;
      padding-left:2em;
    }
    table.todo_items td[header]{
      font-weight:bold;
      text-align:left;
      background:#eee;
      font-style:italic;
      padding-left:1em;
    }
  </style>
</head><body>
<?php include'navbar.php'?>
<div id=root>

<div>
  <h1>All TO DO items/tasks/doubts/issues/etc</h1>
  <p><em>This page is intended to centralize all issues during development</em></p>
  <p style="font-size:smaller">
    If an item is here is because has been discussed at some point, and Lluís B.
    has not understood either the concept itself and/or how to implement it
    (otherwise, it's under development)
  </p>
</div><hr>

<!--items-->
<table class=todo_items border=1>
  <tr><th>Item description<th>Status
  <!--single plant-->
    <tr><td header colspan=2>Single plant model
    <tr>
      <td descr>Rename NO<sub>x</sub> to NO<sub>3</sub>
      <td status>under development
    <tr>
      <td descr>Input estimation module for unknown inputs is done but still not integrated
      <td status>under development
    <tr>
      <td descr>Primary settler sludge composition is unknown
      <td status>help provided by George Ekama
    <tr>
      <td descr>Additional sludge produced by Chemical P removal composition is unknown
      <td status>George to provide help on Apr 6th call
    <tr>
      <td descr>Coarse solids removal
        <br>
        (Pascal knows how to calculate this, Peter may have data)
        <br>
        It is a formula that depends only on the flowrate (Q)
      <td status>not explained to Lluís B. how to calculate this
    </tr>

  <!--multiple plant-->
    <tr><td header colspan=2>Multiple plant model
    <tr>
      <td descr>Marginal contribution expressed as /m<sup>3</sup> of activity influent
      <td status>under development
    <tr>
      <td descr>Country data for averaging (a list of inputs needed for each region can be found <a href="reference_data.php">here</a>)
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
      <td status>task assigned to Peter
    <tr>
      <td descr>Ecospold generation is under development <a href="ecospold/wastewater_treatment_tool/">here</a>
        <ul ecospold>
          <li>develop technology 7 bit binary keyword
          <li>PV differentiate of Q, relate to untreated fraction
          <li>the same python dictionary will generate both ecospold files
          <li>Uncertainty is done inside ecospold (Pascal)
          <li>
            dictionary keys
            <ul>
              <li>"WW_properties"          is for amounts BEFORE CSO
              <li>"WW_influent_properties" is for amounts AFTER  CSO
            </ul>
          </li>
        </ul>
      <td status>help provided by Pascal
    <tr>
      <td descr>Show off data:
        <br>
        The user will be able to see what's happening in terms of equations
        <br>
        They will be able to acces all the wwtp data
      <td status>not sure how to proceed, need concrete instructions
    <tr>
      <td descr>
        Documentation
        <ul>
          <li style="font-size:smaller">overall approach (?)
          <li style="font-size:smaller">how-to integrated in the tool (?)
          <li style="font-size:smaller">ecospold documentation (?)
        </ul>
      <td status>not sure how to proceed, need concrete instructions

  <!--gui related-->
    <tr><td header colspan=2>Improve user interface
    <tr><td descr>change M&E to M&EA <td status>under development
</table>

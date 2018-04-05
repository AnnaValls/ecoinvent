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
      padding-left:15px;
    }
    table.todo_items td[header]{
      font-weight:bold;
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
  <tr><th>item description<th>status
  <!--single plant-->
    <tr><td header colspan=2>Single plant model
    <tr>
      <td descr>DOC and TOC are not used in the model
      <td status>not used in M&amp;E equations
    <tr>
      <td descr>CH<sub>4</sub> produced is not calculated
      <td status>nobody provided equations
    <tr>
      <td descr>Input estimation module for unknown inputs is under development
      <td status>Yves provided help
    <tr>
      <td descr>Primary settler sludge composition is unknown
      <td status>help provided by George Ekama
    <tr>
      <td descr>Additional sludge produced by Chemical P removal composition is unknown
      <td status>nobody provided equations
    <tr>
      <td descr>Coarse solids removal
      <td status>not explained to Lluís B. how to calculate this
  <!--multiple plant-->
    <tr><td header colspan=2>Multiple plant model
    <tr>
      <td descr>Marginal contribution expressed as /m<sup>3</sup> of activity influent
      <td status>under development
    <tr>
      <td descr>Country data for averaging (a list of inputs needed for each region can be found <a href="reference_data.php">here</a>)
      <td status>task assigned to Peter
    <tr>
      <td descr>Ecospold generation is under development <a href="ecospold/wastewater_treatment_tool/">here</a>
        <ul>
          <li>develop technology 7 bit binary keyword
          <li>PV differentiate of Q, relate to untreated fraction
          <li>the same python dictionary will generate both ecospold files
          <li>
            <pre>
            WW_influent_properties AFTER  CSO
            WW_properties          BEFORE CSO
            </pre>
          </li>
        </ul>
      <td status>help provided by Pascal
    <tr>
      <td descr>Uncertainty inside ecospold
      <td status>done by Pascal inside ecospold generation
    <tr>
      <td descr>Show off data
      <td status>not sure what this item is
    <tr>
      <td descr>
        Documentation
        <ul>
          <li style="font-size:smaller">overall approach (?)
          <li style="font-size:smaller">how-to integrated in the tool (?)
          <li style="font-size:smaller">ecospold documentation (?)
        </ul>
      <td status>task not started
</table>

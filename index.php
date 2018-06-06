<!doctype html><html><head>
  <?php include'imports.php'?>
  <!--css styles are at the end-->
  <title>Home</title>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Home page</h1><hr>

<!--content-->
<p style=max-width:50em>
  <!--introduction text-->
  <div>
    <p>
      The ecoinvent wastewater tool was developed to generate ecoinvent-compliant datasets for wastewater that is discharged to the sewer system. It is useful both for data providers that need to supply datasets on the fate of wastewater from the activity they are submitting data for, and for LCA modellers specifically interested in wastewater treatment.
    </p><p>
      Depending on the context, datasets are generated for the treatment of the wastewater in wastewater treatment plants (WWTP) and for wastewater that is directly discharged to the environment. For the treated fraction, the tool calculates the life cycle inventory of a WWTP (or a set of WWTP) with and without the input of the wastewater for which the datasets are generated, and bases the wastewater-specific life cycle inventory on the difference between the two simulations.
    </p><p>
      The steps for using the tool are:
      <ol>
        <li>Data entry: Enter information about the wastewater of interest: the nature and location of its source, its contamination levels, etc.
        <li>Calculation dashboard: Enter or modify the data on the wastewater treatment plants where the wastewater is being treated. The tool will calculate life cycle inventories for the WWTP operating with and without the input of the wastewater.
        <li>Generate datasets: The model outputs are converted into datasets, downloadable in ecoSpold format.
      </ol>
    </p><p>
      The datasets can then be submitted to ecoinvent for inclusion in the database. To do so, the
      <a href="https://www.ecoinvent.org/data-provider/data-provider-toolkit/ecospold2/ecospold2.html">ecoSpold</a>
      files should be opened in the
      <a href="https://www.ecoinvent.org/data-provider/data-provider-toolkit/ecoeditor/ecoeditor.html">ecoEditor</a>,
      checked, and then submitted directly via the ecoEditor.
    </p>
  </div><hr>

  <!--access button-->
  <div>
    <button
      id=btn_access
      onclick="window.location='simplified_data_entry.php'">
      Access the tool
    </button>
    <style>
      #btn_access {
        margin:auto;
        display:block;
        background-color: #5cb85c;
        border: 1px solid transparent;
        border-radius:4px;
        border-color: #ccc;
        color: #fff;
        cursor: pointer;
        font-size: 30px;
        font-weight: 400;
        line-height: 1.42857143;
        outline:none;
        padding: 6px 12px;
        text-align: center;
        user-select: none;
        vertical-align: middle;
        white-space: nowrap;
      }
      #btn_access:hover {
        background-color: #449d44;
        border-color: #398439;
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.05);
      }
      #btn_access:active {
        box-shadow:inset 0 0 10px #000;
      }
    </style>
  </div><hr>

  <!--other info-->
  <div>
    <ul>
      <li><a href="#" class=wip>Methodological report</a>
      <li><a href="additional_info.php">Additional info</a>
      <li><a href="todo.php">See all TO DO items</a>
    </ul>
  </div>
</p>

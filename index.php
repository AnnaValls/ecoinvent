<!doctype html><html><head>
  <?php include'imports.php'?>
  <!--css styles are at the end-->
  <title>Home</title>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Home page</h1><hr>

<!--content-->
<p style="max-width:50em">
  <!--pascal text-->
  <div>
    <p>
      The main purpose of the ecoinvent wastewater treatment tool is to generate
      datasets representing treatment of wastewater with specific composition using specific
      type of treatment. For more detailed information on the type of methodology
      used behind this tool, please see the Methodological Report (see the link below).
    </p>
    <p>
      This tool has been developed within the SRI project and is accessible for free to everybody.
    </p>
    <p>
      Depending on the context, datasets are generated for the treatment of the 
      wastewater in wastewater treatment plants (WWTP) and for wastewater that is directly
      discharged to the environment. For the treated fraction, the tool calculates
      the life cycle inventory of a WWTP (or a set of WWTP) with and without the input
      of the wastewater for which the datasets are generated, and bases the wastewater-specific
      life cycle inventory on the difference between the two simulations.
    </p>
    <p>
      The steps for using the tool are:
      <ol>
        <li><b>Data entry</b>: enter information about the wastewater of interest: the nature and location of its source, its contamination levels, etc.
        <li>
          <b>Calculation dashboard</b>: enter or modify the data on the wastewater treatment plants where the wastewater is being treated. 
          The tool will calculate life cycle inventories for the WWTP operating with and without the input of the wastewater.
        </li>
        <li><b>Generate datasets</b>: the model outputs are converted into datasets, downloadable in ecoSpold2 format.
        <li><b>Generating ecoSpold2 files.</b>
      </ol>
    </p>
  </div>

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
        font-weight: 200;
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
      <li><a href="docs/report/report.pdf" target=_blank>Methodological report (pdf)</a>
      <li><a href="additional_info.php">Additional info</a>
    </ul>
  </div>
</p>

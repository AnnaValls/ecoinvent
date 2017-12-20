<!doctype html><html><head>
  <?php include'imports.php'?>
  <!--css styles are at the end-->
  <title>Ecoinvent</title>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Home page</h1>
<p style=max-width:50em>
  <p style=max-width:50em>
    This is a placeholder for drafting the user interface.
    The goal is to have a functional backend first, and then implement a 'pretty design' on top of it.
    <hr>
  </p>

  <!--web parts-->
  <div>
    <p><b>Web parts</b></p>
    <ul>
      <li>
        Single plant model
        <ul>
          <li><a href=elementary.php  >Elementary flows (from Metcalf &amp; Eddy)</a>
          <li><a href=construction.php>Construction materials</a>
        </ul>
      <li>
        Multiple plant analysis
        <ul>
          <li><a href="activity.php">Create an Activity</a>
          <li><a href="activity/referenceData.php">Reference Data</a>
        </ul>
      <li>
        Appendix (all model parts)
        <ul>
          <li><a href=inputs.php            >All inputs</a>
          <li><a href=outputs.php           >All outputs</a>
          <li><a href=technologies.php      >All technologies</a>
          <li><a href=dataModel/constants.js>All constants</a>
          <li><a href=terms.php             >All terms</a>
        </ul>
      <li><a href=ecospold.php    >Generate results file (ecospold format)</a>
      <li><a href="README.md">README (tasks)</a>
      <li><a href=future>Future implementations (for 'n' plants)</a>
    </ul>
  </div><hr>

  <!--implementations-->
  <div>
    <p><b>Metcalf &amp; Eddy, Wastewater Engineering, 5th ed., 2014, technologies implemented:</b></p>
    <table border=1>
      <tr><th>Technology<th>Coding status
      <tr>
        <td>0. <a href="implementations/bod_removal_only.php">BOD removal example</a>
        <td>Done
      <tr>
        <td>1. <a href="implementations/bod_removal_with_nitrification.php">BOD removal w/ &amp; w/o nitrification</a>
        <td>Done
      <tr>
        <td>2. <a href="implementations/N_removal.php">N removal</a>
        <td>Done
      <tr>
        <td>3. <a href="implementations/bio_P_removal.php">P removal (biologically)</a>
        <td>Done
      <tr>
        <td>4. <a href="implementations/chem_P_removal.php">P removal (chemically)</a>
        <td>Done
      <tr>
        <td>5. <a href="implementations/ekama_sizing.php">Reactor sizing (optim. cost) [G. Ekama]</a>
        <td>Done
    </table>
  </div><hr>

  <!--other things-->
  <div>
    <p><b>Other things:</b></p>
    <ul>
      <li><a href=docs>Documents</a>
      <li>
        <a target=_blank href="https://docs.google.com/spreadsheets/d/1DiBhDCjxGyw2-umImIfHiZOzY5LJF_psGiD4fEf7Wgk/edit?usp=sharing">
          Google Drive document
        </a>
      </li>
      <li>Source code: <a href=//github.com/holalluis/ecoinvent>github.com/holalluis/ecoinvent</a>
      <li>Guillaume's github (for ecoSpold): 
        <a href="//github.com/ecoinvent/wastewater_treatment_tool">github.com/ecoinvent/wastewater_treatment_tool</a>
        <ul>
          <li>
            <a href="https://github.com/ecoinvent/wastewater_treatment_tool/blob/master/Generating%20ecoSPold%20files%20for%20WWT.ipynb">
              ecospold notebook
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</p>

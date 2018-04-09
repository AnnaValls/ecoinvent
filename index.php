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
    <ol>
      <li>
        Single plant model
        <ul>
          <li><a href="elementary.php"                          >Single plant model (Metcalf &amp; Eddy equations)</a>
          <li><a href="technologies.php"                        >All technologies</a>
          <li><a href="inputs.php"                              >All inputs</a>
          <li><a href="outputs.php"                             >All outputs</a>
          <li><a href="see.php?path=dataModel&file=constants.js">All constants</a>
          <li><a href="construction.php"                        >Construction materials</a>
        </ul>
      <li>
        Multiple plant analysis (<em>under development</em>)
        <ul>
          <li><a href="simplified_data_entry.php">Simplified data entry interface</a>
          <li><a href="marginal.php"             >Marginal approach</a>
          <li><a href="n-wwtp.php"               >Create multiple plants</a>
          <li><a href="reference_data.php"       >Influent default data by country</a>
          <li><a href="ecospold"                 >Generate ecospold file</a>
        </ul>
    </ol>
  </div><hr>

  <!--implementations-->
  <div>
    <p><b>Metcalf &amp; Eddy, Wastewater Engineering: technologies implemented from exercises</b></p>
    <table border=1>
      <tr><th>Technology<th>Source<th>Code
      <tr>
        <td>1. <a href="implementations/bod_removal_with_nitrification.php">Fractionation</a>
        <td>M&amp;EA 5th ed (p. 756)
        <td><a href="see.php?path=techs&file=fractionation.js">fractionation.js</a>
      <tr>
        <td>2. <a href="implementations/bod_removal_with_nitrification.php">BOD removal only</a>
        <td>M&amp;EA 5th ed (p. 756)
        <td><a href="see.php?path=techs&file=bod_removal_only.js">bod_removal_only.js</a>
      <tr>
        <td>3. <a href="implementations/bod_removal_with_nitrification.php">Nitrification</a>
        <td>M&amp;EA 5th ed (p. 762)
        <td><a href="see.php?path=techs&file=nitrification.js">nitrification.js</a>
      <tr>
        <td>4. <a href="implementations/bod_removal_with_nitrification.php">SST sizing</a>
        <td>M&amp;EA 5th ed (p. 767)
        <td><a href="see.php?path=techs&file=sst_sizing.js">sst_sizing.js</a>
      <tr>
        <td>5. <a href="implementations/N_removal.php">N removal</a>
        <td>M&amp;EA 5th ed (p. 810)
        <td><a href="see.php?path=techs&file=n_removal.js">n_removal.js</a>
      <tr>
        <td>6. <a href="implementations/bio_P_removal.php">P removal (biologically)</a>
        <td>M&amp;EA 5th ed (p. 880)
        <td><a href="see.php?path=techs&file=bio_P_removal.js">bio_P_removal.js</a>
      <tr>
        <td>7. <a href="implementations/chem_P_removal.php">P removal (chemically)</a>
        <td>M&amp;EA 5th ed (p. 484)
        <td><a href="see.php?path=techs&file=chem_P_removal.js">chem_P_removal.js</a>
      <tr>
        <td>8. Metals
        <td><a href="docs/gabor-doka-tool/">G. Doka excel tool</a>
        <td><a href="see.php?path=techs&file=metals_doka.js">metals_doka.js</a>
    </table>
  </div><hr>

  <!--other things-->
  <div>
    <p><b>Other things</b></p>
    <ul>
      <li><a href="README.md">README</a>
      <li><a href=docs>Documents</a>
      <li><a href="estimations.php">Input estimations (Y. Comeau)</a>
      <li><a href="fractionation_ekama.php">Fractionation (G. Ekama)</a>
      <li><a href=terms.php>Summary of terms</a>
      <li>
        <a href="implementations/bod_removal_only.php">BOD removal (simple example)</a>
        M&amp;EA 4th (p. 707)
      <li>
        <a href="implementations/ekama_sizing.php">Reactor sizing (optim. cost) [G. Ekama]</a>
      <li>
        <a target=_blank href="https://docs.google.com/spreadsheets/d/1DiBhDCjxGyw2-umImIfHiZOzY5LJF_psGiD4fEf7Wgk/edit?usp=sharing">
          shared google drive document "ecoinvent wastewater treatment project"
        </a>
      </li>
      <li>Github: <a href=//github.com/holalluis/ecoinvent>github.com/holalluis/ecoinvent</a>
      <li>Guillaume's github (ecoSpold):
        <ul>
          <li>
            <a href="//github.com/ecoinvent/wastewater_treatment_tool">
              github.com/ecoinvent/wastewater_treatment_tool
            </a>
          <li>
            <a href="https://github.com/ecoinvent/wastewater_treatment_tool/blob/master/Generating%20ecoSPold%20files%20for%20WWT.ipynb">
              August notebook (from P. Lesage)
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</p>

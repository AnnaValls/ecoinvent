<!doctype html><html><head>
  <?php include'imports.php'?>
  <!--css styles are at the end-->
  <title>Additional info</title>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Additional info</h1><hr>
<p style=max-width:50em>

  <!--implementations-->
  <div>
    <p><b>Modules implemented</b></p>
    <table border=1 style=border-collapse:collapse>
      <tr><th>Technology<th>Source<th>Code
      <tr>
        <td>1. Fractionation
        <td><a href="implementations/bod_removal_with_nitrification.php">M&amp;EA 5th ed (p. 756)</a>
        <td><a href="see.php?path=techs&file=fractionation.js">fractionation.js</a>
      <tr>
        <td>2. BOD removal
        <td><a href="implementations/bod_removal_with_nitrification.php">M&amp;EA 5th ed (p. 756)</a>
        <td><a href="see.php?path=techs&file=bod_removal_only.js">bod_removal_only.js</a>
      <tr>
        <td>3. Nitrification
        <td><a href="implementations/bod_removal_with_nitrification.php">M&amp;EA 5th ed (p. 762)</a>
        <td><a href="see.php?path=techs&file=nitrification.js">nitrification.js</a>
      <tr>
        <td>4. Denitrification
        <td><a href="implementations/N_removal.php">M&amp;EA 5th ed (p. 810)</a>
        <td><a href="see.php?path=techs&file=n_removal.js">n_removal.js</a>
      <tr>
        <td>5. P removal (biologically)
        <td><a href="implementations/bio_P_removal.php">M&amp;EA 5th ed (p. 880)</a>
        <td><a href="see.php?path=techs&file=bio_P_removal.js">bio_P_removal.js</a>
      <tr>
        <td>6. P removal (chemically)
        <td><a href="implementations/chem_P_removal.php">M&amp;EA 5th ed (p. 484)</a>
        <td><a href="see.php?path=techs&file=chem_P_removal.js">chem_P_removal.js</a>
      <tr>
        <td>7. SST sizing
        <td><a href="implementations/bod_removal_with_nitrification.php">M&amp;EA 5th ed (p. 767)</a>
        <td><a href="see.php?path=techs&file=sst_sizing.js">sst_sizing.js</a>
      <tr>
        <td>8. Metals and other elements
        <td><a href="docs/gabor-doka-tool/">G. Doka excel tool</a>
        <td><a href="see.php?path=techs&file=metals_doka.js">metals_doka.js</a>
      <tr>
        <td>9. CSO removal
        <td>Based on M&amp;EA fractionation
        <td><a href="see.php?path=techs&file=cso_removal.js">cso_removal.js</a>
      <tr>
        <td>10. Primary settler
        <td>G. Ekama
        <td><a href="see.php?path=techs&file=primary_settler.js">primary_settler.js</a>
      <tr>
        <td>11. Sludge composition
        <td>G. Ekama
        <td><a href="see.php?path=techs&file=sludge_composition.js">sludge_composition.js</a>
      <tr>
        <td>12. Energy consumption
        <td>G. Ekama, Y. Comeau, L.Corominas
        <td><a href="see.php?path=techs&file=energy_consumption.js">energy_consumption.js</a>
      <tr>
        <td>13. Figures, tables and appendixes
        <td>M&amp;EA 5th ed
        <td><a href="see.php?file=utils.js">utils.js</a>
      <tr>
        <td>14. <a href="estimations.php" >Input estimations</a>
        <td>BioWin 5.2
        <td><a href="see.php?file=estimations.js">estimations.js</a>
    </table>
  </div><hr>

  <!--other things-->
  <div>
    <p><b>Other things</b></p>
    <ul>
      <li><a href="terms.php" >Summary of terms</a>
      <!--
        <li><a href="docs"      >Documents</a>
        <li>
          <a href="implementations/ekama_sizing.php">Reactor sizing (optim. cost) [G. Ekama]</a>
        <li>
          <a target=_blank href="https://docs.google.com/spreadsheets/d/1DiBhDCjxGyw2-umImIfHiZOzY5LJF_psGiD4fEf7Wgk/edit?usp=sharing">
            Google drive "ecoinvent wastewater treatment project" document
          </a>
        </li>
        <li><a href=//github.com/holalluis/ecoinvent>github.com/holalluis/ecoinvent</a>
      -->
      <li><a href="elementary.php">Single plant model</a>
      <li><a href="//github.com/icra/ecoinvent/issues">Future TO DO items</a>
    </ul>
  </div>
</p>

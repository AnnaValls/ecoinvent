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
      <td status>help asked to George Ekama
    <tr>
      <td descr>Additional sludge produced by Chemical P removal composition is unknown
      <td status>nobody provided equations
    <tr>
      <td descr>Coarse solids removal
      <td status>not explained to Lluís B. how to calculate this
    <tr>
      <td descr>Conversion from CaCO<sub>3</sub> to Na<sub>2</sub>CO<sub>3</sub> factor value = 106g/100g to be confirmed by an expert
      <td status>confirmed by Yves
  <!--multiple plant-->
    <tr><td header colspan=2>Multiple plant model
    <tr>
      <td descr>Marginal contribution expressed as /m<sup>3</sup> of activity influent
      <td status>under development
    <tr>
      <td descr>Country data for averaging (a list of inputs needed for each region can be found <a href="reference_data.php">here</a>)
      <td status>task assigned to Peter
    <tr>
      <td descr>
        Untreated fraction:
        <br>there are countries without factors ("R/Q columns of unicef excel")
        <br>and countries without iso code identificator.
        <br>(see list below)
      <td status>help requested to Pascal and Lluís C.
    <tr>
      <td descr>Ecospold generation is under development <a href="ecospold/wastewater_treatment_tool/">here</a>
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

<!--geographies without RQ value-->
<div>
  <button class=toggleView onclick="toggleView(this,'geo_wo_rq')">&darr;</button>
  Geographies without R/Q value (148 of 385): <issue class=help_requested>Pascal and Lluís C.</issue>
  <ul id=geo_wo_rq>
    <li>Africa (RAF)
    <li>Åland Islands (AX)
    <li>Alaska Systems Coordinating Council (ASCC)
    <li>Alberta (CA-AB)
    <li>Aluminium producing area, EU27 and EFTA countries (IAI_Area,_EU27_&_EFTA)
    <li>Aluminium producing area, Europe outside EU27 and EFTA (IAI_Area,_Europe_outside_EU_&_EFTA)
    <li>Americas (UN-AMERICAS)
    <li>Anhui (安徽) (CN-AH)
    <li>Antarctica (AQ)
    <li>Asia (RAS)
    <li>Asia without China (Asia_without_China)
    <li>Asia, UN Region (UN-ASIA)
    <li>Australian Capital Territory (AUS-ACT)
    <li>Baltic System Operator (BALTSO)
    <li>Beijing (北京) (CN-BJ)
    <li>Bonaire, Sint Eustatius, and Saba (BQ)
    <li>Bouvet Island (BV)
    <li>British Columbia (CA-BC)
    <li>British Indian Ocean Territory (IO)
    <li>Canada without Alberta (Canada_without_Alberta)
    <li>Canada without Alberta and Quebec (Canada_without_Alberta_and_Quebec)
    <li>Canada without Quebec (Canada_without_Quebec)
    <li>Canary Islands (Canary_Islands)
    <li>Central America (UN-CAMERICA)
    <li>Central and Eastern Europe (EEU)
    <li>Central European Power Association (CENTREL)
    <li>China Southern Power Grid (CSG)
    <li>Chongqing (重庆) (CN-CQ)
    <li>Christmas Island (CX)
    <li>Churchill Falls Generating Station (Churchill_Falls)
    <li>Cocos (Keeling) Islands (CC)
    <li>Commonwealth of Independent States (FSU)
    <li>Eastern Africa (UN-EAFRICA)
    <li>Eastern Asia (UN-EASIA)
    <li>Eastern Europe (UN-EEUROPE)
    <li>Europe (RER)
    <li>Europe without Austria, Belgium, France, Germany, Italy, Liechtenstein, Monaco, San Marino, Switzerland, and the Vatican (RER_w/o_AT+BE+CH+DE+FR+IT)
    <li>Europe without Germany and Switzerland (RER_w/o_CH+DE)
    <li>Europe without Germany, the Netherlands, and Norway (RER_w/o_DE+NL+NO)
    <li>Europe without NORDEL (NCPA) (Europe_without_NORDEL_(NCPA))
    <li>Europe without Switzerland (Europe_without_Switzerland)
    <li>Europe, UN Region (UN-EUROPE)
    <li>Europe, without Russia and Turkey (Europe,_without_Russia_and_Turkey)
    <li>European Network of Transmission Systems Operators for Electricity (ENTSO-E)
    <li>Florida Reliability Coordinating Council (FRCC)
    <li>France, including overseas territories (France,_including_overseas_territories)
    <li>French Southern Territories (TF)
    <li>Fujian (福建) (CN-FJ)
    <li>Gansu (甘肃) (CN-GS)
    <li>Guangdong (广东) (CN-GD)
    <li>Guangxi (广西壮族自治区) (CN-GX)
    <li>Guernsey (GG)
    <li>Guizhou (贵州) (CN-GZ)
    <li>Hainan (海南) (CN-HA)
    <li>Heard Island and McDonald Islands (HM)
    <li>Hebei (河北) (CN-HB)
    <li>Heilongjiang (黑龙江省) (CN-HL)
    <li>Henan (河南) (CN-HE)
    <li>HICC (HICC)
    <li>Hong Kong (HK)
    <li>Hubei (湖北) (CN-HU)
    <li>Hunan (湖南) (CN-HN)
    <li>IAI producing Area 2, North America, without Quebec (IAI_Area_2,_without_Quebec)
    <li>IAI producing Area 4 and 5, South and East Asia, without China (IAI_Area_4&5_without_China)
    <li>IAl producing Area 1, Africa (IAI_Area_1)
    <li>IAl producing Area 2, North America (Al_producing_Area_2,_North_America)
    <li>IAl producing Area 3, South America (IAI_Area_3)
    <li>IAl producing Area 6A, West Europe (IAI_Area_6A)
    <li>IAl producing Area 6B, East/Central Europe (IAI_Area_6B)
    <li>IAl producing Area 8, Gulf-Aluminium Council/Gulf Region (IAI_Area_8)
    <li>Inner Mongol (内蒙古自治区) (CN-NM)
    <li>Jersey (JE)
    <li>Jiangsu (江苏) (CN-JS)
    <li>Jiangxi (江西) (CN-JX)
    <li>Jilin (吉林) (CN-JL)
    <li>Liaoning (辽宁) (CN-LN)
    <li>Macau (MO)
    <li>Manitoba (CA-MB)
    <li>Melanesia (UN-MELANESIA)
    <li>Micronesia (UN-MICRONESIA)
    <li>Middle Africa (UN-MAFRICA)
    <li>Middle East (RME)
    <li>Midwest Reliability Organization (MRO)
    <li>Midwest Reliability Organization, US part only (MRO,_US_only)
    <li>New Brunswick (CA-NB)
    <li>New South Wales (AUS-NSW)
    <li>Newfoundland and Labrador (CA-NF)
    <li>Ningxia (宁夏回族自治区) (CN-NX)
    <li>Nordic Countries Power Association (NORDEL)
    <li>Norfolk Island (NF)
    <li>North American Free Trade Agreement (NAFTA)
    <li>Northeast Power Coordinating Council (NPCC)
    <li>Northeast Power Coordinating Council, US part only (NPCC,_US_only)
    <li>Northern Territory (AUS-NTR)
    <li>Northwest Territories (CA-NT)
    <li>Nova Scotia (CA-NS)
    <li>Nunavut (CA-NU)
    <li>Ontario (CA-ON)
    <li>Palestinian Territory, Occupied (PS)
    <li>Pitcairn (PN)
    <li>Polynesia (UN-POLYNESIA)
    <li>Prince Edward Island (CA-PE)
    <li>Qinghai (青海) (CN-QH)
    <li>Québec (CA-QC)
    <li>Québec, Hydro-Québec distribution network (Québec,_HQ_distribution_network)
    <li>Queensland (AUS-QNS)
    <li>ReliabilityFirst Corporation (RFC)
    <li>Rest-of-World (RoW)
    <li>Saint Barthelemy (BL)
    <li>Saint Martin (MF)
    <li>Saskatchewan (CA-SK)
    <li>Serbia and Montenegro (CS)
    <li>SERC Reliability Corporation (SERC)
    <li>Shaanxi (陕西) (CN-SA)
    <li>Shandong (山东) (CN-SD)
    <li>Shanghai (上海) (CN-SH)
    <li>Shanxi (山西) (CN-SX)
    <li>Sichuan (四川) (CN-SC)
    <li>South America (UN-SAMERICA)
    <li>South Asia (SAS)
    <li>South Australia (AUS-SAS)
    <li>South Georgia and the South Sandwich Islands (GS)
    <li>South-Eastern Asia (UN-SEASIA)
    <li>Southern Europe (UN-SEUROPE)
    <li>Southwest Power Pool (SPP)
    <li>Spain, including overseas territories (Spain,_including_overseas_territories)
    <li>State Grid Corporation of China (SGCC)
    <li>Svalbard and Jan Mayen (SJ)
    <li>Taiwan, Province of China (TW)
    <li>Tasmania (AUS-TSM)
    <li>Texas Regional Entity (TRE)
    <li>Tianjin (天津) (CN-TJ)
    <li>UCTE without France (UCTE_without_France)
    <li>UCTE without Germany (UCTE_without_Germany)
    <li>UCTE without Germany and France (UCTE_without_Germany_and_France)
    <li>Union for the Co-ordination of Transmission of Electricity (UCTE)
    <li>United States Minor Outlying Islands (UM)
    <li>Victoria (AUS-VCT)
    <li>Western Africa (UN-WAFRICA)
    <li>Western Australia (AUS-WAS)
    <li>Western Electricity Coordinating Council (WECC)
    <li>Western Electricity Coordinating Council, US part only (WECC,_US_only)
    <li>Western Europe (WEU)
    <li>Xinjiang (新疆维吾尔自治区) (CN-XJ)
    <li>Xizang (西藏自治区) (CN-XZ)
    <li>Yukon Territory (CA-YK)
    <li>Yunnan (云南) (CN-YN)
    <li>Zhejiang (浙江) (CN-ZJ)
  </ul>
</div>

<!--countries without geography-->
<div>
  <button class=toggleView onclick="toggleView(this,'geo_wo_id')">&darr;</button>
  list of countries without ecoinvent iso code ------------- factor "R/Q"
  <ul id=geo_wo_id>
    <li><pre>Caribbean_Netherlands                           0</pre>
    <li><pre>Channel_Islands                                 0</pre>
    <li><pre>China,_Hong_Kong_Special_Administrative_Region  0.8451245556</pre>
    <li><pre>China,_Macao_Special_Administrative_Region      0</pre>
    <li><pre>West_Bank_and_Gaza_Strip                        0.2532744543</pre>
    <li><pre>Eastern_Asia_and_Southeastern_Asia              0.1468336581</pre>
    <li><pre>Least_Developed_Countries                       1</pre>
    <li><pre>Landlocked_developing_countries                 0.4283162653</pre>
    <li><pre>Small_island_developing_States                  0.4873039327</pre>
  </ul>
</div>

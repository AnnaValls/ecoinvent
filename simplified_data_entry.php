<?php /*
  //simplified user interface for inputs
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Data entry</title>
  <!--geographies-->
  <script src="dataModel/geographies.js"></script>
</head><body>
<?php include'navbar.php'?>

<div id=root>

<h1>Simplified data entry</h1>
<p>
  User interface only
  <issue class=under_dev></issue>
</p>

<div>
  <ol id=data_entry>
    <li>
      Wastewater source (activity name)<br>
      <input type=text     placeholder="activity name" max=120>

      <small>
        Average:
          <label><input type=radio name=average value=0 checked> No</label>
          <label><input type=radio name=average value=1> Yes</label>
      </small>

      <div>
        <small>
          <a href="#"
            onclick="(function(){
              var el=document.querySelector('#activity_name_help');
              el.style.display=el.style.display=='none'?'':'none';
            })();return false;">help</a>
        </small>
        <div id=activity_name_help style="display:none">
          <code><pre id=help>From ecoEditor:
            Activity Name
            The name describes the activity that is represented by this dataset.
            The activity name can only be edited when a new dataset is created.
            If you want to use this dataset under a new activity name,
            you need to create a new dataset with the desired name,
            using the current dataset as a template (menu File..., New..., FromExistingDataset).
            Length: 120
            Required: Yes
            EcoSpold02 FieldId: 100

            From DQG:
            Activity names are spelled with lower case starting letter, i.e. “lime production”, not “Lime production”.
            In the case of the WWT datasets, the name will depend on the situation:

            CASE 1: treatment of the wastewater from a specific source in an "average" WWTP
            CASE 2: treatment of the wastewater from a specific source in a "specific" WWTP technology/capacity
            CASE 3: treatment of average wastewater in an "average" WWTP
            CASE 4: treatment of average wastewater in a "specific" WWTP technology/capacity
          </pre></code>
          <script>
            //trim text in help
            (function(){
              var help=document.querySelector('#activity_name_help #help')
              var text=help.innerText;
              help.innerText="";
              text.split('\n').forEach(line=>{
                help.innerText+=line.trim()+"\n";
              });
            })();
          </script>
        </div>
      </div>
    </li>

    <li>
      <div>
        Country where the wastewater is being emitted
      </div>
      <div>
        <select id=geographies></select>
      </div>
    </li>

    <li>
      Volume of water discharged<br>
      <input type=number value=0> m<sup>3</sup>
      <div>
        <small>
        How to calculate this:
        (production_volume_of_activity_generating_wastewater · wastewater_per_unit_production)
        </small>
      </div>
    </li>

    <li>
      Wastewater composition
      <table id=inputs></table>
    </li>

    <li>
      Next steps?
      <issue class=help_wanted></issue>
    </li>
  </ol>
  <style>
    #data_entry > li {
      padding-bottom:8px;
      padding-top:8px;
      border-bottom:1px solid #ccc;
    }
  </style>
</div>

<!--app init: populate content default values-->
<script>
  //populate page default values
  (function(){
    //populate inputs
    (function(){
      var t=document.querySelector('#inputs');
      Inputs.filter(i=>{return !i.isMetal && !i.isParameter}).forEach(i=>{
        var newRow=t.insertRow(-1);
        newRow.title=i.descr;
        newRow.insertCell(-1).innerHTML=i.id.prettifyUnit();
        newRow.insertCell(-1).innerHTML="<input id="+i.id+" type=number value="+i.value+">";
        newRow.insertCell(-1).innerHTML="<small>"+i.unit.prettifyUnit()+"</small>";
      });
    })();

    //populate geographies
    (function(){
      var select=document.querySelector('#geographies');
      Geographies.forEach(g=>{
        var option=document.createElement('option');
        option.innerHTML=g.name.replace(/_/g,' ')
        option.value=g.shortcut.replace(/_/g,' ');
        select.appendChild(option);
      });
    })();

  })();
</script>

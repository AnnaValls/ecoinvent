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

<!--TODO-->
<p>
  User interface only
  <issue class=under_dev></issue>
</p>

<div id=root>

<h1>Simplified data entry</h1>

<div>
  <ol id=data_entry>
    <li>
      Wastewater source (activity name)<br>
      <input type=text placeholder="activity name" max=120 size=100>

      <small>
        Average:
          <label><input type=radio name=average value=0 checked> No</label>
          <label><input type=radio name=average value=1> Yes</label>
      </small> |
      <small>
        <a href="#"
          onclick="(function(){
            var el=document.querySelector('#activity_name_help');
            el.style.display=el.style.display=='none'?'':'none';
          })();return false;">help</a>
      </small>

      <div id=activity_name_help style="display:none">
        <code><pre id=help>
          If the wastewater originates from an activity within the ecoinvent
          database, you should enter the name of this activity here. For example, "lime
          production".
          This will generate a wastewater treatment dataset with the name
          "treatment of wastewater from **activity name**, **technology**", for example
          "treatment of wastewater from lime production, average, average capacity"
          If the wastewater is rather meant to be an average municipal
          wastewater, then enter the name "average".
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
    </li>

    <li>
      Wastewater treatment plant capacity (PCE: per capita equivalents)<br>
      <select>
        <option>Class 1: over      100,000 PCE
        <option>Class 2: 50,000 to 100,000 PCE
        <option>Class 3: 10,000 to  50,000 PCE
        <option>Class 4:  2,000 to  10,000 PCE
        <option>Class 5:     30 to   2,000 PCE
        <option>Average
      </select>
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
      Wastewater treatment technology mix <br>
      <table id=techs></table>
    </li>

    <li>
      <button class=toggleView onclick="toggleView(this,'inputs')">&darr;</button>
      Wastewater composition
      <table id=inputs></table>
    </li>

    <li>
      Next steps
      <ul>
        <li><button>Save</button> <small>saves the info in a file that can be uploaded in the future.</small>
        <li><button>Calculate and display results</button>
        <li><button>Calculate and generate ecoSPold</button>
        <li><button>Advanced</button>
          <div style="font-size:smaller">
            Modify advanced wastewater treatment parameters:
            with Q1 loaded with wastewater as descibed in this sheet and Q2
            loaded with default values for the WWTP technology of interest
            and the corresponding region. For now, this should probably
            only be available if model is for a single plant, and not for average treatment.
          </div>
        </li>
      </ul>
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
      Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
        var newRow=t.insertRow(-1);
        newRow.title=i.descr;
        newRow.insertCell(-1).innerHTML=i.id.prettifyUnit();
        newRow.insertCell(-1).innerHTML="<input id="+i.id+" type=number value="+i.value+">";

        //exception: units for Q are m3/year
        if(i.id=="Q"){i.unit="m3/year"}

        newRow.insertCell(-1).innerHTML="<small>"+i.unit.prettifyUnit()+"</small>";
      });
    })();

    //populate technologies
    (function(){
      var t=document.querySelector('#techs');
      Technologies_selected.filter(tec=>{return !tec.notActivable}).forEach(tec=>{
        var newRow=t.insertRow(-1);
        newRow.insertCell(-1).innerHTML=tec.descr;
        newRow.insertCell(-1).innerHTML="<input type=checkbox id=is_"+tec.id+"_active>";
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

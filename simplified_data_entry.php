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
      Wastewater treatment technologies of your plant/s <br>
      <table id=techs></table>
    </li>

    <li>
      <button class=toggleView onclick="toggleView(this,'inputs')">&rarr;</button>
      Wastewater composition
      <table id=inputs style=display:none></table>
    </li>

    <li>
      Next steps
      <ul id=next_steps>
        <!--calculate and display results-->
        <li>
          <button onclick="(function(){
            var url='elementary.php?'
            //user technologies activated
            Technologies_selected.filter(i=>{return !i.notActivable}).forEach(i=>{
              url+='is_'+i.id+'_active='+document.querySelector('#techs #is_'+i.id+'_active').checked+'&';
            });
            //user inputs
            Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
              url+=i.id+'='+document.querySelector('#inputs #'+i.id).value+'&';
            });
            window.location=url;
          })()">Calculate and display results</button>
          <br><small>Run 'single plant model' with current inputs provided</small>
        </li>

        <li>
          <button onclick="alert('under_development')">Save file</button>
          <br><small>Save the inputs provided in a file that can be uploaded in the future.</small>
        </li>

        <li>
          <button onclick="alert('under_development')">Calculate and generate ecoSPold</button>
          <br><small>will be implemented after ecospold generation</small>
        </li>
        <li><button onclick="alert('under_development')">Advanced</button>
          <div style="font-size:smaller">
            Modify advanced wastewater treatment parameters:
            only available if you are modelling a
            single wastewater treatment plant.
          </div>
        </li>

        <li>
          <button onclick="alert('under_development')">View background data</button>
          <br>
          <small>
            which would be associated with the "Show off data" item
          </small>
        </li>

        <li>
          <button onclick="alert('under_development')">Documentation</button>
          <br>
          <small>
            associated with the "access to documentation" item.
          </small>
        </li>
      </ul>
      <style>
        ul#next_steps button {
          padding:0.5em 1em;
          font-size:14px;
        }
      </style>
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

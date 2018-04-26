<?php /*
  simplified user interface
  entry point of the tool
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Data entry</title>
  <style>
    #root div.help {
      width:70%;
      display:block;
      padding:0.5em 0;
      font-size:smaller;
    }

    #root #data_entry > li {
      padding-bottom:8px;
      padding-top:8px;
    }
    #inputs td:first-child:hover {
      text-decoration:underline;
    }
  </style>
</head><body>
<?php include'navbar.php'?>

<!--top menu-->
<div class=flex id=top_menu style=background:#eee>
  <!--File-->
  <div>
    <button onclick="toggleView_top_menu_item('top_menu #file',event)"> File</button>
    <ul id=file style=display:none>
      <li>
        <!--load-->
        <div>
          <input id=loadFile type=file accept=".json" onchange="loadFile(event)" style="display:none">
          <button onclick="document.getElementById('loadFile').click()">Load</button>
          <script>
            //load country mix from file
            function loadFile(evt){
              var file=evt.target.files[0];
              var reader=new FileReader();
              reader.onload=function() {
                var saved_file;
                try{
                  saved_file=JSON.parse(reader.result);
                  (function(){
                    //name, location, industrial type
                    saved_file.general.forEach(el=>{
                      var input=document.getElementById(el.id);
                      if(input) input.value=el.value;
                    });
                    document.getElemen
                    saved_file.ww_composition.forEach(el=>{
                      var input=document.getElementById(el.id);
                      if(input) input.value=el.value;
                    });

                  })();
                }catch(e){alert(e)}
              }
              try{
                reader.readAsText(file);
              }catch(e){alert(e)}
            }
          </script>
        </div>
      <li>
        <!--save-->
        <div>
          <button onclick="saveToFile()">Save</button>
          <script>
            function saveToFile() {
              //generate empty saved file
                var saved_file = {
                  general:[],
                  ww_composition:[],
                };
              //general
                [
                  'activity_name',
                  'geography',
                  'ww_type',
                  'wwtp_type',
                ].forEach(id=>{
                  var value=document.querySelector('#'+id).value;
                  saved_file.general.push({id,value});
                });
              //ww_composition
                Inputs
                  .filter(i=>{return !i.isParameter})
                  .filter(i=>{return !i.canBeEstimated})
                  .forEach(i=>{
                    saved_file.ww_composition.push({
                      id:i.id,
                      value:parseFloat(document.querySelector('#'+i.id).value),
                      unit:i.unit,
                      descr:i.descr,
                  });
                });
              //generate file
                var datestring=(new Date()).toISOString().replace(/-/g,'').replace(/:/g,'').replace(/T/g,'_').substring(2,13);
                var link=document.createElement('a');
                link.href='data:text/json;charset=utf-8,'+JSON.stringify(saved_file,null,'  ');
                link.download='activity_ww_'+datestring+'_UTC.json';
                document.body.appendChild(link);//required in firefox
                link.click();
            }
          </script>
        </div>
      </li>
    </ul>
  </div>
  <!--click listener-->
  <script>
    //fold items when click outside
    document.documentElement.addEventListener('click',top_menu_fold_all_items);
  </script>
</div>

<div id=root>
<h1>Simplified data entry</h1>
<small>Enter the characteristics of your activity wastewater</small>
<hr>

<!--inputs-->
<div>
  <ol id=data_entry>
    <!--activity name-->
    <li>
      Wastewater source<br>
      <input id=activity_name type=text placeholder="activity name" max=120 size=100>
      <small><a href="#" onclick="toggleView(false,'activity_name_help');return false;">help</a></small>
      <div id=activity_name_help style="display:none">
        <div class=help>
          If the wastewater originates from an activity within the ecoinvent database, you should use the name of this activity here.
          For example, for wastewater originating from "lime production", you would write "from lime production".
          This will generate the first part of the name of the wastewater treatment datasets.
          In the example, it would be "treatment of wastewater from lime production".
          If the wastewater is the average municipal wastewater, then enter the name "average municipal".
          This will generate a name starting with "treatment of wastewater, average municipal".
          The second part of the name will be based on the treatment type.
        </div>
      </div>
    </li>

    <!--country-->
    <li>
      <div>Location where the wastewater is being emitted</div>
      <div>
        <select id=geography></select>
      </div>
    </li>

    <!--industrial ww type-->
    <li>
      Industrial wastewater type<br>
      <select id=ww_type>
        <option value="muni"> Type 0: Municipal
        <option value="hshd"> Type 1: Highly soluble     - high degradability (beverages industry wastewater)
        <option value="hphd"> Type 2: Highly particulate - high degradability (pig manure)
        <option value="hsld"> Type 3: Highly soluble     - low degradability  (tanning wastewater)
        <option value="hpld"> Type 4: Highly particulate - low degradability  (thermomechanical pulp and paper wastewater)
      </select>
    </li>

    <!--volume-->
    <li>
      Volume of water discharged per day<br>
      <input id=Q type=number value=1 min=0> m<sup>3</sup>/d | <small><a href="#" onclick="toggleView(false,'PV_help');return false;">help</a></small>
      <div id=PV_help style="display:none">
        <div class=help>
          How to calculate this:<br>
          yearly_production_volume_of_activity_generating_the_wastewater/365.25 · amount_of_wastewater_per_unit_of_production
        </div>
      </div>
    </li>

    <!--ww composition-->
    <li>
      <button class=toggleView onclick="toggleView(this,'inputs')">&rarr;</button>
      Wastewater composition
      <table id=inputs style=display:none></table>
    </li>

    <!--wwtp plant type-->
    <li>
      <div>Wastewater treatment plant type</div>
      <div>
        <select id=wwtp_type>
          <option value=specific selected>
            Specific WWTP
            &mdash;
            calculate the marginal contribution to a single treatment plant
          <option value=average>
            Country Average WWTP
            &mdash;
            calculate the marginal contribution to a multiple plant mix average
        </select>
      </div>
    </li>
    <!--next btn-->
    <li>
      <button id=next_btn onclick="(function(){
        //build URL string with GET parameters
        var url='';
        var activity_name = document.querySelector('#activity_name').value;
        var geography     = document.querySelector('#geography').value;
        var ww_type       = document.querySelector('#ww_type').value;
        var wwtp_type     = document.querySelector('#wwtp_type').value;
        var Q             = document.querySelector('#Q').value;
        url+='activity_name='+activity_name+'&';
        url+='geography='+geography+'&';
        url+='ww_type='+ww_type+'&';
        url+='wwtp_type='+wwtp_type+'&';
        url+='Q='+Q+'&';
        Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
          var el=document.querySelector('#inputs #'+i.id);
          if(el){url+=i.id+'='+el.value+'&';}
        });
        url='n-wwtp.php?'+url;
        //go to url
        window.location=url;
      })()">Next</button>
      <style>
        #next_btn {
          padding:default;
        }
      </style>
    </li>
  </ol>
  <style>
    #data_entry > li:not(:last-child) {
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
      Inputs
        //.filter(i=>{return true})
        .filter(i=>{return !i.isParameter})
        .filter(i=>{return !i.canBeEstimated})
        .filter(i=>{return i.id!="Q"}) //remove Q
        .forEach(i=>{
        var newRow=t.insertRow(-1);
        newRow.title=i.descr;
        newRow.insertCell(-1).innerHTML=i.id.prettifyUnit();
        newRow.insertCell(-1).innerHTML="<input id="+i.id+" type=number value="+i.value+">";
        newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
      });
    })();

    //populate geographies
    (function(){
      var select=document.querySelector('#geography');
      Geographies.forEach(g=>{
        var option=document.createElement('option');
        option.innerHTML=g.name.replace(/_/g,' ')
        option.value=g.shortcut.replace(/_/g,' ');
        select.appendChild(option);
      });
      select.value="GLO"; //default value: "global"
    })();
  })();
</script>

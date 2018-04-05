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
      border-bottom:1px solid #ccc;
    }
  </style>
</head><body>
<?php include'navbar.php'?>

<div id=root>

<h1>Simplified data entry</h1>

<!--load save-->
<ul>
  <!--load file-->
  <li><button onclick="(function loadFile(){
      alert('under development');
    })();">Load</button>
    <issue class=under_dev></issue>
  </li>
  <!--save file-->
  <li><button onclick="(function saveFile(){
      var saved_file = {
        general:[],
        ww_composition:[],
      }
      //get ww_composition
        Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
          if(i.id=='Q'){ i.unit='m3/year'; }
          saved_file.ww_composition.push({
            id:i.id,
            value:parseFloat(document.querySelector('#'+i.id).value),
            unit:i.unit,
            descr:i.descr,
          });
        });
      //get activity_name and country selected
        [
          'activity_name',
          'geography',
        ].forEach(id=>{
          var value=document.querySelector('#'+id).value;
          saved_file.general.push({ id, value });
        });
        //3. WWTP type
        saved_file.general.push({
          id:'wwtp_type',
          value:document.querySelector('input[name=wwtp]:checked').value,
        });

      //generate file
        var datestring=(new Date()).toISOString().replace(/-/g,'').replace(/:/g,'').replace(/T/g,'_').substring(2,13);
        var link=document.createElement('a');
        link.href='data:text/json;charset=utf-8,'+JSON.stringify(saved_file,null,'  ');
        link.download='ww_comp_'+datestring+'_UTC.json';
        document.body.appendChild(link);//required in firefox
        link.click();
    })();">Save</button>
  </li>
</ul>


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

    <!--volume-->
    <li>
      Volume of water discharged<br>
      <input id=PV type=number value=1 min=0> m<sup>3</sup>/year
      | <small><a href="#" onclick="toggleView(false,'PV_help');return false;">help</a></small>
      <div id=PV_help style="display:none">
        <div class=help>
          How to calculate this:<br>
          production_volume_of_activity_generating_wastewater · wastewater_per_unit_production
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
      <div> Wastewater treatment plant </div>
      <div>
        <!--specific-->
        <label><input type=radio name=wwtp value="specific" checked> Specific WWTP</label>
        &mdash;
        <small>take the user to to elementary flows</small>
        <br>

        <!--average-->
        <label><input type=radio name=wwtp value="average"> Default Average WWTP</label>
        &mdash;
        <small>take the user to the page of running the model n times</small>
        <br>

        <!--TODO-->
        <label><input type=radio name=wwtp value="average" disabled> New Average WWTP</label>
        &mdash;
        <small>the user creates customized wwtps (future)
          <issue class=TBD></issue>
        </small>
      </div>
    </li>

    <!--next btn-->
    <li id=next_btn>
      <button onclick="(function(){
        //check if user selected 'specific' or 'average'
        var wwtp=document.querySelector('input[name=wwtp]:checked').value;

        //build URL string with GET parameters
        var url='';

        //check type of wwt treatment
        if(wwtp=='specific'){
          //build URL string with GET parameters
          url='elementary.php?';
          var activity_name = document.querySelector('#activity_name').value;
          var geography     = document.querySelector('#geography').value;
          var PV            = document.querySelector('#PV').value;
          url+='activity_name='+activity_name+'&';
          url+='geography='+geography+'&';
          url+='PV='+PV+'&';
          Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
            var el=document.querySelector('#inputs #'+i.id);
            if(el){url+=i.id+'='+el.value+'&';}
          });
        }else if(wwtp=='average'){
          url='n-wwtp.php';
          //TODO
        }

        //go to built url
        window.location=url;
      })()">Next</button>
    </li>
  </ol>
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
        .filter(i=>{return i.id!="Q"}) //remove Q
        .forEach(i=>{
        var newRow=t.insertRow(-1);
        newRow.title=i.descr;
        newRow.insertCell(-1).innerHTML=i.id.prettifyUnit();
        newRow.insertCell(-1).innerHTML="<input id="+i.id+" type=number value="+i.value+">";
        newRow.insertCell(-1).innerHTML="<small>"+i.unit.prettifyUnit()+"</small>";
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

<footer>
  <div>Documentation</div>
</footer>

<?php /*
  simplified user interface for inputs
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

<ul>
  <li><button>Load</button>
  <li><button>Save</button>
</ul>

<div>
  <ol id=data_entry>
    <!--activity name-->
    <li>
      Wastewater source (activity name)<br>
      <input type=text placeholder="activity name" max=120 size=100>

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

    <!--country-->
    <li>
      <div>
        Country where the wastewater is being emitted
      </div>
      <div>
        <select id=geographies></select>
      </div>
    </li>

    <!--volume-->
    <li>
      Volume of water discharged<br>
      <input type=number value=0> m<sup>3</sup>/year
      <div>
        <small>
        How to calculate this:
        (production_volume_of_activity_generating_wastewater · wastewater_per_unit_production)
        </small>
      </div>
    </li>

    <!--ww composition-->
    <li>
      <button class=toggleView onclick="toggleView(this,'inputs')">&rarr;</button>
      Wastewater composition
      <table id=inputs style=display:none></table>
    </li>

    <!--wwtp plant-->
    <li>
      Wastewater treatment plant<br>
      <label><input type=radio name=wwtp_techs checked>Use country defaults</label> <br>
      <small>(this option takes the user to the page of running the model n times)</small>
      <br>
      <label><input type=radio name=wwtp_techs>Define a local plant</label>
      <br>
      <small>(goes to elementary flows)</small>
    </li>

    <!--next btn-->
    <li id=next_btn>
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
      })()">Next</button>
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
      Inputs
        //.filter(i=>{return true})
        .filter(i=>{return !i.isParameter})
        .forEach(i=>{
        var newRow=t.insertRow(-1);
        newRow.title=i.descr;
        newRow.insertCell(-1).innerHTML=i.id.prettifyUnit();
        newRow.insertCell(-1).innerHTML="<input id="+i.id+" type=number value="+i.value+">";

        //exception: units for Q are m3/year
        if(i.id=="Q"){
          i.unit="m3/year";
        }

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
        if(g.id=="Global"){
          option.selected=true; //TODO
        }
        select.appendChild(option);
      });
    })();
  })();
</script>

<footer>
  <div>Documentation</div>
</footer>

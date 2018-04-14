<?php /*
  Multiple plant interface
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <script src="elementary.js"></script>
  <script src="multiple.js"></script>
  <title>Multiple WWTPs</title>
  <script>
    //add a new object to WWTPs array
    function add_wwtp(){
      var wwtp={name:'new plant', perc_PE:100-WWTPs.map(w=>{return w.perc_PE}).reduce(function(pr,cu){return pr+cu},0)};

      //add technologies with the default value
      Object.keys(Technologies)
        .filter(key=>{return !Technologies[key].notActivable})
        .forEach(key=>{
          wwtp["is_"+key+"_active"]=getInput(key,true).value;
        });
      Inputs.forEach(inp=>{wwtp[inp.id]=inp.value;});
      WWTPs.push(wwtp);
      redisplay_wwtps();
    }

    //redraw wwtps
    function redisplay_wwtps(){
      //populate wwtps
      var table=document.querySelector('table#wwtps');
      table.innerHTML="";

      //add wttp names
      (function(){
        var newRow=table.insertRow(-1);
        newRow.insertCell(-1).outerHTML="<th rowspan=2>Inputs<th rowspan=2>Activity WW<th colspan='"+WWTPs.length+"'>WWTPs";

        //new row
        var newRow=table.insertRow(-1);

        //add a <td> for each WWTP
        WWTPs.forEach((wwtp,i)=>{
          //new cell
          var newCell=newRow.insertCell(-1);
          newCell.innerHTML="<input type=text value='"+wwtp.name+"' onchange=WWTPs["+i+"].name=this.value placeholder='name'>";

          //btn go to single plant model
          newCell.appendChild((function(){
            var btn=document.createElement('button');
            btn.innerHTML='Run';
            btn.title='Run these inputs in "Single plant model"';
            btn.addEventListener('click',function(){
              var url="elementary.php?";
              Object.keys(wwtp).forEach(key=>{
                var value=wwtp[key];
                url+=key+'='+value+'&';
              });
              window.open(url);
            });
            return btn;
          })());

          //btn delete wwtp
          newCell.appendChild((function(){
            var btn=document.createElement('button');
            btn.innerHTML='Delete';
            btn.addEventListener('click',function(){
              if(WWTPs.length<2){return;}
              WWTPs.splice(i,1);
              redisplay_wwtps();
            });
            return btn;
          })());
        });
      })();

      //add the percentage of PE treated (perc_PE)
      (function(){
        var newRow=table.insertRow(-1);
        newRow.insertCell(-1).outerHTML="<th title='Treated population equivalents'>Treated Pop. Eq. (%)";
        newRow.insertCell(-1).innerHTML="<center>-</center>"; //activity

        //add a <td> for each WWTP
        WWTPs.forEach((wwtp,i)=>{
          var newCell=newRow.insertCell(-1);
          newCell.innerHTML="<input type=number value='"+wwtp.perc_PE+"' onchange=WWTPs["+i+"].perc_PE=parseFloat(this.value);redisplay_perc_PE_sum()>";
        });
        newRow.insertCell(-1).outerHTML="<td id=perc_PE_sum>";
        redisplay_perc_PE_sum();
      })();

      //draw btn fold technologies
      (function(){
        var newRow=table.insertRow(-1);
        var newCell=document.createElement('th');
        newRow.appendChild(newCell);
        newCell.colSpan=3+WWTPs.length;
        newCell.style.textAlign='left';
        //add <button>+/-</button> Metals
        newCell.appendChild((function(){
          var btn=document.createElement('button');
          btn.innerHTML='↓';
          btn.addEventListener('click',function(){
            this.innerHTML=(this.innerHTML=='→')?'↓':'→';
            Technologies_selected
              .filter(tec=>{return !tec.notActivable})
              .forEach(i=>{
              var h=document.querySelector('#wwtps #is_'+i.id+'_active');
              h.style.display=h.style.display=='none'?'':'none';
            });
          });
          return btn;
        })());
        newCell.appendChild((function(){
          var span=document.createElement('span');
          span.innerHTML=' Technologies';
          return span;
        })());
      })();

      //add technologies
      (function(){
        //only technologies activable by user
        Technologies_selected
          .filter(tec=>{return !tec.notActivable})
          .forEach(tec=>{
            var newRow=table.insertRow(-1);
            newRow.id="is_"+tec.id+"_active";
            newRow.title=tec.comments ? tec.comments : "";

            //add tec name
            newRow.insertCell(-1).innerHTML=tec.descr;
            //first column: activity WW
            newRow.insertCell(-1).innerHTML="<center>-</center>";

            //add a checkbox for each tec
            WWTPs.forEach((wwtp,i)=>{
              var checked=WWTPs[i]["is_"+tec.id+"_active"] ? "checked" : "";
              newRow.insertCell(-1).outerHTML="<td style=text-align:center>"+
                "<input type=checkbox "+checked+" tech='"+tec.id+"' onclick=WWTPs["+i+"]['is_"+tec.id+"_active']^=true>"; //toggle boolean ("https://stackoverflow.com/questions/11604409/toggle-a-boolean-in-javascript")
            });
        });
      })();

      //function draw input
      function draw_input(inp){
        var newRow=table.insertRow(-1);
        newRow.title=inp.descr;
        newRow.id=inp.id;

        //add input name
        if(inp.canBeEstimated){
          newRow.insertCell(-1).outerHTML="<th class=help>"+inp.id+" <span title='Input estimated using COD, TKN and TP' style=float:right>&#9888;</span>";
        }else{
          newRow.insertCell(-1).outerHTML="<th class=help>"+inp.id;
        }

        //draw activity <input>
        var newCell=newRow.insertCell(-1);
        (function(){
          var value=(function(){
            if(typeof Activity[inp.id] == 'number'){
              return Activity[inp.id];
            }else{
              if(!inp.isParameter){
                var rv=getInputById(inp.id).value; //get default value
                Activity[inp.id]=rv;
              }
              return rv;
            }
          })();
          newCell.innerHTML=inp.isParameter ? "<center>-</center>":"<input onchange=Activity['"+inp.id+"']=parseFloat(this.value) value='"+value+"' type=number step=any min=0>";
        })();

        //draw <input> for each WWTP
        WWTPs.forEach((wwtp,i)=>{
          var newCell=newRow.insertCell(-1)
          var value=(function(){
            if(wwtp[inp.id]!=undefined){
              return wwtp[inp.id];
            }else{
              var v=getInputById(inp.id).value;
              wwtp[inp.id]=v;
              return v;
            }
          })();
          newCell.innerHTML="<input value='"+value+"' type=number step=any min=0 onchange=WWTPs["+i+"]['"+inp.id+"']=parseFloat(this.value)>"
        });
        newRow.insertCell(-1).outerHTML="<td class=unit>"+inp.unit.prettifyUnit();
      }

      //btn fold inputs
      (function(){
        var newRow=table.insertRow(-1);
        var newCell=document.createElement('th');
        newRow.appendChild(newCell);
        newCell.colSpan=3+WWTPs.length;
        newCell.style.textAlign='left';
        //add <button>+/-</button> Metals
        newCell.appendChild((function(){
          var btn=document.createElement('button');
          btn.innerHTML='↓';
          btn.addEventListener('click',function(){
            this.innerHTML=(this.innerHTML=='→')?'↓':'→';
            Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
              var h=document.querySelector('#wwtps #'+i.id);
              h.style.display=h.style.display=='none'?'':'none';
            });
          });
          return btn;
        })());
        newCell.appendChild((function(){
          var span=document.createElement('span');
          span.innerHTML=' Wastewater composition';
          return span;
        })());
      })();

      //add inputs
      Inputs.filter(inp=>{return !inp.isParameter}).forEach(inp=>{draw_input(inp)});
      //btn fold design parameters
      (function(){
        var newRow=table.insertRow(-1);
        var newCell=document.createElement('th');
        newRow.appendChild(newCell);
        newCell.colSpan=3+WWTPs.length;
        newCell.style.textAlign='left';
        //add <button>+/-</button> Metals
        newCell.appendChild((function(){
          var btn=document.createElement('button');
          btn.innerHTML='↓';
          btn.addEventListener('click',function(){
            this.innerHTML=(this.innerHTML=='→')?'↓':'→';
            Inputs.filter(i=>{return i.isParameter}).forEach(i=>{
              var h=document.querySelector('#wwtps #'+i.id);
              h.style.display=h.style.display=='none'?'':'none';
            });
          });
          return btn;
        })());
        newCell.appendChild((function(){
          var span=document.createElement('span');
          span.innerHTML=' Design parameters';
          return span;
        })());
      })();
      //add design parameters
      Inputs.filter(inp=>{return inp.isParameter}).forEach(inp=>{draw_input(inp)});
    }

    function init(){
      redisplay_wwtps();

      //populate outputs
      (function(){
        var table=document.getElementById('contribution');
        var outputs=compute_elementary_flows(WWTPs[0]).Outputs;

        var tbody=table.querySelector('#main');
        Object.keys(Outputs).filter(key=>{return !getInputById(key).isMetal}).forEach(key=>{
          populate_output(key,tbody);
        });

        var tbody=table.querySelector('#metals');
        Object.keys(Outputs).filter(key=>{return getInputById(key).isMetal}).forEach(key=>{
          populate_output(key,tbody);
        });

        function populate_output(key, tbody){
          var newRow=tbody.insertRow(-1);
          newRow.id=key;
          newRow.insertCell(-1).outerHTML="<th>"+key;
          newRow.insertCell(-1).outerHTML="<td influent>0";
          newRow.insertCell(-1).outerHTML="<td water>0";
          newRow.insertCell(-1).outerHTML="<td air>0";
          newRow.insertCell(-1).outerHTML="<td sludge>0";
        }
      })();

      //RUN automatically on start (PROVISIONAL) TODO
      run();
    }

    function run(){
      var result=n_wwtps_simulation(Activity,WWTPs);
      display_contribution(result);
    }
  </script>

  <script>
    //GUI
    //Display weighted contribution THIS CONVERTS G/D TO KG/D
    function display_contribution(result){
      var weighted_contribution=result.weighted_contribution;
      var weighted_output_mixed=result.weighted_output_mixed;

      //weighted flowrate
      var weighted_Q = WWTPs.map(w=>{return w.Q*w.perc_PE/100}).reduce(function(pr,cu){return pr+cu},0);

      var table=document.getElementById('contribution');

      //displayed unit
      var is_kg_per_m3_selected = document.querySelector('input[name=displayed_unit][value="kg/m3"]').checked;
      var is_percent_selected   = document.querySelector('input[name=displayed_unit][value="%"]').checked;

      Object.keys(Outputs).forEach(key=>{
        var row=document.querySelector('#contribution tr[id='+key+']');

        //influent
        var value1=weighted_contribution[key+"_influent"]/1000; //contribution
        var value2=weighted_output_mixed[key+"_influent"]/1000; //mixed influents
        var color = value1 ? "":"#ccc";

        if(is_kg_per_m3_selected){ 
          value1/=Activity.Q; 
          value2/=weighted_Q; 
        }else if(is_percent_selected){
          var percent=value2==0 ? 0 : 100*value1/value2;
        }

        row.querySelector('td[influent]').innerHTML=(function(){
          if(is_percent_selected){
            return format(percent,false,color)+" <small>%</small>";
          }else if(is_kg_per_m3_selected){
            return format(value1,false,color);
          }
          var rv="";
          rv+=format(value1,false,color);
          rv+="/";
          rv+=format(value2,false,color);
          return rv;
        })();

        //effluent
        ['water','air','sludge'].forEach(part=>{
          var value1=weighted_contribution[key+"_effluent_"+part]/1000; //contribution
          var value2=weighted_output_mixed[key+"_effluent_"+part]/1000; //mixed influents
          var color = value1 ? "":"#ccc";

          if(is_kg_per_m3_selected){ 
            value1/=Activity.Q; 
            value2/=weighted_Q; 
          }else if(is_percent_selected){
            var percent=value2==0 ? 0 : 100*value1/value2;
          }

          row.querySelector('td['+part+']').innerHTML=(function(){
            if(is_percent_selected){
              return format(percent,false,color)+" <small>%</small>";
            }else if(is_kg_per_m3_selected){
              return format(value1,false,color);
            }
            var rv="";
            rv+=format(value1,false,color);
            rv+="/";
            rv+=format(value2,false,color);
            return rv;
          })();
        });
      });
    }

    //redisplay sum of percentages of population equivalents
    function redisplay_perc_PE_sum(){
      var td=document.querySelector('#perc_PE_sum');
      var sum=WWTPs.map(w=>{return w.perc_PE}).reduce(function(prev,curr){return prev+curr});
      td.innerHTML="total: "+format(sum)+"%";
      td.style.color = sum==100 ? "":"red";
    }
  </script>

  <!--CSS-->
  <style>
    #wwtps, #contribution {
      border-collapse:collapse;
      font-size:smaller;
    }
    #contribution {
      width:100%;
    }
    #wwtps input[type=text],
    #wwtps input[type=number],
    #wwtps td button {
      width:60px;
      display:block;
      margin:auto;
    }
    #wwtps tr[id]:hover {
      text-decoration:underline;
      background:#fafafa;
    }
    #contribution td {
      text-align:right;
    }
    #results ul[id] {
      font-size:smaller;
    }
  </style>
</head><body onload="init()">
<?php include'navbar.php'?>
<?php include'top_menu_multiple.php'?>
<div id=root>
<!--title--><div>
  <h1>Multiple plant simulation</h1>
  <small>
    Study your activity's contribution to one or more wastewater treatment plants
  </small>
</div><hr>

<!--main-->
<div class=flex style=''>
  <!--inputs-->
  <div style='min-width:50%;border-right:1px solid #ccc;padding-right:8px;'>
    <p>
      <b> 1. Inputs </b>
      <!--RUN btn-->
      <span>
        <button
          title="Press this button after modifying the inputs to run the 'n' simulations"
          id=run onclick="run()">
          &#9654; RUN SIMULATION
        </button>
        <style>
          button#run {
            background:lightgreen;
            margin-left:1em;
            width:250px;
          }
        </style>
      </span>
    </p>
    <table id=wwtps border=1></table>
  </div>

  <!--results-->
  <div id=results style='min-width:45%;padding-left:8px'>
    <p>
      <b>2. Results</b>
      <span>
        <script src="generate_ecospold.js"></script>
        <button onclick="generate_ecospold()">Generate ecoSpold files</button>
      </span>
    </p>
    <!--2.1 effluent-->
    <div>
      <p>
        2.1
        <button class=toggleView onclick="toggleView(this,'results #contribution_container')">&darr;</button>
        Activity contribution
      </p>
      <div id=contribution_container>
        <div style=font-size:smaller>
          Select units:
          <label><input name=displayed_unit type=radio checked value="kg/d"  onclick=document.querySelector('#run').click()> kg/d</label>
          <label><input name=displayed_unit type=radio         value="%"     onclick=document.querySelector('#run').click()> %</label>
          <label><input name=displayed_unit type=radio         value="kg/m3" onclick=document.querySelector('#run').click()> kg/m<sup>3</sup><sub>activity ww</sub></label>
        </div>
        <table id=contribution border=1>
          <tr><th rowspan=2>Compound<th rowspan=2>Influent<th colspan=3>Effluent
          <tr><th>Water<th>Air<th>Sludge
          <tr><th colspan=5 style=text-align:left><button class=toggleView onclick="toggleView(this,'contribution #main')">&darr;</button>
            Main compounds
            <tbody id=main></tbody>
          <tr><th colspan=5 style=text-align:left><button class=toggleView onclick="toggleView(this,'contribution #metals')">&rarr;</button>
            Metals and other elements
            <tbody id=metals style=display:none></tbody>
        </table>
      </div>
    </div>

    <!--2.2 sludge-->
    <div>
      <p>
        2.2
        <button class=toggleView onclick="toggleView(this,'results #sludge_production')">&rarr;</button>
        Sludge production
        <ul id=sludge_production style=display:none>
          <li>Primary sludge
            <ul>
              <li>Removed TSS: <span id=TSS_removed_kgd>0</span>
                <ul style=font-family:monospace>
                  <li>H<sub>2</sub>O content: <span id=sludge_primary_water_content>0</span>
                </ul>
              <li>Removed VSS: <span id=VSS_removed_kgd>0</span>
                <ul style=font-family:monospace>
                  <li>C content: <span id=sludge_primary_C_content>0</span>
                  <li>H content: <span id=sludge_primary_H_content>0</span>
                  <li>O content: <span id=sludge_primary_O_content>0</span>
                  <li>N content: <span id=sludge_primary_N_content>0</span>
                  <li>P content: <span id=sludge_primary_P_content>0</span>
                </ul>
              </li>
            </ul>
          <li>Secondary sludge
            <ul>
              <li>P_X_TSS: <span id=P_X_TSS>0</span>
                <ul style=font-family:monospace>
                  <li>H<sub>2</sub>O content: <span id=sludge_secondary_water_content>0</span>
                </ul>
              <li>P_X_VSS: <span id=P_X_VSS>0</span>
                <ul style=font-family:monospace>
                  <li>C content: <span id=sludge_secondary_C_content>0</span>
                  <li>H content: <span id=sludge_secondary_H_content>0</span>
                  <li>O content: <span id=sludge_secondary_O_content>0</span>
                  <li>N content: <span id=sludge_secondary_N_content>0</span>
                  <li>P content: <span id=sludge_secondary_P_content>0</span>
                </ul>
              </li>
            </ul>
          <li>
            FeCl<sub>3</sub> additional sludge: <span id=Excess_sludge_kg>0</span>
            <ul style=font-family:monospace>
              <li>Fe content: <span id=sludge_precipitation_Fe_content>0</span>
              <li>H content: <span id=sludge_precipitation_H_content>0</span>
              <li>P content: <span id=sludge_precipitation_P_content>0</span>
              <li>O content: <span id=sludge_precipitation_O_content>0</span>
            </ul>
          </li>
        </ul>
      </p>
    </div>

    <!--2.3 co2-->
    <div>
      <p>
        2.3
        <button class=toggleView onclick="toggleView(this,'results #fossil_CO2')">&rarr;</button>
        Emitted CO<sub>2</sub>
        <ul id=fossil_CO2 style=display:none>
          <li>Non-biogenic (fossil): <span id=nonbiogenic_CO2>0</span>
          <li>Biogenic    : <span id=biogenic_CO2>0</span>
        </ul>
      </p>
    </div>

    <!--2.4 chemicals-->
    <div>
      <p>
        2.4
        <button class=toggleView onclick="toggleView(this,'results #chemicals')">&rarr;</button>
        Chemicals
        <ul id=chemicals style=display:none>
          <li>Dewatering polymers
            <ul>
              <li><em>Polyacrilamide</em>: <span id=Dewatering_polymer>0</span>
            </ul>
          </li>
          <li>Alkalinity to maintain pH ≈ 7.0
            <ul>
              <li>For Nitrification:       <span id=alkalinity_added>0</span>
              <li>For Denitrification:     <span id=Mass_of_alkalinity_needed>0</span>
            </ul>
          </li>
          <li>FeCl<sub>3</sub> used for chemical P removal
            <ul>
              <li>Volume per day:          <span id=FeCl3_volume>0</span>
              <li>Volume storage required: <span id=storage_req_15_d>0</span>
            </ul>
          </li>
        </ul>
      </p>
    </div>

    <!--2.5 energy-->
    <div>
      <p>
        2.5
        <button class=toggleView onclick="toggleView(this,'results #energy')">&rarr;</button>
        Energy
        <ul id=energy style=display:none>
          <li>Aeration:                    <span id=aeration_power>0</span>
          <li>Anoxic Mixing:               <span id=mixing_power>0</span>
          <li>Pumping:                     <span id=pumping_power>0</span>
            <ul>
              <li>Influent pumping:        <span id=pumping_power_influent>0</span>
              <li>External recirculation:  <span id=pumping_power_external>0</span>
              <li>Internal recirculation:  <span id=pumping_power_internal>0</span>
              <li>Wastage  recirculation:  <span id=pumping_power_wastage> 0</span>
            </ul>
          </li>
          <li>Dewatering:                  <span id=dewatering_power>0</span>
          <li>Other:                       <span id=other_power>0</span>
          <li>Total energy
            <ul>
              <li>As power needed:   <span id=total_power>0</span>
              <li>As energy per day: <span id=total_daily_energy>0</span>
              <li>As energy per m3:  <span id=total_energy_per_m3>0</span>
            </ul>
        </ul>
      </p>
    </div>

    <!--2.6 other-->
    <div>
      <p>
        2.6
        <button class=toggleView onclick="toggleView(this,'results #other')">&rarr;</button>
        Other
        <ul id=other style=display:none>
          <li>TBD
        </ul>
      </p>
    </div>
  </div>
</div>
</html>

<!--URL-->
<script>
  /*URL: GET params*/
  //max URL lengh is 2000 chars: "https://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers"
  var url=new URL(window.location.href);
  console.log("URL length: "+url.href.length+" chars (OK below 2000 chars)");
  if(url.href.length>2000){alert("Error: the URL length is above 2000 characters");}
  //url.searchParams.get('param');
</script>

<!--backend-->
<script>
  //main object for storing WWTPs
  var WWTPs=[];
  //main object for storing the Activity inputs
  var Activity={ Q:100 };

  //GET activity inputs from URL
  Inputs
    .filter(i=>{return !i.isParameter})
    .filter(i=>{return !i.canBeEstimated})
    .forEach(i=>{
      var get_param_value=url.searchParams.get(i.id);
      if(get_param_value!=null){
        Activity[i.id]=parseFloat(get_param_value);
      }
    });
</script>

<!--load country data if wwtp_type is "average"-->
<script src="mix_SAfrica.js"></script>
<script>
  (function(){
    var wwtp_type = url.searchParams.get('wwtp_type');
    if(wwtp_type=="average"){
      //convert mix_SAfrica to array of objects
      var mix_SAfrica_arr=[];
      (function(){
        for(var i=0;i<4;i++){
          mix_SAfrica_arr.push({});
          for(var field in mix_SAfrica){
            mix_SAfrica_arr[i][field]=mix_SAfrica[field][i];
          }
        }
      })();
      WWTPs=mix_SAfrica_arr;
    }else{
      add_wwtp();//add one wwtp by default
    }
  })();
</script>

<!--input estimations-->
<script>
  //calculate estimations for both Activity and WWTPs
  WWTPs.concat(Activity).forEach(wwtp=>{
    var ests=estimations(wwtp.COD,wwtp.TKN,wwtp.TP);
    Object.keys(ests.outputs).forEach(key=>{
      wwtp[key]=Math.round(ests.outputs[key]*100)/100;
    });
  });
</script>

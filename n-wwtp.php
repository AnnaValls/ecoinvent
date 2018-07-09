<?php /*
  Multiple plant user interface
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <script src="elementary.js"></script><!--single plant model backend-->
  <script src="multiple.js"></script><!--multiple plant model backend-->
  <title>2/4 Calculation dashboard</title>

  <!--frontend-->
  <script>
    function init(){
      redisplay_wwtps();

      //populate outputs
      (function(){
        var table=document.getElementById('contribution');
        var outputs=compute_elementary_flows(WWTPs[0]).Outputs;

        var tbody=table.querySelector('#main');
        tbody.innerHTML="";
        Object.keys(Outputs).filter(key=>{return !getInputById(key).isMetal}).forEach(key=>{
          populate_output(key,tbody);
        });

        var tbody=table.querySelector('#metals');
        tbody.innerHTML="";
        Object.keys(Outputs).filter(key=>{return getInputById(key).isMetal}).forEach(key=>{
          populate_output(key,tbody);
        });

        function populate_output(key, tbody){
          var newRow=tbody.insertRow(-1);
          newRow.title=Outputs[key].descr;
          newRow.id=key;
          newRow.insertCell(-1).outerHTML="<th>"+key.prettifyUnit();
          newRow.insertCell(-1).outerHTML="<td influent>0";
          newRow.insertCell(-1).outerHTML="<td water>0";
          newRow.insertCell(-1).outerHTML="<td air>0";
          newRow.insertCell(-1).outerHTML="<td sludge>0";
        }
      })();

      //RUN automatically on start
      run();
    }

    //execute model wrapper (call backend+frontend)
    var Result={};
    function run(){
      var btn_run=document.getElementById('run');
      btn_run.disabled=true; //disable the button to avoid double clicking
      btn_run.innerHTML="Running...";

      //run n times 'compute elementary flows'
      Result=n_wwtps_simulation(Activity,WWTPs); //{weighted_contribution, weighted_reference, weighted_mixed}

      //send 'result' to the button generate ecospold
      var btn_generate_ecospold=document.getElementById('btn_generate_ecospold');
      btn_generate_ecospold.disabled=false;

      //table contribution
      display_contribution_Outputs(Result);

      //create table "all_contributions"
      (function(){
        var container=document.querySelector('#results #all');
        container.innerHTML="";
        container.appendChild(display_contribution_All(Result));
      })();

      //visually display 'simulation completed'
      btn_run.innerHTML="Simulation complete!";
      setTimeout(function(){
        btn_run.innerHTML=btn_run.getAttribute('text');
        btn_run.disabled=false; //enable button again
      },1500);
    }

    //add a new object to WWTPs array
    function add_wwtp(){
      var wwtp={
        name:'new plant',
        perc_PE:100-WWTPs.map(w=>{return w.perc_PE}).reduce(function(pr,cu){return pr+cu},0)
      };
      //add technologies with default values
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
        newRow.insertCell(-1).outerHTML="<th rowspan=2>Inputs"+
          "<th rowspan=2 title='Activity wastewater'>Activity<br>WW"+
          "<th colspan='"+WWTPs.length+"' title='Wastewater treatment plants'>WWTPs";

        //new row
        var newRow=table.insertRow(-1);

        //add a <td> for each WWTP
        WWTPs.forEach((wwtp,i)=>{
          //new cell
          var newCell=newRow.insertCell(-1);
          newCell.innerHTML="<input type=text value='"+wwtp.name+"' onchange=WWTPs["+i+"].name=this.value placeholder='name'>";

          //container for buttons 'run' and 'delete'
          var div=document.createElement('div');
          newCell.appendChild(div);

          //btn go to single plant model
          div.appendChild((function(){
            var btn=document.createElement('button');
            btn.innerHTML='Run alone';
            btn.title='Open window to run a simulation of the reference WWTP only';
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

          //btn run with mixed activity
          div.appendChild((function(){
            var btn=document.createElement('button');
            btn.innerHTML='Run with activity';
            btn.title='Open window to run a simulation of the reference WWTP plus the activity wastewater';
            btn.addEventListener('click',function(){
              var mixed_influent = mix_influents(Activity,wwtp);
              var url="elementary.php?";
              Object.keys(mixed_influent).forEach(key=>{
                var value=mixed_influent[key];
                url+=key+'='+value+'&';
              });
              window.open(url);
            });
            return btn;
          })());

          //btn delete wwtp
          div.appendChild((function(){
            var btn=document.createElement('button');
            btn.innerHTML='Delete';
            if(WWTPs.length==1){btn.disabled=true;}
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
          btn.classList.add('toggleView');
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
            newRow.insertCell(-1).outerHTML="<td>"+tec.descr;
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
          btn.classList.add('toggleView');
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
          btn.classList.add('toggleView');
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

    //update table 'contributions' (outputs ONLY) THIS CONVERTS G/D TO KG/D
    function display_contribution_Outputs(result){
      //pick table from gui
      var table=document.getElementById('contribution');

      //get the 'Outputs' object only
      var outputs_contr = result.weighted_contribution.Outputs;
      var outputs_mixed = result.weighted_mixed.Outputs;
      //calculate the weighted flowrate
      var weighted_Q=WWTPs.map(w=>{return w.Q*w.perc_PE/100}).reduce(function(pr,cu){return pr+cu},0);

      //check selected unit to display
      var is_kg_per_m3_selected = document.querySelector('input[name=displayed_unit][value="kg/m3"]').checked;
      var is_percent_selected   = document.querySelector('input[name=displayed_unit][value="%"]').checked;

      Object.keys(Outputs).forEach(key=>{
        var row=document.querySelector('#contribution tr[id='+key+']');
        //draw outputs
        ['influent','water','air','sludge'].forEach(part=>{
          if(part=='influent'){
            var value1=outputs_contr[key+"_influent"].value/1000; //contribution
            var value2=outputs_mixed[key+"_influent"].value/1000; //mixed influents
          }else{
            var value1=outputs_contr[key+"_effluent_"+part].value/1000; //contribution
            var value2=outputs_mixed[key+"_effluent_"+part].value/1000; //mixed influents
          }
          if(is_kg_per_m3_selected){
            value1/=Activity.Q;
            value2/=weighted_Q;
          }else if(is_percent_selected){
            var percent = value2==0 ? 0 : 100*value1/value2;
          }
          var color = value1 ? "":"#ccc";
          row.querySelector('td['+part+']').innerHTML=(function(){
            if(is_percent_selected){
              return format(percent,false,color)+" <small>%</small>";
            }else if(is_kg_per_m3_selected){
              return format(value1,false,color);
            }//else
            var rv=format(value1,false,color)+"/"+format(value2,false,color);
            return rv;
          })();
        });
      });
    }

    //create table 'all_contributions'
    function display_contribution_All(result){
      var table=document.createElement('table');//new table
      table.setAttribute('border',1);
      table.id="all_contributions";
      //add headers
      table.insertRow(-1).outerHTML="<tr><th>Variable<th>Contribution<th>Unit<th>Percent contribution";

      //the user can display the results normalized per m3 of activity
      var is_normalized_selected = document.querySelector('input[name=displayed_unit_normalized][value="yes"]').checked;
      var is_displayed_non_zero_only_selected = document.querySelector('input[name=displayed_non_zero_only][value="yes"]').checked;

      //go through technologies
      Object.keys(result.weighted_mixed).forEach(tec=>{
        //create a tbody for each technology
        var tec_tbody = document.createElement('tbody');
        table.appendChild(tec_tbody);
        tec_tbody.setAttribute('tec',tec);

        var is_revealed = Options.revealedTechs.indexOf(tec)+1;
        tec_tbody.style.display= is_revealed ? '':'none'; //default display of tbody

        //get array of calculated variables (keys only) and which value is greater than 0, ie ['P_X_bio','P_X_VSS,...']
        var tec_keys=(function(){
          var rv=[];
          Object.keys(result.weighted_contribution[tec]).forEach(key=>{
            var value=result.weighted_contribution[tec][key].value;
            var format_value=format(value);
            if(is_displayed_non_zero_only_selected){
              if(format_value!="0" && format_value!="-0"){
                rv.push(key);
              }
            }else{
              rv.push(key);
            }
          });
          return rv;
        })();

        //new header row with toggleView btn
        if(tec_keys.length){
          var newRow = document.createElement('tr');
          table.insertBefore(newRow,tec_tbody);
          var tec_name = Technologies[tec] ? Technologies[tec].Name : tec.prettifyUnit();
          tec_name = tec_name[0].toUpperCase()+tec_name.slice(1);

          newRow.insertCell(-1).outerHTML=(function(){
            return "<th colspan=4 style=text-align:left>"+
              "<button class=toggleView onclick=\"toggleView_tbody(this,'"+tec+"')\">"+
              "&"+(is_revealed?"d":"r")+"arr;"+
              "</button> "+ //symbol of button depends on is_revealed
              tec_name+
              " ("+tec_keys.length+")"+
              "";
          })();
        }

        //go through keys
        tec_keys.forEach(key=>{
          var key_tr = document.createElement('tr');
          tec_tbody.appendChild(key_tr);
          key_tr.outerHTML=(function(){
            var item1 = result.weighted_contribution[tec][key];
            var item2 = result.weighted_mixed[tec][key];
            var title = item1.descr;
            var value1 = item1.value;
            var value2 = item2.value;
            var percent = (value2==0)?0:(100*value1/value2);
            var percent_color =(percent==0)?'':(percent<0?"lightgreen":"red");
            var percent_plus = percent>0 ? "<span style=color:red>+</span>":"";

            //divide contribution per m3 of activity if selected
            if(is_normalized_selected){ value1/=Activity.Q; }

            var format_value1 = format(value1);
            var format_value2 = format(value2);
            var format_unit   = item1.unit.prettifyUnit();

            //mark text somehow if normalized
            if(is_normalized_selected){
              format_value1 = "<span>"+format_value1+"</span>";
            }

            //display contribution and total amount
            var format_contribution = is_normalized_selected ? format_value1 : format_value1+"/"+format_value2;

            return ""+
              "<tr id='"+key+"' title='"+title+"'><th style=font-family:monospace;text-align:left>"+key+
              "<td style=text-align:right>"+format_contribution+
              "<td><small>"+format_unit+"</small>"+
              "<td style=text-align:right>"+percent_plus+""+format(percent,false,percent_color)+" <small>%</small>"+
              "";
          })();
        });
      });
      return table;
    }

    //redisplay sum of percentages of population equivalents
    function redisplay_perc_PE_sum(){
      var td=document.querySelector('#perc_PE_sum');
      var sum=WWTPs.map(w=>{return w.perc_PE}).reduce(function(prev,curr){return prev+curr});
      td.outerHTML="<td style=text-align:center>total: "+format(sum)+"%</td>";
      td.style.color = sum==100 ? "":"red";
    }
  </script>

  <!--user options-->
  <script>
    //options
    var Options={
      revealedTechs:[ ], //since table "all_contributions" is redisplayed each time we need to keep track of revealed tbodys
    }

    //fold button for table 'all_contributions'
    function toggleView_tbody(btn,tec){
      toggleView(btn,'all_contributions tbody[tec='+tec+']'); //'format.js'
      if(Options.revealedTechs.indexOf(tec)==-1){
        Options.revealedTechs.push(tec);
      }else{
        Options.revealedTechs=Options.revealedTechs.filter(t=>{return t!=tec});
      }
    }
  </script>

  <!--css-->
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
      display:block;
      margin:1px;
      width:60px;
    }
    #wwtps td button {
      width:66px;
      font-size:9px;
      border:1px solid #ccc;
    }
    #wwtps td button:first-child { margin-top:1px; }
    #wwtps td button:not(:last-child) { margin-bottom:-2px; }
    #wwtps td button:active {
      box-shadow:inset 0 0 10px #ccc;
    }
    #wwtps td button:hover { color:blue; }

    #wwtps tr[id]:hover,
    #contribution tr[id]:hover {
      text-decoration:underline;
    }
    #contribution td {
      text-align:right;
    }
    #all_contributions {
      border-collapse:collapse;
      font-size:smaller;
      width:100%;
    }
    #all_contributions td {
      font-weight:normal;
    }
    #all_contributions tr[id]:hover {
      text-decoration:underline;
    }
  </style>
</head><body onload="init()">
<?php include'navbar.php'?>
<?php include'top_menu_multiple.php'?>
<div id=root>

<!--title--><div>
  <h1>
    2. Calculation dashboard
    <small>(step 2 of 4)</small>
  </h1>

  <div style=text-align:right>
    Next step:
    <button
      class=next_btn
      id=btn_generate_ecospold onclick="generate_ecospold(Result)">
        Results dataset
    </button>
    <script src="generate_json_for_ecospold.js"></script>
  </div><hr>

  <small>
    Study the contribution of your activity to one or more wastewater treatment plants
  </small>
</div><hr>


<!--main--><div class=flex>
  <!--inputs-->
  <div style='min-width:50%;border-right:1px solid #ccc;padding-right:8px;'>
    <p>
      <b> 1. Inputs </b>
    </p>
    <table id=wwtps border=1></table>
  </div>

  <!--results-->
  <div id=results style='min-width:45%;max-width:49%;padding-left:8px'>
    <p>
      <div class=flex style=justify-content:space-between>
        <div> <b>2. Results</b> </div>
        <!--RUN btn-->
        <div>
          <button
            title="Click here after modifying inputs"
            text="<span style=font-size:14px>&#10227</span> REFRESH RESULTS"
            id=run onclick="run()">
          </button>
          <script>
            (function(){
              //init run button innerHTML
              var btn=document.querySelector('button#run');
              btn.innerHTML=btn.getAttribute('text');
            })();
          </script>
          <style>
            button#run {
              background:lightgreen;
              width:200px;
              height:25px;
              vertical-align:middle;
              display:block;
            }
          </style>
        </div>
      </div>
    </p>

    <!--2.1 effluent-->
    <div>
      <p>
        2.1
        <button class=toggleView onclick="toggleView(this,'results #contribution_container')">&darr;</button>
        Contribution: influent/effluent only
      </p>
      <div id=contribution_container>
        <table style=font-size:smaller>
          <tr><td>Select units:
          <td>
            <label><input name=displayed_unit type=radio checked value="kg/d"  onclick=document.querySelector('#run').click()> kg/d</label>
            <label><input name=displayed_unit type=radio         value="%"     onclick=document.querySelector('#run').click()> %</label>
            <label><input name=displayed_unit type=radio         value="kg/m3" onclick=document.querySelector('#run').click()> kg/m<sup>3</sup><sub>activity ww</sub></label>
          </tr>
        </table>
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

    <!--2.2 All-->
    <div>
      <p>
        2.2
        <button class=toggleView onclick="toggleView(this,'results #all_container')">&darr;</button>
        Contribution: all characteristics
        <div id=all_container>
          <table style=font-size:smaller>
            <tr>
              <td> Display only contributions greater than zero:
              <td>
                <label><input name=displayed_non_zero_only type=radio         value="no"  onclick="run()"> No </label>
                <label><input name=displayed_non_zero_only type=radio checked value="yes" onclick="run()"> Yes</label>
              </td>
            <tr>
              <td>Normalize contributions per activity Q (m<sup>3</sup>/d):
              <td>
                <label><input name=displayed_unit_normalized type=radio checked value="no"  onclick="run()"> No </label>
                <label><input name=displayed_unit_normalized type=radio         value="yes" onclick="run()"> Yes</label>
              </td>
          </table>
          <div id=all style=display:nonee></div>
        </div>
      </p>
    </div>
  </div>
</div>

</html>

<!--url-->
<script>
  /*URL: GET params*/
  //max URL lengh is 2000 chars: "https://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers"
  var url=new URL(window.location.href);
  //console.log("URL length: "+url.href.length+" chars (OK below 2000 chars)"); //debug
  if(url.href.length>2000){alert("Error: the URL length is above 2000 characters");}
  //url.searchParams.get('param');
</script>

<!--backend-->
<script>
  //main object for storing WWTPs
  var WWTPs=[];
  //main object for storing the Activity inputs
  var Activity={ Q:1, };

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
  (function(){
    var ww_type = url.searchParams.get('ww_type');
    WWTPs.concat(Activity).forEach(wwtp=>{
      var ests=estimations(wwtp.COD,wwtp.TKN,wwtp.TP,ww_type);
      Object.keys(ests.outputs).forEach(key=>{
        wwtp[key]=Math.round(ests.outputs[key]*100)/100;
      });
    });
  })();
</script>

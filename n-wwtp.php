<?php /*
  Multiple plant interface
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <script src="elementary.js"></script>
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
      //populate table wwtps
      var table=document.querySelector('table#wwtps');
      table.innerHTML="";

      //add wttp names
      (function(){
        var newRow=table.insertRow(-1);
        newRow.insertCell(-1).outerHTML="<th rowspan=2>Inputs<th rowspan=2>Activity WW<th colspan='"+WWTPs.length+"'>Reference WWTPs";

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
        newCell.colSpan=2+WWTPs.length;
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
        newCell.colSpan=2+WWTPs.length;
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
          span.innerHTML=' Wastewater composition'+
            '<button style=float:right>Apply COD, TKN, TP based estimations</button>';
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
        newCell.colSpan=2+WWTPs.length;
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

      //populate table with zeros
      (function(){
        var table=document.getElementById('contribution');
        var outputs=compute_elementary_flows(WWTPs[0]).Outputs;
        Object.keys(Outputs).forEach(key=>{
          var newRow=table.insertRow(-1);
          newRow.id=key;
          newRow.insertCell(-1).outerHTML="<th>"+key;
          newRow.insertCell(-1).outerHTML="<td influent>0";
          newRow.insertCell(-1).outerHTML="<td water>0";
          newRow.insertCell(-1).outerHTML="<td air>0";
          newRow.insertCell(-1).outerHTML="<td sludge>0";
        });
      })();

      //RUN SIMULATIONS (PROVISIONAL)
      display_contribution(n_wwtps_simulation(Activity,WWTPs))
    }
  </script>

  <script>
    /*N simulations backend*/
    //get 2 influents and mix them
    function mix_influents(activity, reference){
      var rv={
        Q: activity.Q + reference.Q,
      };
      //combine wastewater characteristics
      Object.keys(activity).filter(key=>{return key!="Q"}).forEach(key=>{
        rv[key]=(activity.Q*activity[key]+reference.Q*reference[key])/rv.Q;
      });
      //get design parameters from reference
      Object.keys(reference).filter(key=>{return getInputById(key).isParameter}).forEach(key=>{
        rv[key]=reference[key];
      });
      //get technologies from reference
      Object.keys(Technologies).filter(key=>{return !Technologies[key].notActivable}).forEach(key=>{
        rv["is_"+key+"_active"]=reference["is_"+key+"_active"];
      });
      return rv;
    }

    //perform a marginal approach
    function marginal_approach(activity, reference){
      var outputs_reference = compute_elementary_flows(reference).Outputs;
      //console.log(outputs_reference);
      var mixed_influent = mix_influents(activity, reference);
      //console.log(mixed_influent);
      var outputs_mixed  = compute_elementary_flows(mixed_influent).Outputs;
      //console.log(outputs_mixed);

      //calculate contribution
      var contribution = {};
      Object.keys(outputs_mixed).forEach(key=>{
        //total contribution (g/d) or (g/m3)
        contribution[key] = (outputs_mixed[key].value - outputs_reference[key].value);///activity.Q;
      });
      //console.log(contribution);
      return contribution;
    }

    //perform all simulations
    function n_wwtps_simulation(activity, WWTPs){
      var contributions=[];

      //perform n marginal approaches
      WWTPs.forEach(wwtp=>{
        contributions.push(marginal_approach(activity,wwtp));
      });
      //console.log(contributions);
      //average all the contributions weighted by "perc_PE" value
      var weighted_contribution = {};

      Object.keys(contributions[0]).forEach(key=>{
        //init weighted contribution
        weighted_contribution[key] = 0;
        WWTPs.forEach((wwtp,i)=>{
          weighted_contribution[key] += wwtp.perc_PE/100 * contributions[i][key];
        });
      });

      //console.log(weighted_contribution);
      return weighted_contribution;
    }

    //GUI
    //Display weighted contribution THIS CONVERTS G/D TO KG/D
    function display_contribution(weighted_contribution, contributions){
      contributions=contributions||false;

      var table=document.getElementById('contribution');
      var is_kg_per_m3_selected = document.querySelector('input[name=displayed_unit][value="kg/m3"]').checked;

      Object.keys(Outputs).forEach(key=>{
        var row=document.querySelector('#contribution tr[id='+key+']');
        //influent
        var value=weighted_contribution[key+"_influent"]/1000;
        var color = value ? "":"#ccc";
        if(is_kg_per_m3_selected){ value/=Activity.Q; }
        row.querySelector('td[influent]').innerHTML=format(value,false,color); //TODO show all contributions here
        //effluent
        ['water','air','sludge'].forEach(part=>{
          var value=weighted_contribution[key+"_effluent_"+part]/1000;
          var color = value ? "":"#ccc";
          if(is_kg_per_m3_selected){ value/=Activity.Q; }
          row.querySelector('td['+part+']').innerHTML=format(value,false,color);
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
    #wwtps, #contribution { font-size:smaller; }
    #wwtps input[type=number],
    #wwtps input[type=text] {
      width:60px;
    }
    #wwtps tr[id]:hover {
      text-decoration:underline;
      background:#fafafa;
    }
    #wwtps td button {
      width:100%;
      display:block;
    }
    #contribution td {
      text-align:right;
    }
  </style>
</head><body onload="init()">
<?php include'navbar.php'?>
<div id=root>

<!--title div--><div>
  <h1>Multiple plant simulation</h1>
  <em>Activity wastewater vs Reference wastewater treatment plants.</em>

  <br><br>
  <em>(now: example for South Africa mixes. <a href="mix_SAfrica.js" target=_blank>See loaded raw data here</a>)</em>
</div><hr>

<!--top menu btns-->
<div>
  <div id=top_btns>
    <div class=flex style="justify-content:space-between">
      <div>
        <input id=loadFile type=file accept=".json" onchange="loadFile(event)" style="display:none">
        <button onclick="document.getElementById('loadFile').click()">Load wwtp mix</button>
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
                  WWTPs=saved_file;
                })();
                init();
              }catch(e){alert(e)}
            }
            try{
              reader.readAsText(file);
            }catch(e){alert(e)}
          }
        </script>

        <button onclick="saveToFile()">Save </button>
        <script>
          /*Generate a json/text file*/
          function saveToFile() {
            var saved_file = WWTPs;
            //console.log(saved_file);
            var datestring=(new Date()).toISOString().replace(/-/g,'').replace(/:/g,'').substring(2,13);
            var link=document.createElement('a');
            link.href="data:text/json;charset=utf-8,"+JSON.stringify(saved_file,null,'  ');
            link.download="wwtp_mix_"+datestring+"UTC.json";
            document.body.appendChild(link);//this line is required in firefox
            link.click();
          }
        </script>

        <button onclick="WWTPs=[];add_wwtp()">Clear all</button>
        <button onclick="add_wwtp()" style=background:yellow>Add plant</button>
        <button id=run onclick="display_contribution(n_wwtps_simulation(Activity,WWTPs))" style=background:lightgreen;width:200px>
          RUN SIMULATIONS
        </button>
        <small><em>(Press this button after modifying the inputs to re-run the "n" simulations)</em></small>
      </div>
    </div>
    <style>
      #top_btns button{
        padding:0.5em 1em;
        margin:5px 0;
      }
    </style>
  </div><hr>

  <div>
    <button>Generate ecoSpold file</button>
  </div>
</div><hr>

<!--main-->
<div class=flex style='justify-content:space-between'>
  <!--wwtps-->
  <table id=wwtps></table><hr>

  <!--results-->
  <div id=results_container>
    <table id=contribution>
      <tr><th colspan=5>Activity contribution
        <div>
          <label><input name=displayed_unit type=radio checked value="kg/d"  onclick=document.querySelector('#run').click()>  kg/d</label>
          <label><input name=displayed_unit type=radio         value="kg/m3" onclick=document.querySelector('#run').click()> kg/m<sup>3</sup></label>
        </div>
      <tr><th rowspan=2>Compound<th rowspan=2>Influent<th colspan=3>Effluent
      <tr><th>Water<th>Air<th>Sludge
    </table>
    <div>
      <issue class=under_dev></issue>
      <ul>
        <li>Sludge composition
        <li>Emitted CO2 (biogenic/fossil)
        <li>Chemicals
        <li>Energy
      </ul>
    </div>
  </div>
</div>

<!--load country mix data TODO provisional-->
<script src="mix_SAfrica.js"></script>
<script>
  //main object for storing WWTPs
  //main object for storing the Activity inputs
  var WWTPs=[];
  var Activity={
    Q:1,
  };

  //convert mix_SAfrica dictionary of arrays to array of dictionaries
  (function(){
    for(var i=0;i<4;i++){
      WWTPs.push({});
      for(var field in mix_SAfrica){
        WWTPs[i][field]=mix_SAfrica[field][i];
      }
    }
  })();

  //calculate estimations
  WWTPs.forEach(wwtp=>{
    var ests=estimations(wwtp.COD,wwtp.TKN,wwtp.TP);
    Object.keys(ests.outputs).forEach(key=>{
      wwtp[key]=Math.round(ests.outputs[key]*100)/100;
    });
  });
</script>

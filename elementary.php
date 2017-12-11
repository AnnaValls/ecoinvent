<?php
/* 
  Description of this php page
  backend is in 'elementary.js' (data structures + technology appliying)
  views and frontend is implemented here
*/
?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Elementary Flows</title>

  <!--backend functionality here-->
  <script src="elementary.js"></script>

  <!--user options object (only for this page)-->
  <script>
    //options
    var Options={
      /*the user can select the unit displayed for outputs*/
      currentUnit:{
        value:"kg/d",
        update:function(){
          var els=document.querySelectorAll('span.currentUnit');
          for(var i=0;i<els.length;i++){
            els[i].innerHTML=this.value.prettifyUnit();
          }
        }
      },
      /*developer: new options go here*/
    }
  </script>

  <!--call backend & frontend functions-->
  <script>
    function init(){
      /*
       * call backend functions
       */
      (function reset_all_outputs(){
        for(var out in Outputs){
          Outputs[out].influent=0;
          Outputs[out].effluent.water=0;
          Outputs[out].effluent.air=0;
          Outputs[out].effluent.sludge=0;
        }
      })();

      (function disable_impossible_options(){
        //if bod removal is false
        //  disable nitrification 
        //  disable sst sizing
        //  disable denitri
        //  disable bioP
        //  disable chemP
        if(getInput('BOD',true).value==false){
          getInput('SST',true).value=false;
          getInput('Nit',true).value=false;
          getInput('Des',true).value=false;
          getInput('BiP',true).value=false;
          getInput('ChP',true).value=false;
        }
        else{
          getInput('SST',true).value=true; //if bod active, sst active
        }

        //only one P removal technology allowed
        if(getInput('BiP',true).value){ getInput('ChP',true).value=false }
        if(getInput('ChP',true).value){ getInput('BiP',true).value=false }

        //denitri only if nitri
        if(getInput('Nit',true).value==false){
          getInput('Des',true).value=false;
        }
      })();

      //find current inputs from the technology combination
      (function set_current_inputs(){
        var current_combination=Technologies_selected.map(tec=>{return tec.id}).filter(tec=>{return getInput(tec,true).value});
        var input_codes=[];
        current_combination.forEach(tec=>{
          if(!Technologies[tec])return;
          input_codes=input_codes.concat(Technologies[tec].Inputs)
        });

        input_codes=uniq(input_codes);

        //recalculate current inputs array
        Inputs_current_combination=[];
        input_codes.filter(code=>{return !getInputById(code).isParameter}).forEach(code=>{
          Inputs_current_combination.push(getInputById(code));
        });

        //recalculate design inputs array
        Design=[];
        input_codes.filter(code=>{return getInputById(code).isParameter}).forEach(code=>{
          Design.push(getInputById(code));
        });
      })();

      Variables = [ ]; //empty variables object (refilled in 'compute_elementary_flows')
      
      /* Call Main backend function */
      compute_elementary_flows();

      /*
       * call frontend functions
       */
      (function updateViews(){
        //update number of inputs and variables
        document.querySelector('#input_amount').innerHTML=(function(){
          var a=Inputs_current_combination.concat(Design).length;
          var b=Inputs.length;
          return a+" of "+b;
        })();
        document.querySelector('#variable_amount').innerHTML=Variables.length;

        //update technologies table
        (function(){
          var table=document.querySelector('table#inputs_tech');
          while(table.rows.length>0){table.deleteRow(-1);}
          Technologies_selected.forEach(tec=> {
            if(tec.id=="SST") return; //SST always on
            var newRow=table.insertRow(-1);
            //tec name
            newRow.insertCell(-1).innerHTML=tec.descr;
            //checkbox
            var checked = getInput(tec.id,true).value ? "checked" : "";
            newRow.insertCell(-1).outerHTML="<td style=text-align:center><input type=checkbox "+checked+" onchange=\"toggleTech('"+tec.id+"')\" tech='"+tec.id+"'>";
            //implementation link
            if(Technologies[tec.id]){
              newRow.insertCell(-1).innerHTML="<center><small>"+
                "<a href='techs/"+Technologies[tec.id].File+"' title='see javascript implementation'>"+
                "code</a></center>"+
                "";
            }
          });
        })();

        //update inputs table
        (function(){
          var table=document.querySelector('table#inputs');
          while(table.rows.length>1){table.deleteRow(-1)}

          function process_input(i){
            var newRow=table.insertRow(-1);
            var advanced_indicator = i.color ? "<div class=circle style='background:"+i.color+"' title='Advanced knowledge required to modify this input'></div>" : "";
            /*
            */
            if(0==Inputs_current_combination.concat(Design).indexOf(i)+1){
              newRow.style.color='#aaa';
            }
            newRow.title=i.descr;
            newRow.insertCell(-1).outerHTML="<td class='flex help' style='justify-content:space-between'>"+i.id + advanced_indicator;
            newRow.insertCell(-1).innerHTML="<input id='"+i.id+"' value='"+i.value+"' type=number step=any onchange=setInput('"+i.id+"',this.value) min=0>"
            newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
          }

          //update inputs (not parameters)
          table.insertRow(-1).insertCell(-1).outerHTML="<th colspan=3 align=left>Wastewater characteristics";
          Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
            process_input(i);
          });
          //update inputs (design parameters)
          table.insertRow(-1).insertCell(-1).outerHTML="<th colspan=3 align=left>Design parameters";
          Inputs.filter(i=>{return i.isParameter}).forEach(i=>{
            process_input(i);
          });

          //hide not active inputs and add them to variables
          Inputs_to_be_hidden.forEach(inp=>{
            var id    = inp.id;
            var value = inp.value;
            var unit  = getInputById(id).unit;
            var descr = getInputById(id).descr;
            document.getElementById(id).parentNode.parentNode.style.display='none';
            if(!inp.invisible){
              Variables.push({id,value,unit,descr,tech:'inputs'});
            }
          });
        })();

        //update variables table
        (function(){
          var table=document.querySelector('table#variables');
          while(table.rows.length>1){table.deleteRow(-1)}
          if(Variables.length==0){
            table.insertRow(-1).insertCell(-1).outerHTML="<td colspan=4><i>~Activate some technologies first";
          }

          Variables.forEach(i=>{
            var tech_name = Technologies[i.tech] ? Technologies[i.tech].Name : i.tech;
            var newRow=table.insertRow(-1);
            newRow.setAttribute('tech',i.tech);
            newRow.insertCell(-1).outerHTML="<td class=help title='"+tech_name+"'>"+i.tech;
            newRow.insertCell(-1).outerHTML="<td class=help title='"+i.descr.replace(/_/g,' ')+"'>"+i.id;
            newRow.insertCell(-1).outerHTML="<td class=number>"+format(i.value);
            newRow.insertCell(-1).outerHTML="<td class=unit>"+i.unit.prettifyUnit();
          });
        })();

        //update outputs
        (function(){
          var table=document.querySelector('table#outputs');
          while(table.rows.length>2){table.deleteRow(-1)}
          for(var output in Outputs) {
            var newRow=table.insertRow(-1);
            newRow.insertCell(-1).innerHTML=output.prettifyUnit();
            ['water','air','sludge'].forEach(phase=>{
              var value = Outputs[output].effluent[phase];
              var color = value ? "" : "#aaa";
              newRow.insertCell(-1).outerHTML="<td class=number>"+format(value/1000,false,color);
            });
          }
        })();
      })();

      //disable checkboxes for impossible technology combinations
      (function(){
        function disable_checkbox(tech){
          var el=document.querySelector('#inputs_tech input[tech='+tech+']')
          el.disabled=true;
          el.parentNode.parentNode.style.color='#aaa';
        }
        if(getInput('BOD',true).value==false) {
          disable_checkbox('Nit');
          disable_checkbox('Des');
          disable_checkbox('BiP');
          disable_checkbox('ChP');
        }
        if(getInput('Nit',true).value==false) {
          disable_checkbox('Des');
        }
        if(getInput('BiP',true).value==true) {
          disable_checkbox('ChP');
        }
        if(getInput('ChP',true).value==true) {
          disable_checkbox('BiP');
        }
      })();

      //set "Scroll to" links visibility
      (function(){
        function set_scroll_link_visibility(tec){
          var el=document.querySelector('#variable_scrolling a[tech='+tec+']')
          if(el){
            el.style.display=getInput(tec,true).value ? "":"none";
          }
        }
        Technologies_selected.forEach(t=>{
          set_scroll_link_visibility(t.id)
        });
      })();

      //MASS BALANCES (end part)
      (function do_mass_balances(){
        function setBalance(element,influent,water,air,sludge){
          [
            {phase:'influent',value:influent},
            {phase:'water',value:water},
            {phase:'air',value:air},
            {phase:'sludge',value:sludge},
          ].forEach(ob=>{
            var color = ob.value ? "":"#aaa";
            document.querySelector('#mass_balances #'+element+' td[phase='+ob.phase+']').innerHTML=format(ob.value/1000,false,color);
          });

          //actual balance: output/input should be aprox 1
          var percent = influent==0 ? 0 : Math.abs(100*(1-(water+air+sludge)/influent));
          var el=document.querySelector('#mass_balances #'+element+' td[phase=balance]')
          el.innerHTML = format(percent,2)+" %";
          //red warning if percent is greater than 5%
          if(percent>3){el.style.color='red'}else{el.style.color='green'}
        }

        /*C,N,P,S balances*/
        var table=document.querySelector('table#mass_balances');
        //Carbon balance
          var influent = Outputs.COD.influent;
          var water    = Outputs.COD.effluent.water;
          var air      = Outputs.CO2.effluent.air;
          var sludge   = Outputs.COD.effluent.sludge;
          setBalance('C',influent,water,air,sludge);
        //Nitrogen balance
          var influent = Outputs.TKN.influent;
          var water    = Outputs.TKN.effluent.water  + Outputs.NOx.effluent.water;
          var air      = Outputs.N2.effluent.air     + Outputs.N2O.effluent.air;
          var sludge   = Outputs.TKN.effluent.sludge + Outputs.NOx.effluent.sludge;
          setBalance('N',influent,water,air,sludge);
        //Phosphorus balance
          var influent = Outputs.TP.influent;
          var water    = Outputs.TP.effluent.water;
          var air      = Outputs.TP.effluent.air;
          var sludge   = Outputs.TP.effluent.sludge;
          setBalance('P',influent,water,air,sludge);
        //Sulfur balance
          var influent = Outputs.TS.influent;
          var water    = Outputs.TS.effluent.water;
          var air      = Outputs.TS.effluent.air;
          var sludge   = Outputs.TS.effluent.sludge;
          setBalance('S',influent,water,air,sludge);
      })();

      //update ouputs selected unit views
      Options.currentUnit.update();
    }
  </script>
</head><body onload="init()">
<?php include'navbar.php'?>

<div id=root>
<h1>Elementary Flows (single plant model)</h1><hr>

<!--INPUTS AND OUTPUTS VIEW SCAFFOLD-->
<div class=flex>
  <!--1. Inputs-->
  <div>
    <p><b><u>1. User Inputs</u></b></p>
    <!--enter technologies-->
    <div>
      <p>1.1. Activate technologies of your plant</p>
      <table id=inputs_tech border=1></table>
    </div>
    <!--enter ww characteristics-->
    <div>
      <p>1.2. Enter inputs
        <small>(required: <span id=input_amount>0</span>)</small>
      </p>

      <!--inputs table-->
      <table id=inputs border=1>
        <tr><th>Input<th>Value<th>Unit
      </table>

      <!--go to top link-->
      <div style=font-size:smaller><a href=#>&uarr; top</a></div>

      <!--hint modify values using keyboard-->
      <p style=font-size:smaller>
        Hint: modify inputs using the <kbd>&uarr;</kbd> and <kbd>&darr;</kbd> keys.
        <style>
          kbd {
            display: inline-block;
            margin: 0 .1em;
            padding: .1em .6em;
            font-family: Arial,"Helvetica Neue",Helvetica,sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #242729;
            text-shadow: 0 1px 0 #FFF;
            background-color: #e1e3e5;
            border: 1px solid #adb3b9;
            border-radius: 3px;
            box-shadow: 0 1px 0 rgba(12,13,14,0.2), 0 0 0 2px #FFF inset;
            white-space: nowrap;
          }
        </style>
      </p>
    </div>
  </div><hr>

  <!--2. Variables (intermediate step between inputs and outputs)-->
  <div style=width:360px>
    <p>
      <b><u>2. Variables calculated: <span id=variable_amount>0</span></u></b>
    </p>

    <!--links for scrolling-->
    <div id=variable_scrolling style=font-size:smaller>
      <script>
        //frontend function: scroll to variables of a technology
        function scroll2tec(a){
          var tec=a.getAttribute('tech');
          var els=document.querySelectorAll('#variables tr[tech='+tec+']');
          els[0].scrollIntoView();
          //create a mini animation of changing colors
          for(var i=0;i<els.length;i++) {
            els[i].style.transition='background 0.4s';
            els[i].style.background='lightblue';
          }
          setTimeout(function(){
            for(var i=0;i<els.length;i++) {
              els[i].style.background='white';
            }
          },800);
          //end animation
        }
      </script>
      Scroll to &rarr;
      <a tech=BOD href=# onclick="scroll2tec(this);return false">BOD</a>
      <a tech=Nit href=# onclick="scroll2tec(this);return false">Nit</a>
      <a tech=SST href=# onclick="scroll2tec(this);return false">SST</a>
      <a tech=Des href=# onclick="scroll2tec(this);return false">Des</a>
      <a tech=BiP href=# onclick="scroll2tec(this);return false">BiP</a>
      <a tech=ChP href=# onclick="scroll2tec(this);return false">ChP</a>
      <script>
        //add a title attribute for the scroll links
        (function(){
          var els=document.querySelectorAll('#variable_scrolling a[tech]');
          for(var i=0;i<els.length;i++){
            els[i].title=Technologies[els[i].getAttribute('tech')].Name;
          }
        })();
      </script>
    </div>

    <!--Variables-->
    <table id=variables border=1><tr>
      <th>Tech
      <th>Variable
      <th>Result
      <th>Unit
    </table>

    <!--link go to top--><div style=font-size:smaller><a href=#>&uarr; top</a></div>
  </div><hr>

  <!--3. Outputs-->
  <div style=width:360px>
    <p><b><u>3. Outputs</u></b></p>

    <!--menu to change output units (kg/d or g/m3)-->
    <div style=font-size:smaller>
      Select units: 
      <label>
        <input type=radio name=currentUnit value="kg/d" onclick="Options.currentUnit.value=this.value;init()" checked> kg/d
      </label><label>
        <input type=radio name=currentUnit value="g/m3" onclick="Options.currentUnit.value=this.value;init()"> g/m<sup>3</sup>
      </label>
    </div>

    <!--table effluent phases-->
    <div>
      <p>3.1. Effluent</p>
      <table id=outputs border=1 style=font-size:smaller>
        <tr>
          <th rowspan=2>Compound
          <th colspan=3>Effluent <small>(<span class=currentUnit>kg/d</span>)</small>
        <tr>
          <th>Water<th>Air<th>Sludge
        </tr>
      </table>
    </div>

    <!--table mass balances-->
    <div>
      <p>3.2. Mass balances</p>
      <table id=mass_balances border=1 style=font-size:smaller>
        <tr>
          <th rowspan=2>Element<th rowspan=2>Influent<br><small>(<span class=currentUnit>kg/d</span>)</small><th colspan=3>Effluent <small>(<span class=currentUnit>kg/d</span>)</small>
          <th rowspan=2>|Error|<br><small>(%)</small>
        <tr>
          <th>Water<th>Air<th>Sludge  
        <tr id=C><th>C <td phase=influent>Q·COD <td phase=water>1:1     <td phase=air>2:2     <td phase=sludge>1:3     <td phase=balance>A-B-C-D
        <tr id=N><th>N <td phase=influent>Q·TKN <td phase=water>4:1+5:1 <td phase=air>6:2+7:2 <td phase=sludge>4:3+5:3 <td phase=balance>A-B-C-D
        <tr id=P><th>P <td phase=influent>Q·TP  <td phase=water>8:1     <td phase=air>-       <td phase=sludge>8:3     <td phase=balance>A-B-C-D
        <tr id=S><th>S <td phase=influent>Q·TS  <td phase=water>9:1     <td phase=air>-       <td phase=sludge>9:3     <td phase=balance>A-B-C-D
      </table>
    </div>

    <!--summary tables-->
    <div id=summary>
      <p>3.3. Design summary</p>
      <ul>
        <li>Total reactor volume: <span id=V_total>0</span>
          <ul>
            <li>V<sub>aerobic</sub>:   <span id=V_aer>0</span>
            <li>V<sub>anoxic</sub>:    <span id=V_nox>0</span>
            <li>V<sub>anaerobic</sub>: <span id=V_ana>0</span>
          </ul>
        <li>Settler Total Area needed:       <span id=Area>0</span>
        <li>Wastage flow (Q<sub>was</sub>): <span id=Qwas>0</span>
        <li>SRT:                <span id=SRT>0</span>
        <li>Recirculation flow (Q<sub>R</sub>): <span id=QR></span>
      </ul>
      <p>3.4. Technosphere</p>
        <ul>
          <li>Alkalinity to maintain pH
            <ul>
              <li>Nitrification:   <span id=alkalinity_added>0</span>
              <li>Denitrification: <span id=Mass_of_alkalinity_needed>0</span>
            </ul>
          </li>
          <li>FeCl<sub>3</sub> for Chemical P removal
            <ul>
              <li>Volume per day:          <span id=FeCl3_volume>0</span>
              <li>Volume storage required: <span id=storage_req_15_d>0</span>
            </ul>
          </li>
          <li>Kg concrete: go <a href="construction.php">here</a>
          <li>Aeration
            <ul>
              <li>Air flowrate:                     <span id=air_flowrate>0</span>
              <li>OTRf:                             <span id=OTRf>0</span>
              <li>SOTR :                            <span id=SOTR>0</span>
              <li>SAE:                              <span id=SAE>0</span>
                <div>
                  <small>
                    (note: Fine bubble systems have SAE ranges 
                    <br>
                    of between 3.6 and 4.8 kgO<sub>2</sub>/kWh)
                  </small>
                </div>
              <li>Power required (SOTR/SAE):        <span id=O2_power>0</span>
              <li>For Denitrirication
                <ul>
                  <li>Net O<sub>2</sub> required: <span id=Net_O2_required>0</span>
                  <li>SDNR:           <span id=SDNR>0</span>
                  <li>Power required: <span id=Power>0</span>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
    </div>

    <!--link to generate an outputs ecospold file-->
    <div style=margin-top:10px>
      <a href=ecospold.php> Save results as ecoSpold file </a>
    </div>
  </div>
</div><hr>

<!--TODO development-->
<div style=font-size:smaller>
  Development issues (lbosch):
  <ul>
    <li>How to handle inputs for ChemP when BioP is active? Is Chem [P]<sub>input</sub> = Bio [P]<sub>output</sub> ?
      <issue class="help_wanted"></issue>
    <li>TS (Sulfur) effluent equations unknown.
      <issue class="help_wanted"></issue>
    <li>CH<sub>4</sub> effluent equations unknown.
      <issue class="help_wanted"></issue>
  </ul>
</div>

<!--CSS-->
<link rel=stylesheet href=css.css>
<style>
  #root hr{
    margin:0px auto;
  }
  #root th{
    background:#eee;
  }
  #root input[type=number]{
    text-align:right;
  }
  #root #mass_balances [phase]{
    text-align:right;
  }
  #root .help:hover{
    text-decoration:underline;
  }
  #root #inputs, #root #variables {
    font-size:smaller;
  }
  #root .circle{
    text-align:center;
    border-radius:17px;
    width:17px;
  }
  #root #summary > ul {
    font-size:smaller;
  }
  #root #summary ul ul{
    padding-left:20px;
  }
  #root table#inputs_tech,
  #root table#inputs,
  #root table#variables,
  #root table#outputs,
  #root table#mass_balances {
    width:100%;
    border-collapse:collapse;
  }
</style>

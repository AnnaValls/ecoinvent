<?php /*
  Marginal approach:
  Mix 2 influents to see the contribution of the first to the total effluent
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Marginal approach</title>
  <script src="elementary.js"></script>

  <script>
    function init() {
      //1. reset all outputs to zero
      (function reset_all_outputs(){
        for(var out in Outputs){
          Outputs[out].influent=0;
          Outputs[out].effluent.water=0;
          Outputs[out].effluent.air=0;
          Outputs[out].effluent.sludge=0;
        }
      })();
      disable_checkboxes();
      mix_influents();
      getInputSets();
      call_elementary_flows();
      //vim: mark "i"
    }
  </script>

  <!--marginal approach backend implementation-->
  <script>
    //deactivate impossible tech combinations
    function disable_checkboxes(){
      var is_BOD_active = document.querySelector('#technologies tr[id=is_BOD_active] input[type=checkbox]').checked;
      var is_Nit_active = document.querySelector('#technologies tr[id=is_Nit_active] input[type=checkbox]').checked;
      var is_Des_active = document.querySelector('#technologies tr[id=is_Des_active] input[type=checkbox]').checked;
      var is_BiP_active = document.querySelector('#technologies tr[id=is_BiP_active] input[type=checkbox]').checked;
      var is_ChP_active = document.querySelector('#technologies tr[id=is_ChP_active] input[type=checkbox]').checked;
      var is_Met_active = document.querySelector('#technologies tr[id=is_Met_active] input[type=checkbox]').checked;
      function set_checkbox_disabled(tec,disabled){
        var el=document.querySelector('#technologies tr[id=is_'+tec+'_active] input[type=checkbox]');
        el.disabled=disabled;
        if(disabled){el.checked=false;}
        el.parentNode.parentNode.style.color=disabled?'#aaa':"";
      }
      set_checkbox_disabled('Nit', !is_BOD_active);
      set_checkbox_disabled('Des', (!is_BOD_active || !is_Nit_active));
      set_checkbox_disabled('BiP', (!is_BOD_active || is_ChP_active));
      set_checkbox_disabled('ChP', (!is_BOD_active || is_BiP_active));
      set_checkbox_disabled('Met', !is_BOD_active);
    }

    //total flow (inf1+inf2)
    var total_Q=0;

    //get influents 1 and 2 from DOM and mix them
    function mix_influents(){
      Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
        mix_input(i.id);
      });
      function mix_input(id){
        var input1=document.querySelector('#inputs tr[id='+id+'] input[inf="1"]');
        var input2=document.querySelector('#inputs tr[id='+id+'] input[inf="2"]');
        var output=document.querySelector('#inputs tr[id='+id+'] span[mixed]');
        var value1=parseFloat(input1.value);
        var value2=parseFloat(input2.value);
        if(id=="Q"){
          total_Q=value1+value2;
          output.setAttribute('value',total_Q);
          output.innerHTML=format(total_Q);
        }else{
          var Q1=parseFloat(document.querySelector('#inputs tr[id=Q] input[inf="1"]').value);
          var Q2=parseFloat(document.querySelector('#inputs tr[id=Q] input[inf="2"]').value);
          var mass1=Q1*value1; //g/d
          var mass2=Q2*value2; //g/d
          var conc=(mass1+mass2)/total_Q;
          output.setAttribute('value',conc);
          output.innerHTML=format(conc);
        }
      }
    }

    //new input sets: will store all inputs to compute elementary flows (=simulation)
    var Input_set1={};
    var Input_set2={};
    var Input_set3={};

    //fill input sets
    function getInputSets(){
      //get ww characteristics
      Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
        var input1=document.querySelector('#inputs tr[id='+i.id+'] input[inf="1"]');
        var input2=document.querySelector('#inputs tr[id='+i.id+'] input[inf="2"]');
        var input3=document.querySelector('#inputs tr[id='+i.id+'] span[mixed]');
        Input_set1[i.id]=parseFloat(input1.value);
        Input_set2[i.id]=parseFloat(input2.value);
        Input_set3[i.id]=parseFloat(input3.getAttribute('value'));
      });
      //get designn parameters
      Inputs.filter(i=>{return i.isParameter}).forEach(i=>{
        var dp=parseFloat(document.querySelector('#design_parameters tr[id='+i.id+'] input').value);
        Input_set1[i.id]=dp;
        Input_set2[i.id]=dp;
        Input_set3[i.id]=dp;
      });
      //fill input sets
      (function(){
        var is_BOD_active = document.querySelector('#technologies tr[id=is_BOD_active] input[type=checkbox]').checked;
        var is_Nit_active = document.querySelector('#technologies tr[id=is_Nit_active] input[type=checkbox]').checked;
        var is_Des_active = document.querySelector('#technologies tr[id=is_Des_active] input[type=checkbox]').checked;
        var is_BiP_active = document.querySelector('#technologies tr[id=is_BiP_active] input[type=checkbox]').checked;
        var is_ChP_active = document.querySelector('#technologies tr[id=is_ChP_active] input[type=checkbox]').checked;
        var is_Met_active = document.querySelector('#technologies tr[id=is_Met_active] input[type=checkbox]').checked;

        Input_set1.is_BOD_active = is_BOD_active;
        Input_set1.is_Nit_active = is_Nit_active;
        Input_set1.is_Des_active = is_Des_active;
        Input_set1.is_BiP_active = is_BiP_active;
        Input_set1.is_ChP_active = is_ChP_active;
        Input_set1.is_Met_active = is_Met_active;

        Input_set2.is_BOD_active = is_BOD_active;
        Input_set2.is_Nit_active = is_Nit_active;
        Input_set2.is_Des_active = is_Des_active;
        Input_set2.is_BiP_active = is_BiP_active;
        Input_set2.is_ChP_active = is_ChP_active;
        Input_set2.is_Met_active = is_Met_active;

        Input_set3.is_BOD_active = is_BOD_active;
        Input_set3.is_Nit_active = is_Nit_active;
        Input_set3.is_Des_active = is_Des_active;
        Input_set3.is_BiP_active = is_BiP_active;
        Input_set3.is_ChP_active = is_ChP_active;
        Input_set3.is_Met_active = is_Met_active;
        /*
        console.log("--input sets:");
        console.log(Input_set1);
        console.log(Input_set2);
        console.log(Input_set3);
        */
      })();
    }

    /** Compute elementary flows 2 times
      * The key objects are:
      * - Input_set{N}
      * - Result{N}
      * - Outputs{N}
      * where N is:
      *   N=1 means influent 1
      *   N=2 means influent 2
      *   N=3 means influent 1+2
    */
    function call_elementary_flows(){
      /*Influent 2*/
      var Result2  = compute_elementary_flows(Input_set2);
      var Outputs2 = JSON.parse(JSON.stringify(Outputs)); //clone Outputs object
      /*Mixed influents (1+2)*/
      var Result3 = compute_elementary_flows(Input_set3);
      var Outputs3 = JSON.parse(JSON.stringify(Outputs));

      //Calculate Contribution of Influent 1 in percentages
      var Contribution = JSON.parse(JSON.stringify(Outputs)); //we'll store the percentages here
      (function calculate_contribution(){
        //we need 22 outputs * (1 influent + 3 effluent phases) = 88 calculations
        Object.keys(Outputs).forEach(k=>{
          Contribution[k].influent = 100*(1 - Outputs2[k].influent/Outputs3[k].influent) || 0;
          ['water','air','sludge'].forEach(p=>{
            Contribution[k].effluent[p] = 100*(1 - Outputs2[k].effluent[p]/Outputs3[k].effluent[p]) || 0;
          });
        });
        //console.log(Contribution);
      })();

      /*FRONTEND: contribution and design parameters + technosphere*/

      //frontend 1/2: show contribution
      Object.keys(Contribution).forEach(k=>{
        /*INFLUENT*/
        //DOM handle

        ['influent','water','air','sludge'].forEach(p=>{
          var h3=document.querySelector('#results tr[id='+k+'] td[phase='+p+'][inf="3"]');
          var h2=document.querySelector('#results tr[id='+k+'] td[phase='+p+'][inf="2"]');
          var h1=document.querySelector('#results tr[id='+k+'] td[phase='+p+'][inf="1"]');

          var v3 = (p=='influent') ? Outputs3[k].influent/1000 : Outputs3[k].effluent[p]/1000;
          var v2 = (p=='influent') ? Outputs2[k].influent/1000 : Outputs2[k].effluent[p]/1000;
          var v1 = v3-v2;

          if(Options.displayed_results.value=="g/m3"){
            v3*=1000/Input_set3.Q;
            v2*=1000/Input_set3.Q;
            v1*=1000/Input_set3.Q;
          }
          
          //calc percentage if user set the option
          if(Options.displayed_results.percent){
            v1=100*v1/v3 ||0;
          }

          h3.innerHTML=format(v3);
          h2.innerHTML=format(v2);
          h1.innerHTML=format(v1);

          if(Options.displayed_results.percent && v1){
            h1.innerHTML+="%";
          }

          //colors
          h3.style.color= v3 ? "":"#aaa";
          h2.style.color= v2 ? "":"#aaa";
          h1.style.color= v1 ? "":"#aaa";
        });
      });

      //frontend 2/2: design parameters and technosphere
      (function(){
        //#design_parameters
        function display_result(tec,variable){
          var h=document.getElementById(variable);
          var v=variable;

          //check if required variable exists
          var exists = (Result2 && Result2[tec] && Result2[tec][v]) ? true : false;
          h.parentNode.style.color = exists ? "":"#aaa";
          if(!exists){
            h.innerHTML=0;
            return;
          }

          var rtv3 = Result3[tec][v].value;
          var rtv2 = Result2[tec][v].value;
          h.innerHTML=format(rtv3-rtv2)+" <small>of</small> "+format(rtv3)+" ("+format(100-100*rtv2/rtv3)+"%)";
        }
        display_result('summary','P_X_TSS');
        display_result('summary','V_total');
        display_result('SST','Area');
        display_result('SST','QR');
        //#technosphere
        display_result('Nit','alkalinity_added');
        display_result('Des','Mass_of_alkalinity_needed');
        display_result('ChP','FeCl3_volume');
        display_result('ChP','storage_req_15_d');
      })();
    }
  </script>

  <!--user options object-->
  <script>
    //options
    var Options={
      /*user can select displayed results */
      displayed_results:{
        value:"kg/d", //default
        set:function(newValue){
          this.value=newValue;
          this.update();
          init();
        },
        update:function(){
          var els=document.querySelectorAll('.currentUnit');
          for(var i=0;i<els.length;i++){
            els[i].innerHTML=this.value.prettifyUnit();
          }
        },

        percent:false, //see contribution as percent
        setPercent:function(newValue){
          this.percent=newValue;
          init();
        },
      },
      /*for further user-options: new options should go here*/
    }
  </script>

  <style>
    body {
      max-width:95em;
    }
    #root table {
      width:100%;
      font-size:smaller;
      border-collapse:collapse;
    }
    #root #technologies input[type=checkbox]{
      display:block;
      margin:auto;
    }
  </style>
</head><body onload="init()">
<?php include'navbar.php'?>
<div id=root>
<h1>Marginal approach</h1>
<!--subtitle-->
<div>
  <p>
    Here you can study the marginal contribution of an influent to the
    effluent resulting from the sum of two influents.
  </p><p>
    <small>Note: mouse over variables to see a little description</small>
  </p>
  <p>
    <button>Generate ecospold with the results</button>
  </p>
</div><hr style=margin:0>

<!--main-->
<div class=flex>
  <!--1. influents to mix-->
  <div style="max-width:445px;border-right:1px solid #ccc;padding-right:8px">
    <p><b>1. Wastewater characteristics:</b></p>
    <table id=inputs border=0>
      <tr>
        <th>Inputs
        <th>Influent 1
          <br><small>activity<br>wastewater</small>
        <th>Influent 2
          <br><small>reference<br>wastewater</small>
        <th>Influent 1+2
        <th>Units
      <tr>
    </table>
    <style>
      #inputs input[type=number]{
        width:80px;
      }
    </style>
  </div>

  <!--2. techs and design parameters-->
  <div style="max-width:445px;border-right:1px solid #ccc;padding:0 8px">
    <div>
      <p><b>2. Reference WWTP</b></p>

      <p>2.1. Define treatment levels:</p>
      <table id=technologies border=1></table>
    </div>
    <div>
      <p>2.2. Enter design parameters:</p>
      <table id=design_parameters></table>
      <style>
        #design_parameters input[type=number] {
          width:80px;
        }
      </style>
    </div>
  </div>

  <!--3. results-->
  <div style="padding-left:8px">
    <p><b>3. Results</b></p>
    <p>
      3.1. Effluent
      <!--menu to change output units (kg/d or g/m3)-->
      <!--menu to see percentage-->
      <table style=font-size:smaller>
        <tr><td>Select units:
          <label>
            <input type=radio name=currentUnit value="kg/d" onclick="Options.displayed_results.set(this.value)" checked> kg/d
          <label>
            <input type=radio name=currentUnit value="g/m3" onclick="Options.displayed_results.set(this.value)"> g/m<sup>3</sup>
        <tr><td>See activity contribution in %:
          <label>
            <input type=radio  name=percent onclick="Options.displayed_results.setPercent(false)" checked> No
          <label>
            <input type=radio  name=percent onclick="Options.displayed_results.setPercent(true)"> Yes
        <tr><td>See activity contribution per m<sup>3</sup> of Influent 1:
          <label>
            <input type=radio  name=contr_per_Q1 onclick="" checked> No
          <label>
            <input type=radio  name=contr_per_Q1 onclick=""> Yes
            <issue class=under_dev></issue>
      </table>
    </p>

    <!--effluent results-->
    <table id=results border=1>
      <tr>
        <th rowspan=3>Compound
        <th colspan=3>Influent <small>(<span class=currentUnit>kg/d</span>)</small>
        <th colspan=9>Effluent <small>(<span class=currentUnit>kg/d</span>)</small>
      <tr>
        <th rowspan=2 style=font-size:smaller>Inf 1+2
        <th rowspan=2 style=font-size:smaller>Inf 2
        <th rowspan=2 style=font-size:smaller>Inf 1
        <th colspan=3>Water<th colspan=3>Air<th colspan=3>Sludge
      <tr style=font-size:smaller>
        <th>Inf 1+2 <th>Inf 2 <th>Inf 1
        <th>Inf 1+2 <th>Inf 2 <th>Inf 1
        <th>Inf 1+2 <th>Inf 2 <th>Inf 1
    </table>
    <style>
      #results td[phase][inf="1"]{
        background:#eee;
      }
    </style>

    <!--design summary-->
    <p>3.2. Design summary</p>
    <table border=1 id=design_summary>
      <tr><th>Total sludge produced    <td class=number id="P_X_TSS">0<td class=unit>kg/d
      <tr><th>Total reactor volume     <td class=number id="V_total">0<td class=unit>m<sup>3</sup>
      <tr><th>Settler total area needed<td class=number id="Area">   0<td class=unit>m<sup>2</sup>
      <tr><th>Recirculation flow       <td class=number id="QR">     0<td class=unit>m<sup>3</sup>/d
    </table>

    <!--technosphere-->
    <p>3.3. Technosphere</p>
    <table border=1 id=technosphere>
      <tr><th rowspan=3>Alkalinity<br>to maintain pH
        <tr><th>Nitrification   <td class=number id="alkalinity_added">0<td class=unit>kg/d as NaHCO<sub>3</sub>
        <tr><th>Denitrification <td class=number id="Mass_of_alkalinity_needed">0<td class=unit>kg/d as CaCO<sub>3</sub>
      <tr><th rowspan=3>FeCl<sub>3</sub> for<br>Chemical P removal
        <tr><th>Volume per day          <td class=number id="FeCl3_volume">0<td class=unit>L/d
        <tr><th>Volume storage required <td class=number id="storage_req_15_d">0<td class=unit>m<sup>3</sup>
      <tr><th colspan=2>Concrete
          <issue class=under_dev></issue>
        <td>?
        <td class=unit>kg
    </table>
  </div>
</div><hr>
<?php include'btn_reset_cache.php'?>
<!--end page-->

<!--frontend initial values-->
<script>
  //populate DOM with initial values
  (function(){
    //populate input tables
    (function(){
      var t=document.querySelector('table#inputs');
      Inputs.filter(i=>{return !i.isParameter && !i.isMetal}).forEach(i=>{
        process_input(i);
      });
      Inputs.filter(i=>{return i.isMetal}).forEach(i=>{
        process_input(i);
      });
      function process_input(i){
        var newRow=t.insertRow(-1);
        //row attrs
        newRow.id=i.id;
        newRow.title=i.descr;
        //col 1: input id
        newRow.insertCell(-1).innerHTML=i.id;
        //col 2: input1
        newRow.insertCell(-1).innerHTML="<input onchange=init() inf=1 type=number value='"+i.value+"'>";
        //col 3: input2
        newRow.insertCell(-1).innerHTML="<input onchange=init() inf=2 type=number value='"+i.value+"'>";
        //col 4: mixed influents
        newRow.insertCell(-1).outerHTML="<td style=text-align:right><span mixed>0</span></td>";
        //col 5: unit
        newRow.insertCell(-1).outerHTML="<td style=font-size:smaller>"+i.unit.prettifyUnit()+"</td>";
      }
    })();

    //populate technologies table (activable)
    (function(){
      //get table by id
      var t=document.getElementById('technologies');
      //default state for technologies
      var Techs_selected={
        "BOD":true,
        "Nit":false,
        "Des":false,
        "BiP":false,
        "ChP":false,
      };
      //go over technologies
      for(var i in Technologies){
        var tec=Technologies[i];
        if(tec.notActivable)continue;
        var newRow=t.insertRow(-1);
        newRow.id="is_"+i+"_active";
        newRow.insertCell(-1).innerHTML=tec.Name;
        var checked = Techs_selected[i] ? "checked":"";
        newRow.insertCell(-1).innerHTML="<input type=checkbox "+checked+" onchange=init()>";
        //TODO add disabled
      }
    })();

    //populate design parameters table
    (function(){
      var t=document.querySelector('table#design_parameters');
      Inputs.filter(i=>{return i.isParameter}).forEach(i=>{
        var newRow=t.insertRow(-1);
        newRow.id=i.id;
        newRow.title=i.descr;
        //design parameter id
        newRow.insertCell(-1).innerHTML=i.id;
        //input element
        newRow.insertCell(-1).innerHTML="<input disabled type=number value='"+i.value+"' onchange=init()>";
        //unit
        newRow.insertCell(-1).innerHTML="<small>"+i.unit.prettifyUnit()+"</small>";
      });
    })();

    //populate results table default values
    (function(){
      var t=document.querySelector('table#results');
      for(var o in Outputs){
        var newRow=t.insertRow(-1);
        newRow.id=o;
        newRow.title=Outputs[o].descr;
        newRow.insertCell(-1).outerHTML="<th>"+o.prettifyUnit();
        ['influent', 'water', 'air', 'sludge'].forEach(p=>{
          ['3','2','1'].forEach(i=>{
            newRow.insertCell(-1).outerHTML="<td class=number phase="+p+" inf='"+i+"'>0</td>";
          });
        });
      }
    })();
  })();
</script>

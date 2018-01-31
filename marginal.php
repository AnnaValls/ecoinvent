<?php
  /*
   * Marginal approach:
   * Mix 2 influents to see the contribution of the first to the total effluent
   *
*/?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Marginal approach</title>
  <script src="elementary.js"></script>
  <script>
    function init(){
      disable_checkboxes();
      mix_influents();
      getInputSets();
      call_elementary_flows();
      //vim: mark "i"
    }
  </script>
  <style>
    #root table {
      width:100%;
      font-size:smaller;
    }
    #root #results td[phase]:hover{
      text-decoration:underline;
    }
  </style>
</head><body onload="init()">
<?php include'navbar.php'?>
<div id=root>
<h1>Marginal approach</h1>

<!--subtitle-->
<div>
  <p>
    Here you can simulate and study the contribution of an influent to the
    effluent created by of the sum of two influents.
  </p>
  <p><small>Tip: mouse over any variable to see a little description</small></p>
</div><hr>

<!--main-->
<div class=flex>
  <!--1. influents to mix-->
  <div>
    <p>1. Enter two influents to be mixed:</p>
    <table id=inputs border=0>
      <tr>
        <th>Input
        <th>Influent 1
        <th>Influent 2
        <th>Influent 1+2
        <th>Unit
      <tr>
    </table>
  </div><hr>

  <!--2. techs and design parameters-->
  <div>
    <div>
      <p>2. Activate removal technologies:</p>
      <table id=technologies border=1></table>
    </div>
    <div>
      <p>3. Enter design parameters:</p>
      <table id=design_parameters></table>
    </div>
  </div><hr>

  <!--3. results-->
  <div>
    <p>
      4. Results
      <div style=font-size:smaller>
        Display:
        <select onchange="Options.displayed_results.set(this.value)">
          <option value="%"   > Contribution (%) of Influent 1
          <option value="kg/d"> Total influent (kg/d)
          <option value="g/m3"> Total influent (g/m3)
        </select>
      </div>
    </p>

    <table id=results border=1>
      <tr>
        <th rowspan=2>Compound
        <th rowspan=2>Influent<br><small>(<span class=currentUnit>%</span>)</small>
        <th colspan=3>Effluent <small>(<span class=currentUnit>%</span>)</small>
      <tr>
      <th>Water<th>Air<th>Sludge
    </table>

    <p>5. Design summary</p>
    <table border=1>
      <tr><td>total sludge produced
      <tr><td>total reactor volume
      <tr><td>settler total area needed
      <tr><td>recirculation flow
      <tr><td><issue class=under_dev></issue>
    </table>

    <p>6. Technosphere</p>
    <table border=1>
      <tr><td>alkalinity to maintain pH
      <tr><td>FeCl3 for Chemical P removal
      <tr><td>kg concrete
      <tr><td><issue class=under_dev></issue>
    </table>
  </div>
</div><hr>
<?php include'btn_reset_cache.php'?>
<!--end page-->

<!--frontend-->
<script>
  //populate DOM with initial values
  (function(){
    //populate input tables
    (function(){
      var t=document.querySelector('table#inputs');
      Inputs.filter(i=>{return !i.isParameter}).forEach(i=>{
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
      });
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
        newRow.insertCell(-1).innerHTML="<input type=number value='"+i.value+"' onchange=init()>";
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
        newRow.insertCell(-1).innerHTML=o;
        newRow.insertCell(-1).outerHTML="<td class=number phase=influent>0%</td>";
        newRow.insertCell(-1).outerHTML="<td class=number phase=water   >0%</td>";
        newRow.insertCell(-1).outerHTML="<td class=number phase=air     >0%</td>";
        newRow.insertCell(-1).outerHTML="<td class=number phase=sludge  >0%</td>";
      }
    })();
  })();
</script>

<!--backend-->
<script>
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
      Input_set1.is_BOD_active = is_BOD_active;
      Input_set1.is_Nit_active = is_Nit_active;
      Input_set1.is_Des_active = is_Des_active;
      Input_set1.is_BiP_active = is_BiP_active;
      Input_set1.is_ChP_active = is_ChP_active;
      Input_set2.is_BOD_active = is_BOD_active;
      Input_set2.is_Nit_active = is_Nit_active;
      Input_set2.is_Des_active = is_Des_active;
      Input_set2.is_BiP_active = is_BiP_active;
      Input_set2.is_ChP_active = is_ChP_active;
      Input_set3.is_BOD_active = is_BOD_active;
      Input_set3.is_Nit_active = is_Nit_active;
      Input_set3.is_Des_active = is_Des_active;
      Input_set3.is_BiP_active = is_BiP_active;
      Input_set3.is_ChP_active = is_ChP_active;
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

    //FRONTEND: show contribution
    Object.keys(Contribution).forEach(k=>{
      /*INFLUENT*/
      //DOM handle
      var h=document.querySelector('#results tr[id='+k+'] td[phase=influent]');
      var contrib=Contribution[k].influent;
      h.style.color=contrib?"":"#aaa";
      switch(Options.displayed_results.value){
        case "kg/d":
          h.innerHTML=format(Outputs3[k].influent/1000);
          break;
        case "g/m3":
          h.innerHTML=format(Outputs3[k].influent/Input_set3.Q);
          break;
        default:
          h.innerHTML=format(contrib)+"%";
          break;
      }
      //set title
      (function(){
        h.title=""+
          format(Outputs3[k].influent/1000-Outputs2[k].influent/1000)+
          " of "+
          format(Outputs3[k].influent/1000)+
          " (kg/d)";
      })();
      /*EFFLUENT PHASES*/
      ['water','air','sludge'].forEach(p=>{
        //DOM handle
        var h=document.querySelector('#results tr[id='+k+'] td[phase='+p+']');
        var contrib=Contribution[k].effluent[p];
        h.style.color= contrib ? "":"#aaa";
        switch(Options.displayed_results.value){
          case "kg/d":
            h.innerHTML=format(Outputs3[k].effluent[p]/1000);
            break;
          case "g/m3":
            h.innerHTML=format(Outputs3[k].effluent[p]/Input_set3.Q);
            break;
          default:
            h.innerHTML=format(contrib)+"%";
            break;
        }
        //set title
        (function(){
          h.title=""+
            format(Outputs3[k].effluent[p]/1000-Outputs2[k].effluent[p]/1000)+
            " of "+
            format(Outputs3[k].effluent[p]/1000)+
            " (kg/d)";
        })();
      });
    });
  }

  //deactivate impossible tech combinations
  function disable_checkboxes(){
    var is_BOD_active = document.querySelector('#technologies tr[id=is_BOD_active] input[type=checkbox]').checked;
    var is_Nit_active = document.querySelector('#technologies tr[id=is_Nit_active] input[type=checkbox]').checked;
    var is_Des_active = document.querySelector('#technologies tr[id=is_Des_active] input[type=checkbox]').checked;
    var is_BiP_active = document.querySelector('#technologies tr[id=is_BiP_active] input[type=checkbox]').checked;
    var is_ChP_active = document.querySelector('#technologies tr[id=is_ChP_active] input[type=checkbox]').checked;
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
  }
</script>

<!--user options object-->
<script>
  //options
  var Options={
    /*user can select displayed results */
    displayed_results:{
      value:"%", //possible values: {%, kg/d, g/m3}
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
      }
    },
    /*for further user-options: new options should go here*/
  }
</script>

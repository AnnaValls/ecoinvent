<?php
/* 
 * Description of this php page
 *
 */
?>
<!doctype html><html><head>
  <?php include'imports.php'?>
  <link rel=stylesheet href=css.css>
  <title>Activity</title>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Create an Activity (wastewater generation)</h1><hr>

<!--status-->
<h4>status: developing user interface (before backend)</h4>

<!--create activity menu-->
<table border=1>
  <tr>
    <td>Name 
    <td><input placeholder="Name">

    <!--user chooses reference data here--> 
    <td rowspan=3 style=text-align:center>
      Compare activity vs reference data: 
      <select>
        <option> --CUSTOM--
        <option> France 1
        <option> Germany 1
        <option> Germany 2
        <option> Germany 3
        <option> Spain 1
        <option> Spain 2
      </select>
      <br>
      (this selection will make values below to change)
    </td>
    <td rowspan=3 style=text-align:center>
      <button>Compare</button>
    </td>
  <tr>
    <td>Comments
    <td><textarea placeholder="Comments"></textarea>
  <tr>
    <td>Activity
    <td>Steel, RER <issue class="help_wanted"></issue>
  <tr>
    <td colspan=2 style="vertical-align:top">
      <p>Define wastewater characteristics of your activity</p>
      <table id=inputs></table>
      <!--inputs.row template-->
      <template id=inputs_row>
        <tr title class=help>
          <td id>
          <td><input id value>
          <td unit style=font-size:smaller>
        </tr>
      </template>
    </td>
    <td style="vertical-align:top">
      <p>Chosen Reference data wastewater characteristics</p>
      <table id=inputs_reference></table>
    </td>
    <td style=vertical-align:top>
      Outputs will appear here
      after clicking 'Compare'
    </td>
</table>

<script>
  //fx: frontend
  (function populate_inputs(){
    populate_table('inputs');
    populate_table('inputs_reference',true);
    populate_table('inputs_reference',true,true);

    function populate_table(id,disabled,design_parameters){
      disabled=disabled||false;
      design_parameters=design_parameters||false;

      //get table by id
      var t=document.getElementById(id);

      //empty table
      if(!design_parameters) while(t.rows.length>0)t.deleteRow(-1);

      //get template
      var template=document.querySelector("template#inputs_row");

      //filter inputs depending on if we want design parameters or normal inputs
      var filtered_Inputs;
      if(!design_parameters){
        filtered_Inputs=Inputs.filter(inp=>{return !inp.isParameter});
      }else{
        filtered_Inputs=Inputs.filter(inp=>{return inp.isParameter});
      }

      //add a mini header for design parameters
      if(design_parameters){
        var newRow=t.insertRow(-1);
        newRow.insertCell(-1).outerHTML="<td colspan=3><p><b>Design parameters</b></p>";
      }

      //go over Inputs
      filtered_Inputs.forEach(inp=>{
        //clone row template
        var clone=template.content.cloneNode(true);

        //title (caption)
        var tr=clone.querySelector('tr');
        tr.title=inp.descr;

        //name
        var td=clone.querySelector('td[id]');
        td.innerHTML=inp.id;
        //input value
        var input=clone.querySelector('input[id][value]');
        input.id=inp.id;
        input.value=inp.value;
        if(disabled)input.disabled=true;
        //unit
        var unit=clone.querySelector('td[unit]');
        unit.innerHTML=inp.unit.prettifyUnit();
        //append clone
        t.appendChild(clone);
      });
    }
  })();
</script>


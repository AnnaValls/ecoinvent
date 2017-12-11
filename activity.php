<?php
/* 
 *
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
<h4>status: developing user interface (before backend)</h4>

<!--create activity menu-->
<table border=1>
  <tr>
    <td>Name 
    <td><input placeholder="Name">

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
    <td colspan=2>
      <p>Define wastewater characteristics of your activity</p>
      <table id=inputs></table>
      <!--inputs.row template-->
      <template id=inputs_row>
        <tr>
          <td id>
          <td><input id value>
          <td unit style=font-size:smaller>
        </tr>
      </template>
    </td>
    <td>
      <p>Chosen Reference data wastewater characteristics</p>
      <table id=inputs_reference></table>
    </td>
    <td style=vertical-align:top>
      Outputs here
      after clicking 'Compare'
    </td>
</table>


<script>
  //fx: frontend
  (function populate_inputs(){
    populate_table('inputs');
    populate_table('inputs_reference',true);
    function populate_table(id,disabled){
      disabled=disabled||false;
      var t=document.getElementById(id);
      while(t.rows.length>0)t.deleteRow(-1);
      var template=document.querySelector("template#inputs_row");
      Inputs.filter(inp=>{return !inp.isParameter}).forEach(inp=>{
        //clone row template
        var clone=template.content.cloneNode(true);
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

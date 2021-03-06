<!--File/Edit/View-->
<div id=top_menu class=flex style="background:#eee">
  <!--File-->
  <div>
    <button onclick="toggleView_top_menu_item('top_menu #file',event)">
      File</button>
    <ul id=file style="display:none">
        <!--load-->
        <li>
          <script>
            function loadFile(evt){
                var file=evt.target.files[0];
                var reader=new FileReader();
                reader.onload=function() {
                  var saved_file;
                  try{
                    saved_file=JSON.parse(reader.result);
                    (function(){
                      //technologies
                      Object.keys(saved_file.techs).forEach(key=>{
                        var newValue=saved_file.techs[key].value;
                        document.querySelector('#inputs_tech input[tech='+key+']').checked=newValue;
                        getInput(key,true).value=newValue;
                      });
                      //inputs
                      Object.keys(saved_file.inputs).forEach(key=>{
                        var newValue=saved_file.inputs[key].value;
                        document.querySelector('#inputs #'+key).value=newValue;
                        getInput(key,false).value=newValue;
                      });
                    })();
                    init();
                  }catch(e){alert(e)}
                }
                try{
                  reader.readAsText(file);
                }catch(e){alert(e)}

                //show "loaded successfully"
                (function(){
                  var div=document.createElement('p');
                  div.style.background="lightgreen";
                  div.style.fontFamily="monospace";
                  div.style.padding="3px 5px";
                  div.innerHTML="File loaded correctly <button onclick=this.parentNode.parentNode.removeChild(this.parentNode)>ok</button>";
                  document.querySelector("#loadFile").parentNode.appendChild(div);
                  div.querySelector('button').focus();
                  setTimeout(function(){if(div.parentNode){div.parentNode.removeChild(div)}},5000);
                })();
            }
          </script>
          <button onclick="document.getElementById('loadFile').click()">Load file</button>
          <input id=loadFile type=file accept=".json" onchange="loadFile(event)" style="display:none">
        </li>
        <!--save as json file component-->
        <li>
          <button id=saveToFile onclick="saveToFile()" style="">Save file</button>
          <script>
            /*Generate a json/text file*/
            function saveToFile() {
              var saved_file = {
                techs:{ },
                inputs:{ },
              }
              Technologies_selected.filter(t=>{return !t.notActivable}).forEach(t=>{
                saved_file.techs[t.id]={
                  descr:t.descr,
                  value:t.value,
                };
              });
              Inputs.forEach(i=>{
                saved_file.inputs[i.id]={
                  descr:i.descr,
                  value:i.value,
                  unit:i.unit,
                };
              });
              //console.log(saved_file);
              var datestring=(new Date()).toISOString().replace(/-/g,'').replace(/:/g,'').substring(2,13);
              var link=document.createElement('a');
              link.href="data:text/json;charset=utf-8,"+JSON.stringify(saved_file,null,'  ');
              link.download="inf"+datestring+"UTC.json";
              document.body.appendChild(link);//this line is required in firefox
              link.click();
            }
          </script>
        </li>
    </ul>
  </div>

  <!--Edit-->
  <div>
    <button onclick="toggleView_top_menu_item('top_menu #edit',event)">
      Edit</button>
    <ul id=edit style=display:none>
      <!--set all inputs to zero-->
      <li>
        <button style=""
          onclick="(function(){
            var inputs=document.querySelectorAll('#inputs input');
            for(var i=0;i<inputs.length;i++){
              inputs[i].value=0;
              getInput(inputs[i].id).value=0;
            }
            init();
        })()">Set all inputs to zero</button>
      </li>

      <!--set ww to zero-->
      <li>
        <button style=""
          onclick="(function(){
            var inputs=document.querySelectorAll('#inputs input');
            for(var i=0;i<inputs.length;i++){
              if(getInputById(inputs[i].id).isParameter){continue;}
              inputs[i].value=0;
              getInput(inputs[i].id).value=0;
            }
            init();
        })()">Set all wastewater components to zero</button>
      </li>

      <!--set dp to zero-->
      <li>
        <button style=""
          onclick="(function(){
            var inputs=document.querySelectorAll('#inputs input');
            for(var i=0;i<inputs.length;i++){
              if(!getInputById(inputs[i].id).isParameter){continue;}
              inputs[i].value=0;
              getInput(inputs[i].id).value=0;
            }
            init();
        })()">Set all design parameters to zero</button>
      </li>
    </ul>
  </div>

  <!--View-->
  <div>
    <button onclick="toggleView_top_menu_item('top_menu #view',event)">
      View</button>
    <ul id=view style=display:none>
      <li><button onclick=window.open('img/plant-diagram.jpg')     >Plant diagram</button>
      <li><button onclick=window.open('fractionation_diagrams.php')>Fractionation diagram</button>
      <li><button onclick=window.open('estimations.php')           >Estimations module</button>
    </ul>
  </div>

  <!--Help-->
  <div>
    <button onclick="toggleView_top_menu_item('top_menu #help',event)">
      Help</button>
    <ul id=help style=display:none>
      <li>Documentation
      <li><button onclick=window.open('technologies.php')>Technologies</button>
      <li><button onclick=window.open('inputs.php')>Inputs</button>
      <li><button onclick=window.open('outputs.php')>Calculated variables</button>
      <li><button onclick=window.open('see.php?path=dataModel&file=constants.js')>Constants</button>
    </ul>
  </div>

  <!--logic-->
  <script>
    //fold items when click outside
    document.documentElement.addEventListener('click',top_menu_fold_all_items);
  </script>
</div>

<div id=top_menu class=flex style="background:#eee">
  <!--File-->
  <div>
    <button onclick="toggleView_top_menu_item('top_menu #file')">
      File
    </button>
    <ul id=file style=display:none>
      <!--load-->
      <li>
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
      </li>
      <li>
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
      </li>
      <li>
        <button>Generate ecoSpold file</button>
      </li>
      <!--save-->
    </ul>
  </div>

  <!--Edit-->
  <div>
    <button onclick="toggleView_top_menu_item('top_menu #edit')">
      Edit
    </button>
    <ul id=edit style=display:none>
      <li><button onclick="add_wwtp()" style=background:yellow>Add plant</button>
      <li><button onclick="WWTPs=[];add_wwtp()">Clear all plants</button>
    </ul>
  </div>

  <!--click listener-->
  <script>
    //fold items when click outside
    document.documentElement.addEventListener('click',top_menu_fold_all_items);
  </script>
</div>

<!--views-->
<style>
  #top_menu {
    border-bottom:1px solid #ccc;
    padding-left:8px;
    padding-bottom:1px;
  }

  #top_menu > div {
    margin-right:8px;
    position:relative;
  }

  #top_menu > div > ul[id] {
    margin-top:2px;
    position:absolute;
    background:#eee;
    list-style-type:none;
    padding:0 5px 5px 5px;
    box-shadow: 0 1px 2px rgba(0,0,0,.1);
  }

  #top_menu > div > ul[id] button{
    text-align:left;
    width:100%;
    width:150px;
    border:1px solid #ccc;
    border-radius:0;
    background:white;
  }
</style>

<!doctype html><html><head>
  <?php include'imports.php'?>
  <script>
    var received_json = JSON.parse('<?php echo $_POST['input'] ?>');

    function genereate_ecospold(){
      //change this when other server
      post('ecospold/index.php', "python3 generate_untreated_ecospold.py '"+JSON.stringify(received_json)+"'");
    }
  </script>
  <title>ecoSpold generation</title>
</head><body><?php include'navbar.php'?>
<div id=root><h1>Generating ecoSpold file...</h1>

<div>
  <div>
    The following data is going to be saved as two new ecoSpold files (untreated emissions and treated emissions):
  </div>

  <!--continue btn-->
  <div>
    <button
      style="font-size:16px;padding:0.618em 1em"
      onclick="genereate_ecospold()"
    >CONTINUE</button>
  </div>

  <!--received json-->
  <pre id=received_json style="border:1px solid #ccc"></pre>
</div>

<script>
  (function(){
    //show stringified input json at start
    document.getElementById('received_json').innerHTML=JSON.stringify(received_json,null,"  ");
  })();
</script>

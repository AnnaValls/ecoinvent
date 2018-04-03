<!doctype html><html><head>
  <?php include'imports.php'?>
  <title>Untreated WW ecospold</title>
  <script>
    var received_json = JSON.parse('<?php echo $_POST['input'] ?>');
  </script>
</head><body>
<?php include'navbar.php'?>
<div id=root>
<h1>Generating ecospold file...</h1>
<div>
  <b>The following data is going to be saved as a new ecospold file</b>
  <button
    style="font-size:18px;padding:0.5em 1em"
    onclick="genereate_untreated_ecospold()"
  >CONTINUE</button>
  <pre id=received_json style="border:1px solid #ccc"></pre>

  <script>
    function genereate_untreated_ecospold(){
      //Server is windows
      post('ecospold/index.php',"python generate_untreated_ecospold.py '"+JSON.stringify(received_json)+"'");
      //Server is unix
      //post('ecospold/index.php',     "./generate_untreated_ecospold.py '"+JSON.stringify(received_json)+"'");
    }
  </script>
</div>

<script>
  (function(){
    document.getElementById('received_json').innerHTML=JSON.stringify(received_json,null,"  ");
  })();
</script>

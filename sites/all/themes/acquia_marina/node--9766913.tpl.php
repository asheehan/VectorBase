<?php

$image="/".drupal_get_path('theme', 'acquia_marina')."/images/deadMosquito.png";
echo '<center><h1 style="color:#27638C;">404 Error</h1>
<h3>The page '.$_SERVER['REQUEST_URI'].' does not exist!</h3><br/>
<img width="180" src="'.$image.'">';

//var_dump($_SERVER);
if($_SERVER['HTTPS']=="on")
$protocol="https";
else
$protocol="http";

?>
</center>
<div class="404helpText" style="padding:40px;">
This error has been logged and the administrators will be notified. If you would like to provide additional comments describing the conditions under which the error occured please feel free to 
<a href="mailto:webmaster@vectorbase.org?subject=404 Error&body=<?php echo date(DATE_RFC822);?>%0dReferer: <?php echo urlencode($_SERVER["HTTP_REFERER"]);?>%0dTarget: <?php echo "$protocol://".$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];?>">contact us to report the error.</a>
</div>





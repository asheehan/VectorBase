<?
preg_match("/\w*:\w*:(\w*\.\w*):\d+:(\w*):.*/", $region, $r);
$region = $r[1];# . ":" . $r[2];
//$width = (int) ($end - $start)*(1.5);
//$median = (($end+$start)/2);
$margin=30;
$dispString .= "<br /><a style=\'color:#0000ff\' href=\'http://www." . $_SESSION["server_suffix"] . "vectorbase.org/Culex_quinquefasciatus/Location/View?r=".$region.":" . ($start-$margin) . "-" . ($end+$margin) . ";contigviewbottom=url:http://www." . $_SESSION["server_suffix"] . "vectorbase.org/data/job_output/BLAST/" . $job_id . "_" . $rNum . ".gff=unbound\'>View alignment in genome browser</a>";

?>

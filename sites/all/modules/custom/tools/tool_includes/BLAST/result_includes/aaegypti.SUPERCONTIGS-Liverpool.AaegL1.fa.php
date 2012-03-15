<?
//preg_match("/supercontig_(.*)/", $region, $r);
//preg_match("/^supercont\d\.\d+/")
//$region = "supercont".$r[1];
//$dispString .= "<br /><a href=\'http://aaegypti.vectorbase.org/Genome/ContigView/?vc_start=" . $start . "&vc_end=" . $end . "&region=" . $region . "\'>View in Genomic Scaffold Viewer</a>";
//$width = (int) ($end - $start)*(1.5);
//$median = (($end+$start)/2);
//$dispString .= "<br /><a style=\'color:#0000ff\' href=\'http://aaegypti." . $_SESSION["server_suffix"] . "vectorbase.org/Genome/ContigView/?c=".$region.":" . $median . ";w=" . $width . ";data_URL=http://aaegypti." . $_SESSION["server_suffix"] . "vectorbase.org/data/job_output/BLAST/" . $job_id . "_" . $rNum . ".gff\'>View alignment in genome browser</a>";
$margin=30;
$dispString .= "<br /><a style=\'color:#0000ff\' href=\'http://www." . $_SESSION["server_suffix"] . "vectorbase.org/Aedes_aegypti/Location/View?r=".$region.":" . ($start-$margin) . "-" . ($end+margin) . ";contigviewbottom=url:http://www." . $_SESSION["server_suffix"] . "vectorbase.org/data/job_output/BLAST/" . $job_id . "_" . $rNum . ".gff=ungrouped\'>View alignment in genome browser</a>";

?>

<?php

	$server_vars = $_SERVER["DOCUMENT_ROOT"] . "/includes/index_header.php";
	include_once($server_vars);
	include_once($_SERVER["DOCUMENT_ROOT"]."includes/Jobs.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."sections/Tools/tool_includes/ClustalW/clustalw_errors.php");



function print_r_html($data,$return_data=false)
{
    $data = print_r($data,true);
    $data = str_replace( " ","&nbsp;", $data);
    $data = str_replace( "\r\n","<br>\r\n", $data);
    $data = str_replace( "\r","<br>\r", $data);
    $data = str_replace( "\n","<br>\n", $data);

    if (!$return_data)
        echo $data;   
    else
        return $data;
}


echo '$_GET</br>';
print_r_html($_GET);
echo '</br></br></br></br></br></br>';

echo '$_POST</br>';
print_r_html($_POST);
echo '</br></br></br></br></br></br>';

echo '</br>';
echo '</br>';
echo 'string length of input sequence: '.strlen($_POST["input_sequence"]).'</br>';
echo 'input file size: '.$_FILES["input_file"]["size"].'</br>';

echo 'max input: '.$MAX_INPUT_SIZE.'</br>';
?>

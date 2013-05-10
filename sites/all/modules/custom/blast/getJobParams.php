<?php

// print all job params for given job id

$id=$_POST['id'];

$params=db_query("select * from xgrid_job_params where job_id=$id");
foreach($params as $param){
	if($param->argument!='target_database' && $param->argument!='dbs')
		$jobParams[$param->argument]=$param->value;
	else if($param->argument=='target_database')
		$jobParams['dbs'][]=$param->value;
}
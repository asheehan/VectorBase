<?
$server_vars = $_SERVER["DOCUMENT_ROOT"] . "/includes/index_header.php";
//error_reporting(E_ALL);
include ($server_vars);
include_once("Jobs.php");
include_once("hmmer_errors.php");
include("regex.php");

$errors = array();

// ERROR CHECKING
if (!$_POST["get_hmmsearch"]){
  // Check to see if database is chosen	
  if (!$_POST["blastdb_id"]){
    array_push($errors,1);
  }

  //verify evalue is a number
  if ( !(RegexNumber($_POST["evalue"])) ){
    array_push($errors,14);
  }


  // Get all the databases out for more error checking
  $bdbs = array();
  $sql = "select * from blast_databases;";
  $bdb_rs = pg_query(DB::getUI_DB(),$sql);
  while ($bdb_row = pg_fetch_assoc($bdb_rs)){
    $bdbs[$bdb_row["blastdb_id"]] = $bdb_row["file_name"];
  }

/*
  // Check to make sure we don't have two different types of databases
  $n_db = 0;
  $p_db = 0;
  if ($_POST["blastdb_id"]){
    foreach ($_POST["blastdb_id"] as $blastdb_id){
      if ($bdbs[$blastdb_id] == "NUCLEOTIDE"){
        $n_db = 1;
      } else {
        $p_db = 1;
      }
    }
    // Different Database Types!
    if ($n_db && $p_db){
      array_push($errors,3);
    }
  }
*/

  // Check to make sure we have input
  $have_input=1;
  if (($_FILES["input_file"]["error"])&&(strlen($_POST["input_sequence"])<5)){
    // Where's the input? I don't know.
    array_push($errors,5);
    $have_input=0;
  }



  // Check to make sure our input sequence isn't bigger than 100k
  /*$TOO_BIG=0;
  if ((strlen($_POST["input_sequence"])>$MAX_INPUT_SIZE)||( $_FILES["input_file"]["size"] > $MAX_INPUT_SIZE)){
    // Input sequence too big
    array_push($errors,7);
    $TOO_BIG=1;
  }*/

  // Try and move the input file (if provided) to a tmp location
  if ($_FILES["input_file"]["tmp_name"]){
    $upload_file = $TOOL_UPLOADS . md5($_SERVER['REQUEST_TIME']) . ".hmmsearch_input";
    if (move_uploaded_file($_FILES['input_file']['tmp_name'], $upload_file)) {
      $lines = file($upload_file);
      $input_model_data = file($upload_file);
      unlink($upload_file);
    } else {
      array_push($errors,8);
    }
    // If input comes in the text field, put it in an array just so it's like the file upload input
  } elseif (strlen($_POST["input_sequence"])>5){
    $lines = split("\n",$_POST["input_sequence"]);
    $input_model_data = $_POST["input_sequence"];  
    //$lines = $_POST["input_sequence"];
  } elseif ($have_input){
    // if we get here and have input, something is wrong.... 
    array_push($errors,10);
  }

  // look for the alphabet in the input model
  // to determine if nucleotide or peptide
  $model_seqtype = 0;
  for ($lineI = 0; $lineI < sizeof($lines); $lineI++) {
    $words = preg_split("/\s+/", $lines[$lineI]);
    //print_r($words);
    if ($words[0] == "ALPH") {
      if ($words[1] == "Amino") {
        $model_seqtype = 1;
      } else {
        $model_seqtype = 2;
      }
      break;
    }
  }
  if (!$model_seqtype) {
    array_push($errors,9);
  }

/*
  // Cannot use a nucleotide model against
  // a peptide database
  if ($model_seqtype == 2) {
    foreach ($_POST["blastdb_id"] as $blastdb_id) {
      if ($bdbs[$blastdb_id] == "PEPTIDE") {
         array_push($errors,3);
         break;
      }
    }
  }



/*
  // temporairly disallow a peptide model against
  // a nucleotide database

  if ($model_seqtype == 1) {
    foreach ($_POST["blastdb_id"] as $blastdb_id) {
      if ($bdbs[$blastdb_id] == "NUCLEOTIDE") {
         array_push($errors,3);
         break;
      }
    }
  }

*/



  // Translate each DB into an appropriate sequence
  // file for doing a HMMER search
  $hmmer_dbs = array();
  foreach ($_POST["blastdb_id"] as $blastdb_id) {
	array_push($hmmer_dbs, $blastdb_id);
  }
/*   this should be in the foreach loop...
    if ($model_seqtype == 1) {
      if ($bdbs[$blastdb_id] == "PEPTIDE") {
        array_push($hmmer_dbs, $blastdb_id);
      } else { 
        array_push($hmmer_dbs, $blastdb_id . ".frame0");
        array_push($hmmer_dbs, $blastdb_id . ".frame1");
        array_push($hmmer_dbs, $blastdb_id . ".frame2");
        array_push($hmmer_dbs, $blastdb_id . ".frame0R");
        array_push($hmmer_dbs, $blastdb_id . ".frame1R");
        array_push($hmmer_dbs, $blastdb_id . ".frame2R");
      }
    } else {
      array_push($hmmer_dbs, $blastdb_id);
      array_push($hmmer_dbs, $blastdb_id . ".reverse");
    }

  }



/*
  // concat all lines into a single string 
  // Error checking later?
  for($lineI = 1; $lineI < sizeof($lines); $lineI++){
    if (substr($lines[$lineI], 0, 1) != ">") {
      $lines[$lineI] = preg_replace('/[ \n\r]/', '', $lines[$lineI]);
    } else {
      $lines[$lineI] = "\n" . $lines[$lineI];
    }
  }
*/

  //print_r($model_seqtype);
  //print_r($hmmer_dbs);
  //exit;



} else {

  // Check to see if they provided the job id if they're trying retrieve a job id
  if (!((int)($_POST["job_id"])) && (strlen($_POST["get_hmmsearch"])>0)){
    // No Job ID!
    array_push($errors,6);
  }
}

// If we have errors, redirect to the input page with error codes attached to the url
if (count($errors)){
  $error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/HMMSEARCH/?error=1";
  foreach ($errors as $error_code){
    $error_rdir .= "&e" . $error_code . "=1";
  }
  header("Location: " . $error_rdir);
  exit();
} else {
  // NO ERRORS

  // If the user is just asking for a job, just redirect them...
  $job_id="";
  if (((int)($_POST["job_id"])) && (strlen($_POST["get_hmmsearch"])>0)){
    $job_id = $_POST["job_id"];
  } else {
    // Create a new HMMSEARCH JOB
    $input_model_data = str_replace(array("\r\n","\r"), "\n", $input_model_data);

    $hmmsearch_params_array = array("model"=>$input_model_data,
        "databases"=>$hmmer_dbs,
        "evalue"=>$_POST["evalue"]
    );
    $fp = fopen("/Volumes/Web/vectorbase/data/job_input/TEST1", 'w');
    fwrite($fp, $input_model_data[0]);
    fclose($fp);

    $hmmsearch = new HMMSEARCHJob($hmmsearch_params_array);
    try {
      $result = $hmmsearch->submit();
    } catch (JobException $e) {
      $error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/HMMSEARCH/?error=1&e0=" . urlencode($e->getMessage());
      header("Location: " . $error_rdir);
      print "Error! Please see the error message <a href=\"$error_rdir\">here</a>.";
      exit();
    }
    $job_id = $result;		
    //$job_id = $result["id"];

    if ($job_id == ""){
      $error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/HMMSEARCH/?error=1&e11=1";
      header("Location: " . $error_rdir);
      exit();
    }
    //inserting hmmsearch information into the database.

    if($_SESSION['logged_in']){
      $uid = $_SESSION['user_id'];
    } else {
      $uid = 'USERID_00000000001';
    }

   $jobs_insert_query = "insert into job_params (job_id,argument,value) values (". $job_id .", '".$uid."', '"."HMMSEARCH"."')";
   pg_query(DB::getJOB_DB(), $jobs_insert_query);


    $ip_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'submitter_ip','" . $_SERVER["REMOTE_ADDR"] . "');";
    pg_query(DB::getJOB_DB(),$ip_query);

    $date_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'job_submit_date','" . date('Y\-m\-d G:i:s') . "');";
    pg_query(DB::getJOB_DB(),$date_query); 



    foreach($hmmsearch_params_array as $bpa_key => $bpa_value) {
      if($bpa_key == "databases"){
        foreach ($bpa_value as $database){
          $bpa_query = "insert into job_params (job_id, argument, value) values (".$job_id.", 'target_database','". $database ."')";
          pg_query(DB::getJOB_DB(), $bpa_query);
        }
      } else {
        $bpa_query = "insert into job_params (job_id, argument, value) values (".$job_id.", '".$bpa_key."', '".$bpa_value."')";
        pg_query(DB::getJOB_DB(), $bpa_query);
      }
    }
  }

  // Redirect to the job status page
  $status_rdr = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/HMMSEARCH/?job_id=" . $job_id . "&page=status";
  header("Location: " . $status_rdr);				
}
  ?>

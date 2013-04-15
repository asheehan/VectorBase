<?php

ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache; remove when everything works
ini_set('error_reporting', E_ALL ^ E_NOTICE);
require_once('db_connect.php');


/* 
class: Jobs
methods: 
	getStatus($id, $program)
	getResults($id, $program)

$program isn't used in either function call but is included for legacy purposes
*/

class Jobs {

	// outputs an array of status attributes
	public function getStatusNew($id) {
		if (!$id) { throw new JobException("No job ID provided."); }
		$soapClient = new SoapClient("http://jobs.vectorbase.org/xgrid.wsdl", array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));
		$statusOutput = $soapClient->getStatus($id);

		$attributes = array("dateStarted","dateSubmitted","jobStatus","name","percentDone");
		foreach($attributes as $attribute){
			preg_match("#".$attribute." = (.*);#",$statusOutput,$match);
			$outputs[$attribute]=$match[1];
		}
		if (!$outputs["status"]) { throw new JobException("Sorry, we have no information for Job ID ".$id); }

		return $outputs;
	}

	// only returns the job status
	public function getSimpleStatus($id) {
		if (!$id) { throw new JobException("No job ID provided."); }
		$soapClient = new SoapClient("http://jobs.vectorbase.org/xgrid.wsdl", array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));
		$statusOutput = $soapClient->getStatus($id);
		preg_match("#jobStatus = (.*?);#",$statusOutput,$match);
		if (!$match[1]) { throw new JobException("Sorry, we have no information for Job ID ".$id); }
		return $match[1];
	}

	public function getResultsNew($id) {
		$client = new SoapClient("http://jobs.vectorbase.org/xgrid.wsdl", array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));
		if (!$id) { throw new JobException("No job ID provided."); }
		$status = new JobStatus($id);
		$this->status = $status->simpleStatus();
		if (!$this->status) { throw new JobException("No data for job ID ".$id."."); }

		if ($this->status=="Finished") { 
			$results = $client->getResults($id);
		}

		return $results;
	}

	public function submitJob($batchXml) {
		$client = new SoapClient("http://jobs.vectorbase.org/xgrid.wsdl", array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));
		$jobId = $client->submitBatch($batchXml);
		return $jobId;
	}
// ==============================================================================
// these next 2 are included for legacy purposes and are extremely bulky
// they need to be phased out of all the job specific pages. STOP USING THESE!
    public static function getStatus($id, $program='null') {
	$status = new JobStatus($id);
	return $status;
    }
    public static function getResults($id, $program='null') {
      $results = new JobResults($id);
      return $results;
    }
// ==============================================================================


}

/* 
class: JobStatus($id)
methods: 
	status()

fetches job status data on construction, outputs status data on JobStatus::status() call
*/
  class JobStatus {
    private $status = array();
    private $output = array();
    protected $client;

    function __construct($id) {
      require("static_vars.php");
      if (!$id) { throw new JobException("No job ID provided."); }
	$soapClient = new SoapClient("http://jobs.vectorbase.org/xgrid.wsdl", array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));
	$statusOutput = $soapClient->getStatus($id);
	$this->output["started"]=$this->parseStatus($statusOutput,"dateStarted");
	$this->output["submitted"]=$this->parseStatus($statusOutput,"dateSubmitted");
	$this->output["status"]=$this->parseStatus($statusOutput,"jobStatus");
	$this->output["name"]=$this->parseStatus($statusOutput,"name");
	$this->output["percentDone"]=$this->parseStatus($statusOutput,"percentDone");

	if (!$this->output["status"]) { throw new JobException("Sorry, we have no information for Job ID ".$id); }
    }

    function parseStatus($commandlineOutput, $parseFor){
	preg_match("#".$parseFor." = (.*);#",$commandlineOutput,$match);
	return $match[1];
    }

    public function simpleStatus(){
	return $this->output["status"];
    }

    public function status() {
	return $this->output;
    }
  }

/* 
class: JobResults($id)
methods: 
	status()
	results()
	parsedResults(), for BLAST jobs

status must be called before results is called.
*/
class JobResults {
	protected $results = "";
	protected $parsedresults = "";
	protected $client;

	function __construct($id) {
		require("static_vars.php");
		if (!$id) { throw new JobException("No job ID provided."); }
		$this->id=$id;
		//$status = new JobStatus($id);
		//$this->status = $status->simpleStatus();
		$this->status = Jobs::getSimpleStatus($id);
		if (!$this->status) { throw new JobException("No data for job ID ".$id."."); }
	}

	public function results() {
	//this used to get jobid-1 for blast raw results... now it does the same thing as parsedResults
		return JobResults::parsedResults();
	}

	public function parsedResults(){
	// USE THIS FOR GETTING NORMAL JOB RESULTS!!!!!!
	//this returns the parsed job results for blast, should be the id that has been used to construct the class
		if ($this->status=="Finished") { // Job and SOAP client seem to exist
			$soapClient = new SoapClient("http://jobs.vectorbase.org/xgrid.wsdl", array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));
			$results = $soapClient->getResults($this->id);
		}
		return $results;
	}
}



  abstract class JobSubmission {
    protected $submission;
    protected $client;
    function __construct($submitter) {
      $this->submission["submitter"] = $submitter;
    }
    function __toString() {
      $strings = array();
      foreach ($this->submission as $field => $value) {
        if (is_array($value)) { $value = implode(",", $value); }
        array_push($strings, "\t$field: $value");
      }
      return "JobSubmission:\n" . implode(", \n", $strings);
    }
    public function submit() {
      require("static_vars.php");
      //$this->client = new SoapClient("http://" . $APP . "/applications/definitions/JobService.wsdl", array('trace' => 1));
      	$this->client = new SoapClient("http://".$APP.":8080/axis/services/Jobs?wsdl");
      try {
        $result = $this->client->SubmitJob($this->submission);
      } catch (SoapFault $e) {
        // Rethrow exception with better formatting
        throw new JobException("RPC error retrieving status: (" . $e->faultcode . ") " . $e->faultstring . ". Most likely the applications server is down.");
      }
      return $result;
    }
  }

  class BLASTJob{

    private $options = array();
    private $databases= array();
    private $sequence="";

    function __construct($submitter, $program = false, $sequence = false, $databases = false, $wordsize = false, 
                         $evalue = false, $scoringmatrix = false, $masking = false, $numhits_oneline = false, $numhits_align = false) {
      if (is_array($submitter)) {
        // Demux associative input
        $program = $submitter["program"];
        $sequence = $submitter["sequence"];
        $databases = $submitter["databases"];
        $wordsize = $submitter["wordsize"];
        $evalue = $submitter["evalue"];
        $scoringmatrix = $submitter["scoringmatrix"];
        $masking = $submitter["masking"];
        $numhits_oneline = $submitter["numhits_oneline"];
        $numhits_align = $submitter["numhits_align"];
        // Set submitter to the actual submitter
        // P.S. Don't try to set anything the the submitter array after this, derr
        $submitter = $submitter["submitter"];
      }

      if (!is_array($databases)) { $databases = array($databases); }
      if (!$program || !$sequence || !count($databases)) {
        throw new JobException("Need at least a program type ($program), sequence ($sequence), and database (" . implode(", ", $databases). ")");
      }
      if ($sequence)         $this->sequence = $sequence;
      if ($databases)        $this->databases = $databases;
      if ($program)          $this->options["program"] = $program;			else $this->options["program"] ="";
      if ($wordsize)         $this->options["wordsize"] = $wordsize;			else $this->options["wordsize"] ="";
      if ($evalue)           $this->options["evalue"] = $evalue;			else $this->options["evalue"] ="";
      if ($scoringmatrix)    $this->options["scoringmatrix"] = $scoringmatrix;		else $this->options["scoringmatrix"] ="";
      if ($masking)          $this->options["masking"] = $masking;			else $this->options["masking"] ="";
      if ($numhits_oneline)  $this->options["numhits_oneline"] = $numhits_oneline;	else $this->options["numhits_oneline"] ="";
      if ($numhits_align)    $this->options["numhits_align"] = $numhits_align;		else $this->options["numhits_align"] ="";
      $this->submission["BLAST"] = $this->options;
    }

    function __toString() {
      $strings = array();
      foreach ($this->submission as $field => $value) {
        if (is_array($value)) { $value = implode(",", $value); }
        array_push($strings, "\t$field: $value");
      }
      return "JobSubmission:\n\nBLASTJob:\n" . implode(", \n", $strings);
    }


    public function submit() {

	require("static_vars.php");
	//create .plist file to submit to xgrid via soap service

	//create program argument string
	$arguments="\n\t\t<string>-p</string>\n\t\t<string>".$this->options["program"]."</string>";
	$arguments.="\n\t\t<string>-W</string>\n\t\t<string>".$this->options["wordsize"]."</string>";
	$arguments.="\n\t\t<string>-e</string>\n\t\t<string>".$this->options["evalue"]."</string>";
	$arguments.="\n\t\t<string>-M</string>\n\t\t<string>".$this->options["scoringmatrix"]."</string>";
	$arguments.="\n\t\t<string>-F</string>\n\t\t<string>".$this->options["masking"]."</string>";
	$arguments.="\n\t\t<string>-v</string>\n\t\t<string>".$this->options["numhits_oneline"]."</string>";
	$arguments.="\n\t\t<string>-b</string>\n\t\t<string>".$this->options["numhits_align"]."</string>\n";

        $random=genRandomString(6);
        $filename="BLAST_".$random;

	$batch ="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	<!DOCTYPE plist PUBLIC \"-//Apple Computer//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">
	<plist version=\"1.0\">
	<array>
	<dict>
	<key>inputFiles</key>
	<dict>
	<key>sequence</key>
	<dict>
	<key>fileData</key>
	<data>".base64_encode($this->sequence)."</data>
	</dict> 
	</dict>
	<key>name</key>
	<string>".$filename."</string>
	<key>taskSpecifications</key>
	<dict>\n"; 

	foreach($this->databases as $db){
		$batch.=" <key>$db</key>
		<dict>
		<key>arguments</key>
		<array>
		$arguments
		<string>-d</string>
		<string>/var/blast/$db</string>
		<string>-i</string>
		<string>sequence</string>
		</array>
		<key>command</key>
		<string>/opt/local/blast/bin/blastall</string>
		</dict>\n";
	}

	$batch.=" </dict>
	</dict>
	</array>
	</plist>";

	$searchId = Jobs::submitJob($batch);
	$this->searchId=$searchId;
        $filename="BLASTparse_".$random;

	//run the script that dump blast results to file for BLASTParse.pl, runs BLASTParse.pl, then cleans up
	$batch="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	<!DOCTYPE plist PUBLIC \"-//Apple Computer//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">
	<plist version=\"1.0\">
	<array>
	<dict>
	
	<key>name</key>
	<string>$filename</string>
	<key>schedulerParameters</key>
	<dict>
	<key>dependsOnJobs</key>
	<array>
	<string>$searchId</string>
	</array>
	</dict>
	<key>taskSpecifications</key>
	<dict>
	
	<key>printResultsToFile</key>
	<dict>
	<key>command</key>
	<string>/var/xgrid_results/xgridBlastParse.sh</string>
	<key>arguments</key>
	<array>
	<string>$searchId</string>
	<string>".$this->options["numhits_oneline"]."</string>
	<string>".$_SERVER['SERVER_ADDR']."</string>
	</array>
	</dict>

	</dict>
	</dict>
	</array>
	</plist>";

	$parseJobId = Jobs::submitJob($batch);
	return $parseJobId;
    }
  }

  //class HMMBUILDJob extends JobSubmission {
  class HMMBUILDJob {
    private $options = array();
    //public $content = "";
    //public $subsection = "";
    function __construct($submitter, $seqtype = false, $sequence = false, $calibrate = false, $randomseqlength = false, $randomseed = false, $randomseqlengthmean = false, $sampledseqs = false, $randomseqlengthstddev = false){

      if(is_array($submitter)) {
        $seqtype = $submitter["seqtype"];
        $algorithm = $submitter["algorithm"];
        $alignment = $submitter["alignment"];
        $calibrate = $submitter["calibrate"];
	$randomseqlength = $submitter["randomseqlength"];
	$randomseed = $submitter["randomseed"];
	$randomseqlengthmean = $submitter["randomseqlengthmean"];
	$sampledseqs = $submitter["sampledseqs"];
	$randomseqlengthstddev = $submitter["randomseqlengthstddev"];
        $sequence = $submitter["sequence"];
        $submitter = $submitter["submitter"];
      }

      //parent::__construct($submitter);
      if (!is_array($sequence)) { $sequence = array($sequence); }
      if ($seqtype)		   	{ $this->options["seqtype"] = $seqtype; }
      if ($algorithm)           	{ $this->options["algorithm"] = $algorithm; }
      if ($alignment)           	{ $this->options["alignment"] = $alignment; }
      if ($calibrate)           	{ $this->options["calibrate"] = $calibrate; }
      if ($randomseqlength)      	{ $this->options["randomseqlength"] = $randomseqlength; }
      if ($randomseed)              	{ $this->options["randomseed"] = $randomseed; }
      if ($randomseqlengthmean)  	{ $this->options["randomseqlengthmean"] = $randomseqlengthmean; }
      if ($sampledseqs)           	{ $this->options["sampledseqs"] = $sampledseqs; }
      if ($randomseqlengthstddev)	{ $this->options["randomseqlengthstddev"] = $randomseqlengthstddev; }
      if ($sequence)            	{ $this->options["sequence"] = $sequence; }

      $this->submission["HMMBUILD"] = $this->options;
    }

    function __toString() {
      $string = array();
      foreach ($this->options as $field => $value) {
        if (is_array($value)) { $value = implode(",", $value); }
        array_push($strings, "\t$field: $value");
      }
      //return parent::__toString() . "\nHMMBUILDJob:\n" . implode(", \n", $strings);
      return "\nHMMBUILDJob:\n" . implode(", \n", $strings);
    }

    public function submit() {
	require("static_vars.php");
	//create local .plist file to submit to xgrid via local command line

	//create program argument string
	$arguments="<string>--w".$this->options["algorithm"]."</string>";

	//open new file for writting plist to
	$random=genRandomString(6);
	$filename="build_".$random;


        #$seq = base64_encode($this->options["sequence"]);
        $tmp = clustalToStockholm($this->options["sequence"][0]);
        $seq = base64_encode($tmp);

	$batch = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	<!DOCTYPE plist PUBLIC \"-//Apple Computer//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">
	<plist version=\"1.0\">
	<array>
	<dict>
	<key>inputFiles</key>
	<dict>
	<key>sequence</key>
	<dict>
	<key>fileData</key>
	<data>$seq</data>
	</dict> 
	</dict>
	<key>name</key>
	<string>".$filename."</string>
	<key>taskSpecifications</key>
	<dict> 
	<key>0</key>
	<dict>
        <key>command</key>
        <string>/var/xgrid_results/HMMBuild.sh</string>
        <key>arguments</key>
	<array>
        <string>".$filename."</string>\n";
        //<string>
        //--mpi
        //</string>
        $batch.="$arguments
	</array>
	</dict>
	</dict>
	</dict>
	</array>
	</plist>";

	$jobId = Jobs::submitJob($batch);
	return $jobId;
    }
  }

  //class HMMSEARCHJob extends JobSubmission {
  class HMMSEARCHJob {
    private $options = array();
    //public $content = "";
    //public $subsection = "";
    public $job_id = 0;
    function __construct($submitter, $model = false, $databases = false,
			$numhits_oneline = false){
      if(is_array($submitter)) {
        $model = $submitter["model"];
        $databases = $submitter["databases"];
        $evalue = $submitter["evalue"];
        $submitter = $submitter["submitter"];
      }
      //parent::__construct($submitter);
      if(!is_array($databases)) { $databases = array($databases); }
      if(!is_array($model))     { $model = array($model); }
      if ($databases)       	{ $this->options["databases"] = $databases; }
      if ($evalue) 		{ $this->options["evalue"] = $evalue;    }
      if ($model)               { $this->options["model"] = $model; }
      $this->submission["HMMSEARCH"] = $this->options;
    }
    function __toString() {
      $string = array();
      foreach ($this->options as $field => $value) {
        if (is_array($value)) { $value = implode(",", $value); }
        array_push($strings, "\t$field: $value");
      }
      //return parent::__toString() . "\nHMMSEARCHJob:\n" . implode(", \n", $strings);
      return "\nHMMSEARCHJob:\n" . implode(", \n", $strings);
    }

    public function submit() {
	require("static_vars.php");
	//create local .plist file to submit to xgrid via local command line
        $arguments="";

	//create program argument string
	$arguments="\n\t<string>-E</string>\n\t<string>".$this->options["evalue"]."</string>\n";

	//open new file for writting plist to
	$random=genRandomString(6);
	$filename="HMMER_".$random;


        $seq = base64_encode($inputsequence[0]);
        $processors="4";

        $databases = $this->options["databases"];
        $model = $this->options["model"];

	$batch ="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	<!DOCTYPE plist PUBLIC \"-//Apple Computer//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">
	<plist version=\"1.0\">
	<array>
	<dict>
	<key>inputFiles</key>
	<dict>
	<key>sequence</key>
	<dict>
	<key>fileData</key>
	<data>".base64_encode($model[0])."</data>
	</dict> 
	</dict>
	<key>name</key>
	<string>".$filename."</string>
	<key>taskSpecifications</key>
	<dict>\n"; 

//".$arguments."
//<string>/opt/local/hmmer3/bin/hmmsearch</string>

        foreach ($databases as $db)
        {
        $str="/var/blast/".$db;
        $batch.="     <key>$db</key>
	<dict>
        <key>command</key>
        <string>/var/xgrid_results/HMMSearch.sh</string>
        <key>arguments</key>
	<array>
        <string>--domtblout</string>
        <string>table</string>".$arguments."\t<string>sequence</string>
        <string>".$str."</string>
	</array>\n";
        //<key>command</key>
        //<string>/usr/bin/mpirun</string>
	$batch.="     </dict>\n";
        }

	$batch.="        </dict>
	</dict>
	</array>
	</plist>";

	$jobId = Jobs::submitJob($batch);
	return $jobId;
    }
  }



  class ClustalWJob {
    protected $submission;
    protected $client;
    private $options = array();
	private $args=array();

    function __construct($submitter, $seqtype = false, $alignment = false, $sequence = false, $ktuple = false, $wlength = false, 
                         $score = false, $tdiag = false, $gpenalty = false, $matrix = false, $opengap = false,
			 $endgap = false, $extgap = false, $sepgap = false, $output = false, $order = false) {
      if (is_array($submitter)) {
        // Demux associative input
        $seqtype = $submitter["seqtype"];
        $alignment = $submitter["alignment"];
        $sequence = $submitter["sequence"];
        $ktuple = $submitter["ktuple"];
        $wlength = $submitter["wlength"];
        $score = $submitter["score"];
        $tdiag = $submitter["tdiag"];
        $gpenalty = $submitter["gpenalty"];
        $matrix = $submitter["matrix"];
        $opengap = $submitter["opengap"];
        $endgap = $submitter["endgap"];
        $extgap = $submitter["extgap"];
        $sepgap = $submitter["sepgap"];
        $output = $submitter["output"];
        $order = $submitter["order"];
        // Set submitter to the actual submitter
        // P.S. Don't try to set anything the the submitter array after this, derr
        $submitter = $submitter["submitter"];
      }

      //if (!is_array($sequence)) { $sequence = array($sequence); }
      if ($alignment)         	{ $this->options["alignment"] = $alignment; }
      if ($seqtype)         	{ $this->options["type"] = $seqtype; }
      if ($sequence)        	{ $this->options["sequence"] = $sequence; }
      if ($ktuple)       	{ $this->options["ktuple"] = $ktuple; }
      if ($wlength)        	{ $this->options["window"] = $wlength; }
      if ($score)          	{ $this->options["score"] = $score; }
      if ($tdiag)   		{ $this->options["topdiags"] = $tdiag; }
      if ($gpenalty)         	{ $this->options["pairgap"] = $gpenalty; }
      if ($matrix) 		{ if($seqtype=="dna") $this->options["dnamatrix"] = $matrix;
					else $this->options["pwmatrix"]=$matrix; }
      if ($opengap)   		{ $this->options["gapopen"] = $opengap; }
      if ($endgap)   		{ $this->options["endgaps"] = $endgap; }
      if ($extgap)   		{ $this->options["gapext"] = $extgap; }
      if ($sepgap)   		{ $this->options["gapdist"] = $sepgap; }
      if ($output)   		{ $this->options["output"] = $output; }
      if ($order)   		{ $this->options["outorder"] = $order; }
      $this->submission["ClustalW"] = $this->options;

	//Job class accepts arguments as string array
	$i=0;
	foreach(array_keys($this->options) as $option){
		if($option!="sequence" && $option!="alignment" && $this->options[$option]!="default"){
			$this->args[$i]="-".$option."=".$this->options[$option];
		}
		if($option=="alignment")
			$this->args[$i]="-align";
	$i++;
	}	
     }


    function __toString() {
      $strings = array();
      foreach ($this->submission as $field => $value) {
        if (is_array($value)) { $value = implode(",", $value); }
        array_push($strings, "\t$field: $value");
      }
      return "JobSubmission:\n\nClustalWJob:\n" . implode(", \n", $strings);
    }

public function args(){
	var_dump($this->options);
	var_dump($this->args);
	//print_r(array_keys($this->op,$this->options["program"]tions));
}

    public function submit() {
	//create program argument string
	foreach($this->args as $argument){
		$arguments.="<string>$argument</string>\n";
	}

	//open new file for writting plist to
	$random=genRandomString(6);
	$filename="ClustalW_".$random;

	$batch="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	<!DOCTYPE plist PUBLIC \"-//Apple Computer//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">
	<plist version=\"1.0\">
	<array>
	<dict>
	<key>inputFiles</key>
	<dict>
	<key>sequence</key>
	<dict>
	<key>fileData</key>
	<data>".base64_encode($this->options["sequence"])."</data>
	</dict> 
	</dict>
	<key>name</key>
	<string>$filename</string>
	<key>taskSpecifications</key>
	<dict>
		  
	<key>0</key>
	<dict>
	<key>command</key>
	<string>/var/xgrid_results/brokeClustalW.sh</string>
	<key>arguments</key>
	<array>
	<string>$filename</string>
	$arguments
	</array>
	</dict>
            
	</dict>
	</dict>
	</array>
	</plist>";

	$jobId = Jobs::submitJob($batch);
	return $jobId;
    }
}


  class ChapolloJob extends JobSubmission {
    private $options = array();
    function __construct($submitter, $perloptions = false) {
      if (is_array($submitter)) {
        // Demux associative input
        $perloptions = $submitter["perloptions"];
        $submitter = $usbmitter["submitter"];
      }
      parent::__construct($submitter);
      if ($perloptions) { $this->options["perloptions"] = $perloptions; }
      $this->submission["Chapollo"] = $this->options;
    }
    function __toString() {
      $strings = array();
      foreach ($this->options as $field => $value) {
        if (is_array($value)) { $value = implode(",", $value); }
        array_push($strings, "\t$field: $value");
      }
      return parent::__toString() . "\nChapolloJob:\n" . implode(", \n", $strings);
    }
  }

  class seqJob extends JobSubmission {
    private $options = array();
    function __construct($parameters) {
      if (is_array($parameters)) {
        // Demux associative input
        $parameters = $parameters["parameters"];
        // Set parameters to the actual parameters
        // P.S. Don't try to set anything the the parameters array after this, derr
      }
      parent::__construct($parameters);
      if(!$parameters){
        throw new JobException("Need parameters");
      }
      if($parameters){$this->options["parameters"] = $parameters; }
      $this->submission["seq"] = $this->options;
    }
    function __toString() {
      $strings = array();
      foreach ($this->options as $field => $value) {
        if (is_array($value)) { $value = implode(",", $value); }
        array_push($strings, "\t$field: $value");
      }
      return parent::__toString() . "\nseqJob:\n" . implode(", \n", $strings);
    }
  }

  class JobException extends Exception {
    const NO_RESULTS = "No Results";
    const NO_JOB = "No Job";
    const NO_APP = "No Application Specified";
    const CLIENT = "Client";
    private $jobcode;
    function __construct($message = null, $code = false) {
      $this->jobcode = $code;
      parent::__construct($message, 0);
    }
    public function getJobCode() {
      return $this->jobcode;
    }
  }


function genRandomString($length) {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $string = "";    
    for ($p = 0; $p < $length; $p++) {
	$string .= $characters[mt_rand(0, strlen($characters)-1)];
    }
    return $string;
}

function clustalToStockholm($input){
        $patterns = array("/CLUSTAL \d\.\d\d?\.?\d?\d? multiple sequence alignment\n/","/\n\s+[\*\.\:\s]+/","/-/");
        $replacements = array("# STOCKHOLM 1.0","\n\n",".");
        $output = preg_replace($patterns, $replacements, $input)."//\n";
        return $output;
}

?>

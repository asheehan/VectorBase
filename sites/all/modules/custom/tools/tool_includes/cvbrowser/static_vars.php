<?
  
/*
  if ($_SERVER["SERVER_ADDR"] == "192.168.1.14"){
        $APP = "patty.vectorbase.org";
        $APPDIR = "App";
  } elseif ($_SERVER["SERVER_ADDR"] == "192.168.1.31") {
        $APP = "pierre.vectorbase.org";
        $APPDIR = "App2";
  } else {
        $APP = "pierre.vectorbase.org";
        $APPDIR = "App1";
  }
*/
$APP = "applications.vectorbase.org";
$DB = "db.vectorbase.org";
//$APP = "192.168.1.90";
//$DB = "192.168.1.90";
//$DB="127.0.0.1";
$APPDIR = "App";
  
  $UI_DATABASE_HOST = $DB;
  $UI_DATABASE_PORT = "5432";
  $UI_DATABASE_NAME = "vectorbase_ui";
  $UI_DATABASE_USERNAME = "db_public";
  $UI_DATABASE_PASSWORD = "limecat";

  $WRITABLES_DATABASE_HOST = $DB;
  $WRITABLES_DATABASE_PORT = "5432";
  $WRITABLES_DATABASE_NAME = "writables";
  $WRITABLES_DATABASE_USERNAME = "db_public";
  $WRITABLES_DATABASE_PASSWORD = "limecat";
  
  $JOB_DATABASE_HOST = $DB;
  $JOB_DATABASE_PORT = "5432";
  $JOB_DATABASE_NAME = "vectorbase_job_data";
  $JOB_DATABASE_USERNAME = "db_public";
  $JOB_DATABASE_PASSWORD = "limecat";

  $CHADO_DATABASE_HOST = $DB;
  $CHADO_DATABASE_PORT = "5432";
  $CHADO_DATABASE_NAME = "chado_current";
  $CHADO_DATABASE_USERNAME = "db_public";
  $CHADO_DATABASE_PASSWORD = "limecat";

  $CHADO_MANUAL_DATABASE_HOST = $DB;
  $CHADO_MANUAL_DATABASE_PORT = "5432";
  $CHADO_MANUAL_DATABASE_NAME = "manual_chado";
  $CHADO_MANUAL_DATABASE_USERNAME = "db_public";
  $CHADO_MANUAL_DATABASE_PASSWORD = "limecat";

  $CHADO_ANALYSES_DATABASE_HOST = $DB;
  $CHADO_ANALYSES_DATABASE_PORT = "5432";
  $CHADO_ANALYSES_DATABASE_NAME = "chado_current_analyses";
  $CHADO_ANALYSES_DATABASE_USERNAME = "db_public";
  $CHADO_ANALYSES_DATABASE_PASSWORD = "limecat";

  $BD_DATABASE_HOST = $DB;
  $BD_DATABASE_PORT = "5432";
  $BD_DATABASE_NAME = "blast_sequences";
  $BD_DATABASE_USERNAME = "db_public";
  $BD_DATABASE_PASSWORD = "limecat";

  $SITE_WIDTH = "800";
  
  $MONTHS = array(
				  'January',
				  'February',
				  'March',
				  'April',
				  'May',
				  'June',
				  'July',
				  'August',
				  'September',
				  'October',
				  'November',
				  'December'
				);

  $SIDEBAR_SUBSECTIONS = array(
    'Genome/MapView',
    'Genome/ContigView',
    'Genome/IdhistoryView',
    'Genome/HistoryView',
    'Genome/GeneView',
    'Genome/TransView',
    'Genome/ProtView',
    'Genome/FamilyView',
    'Genome/AlignView',
    'Genome/ExonView',
    'Genome/GenesnpView',
    'Genome/GeneseqView',
    'Genome/GenespliceView',
    'Genome/CytoView',
    'Genome/ExportView',
    'Genome/MulticontigView',
    'Genome/GeneregulationView',
    'Genome/AlignsliceView',
    'Genome/DomainView',
    'Genome/SnpView',
    'Genome/KaryoView',
    'Genome/LdView',
    'Genome/LdtableView',
    'Genome/MarkerView',
    'Genome/FeatureView',
    'Genome/FastaView',
    'Genome/DotterView',
    'Genome/DasconfView',
    'Search/Search',
    'Search/CVSearch'
  );
  
  $SIDEBAR_GENERATE_CONTENT = array('Genome','Search');

  
  $SIDEBAR_TOGGLEABLE = array('Genome');

	$TOOL_UPLOADS = $_SERVER["DOCUMENT_ROOT"] . "/data/tool_uploads/";
	$HTTP_DOWNLOAD_ROOT = "downloads/public_data/organism_data";
	$FTP_DOWNLOAD_ROOT = "ftp://ftp.vectorbase.org/public_data";

   define('IS_HTTPS', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');

?>

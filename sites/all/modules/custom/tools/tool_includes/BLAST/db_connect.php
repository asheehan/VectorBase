<?
require_once("static_vars.php");

	class DB {
		
		private static $ui_db = null;
		private static $writables_db = null;
		private static $job_db = null;
		private static $chado_database = null;
		private static $chado_manual_database = null;
		private static $chado_analyses_database = null;
                private static $blast_databases_db = null;
                
                public static function getBD_DB() {
                  global $BD_DATABASE_HOST, $BD_DATABASE_PORT, $BD_DATABASE_NAME, $BD_DATABASE_USERNAME, $BD_DATABASE_PASSWORD;
                  if(!isset(DB::$blast_databases_db)){
                    DB::$blast_databases_db = DB::connect_db($BD_DATABASE_HOST, $BD_DATABASE_PORT, $BD_DATABASE_NAME, $BD_DATABASE_USERNAME, $BD_DATABASE_PASSWORD);
                  }
                  return DB::$blast_databases_db;
                }

		public static function getWritables_DB(){
			global $WRITABLES_DATABASE_HOST,$WRITABLES_DATABASE_PORT,$WRITABLES_DATABASE_NAME,
				$WRITABLES_DATABASE_USERNAME,$WRITABLES_DATABASE_PASSWORD;
			if (!isset(DB::$writables_db)){
                          DB::$writables_db = DB::connect_db($WRITABLES_DATABASE_HOST,$WRITABLES_DATABASE_PORT,
				$WRITABLES_DATABASE_NAME,$WRITABLES_DATABASE_USERNAME,$WRITABLES_DATABASE_PASSWORD);
			}
			return DB::$writables_db;
		}

		
		public static function getUI_DB(){
			global $UI_DATABASE_HOST,$UI_DATABASE_PORT,$UI_DATABASE_NAME,$UI_DATABASE_USERNAME,$UI_DATABASE_PASSWORD;
			if (!isset(DB::$ui_db)){
                          DB::$ui_db = DB::connect_db($UI_DATABASE_HOST,$UI_DATABASE_PORT,$UI_DATABASE_NAME,$UI_DATABASE_USERNAME,$UI_DATABASE_PASSWORD);
			}
			return DB::$ui_db;
		}
		
		public static function getJOB_DB(){
			global $JOB_DATABASE_HOST,$JOB_DATABASE_PORT,$JOB_DATABASE_NAME,$JOB_DATABASE_USERNAME,$JOB_DATABASE_PASSWORD;
			if (!isset(DB::$job_db)){
                          DB::$job_db = DB::connect_db($JOB_DATABASE_HOST,$JOB_DATABASE_PORT,$JOB_DATABASE_NAME,$JOB_DATABASE_USERNAME,$JOB_DATABASE_PASSWORD);
			}
			return DB::$job_db;
		}
		
		public static function getCHADO_DB(){
			global $CHADO_DATABASE_HOST,$CHADO_DATABASE_PORT,$CHADO_DATABASE_NAME,$CHADO_DATABASE_USERNAME,$CHADO_DATABASE_PASSWORD;
			if (!isset(DB::$chado_database)){
                          DB::$chado_database = DB::connect_db($CHADO_DATABASE_HOST,$CHADO_DATABASE_PORT,$CHADO_DATABASE_NAME,$CHADO_DATABASE_USERNAME,$CHADO_DATABASE_PASSWORD);
			}
			return DB::$chado_database;
		}
		
		public static function getCHADO_MANUAL_DB(){
			global $CHADO_MANUAL_DATABASE_HOST,$CHADO_MANUAL_DATABASE_PORT,$CHADO_MANUAL_DATABASE_NAME,$CHADO_MANUAL_DATABASE_USERNAME,$CHADO_MANUAL_DATABASE_PASSWORD;
			if (!isset(DB::$chado_manual_database)){
                          DB::$chado_manual_database = DB::connect_db($CHADO_MANUAL_DATABASE_HOST,$CHADO_MANUAL_DATABASE_PORT,$CHADO_MANUAL_DATABASE_NAME,$CHADO_MANUAL_DATABASE_USERNAME,$CHADO_MANUAL_DATABASE_PASSWORD);
			}
			return DB::$chado_manual_database;
		}

		public static function getCHADO_ANALYSES_DB(){
			global $CHADO_ANALYSES_DATABASE_HOST,$CHADO_ANALYSES_DATABASE_PORT,$CHADO_ANALYSES_DATABASE_NAME,$CHADO_ANALYSES_DATABASE_USERNAME,$CHADO_ANALYSES_DATABASE_PASSWORD;
			if (!isset(DB::$chado_analyses_database)){
                          DB::$chado_analyses_database = DB::connect_db($CHADO_ANALYSES_DATABASE_HOST,$CHADO_ANALYSES_DATABASE_PORT,$CHADO_ANALYSES_DATABASE_NAME,$CHADO_ANALYSES_DATABASE_USERNAME,$CHADO_ANALYSES_DATABASE_PASSWORD);
			}
			return DB::$chado_analyses_database;
		}

		private static function connect_db($DATABASE_HOST,$DATABASE_PORT,$DATABASE_NAME,$DATABASE_USERNAME,$DATABASE_PASSWORD){
			$connect_string = "host=" . $DATABASE_HOST . " ";
			if ($DATABASE_PORT != "NULL"){
				$connect_string .= "port=" . $DATABASE_PORT . " ";
			}
			$connect_string .= "dbname=" . $DATABASE_NAME . " user=" . $DATABASE_USERNAME . " password=" . $DATABASE_PASSWORD;
			return pg_connect($connect_string); 
		}
	
	}

?>

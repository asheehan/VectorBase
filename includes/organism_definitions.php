<?
	class ORG {
	
		// Reverse lookup for shortname to ID
		/*
		public static $ID = array(
									// Nothing for organism 0
									""=>0,
									
									// All organisms
									"all"=>1,
									"All Organisms"=>1,
									
									// Anopheles gambiae
									"agambiae"=>2,
									"Anopheles gambiae"=>2,
									
									// Aedes aegypti
									"aaegypti"=>3,
									"Aedes aegypti"=>3,
									
									// Ixodes scapularis
									"iscapularis"=>4,
									"Ixodes scapularis"=>4,
									
									// Culex pipiens quinquefasciatus
									//"cpipiens"=>5,
									//"Culex pipiens"=>5,
									"quinquefasciatus"=>5,
									"Culex quinquefasciatus"=>5,

									// Glossina morsitans morsitans
									"gmorsitans"=>6,
									"Glossina morsitans"=>6,
									
									// Rhodnius prolixus
									"rprolixus"=>7,
									"Rhodnius prolixus"=>7,
									
									// Lutzomyia longipalpis
									"llongipalpis"=>8,
									"Lutzomyia longipalpis"=>8,
									
									// Pediculus humanus
									"phumanus"=>9,
									"Pediculus humanus"=>9,
									
									// Phlebotomus papatasi
									"ppapatasi"=>10,
									"Phlebotomus papatasi"=>10
								);
		*/
		
		// Short Names		  
		public static $SN = array(
									
									// All organisms
									"all",
									
									// Anopheles gambiae
									"agambiae",
									
									// Aedes aegypti
									"aaegypti",
									
									// Ixodes scapularis
									"iscapularis",
									
									// Culex pipiens quinquefasciatus
									//"cpipiens",
									"cquinquefasciatus",
									
									// Glossina morsitans morsitans
									"gmorsitans",
									
									// Rhodnius prolixus
									"rprolixus",
									
									// Lutzomyia longipalpis
									"llongipalpis",
									
									// Pediculus humanus
									"phumanus",
									
									// Phlebotomus papatasi
									"ppapatasi",


//"aalbopictus",
//"adarlingi",
//"afunestus",
//"astephensi",


									// Other organisms
									//"other"
								);
							
		// Display Names	
		public static $DN = array(
									
									// All organisms
									"all"=>"All organisms",
									
									// Anopheles gambiae
									"agambiae"=>"An. gambiae",
									
									// Aedes aegypti
									"aaegypti"=>"Ae. aegypti",
									
									// Ixodes scapularis
									"iscapularis"=>"I. scapularis",
									
									// Culex pipiens quinquefasciatus
									//"cpipiens"=>"C. pipiens",
									"cquinquefasciatus"=>"C. quinquefasciatus",
									
									// Glossina morsitans morsitans
									"gmorsitans"=>"G. morsitans morsitans",
									
									// Rhodnius prolixus
									"rprolixus"=>"R. prolixus",
									
									// Lutzomyia longipalpis
									"llongipalpis"=>"L. longipalpis",
									
									// Pediculus humanus
									"phumanus"=>"P. humanus",
									
									// Phlebotomus papatasi
									"ppapatasi"=>"P. papatasi",

									// Other Organisms
									//"other"=>"Other"
								);
								
		public static $FN = array(							
									// All organisms
									"all"=>"All organisms",
									
									// Anopheles gambiae
									"agambiae"=>"Anopheles gambiae",
									
									// Aedes aegypti
									"aaegypti"=>"Aedes aegypti",
									
									// Ixodes scapularis
									"iscapularis"=>"Ixodes scapularis",
									
									// Culex pipiens quinquefasciatus
									//"cpipiens"=>"Culex pipiens",
									"cquinquefasciatus"=>"Culex quinquefasciatus",
									
									// Glossina morsitans morsitans
									"gmorsitans"=>"Glossina morsitans morsitans",
									
									// Rhodnius prolixus
									"rprolixus"=>"Rhodnius prolixus",
									
									// Lutzomyia longipalpis
									"llongipalpis"=>"Lutzomyia longipalpis",
									
									// Pediculus humanus
									"phumanus"=>"Pediculus humanus",
									
									// Phlebotomus papatasi
									"ppapatasi"=>"Phlebotomus papatasi"
//'aalbopictus'=>'Aedes albopictus',
//'adarlingi'=>'Anopheles darlingi',
//'afunestus'=>'Anopheles funestus',
//'astephensi'=>'Anopheles stephensi'

								);
		
		// Full name to short name reverse lookup
		public static $LTS = array(
									
									// All organisms
									"All Organisms"=>"all",
									"All"=>"all",
									
									// Anopheles gambiae
									"Anopheles gambiae"=>"agambiae",
									"A. gambiae"=>"agambiae",
									
									// Aedes aegypti
									"Aedes aegypti"=>"aaegypti",
									"A. aegypti"=>"aaegypti",
									
									// Ixodes scapularis
									"Ixodes scapularis"=>"iscapularis",
									"I. scapularis"=>"iscapularis",
									
									
									// Culex pipiens quinquefasciatus
									//"Culex pipiens"=>"cpipiens",
									//"C. pipiens"=>"cpipiens",
									"Culex quinquefasciatus"=>"cquinquefasciatus",
									"C. quinquefasciatus"=>"cquinquefasciatus",
									
									// Glossina morsitans morsitans
									"Glossina morsitans morsitans"=>"gmorsitans",
									"G. morsitans morsitans"=>"gmorsitans",
									
									// Rhodnius prolixus
									"Rhodnius prolixus"=>"rprolixus",
									"R. prolixus"=>"rprolixus",
									
									// Lutzomyia longipalpis
									"Lutzomyia longipalpis"=>"llongipalpis",
									"L. longipalpis"=>"llongipalpis",
									
									// Pediculus humanus
									"Pediculus humanus"=>"phumanus",
									"P. humanus"=>"phumanus",
									
									// Phlebotomus papatasi
									"Phlebotomus papatasi"=>"ppapatasi",
									"P. papatasi"=>"ppapatasi"
								);
        
		
		public static $CUR = array( "agambiae"=>"agambiae_curator@vectorbase.org",
		                            "aaegypti"=>"aaegypti_curator@vectorbase.org"
		                            );
								
		//Ensembl
		public static $EN = array(
									"agambiae"=>"Anopheles_gambiae",
									"aaegypti"=>"Aedes_aegypti",
									//"cpipiens"=>"Culex_pipiens",
									"cquinquefasciatus"=>"Culex_quinquefasciatus",
                  							"iscapularis"=>"Ixodes_scapularis",
									"rprolixus"=>"Rhodnius_prolixus",
								  );
									

		//public static $ENDOWED = array("all","agambiae","aaegypti","iscapularis","cpipiens","phumanus", "other");
		public static $ENDOWED = array("all","agambiae","aaegypti","iscapularis","cquinquefasciatus","phumanus","rprolixus", "gmorsitans");
		public static $NOT_ENDOWED = array("llongipalpis","ppapatasi");
		//public static $GENOME_COMPLETE = array("agambiae","aaegypti","phumanus","cpipiens");
		public static $GENOME_COMPLETE = array("agambiae","aaegypti","phumanus","cquinquefasciatus");
		
	}
	
	class DV {
	
		// Organism Color Schema
		public static $OCS = array(
									
									// All organisms
									"all"=>array("003300","005500","309930","A7D48C","99DD99","BBEEBB","EFFEEF"),

									// A. gambiae
									"agambiae"=>array("002A40","004466","408090","669999","AADDDD","BBEEEE","F0ffff"),
									
									// A. aegypti
									"aaegypti"=>array("000033","000066","404090","3F3ABC","CCCCDD","CCCCEE","F0F0F8"),
									
									// I. scapularis
									"iscapularis"=>array("3B1356","612C86","8552A9","AC82C9","C1A8D2","E2D5EB","F5F0F9"),
									
									// C. pipiens
									//"cpipiens"=>array("3A0000","880000","BB0000","FF3B3B","DDCCCC","FFCACA","FFECEC"),
									"cquinquefasciatus"=>array("3A0000","880000","BB0000","FF3B3B","DDCCCC","FFCACA","FFECEC"),

									// G. morsitans
									"gmorsitans"=>array("3f0600","5d271f","7a4338","98685e","c8a399","d0b0a4","dfc5b5"),
									
									// R. prolixus
									//"rprolixus"=>array("222222","444444","606060","CCCCCC","DDDDDD","EEEEEE","FFFFFF"),
									"rprolixus"=>array("a21233","c02752","e05780","f286a5","f6a6bc","f9c5d1","fcdce1"),
									
									// L. longipalpis
									"llongipalpis"=>array("222222","444444","606060","CCCCCC","DDDDDD","EEEEEE","FFFFFF"),
									
									// P. humanus
									"phumanus"=>array("502800","C26100","A05000","CCCC99","E5E5B7","EEEECC","FDFDED"),

									// P. papatasi
									"ppapatasi"=>array("222222","444444","606060","CCCCCC","DDDDDD","EEEEEE","FFFFFF"),

									// Other
									//"other"=>array("222222","444444","606060","CCCCCC","DDDDDD","EEEEEE","FFFFFF")
								);

		// BLAST Organism Color Schema
		public static $BLASTOCS = array(
									
									// All organisms
									"all"=>array("003300","005500","309930","8fc982","99DD99","BBEEBB","EFFEEF"),

									// A. gambiae
									"agambiae"=>array("002A40","004466","408090","669999","99dddc","BBEEEE","F0ffff"),
									
									// A. aegypti
									"aaegypti"=>array("000033","000066","404090","8287c9","999bdd","CCCCEE","F0F0F8"),
									
									// I. scapularis
									"iscapularis"=>array("3B1356","612C86","8552A9","AC82C9","C1A8D2","E2D5EB","F5F0F9"),
									
									// C. pipiens
									//"cpipiens"=>array("3A0000","880000","BB0000","c98282","d2a8a8","FFCACA","FFECEC"),
									"cquinquefasciatus"=>array("3A0000","880000","BB0000","c98282","d2a8a8","FFCACA","FFECEC"),

									// G. morsitans
									"gmorsitans"=>array("3f0600","5d271f","7a4338","98685e","c8a399","d0b0a4","dfc5b5"),
									
									// R. prolixus
									"rprolixus"=>array("33000c","5c0015","aa052b","e01947","ff4c75","fd87a2","ffc6d3"),

									// L. longipalpis
									"llongipalpis"=>array("222222","444444","606060","CCCCCC","DDDDDD","EEEEEE","FFFFFF"),
									
									// P. humanus
									"phumanus"=>array("502800","884a00","bb7700","c9aa82","E5E5B7","EEEECC","FDFDED"),

									// P. papatasi
									"ppapatasi"=>array("222222","444444","606060","CCCCCC","DDDDDD","EEEEEE","FFFFFF")
								);

		
	}
?>

<?php
/**
 * This is the constnts file for the Data file (downloadable_file) module.
 *
 * @package DataFiles
 * @filesource
 */


/**
 * Threshold value for minimum number of times a file is downloaded before it
 * becomes 'more important'.
 */
define('RELATED_FILES_DOWNLOADED_COUNT_THRESHOLD', 15);

/**
 * How many files are to be dispalyed in the 'Related files' block on organism
 * pages.
 */
define('RELATED_FILES_VIEW_LIMIT', 5);

/**
 * Display string of the 'Featured Download' tag (actually a taxon in the 
 * tags taxonomy). This is used to retrieve the taxon object itself from drupal
 * to get the taxon id, which is used in other queries.
 */
define('FEATURED_DOWNLOAD_TAG_TEXT', 'Featured Download');

/**
 * Public user in the drupal database that is allowed to issue SELECT queries.
 */
define('DB_USER', 'db_public');

/**
 * Password for the DB_USER.
 */
define('DB_PASSWORD', 'limecat');

/**
 * Node id key name for the file increment php counter.
 */
define('DOWNLOAD_COUNT_NODE_ID_GET_KEY', 'nid');

/**
 * Version id key name for the file increment php counter.
 */
define('DOWNLOAD_COUNT_VERSION_ID_GET_KEY', 'vid');

/**
 * CSS class used by jquery to locate file downloads and 
 * increment the download count.
 */
define('DATA_FILE_DOWNLOAD_LINK_CSS_CLASS', 'data-file-download-link');

/** 
 *
 * Last part of the url for the given node if you are viewing that node.
  * this is used because it is a unique value AND is user friendly...kind of.
  * This is the key used to find the node to increment its download count.
  */
  define('DATA_FILE_NODE_VIEW_BASENAME', 'file');


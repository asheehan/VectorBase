<?php
// $Id: 

/**
 * @file
 * This is a helper class, the actual controller. It is the actual controller
 * of the application being the connection between the drupal API and the
 * storage engine.
 *
 * It's doing the most basic stuff that are the same overall the storage engines
 *
 * @author Raphael Sch�r - www.schaerwebdesign.ch
 */

include_once('FGImage.class.php');
include_once('fast_gallery_constants.php');

/**
 * The Fast Gallery Controller class
 */
class FastGallery {
  private static $instance = null;

  /**
   * We are implementing a singleton pattern
   */
  private function __construct() {
  }

  /**
   *
   * @return FastGallery
   */
  public function getInstance() {
    if (is_null(self :: $instance)) {
      self :: $instance = new self;
    }
    return self :: $instance;
  }

  /**
   * Get a random image from any gallery
   * @return FGImage
   */
  public function getRandomImage() {
    $storage = $this->getStorageEngine();
    return $storage->getRandomImage();
  }

  /**
   * Checks for gallery additions/deletions only. Leaves existing files alone.
   */
  public function rescanGallery() {
    $arGalleries = variable_get('fg_galleries', array());
    $storage = $this->getStorageEngine();

    foreach ($arGalleries as $gallery) {
      $path = utf8_decode($gallery['fg_path']);
      if (!is_dir($path)) {
        watchdog('fast_gallery', 'No gallery path specified! Do it at !link', array('!link' => l('admin/config/fast_gallery', 'admin/config/fast_gallery')));
      }
      // Get current file list hierarchy
      $files = $this->exploreDir($path, TRUE);
      //dsm($files);

      // Process the files
      $FgImgContainer = array();
      $this->processFiles($files, $FgImgContainer);


      $storage->storeImages($FgImgContainer);
    }
    $storage->removeDeletedFiles();
  }

  /**
   * Return the storage engine. We first find out which storage engine is
   * used, then we load specified file and then we call the function that
   * needs to be in the storage engine file "fast_gallery_get_storage,
   * which then returns the correct storage engine
   * @return Istorage
   */
  public function getStorageEngine() {
    $storage_engine_info = variable_get('fg_storage_engine', array());

    //we fetch the file with the storage engine
    include_once($storage_engine_info['path'] . '/' . $storage_engine_info['file']);
    return fast_gallery_get_storage();//and call the function to return it.

  }

  /**
   * Process the images (which are right now only a path) and
   * make nice FGImages out of them so that they can be
   * passed to the storage engine
   *
   * @param ar_files
   *   Array of files, as returned by exploreDir()
   * @param fGImagesContainer
   *   Array that collects the created FGImages objects
   */
  private function processFiles($ar_files, &$fGImagesContainer) {
    foreach ($ar_files as $key => $value) {
      // If we found a folder, recurse through it
      if (is_array($value)) {
        $this->processFiles($value, $fGImagesContainer);
      }
      else {
    // Handle files with special characters.
        $value_slash = str_replace('\\', '/', utf8_encode($value));
        $fGImagesContainer[] = new FGImage($value_slash);
    }

      //we don't care about empty arrays
      if (is_array($value) && count($value) < 1) {
        continue;
  }
    }
    //return $fgImagesContainer;
  }

  /**
   * clearing the db -> removing all entries from the db
   *
   */
  public function clearDb() {
    $storage = $this->getStorageEngine();
    $storage->clearDb();
    db_truncate('cache_fast_gallery')->execute();
  }


  /**
   * Get all images in given directory.
   *
   * @param path
   *   Absolute path of the directory
   * @param recursive
   *   Specify whether to recurse through subdirectories.
   * @return
   *   Array of arrays of image files. Each array element corresponds to
   *   an image type. If recursive is on, returns an array tree hierarchy.
   */
  private function exploreDir($path = '', $recursive = FALSE) {
    $fg_galleries = variable_get('fg_storage_engine', array());

    // get all the files that are supported by the gallery
    // or take some default values
    $exts = $fg_galleries['supported_files'];

    if (count($exts) < 1) {
      $exts = array (
          'jpg',
          'jpeg',
          'gif',
          'bmp',
    /*'flv',
          'png',
     'mov',
     'wmv',
     'asx',
     'swf',
     'pdf',*/
      );
    }
    // Get all image files of each file type
    $files = array ();
    foreach ($exts as $ext) {

      $pattern = make_regcase($path . '*.' . $ext);
      $f = glob($pattern);
      if (count($f) > 0 && $f != '') {
        $files[] = $f;
      }
    }

    // Recurse through subdirectories if necessary
    if ($recursive) {
      $dirs = glob($path . '*', GLOB_MARK | GLOB_ONLYDIR);
      if (is_array($dirs)) {
        foreach ($dirs as $dir) {
          if ($dir != '') {
            $files[] = $dir;
          }
          $files[] = $this->exploreDir($dir, TRUE);
        }
      }
    }
    return $files;
  }

  /**
   * Building the array for the breadcrumbs
   * @return array
   *  and array containing breadcrumb items
   */
  public function buildBreadCrumbs() {
    $bc = array();
    $path = '';
    $displayArgs = arg();
    $linkArgs = arg();
    $cache = cache_get(FG_CACHED_GALLERY_TITLE_KEY);

    // If the cache value exists, its data value is not whitespace AND not an empty string, then use that value.
    if(!empty($cache) && !ctype_space($cache->data) && $cache->data != '') {
	$displayArgs[0] = $cache->data;
	//dpm($cache->data, 'Retrieved the gallery breadcrumb title from cache.');
    } else {

	$q = db_select('{menu_router}', 'mr');
	$q->addField('mr', 'title');
	$q->condition('mr.path', $displayArgs[0], '=');
	$q->distinct();

	$results = $q->execute()->fetchAssoc();
	if($results !== FALSE) {
		$displayArgs[0] = $results['title'];
		cache_set(FG_CACHED_GALLERY_TITLE_KEY, $results['title'], 'cache', CACHE_TEMPORARY);
		//dpm($results['title'], 'Saved the gallery breadcrumb title to cache.');
	} else {
		dpm('base url value (alias) will be used as first breadcrumb', 'Failed to cache Image Gallery\'s name', 'warning');
	}
    }

    array_unshift($displayArgs, 'Home');
    array_unshift($linkArgs, '');

    for ($i = 0; $i < sizeof($displayArgs); $i++) {
      $path .= $linkArgs[$i];
      if(!empty($linkArgs[$i])) {
	$path .= '/';
      }
      $bc[] = l($displayArgs[$i], $path);
    }
    return $bc;
  }

}


function make_regcase($mixedCaseString) {
  $insensitivePattern = '';
  for ($i=0;$i<mb_strlen($mixedCaseString);$i++) {
    $char = mb_substr($mixedCaseString, $i, 1);
    if (ctype_alpha($char)) {
      $insensitivePattern .= '[';
      $insensitivePattern .= strtoupper($char);
      $insensitivePattern .= strtolower($char);
      $insensitivePattern .= ']';
    } else {
      $insensitivePattern .= $char;
    }
  }
  return $insensitivePattern;
}

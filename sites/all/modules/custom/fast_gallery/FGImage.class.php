<?php
// $Id:

/**
 *
 * @author rschaer
 *
 */


class FGImage {
  //$fid
  private $path, $name, $folder, $parent, $fid, $isDir, $filetype, $created;

  /**
   * Constructor
   * @param $path
   *  The path to the image
   * @param $options
   *  an assoziative array containing some options. The following options are possible:
   *    - dir: can be true or false. If set to true the image behaves as a dir! Default is set to false
   */
  public function __construct($path, $options = array()) {
    $this->setPath($path);
    // Split up the Image Path, so we can work on it
    $arPath = explode('/', $path);
    if ($arPath[count($arPath)-1] == '') {
      unset($arPath[count($arPath)-1]);
      $options['dir'] = TRUE;
    }

    $this->setName($arPath);
    $this->setTitle($arPath);
    $this->setDesc($arPath);
    $this->setCredit($arPath);
    $this->setSource($arPath);

    if (isset($options['dir'])) {
      $this->setIsDir($options['dir']);
    }
    else {
      $this->setIsDir(FALSE);
      $this->setFileType($arPath[count($arPath) - 1]);
    }

    $this->setFolder($arPath);
    $this->setParent($arPath);
    $this->setCreationTimestamp();
  }

  /**
   * Render the html for displaying the image
   * @return string html
   */
  public function renderHtml() {
    $cache = fast_gallery_get_cache();
    $path = $this->getPath();
    if ($this->isDir) { //incase a dir we return a special image
      $folderIconPath = $path . '/folder.png';
      if ((is_file($folderIconPath)) && (exif_imagetype($folderIconPath))) {
        $path = $folderIconPath;
      } else {
        $path = drupal_get_path('module', 'fast_gallery') . '/images/folder.png';
      }
      return theme('image', array('path' => $path, 'title' => t($this->getName() . ' Images')));
    }
    else if($this->getFileType() == 'pdf') {
      $path = drupal_get_path('module', 'fast_gallery') . '/images/doc.screenshot.jpg';
      $cache->createthumb($path, 150, 100);
      return theme('image', array('path' => $path . '.thumb', 'title' => t('PDF')));
    }
    else {
      $cache->createthumb($path, 150, 100);
      return theme('image', array('path' => $path . '.thumb'));
    }
  }

  public function createArrayVersion() {
    $image = array(
      'path' => $this->getPath(),
      'name' => $this->getName(),
      'title' => $this->getTitle(),
      'desc' => $this->getDesc(),
      'credit' => $this->getCredit(),
      'source' => $this->getSource(),
      'folder' => $this->getFolder(),
      'filetyp' => $this->getFileType(),
      'created' => $this->getCreationTimestamp(),
    );
    return $image;
  }
  /**
   * Given a path and index n, removes n number of elements from the end of
   * the path (delimited by '/').
   *
   * @param path_ar
   *   Path.
   * @param n
   *   Number of elements to remove from end of the path.
   */
  private function substractFromPath($path_ar, $n) {
    $path_ar = array_slice($path_ar, 0, - $n);
    return implode('/', $path_ar);
  }
  /**
   * Given a path return the IPTC tag named in tag
   *
   * @param path_ar
   *   Path.
   * @param tag
   *   Name of the IPTC tag to read
   */
  private function readIptcTag($path, $tag) {
    $theTag = $this->getHumanreadableIPTCkey($tag);
    if ((is_file($path)) && (exif_imagetype($path))) {
      GetImageSize($path, $infoImage);
      if (isset($infoImage) && is_array($infoImage) && array_key_exists('APP13',$infoImage)) {
        $app13 = iptcparse($infoImage['APP13']);
        if (isset($app13) && is_array($app13) && array_key_exists($theTag,$app13)) {
          return $app13[$theTag][0];
        } else {
          return '';
        }
      } else {
        return '';
      }
    } else {
      return '';
    }
  }

  // All the accessor mehtods
  // -------------------------

  public function setCreationTimestamp($timestamp = 0) {
    if ($timestamp == 0) {
      if (!file_exists($this->getPath())) {
        drupal_set_message(t('The file %file doesn\'t exist. Line %line in %file',
        array('%line' => __LINE__, '%file' => __FILE__, '%file' => $this->getPath())), 'error');
        return false;
      }
      $this->created = filectime($this->getPath());
    }
    else {
      $this->created = $timestamp;
    }
  }

  public function getCreationTimestamp() {
    return $this->created;
  }

  public function setIsDir($isDir) {
    if ($isDir) {
      $this->isDir = TRUE;
    }
    else {
      $this->isDir = FALSE;
    }
  }

  public function isDir() {
    return $this->isDir;
  }

  public function getFid() {
    return $this->fid;
  }

  public function setFid($fid) {
    $this->fid = $fid;
  }

  public function getFolder() {
    return $this->folder;
  }

  public function setFolder($arPath) {
    if (!$this->isDir()) {
      $this->folder = $this->substractFromPath($arPath, 1);
    }
    else {
      $this->folder = implode("/", $arPath);
    }
  }

  public function getParent() {
    return $this->parent;
  }

  public function setParent($arPath) {
    if ($this->isDir()) {
      $this->parent = $this->substractFromPath($arPath, 1);
    }
    else {
      $this->parent = $this->substractFromPath($arPath, 2);
    }
  }
  /**
   * Getter method
   * @return string $path
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * Setter method
   * @param $path string
   */
  public function setPath($path) {
    $this->path = $path;
  }

  /**
   * Getter method
   * @return string $name
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Getter method
   * @return string $title
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Getter method
   * @return string $desc
   */
  public function getDesc() {
    return $this->desc;
  }

  /**
   * Getter method
   * @return string $credit
   */
  public function getCredit() {
    return $this->credit;
  }

  /**
   * Getter method
   * @return string $source
   */
  public function getSource() {
    return $this->source;
  }

  /**
   * Setter method
   * @param $name string
   */
  public function setName($arPath) {
    if (!$this->isDir()) {
      $this->name = $arPath[count($arPath)-1];
    }
  }

  /**
   * Setter method
   * @param $title string
   */
  public function setTitle($arPath) {
    if (!$this->isDir()) {
        $theTitle = $this->readIptcTag($this->GetPath(),'by_line');
        if ($theTitle != '') {
            $this->title = $theTitle;
        } else {
            $this->title = $this->name;
        }
    }
  }

  /**
   * Setter method
   * @param $desc string
   */
  public function setDesc($arPath) {
    if (!$this->isDir()) {
        $this->desc = $this->readIptcTag($this->GetPath(),'caption');
    }
  }

  /**
   * Setter method
   * @param $credit string
   */
  public function setCredit($arPath) {
    if (!$this->isDir()) {
        $this->credit = $this->readIptcTag($this->GetPath(),'credit');
    }
  }

  /**
   * Setter method
   * @param $source string
   */
  public function setSource($arPath) {
    if (!$this->isDir()) {
        $this->source = $this->readIptcTag($this->GetPath(),'source');
    }
  }

  /**
   * setter method
   * @param $path - the path of the file
   */
  public function setFileType($path) {
    $ending = explode(".", $path);
    $ending = $ending[count($ending) - 1];
    $this->filetype = $ending;
  }

  /**
   * getter method
   * @return string
   */
  public function getFileType() {
    return $this->filetype;
  }

  /**
   * Just some little helper function to get the iptc fields
   * @return value
   *
   * Needs to have the array flipped for this version
   *
   */
  private function getHumanReadableIPTCkey($key) {
    $iptcKeys =  array(
      "2#202" => "object_data_preview_data",
      "2#201" => "object_data_preview_file_format_version",
      "2#200" => "object_data_preview_file_format",
      "2#154" => "audio_outcue",
      "2#153" => "audio_duration",
      "2#152" => "audio_sampling_resolution",
      "2#151" => "audio_sampling_rate",
      "2#150" => "audio_type",
      "2#135" => "language_identifier",
      "2#131" => "image_orientation",
      "2#130" => "image_type",
      "2#125" => "rasterized_caption",    
      "2#122" => "writer",
      "2#120" => "caption",
      "2#118" => "contact",
      "2#116" => "copyright_notice",
      "2#115" => "source",
      "2#110" => "credit",
      "2#105" => "headline",
      "2#103" => "original_transmission_reference",
      "2#101" => "country_name",
      "2#100" => "country_code",
      "2#095" => "state",
      "2#092" => "sublocation",
      "2#090" => "city",
      "2#085" => "by_line_title",
      "2#080" => "by_line",
      "2#075" => "object_cycle",
      "2#070" => "program_version",
      "2#065" => "originating_program",
      "2#063" => "digital_creation_time",
      "2#062" => "digital_creation_date",   
      "2#060" => "creation_time",
      "2#055" => "creation_date",
      "2#050" => "reference_number",
      "2#047" => "reference_date",
      "2#045" => "reference_service",
      "2#042" => "action_advised",
      "2#040" => "special_instruction",
      "2#038" => "expiration_time",
      "2#037" => "expiration_date",
      "2#035" => "release_time",
      "2#030" => "release_date",
      "2#027" => "content_location_name",
      "2#026" => "content_location_code",
      "2#025" => "keywords",
      "2#022" => "fixture_identifier",
      "2#020" => "supplemental_category", 
      "2#015" => "category",
      "2#010" => "subject_reference", 
      "2#010" => "urgency",
      "2#008" => "editorial_update",
      "2#007" => "edit_status",
      "2#005" => "object_name",
      "2#004" => "object_attribute_reference",
      "2#003" => "object_type_reference",
      "2#000" => "record_version"
      );
    $iptcKeys = array_flip($iptcKeys);
    return $iptcKeys[$key];
  }

}

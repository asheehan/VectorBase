<?
class blastResult{
	function __construct($dbName, $queryName, $numberOfHits, $bestEvalue, $resultNumber) {
		$this->dbName=$dbName;
		$this->queryName=$queryName;
		$this->numberOfHits=$numberOfHits;
		$this->bestEvalue=$bestEvalue;
		$this->resultNumber=$resultNumber;
	}
	public function getDbName() { return $this->dbName; }
	public function getQueryName() { return $this->queryName; }
	public function getNumberOfHits() { return $this->numberOfHits; }
	public function getBestEvalue() { return $this->bestEvalue; }
	public function getResultNumber() { return $this->resultNumber; }
}


/* Blast Hits objects: VectorbaseBlastResult, VectorbaseBlastHit, VectorbaseBlastHsp */
class VectorbaseBlast {
  protected $results;

  public function getResults() { return $this->results; }
  public function addResult( $result ) { array_push($this->results, $result); }
  function __construct($results = array()){
    $this->results = $results;
  }
}
class VectorbaseBlastResult {
  protected $hits;
  protected $db;
  protected $queryString;

  public function getDb() { return $this->db; }
  public function getQueryString() { return $this->queryString; }

  public function setDb( $db ) { $this->db = $db; }
  public function setQueryString( $queryString ) { $this->queryString = $queryString; }

  public function clearEmptyHits(){
    for($i = 0; $i < count($this->hits); $i++){
      if(count($this->hits[$i]->getHsps()) == 0){
        array_splice($this->hits, $i, 1);
        $i--;
      }
    }
  }

  public function getNumHsps() { 
    $count = 0;
    foreach($this->hits as $hit){
      foreach($hit->getHsps() as $hsp){
        $count++;
      }
    }
    return $count; 
  }
  public function getNumHits(){
    return count($this->hits);
  }

  public function getLowestEvalue(){
	$evalues=$this->getSortedHsps('evalue','desc');
	return $evalues[0];
   }

  public function getHits() { return $this->hits; }
  public function addHit( $hit ) { array_push($this->hits, $hit); }

  public function getAllHsps() { 
    $hsps = array();
    foreach($this->hits as $hit){
      foreach($hit->getHsps() as $hsp){
        array_push($hsps, $hsp);
      }
    }
    return $hsps;
  }
  public function getSortedHsps($order, $by) { 
    $hsps = $this->getAllHsps();
    $vals = array();
    $sorted = array();
    $current = 0;
    foreach($hsps as $hsp){
      switch($order){
        case "querystart":
          if(!in_array($hsp->getQueryStart(), $vals)){
            array_push($vals, $hsp->getQueryStart());
          }
          break;
        case "queryend":
          if(!in_array($hsp->getQueryEnd(), $vals)){
            array_push($vals, $hsp->getQueryEnd());
          }
          break;
        case "length":
          if(!in_array($hsp->getLength(), $vals)){
            array_push($vals, $hsp->getLength());
          }
          break;
        case "evalue":
          if(!in_array($hsp->getEvalue(), $vals)){
            array_push($vals, $hsp->getEvalue());
          }
          break;
        case "score":
          if(!in_array($hsp->getScore(), $vals)){
            array_push($vals, $hsp->getScore());
          }
          break;
        case "identity":
          if(!in_array($hsp->getIdentity(), $vals)){
            array_push($vals, $hsp->getIdentity());
          }
          break;
        case "start":
          if(!in_array($hsp->getHitStart(), $vals)){
            array_push($vals, $hsp->getHitStart());
          }
          break;
        case "end":
          if(!in_array($hsp->getHitEnd(), $vals)){
            array_push($vals, $hsp->getHitEnd());
          }
          break;
      }
    }
    if($by == "desc"){
      rsort($vals, SORT_NUMERIC);
    } else {
      sort($vals, SORT_NUMERIC);
    }
    foreach($vals as $e){
      foreach($hsps as $hsp){
        switch($order){
          case "queryend":
            if($hsp->getQueryEnd() == $e){
              array_push($sorted, $hsp);
            }
            break;
          case "querystart":
            if($hsp->getQueryStart() == $e){
              array_push($sorted, $hsp);
            }
            break;
          case "length":
            if($hsp->getLength() == $e){
              array_push($sorted, $hsp);
            }
            break;
          case "evalue":
            if($hsp->getEvalue() == $e){
              array_push($sorted, $hsp);
            }
            break;
          case "score":
            if($hsp->getScore() == $e){
              array_push($sorted, $hsp);
            }
            break;
          case "identity":
            if($hsp->getIdentity() == $e){
              array_push($sorted, $hsp);
            }
            break;
          case "start":
            if($hsp->getHitStart() == $e){
              array_push($sorted, $hsp);
            }
            break;
          case "end":
            if($hsp->getHitEnd() == $e){
              array_push($sorted, $hsp);
            }
            break;
        }
      }
    }

    return $sorted; 
  }
  public function generateHspId() {
    $hsps = $this->getAllHsps();
    $id = 0;
    $highest = 0;
    foreach($hsps as $hsp){
      if($hsp->getId() > $highest){
        $highest = $hsp->getId();
      }
    }
    return ($highest+1);
  }
  public function generateHitid() {
    $id = 0;
    $highest = 0;
    foreach($this->hits as $hit){
      if($hit->getId() > $highest){
        $highest = $hit->getId();
      }
    }
    return ($highest+1);
  }
  public function getHitByHspId( $id ){
    foreach($this->hits as $hit){
      foreach($hit->getHsps() as $hsp){
        if($hsp->getId() == $id){
          return $hit;
        }
      }
    }
    return null;
  }
  public function getHspById( $id ){
    $hsps = $this->getAllHsps();
    foreach($hsps as $hsp){
      if($hsp->getId() == $id){
        return $hsp;
      }
    }
    return null;
  }
  function __construct($hits = array()){
    $this->hits = $hits;
  }
}
class VectorbaseBlastHit {
  protected $hsps;
  protected $name;
  protected $id;
  protected $parent;

  public function getName() { return $this->name; }
  public function getId() { return $this->id; }
  public function setName( $name ) { $this->name = $name; }
  public function setId( $id ){ $this->id = $id; }
  public function setParent( $parent ){$this->parent = $parent; }
  public function getParent() {return $this->parent; }

  public function getHsps() { return $this->hsps; }
  public function getSortedHsps($order, $by) { return null; }
  public function addHsp( $hsp ) { array_push($this->hsps, $hsp); }
  function __construct($hsps = array()){
    $this->hsps = $hsps;
  }
}
class VectorbaseBlastHsp {
  protected $evalue;
  protected $length;
  protected $score;
  protected $identity;
  protected $hitStart;
  protected $hitEnd;
  protected $queryStart;
  protected $queryEnd;
  protected $homologyString;
  protected $hitString;
  protected $queryString;
  protected $queryStrand;
  protected $hitStrand;
  protected $queryFrame;
  protected $hitFrame;
  protected $id;
  protected $displayed;
  protected $parent;

  public function getEvalue() { return $this->evalue; }
  public function getLength() { return $this->length; }
  public function getScore() { return $this->score; }
  public function getIdentity() { return $this->identity; }
  public function getHitStart() { return $this->hitStart; }
  public function getHitEnd() { return $this->hitEnd; }
  public function getQueryStart() { return $this->queryStart; }
  public function getQueryEnd() { return $this->queryEnd; }
  public function getHomologyString() { return $this->homologyString; }
  public function getHitString() { return $this->hitString; } 
  public function getQueryString() { return $this->queryString; } 
  public function getQueryStrand() { return $this->queryStrand; }
  public function getHitStrand() { return $this->hitStrand; }
  public function getQueryFrame() { return $this->queryFrame; }
  public function getHitFrame() { return $this->hitFrame; }
  public function getId() { return $this->id; }
  public function getDisplayed() { return $this->displayed; }
  public function getParent() { return $this->parent; }

  public function setEvalue( $evalue ) { $this->evalue = $evalue; }
  public function setLength( $length ) { $this->length = $length; }
  public function setScore( $score ) { $this->score = $score; }
  public function setIdentity( $identity ) { $this->identity = $identity; }
  public function setHitStart( $hitStart ) { $this->hitStart = $hitStart; }
  public function setHitEnd( $hitEnd ) { $this->hitEnd = $hitEnd; }
  public function setQueryStart( $queryStart ) { $this->queryStart = $queryStart; }
  public function setQueryEnd( $queryEnd ) { $this->queryEnd = $queryEnd; }
  public function setHomologyString ( $homologyString ) { $this->homologyString = $homologyString; }
  public function setHitString ( $hitString ) { $this->hitString = $hitString; }
  public function setQueryString ( $queryString) { $this->queryString = $queryString; }
  public function setQueryStrand ( $queryStrand ) { $this->queryStrand = $queryStrand; }
  public function setHitStrand ( $hitStrand ) { $this->hitStrand = $hitStrand; }
  public function setQueryFrame ( $queryFrame ) { $this->queryFrame = $queryFrame; }
  public function setHitFrame ( $hitFrame ) { $this->hitFrame = $hitFrame; }
  public function setId( $id ) { $this->id = $id; }
  public function setDisplayed( $displayed ) { $this->displayed = $displayed; } 
  public function setParent ( $parent ) { $this->parent = $parent; }

  function __construct() {
  }
}

<?php
/**
 * MaxHeap object tayolored to comparing (ranking) drupal data file nodes.
 * 
 * @package DataFiles
 * @filesource
 */


require_once('constants.php');


/**
 * This extension of the SplHeap overrides the compare function to
 * allow us to "rank" our "Data file/Download" nodes.  The ranking
 * is used to show the "top X" files to users.
 *
 * @package DataFiles
 */
class DownloadSimpleHeap extends SplHeap
{

	/**
	 * Comparison function used by the heap. Since this returns the "greater"
	 * of the two items, this makes the parent object a "max" heap.
	 *
	 * In english terms, this is how the comparison (ranking) is computed:
	 *	
	 * There are 3 variables in this ranking:
	 * 1. Number of times downloaded
	 * 2. Presence of a "Featured" tag
	 * 3. Download count threshold
	 *
	 * If a file has a higher download count than another then it will
	 * be ranked higher, unless:
	 ** The higher count is under the count threshold AND the lesser count
	 * file has a "featuerd" tag AND the higher one doesn't. In this case,
	 * the lesser count file gets ranked higher.
	 * 
	 * If the counts are equal and one has a "featured" tag while the other
	 * one does not, then the "featured" one ranks higher. 
	 *
	 * Finally, if the counts and tag existance (null vs !null)  are equal, 
	 * the two files are ranked equallly.
	 * 
	 * @param object $value1 The file node to be compared.
	 * @param object $value2 The file node to be the comparing reference.
	 * @return -1 if value1 is less than value2, 1 if value1 is greater than
	 * value2, or 0 if they are equal.
	 * 
	 */
	public function compare( $value1, $value2) {

		$c1 = $value1->field_download_count_value;
		$c2 = $value2->field_download_count_value;
		$t1 = $value1->field_tags_tid;
		$t2 = $value2->field_tags_tid;

		if($c1 > $c2) {

			if($c1 < RELATED_FILES_DOWNLOADED_COUNT_THRESHOLD && is_null($t1) && !is_null($t2)) {
				return -1;	
			} else {
				return 1;
			}
		} else if($c1 < $c2) {
			if($c2 < RELATED_FILES_DOWNLOADED_COUNT_THRESHOLD && is_null($t2) && !is_null($t1)) {
				return 1;
			} else {
				return -1;
			}
		} 

		// Could put an "else" here, but since we catch all possible outcomes from above, there's no need, we just fall through to here.	
		if(is_null($t1) && !is_null($t2)) {
			return -1;
		} else if(!is_null($t1) && is_null($t2)) {
			return 1;
		}
		return 0;	

	}

}



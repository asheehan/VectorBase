<?php

// these are used for viewing chromosome arm/supercontig segments in the genome browser
function blast_generateGFF($id){

    $searchId=blast_getRawJobId($id);
    $br_ids=array();


    // get the tid for "Reversed Headers"
    $rhTid=db_query("select tid from taxonomy_term_data where name='Reversed Headers'")->fetchField();


    // look up all blast_results that have this search id
    $results=db_query("select br_id, query_name, query_description, database_name from blast_results where search_id=$searchId");
    foreach($results as $result){
        $br_ids[]=$result->br_id;  
        $queryNames[]=trim($result->query_name.' '.$result->query_description);
        $databaseNames[]=$result->database_name;
    }
 
    // only run if there are results or else drupal will report notice errors
    if(count($br_ids)>0){
    // generate gff file for each blast_result
    $i=0;
	foreach($br_ids as $br_id){
        $bh_ids=array();
        $hitNames=array();
        
        $gff='track name="BLAST Hits" description="BLAST Hits" color=green useScore=0 url=http://www.vectorbase.org/Tools/BLAST/?result=html_results&br_id='.$br_id.'&page=res&job_id='.$id."\n";

        // look up all blast hits for this blast result
        $hits=db_query("select bh_id, name, description from blast_hits where br_id=$br_id");
        foreach($hits as $hit){
            $bh_ids[]=$hit->bh_id;
            $hitNames[]=$hit->name;
            //$hitDescriptions[]=$hit->description;
        }

        // get hsp info for these hits
        $j=0;
        if($bh_ids){ // check for results

            for($k=0; $k<count($hitNames); $k++){

                // change some of the hit names so the gffs show up in ensembl properly
                // these should all be tagged with "Reversed Headers"

                // get the nid(entity_id) for this db name
                $fid=db_query("select fid from file_managed where filename='".$databaseNames[$i].".gz';")->fetchField();
                $entity_id=db_query("select entity_id from field_data_field_file where field_file_fid=$fid;")->fetchField();

                // is this db tagged with reverse headers?
                $isTagged=db_query("select nid from taxonomy_index where tid=$rhTid and nid=$entity_id;")->fetchField();

                if($isTagged){
                    preg_match("#^.*?:.*?:(.*?):#",$hitNames[$k],$match);
                    $hitNames[$k]=$match[1];
                }

            }

            foreach($bh_ids as $bh_id){
                    $hsps=db_query("select starthit,endhit,score,strandhit from blast_hsps where bh_id=$bh_id");
                    foreach($hsps as $hsp){

                        if($hsp->strandhit=='1')
                          $strand="+";
                        else if($hsp->strandhit=='-1')
                          $strand="-";
                        else 
                          $strand=".";

                        $gff.=$hitNames[$j]."\tBLAST\tBlast Hit\t".$hsp->starthit."\t".$hsp->endhit."\t".$hsp->score."\t".$strand."\t.\t".$queryNames[$i]."\n";
                        //      hit name        BLAST   Blast Hit   start   end     length  strand  .   query name
                    }
                    $j++;
            }

            // save locally
            $location=$_SERVER['DOCUMENT_ROOT']."/data/";
            $fileName=$id."_".$br_id.".gff";
            file_put_contents($location.$fileName,$gff);
        } // end check for results
        $i++;
    }
    }
}

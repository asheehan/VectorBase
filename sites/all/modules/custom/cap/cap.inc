<?php

function get_cap_submission_stats($option) {

if($option=='half'){
    $userCounts = array ( 'user 1' => 50, 'user 2' => 50);
  } elseif($option=='three') {
    $userCounts = array ( 'user 1' => 25, 'user 2' => 25, 'user 3' => 50);
  } elseif($option=='db') {

  $db = pg_connect("host=bella.vectorbase.org dbname=manual_chado user=db_public password=limecat");

  if(!$db) {
    die("Error in connection: " . pg_last_error());
  }

pg_prepare($db, 'userQuery', 'select distinct(submitter.value) as submitter from featureprop submitter where submitter.type_id = 38657 order by submitter.value');
pg_prepare($db, 'submissionCountQuery', 'select count(distinct(gene.feature_id)) as count from feature gene, feature_relationship rel where gene.type_id = 767 and gene.feature_id = rel.object_id and rel.subject_id in (select f.feature_id from feature f, featureprop usr, featureprop status where f.type_id = 297 and f.feature_id = usr.feature_id and usr.type_id = 38657 and f.feature_id = status.feature_id and status.type_id = 38659 and status.value = \'approved\' and usr.value = $1)');
$users = array();
$result = pg_execute($db, "userQuery", array());
if($result) {
  
  while($row = pg_fetch_array($result)) {
    array_push($users, $row['submitter']);
  }

}

$userCounts = array();

unset($result);

foreach ($users as $username) {
  $result = pg_execute($db, 'submissionCountQuery', array($username));
  if($result) {

    while($row = pg_fetch_array($result)) {
      $userCounts[$username] = $row['count'];
    } 
  } else {
    $userCounts[$username] = 0; 
  }
}
  pg_close($db);
}
  return $userCounts;
}


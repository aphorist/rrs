<?php
require_once('config.php');
require_once('functions.php');

if ( isset($_POST['id']) ) { $id = $_POST['id']; } else { $id = NULL; }

$q = "SELECT * FROM `reserved_room` WHERE `id`=$id";
$db = dbConnect($ls);
$res = selectQuery($q,$db);
$numrows = $res->num_rows;
$row = $res->fetch_assoc();

//echo print_r($row,true);
foreach ($row as $k=>$v) {
   $$k = $v;
}

if ( $numrows > 0 ) {
   echo "true|$id|$subject|$userNumber|$room|$day|$month|$year|$startTime|$stopTime|$dateReserved|$needProjector|$needPointer|$needPhoto|$needMic|$needTechnicial|$other|$reserver";
} else {
   echo 'false|nodata';
}

/*
0 = true
1 = $id
2 = $subject
3 = $userNumber
4 = $room
5 = $day
6 = $month
7 = $year
8 = $startTime
9 = $stopTime
10 = $dateReserved
11 = $needProjector
12 = $needPointer
13 = $needPhoto
14 = $needMic
15 = $needTechnicial
16 = $other
17 = $reserver
*/
?>
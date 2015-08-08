<?php
require_once('config.php');
require_once('functions.php');

$room = $_POST['room'];
$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];
$startTime = $_POST['startTime'];
$stopTime = $_POST['stopTime'];
$id = $_POST['id'];

//echo "$room :: วันที่ $day/$month/$year เวลา $startTime น. - $stopTime น. ";

// แปลงเดือนให้เป็น ตัวเลข
$month = array_search($month,$thaiMonthName);
// แปลง พ.ศ. ให้เป็น คริส
$year = $year - 543;

//echo "true|$startTime - $stopTime";

if ( $id > 0 ) {
   $q = "SELECT `startTime`,`stopTime` FROM `reserved_room` WHERE `room`='$room' AND `day`='$day' AND `month`= '$month' AND `year`='$year' AND ( (`startTime` BETWEEN '$startTime' AND '$stopTime') OR (`stopTime` BETWEEN '$startTime' AND '$stopTime') ) AND `id`!=$id";
} else {
   $q = "SELECT `startTime`,`stopTime` FROM `reserved_room` WHERE `room`='$room' AND `day`='$day' AND `month`= '$month' AND `year`='$year' AND ( (`startTime` BETWEEN '$startTime' AND '$stopTime') OR (`stopTime` BETWEEN '$startTime' AND '$stopTime') )"; 
}

$db = dbConnect($ls);
$res = selectQuery($q,$db);
$numrows = $res->num_rows; 
if ( $numrows > 0 ) {
$row = $res->fetch_assoc();
   $ss = print_r($row,true);
   echo "false|$ss \r\n $q \r\n ตรวจเจอ เวลาที่คาบเกี่ยวกัน";
} else {
   echo "true| $ss \r\n  $q";
}

?>
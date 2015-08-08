
<?php
require_once('config.php');
require_once('functions.php');

if ( isset($_POST['room']) ) { $room = $_POST['room']; } else { $room = NULL; }
if ( isset($_POST['day']) ) { $day = $_POST['day']; } else { $day = NULL; }
if ( isset($_POST['month']) ) { $month = $_POST['month']; } else { $month = NULL; }
if ( isset($_POST['year']) ) { $year = $_POST['year']; } else { $year = NULL; }

// แปลงเดือนให้เป็น ตัวเลข
$month = array_search($month,$thaiMonthName);
// แปลง พ.ศ. ให้เป็น คริส
$year = $year - 543;

switch ($room) {
   case 'room1' :
      $roomName = "ห้องประชุม ชั้น 1";
   break;

   case 'room2' :
      $roomName = "ห้องประชุม ชั้น 2";
   break;

   case 'room3' :
      $roomName = "ห้องอบรม ชั้น 4";
   break;
}

$q = "SELECT `id`,`startTime`,`stopTime`,`reserver`, `subject` FROM `reserved_room` WHERE `day`='$day' AND `month`='$month' AND `year`='$year' AND `room`='$roomName' ORDER BY `startTime`";
$db = dbConnect($ls);
$res = selectQuery($q,$db);
$numrow = $res->num_rows; 
if ( $numrow > 0 ) {
   while ($row = $res->fetch_assoc()) {
      $time[$row['startTime']] = $row;
   }
} else {
   $time = NULL;
}

//echo print_r($time,true);

echo "
<table class='table time-bar'>
   <tr><td width='40%'></td><td></td></tr>
   <tr><th colspan='2'> $roomName </th></tr>";

// กำหนด CSS พื้นฐานไว้ก่อน
$css = 'success'; 

$timeStart = NULL;
$timeStop = NULL;
$dToggle = NULL;
$tToggle = NULL;
$tdcss = NULL;
for ($i=1;$i<=18;$i++) {
   if (isset ($time[$i]['startTime']) ) {
      $timeStart = $time[$i]['startTime'];
      $timeStop = $time[$i]['stopTime'];
      $rowspan = $timeStop - $timeStart;
      $reserver = $time[$i]['reserver'];
      $subject = $time[$i]['subject'];
      $id = $time[$i]['id'];
   } else {
      $reserver = NULL;  // กลับคืนค่าเดิม
   }

   if ( $i == $timeStart) { 
      $css = 'danger pointer'; 
      $dToggle = " data-dismiss='modal' data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#reservedDetail' data-id='$id' data-room='$roomName' data-day='$day' data-month='$month' data-year='$year' ";
      $rowspan = $timeStop-$timeStart+1;
      $rowspan = " rowspan='$rowspan'";
      echo "<tr$dToggle class='$css'><td>".$reserveTime[$i]."</td><td$rowspan style='vertical-align: middle;'><strong>$subject</strong><br> $reserver</td></tr>";
   } elseif ( ($i >= $timeStart) AND ($i <= $timeStop) ) {
      echo "<tr$dToggle class='$css'><td>".$reserveTime[$i]."</td>";
   } else {
      echo "<tr class='success'><td>".$reserveTime[$i]."</td><td></td></tr>";
   }
}

echo "</table>";
?>
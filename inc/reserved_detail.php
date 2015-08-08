<?php
require_once('config.php');
require_once('functions.php');

if ( isset($_POST['id']) ) { $id = $_POST['id']; } else { $id = NULL; }
if ( isset($_POST['cUserName']) ) { $cUserName = $_POST['cUserName']; } else { $cUserName = NULL; }

$q = "SELECT * FROM `reserved_room` WHERE `id`=$id";
$db = dbConnect($ls);
$res = selectQuery($q,$db);
$row = $res->fetch_assoc();

//echo print_r($row,true);
foreach ($row as $k=>$v) {
   $$k = $v;
}

$year = $year + 543;
$month = $thaiMonthName[$month];

$timeArr = explode('-',$reserveTime[$startTime] .  $reserveTime[$stopTime]);
$time = $timeArr[0] . 'น. - ' . $timeArr[2] . 'น.';

$dArr = explode('|',date('d|n|Y|H|i',$dateReserved));
$dArr[2] = $dArr[2]+543;

$dateReserved = $dArr[0].' '.$thaiMonthName[$dArr[1]].' '.$dArr[2].'  เวลา '.$dArr[3].':'.$dArr[4].'น.';

$required = '';
if ($needProjector <> '') { $required .= '<li>เครื่องฉายภาพโปรเจคเตอร์</li>'; }
if ($needPointer <> '') { $required .= '<li>อุปกรณ์ควบคุมการนำเสนอ (Pointer)</li>'; }
if ($needPhoto <> '') { $required .= '<li>เจ้าหน้าที่ถ่ายภาพ</li>'; }
if ($needMic <> '') { $required .= '<li>ต้องการใช้ไมค์ไร้สาย</li>'; }
if ($needTechnicial <> '') { $required .= '<li>นักวิชาการคอมพิวเตอร์</li>'; }
if ($required == '') { $required .= '<li>ไม่มีสิ่งที่ต้องการเพิ่มเติม</li>'; }
echo "
<table class='table'>
   <tr class='text-center bg-success'><td colspan='2'><strong>รายละเอียดการจองห้อง</strong></td></tr>
   <tr><td class='text-right' width='30%'><strong>เรื่อง :</strong></td><td class='text-left'>$subject</td></tr>
   <tr><td class='text-right'><strong>วันที่ :</strong></td><td class='text-left'>$day $month $year</td></tr>
   <tr><td class='text-right'><strong>สถานที่ :</strong></td><td class='text-left'>$room</td></tr>
   <tr><td class='text-right'><strong>จำนวนผู้เข้าร่วม :</strong></td><td class='text-left'>$userNumber คน</td></tr>
   <tr><td class='text-right'><strong>เวลา :</strong></td><td class='text-left'>$time</td></tr>
   <tr><td class='text-right'><strong>สิ่งที่ต้องการ :</strong></td><td class='text-left'>
      <ul>
$required
      </ul>
   </td></tr>
   <tr><td class='text-right'><strong>ผู้จอง :</strong></td><td class='text-left'>$reserver</td></tr>
   <tr><td class='text-right'><strong>จองเมื่อ :</strong></td><td class='text-left'>$dateReserved</td></tr>
      <tr><td class='text-right'><strong>อื่น ๆ เพิ่มเติม :</strong></td><td class='text-left'> $other </td></tr>

</table>
";
echo '|';
// ตรวจสอบว่า ผู้ใช้นี้สามารถแก้ไขข้อมูลได้หรือไม่ (ฟังก์ชัน canEdit() อยู่ที่ไฟล์ function.php ) ถ้าแก้ไขได้ให้ส่งข้อความ true ออกไป
if ( canEdit($id,$cUserName) ) { echo 'true'; } else { echo 'false'; }

?>
<?php
require_once('config.php');
require_once('functions.php');
if ( isset($_POST['action']) ) { $action = $_POST['action']; } else { $action = NULL; }
if ( isset($_POST['id']) ) { $id = $_POST['id']; } else { $id = NULL; }
if ( isset($_POST['day']) ) { $day = $_POST['day']; } else { $day = NULL; }
if ( isset($_POST['month']) ) { $month = $_POST['month']; } else { $month = NULL; }
if ( isset($_POST['year']) ) { $year = $_POST['year']; } else { $year = NULL; }
if ( isset($_POST['subject']) ) { $subject = $_POST['subject']; } else { $subject = NULL; }
if ( isset($_POST['inputNumber']) ) { $inputNumber = $_POST['inputNumber']; } else { $inputNumber = NULL; }
if ( isset($_POST['room']) ) { $room = $_POST['room']; } else { $room = NULL; }
if ( isset($_POST['startTime']) ) { $startTime = $_POST['startTime']; } else { $startTime = NULL; }
if ( isset($_POST['stopTime']) ) { $stopTime = $_POST['stopTime']; } else { $stopTime = NULL; }
if ( isset($_POST['needProjector']) ) { $needProjector = $_POST['needProjector']; } else { $needProjector = NULL; }
if ( isset($_POST['needPointer']) ) { $needPointer = $_POST['needPointer']; } else { $needPointer = NULL; }
if ( isset($_POST['needPhoto']) ) { $needPhoto = $_POST['needPhoto']; } else { $needPhoto = NULL; }
if ( isset($_POST['needMic']) ) { $needMic = $_POST['needMic']; } else { $needMic = NULL; }
if ( isset($_POST['needTechnicial']) ) { $needTechnicial = $_POST['needTechnicial']; } else { $needTechnicial = NULL; }
if ( isset($_POST['other']) ) { $other = $_POST['other']; } else { $other = NULL; }

// แปลงเดือนให้เป็น ตัวเลข
$month = array_search($month,$thaiMonthName);
// แปลง พ.ศ. ให้เป็น คริส
$year = $year - 543;

$dateReserved = time();
$reserver = $_SESSION['name'];

$query = "
INSERT INTO `reserved_room` 
   (`id`, `subject`, `userNumber`, `room`, `day`, `month`, `year`, `startTime`, `stopTime`, `dateReserved`, `needProjector`, `needPointer`, `needPhoto`, `needMic`, needTechnicial, `other`, `reserver`) 
      VALUES 
   (NULL, '$subject', '$inputNumber', '$room', '$day', '$month', '$year', '$startTime', '$stopTime', '$dateReserved', '$needProjector', '$needPointer', '$needPhoto', '$needMic', '$needTechnicial', '$other', '$reserver')
";

//เชื่อมต่อฐานข้อมูล
$db = dbConnect($ls);

if ( $action == 'edit' ) {
// ถ้าเป็นการ แก้ไข ให้ลบ ข้อมูลเดิมในฐานข้อมูลออกเลย แล้ว insert เข้าไปใหม่ จะง่ายกว่าการต้องมาทำการเปรียบเทียบและแก้ไขในฐานข้อมูล
   $q = "DELETE FROM `reserved_room` WHERE `id` = '$id'";
   $result = sqlQuery($q,$db);
}

$result = sqlQuery($query,$db);

if ( $result === false ) {
   echo "false|เกิดปัญหา ไม่สามารถบันทึกข้อมูลได้";
} else {
//   echo "true|บันทึกข้อมูลเรียบร้อย $query";
   echo "true|บันทึกข้อมูลเรียบร้อย";
}
?>
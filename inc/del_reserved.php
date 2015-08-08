<?php
require_once('config.php');
require_once('functions.php');

if ( isset($_POST['id']) ) { $id = $_POST['id']; } else { $id = NULL; }

$q = "DELETE FROM `reserved_room` WHERE `id` = $id";
$db = dbConnect($ls);
$affected = sqlQuery($q,$db);
if ( $affected < 1 ) {
   // ถ้าไม่มีแถวใดโดนลบเลย (ค่าที่ส่งมาเป็น false)
   echo "false|ไม่มีแถวที่โดนลบ";
} else {
   // ถ้าค่าที่ส่งมาก มากกว่า 0 แสดงว่า มีแถวที่โดนลบ
   echo "true|ลบสำเร็จ";
}
?>
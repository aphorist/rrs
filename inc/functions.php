<?php
// Database Function
function dbConnect($c) 
	{
            /*  
            โดยที่ $c เป็น Array มี index เป็น 
            host = ชื่อ หรือ ip ของเครื่อง mysql server
            user = ชื่อผู้ใช้
            pass = รหัสผ่าน
            db = ชื่อฐานข้อมูล
            charset = รหัสอักขระ เป็น utf8 หรือ tis620
            */
	   $db = new mysqli($c['host'], $c['user'], $c['pass'], $c['db']);
	   $db->set_charset($c['charset']);
	   return $db;
	}

function selectQuery($q,$db)
	{
/*  
$q คือ คำสั่ง SQL สำหรับ Select ค่า
$db คือ ค่าที่ return มาจาก dbconnect
เมื่อรับค่าจากฟังชั่นนี้ไปแล้ว ต้องไปเรียก $result->fetch_assoc(); อีกครั้งหนึ่ง
*** $result เป็นตัวแปลที่เรียกฟังก์ชัน selectQuery(); 
*** เป็นชื่ออื่นก็ได้ เช่น 
$res = selectQuery($q,$db);
$row = $res->fetch_assoc();  เรียกข้อมูลจากคิวรี่มาเก็บใน $row
$res->num_rows;  นับแถว
print_r($row);

$res->close();  อย่าลืม ปิดด้วย
*/
		$result = $db->query($q);
		return $result;
	}

function countRows($sql,$db)
   {
		$res = selectQuery($sql,$db);
		$c = $res->num_rows;
		$res->close();
		return $c;
   }

function sqlQuery($q,$db)
	{
		$result = $db->query($q);
		if ($result) {
			$affected = $db->affected_rows;
			return $affected;
		} else {
			return false;
		}
	}

function arrayToSql($array,$table,$output=FALSE)
	{
		/*
			$array ตัวแปรอาเรย์ โดยให้ key เป็นชื่อฟิลด์ในตาราง และ value เป็นค่าที่จะเพิ่มเข้าตาราง
			$table ชื่อตารางที่ต้องการ
			$output False ไม่แสดงผล ส่งออกค่า false ถ้า True แสดงค่า $Query
		*/
		$db = dbConnect();
		$field = NULL;
		$values = NULL;
		foreach ( $array AS $k=>$v ) {
			$field .= "`".$k."`, ";
			$values .= "'".$v."', ";
		}
		$field = trim($field,', ');
		$values = trim($values,', ');

		$query = "INSERT INTO `$table` ( $field ) VALUES ( $values )"; 

		$result = $db->query($query);
		if ($result) {
			$affected = $db->affected_rows;
			return $affected;
		} else {
			if (!$output) {
				return false;
			} else {
				return $query;
			}
			
		}
	}

function arrayUpdateSql($array,$table,$where,$output=FALSE)
	{
		/*
               $array ตัวแปรอาเรย์ โดยให้ key เป็นชื่อฟิลด์ และ value เป็นค่าที่จะแก้ไข
               $table ชื่อตารางที่ต้องการ
               $where = Where statement ที่กำหนดไว้เลยโดยตรง
               $output False ไม่แสดงผล ส่งออกค่า false ถ้า True แสดงค่า $Query
		*/
		$db = dbConnect();
          $update_set = NULL;
		foreach ( $array AS $k=>$v ) {
            $update_set .= "`".$k."`='".$v."', ";
		}
		$update_set = trim($update_set,', ');

		$query = "UPDATE `$table` SET $update_set WHERE $where"; 

		$result = $db->query($query);
		if ($result) {
			$affected = $db->affected_rows;
			return $affected;
		} else {
			if (!$output) {
				return false;
			} else {
				return $query;
			}
			
		}
	}
   
   
function province() {
   $p=array( 'กรุงเทพมหานคร',
         'กระบี่',
         'กาญจนบุรี',
         'กาฬสินธุ์',
         'กำแพงเพชร',
         'ขอนแก่น',
         'จันทบุรี',
         'ฉะเชิงเทรา',
         'ชลบุรี',
         'ชัยนาท',
         'ชัยภูมิ',
         'ชุมพร',
         'เชียงราย',
         'เชียงใหม่',
         'ตรัง',
         'ตราด',
         'ตาก',
         'นครนายก',
         'นครปฐม',
         'นครพนม',
         'นครราชสีมา',
         'นครศรีธรรมราช',
         'นครสวรรค์',
         'นนทบุรี',
         'นราธิวาส',
         'น่าน',
         'บึงกาฬ',
         'บุรีรัมย์',
         'ปทุมธานี',
         'ประจวบคีรีขันธ์',
         'ปราจีนบุรี',
         'ปัตตานี',
         'พระนครศรีอยุธยา',
         'พะเยา',
         'พังงา',
         'พัทลุง',
         'พิจิตร',
         'พิษณุโลก',
         'เพชรบุรี',
         'เพชรบูรณ์',
         'แพร่',
         'ภูเก็ต',
         'มหาสารคาม',
         'มุกดาหาร',
         'แม่ฮ่องสอน',
         'ยโสธร',
         'ยะลา',
         'ร้อยเอ็ด',
         'ระนอง',
         'ระยอง',
         'ราชบุรี',
         'ลพบุรี',
         'ลำปาง',
         'ลำพูน',
         'เลย',
         'ศรีสะเกษ',
         'สกลนคร',
         'สงขลา',
         'สตูล',
         'สมุทรปราการ',
         'สมุทรสงคราม',
         'สมุทรสาคร',
         'สระแก้ว',
         'สระบุรี',
         'สิงห์บุรี',
         'สุโขทัย',
         'สุพรรณบุรี',
         'สุราษฎร์ธานี',
         'สุรินทร์',
         'หนองคาย',
         'หนองบัวลำภู',
         'อ่างทอง',
         'อำนาจเจริญ',
         'อุดรธานี',
         'อุตรดิตถ์',
         'อุทัยธานี',
         'อุบลราชธานี');
   return $p;
}






/* ฟังชั่นใหม่ */
function isLogedIn() {
   if ( isset($_SESSION['username']) AND ($_SESSION['username'] <> '') ) {
   // มีการบันทึก Session ในระแบบ แสดงว่าเข้าสู่ระบบแล้ว
      return true;
   } else {
      return false;
   }
}

function canEdit($id,$reserver) {
// $id = id ในฐานข้อมูลของตารางการจองที่ต้องการตรวจสอบ
// $reserver = ผู้ใช้ปัจจุบัน
   global $admin;
   global $ls;
   $canEditUser = $admin;

   $q = "SELECT `reserver` FROM `reserved_room` WHERE `id`=$id";
   $db = dbConnect($ls);
   $res = selectQuery($q,$db);
   $row = $res->fetch_assoc(); 

   array_push($canEditUser, $row['reserver']);
   $canEditUser = array_unique($canEditUser);
   if ( in_array($reserver,$canEditUser) ) {
      return true;
   } else {
      return false;
   }
}
?>
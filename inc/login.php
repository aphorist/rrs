<?php
require_once('config.php');
require_once('functions.php');

if ( isset($_POST['username']) ) { $username = $_POST['username']; } else { $username = NULL; }
if ( isset($_POST['password']) ) { $password = $_POST['password']; } else { $password = NULL; }
$password = md5($password);

if ($username == NULL) { die('No username input.'); }

$ilib = dbConnect($rs); // ตัวแปรในฟังก์ชันเป็น array ดูไฟล์ config.php ในที่นี้จะเชื่อมต่อกับ ilib.msu.ac.th
$queryMember = "SELECT `loginid`, `pwd`, `name`, `picfilename` FROM `logins` WHERE `loginid`='$username' AND pwd='$password' LIMIT 0,1";
$ilibMemberResult = selectQuery($queryMember, $ilib);
$memberDetail = $ilibMemberResult->fetch_assoc();

// แปลงตัวอักษรให้เป็น UTF-8
foreach ($memberDetail as $k=>$v) {
   $memberDetail[$k] = iconv('TIS-620','UTF-8',$v);
}

if ( ($username == $memberDetail['loginid']) AND ($password == $memberDetail['pwd']) ) {
   // ลงทะเบียน SESSION
   $_SESSION['username'] = $memberDetail['loginid'];
   $_SESSION['avatar'] = $memberDetail['picfilename'];
   $_SESSION['name'] = $memberDetail['name'];
   
   header("location: ../index.php?login=success");
} else {
   header("location: ../index.php?login=fail");
}


?>
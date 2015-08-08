<?php
require_once('config.php'); // include มาเพื่อใช้งาน $_SESSION

$_SESSION = array();
   
header("location: ../index.php");
?>
<?php
require_once("inc/config.php");
require_once("inc/functions.php");

// ถ้ามีการกำหนด วัน เดือน ปี มา ให้แสดงปฎิทิน ของวันเดือนปีที่กำหนด
if ( isset($_GET['day']) || isset($_GET['month']) || isset($_GET['year']) ) {
   if ( isset($_GET['day']) ) { $day = $_GET['day']; } else { $day = date('d'); }
   if ( isset($_GET['month']) ) { $month = $_GET['month']; } else { $month = date('n'); }
   if ( isset($_GET['year']) ) { $year = $_GET['year']; } else { $year = date('o'); }
   $time = mktime(0,0,0,$month,$day,$year);
} else {
// หรือ ใช้วันเดือนปี ปัจจุบัน
   $time = time();   
}

$presentDay = date('d',$time);
$presentMonth = date('n',$time);
$presentYear = date('Y',$time);

$firstDayOfMonthTimeStamp = mktime(0,0,0,$presentMonth,1,$presentYear);
$numberOfDayInThisMonth = date('t',$time);
$lastDayOfMonthTimeStamp = mktime(0,0,0,$presentMonth,$numberOfDayInThisMonth,$presentYear);

$startDayOfWeekInThisMonth = date('w',$firstDayOfMonthTimeStamp); // 1 - จันทร์, ... , 7 - อาทิตย์  (วันที่ 1 ของเดือนนี้เริ่มวันอะไร)
$startDayOfWeekInThisMonth7isSunday = $startDayOfWeekInThisMonth;
if ($startDayOfWeekInThisMonth == 0) {
   $startDayOfWeekInThisMonth7isSunday = 7;
   // วันแรกของเดือนนี้ คือวันอะไร ( 1 - จันทร์ ... 7 - อาทิตย์)
}

$lastDayOfWeekInThisMonth = date('w',$lastDayOfMonthTimeStamp);
$lastDayOfWeekInThisMonth7isSunday = $lastDayOfWeekInThisMonth;
if ($lastDayOfWeekInThisMonth == 0) {
   $lastDayOfWeekInThisMonth7isSunday = 7;
   // วันสุดท้ายของเดือนนี้ คือวันอะไร ( 1 - จันทร์ ... 7 - อาทิตย์)
}

// คำนวณหาเดือนก่อนหน้า
$previousMonthTimeStamp = $firstDayOfMonthTimeStamp - 43200;

$previousMonth = date('n',$previousMonthTimeStamp);
$previousYear = date('Y',$previousMonthTimeStamp);

// คำนวณหาเดือนต่อไป
$nextMonthTimeStamp = $lastDayOfMonthTimeStamp + 129600;

$nextMonth = date('n',$nextMonthTimeStamp);
$nextYear = date('Y',$nextMonthTimeStamp);

$q = "SELECT `day` FROM `reserved_room` WHERE `month`='$presentMonth' AND `year`='$presentYear' GROUP BY `day`";

$db = dbConnect($ls);
$res = selectQuery($q,$db);
$k=0;
$reservedDay = array();
while ($row = $res->fetch_assoc()) {
   $reservedDay[$k] = $row['day'];
   $k++; 
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Room Reserved System</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="css/custom.css" rel="stylesheet">
  </head>
  <body>
      <div class="container width800">
         <div class="row"> <!--- Reserve Room System Header -->
            <div class="col-xs-12">
               <h3 class="text-center"><strong>ระบบจองห้องประชุม / ห้องอบรม</strong><br><small>สำหรับบุคลากรสำนักวิทยบริการ มหาวิทยาลัยมหาสารคาม</small></h3>
               <hr>
            </div>
         </div>

         <div class="row">
            <div class="col-md-4"> <!-- Right BOX -->
               <div class="text-center">
<?php
   if ( isLogedIn() ) {
   // มีการบันทึก Session ในระแบบ แสดงว่าเข้าสู่ระบบแล้ว
      echo  "
                  <img src='http://ilib.msu.ac.th/signon/_memberpic/".$_SESSION['avatar']."' class='img-thumbnail' width='90'><br>
                  ยินดีต้อนรับคุณ <span id='currentUserName'>".$_SESSION['name']."</span><br>
                  <a href='inc/logout.php' class='btn btn-default'>ออกจากระบบ</a>
                 ";

   } else {  
   // ยังไม่เข้าสู่ระบบ ให้แสดงปุ่มเข้าสู่ระบบ
      echo  "
                  <a href='#' class='btn btn-default' data-toggle='modal' data-target='#loginForm'>เข้าสู่ระบบ</a><br>
                 ";
   }   
?>
                  <div class="text-left"> <!-- INFO BOX -->
                  <hr>
                  <a href="#roomDetails" role="button" class="btn btn-success" data-toggle="modal">รายละเอียดห้องประชุม / อบรม</a>
                     <div>
                        <small>สามารถคลิกวันที่ในปฎิทินเพื่อดูรายละเอียดการจองห้องในแต่ละวันได้ หากต้องการจองห้อง ให้คลิกที่วันที่ต้องการ แล้วคลิกที่ปุ่ม "ลงชื่อจอง" พร้อมกรอกรายละเอียดการจองห้อง</small>
                     </div>
                  </div>
               </div>
            </div>
         
            <div class="col-md-8">  <!--- Calendar Table -->
               <div> <!-- navi month year -->
                  <h3 class="text-center">
                     <a href="index.php?month=<?php echo $previousMonth; ?>&year=<?php echo $previousYear; ?>">
                        <span class="glyphicon glyphicon-menu-left pull-left" aria-hidden="true"></span>
                     </a>
                  <strong> <!-- เก็บค่าใส่ id ไว้ใช้สำหรับ jQuery -->
                     <span id="calendarMonth"><?php echo $thaiMonthName[$presentMonth]; ?></span> 
                     <span id="calendarYearThai"><?php echo $presentYear+543; ?></span>
                  </strong>
                     <a href="index.php?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>">
                        <span class="glyphicon glyphicon-menu-right pull-right" aria-hidden="true"></span>
                     </a>
                  </h3>
               </div>
               <table class="table text-center">
                  <tr>
               <?php
                  foreach ($thaiDaysName as $thaiDayName) {
                     echo "<th width='14%'>".$thaiDayName."</th>";
                  }
                ?>
                  </tr>
                  <tr>
                  <?php
                     $numberOfBlockForThisMonth = $startDayOfWeekInThisMonth + $numberOfDayInThisMonth + (7 - $lastDayOfWeekInThisMonth7isSunday);
                     for ($j=1;$j<$numberOfBlockForThisMonth;$j++) {
                        $day = NULL;
                        if ( $startDayOfWeekInThisMonth <= $j ) { $i++; $day = $i;}    // ถ้าถึงวันเริ่มต้นวันของสัปดาห์นี้ ให้เพิ่มค่า $i ขึ้นไปแล้วเก็บค่าลง $day
                        if ( $i > $numberOfDayInThisMonth ) { $day = NULL; }              // ถ้าค่า i มากกว่าจำนวนวันในเดือนนั้น ให้ $day มีค่าเป็น NULL
                        $trCheck = $j % 7;
                        
                        $dayCssClass = "active";
                        $dataToggle = NULL;
                        
                        if ( $day != NULL ) { 
                           $dayCssClass .= " day"; 
                           $dataToggle = "data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#dayDetail' data-day='$day'";
                        }
                        
                        if ( ($trCheck == 0) OR ($trCheck == 6)) { $dayCssClass .= " danger"; } 
                        
                        if ( $presentDay == $i ) { $dayCssClass .= " today"; }
                        
                        
                        if ( in_array($day,$reservedDay) ) {$pd = "pdactive";} else {$pd = "pd";}
                         
                        echo "
                        <td class='$dayCssClass' $dataToggle>
                           <div class='pd'></div>
                           <div>$day</div>
                           <div class='$pd'></div>";                           
                        if ( $trCheck == 0 ) {
                           echo "</tr><tr>";
                        }
                     }
                  ?>
                  </tr>
               </table>

            </div>
         </div>
      </div>
<?php include_once('inc_html/modal_day_detail.php'); ?>
<?php include_once('inc_html/modal_reserved_form.php'); ?>
<?php include_once('inc_html/modal_login_form.php'); ?>
<?php include_once('inc_html/modal_reserved_detail.php'); ?>
<?php include_once('inc_html/modal_room_details.php'); ?>

<nav class="navbar navbar-default navbar-fixed-bottom">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            ระบบจองห้องประชุม และห้องฝึกอบรม สำนักวิทยบริการ<br>
            พัฒนาโดย นายอภิชัย  ไสยรส นักวิชาการคอมพิวเตอร์ปฎิบัติการ<br>
            สำนักวิทยบริการ มหาวิทยาลัยมหาสารคาม<br>
         </div>
      </div>
   </div>
</nav>

<!-- ตรงส่วนนี้ จะ ซ่อนไว้ ไม่ให้แสดงผล แต่จะสามารถดึงค่าไปใช้ใน jQuery ได้ -->
<div style="display: none;">
   <span id="calendarToday"><?php echo $presentDay; ?></span>
   <span id="calendarYear"><?php echo $presentYear; ?></span>

   <span id="reserveFormDay"></span>
   <span id="reserveFormMonth"></span>
   <span id="reserveFormYear"></span>
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/jquery.confirm.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>
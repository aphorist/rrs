      <!-- Modal dayDetail-->
      <div class="modal fade" id="dayDetail" tabindex="-1" role="dialog">
        <div class="modal-dialog width800" role="document">
        
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">รายละเอียดการจอง วันที่ <strong><span id="fday"></span> <span id="fmonth"></span> <span id="fyear"></span></strong></h4>
            </div>
            
            <div class="modal-body">
               <div class="container col-md-12">
                  <div class="row">
                     <div class="col-md-4" id="room1"> <!-- ตารางเวลาจองห้องประชุมชั้น 1 -->

                     </div>
                     
                     <div class="col-md-4" id="room2"> <!-- ตารางเวลาจองห้องประชุมชั้น 2 -->
                        <img src="css/ajax-loader.gif" width="64">
                     </div>
                     
                     <div class="col-md-4" id="room3"> <!-- ตารางเวลาจองห้องอบรมชั้น 4 -->

                     </div>
                  </div>
               </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
<?php if ( isLogedIn() ) { ?>  
              <button 
                  id="reserveButton"
                  type="button" 
                  class="btn btn-primary" 
                  data-dismiss="modal" 
                  data-toggle="modal" 
                  data-backdrop="static" 
                  data-keyboard="false" 
                  data-act="add"
                  data-target="#reserveForm"
              >
                  ลงชื่อจอง
              </button>
<?php } else { ?>
               <div class="text-center text-warning">กรุณาเข้าสู่ระบบ หากต้องการจองห้อง</div>
<?php } ?>
            </div>
          </div>
          
        </div>
      </div>

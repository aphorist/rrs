      <!-- Modal reserveForm-->
      <div class="modal fade" id="reservedDetail" tabindex="-1" role="dialog">
        <div class="modal-dialog width500" role="document">
         <form class="form-horizontal" action="inc/reserve_room.php" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
               รายละเอียดการจอง <strong><span id="rdRoom"></span></strong> 
               วันที่ 
               <strong>
                  <span id="rdDay"></span> 
                  <span id="rdMonth"></span> 
                  <span id="rdYear"></span>
               </strong>
              </h4>
            </div>
            <div class="modal-body">
               <div id="reservedDetailBox"></div>
            </div>
            <div style="display: none;"><!-- สำหรับเก็บค่า ตรวจเช็ค ต่าง ๆ ไว้ใช้งานกับ jQuery -->
               <span id="reservedID"></span>
            </div>
            <div class="modal-footer">
               <div>
                 <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#dayDetail">กลับ</button>
                 <button id="editReservedButton" type="button" class="btn btn-warning" data-dismiss="modal" data-toggle="modal" data-act="edit" data-target="#reserveForm">แก้ไขการจอง</button>
                 <button id="delReservedButton" type="button" class="btn btn-danger" data-text="ต้องการยกเลิกการจองห้องนี้ ใช่หรือไม่" data-confirm-button="ใช่ ยกเลิกการจองห้องนี้" data-cancel-button="ไม่ใช่">ลบ</button>
               </div>
            </div>
          </div>
          
        </div>
        </form>
      </div>

      <!-- Modal reserveForm-->
      <div class="modal fade" id="reserveForm" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
         <form class="form-horizontal" action="inc/reserve_room.php" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
               จองห้อง 
               วันที่ 
               <strong>
                  <span id="rfDay"></span> 
                  <span id="rfMonth"></span> 
                  <span id="rfYear"></span>
               </strong>
              </h4>
            </div>
            <div class="modal-body">
            
            <fieldset>
              <!-- 1. หัวข้อ กิจรรม -->
              <div class="form-group">
                <label for="inputSubject" class="col-xs-3 control-label">กิจกรรม</label>
                <div class="col-xs-8">
                  <input type="text" class="form-control" id="inputSubject" placeholder="เช่น 'KM บรรณารักษณ์' เป็นต้น" name="inputSubject" required>
                </div>
              </div>
              
              <!-- 2. จำนวนผู้เข้าร่วมกี่คน -->
              <div class="form-group">
                <label for="inputNumber" class="col-xs-3 control-label">จำนวนผู้เข้าร่วม (คน)</label>
                <div class="col-xs-3">
                  <input type="number" class="form-control" id="inputNumber" data-bind="value:replyNumber" placeholder="(ตัวเลข)" name="inputNumber" required>
                </div>
              </div>

               <!-- 3. ห้องที่ต้องการจอง -->
              <div class="form-group">
                <label class="col-xs-3 control-label">ห้องที่ต้องการจอง</label>
                <div class="col-xs-8">
                  <div class="radio">
                    <label>
                      <input type="radio" name="inputRoom" id="optionsRadios1" value="ห้องประชุม ชั้น 1">
                      ห้องประชุม ชั้น 1
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="inputRoom" id="optionsRadios2" value="ห้องประชุม ชั้น 2">
                      ห้องประชุม ชั้น 2
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="inputRoom" id="optionsRadios3" value="ห้องอบรม ชั้น 4">
                      ห้องอบรม ชั้น 4
                    </label>
                  </div>
                </div>
              </div>
              
              <!-- 4. เวลาเริ่มใช้งาน -->
              <div class="form-group">
                <label for="startTime" class="col-xs-3 control-label">เวลาเริ่มใช้งาน</label>
                <div class="col-xs-4">
                  <select class="form-control" id="startTime" name="startTime">
<?php
for ($i=1;$i<=18;$i++) {
   echo "<option value='$i'>".$reserveTime[$i]."</option>";
}
?>

                  </select>
                </div>
              </div>
              
               <!-- 5. เวลาเลิก -->
              <div class="form-group">
                <label for="stopTime" class="col-xs-3 control-label">ใช้งานถึงเวลา</label>
                <div class="col-xs-4">
                  <select class="form-control" id="stopTime" name="stopTime">
<?php
for ($i=1;$i<=18;$i++) {
   echo "<option value='$i'>".$reserveTime[$i]."</option>";
}
?>
                  </select>
                </div>
              </div>

              <!-- 6. อื่น ๆ ที่ต้องการ -->
              <div class="form-group">
                <label for="inputPassword" class="col-xs-3 control-label">อื่น ๆ ที่ต้องการ<br><small>เลือกได้หลายอัน</small></label>
                <div class="col-xs-8">
                  <div class="checkbox">
                     <label>
                      <input type="checkbox" id="inputNeedProjector" value="1"> โปรเจคเตอร์
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="inputNeedPointer" value="1"> พ้อยเตอร์
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="inputNeedPhoto" value="1"> ถ่ายภาพ
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="inputNeedMic" value="1"> ไมค์ลอย
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="inputNeedTechnicial" value="1"> ต้องการนักคอมพิวเตอร์ (แสตนบาย)
                    </label>
                  </div>
                </div>
              </div>
              
              <!-- 7.เพิ่มเติม -->
              <div class="form-group">
                <label for="inputOther" class="col-xs-3 control-label">เพิ่มเติม</label>
                <div class="col-xs-8">
                  <textarea class="form-control" rows="3" id="inputOther" name="inputOther"></textarea>
                  <span class="help-block">อื่น ๆ เพิ่มเติมเพื่อแจ้งเจ้าหน้าที่ให้รับทราบ</span>
                </div>
              </div>
            </fieldset>

            </div>
            <div style="display: none;"><!-- สำหรับเก็บค่า ตรวจเช็ค ต่าง ๆ ไว้ใช้งานกับ jQuery -->
               <span id="checkRoom"></span>
               <span id="reservedAction"></span>
               <span id="reservedID"></span>
            </div>
            <div class="modal-footer">
               <div id="infobox" class="col-xs-6">
                  <p id="info-text" class="bg-danger text-center "></p>
               </div>

               <div class="col-xs-6">
                 <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                 <button id="checkReserved" type="button" class="btn btn-primary">บันทึกการจอง</button>
               </div>
            </div>
          </div>
          
        </div>
        </form>
      </div>

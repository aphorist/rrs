      <!-- Modal loginForm-->
      <div class="modal fade" id="confirmBox" tabindex="-1" role="dialog">
        <div class="modal-dialog width400" role="document">
         <form class="form-horizontal" action="inc/login.php" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center">กรุณายืนยัน</h4>
            </div>
            <div class="modal-body">
            
            <fieldset>
              <div class="form-group">
                <label for="inputUsername" class="col-xs-3 control-label">ชื่อผู้ใช้</label>
                <div class="col-xs-9">
                  <input type="text" class="form-control" id="inputUsername" name="username" placeholder="ชื่อผู้ใช้" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-xs-3 control-label">รหัสผ่าน</label>
                <div class="col-xs-9">
                  <input type="password" class="form-control" id="inputPassword" name="password" placeholder="รหัสผ่าน" required>
                  <span class="help-block">ใช้ username และ password จากระบบชายคาสำนัก</span>
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12">
                  
                </div>
              </div>
            </fieldset>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
              <input type="submit" value="ตกลง" class="btn btn-primary">
            </div>
          </div>
          
        </div>
        </form>
      </div>

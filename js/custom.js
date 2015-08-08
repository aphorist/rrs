$(document).ready(function(){
	// เมื่อคลิก วันที่ในตาราง (คลาส .day)
	$(".day").click(function(){ 
		$("#fday").html($(this).data('day'));
		$("#fmonth").html($("#calendarMonth").html());
		$("#fyear").html($("#calendarYearThai").html());

		$("#reserveFormDay").html($(this).data('day'));
		$("#reserveFormMonth").html($("#calendarMonth").html());
		$("#reserveFormYear").html($("#calendarYearThai").html());

		$("#rfDay").html($("#reserveFormDay").html());
		$("#rfMonth").html($("#reserveFormMonth").html());
		$("#rfYear").html($("#reserveFormYear").html());

		showReservedTable('room1');
		showReservedTable('room2');
		showReservedTable('room3');
	});
	
	// เมื่อคลิก ตารางเวลาที่ได้ทำการจองแล้ว  (คลาส pointer)
	 $(document).on("click",".pointer",function(e){
	 	var room=$(this).data('room');
	 	var id=$(this).data('id');
	 	var day=$(this).data('day');
//	 	var month=$(this).data('month');
	 	var month=$("#fmonth").html();
//	 	var year=$(this).data('year');
	 	var year=$("#fyear").html();
		$('#rdRoom').html(room);
		$('#rdDay').html(day);
		$('#rdMonth').html(month);
		$('#rdYear').html(year);
		$('#reservedID').html(id);
		var cUserName = $("#currentUserName").html();
		
		$.post("inc/reserved_detail.php",
			{
				// ค่าที่จะส่งไป ใส่ตรงนี้
				id: id,
				cUserName : cUserName
			},
			function(data) {
				var dataArr = data.split('|');
				// ตรวจสอบว่า สามารถแก้ไข หรือ ลบได้หรือไม่
				if ( dataArr[1] == 'true' ) {
					$("#editReservedButton").css('display','initial');
					$("#delReservedButton").css('display','initial');
				}
				$('#reservedDetailBox').html(dataArr[0]);
			}
		);
		
	 });

//##### แสดงตาราง การจองห้องของแต่ละวัน
	function showReservedTable(room){
	   	var day = $("#reserveFormDay").html();
	   	var month = $("#reserveFormMonth").html();
	   	var year = $("#reserveFormYear").html();
 	
		return $.post("inc/day_detail_table.php",
			{
				// ค่าที่จะส่งไป ใส่ตรงนี้
				room: room,
				day: day,
				month: month,
				year: year,
			},
			function(data) {
				$('#'+room).html(data);
			}
		);
	}

   // เมื่อคลิกปุ่ม ลงชื่อจอง (ไอดี #reserveForm)
   $("#reserveForm").click(function(){ 
     $("#rfDay").html($("#reserveFormDay").html());
     $("#rfMonth").html($("#reserveFormMonth").html());
     $("#rfYear").html($("#reserveFormYear").html());
   });
   
//##### ส่วนการทำงานของ ฟอร์มจองห้อง
	
	//บันทึกข้อมูลลงฐานข้อมูล
	function saveReserveRoom(act,id){
	   	var day = $("#reserveFormDay").html();
	   	var month = $("#reserveFormMonth").html();
	   	var year = $("#reserveFormYear").html();
	     	var inputSubject = $("#inputSubject").val();
	     	var inputNumber = $("#inputNumber").val();
	     	var inputRoom = $("input:radio[name=inputRoom]:checked").val();
	   	var inputStartTime = $("#startTime option:selected").val();
		var inputStopTime = $("#stopTime option:selected").val();
	 	if ( $("#inputNeedProjector").is(":checked") ) { var inputNeedProjector = $("#inputNeedProjector").val(); }
	 	if ( $("#inputNeedPointer").is(":checked") ) { var inputNeedPointer = $("#inputNeedPointer").val(); }
	 	if ( $("#inputNeedPhoto").is(":checked") ) { var inputNeedPhoto = $("#inputNeedPhoto").val(); }
	 	if ( $("#inputNeedMic").is(":checked") ) { var inputNeedMic = $("#inputNeedMic").val(); }
	 	if ( $("#inputNeedTechnicial").is(":checked") ) { var inputNeedTechnicial = $("#inputNeedTechnicial").val(); }
	 	var inputOther = $("#inputOther").val();
   	
		return $.post("inc/save_room.php",
			{
				// ค่าที่จะส่งไป ใส่ตรงนี้
				day: day,
				month: month,
				year: year,
				subject: inputSubject,
				inputNumber: inputNumber,
				room: inputRoom,
				startTime: inputStartTime,
				stopTime: inputStopTime,
				needProjector: inputNeedProjector,
				needPointer : inputNeedPointer,
				needPhoto: inputNeedPhoto,
				needMic: inputNeedMic,
				needTechnicial: inputNeedTechnicial,
				other: inputOther,
				action : act,
				id : id
			}
		);
	}

	// ตรวจสอบว่าห้องว่างหรือไม่ในช่วงเวลานั้น (id คือ ค่า id ในตารางที่เราจะไม่รวมในการเช็ค ใช้สำหรับการแก้ไขข้อมูล)
	function checkRoom(room,startTime,stopTime,id){
	   	var day = $("#reserveFormDay").html();
	   	var month = $("#reserveFormMonth").html();
	   	var year = $("#reserveFormYear").html();
   	
		return $.post("inc/check_room.php",
			{
				// ค่าที่จะส่งไป ใส่ตรงนี้
				room: room,
				day: day,
				month: month,
				year: year,
				startTime: startTime,
				stopTime: stopTime,
				id: id
			}
		);
	}
	
	// ตรวจสอบเวลา เริ่มใช้ห้อง
	// หากเลือก "เวลาเริ่มใช้งาน" ให้เปลี่ยน "ใช้งานถึงเวลา" เป็น ค่าที่เลือก + 1 ซึ่งหมายถึง 30 นาที
	// เช่น หากเลือก 09.30 ในส่วนของ "ใช้งานถึงเวลา" จะเปลี่ยนเป็น 10.00 อัตโนมัติ
   $("#startTime").change(function(){
   	var inputStartTime = $("#startTime option:selected").val();
   	var inputStopTime = $("#stopTime option:selected").val();
   	if ( Number(inputStartTime) > Number(inputStopTime) ) {
   		$("#stopTime").val(inputStartTime);
   	}

   });

   	// ตรวจสอบเวลาเลิกใช้ห้อง
   $("#stopTime").change(function(){
	$('#info-text').fadeOut();
   	var startTime = $("#startTime option:selected").val();
	var stopTime = $("#stopTime option:selected").val();

	if ( Number(startTime) > Number(stopTime)) {
		$('#info-text').html('ต้องเลือก เวลาเลิกใช้งาน ให้มากกว่า เวลาเริ่มใช้งาน กรุณาเลือกใหม่').fadeIn("slow");
		stopTime = startTime;
		$("#stopTime").val(stopTime);
	} 
	
   	var room = $("input:radio[name=inputRoom]:checked").val();
   	var id = $("#reservedID").html();
	var checkRoomData = checkRoom(room,startTime,stopTime,id);
   	checkRoomData.done(function(data) {
   		var arr = data.split('|');
   		if ( arr[0] == 'false' ) {
   			$('#checkReserved').attr('disabled','disabled');
   			$('#info-text').html('ห้องนี้ มีการจองในช่วงเวลานี้แล้วครับ กรุณาเลือกช่วงเวลาใหม่ครับ').fadeIn("slow");
   			//alert(arr[1]);
   		} else {
   			$('#checkReserved').removeAttr('disabled');
   			//alert(arr[1]);
   		}
   	});
   });
   
   // เมื่อคลิกปุ่ม บันทึกการจอง (ไอดี #checkReserved)
   $("#checkReserved").click(function(){ 
     	var inputSubject = $("#inputSubject").val();
     	if ( !inputSubject ) {
   			$('#info-text').html('กรุณากรอก "กิจกรรม"').fadeIn("slow");
   			$("#inputSubject").addClass("has-error").focus();
   			return false;
     	} else {
     		$('#info-text').html('').fadeOut(1);
     		$("#inputSubject").removeClass("has-error");
     	}
     	
     	var inputNumber = $("#inputNumber").val();
     	if ( !inputNumber ) {
   			$('#info-text').html('กรุณากรอก "จำนวนผู้เข้าร่วม"').fadeIn("slow");
   			$("#inputNumber").addClass("has-error").focus();
   			return false;
     	} else {
	     	$('#info-text').html('').fadeOut(1);
     		$("#inputNumber").removeClass("has-error");
     	}
     	
     	var inputRoom = $("input:radio[name=inputRoom]:checked").val();
   	var inputStartTime = $("#startTime option:selected").val();
	var inputStopTime = $("#stopTime option:selected").val();
	var id = $("#reservedID").html();

	var checkRoomData = checkRoom(inputRoom,inputStartTime,inputStopTime,id);
   	checkRoomData.done(function(data) {
   		var arr = data.split('|');
   		if ( arr[0] == 'false' ) {
//   			$('#checkReserved').attr('disabled','disabled');
//   			$('#inputSubject').focus();
   			$('#info-text').html('ห้องนี้ มีการจองในช่วงเวลานี้แล้วครับ กรุณาเลือกช่วงเวลาใหม่ครับ').fadeIn("slow");
   			//$('#info-text').fadeIn("slow");
   		} else {
   			$('#info-text').fadeOut("slow");
   			act = $("#reservedAction").html();
   			id = $("#reservedID").html();
   			var saveData = saveReserveRoom(act,id);
   			saveData.done(function(result){
   				var resultArr = result.split('|');
   				if ( resultArr[0] != 'true' ) {
   					alert('เกิดข้อผิดพลาด \r\n กรุณาติดต่อ 2404 \r\n อภิชัย  ไสยรส \r\n error : ' + resultArr[1]);
   				} else {
   					alert('บันทึกข้อมูลเรียบร้อยแล้ว' + result)
   					window.location.href = "index.php";
   				}
   			});
   		}
   	});
   });

	// เมื่อคลิก ให้เปิดฟอร์มการจอง
	$( "#reserveForm" ).on('shown.bs.modal', function(e){
		// ตรวจสอบตัวแปล
		var action = $(e.relatedTarget).data('act');
		var id = $('#reservedID').html();
		if (action == 'edit') {
			// ถ้าเป็นการแก้ไข ให้เพิ่มค่าต่าง ๆ จาก ฐานข้อมูลลงไปในฟอร์ม
			$.post("inc/get_reserved_detail_from_id.php",
				{
					// ค่าที่จะส่งไป ใส่ตรงนี้
					id: id
				},
				function(data) {
			   		var arr = data.split('|');
			   		if ( arr[0] == 'false' ) {
						alert(arr[1]);
			   		} else {
			   			$("#inputSubject").val(arr[2]);
			   			$("#inputNumber").val(arr[3]);
			   			$("input[name=inputRoom][value='" + arr[4] + "']").prop('checked', true);
			   			$("#startTime").val(arr[8]);
			   			$("#stopTime").val(arr[9]);
						if ( arr[11] == 1 ) { $("#inputNeedProjector").prop('checked', true); } else { $("#inputNeedProjector").prop('checked', false); }
						if ( arr[12] == 1 ) { $("#inputNeedPointer").prop('checked', true); } else { $("#inputNeedPointer").prop('checked', false); }
						if ( arr[13] == 1 ) { $("#inputNeedPhoto").prop('checked', true); } else { $("#inputNeedPhoto").prop('checked', false); }
						if ( arr[14] == 1 ) { $("#inputNeedMic").prop('checked', true); } else { $("#inputNeedMic").prop('checked', false); }
						if ( arr[15] == 1 ) { $("#inputNeedTechnicial").prop('checked', true); } else { $("#inputNeedTechnicial").prop('checked', false); }
			   			$("#inputOther").val(arr[16]);
			   			$("#reservedAction").html('edit');
			   			$("#reservedID").html(id);
			   		}
				}
			);
		} else {
			// ถ้าเป็นการเพิ่มใหม่
			var n = null;
   			$("#inputSubject").val(n);
   			$("#inputNumber").val(n);
   			$("input[name=inputRoom]").prop('checked', false);
   			$("#startTime").val(1);
   			$("#stopTime").val(1);
			$("#inputNeedProjector").prop('checked', false);
			$("#inputNeedPointer").prop('checked', false);
			$("#inputNeedPhoto").prop('checked', false); 
			$("#inputNeedMic").prop('checked', false); 
			$("#inputNeedTechnicial").prop('checked', false);
   			$("#inputOther").val(n);
   			$("#reservedAction").html('add');
   			$("#reservedID").html(0);
		}

	});
	
// เรียกใช้สคริป เมื่อปิด modal
// $('#myModal').on('hidden.bs.modal', function () {
    // do something
// })

	// เมื่อปิด ดูรายละเอียดการจองในตาราง (ที่ ไฮไลด์ การจองสีแดง ๆ )
//	$('#reservedDetail').on('show.bs.modal', function () {
//		var roomName = $(".pointer").data('room');
//		var id = $(".pointer").data('id');
//		
//	   	$("#rdRoom").html( roomName );
//	   	$("#rdDay").html('.....');
//	   	$("#rdMonth").html('.....');
//	   	$("#rdYear").html('.....');
//	});

	$("#delReservedButton").confirm(
		{
			confirm : function(button) {
				var id = $('#reservedID').html();
				$.post("inc/del_reserved.php",
					{
						// ค่าที่จะส่งไป ใส่ตรงนี้
						id: id
					},
					function(data) {
				   		var arr = data.split('|');
				   		if ( arr[0] == 'false' ) {
							alert("ไม่พบข้อมูลที่ต้องการลบ เป็นไปได้ว่า ข้อมูลอาจถูกลบไปแล้ว");
							window.location.href = "index.php";
				   		} else {
//				   			alert("ลบข้อมูลเรียบร้อยแล้ว");
							window.location.href = "index.php";
				   		}
					}
				);
			}
		}
	);

});
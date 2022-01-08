<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhiệm vụ mới</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	
</head>

<style>
	body {
		background-image: url(../images/background.jpg);
		background-repeat: no-repeat;
    	background-size: 100% 100%;
	}
	.e__task__heading {
		background-color: rgb(131,124,124);
		position: sticky;
		color: rgb(222,215,35);
	}
	.e__task__infomation {
		background-color: rgb(240,255,255);
	}
	.scrollable-task {
		height: 500px;
		overflow-x: auto;
	}
</style>
<body>
    
<div>
    <div class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between mr-2 ml-2">
        <div class="">
            <div class="navbar-header">
                <div class=""><h4>Home page Employee</h4></div>
            </div>
        </div>
        <div class="navbar-info nav d-flex">
            <a class="font-weight-bold mr-4" href="../profile.php">Profile</a>
            <a class="font-weight-bold" href="../logout.php">Logout</a>
        </div>
        <div class="navbar-icon">
            <i class="fas fa-bars"></i>
        </div>
    </div>

	</div>
	<div class="employee m-4">
		<div class="row">
			<div class="d-flex w-100 align-items-center employee-heading">
					
				<div class="col-xl-4 col-lg-6 col-md-5 employee-name">
					<h4 class="">Hello <?= $_SESSION['hoTen'] ?></h4>
				</div>
				<div class="col-xl-5 col-lg-4 col-md-6 col-sm-10 col-10">
					<div class="form-group border rounded-lg mb-0 bg-light">
						<form class="" methode="post">
							<div class="d-flex align-items-center justify-content-between w-100">
								<div class="task-search-input m-1" style="width: inherit">
									<input class="border border-0 border-none rounded p-1 w-100" type="search" placeholder="Search task" aria-label="Search">
								</div>
								<div class="task-search-icon m-1">
									<button class="btn btn-outline-info rounded-circle" type="submit"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-xl-3 col-lg-2 col-md-3 col-sm-2 col-2">
					<ul class="d-flex list-unstyled justify-content-end mb-0">
						<li>
							<button class="nav-item__day-off btn btn-light text-decoration-none d-flex align-items-center justify-content-center" data-toggle='modal' data-target='#day-off-dialog' href="">
								<i class="fas fa-calendar-day"></i>
								<p class="mb-0 ml-1 day-off">On leave</p> 
							</button>
						</li>
					</ul>
				</div>
		
				</div>
			</div>
	
		</div>
	</div>
	<div>
		<div class="row m-0">
			<?php
				require_once('sidebar.php');
			?>

			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 rounded border border-left-0 border-right-0 border-bottom-0">
				<div class="border border-left-0 border-right-0">
					<div class="scrollable-task">
						<div class="e__task__heading">
							<div class="d-flex">
								<div class='task-name__heading col-xl-2 col-lg-4 col-md-3 col-sm-12 col-12 border border-top-0 border-left-0'>
									<p class="mb-0 p-1">Tên nhiệm vụ</p>
								</div>
								<div class='task-description__heading col-xl-6 col-lg-4 col-md-7 border border-top-0 border-left-0'>
									<p class="mb-0 p-1">Thông tin nhiệm vụ</p>
								</div>
								<div class='task-time col-xl-2 col-lg-0 col-md-0 border border-top-0 border-left-0'>
									<p class="mb-0 p-1">Deadline</p>
								</div>								
								<div class='task-rate col-xl-2 col-lg-4 col-md-2 border border-top-0 border-left-0 border-right-0'>
									<p class="mb-0 p-1">Trạng thái</p>
								</div>	
							</div>
						</div>	
						<div class="e__task__infomation">
							<?php
								require_once("../connect_db.php");
								require_once("task_and_dayOff_db.php");
								$sql = "SELECT * FROM NHIEMVU WHERE trangThai = 'waiting' ORDER BY hanThucHien";
								$result = connect_db()->query($sql);

								while ($row = $result->fetch_assoc()) {

									$name = $row['tenNhiemVu'];
									$desc = $row['moTa'];
									$time = $row['hanThucHien'];
									$condition = $row['trangThai'];

									echo	"<div class='d-flex task-list' style='cursor: pointer' data-toggle='modal' data-target='#file-info-dialog'>
												<div class='task-name__heading col-xl-2 col-lg-4 col-md-3 col-sm-12 col-12 border border-top-0 border-left-0'>
													<p class='task-name  mb-0 p-1'>$name</p>
												</div>
												<div class='task-description__heading col-xl-6 col-lg-4 col-md-7 border border-top-0 border-left-0'>
													<p class='task-description mb-0 p-1'>$desc</p>
												</div>
												<div class='task-time col-xl-2 border border-top-0 border-left-0'>
													<p class='mb-0 p-1'>$time</p>
												</div>
												<div class='task-condition col-xl-2 border border-top-0 border-left-0'>
													<p id='employee__task-rate' class='mb-0 p-1'>$condition</p>
												</div>												
											</div>";
								}
							?>		
						</div>
					</div>
				</div>
			</div>
		</div>
    
    </div>

	<!-- Day off dialog -->
	<div class="modal fade" id="day-off-dialog">
         <div class="modal-dialog">
            <div class="modal-content">
        
               <div class="modal-header">
                  <h4 class="modal-title">Đơn xin nghỉ phép</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>

               <div class="modal-body">
				   <div class="row">
						<div class="col-xl-12">
							<div class="modal-off__form">
								
								<form action="" method="POST" onsubmit="return false;">
									<div class="row">
										<div class="col">
											<input type="text" class="form-control" id="maNVDayOff" placeholder="Nhập MSNV" required>
										</div>
										<div class="col">
											<input type="text" class="form-control" id="dayDayOff" placeholder="Số ngày xin nghỉ phép" required>
										</div>
										
									</div>
									<div class="row mt-2">
										<div class="col">
											<input type="text" class="form-control" id="reasonDayOff" placeholder="Lý do">
										</div>										
									</div>
									<div class="form-group">
										<div class="custom-file">
											<label for="fileDayOff">Tệp đính kèm (nếu có)</label>
											<input type="file" class="custom-file-input" id="fileDayOff">
										</div>
									</div>
									<p class="mb-0 text-center text-danger d-none empty">Please fill out all of the infomation</p>
									<div class="modal-off__footer d-flex">
										<button onclick="addDayOffForm();" type="submit" class="btn btn-success ml-auto">Gửi</button>
									</div>
								</form>								
							</div>
						</div>
				   </div>
               </div>     
            </div>
         </div>
	</div>


    <script>
		
		// function addInfoTask(e) {
		// 	e.preventDefault();

		// 	let fileTaskInput = $('#fileTaskInput').val()

		// 	// let feedbackTaskInput = $('#feedbackTaskInput').val()
			
		// 	if (fileTaskInput == '') {
		// 		$('.errorTask').removeClass('d-none')
		// 	} else {
		// 		$('.errorTask').addClass('d-none')
		// 	}

		// 	let data = {
		// 		"fileTaskInput":fileTaskInput
		// 	}

		// 	fetch(addAPIInputTask, {
		// 		'method': 'POST',
		// 		headers: {
		// 			"Content-Type": "application/json",
		// 		},
		// 		body: JSON.stringify(data)
		// 	})
		// 	.then(res => res.json())
		// 	// .then(data => {
		// 			// if (data.code === 0) {
		// 				// $('#day-off-dialog').modal('toggle')
		// 				// $('#responseMess').html(data.message);
		// 				// $('#message-respone').modal('show');
						
		// 				// $('tbody').children().remove()
		// 				// loadTasks()
		// 			// } else {
		// 				// console.log(1)
		// 				// $('#add-dialog').modal('toggle')
		// 				// $('#responseMess').html(data.message);
		// 				// $('#message-respone').modal('show');
		// 			// }
		// 		// })
		// }

    </script>
    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script>
</body>
</html>
<?php
	session_start();
	
	// Kiểm tra người dùng đã đăng nhập chưa 
	if (!isset($_SESSION['maNhanVien'])) {
		header("Location: ../login.php");
		die();
	}

	// Kiểm tra người dùng đã đổi mật khẩu chưa
	if (isset($_SESSION['doiMatKhau'])) {
        if ($_SESSION['doiMatKhau'] == 0) {
            header("Location: ../change_pwd_first.php");
            die();
        } 
    }

	// Kiểm tra người dùng có phải trưởng phòng?
    if (!$_SESSION['maChucVu'] == 'TP') {
        header("Location: /no_access.html");
    }

		
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<title>Trưởng Phòng</title>
    <style>
       
    </style>
</head>

<body>

	<div>
		<div>
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="#">Task Manager</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse " id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto"></ul>
					<?php
						?>
						<div>
							<a class="nav-link" href="../profile.php">Xin chào <?= $_SESSION['hoTen'] ?></a>
						</div>
						<div>
							<a class="font-weight-bold" href="../logout.php">Đăng xuất</a>
						</div>
					<?php
						?>
				</div>
			</nav>
		</div>
		
		<div class="row">
			<div class="col-xl-2  col-sm-12">
				<ul class="menu ">
					<li class="create-task add-task " ><a href="form_add.php" class="d-flex justify-content-between text-success"><i class="fas fa-plus-circle" ></i>   Tạo Task</a></li>
                    <div class="list-group">
                        <a href="index.php" class="list-group-item list-group-item-action activee">
                        <i class="fas fa-tasks"></i>  Tất cả Task
                        </a>
                        <a href="newTask.php" class="list-group-item list-group-item-action"><i class="fas fa-star"></i> Task Mới</a>
                        <a href="progress.php" class="list-group-item list-group-item-action "><i class="fas fa-spinner"></i> Task in progress</a>
                        <a href="waiting.php" class="list-group-item list-group-item-action"> <i class="fas fa-stopwatch"></i> Task Waiting</a>
                        <a href="rejected.php" class="list-group-item list-group-item-action"> <i class="fas fa-history"></i> Task Phản hồi</a>
                        <a href="complete.php" class="list-group-item list-group-item-action"><i class="fas fa-check-double"></i> Task Đã hoàn Thành</a>
                        <a href="canceled.php" class="list-group-item list-group-item-action"> <i class="fas fa-trash"></i> Task đã hủy</a>
                        <a href="calendar.php" class="list-group-item list-group-item-action"> <i class="fas fa-calendar-week"></i>  Đơn Nghĩ Phép</a>
                        
                       
                    </div>
				</ul>
              
			</div>
			<div class="col-xl-10  col-sm-12 ">
				<div class="d-flex">
                
					<div class="ml-auto p-2 d-flex">
						<p>Tổng số Task: </p>
						<h5 class='countTask'></h5>
					</div>
				</div>

				<div class="all-task">
					<div class="task-content">
						<table class="table able-striped border ">
                            <thead class="thead-dark">
                                <tr>
                                    <th>TRẠNG THÁI</th>
                                    <th>TÊM NHIỆM VỤ</th>
                                    <th>THỜI GIAN</th>
                                
                                </tr>
                            </thead>
                            <!-- manager list task -->
                            <tbody id='list-task'>
                        
                            </tbody>
                        </table>
					</div>
				</div>
		</div>
		</div>
			

		 <!-- add dialog -->
		<div class="modal fade" id="add-dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Add new task</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form onsubmit="addTask(event)">

                    <div class="modal-body">

                        <p class="text-center text-danger d-none empty">Please fill out all of the information of task</p>
                        <div class="form-group">
                            <label for="maNVu">Mã nhiệm vụ</label>
                            <input type="text" placeholder="Nhập mã nhiệm vụ" class="form-control" id="maNVu" required />
                        </div>
                        <div class="form-group">
                            <label for="tenNVu">Tên nhiệm vụ</label>
                            <input type="text" placeholder="Nhập tên nhiệm vụ" class="form-control" id="tenNVu" required />
                        </div>
                        <div class="form-group">
                            <label for="maNVien">mã nhân viên</label>
                            <input type="text" readonly class="form-control" id="maNVien" value=<?=$_SESSION['maNhanVien']?> />
                        </div>
                        <div class="form-group">
                            <label for="maPB">mã phòng ban</label>
                            <input type="text" readonly class="form-control" id="maPB" value=<?=$_SESSION['maPB']?> />
                        </div>
                        <!-- <div class="form-group">
                            <label for="time">hạn thực hiện</label>
                            <input type="text" placeholder="Thời gian thực hiện" class="form-control" id="time" required />
                        </div> -->

                        <div class="form-group">
                            <label for="time">Start date:</label>
                            <input type="date" id="time" name="trip-start"
                                value="2022-01-01"
                                min="2022-01-01" max="3000-12-31">
                        </div>
                        <div class="form-group">
                            <label for="moTa">mô tả</label>
                            <textarea rows="2" id="moTa" class="form-control" placeholder="Nhập mô tả" required></textarea>

                        </div>
                        <div class="form-group">
                            <input type="file" name="myFile" id="file">
                        </div>
                        <!-- <div class="form-group">
                            <label for="file">Tập tin</label>
                            <input type="text" placeholder="Chọn tập tin" class="form-control" id="file" required />
                        </div> -->
                        <div class="form-group">
                            <label for="trangThai">Trạng thái</label>
                            <input type="text" readonly class="form-control" id="trangThai" value="NEW" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- information dialog -->
    <div class="modal fade" id="info-dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">INFORMATION TASK</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tenNVu">Tên nhiệm vụ</label>
                            <p>aaaa</p>
                        </div>
                        <div class="form-group">
                            <label for="maNVien">Tên nhân viên</label>
                            <p>Phạm tùng</p>
                        </div>
                        <div class="form-group">
                            <label for="time">Thời gian thực hiện</label>
                            <p>12:20</p>
                        </div>
                        <div class="form-group">
                            <label for="moTa">mô tả</label>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum labore nam praesentium vel laudantium? Facere dignissimos eius velit magnam, deleniti sed dolorem sapiente incidunt et aliquid ipsa enim saepe adipisci.</p>
                        </div>
                        <div class="form-group">
                            <label for="file">Tệp đính kèm</label>
                            <p>aa.txt</p>
                        </div>
                        <div class="form-group">
                            <label for="trangThai">Trạng thái</label>
                            <p>NEW</p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="abc"> -->
     <!-- message respone -->
   <div class="modal fade" id="message-respone">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Notification</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <p id="responseMess"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
	<script></script>
    <script>
		const readAPI = 'http://localhost:8080/manager/api/get_task.php'
        const addAPI = 'http://localhost:8080/manager/api/add_task.php'
  // const deleteAPI = 'http://localhost/lab9/delete_product.php'
  // const updateAPI = 'http://localhost/lab9/update_product.php'

    function loadTasks() {
			const countTask = 0;
      fetch(readAPI)
        .then(response => response.json())
          .then(data => {
             
            data.forEach(task => {
               
              let tr = $('<tr></tr>')
				
              // countTask = countTask+1;
        
                // console.log(data)
                if (task.trangThai === 'IS PROGRESS'){
                    tr.html(`
                
                        <td><span class="badge mission-status-color badge-primary" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `)
                }else if (task.trangThai === 'CANCELED'){
                    tr.html(`
                
                        <td><span class="badge mission-status-color badge-danger" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `)
                }else if (task.trangThai === 'REJECTED'){
                    tr.html(`
                
                        <td><span class="badge mission-status-color badge-warning" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `)
                }else if (task.trangThai === 'WAITING'){
                    tr.html(`
                
                        <td><span class="badge mission-status-color badge-secondary" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `)
                }else if (task.trangThai === 'COMPLETED'){
                    tr.html(`
                
                        <td><span class="badge mission-status-color badge-info" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `)
                }else{
                    tr.html(`
                
                        <td><span class="badge mission-status-color badge-success" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `)
                }
                 

                $('#list-task').append(tr)
								
            })
						document.querySelector('.countTask').innerHTML = (data.length);
          })
    } 

    
		//====================thêm task mới==========================
   
// chọn ngày
	$(function(){
   $('.datepicker').datepicker({
      format: 'dd-mm-yyyy'
    });
	});
// chọn file
  
    loadTasks()
    // console.log(($('.badge').text()=='IS PROGRESS')==true)
    // if($('.badge').text()=='IS PROGRESS'){

    // }


	</script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>


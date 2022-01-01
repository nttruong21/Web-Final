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
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<title>Home Page</title>
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
					<form class="form-inline my-2 my-lg-0">
						<input class="box-search mr-sm-2" type="search" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					</form>
						<ul class="navbar-nav mr-auto">
							<li class="nav-item">
								<a class="nav-link" href="#"><i class="fas fa-cogs"></i></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#"><i class="fas fa-question-circle"></i></a>
							</li>
						</ul>
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
				<ul class="menu">
					<li class="create-task add-task " data-toggle="modal" data-target="#add-dialog"><i class="fas fa-plus-circle" ></i>   Tạo Task</li>
					<li class="create-task"><i class="fas fa-book"></i>   Tất cả Task</li>
					<li class="create-task"><i class="fas fa-star"></i>   Task Mới</li>
					<li class="create-task"><i class="fas fa-check-double"></i>   Task Đã hoàn Thành</li>
					<li class="create-task"><i class="fas fa-trash"></i>   Task đã hủy</li>
				</ul>
			</div>
			<div class="col-xl-10  col-sm-12 ">
				<div class="d-flex">
					<div class="p-2">
						<input type="checkbox" id="choose-all" name="choose-all">
						<label for="choose-all">Chọn tất cả</label>
					</div>
					<div class="p-2"><i class="fas fa-redo-alt"></i>Tải lại</div>
					<div class="ml-auto p-2 d-flex">
						<p>Tổng số Task:</p>
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
                        <th>CHỨC NĂNG</th>
                    </tr>
                </thead>
                <tbody>
            
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
                <form onsubmit="addProduct(event)">

                    <div class="modal-body">

                        <p class="text-center text-danger d-none empty">Please fill out all of the information of task</p>
                        <div class="form-group">
                            <label for="id">Mã Nhiệm Vụ</label>
                            <input type="text" placeholder="mã nhiệm vụ" class="form-control" id="id" required />
                        </div>
                        <div class="form-group">
                            <label for="name">Tên nhiệm vụ</label>
                            <input type="number" placeholder="Tên nhiệm vụ" class="form-control" id="name" required />
                        </div>
                        <div class="form-group">
                            <label for="desc">Mô tả</label>
                            <textarea rows="2" id="desc" class="form-control" placeholder="Description" required></textarea>
                        </div>
												<div class="form-group">
                            <label for="dateEx">Hạn thực hiện</label>
														<input type="text" id="dateEx" class="form-control datepicker" placeholder="chọn ngày"/>
                            
                        </div>
												<div class="form-group">
													<label for="exampleFormControlFile1">Tệp đính kèm (Nếu có)</label>
													<input type="file" class="form-control-file" id="exampleFormControlFile1">
												</div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="sumit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
	<script>
		const readAPI = 'http://localhost:8080/manager/api/get_task.php'
  // const addAPI = 'http://localhost/lab9/add_product.php'
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
                tr.html(`
                  <td>${task.trangThai}</td>
                  <td>${task.tenNhiemVu}</td>
                  <td>${task.hanThucHien}</td>
                  
									<td>
                    <button onclick="" class="btn btn-primary" data-toggle="modal" data-target="#edit-dialog">
                      <i class="fa fa-edit action"></i>
                    </button>
                    <button onclick="" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete">
                      <i class="fa fa-trash action"></i>
                    </button>
                  </td>
                `)
                $('tbody').append(tr)
								
            })
						document.querySelector('.countTask').innerHTML = (data.length);
          })
    } 
		function addProduct(e) {
            e.preventDefault()
            // let name = $('#name').val()
            // let price = $('#price').val()
            // let desc = $('#desc').val()

            // if (name == '' || price == '' || desc == '') {
            //     $('.empty').removeClass('d-none')
            //     return
            // } else {
            //     $('.empty').addClass('d-none')
            // }

            // fetch(addAPI, {
            //     'method': 'POST',
            //     'body': new URLSearchParams({
            //         name,
            //         price,
            //         desc
            //     })
            // })
            //     .then(res => res.json())
            //     .then(data => {
            //         if (data.code == 0) {
            //             $('#add-dialog').modal('toggle')
            //             $('#responseMess').html(data.message);
            //             $('#message-respone').modal('show');
                        
            //             $('tbody').children().remove()
            //             loadProduct()
            //         } else {
            //             $('#add-dialog').modal('toggle')
            //             $('#responseMess').html(data.message);
            //             $('#message-respone').modal('show');
            //         }
            //     })
        }
// chọn ngày
	$(function(){
   $('.datepicker').datepicker({
      format: 'dd-mm-yyyy'
    });
	});
// chọn file
	
    loadTasks()



	</script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>


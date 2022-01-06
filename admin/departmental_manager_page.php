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

	// Kiểm tra người dùng có phải giám đốc?
    if (!$_SESSION['maChucVu'] == 'GD') {
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
		<title>Quản lý phòng ban</title>
	</head>
	<body>
		<!-- Navigation -->
		<?php require_once("header.php"); ?>

		<!-- Content container -->
		<div class="container-fluid h-100-vh bg-image p-0">
			<div class="row py-4 m-0">
				<div class="d-flex w-100 align-items-center employee-heading">
					<div class="col-xl-4 col-lg-6 col-md-5 employee-name">
						<h4 class=""></h4>
					</div>
					<div class="col-xl-5 col-lg-4 col-md-6 col-sm-10 col-10">
						<div class="form-group border rounded-lg mb-0 bg-light">
							<form class="" methode="post">
								<div class="d-flex justify-content-between align-items-center p-1">
									<div class="task-search-input flex-fill mr-2">
										<input class="search-input outline-none border border-none rounded p-1 w-100" type="search" placeholder="Search task" aria-label="Search">
									</div>
									<div class="task-search-icon ">
										<button class="btn btn-outline-info rounded-circle" type="submit"><i class="fas fa-search"></i></button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-xl-3 col-lg-2 col-md-3 col-sm-2 col-2">
						<div class="d-inline-block">
							<button data-toggle="modal" data-target="#add-departmental-modal" class="d-flex btn btn-primary text-white align-items-center">
                                <i class="text-white fas fa-plus"></i>
								<p class="mb-0 ml-1 day-off">Thêm phòng ban</p>
							</button>
						</div>
					</div>

				</div>
			</div>
			<div class="row m-0">
				<!-- Sidebar -->
				<?php require_once("sidebar.php"); ?>

				<!-- List departmentals -->
				<div class="task-form col-lg-10">
					<div class="scrollable">
						<div class="task-heading d-flex custom-border position-sticky" >
							<div class='col-lg-2 custom-border-right'>
								<p class="mb-0 p-1">MÃ PHÒNG BAN</p>
							</div>
							<div class='col-lg-3 custom-border-right'>
								<p class="mb-0 p-1">TÊN PHÒNG BAN</p>
							</div>
							<div class='col-lg-2 custom-border-right'>
								<p class="mb-0 p-1">SỐ PHÒNG BAN</p>
							</div>
							<div class='col-lg-3 custom-border-right'>
								<p class="mb-0 p-1">MÔ TẢ</p>
							</div>
							<div class='col-lg-2 custom-border-right'>
								<p class="mb-0 p-1">TRƯỞNG PHÒNG</p>
							</div>
						</div>
						<div id="departmentals-list" class="task-information  bg-azure">
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Add departmental modal --> 
        <div class="modal fade" id="add-departmental-modal">
         <div class="modal-dialog">
            <div class="modal-content" id = "add-departmental-modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Thêm phòng ban mới</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div id="add-error-mess" class="modal-body">
                  <div class="form-group">
                     <label for="add-depart-id">Mã phòng ban</label>
                     <input type="text" name="depart-id" class="form-control" id="add-depart-id"/>
                  </div>
                  <div class="form-group">
                     <label for="add-depart-name">Tên phòng ban</label>
                     <input type="text" name="depart-name" id="add-depart-name" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="add-depart-num">Số phòng ban</label>
                     <input type="text" name="depart-num" id="add-depart-num" class="form-control">
                  </div>
				  <div class="form-group">
                     <label for="add-depart-desc">Mô tả</label>
					 <textarea name="depart-desc" class="form-control" id="add-depart-desc" cols="30" rows="3"></textarea>
                  </div>
				  <div class="form-group">
					<div id="add-depart-error" class="text-center card alert-danger font-weight-bold"></div>
				</div>
               </div>
               <div  class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button onclick="addDepartmental()" type="button" class="btn btn-success" >Thêm</button> 
               </div>         
            </div>
         </div>
        </div>

		<!-- Add success modal -->
		<div class="modal fade" id="add-departmental-success-model">
			<div class="modal-dialog modal-sm">
				<div class="modal-content" id="add-model-content">
					<div class="modal-header">
						<h4 class="modal-title">Thêm thành công</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-footer text-center">
						<button onclick="refreshPage();" type="button" class="btn btn-success">OK</button>
					</div>
				</div>
			</div>
    	</div>

		<!-- Detail departmental modal --> 
        <div class="modal fade" id="detail-departmental-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Thông tin phòng ban</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <div class="form-group">
                     <label for="detail-depart-id">Mã phòng ban</label>
                     <input disabled type="text" name="depart-id" class="form-control" id="detail-depart-id"/>
                  </div>
                  <div class="form-group">
                     <label for="detail-depart-name">Tên phòng ban</label>
                     <input disabled type="text" name="depart-name" id="detail-depart-name" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="detail-depart-num">Số phòng ban</label>
                     <input disabled type="text" name="depart-num" id="detail-depart-num" class="form-control">
                  </div>
				  <div class="form-group">
                     <label for="detail-depart-desc">Mô tả</label>
					 <textarea disabled name="depart-desc" class="form-control" id="detail-depart-desc" cols="30" rows="3"></textarea>
                  </div>
               </div>
               <div  class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
               </div>         
            </div>
         </div>
        </div>

		<!-- Edit departmental modal --> 
        <div class="modal fade" id="edit-departmental-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Cập nhật thông tin phòng ban</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div id="edit-error-mess" class="modal-body">
                  <div class="form-group">
                     <label for="edit-depart-id">Mã phòng ban</label>
                     <input disabled type="text" name="depart-id" class="form-control" id="edit-depart-id"/>
                  </div>
                  <div class="form-group">
                     <label for="edit-depart-name">Tên phòng ban</label>
                     <input type="text" name="depart-name" id="edit-depart-name" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="edit-depart-num">Số phòng ban</label>
                     <input type="text" name="depart-num" id="edit-depart-num" class="form-control">
                  </div>
				  <div class="form-group">
                     <label for="edit-depart-desc">Mô tả</label>
					 <textarea name="depart-desc" class="form-control" id="edit-depart-desc" cols="30" rows="3"></textarea>
                  </div>
               </div>
               <div  class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button onclick="editDepartmental()" type="button" class="btn btn-success" >Cập nhật</button> 
               </div>         
            </div>
         </div>
        </div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	</body>
</html>
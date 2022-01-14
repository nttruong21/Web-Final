<?php
    session_start();

    require_once('connect_db.php');
    // Kiểm tra người dùng đã đăng nhập chưa?
    if (!isset($_SESSION['maNhanVien'])) {
        header("Location: login.php");
        die();
    }

    // Kiểm tra người dùng đã đổi mật khẩu chưa?
    if ($_SESSION['doiMatKhau'] == 0) {
        header("Location: change_pwd_first.php");
        die();
    } 

    $chucVu = '';
    if(isset($_SESSION['maChucVu'])) {
        switch ($_SESSION['maChucVu']) {
            case 'GD':
                $chucVu = 'Giám Đốc';
                break;
            case 'TP':
                $chucVu = 'Trưởng phòng';
                break;
            case 'NV':
                $chucVu = 'Nhân Viên';
                break;
        }
    }
    
    // $birthDay = $_SESSION['ngaySinh'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin chi tiết</title>
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
</head>
<body>
    <!-- Navigation -->
    <div>
		<div class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between mr-2 ml-2">
			<div class="e__home-heading">
				<a href="employee/index.php"><h4>HOME</h4></a>
			</div>
			<div class="">
				<div class="navbar-header">
					<a class="" href="employee/index.php"><h4>THÔNG TIN NHÂN VIÊN</h4></a>
				</div>
			</div>
			<div class="navbar-info nav d-flex">
				<a class="font-weight-bold" href="../logout.php">Logout</a>
			</div>
			<div class="navbar-icon d-none">
				<i class="fas fa-bars"></i>
			</div>
		</div>
    </div>

    <?php
    $maNhanVien = $_SESSION["maNhanVien"];
    $sql = "SELECT * FROM NhanVien WHERE maNhanVien = '$maNhanVien'";

    $result = connect_db()->query($sql);

    while ($row = $result->fetch_assoc()) {
        $birthDay = date('Y-m-d',strtotime($row['ngaySinh']));
        $maPhongBan = $row['maPhongBan'];
        $diaChi = $row['diaChi'];
        $gioiTinh = $row['gioiTinh'];
        $soDT = $row['sdt'];
        $email = $row['email'];
    }
    ?>

    <div class="w-75 mx-auto mt-4">
        <div class="bg-light card pr-5">
            <div class="row py-4">
                <div class="col-6 py-4 d-flex flex-column justify-content-between">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="employee-id">Mã nhân viên</label>
                        <div class="col-sm-8">
                            <input disabled id="employee-id" value="<?= $_SESSION['maNhanVien'] ?>" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="department-id">Mã phòng ban</label>
                        <div class="col-sm-8">
                            <input disabled id="department-id" value="<?= $maPhongBan ?>" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="employee-birthday">Ngày sinh</label>
                        <div class="col-sm-8">
                            <input disabled id="employee-birthday" value="<?= $birthDay ?>" type="date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="employee-address">Địa chỉ</label>
                        <div class="col-sm-8">
                            <input disabled id="employee-address" value="<?= $diaChi ?>" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                    <label class="control-label text-right col-sm-4 p-0 m-0" for="employee-sex">Giới tính:</label>
                        <div class="col-sm-8 text-left">
                        <?php
                            if ($gioiTinh === 1) {
                                ?>
                                    <label class="radio-inline mb-0 mr-3"><input disabled id="male" class="mr-2" type="radio" name="employee-sex" checked>Nam</label>
                                    <label class="radio-inline mb-0"><input disabled id="female" class="mr-2" type="radio" name="employee-sex">Nữ</label>
                                <?php
                            } else {
                                ?>
                                    <label class="radio-inline mb-0 mr-3"><input disabled id="male" class="mr-2" type="radio" name="employee-sex">Nam</label>
                                    <label class="radio-inline mb-0"><input disabled id="female" class="mr-2" type="radio" name="employee-sex" checked>Nữ</label>
                                <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="employee-number">Số điện thoại</label>
                        <div class="col-sm-8">
                            <input disabled id="employee-number" value="<?= $soDT ?>" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="employee-email">Email</label>
                        <div class="col-sm-8">
                            <input disabled id="employee-email" value="<?= $email ?>" type="email" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-6 d-flex flex-column justify-content-between">
                    <!-- <div class="d-flex mb-4 w-75 mx-auto flex-row-reverse align-items-center justify-content-between">
                        <div class="">
                            <button onclick="enableEditAdminProfileMode();" class="btn btn-secondary mr-4">Chỉnh sửa</button>
                            <button data-toggle="modal" data-target="#change-employee-avatar-modal" class="btn btn-primary mr-4">Đổi ảnh đại diện</button>
                            <a href="handle_update_admin_pass.php" class="btn btn-info">Đổi mật khẩu</a>
                        </div>
                    </div> -->
                    <div class="card m-auto" style="width: 300px;">
                        <img class="card-img-top mx-auto" style="width: 200px;" src="https://static.vecteezy.com/system/resources/thumbnails/000/439/863/small/Basic_Ui__28186_29.jpg" alt="User image">
                        <div class="card-body">
                            <h3 class="card-title"><?= $_SESSION['hoTen'] ?></h3>
                            <p class="card-text">Chức vụ: <?= $chucVu ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Dialog đổi ảnh đại diện -->
    <div class="modal fade" id="change-employee-avatar-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đổi ảnh đại diện</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="handle_change_admin_avatar.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="custom-file">
                            <input name="admin-avatar" type="file" class="custom-file-input" id="admin-avatar">
                            <label class="custom-file-label" for="admin-avatar">Choose file</label>
                        </div>
                        <div class="form-group mt-3">
                            <div id="change-admin-avatar-error-message" class="text-center alert-danger font-weight-bold"></div>
                        </div>
                    </div>
                    <div  class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>
                        <button onclick="handleChangeAdminAvatar(event);" type="submit" class="btn btn-primary">Thay đổi</button>
                    </div>   
                </form>      
            </div>
        </div>
    </div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<script src="/main.js"></script> 


</body>
</html>
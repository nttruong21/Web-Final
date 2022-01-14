<?php
    session_start();

    require_once('../connect_db.php');
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
    
    $conn = connect_db();
    $sql = "SELECT * FROM NhanVien";
    $result = $conn -> query($sql);
    if ($conn -> connect_error) {
        die("Không thể lấy thông tin giám đốc " . $conn -> connect_error);
    }
    $employee_account = $result->fetch_assoc();
    // print_r($admin_account);
    // print_r($admin_account['gioiTinh'] == 1);
    $avatar_path = "../images/" . $employee_account['anhDaiDien'];


    if (isset($_POST['submit'])) {
        $message = '';
        if (!isset($_POST['employee-birthday']) || !isset($_POST['employee-address']) || !isset($_POST['employee-sex']) ||
        !isset($_POST['employee-number']) || !isset($_POST['employee-email'])) {
            $message = "Vui lòng nhập đầy đủ thông tin";
            die($message);
        } else {

            $employee_id = $_SESSION['maNhanVien'];
            $employee_birthday = $_POST['employee-birthday'];
            $employee_address = $_POST['employee-address'];
            $employee_sex = $_POST['employee-sex'];
            $employee_number = $_POST['employee-number'];
            $employee_email = $_POST['employee-email'];

            $sql = "UPDATE NhanVien SET ngaySinh = ?, gioiTinh = ?, diaChi = ?, sdt = ?, email = ? WHERE maNhanVien = '$employee_id' ";
            $conn = connect_db();
            $stm = $conn->prepare($sql);
            $stm -> bind_param("sisss", $employee_birthday, $employee_sex, $employee_address, $employee_number, $employee_email);
            $stm -> execute();

            if ($stm->affected_rows == 1) {
                header("Location: profileTP.php");
            }
        }
    }
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
<style>
    .card-employee {
       width: 300px;
    }
    .card-img-employee {
        width: 200px;
    }
</style>
<body>
    <!-- Navigation -->
    <div>
		<div class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between mr-2 ml-2">
			<div class="e__home-heading">
				<a href="index.php"><h4>HOME</h4></a>
			</div>
			<div class="">
				<div class="navbar-header">
					<a class="" href="#"><h4>THÔNG TIN NHÂN VIÊN</h4></a>
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

    <div class="d-flex mt-2 mb-2 w-75 mx-auto flex-row-reverse align-items-center justify-content-between">
        <div class="">
            <button onclick="enableEditEmployeeProfileMode();" class="btn btn-secondary mr-4">Chỉnh sửa</button>
            <button data-toggle="modal" data-target="#change-employee-avatar-modal" class="btn btn-primary mr-4">Đổi ảnh đại diện</button>
            <!-- <a href="handle_update_admin_pass.php" class="btn btn-info">Đổi mật khẩu</a> -->
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
                    <form action="" method="POST">

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
                                <input disabled id="employee-birthday" name="employee-birthday" value="<?= $birthDay ?>" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label class="control-label text-right col-sm-4 p-0 m-0" for="employee-address">Địa chỉ</label>
                            <div class="col-sm-8">
                                <input disabled id="employee-address" name="employee-address" value="<?= $diaChi ?>" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="employee-sex">Giới tính:</label>
                            <div class="col-sm-8 text-left">
                            <?php
                                if (intval($gioiTinh) === 1 ) {
                                    ?>
                                    
                                        <label class="radio-inline mb-0 mr-3"><input disabled id="male" value="1" class="mr-2" type="radio" name="employee-sex" checked>Nam</label>
                                        <label class="radio-inline mb-0"><input disabled id="female" value="0" class="mr-2" type="radio" name="employee-sex">Nữ</label>
                                    <?php
                                } else {
                                    ?>
                                        <label class="radio-inline mb-0 mr-3"><input disabled id="male" value="1" class="mr-2" type="radio" name="employee-sex">Nam</label>
                                        <label class="radio-inline mb-0"><input disabled id="female" value="0" class="mr-2" type="radio" name="employee-sex" checked>Nữ</label>
                                    <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label class="control-label text-right col-sm-4 p-0 m-0" for="employee-number">Số điện thoại</label>
                            <div class="col-sm-8">
                                <input disabled id="employee-number" name="employee-number" value="<?= $soDT ?>" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label class="control-label text-right col-sm-4 p-0 m-0" for="employee-email">Email</label>
                            <div class="col-sm-8">
                                <input disabled id="employee-email" name="employee-email" value="<?= $email ?>" type="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="submit" disabled id="btn-confirm-edit-employee-profile" class="btn btn-primary">Xác nhận</button>
                        </div>
                    </form>
                </div>
                <div class="col-6 d-flex border-none border rounded">              
                    <div class="card-employee w-100 m-auto">
                        <img class="card-img-employee w-100" src= <?= $avatar_path ?> alt="User image">
                        <div class="card-body-employee">
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
                <form action="handle_change_employee_avatar.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="custom-file">
                            <input name="employee-avatar" type="file" class="custom-file-input" id="employee-avatar">
                            <label class="custom-file-label" for="employee-avatar">Choose file</label>
                        </div>
                        <div class="form-group mt-3">
                            <?php
                                require_once('handle_change_employee_avatar.php');
                            ?>
                            <div id="change-employee-avatar-error-message" class="text-center alert-danger font-weight-bold"><?= implode($errors)  ?></div>
                        </div>
                    </div>
                    <div  class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>
                        <button type="submit" class="btn btn-primary">Thay đổi</button>
                    </div>   
                </form>      
            </div>
        </div>
    </div>


     <!-- Dialog xác nhận cập nhật thông tin
     <div id="confirm-edit-employee-profile-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                    <h4 class="modal-title">Cập nhật thông tin</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc rằng muốn cập nhật thông tin nhân viên <strong><?= $_SESSION['hoTen'] ?></strong> không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" name="submit-info" class="btn btn-danger">Đồng ý</button>
                </div>
            </div>
        </div>
    </div> -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<script src="/main.js"></script> 
 

</body>
</html>
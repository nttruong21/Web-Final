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

	<?php 
    require_once("employee/employee_heading.php"); 

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
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="user-id">Mã nhân viên</label>
                        <div class="col-sm-8">
                            <input disabled id="user-id" value="<?= $_SESSION['maNhanVien'] ?>" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="department-id">Mã phòng ban</label>
                        <div class="col-sm-8">
                            <input disabled id="department-id" value="<?= $maPhongBan ?>" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="user-birthday">Ngày sinh</label>
                        <div class="col-sm-8">
                            <input disabled id="user-birthday" value="<?= $birthDay ?>" type="date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="user-address">Địa chỉ</label>
                        <div class="col-sm-8">
                            <input disabled id="user-address" value="<?= $diaChi ?>" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                    <label class="control-label text-right col-sm-4 p-0 m-0" for="sex">Giới tính:</label>
                        <div class="col-sm-8 text-left">
                        <?php
                            if ($gioiTinh === 1) {
                                ?>
                                    <label class="radio-inline mb-0 mr-3"><input disabled id="male" class="mr-2" type="radio" name="sex" checked>Nam</label>
                                    <label class="radio-inline mb-0"><input disabled id="female" class="mr-2" type="radio" name="sex">Nữ</label>
                                <?php
                            } else {
                                ?>
                                    <label class="radio-inline mb-0 mr-3"><input disabled id="male" class="mr-2" type="radio" name="sex">Nam</label>
                                    <label class="radio-inline mb-0"><input disabled id="female" class="mr-2" type="radio" name="sex" checked>Nữ</label>
                                <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="depart-id">Số điện thoại</label>
                        <div class="col-sm-8">
                            <input disabled id="depart-id" value="<?= $soDT ?>" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="depart-id">Email</label>
                        <div class="col-sm-8">
                            <input disabled id="depart-id" value="<?= $email ?>" type="email" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-6 d-flex flex-column justify-content-between">
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
</body>
</html>
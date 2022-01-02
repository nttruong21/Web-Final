<?php
    session_start();
    // Kiểm tra người dùng đã đăng nhập chưa
    if (!isset($_SESSION['maNhanVien'])) {
        header("Location: /login.php");
        die();
    }

    // Kiểm tra người dùng đã đổi mật khẩu chưa
    if (isset($_SESSION['doiMatKhau'])) {
        if ($_SESSION['doiMatKhau'] == 0) {
            header("Location: /change_pwd_first.php");
            die();
        }
    }

    // Kiểm tra người dùng có phải giám đốc?
    if (!$_SESSION['maChucVu'] == 'GD') {
        header("Location: /no_access.html");
    }

    if($_GET['maNhanVien']) {
        $user_id = $_GET['maNhanVien'];
        require_once("account_db.php");
        $result = get_account($user_id);
        $name = $result['hoTen'];
        $birthday = $result['ngaySinh'];
        $sex = $result['gioiTinh'];
        $phone = $result['sdt'];
        $address = $result['diaChi'];
        $email = $result['email'];
        $position_id = $result['maChucVu'];
        $departmental_id = $result['maPhongBan'];
        $num_day = $result['soNgayNghi'];

        // Lấy danh sách phòng ban và phòng ban hiện tại của nhân viên
        require_once("../departmental/departmental_db.php");
        $curr_departmental_name = get_departmental($departmental_id)['tenPhongBan'];
        $curr_departmental = $departmental_id . " - " . $curr_departmental_name;
        $get_departmentals = get_departmentals();
        $departmentals = array();
        // print_r($get_departmentals);
        // print_r(count($get_departmentals));
        for($i = 0; $i < count($get_departmentals); $i++) {
            $departmentals[] = $get_departmentals[$i]['maPhongBan'] . " - " . $get_departmentals[$i]['tenPhongBan'];
        }
        // print_r($departmentals);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style.css">
    <title>Thông tin nhân viên</title>
</head>

<body>
    <!-- Navigation -->
	<?php require_once("../header.php"); ?>
    
    <div class="container text-center">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-center">
                <h2 class="my-4">Thông tin nhân viên</h2>
            </div>
            <div class="">
                <button id="btn-reset-account-password" data-toggle="modal" data-target="#confirm-reset-account-password-model" class="btn btn-secondary mr-4">Đặt lại mật khẩu</button>
                <button id="btn-enable-edit-account" class="btn btn-primary mr-4">Chỉnh sửa</button>
                <button id="btn-delele-account" class="btn btn-danger">Xóa</button>
            </div>
        </div>
        <form onsubmit="return false;" id="form-add-account" class="bg-light card pr-5" action="" method="POST">
            <div class="row my-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="user-id">Mã nhân viên:</label>
                        <div class="col-sm-8">
                            <input disabled id="user-id" value="<?= $user_id ?>" name="user-id" type="text" class="form-control" placeholder="Nhập mã nhân viên">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0" for="address">Địa chỉ:</label>
                        <div class="col-sm-8">
                            <input disabled id="address" value="<?= $address ?>" name="address" type="text" class="form-control" placeholder="Nhập địa chỉ">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="name">Họ tên:</label>
                        <div class="col-sm-8">
                            <input disabled id="name" value="<?= $name ?>" name="name" type="text" class="form-control" placeholder="Nhập họ tên">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0" for="email">Email:</label>
                        <div class="col-sm-8">
                            <input disabled id="email" value="<?= $email ?>" name="email" type="email" class="form-control" placeholder="Nhập email">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="birthday">Ngày sinh:</label>
                        <div class="col-sm-8">
                            <input disabled id="birthday" value="<?= $birthday ?>" name="birthday" type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label for="position" class="control-label text-right col-sm-4 m-0 p-0" for="email">Chức vụ:</label>
                        <div class="col-sm-8">
                            <select disabled id="position" name="position" class="form-control" id="position">
                                <?php
                                    if($position_id === 'NV') {
                                        ?>
                                            <option selected>NV - Nhân viên</option>
                                            <option>TP - Trưởng phòng</option>
                                        <?php
                                    } else {
                                        ?>
                                            <option>NV - Nhân viên</option>
                                            <option selected>TP - Trưởng phòng</option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="sex">Giới tính:</label>
                        <div class="col-sm-8 text-left">
                            <?php
                                if ($sex === 1) {
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
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0" for="departmental">Phòng ban:</label>
                        <div class="col-sm-8">
                            <select disabled id="departmental" name="departmental" class="form-control" >
                                <?php
                                    for($i = 0; $i < count($departmentals); $i++) {
                                        if ($curr_departmental === $departmentals[$i]) {
                                            ?>
                                                <option selected><?= $departmentals[$i] ?></option>
                                            <?php
                                        } else {
                                            ?>
                                                <option ><?= $departmentals[$i] ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="phone-number">Số điện thoại:</label>
                        <div class="col-sm-8">
                            <input disabled id="phone-number" value="<?= $phone ?>" name="phone-number" type="number" class="form-control" placeholder="Nhập số điện thoại">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="num-day">Số ngày nghỉ:</label>
                        <div class="col-sm-8">
                            <input disabled id="num-day" value="<?= $num_day ?>" name="num-day" type="number" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div id="error-message" class="form-group">

            </div>
            <div class="form-group text-center">
                <button disabled type="submit" id="btn-confirm-edit-account" class="btn btn-primary">Xác nhận</button>
            </div>
        </form>
    </div>

    <!-- Dialog xác nhận cập nhật nhân viên -->
    <div id="confirm-edit-account-model" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                        <h4 class="modal-title">Cập nhật thông tin nhân viên</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc rằng muốn cập nhật thông tin nhân viên <strong><?= $name ?></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                        <button type="button" id="btn-edit-account-sure" class="btn btn-danger">Đồng ý</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialog xác nhập xóa thông tin nhân viên -->
        <div id="confirm-delete-account-model" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Xóa thông tin nhân viên</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc rằng muốn xóa nhân viên <strong><?= $name ?></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                        <button type="button" id="btn-confirm-delete-account" class="btn btn-danger">Đồng ý</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialog xác nhận đặt lại mật khẩu -->
        <div id="confirm-reset-account-password-model" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Đặt lại mật khẩu</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc rằng muốn đặt lại mật khẩu của nhân viên <strong><?= $name ?></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                        <button type="button" id="btn-confirm-reset-account-pass" class="btn btn-danger">Đồng ý</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Dialog đặt lại mật khẩu thành công -->
    <div class="modal fade" id="reset-pass-success-model">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="add-model-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đặt lại mật khẩu thành công</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" id="btn-reset-pass-complete" class="btn btn-success">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dialog cập nhật thông tin nhân viên thành công -->
    <div class="modal fade" id="update-account-success-model">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="add-model-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cập nhật thành công</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" id="btn-update-account-success" class="btn btn-success">OK</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>

</body>

</html>

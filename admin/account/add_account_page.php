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

    // Lấy danh sách phòng ban 
    require_once("../departmental/departmental_db.php");
    $get_departmentals = get_departmentals();
    $departmentals = array();
    // print_r($get_departmentals);
    // print_r(count($get_departmentals));
    for($i = 0; $i < count($get_departmentals); $i++) {
        $departmentals[] = $get_departmentals[$i]['maPhongBan'] . " - " . $get_departmentals[$i]['tenPhongBan'];
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
    <title>Thêm thông tin nhân viên</title>
</head>

<body>
    <nav class="navbar navbar-light bg-primary d-flex">
        <a class="navbar-brand ml-5" href="../index.php">
            <span class="text-white">TRANG CHỦ</span>
        </a>
        <div class="d-flex">
            <a href="/profile.php"><span class="text-white">THÔNG TIN CHI TIẾT</span></a>
            <a class="mx-5" href="/logout.php"><span class="text-white">ĐĂNG XUẤT</span></a>
        </div>
    </nav>
    <div class="container text-center">
        <div class="text-center">
            <h2 class="my-4">Thêm thông tin nhân viên</h2>
        </div>
        <form id="form-add-account" class="bg-light card pr-5" action="add_account.php" method="POST">
            <div class="row my-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="user-id">Mã nhân viên:</label>
                        <div class="col-sm-8">
                            <input id="user-id" name="user-id" type="text" class="form-control" placeholder="Nhập mã nhân viên">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0" for="address">Địa chỉ:</label>
                        <div class="col-sm-8">
                            <input id="address" name="address" type="text" class="form-control" placeholder="Nhập địa chỉ">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="name">Họ tên:</label>
                        <div class="col-sm-8">
                            <input id="name" name="name" type="text" class="form-control" id="" placeholder="Nhập họ tên">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0" for="email">Email:</label>
                        <div class="col-sm-8">
                            <input id="email" name="email" type="email" class="form-control" id="" placeholder="Nhập email">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="birthday">Ngày sinh:</label>
                        <div class="col-sm-8">
                            <input id="birthday" name="birthday" type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label for="position" class="control-label text-right col-sm-4 m-0 p-0" for="email">Chức vụ:</label>
                        <div class="col-sm-8">
                            <select id="position" name="position" class="form-control" id="position">
                                <option>NV - Nhân viên</option>
                                <option>TP - Trưởng phòng</option>
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
                            <label class="radio-inline mr-3"><input id="male" class="mr-2" type="radio" name="sex" value="1" checked>Nam</label>
                            <label class="radio-inline"><input id="female" class="mr-2" type="radio" name="sex" value="0">Nữ</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0" for="departmental">Phòng ban:</label>
                        <div class="col-sm-8">
                            <select id="departmental" name="departmental" class="form-control" id="departmental">
                            <?php
                                    for($i = 0; $i < count($departmentals); $i++) {
                                        ?>
                                        <option ><?= $departmentals[$i] ?></option>
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
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="phone-number">Số điện thoại:</label>
                        <div class="col-sm-8">
                            <input id="phone-number" name="phone-number" type="number" class="form-control" placeholder="Nhập số điện thoại">
                        </div>
                    </div>
                </div>
            </div>
            <div id="add-error-message" class="form-group">

            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Xác nhận</button>
            </div>
        </form>
    </div>

    <!-- Dialog thêm nhân viên thành công -->
    <div class="modal fade" id="success-model">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="add-model-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm thành công</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" id="btn-add-confirm" class="btn btn-success">OK</button>
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

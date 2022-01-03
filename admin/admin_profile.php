<?php
    session_start();

    // Kiểm tra người dùng đã đăng nhập chưa?
    if (!isset($_SESSION['maNhanVien'])) {
        header("Location: /login.php");
        die();
    }

    // Kiểm tra người dùng đã đổi mật khẩu chưa?
    if ($_SESSION['doiMatKhau'] == 0) {
        header("Location: /change_pwd_first.php");
        die();
    } 

    // Kiểm tra người dùng có phải giám đốc?
    if (!$_SESSION['maChucVu'] == 'GD') {
        header("Location: /no_access.html");
    }

    require_once("../connect_db.php");
    $conn = connect_db();
    $sql = "SELECT * FROM GiamDoc";
    $result = $conn -> query($sql);
    if ($conn -> connect_error) {
        die("Không thể lấy thông tin giám đốc " . $conn -> connect_error);
    }
    $admin_account = $result->fetch_assoc();
    // print_r($admin_account);
    // print_r($admin_account['gioiTinh'] == 1);
    $avatar_path = "../images/" . $admin_account['anhDaiDien'];
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
	<?php require_once("header.php"); ?>
    
    <div class="d-flex my-4 w-75 mx-auto flex-row-reverse align-items-center justify-content-between">
        <div class="">
            <button onclick="enableEditAdminProfileMode();" class="btn btn-secondary mr-4">Chỉnh sửa</button>
            <button data-toggle="modal" data-target="#change-admin-avatar-modal" class="btn btn-primary mr-4">Đổi ảnh đại diện</button>
            <a href="handle_update_admin_pass.php" class="btn btn-info">Đổi mật khẩu</a>
        </div>
    </div>
    <div class="w-75 mx-auto">
        <div class="bg-light card">
            <div class="row py-4">
                <div class="col-6 py-4 d-flex flex-column justify-content-between">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="admin-id">Mã nhân viên</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-id" value="<?= $admin_account['maNhanVien'] ?>" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="admin-name">Họ tên</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-name" value="<?= $admin_account['hoTen'] ?>" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="admin-birthday">Ngày sinh</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-birthday" value="<?= $admin_account['ngaySinh'] ?>" type="date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="admin-address">Địa chỉ</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-address" value="<?= $admin_account['diaChi'] ?>" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                    <label class="control-label text-right col-sm-4 p-0 m-0" for="sex">Giới tính:</label>
                        <div class="col-sm-8 text-left">
                        <?php
                            if ($admin_account['gioiTinh'] == 1) {
                                ?>
                                    <label class="radio-inline mb-0 mr-3"><input disabled id="admin-male" class="mr-2" type="radio" name="sex" checked>Nam</label>
                                    <label class="radio-inline mb-0"><input disabled id="admin-female" class="mr-2" type="radio" name="sex">Nữ</label>
                                <?php
                            } else {
                                ?>
                                    <label class="radio-inline mb-0 mr-3"><input disabled id="admin-male" class="mr-2" type="radio" name="sex">Nam</label>
                                    <label class="radio-inline mb-0"><input disabled id="admin-female" class="mr-2" type="radio" name="sex" checked>Nữ</label>
                                <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="admin-phone">Số điện thoại</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-phone" value="<?= $admin_account['sdt'] ?>" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="admin-email">Email</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-email" value="<?= $admin_account['email'] ?>" type="email" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-6 d-flex flex-column justify-content-between">
                    <div class="card m-auto" style="width: 300px;">
                        <img class="card-img-top mx-auto w-100" src="<?= $avatar_path ?>" alt="admin image">
                        <div class="card-body">
                            <h3 class="card-title"><?= $admin_account['hoTen'] ?></h3>
                            <p class="card-text">Chức vụ: Giám đốc</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button data-toggle="modal" data-target="#confirm-edit-admin-profile-modal" disabled id="btn-confirm-edit-admin-profile" class="btn btn-primary">Xác nhận</button>
            </div>
        </div>
    </div>

    <!-- Dialog xác nhận cập nhật thông tin-->
    <div id="confirm-edit-admin-profile-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                    <h4 class="modal-title">Cập nhật thông tin</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc rằng muốn cập nhật thông tin giám đốc <strong><?= $_SESSION['hoTen'] ?></strong> không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button type="button" onclick="updateAdminProfile();" class="btn btn-danger">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dialog cập nhật thông tin giám đốc thành công -->
    <div class="modal fade" id="update-account-admin-success-modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="add-model-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cập nhật thành công</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" onclick="refreshPage();" class="btn btn-success">OK</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dialog thay đổi mật khẩu -->
    <div class="modal fade" id="change-pass-admin-account-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thay đổi mật khẩu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="handle_update_admin_pass.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="change-pass-admin-account-old-pass">Mật khẩu cũ</label>
                            <input type="text" class="form-control" name="old-pass" id="change-pass-admin-account-old-pass"/>
                        </div>
                    <div class="form-group">
                        <label for="change-pass-admin-account-new-pass">Mật khẩu mới</label>
                        <input type="text" name="new-pass" id="change-pass-admin-account-new-pass" class="form-control">
                    </div>
                        <div class="form-group">
                            <label for="change-pass-admin-account-new-pass-again">Nhập lại mật khẩu mới</label>
                            <input type="text" name="confirm-pass" id="change-pass-admin-account-new-pass-again" class="form-control">
                        </div>
                        <div id="update-admin-pass-error-message" class="form-group">
                        </div>
                    </div>
                    <div  class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>
                        <button onclick="handleUpdateAdminAccountPass();" type="button" class="btn btn-primary">Thay đổi</button>
                    </div>   
                </form>      
            </div>
        </div>
    </div>

    <!-- Dialog đổi ảnh đại diện -->
    <div class="modal fade" id="change-admin-avatar-modal">
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
    <script src="/main.js"></script>
</body>
</html>
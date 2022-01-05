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

    // print_r($_GET['maDon']);
    // print_r($_GET['hoTen']);

    $id = $_GET['maDon'];
    $hoTen = $_GET['hoTen'];
    $soNgayNghi = 0;
    $trangThai = "Chưa xử lý";
    $lyDo = "";
    $ngayTao = "";  
    $tapTin = "";
    $ketQua = "";
    if($id) {
        require_once("application_db.php");
        $app = get_application($id);
        if ($app) {
            $soNgayNghi = $app['soNgayNghi'];
            if (intval($app['trangThai']) === 1) {
                $trangThai = "Đã xử lý";    
                if (intval($app['ketQua']) === 1) {
                    $ketQua = "Thành công";    
                } else if (intval($app['ketQua']) === 0) {
                    $ketQua = "Không thành công";   
                }
            }
            $lyDo = $app['lyDo'];
            $ngayTao = $app['ngayTao'];  
            $tapTin = $app['tapTin'];
        }
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
    <title>Thông tin đơn xin nghỉ phép</title>
</head>

<body class="">
    <!-- Navigation -->
	<?php require_once("../header.php"); ?>
    
    <div class="container-fluid px-108 h-100-vh bg-image text-center">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-center">
                <h2 class="my-4">Thông tin đơn xin nghỉ phép</h2>
            </div>
            <div class="">
                <?php
                    if ($trangThai == "Chưa xử lý") {
                        ?>
                            <button data-toggle="modal" data-target="#choose-app-result-modal" class="btn btn-primary mr-4">Duyệt đơn</button>
                        <?php
                    } else {
                        ?>
                            <button disabled data-toggle="modal" data-target="#choose-app-result-modal" class="btn btn-primary mr-4">Duyệt đơn</button>
                        <?php
                    }
                ?>
                
            </div>
        </div>
        <form onsubmit="return false;" id="form-add-account" class="bg-light card pr-5" action="" method="POST">
            <div class="row my-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="admin-app-id">Mã đơn:</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-app-id" value="<?= $id ?>" name="admin-app-id" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0" for="admin-app-name">Họ tên:</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-app-name" value="<?= $hoTen ?>" name="admin-app-name" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="admin-app-num">Số ngày nghỉ:</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-app-num" value="<?= $soNgayNghi ?>" name="admin-app-num" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0" for="admin-app-status">Trạng thái:</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-app-status" value="<?= $trangThai ?>" name="admin-app-status" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="admin-app-reason">Lý do:</label>
                        <div class="col-sm-8">
                            <input disabled id="admin-app-reason" value="<?= $lyDo ?>" name="admin-app-reason" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0">Ngày tạo:</label>
                        <div class="col-sm-8">
                            <input disabled value="<?= $ngayTao ?>" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0">Tập tin:</label>
                        <div class="col-sm-8 text-left font-italic">
                            <!-- <input download value="<?= $tapTin ?>" type="text" class="form-control"> -->
                            <a target="blank" href="/files/<?= $tapTin ?>"><?= $tapTin ?></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0">Kết quả:</label>
                        <div class="col-sm-8">
                            <input disabled value="<?= $ketQua ?>" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Dialog lựa chọn phê duyệt-->
    <div id="choose-app-result-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                        <h4 class="modal-title">Phê duyệt đơn xin nghỉ phép</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Vui lòng phê duyệt đơn xin nghỉ phép của <strong><?= $hoTen ?></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button data-toggle="modal" data-dismiss="modal" data-target="#confirm-disagree-leave-app-modal" type="button" class="btn btn-danger">Không đồng ý</button>
                        <button data-toggle="modal" data-dismiss="modal" data-target="#confirm-agree-leave-app-modal" type="button" id="btn-edit-account-sure" class="btn btn-primary">Đồng ý</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialog xác nhập kết quả Đồng ý -->
        <div id="confirm-agree-leave-app-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Phê duyệt đơn xin nghỉ phép</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc với quyết định <strong>Đồng ý</strong> của mình?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                        <button  onclick="agreeLeaveApp(<?= $id ?>);"  type="button" id="btn-confirm-delete-account" class="btn btn-danger">Đồng ý</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialog xác nhập kết quả Không đồng ý -->
        <div id="confirm-disagree-leave-app-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Phê duyệt đơn xin nghỉ phép</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <p>Bạn có chắc với quyết định <strong>Không đồng ý</strong> của mình?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                        <button onclick="disagreeLeaveApp(<?= $id ?>);" type="button" id="btn-confirm-delete-account" class="btn btn-danger">Đồng ý</button>
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

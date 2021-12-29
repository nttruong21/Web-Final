<?php
    session_start();

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
            case 'QL':
                $chucVu = 'Quản Lý';
                break;
            case 'NV':
                $chucVu = 'Nhân Viên';
                break;
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
<body>
    <div class="card mx-auto mt-5" style="width: 18rem;">
    <img class="card-img-top" src="https://static.vecteezy.com/system/resources/thumbnails/000/439/863/small/Basic_Ui__28186_29.jpg" alt="User image">
    <div class="card-body">
        <h3 class="card-title"><?= $_SESSION['hoTen'] ?></h3>
        <p class="card-text">Chức vụ: <?= $chucVu ?></p>
        <a href="#" class="btn btn-primary">Liên hệ</a>
        <a class="btn btn-primary" href="index.php">Quay lại</a>
    </div>
    </div>
</body>
</html>
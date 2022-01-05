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

    if($_GET['id']) {
        $id = $_GET['id'];
        require_once("departmental_db.php");
        // Lấy thông tin phòng ban 
        $result = get_departmental($id);
        $name = $result['tenPhongBan'];
        $num = $result['soPhongBan'];
        $desc = $result['moTa'];
        $manager_id = $result['truongPhong'];

        // Lấy thông tin của trưởng phòng 
        require_once("../account/account_db.php");
        $manager_info = get_account($manager_id);
        // print_r($manager_info);
        // if(empty($manager_info)) {
        //     $manager_id = "";
        // }

        // Lấy danh sách nhân viên (không bao gồm trưởng phòng) của phòng ban hiện tại
        $accounts = get_employee_accounts_by_depart_id($id);
        // print_r($accounts);
        
        $employees = array();
        for($i = 0; $i < count($accounts); $i++) {
            $employees[] = $accounts[$i]['maNhanVien'] . " - " . $accounts[$i]['hoTen'];
        }
        // print_r($employee_names);
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
    <title>Thông tin phòng ban</title>
</head>

<body>
    <!-- Navigation -->
	<?php require_once("../header.php"); ?>

    <div class="container-fluid px-108 h-100-vh bg-image text-center">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-center">
                <h2 class="my-4">Thông tin phòng ban</h2>
            </div>
            <div class="">
                <button id="btn-add-manager-to-departmental" data-toggle="modal" data-target="#assigned-manager-to-departmental-modal" class="btn btn-secondary mr-4">Bổ nhiệm trưởng phòng</button>
                <button onclick="enableEditDepartmental();" id="btn-enable-edit-departmental" class="btn btn-primary mr-4">Chỉnh sửa</button>
                <button data-toggle="modal" data-target="#confirm-delete-departmental-modal" class="btn btn-danger">Xóa</button>
            </div>
        </div>
        <form onsubmit="return false;" id="form-add-account" class="bg-light card pr-5" action="" method="POST">
            <div class="row my-4">
            <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="depart-manager">Trưởng phòng</label>
                        <div class="col-sm-8">
                            <?php
                                if(empty($manager_id)) {
                                    ?>
                                        <input disabled id="depart-manager" value="Không có" name="depart-manager" type="text" class="form-control">
                                    <?php
                                } else {
                                    ?>
                                        <input disabled id="depart-manager" value="<?= $manager_info['hoTen'] ?>" name="depart-manager" type="text" class="form-control">
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="depart-id">Mã phòng ban</label>
                        <div class="col-sm-8">
                            <input disabled id="depart-id" value="<?= $id ?>" name="depart-id" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 m-0 p-0" for="depart-num">Số phòng ban:</label>
                        <div class="col-sm-8">
                            <input disabled id="depart-num" value="<?= $num ?>" name="depart-num" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="depart-name">Tên phòng ban:</label>
                        <div class="col-sm-8">
                            <input disabled id="depart-name" value="<?= $name ?>" name="depart-name" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row align-items-center">
                        <label class="control-label text-right col-sm-4 p-0 m-0" for="depart-desc">Mô tả:</label>
                        <div class="col-sm-8">
                            <input disabled id="depart-desc" value="<?= $desc ?>" name="depart-desc" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div id="error-message" class="form-group">

            </div>
            <div class="form-group text-center">
                <button data-toggle="modal" data-target="#confirm-edit-departmental-modal" disabled type="submit" id="btn-confirm-edit-depart" class="btn btn-primary">Xác nhận</button>
            </div>
        </form>
    </div>

    <!-- Confirm delete departmental modal -->
    <div id="confirm-delete-departmental-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Xóa thông tin phòng ban</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc rằng muốn xóa phòng ban này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button onclick="confirmDeleteDepartmental('<?= $id ?>');" type="button" class="btn btn-danger">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm edit departmental modal -->
    <div id="confirm-edit-departmental-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cập nhật thông tin phòng ban <?= $name ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc rằng muốn cập nhật thông tin phòng ban này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button onclick="ConfirmEditDepartmental();" id="btn-confirm-edit-departmental" type="button" class="btn btn-danger">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>

		<!-- Edit departmental success modal -->
		<div class="modal fade" id="edit-departmental-success-model">
			<div class="modal-dialog modal-sm">
				<div class="modal-content" id="add-model-content">
					<div class="modal-header">
						<h4 class="modal-title">Cập nhật thông tin phòng ban <?= $name ?> thành công</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-footer text-center">
						<button onclick="refreshPage();" type="button" class="btn btn-success">OK</button>
					</div>
				</div>
			</div>
    	</div>

        <!-- Assign manager to departmental modal --> 
        <div class="modal fade" id="assigned-manager-to-departmental-modal">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Bổ nhiệm trưởng phòng cho phòng ban <?= $name ?></h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div id="edit-error-mess" class="modal-body">
                  <div class="form-group">
                     <label for="choose-manager-depart">Chọn nhân viên</label>
                     <select id="choose-manager-depart" class="form-control" >
                        <?php
                            for($i = 0; $i < count($employees); $i++) { 
                            ?>
                                <option><?= $employees[$i] ?></option>
                            <?php
                            }
                        ?>
                    </select>
                  </div>
               </div>
               <div  class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button onclick="showConfirmAssignedManagerDepartmentalModal()" data-toggle="modal" data-target="#confirm-assigned-manager-departmental-modal" type="button" class="btn btn-success" >Lưu</button> 
               </div>         
            </div>
         </div>
        </div>

    <!-- Confirm assign manager to departmental modal -->
    <div id="confirm-assigned-manager-departmental-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="confirm-assigned-manager-departmental-modal-header" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                    <button onclick="confirmAssignedManager();" type="button" class="btn btn-danger">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>

        <!-- Assign manager to departmental success modal -->
		<div class="modal fade" id="assigned-manager-departmental-success-model">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Bổ nhiệm trưởng phòng cho phòng ban <?= $name ?> thành công</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-footer text-center">
						<button onclick="updateAccountPosition('<?= $manager_id ?>');" type="button" class="btn btn-success">OK</button>
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

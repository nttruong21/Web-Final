<?php
    // session_start();
    // // Kiểm tra người dùng có phải giám đốc?
    // if ($_SESSION['maChucVu'] != 'GD') {
    //     header("Location: /no_access.html");
    // }
    
    require_once("../../connect_db.php");

    // Lấy toàn bộ danh sách đơn nghỉ phép của trưởng phòng
    function get_applications() {
        $conn = connect_db();
        $sql = "SELECT * FROM DonXinNghiPhep";
        $result = $conn -> query($sql);
        if ($conn -> connect_error) {
            die("Không thể lấy danh sách đơn nghỉ phép " . $conn -> connect_error);
        }
        $applications = array();
        while ($row = $result->fetch_assoc()) {
            // $applications[] = $row;
            // print_r($row['maNhanVien']);
            $user_id = $row['maNhanVien'];
            // Kiểm tra nhân viên có phải là trưởng phòng không
            $sql = "SELECT * FROM NhanVien WHERE maNhanVien = ?";
            $stm = $conn -> prepare($sql);
            $stm -> bind_param("s", $user_id);
            $stm -> execute();
            $r = $stm -> get_result();
            $account = $r -> fetch_assoc();
            // print_r($account['maChucVu']);
            if ($account['maChucVu'] == 'TP') {
                $applications[] = $row;
            }
        }
        return array_reverse($applications);
    }

    // Lấy thông tin một đơn cụ thể 
    function get_application($id) {
        $conn = connect_db();
        $sql = "SELECT * FROM DonXinNghiPhep WHERE maDon = ?";
        $stm = $conn -> prepare($sql);
        $stm -> bind_param("i", $id);
        $stm -> execute();
        $result = $stm -> get_result();
        if ($result -> num_rows > 0) {
            $row = $result -> fetch_assoc();
            return $row;
        } else {
            return null;
        }
    }

        // Cập nhật thông tin đơn -> duyệt đơn 
        function approve_leave_application($id, $status) {
            $conn = connect_db();
            $sql = "UPDATE DonXinNghiPhep SET trangThai = ? WHERE maDon = ?";
            $stm = $conn -> prepare($sql);
            $stm -> bind_param("si", $status, $id);
            $stm -> execute();
            return $stm -> affected_rows === 1;
        }
?>
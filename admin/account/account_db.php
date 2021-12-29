<?php
    require_once("../../connect_db.php");

    // Lấy toàn bộ danh sách nhân viên 
    function get_accounts() {
        $conn = connect_db();
        $sql = "SELECT * FROM NhanVien";
        $result = $conn -> query($sql);
        if ($conn -> connect_error) {
            die("Không thể lấy danh sách nhân viên " . $conn -> connect_error);
        }
        $accounts = array();
        while ($row = $result->fetch_assoc()) {
            $accounts[] = $row;
        }
        return $accounts;
    }

    // Lấy thông tin một nhân viên 
    function get_account($user_id) {
        $conn = connect_db();
        $sql = "SELECT * FROM NhanVien WHERE maNhanVien = ?";
        $stm = $conn -> prepare($sql);
        $stm -> bind_param("s", $user_id);
        $stm -> execute();
        $result = $stm -> get_result();
        if ($result -> num_rows > 0) {
            $row = $result -> fetch_assoc();
            return $row;
        } else {
            return null;
        }
    }

    // Thêm tài khoản -> thêm nhân viên
    function add_account($user_id, $name, $birthday, $sex, $phone_number, $address, $email, $position, $department, $password) {
        $sql = "INSERT INTO NhanVien(maNhanVien, hoTen, ngaySinh, gioiTinh, sdt, diaChi, email, maChucVu, maPhongBan, matKhau) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $conn = connect_db();

        $stm = $conn -> prepare($sql);
        $stm -> bind_param("sssissssss", $user_id, $name, $birthday, $sex, $phone_number, $address, $email, $position, $department, $password);
        $stm -> execute();

        return $stm -> affected_rows == 1;
    }

    // Cập nhật thông tin nhân viên
    function update_account($user_id, $name, $birthday, $sex, $phone_number, $address, $email, $department, $day) {
        $conn = connect_db();
        $sql = "UPDATE NhanVien SET hoTen = ?, ngaySinh = ?, gioiTinh = ?, sdt = ?, diaChi = ?, email = ?, maPhongBan = ?, soNgayNghi = ? WHERE maNhanVien = ?";
        $stm = $conn -> prepare($sql);
        $stm -> bind_param("ssissssis", $name, $birthday, $sex, $phone_number, $address, $email, $department, $day, $user_id);
        $stm -> execute();
        return $stm -> affected_rows === 1;
    }

    // Xóa thông tin nhân viên
    function delete_account($id) {
        $conn = connect_db();
        $sql = "DELETE FROM NhanVien WHERE maNhanVien = ?";
        $stm = $conn -> prepare($sql);
        $stm -> bind_param("s", $id);
        $stm -> execute();
        return $stm -> affected_rows === 1;
    }

    // Đặt lại mật khẩu
    function reset_pass($user_id, $new_pass) {
        $conn = connect_db();
        $doiMatKhau = 0;
        $sql = "UPDATE NhanVien SET matKhau = ?, doiMatKhau = ? WHERE maNhanVien = ?";
        $stm = $conn -> prepare($sql);
        $stm -> bind_param("sis", $new_pass, $doiMatKhau, $user_id);
        $stm -> execute();
        return $stm -> affected_rows === 1;
    }
?>
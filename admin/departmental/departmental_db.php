<?php
    // session_start();
    // // Kiểm tra người dùng có phải giám đốc?
    // if ($_SESSION['maChucVu'] != 'GD') {
    //     header("Location: /no_access.html");
    // }

    require_once("../../connect_db.php");

    // Lấy toàn bộ danh sách phòng ban
    function get_departmentals() {
        $conn = connect_db();
        $sql = "SELECT * FROM PhongBan";
        $result = $conn -> query($sql);
        if ($conn -> connect_error) {
            die("Không thể lấy danh sách phòng ban " . $conn -> connect_error);
        }
        $departmentals = array();
        while ($row = $result->fetch_assoc()) {
            $departmentals[] = $row;
        }
        return $departmentals;
    }

    // Lấy thông tin một phòng ban
    function get_departmental($id) {
        $conn = connect_db();
        $sql = "SELECT * FROM PhongBan WHERE maPhongBan = ?";
        $stm = $conn -> prepare($sql);
        $stm -> bind_param("s", $id);
        $stm -> execute();
        $result = $stm -> get_result();
        if ($result -> num_rows > 0) {
            $row = $result -> fetch_assoc();
            return $row;
        } else {
            return null;
        }
    }

    // Thêm một phòng ban
    function add_departmental($id, $name, $number, $desc) {
        $sql = "INSERT INTO PhongBan(maPhongBan, tenPhongBan, soPhongBan, moTa) values(?, ?, ?, ?)";
        $conn = connect_db();

        $stm = $conn -> prepare($sql);
        $stm -> bind_param("ssss", $id, $name, $number, $desc);
        $stm -> execute();

        return $stm -> affected_rows == 1;
    }

    // Cập nhật thông tin phòng ban
    function update_departmental($id, $name, $num, $desc) {
        $conn = connect_db();
        $sql = "UPDATE PhongBan SET tenPhongBan = ?, soPhongBan = ?, moTa = ? WHERE maPhongBan = ?";
        $stm = $conn -> prepare($sql);
        $stm -> bind_param("ssss", $name, $num, $desc, $id);
        $stm -> execute();
        return $stm -> affected_rows === 1;
    }

    // Bổ nhiệm trưởng phòng 
    function asigned_manager_departmental($id, $employee_id) {
        $conn = connect_db();
        $sql = "UPDATE PhongBan SET truongPhong = ? WHERE maPhongBan = ?";
        $stm = $conn -> prepare($sql);
        $stm -> bind_param("ss", $employee_id, $id);
        $stm -> execute();
        return $stm -> affected_rows === 1;
    }

    // Xóa thông tin phòng ban
    function delete_departmental($id) {
        $conn = connect_db();
        $sql = "DELETE FROM PhongBan WHERE maPhongBan = ?";
        $stm = $conn -> prepare($sql);
        $stm -> bind_param("s", $id);
        $stm -> execute();
        return $stm -> affected_rows === 1;
    }
?>
<?php 
require_once('../connect_db.php');

// function add_product($name, $price, $desc){
//     $sql = "INSERT INTO product(name, price, description) VALUES(?, ?, ?)";
//     $conn = connect_db();
//     $stm = $conn->prepare($sql);
//     $stm->bind_param('sis', $name, $price, $desc);
//     $stm->execute();
//     if($stm->affected_rows == 1){
//         return $stm->insert_id;
//     }
//     return -1;
// }

function get_tasks(){
    $sql = "SELECT * FROM NhiemVu";
    $conn = connect_db();
    $result = $conn->query($sql);

    if ($result->num_rows == 0){
        die('Kêt nối thành công, Nhưng không có dữ liệu');
    }

    $arr = [];
    while ($row = $result->fetch_assoc()){
        $arr[] = $row;
        // print_r($row);
      
    }
    return $arr;
};


function insertFormDayOff($id, $numDayOff, $reason, $file) {
    $sql = "INSERT INTO DonXinNghiPhep(maNhanVien, soNgayNghi, lyDo, tapTin) values(?, ?, ?, ?)";
    $conn = connect_db();

    $stm = $conn->prepare($sql);
    $stm ->bind_param("siss", $id, $numDayOff, $reason, $file);
    $stm->execute();

    return $stm -> affected_rows == 1;
}


function insertFileTask($file) {
    $sql = "INSERT INTO NhiemVu(tapTin) values( ?)";
    $conn = connect_db();

    $stm = $conn->prepare($sql);
    $stm ->bind_param("s", $file);
    $stm->execute();

    return $stm -> affected_rows == 1;
}

function insertFeedbackTask($feedBack) {
    $sql = "INSERT INTO KetQuaGui(tapTin) values( ?)";
    $conn = connect_db();

    $stm = $conn->prepare($sql);
    $stm ->bind_param("s", $feedBack);
    $stm->execute();

    return $stm -> affected_rows == 1;
}


// function getNewTask($getNewTask) {
//     $conn = connect_db();
//     $sql = "SELECT * FROM NhiemVu WHERE trangThai = ?";
//     $stm = $conn -> prepare($sql);
//     $stm -> bind_param("s", $getNewTask);
//     $stm -> execute();
//     $result = $stm -> get_result();
//     if ($result -> num_rows > 0) {
//         $row = $result -> fetch_assoc();
//         return $row;
//     } else {
//         return null;
//     }
// }


function updateInProgressTask($inprogressTask) {
    $conn = connect_db();
    $sql = "UPDATE NhiemVu SET trangThai = ?";
    $stm = $conn->prepare($sql);
    $stm -> bind_param("s", $inprogressTask);
    $stm -> execute();
    return $stm -> affected_rows == 1;
}


function updateWaitingTask($waitingTask) {
    $conn = connect_db();
    $sql = "UPDATE NhiemVu SET trangThai = ?";
    $stm = $conn->prepare($sql);
    $stm -> bind_param("s", $waitingTask);
    $stm -> execute();
    return $stm -> affected_rows == 1;
}

// function update_product($id, $name, $price, $desc){
//     $sql = "UPDATE product SET name = ?, price = ?, description = ? WHERE id = ?";
//     $conn = connect_db();
//     $stm = $conn->prepare($sql);
//     $stm->bind_param('sisi', $name, $price, $desc, $id);
//     $stm->execute();
//     return $stm->affected_rows == 1;
// }
?>
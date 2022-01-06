<?php 
require_once('../../connect_db.php');

// function add_task($maNVu, $tenNVu, $maNVien, $maPB,$hanTH,$moTa,$tapTin,$trangThai){

//     $sql = "INSERT INTO NhiemVu VALUES(?, ?, ?,?,?,?,?,?)";
//     $conn = connect_db();
//     $stm = $conn->prepare($sql);
//     $stm->bind_param('ssssssss', $maNVu, $tenNVu, $maNVien, $maPB,$hanTH,$moTa,$tapTin,$trangThai);
//     $stm->execute();
//     return $stm->affected_rows == 1;
// }

function get_tasks($maPB){
    $sql = "SELECT * FROM NhiemVu where maPhongBan = '$maPB' Order by maNhiemVu DESC";
    $conn = connect_db();
    $result = $conn->query($sql);
    // $stm = $conn->prepare($sql);
    // // $stm->bind_param('ss', $maNhanVien, $maPB);
    // $stm->execute();

    if ($result->num_rows == 0){
        die('Kêt nối thành công, Nhưng không có dữ liệu');
    }

    $arr = [];
    while ($row = $result->fetch_assoc()){
        $arr[] = $row;
        // print_r($row);
      
    }
    return $arr;
}

// function delete_products($id){
//     $sql = "DELETE FROM product WHERE id = ?";
//     $conn = connect_db();
//     $stm = $conn->prepare($sql);
//     $stm->bind_param('i', $id);
//     $stm->execute();
//     return $stm->affected_rows == 1;
// }

// function update_product($id, $name, $price, $desc){
//     $sql = "UPDATE product SET name = ?, price = ?, description = ? WHERE id = ?";
//     $conn = connect_db();
//     $stm = $conn->prepare($sql);
//     $stm->bind_param('sisi', $name, $price, $desc, $id);
//     $stm->execute();
//     return $stm->affected_rows == 1;
// }
?>
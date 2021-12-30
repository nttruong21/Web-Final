<?php 
require_once('../../connect_db.php');

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
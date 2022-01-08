<?php 
require_once('../../connect_db.php');



function get_tasks($maPB){
    $sql = "SELECT * FROM NhiemVu where maPhongBan = '$maPB' Order by maNhiemVu DESC";
    $conn = connect_db();
    $result = $conn->query($sql);

    if ($result->num_rows == 0){
        die('Kêt nối thành công, Nhưng không có dữ liệu');
    }
    $arr = [];
    while ($row = $result->fetch_assoc()){
        $arr[] = $row;
    }
    return $arr;
}
?>
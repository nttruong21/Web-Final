<?php
	require_once('../connect_db.php');

  if(isset($_GET['maNV'])){
    $sql = "SELECT * FROM KetQuaGui where maNhiemVu = '".$_GET['maNV']."'";
    $conn = connect_db();
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $fileName = basename($row['tapTin']);
    $filePath = '../files/'.$fileName;
    if(!empty($fileName) && file_exists($filePath)){
      header("Cache-Control: public");
      header("Content-Description: File Transfer");
      header("Content-Disposition: attachment; filename=$fileName");
      header("Content-Type: application/zip");
      header("Content-Transfer-Encoding: binary");

      readfile($filePath);
      exit;
      
    }else{
      echo 'file không tồn tại';
    }
  }else{
    echo 'không tìm thấy dữ liệu';
  }
  
?>
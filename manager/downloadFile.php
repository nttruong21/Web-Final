<?php
	require_once('../connect_db.php');

  if(isset($_GET['maNVuu'])){
    $sql = "SELECT * FROM KetQuaGui where maNhiemVu = '".$_GET['maNVuu']."'";
    $conn = connect_db();
    $result2 = $conn->query($sql);
    $row2 = $result2->fetch_assoc();
    $fileName = basename($row2['tapTin']);
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
  }else if(isset($_GET['maNVien'])){
    $sql = "SELECT * FROM DonXinNghiPhep where maNhanVien = '".$_GET['maNVien']."'";
    $conn = connect_db();
    $result2 = $conn->query($sql);
    $row2 = $result2->fetch_assoc();
    $fileName = basename($row2['tapTin']);
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
  

  // if(isset($_GET['maNVien'])){
  //   $sql = "SELECT * FROM DonXinNghiPhep where maNhanVien = '".$_GET['maNVien']."'";
  //   $conn = connect_db();
  //   $result2 = $conn->query($sql);
  //   $row2 = $result2->fetch_assoc();
  //   $fileName = basename($row2['tapTin']);
  //   $filePath = '../files/'.$fileName;
  //   if(!empty($fileName) && file_exists($filePath)){
  //     header("Cache-Control: public");
  //     header("Content-Description: File Transfer");
  //     header("Content-Disposition: attachment; filename=$fileName");
  //     header("Content-Type: application/zip");
  //     header("Content-Transfer-Encoding: binary");

  //     readfile($filePath);
  //     exit;
      
  //   }else{
  //     echo 'file không tồn tại';
  //   }
  // }else{
  //   echo 'không tìm thấy dữ liệu';
  // }
  
?>
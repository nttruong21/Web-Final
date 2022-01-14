<?php   
     $errors= array();
     if (isset($_FILES['employee-avatar'])) {
         $file = $_FILES['employee-avatar'];
         if ($file['error'] !== 0) {
             $errors[] = "Tập tin rỗng";
         } 
        $name = $file['name'];
        $type = $file['type'];
        $tmp_name = $file['tmp_name'];
        $size = $file['size'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        
        // if(!empty($_POST['file-name'])) {
        //     $name = $_POST['file-name'] . '.' . $ext;
        // }

        // Kiểm tra kích thước tệp tin 
        if ($size > 12 * 1024 * 1024) {
            $errors[] = 'Tập tin vượt quá 12MB';
        }

        // Kiểm tra đuôi tệp tin 
        $extensions = array('jpg', 'png', 'jpeg');
        if (in_array($ext, $extensions)=== false) {
            $errors[] = 'Tập tin không phải ảnh';
        }

        // Đường dẫn folder uploads 
        $desc = $_SERVER['DOCUMENT_ROOT'] . '//images/' . $name;

        // chép file từ thư mục tmp -> uploads 
        if(empty($errors)==true){
            $move_status = move_uploaded_file($tmp_name, $desc); 
            // echo("Tải tập tin thành công");
            // echo($name);
            // Lưu tập tin ảnh vào cơ sở dữ liệu
            require_once("../connect_db.php");
            $conn = connect_db();
            $sql = "UPDATE NhanVien SET anhDaiDien = ? where ?";

            $condition = 1;
            $stm = $conn -> prepare($sql);
            $stm -> bind_param("si", $name, $condition);
            $stm -> execute();
            header("Location: profileTP.php");
            die();
        } else {
            print_r($errors);
        }
     }
?>
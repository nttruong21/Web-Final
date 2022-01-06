<?php
  session_start();
  require_once('../connect_db.php');
  $message = '';
  if (!isset($_POST['maNVu']) || !isset($_POST['tenNVu']) || !isset($_POST['time'])
      || !isset($_POST['moTa'])){
        $message = 'vui lòng nhập đầy đủ thông tin!!';
        
      }else if (empty($_POST['maNVu']) || empty($_POST['tenNVu']) || empty($_POST['time'])
      || empty($_POST['moTa'])){
        $message = 'KHông để giá trị rỗng!!';
        
      }else{

        if (!isset($_FILES["file"]))
          {
              $message =  "Dữ liệu không đúng cấu trúc";
              
          }
        $maNVu = $_POST['maNVu'];
        $tenNVu = $_POST['tenNVu'];
        $maNVien = $_POST['maNVien'];
        $maPB = $_POST['maPB'];
        $hanTH = $_POST['time'];
        $moTa = $_POST['moTa'];
        $tapTin = $_FILES["file"]['name'];
        // $tapTin = $_POST["file"];

        $trangThai = $_POST['trangThai'];

        $tname = $_FILES["file"]["tmp_name"];
        $uploads_dir = '../images';
        

       
        $sql = "INSERT INTO NhiemVu VALUES(?, ?, ?,?,?,?,?,?)";
        $conn = connect_db();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssssss', $maNVu, $tenNVu, $maNVien, $maPB, $hanTH, $moTa, $tapTin, $trangThai);
        $stm->execute();
      
        if( $stm->affected_rows == 1){
          move_uploaded_file($tname,$uploads_dir.'/'.$tapTin);
          header("Location: index.php");
        }else{
          $message = "thêm thất bại";
        }
      }

      

 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Document</title>
</head>
<body>
  <div class="container ">
    <div class="d-flex justify-content-center py-3">
      <h4 class="modal-title">ADD NEW TASK</h4>
    </div>

    <form action="form_add.php" method="post" enctype="multipart/form-data">

      <div class="modal-body">
        <?php
          if(!empty($message)){
            echo"<p class='alert alert-success'>". $message ."</p>";
            
          }
        ?>
        
        <div class="form-group">
            <label for="maNVu">Mã nhiệm vụ</label>
            <input type="text" placeholder="Nhập mã nhiệm vụ" class="form-control" id="maNVu" name="maNVu" required />
        </div>
        <div class="form-group">
            <label for="tenNVu">Tên nhiệm vụ</label>
            <input type="text" placeholder="Nhập tên nhiệm vụ" class="form-control" id="tenNVu" name="tenNVu" required />
        </div>

        <?php
            $maNVi = $_SESSION['maNhanVien'];
            $maPBa = $_SESSION['maPB'];
           $sql = "SELECT * FROM NhanVien where maNhanVien != '$maNVi' and maPhongBan = '$maPBa' ";
           $conn = connect_db();
           $result = $conn->query($sql);
          ?>
          <div class="form-group">
              <label for="maNVien">Tên nhân viên</label>
              <select name="maNVien" class="form-control">
              <?php
              while ($row = $result->fetch_assoc()){
                ?>
                  <option value="<?php echo $row['maNhanVien']?>"><?php echo $row['hoTen']?></option>
                <?php
              
            }
            ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="maPB">mã phòng ban</label>
            <input type="text" readonly class="form-control" id="maPB" name="maPB" value=<?=$_SESSION['maPB']?> />
        </div>
        <!-- <div class="form-group">
            <label for="time">hạn thực hiện</label>
            <input type="text" placeholder="Thời gian thực hiện" class="form-control" name="time" id="time" required />
        </div> -->
        <div class="form-group">
            <label for="time">Start date:</label>
            <input type="date" id="time" name="time"
                value="2022-01-01"
                min="2022-01-01" max="3000-12-31">
        </div>
        <div class="form-group">
            <label for="moTa">mô tả</label>
            <textarea rows="2" id="moTa" class="form-control" name="moTa" placeholder="Nhập mô tả" required></textarea>

        </div>
        <div class="form-group">
          <label for="file">Tệp đính kèm</label>
          <input type="file" class="form-control" name="file">
        </div>

        <!-- <div class="form-group">
            <label for="file">Tập tin</label>
            <input type="text" placeholder="Chọn tập tin" name="file" class="form-control" id="file" required />
        </div> -->
        <div class="form-group">
            <label for="trangThai">Trạng thái</label>
            <input type="text" readonly class="form-control" id="trangThai" name="trangThai" value="NEW" />
        </div>
      </div>

      <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Add</button>
      </div>
    </form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
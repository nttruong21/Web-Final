<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<title>Trang thông tin nhiệm vụ mới</title>
</head>

<body>
	<?php
		require_once('employee_heading.php');
	?>
	<div class="employee m-4">
		<div class="row">
			<div class="d-flex w-100 align-items-center employee-heading">
					
				<div class="col-xl-4 col-lg-6 col-md-5 employee-name">
					<h4 class="">Hello <?= $_SESSION['hoTen'] ?></h4>
				</div>
				<div class="col-xl-5 col-lg-4 col-md-6 col-sm-10 col-10">
					<div class="form-group border rounded-lg mb-0 bg-light">
						<form class="" methode="post">
							<div class="d-flex align-items-center justify-content-between w-100">
								<div class="task-search-input m-1">
									<input class="border border-0 border-none rounded p-1 w-100" type="search" placeholder="Search task" aria-label="Search">
								</div>
								<div class="task-search-icon m-1">
									<button class="btn btn-outline-info rounded-circle" type="submit"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<script src="/main.js"></script> 
</body>

</html>
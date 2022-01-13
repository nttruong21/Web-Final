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
<style>
	body {
		background-image: url(../images/background.jpg);
		background-repeat: no-repeat;
    	background-size: cover;
	}
	.navbar-header__none {
		display: none;
	}
	.employee {
		margin: 10px 15px;
	}
	.task-search-input {
		width: inherit;
	}
	.scrollable-task {
		height: 500px;
		overflow-x: auto;
	}
	.e__home-heading {
		display: none;
	}
	.e__task__heading {
		background-color: rgb(131,124,124);
		position: sticky;
		color: rgb(222,215,35);
	}
	.e__task__infomation {
		background-color: rgb(240,255,255);
	}
	.e__check-font-style{
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.e__condition-style {
		padding: 5px 0px 0 15px;
	}
	.displayNone {
		display: none;
	}
	@media screen and (min-width: 992px) and (max-width: 1199px){
		.task-name__heading,
		.task-time__heading {
			display: none;
		}
	}
	@media screen and (min-width: 768px) and (max-width: 991px){
		.employee-name,
		.task-name__heading,
		.task-time__heading {
			display: none;
		}
		.employee-heading {
			justify-content: space-between;
		}
	}	

	@media screen and (min-width: 576px) and (max-width: 767px){
		/* .navbar {
			padding: 0;
    		position: absolute;
		} */
		.employee-name {
			display: none;
		}
		/* .e__home-heading {
			display: block;
		}
		.navbar-header {
			display: none;
		}
		.navbar-header__none {
			display: block;
		}
		.employee-name {
			display: none;
		} */
	}
	@media screen and (max-width: 576px){
		/* .navbar {
			padding: 0;
    		position: absolute;
		} */
		.e__home-heading {
			display: block;
		}
		.navbar-header {
			display: none;
		}
		.navbar-header__none {
			display: block;
			font-weight: bold;
		}
		.employee-name {
			display: none;
		}
		
		.task-description__heading,
		.task-time__heading {
			display: none;
		}
	}
</style>
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
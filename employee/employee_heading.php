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
	<div>
		<div class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between mr-2 ml-2">
			<div class="e__home-heading">
				<a href="employee/index.php"><h4>HOME</h4></a>
			</div>
			<div class="">
				<div class="navbar-header">
					<a class="" href="employee/index.php"><h4>HOME PAGE EMPLOYEE</h4></a>
				</div>
			</div>
			<div class="navbar-info nav d-flex">
				<a class="font-weight-bold mr-4" href="../profileNV.php">Profile</a>
				<a class="font-weight-bold" href="../logout.php">Logout</a>
			</div>
			<div class="navbar-icon d-none">
				<i class="fas fa-bars"></i>
			</div>
		</div>
    </div>
</body>
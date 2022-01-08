<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
	
	<div class="col-xl-2 col-lg-2 col-md-2 col-sm-1 col-1 rounded border border-left-0 border-right-0 border-bottom-0">
		<ul class="menu list-unstyled">
			<li class="mt-2 mb-2 pl-2"> 
				<button onclick="moveToGetAllTaskPage();"
				class="btn btn-primary w-100 d-flex align-items-center">
					<i class="fas fa-book"></i>
					<p class="mb-0 ml-2">ALL TASKS</p> 	
				</button>
			</li>
			<li class="mt-2 mb-2 pl-2 d-flex"> 
				<button onclick="moveToGetNewTaskPage();"
				class="btn btn-info btn-new-task w-100 d-flex align-items-center">
				<i class="fas fa-star"></i>
				<p class="mb-0 ml-2">NEW TASK</p> 	
				</button>
			</li>
			<li class="mt-2 mb-2 pl-2 d-flex"> 
				<button onclick="moveToGetCompleteTaskPage();"
				class="btn btn-success btn-complete-task w-100 d-flex align-items-center">
				<i class="fas fa-check-double"></i>
				<p class="mb-0 ml-2">COMPLETED TASKS</p>	
				</button>
			</li>
			<li class="mt-2 mb-2 pl-2 d-flex"> 
				<button onclick="moveToGetRejectedTaskPage();"
				class="btn btn-secondary btn-canceled-task w-100 d-flex align-items-center">
				<i class="fas fa-trash"></i>
				<p class="mb-0 ml-2">REJECTED TASKS</p>	
				</button>
			</li>
			<li class="mt-2 mb-2 pl-2 d-flex"> 
				<button onclick="moveToGetInProgressTaskPage();"
				class="btn btn-secondary btn-canceled-task w-100 d-flex align-items-center">
				<i class="fas fa-trash"></i>
				<p class="mb-0 ml-2">IN PROGRESS TASKS</p>	
				</button>
			</li>
			<li class="mt-2 mb-2 pl-2 d-flex"> 
				<button onclick="moveToGetWaitingTaskPage();"
				class="btn btn-secondary btn-canceled-task w-100 d-flex align-items-center">
				<i class="fas fa-trash"></i>
				<p class="mb-0 ml-2">WAITING TASKS</p>	
				</button>
			</li>
			<li class="mt-2 mb-2 pl-2 d-flex"> 
				<button onclick="moveToDayOffListPage();"
				class="btn btn-secondary btn-day-off-list w-100 d-flex align-items-center">
				<i class="fas fa-calendar-day"></i>
				<p class="mb-0 ml-2">Nghỉ phép</p>	
				</button>
			</li>
		</ul>
	</div>
	
	<scrip src="/main.js"></scrip>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="col-lg-2">
        <ul class="menu list-unstyled m-0">
            <li class="mb-3 d-flex p-0">
                <button onclick="moveToIndexPage();" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                    <i class="fas fa-book text-white"></i>
                    <p class="mb-0 ml-1 task-btn">QUẢN LÝ NHÂN VIÊN</p>
                </button>
            </li>
            <li class="mb-3 p-0 d-flex">
                <button onclick="moveToDepartmentalManagerPage();" class="btn btn-info w-100 d-flex align-items-center justify-content-center">
                    <i class="fas fa-star text-white"></i>
                    <p class="mb-0 ml-1 task-btn">QUẢN LÝ PHÒNG BAN</p>
                </button>
            </li>
            <li class="mb-3 p-0 d-flex">
                <button onclick="moveToLeaveApplicationManagerPage();" class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                    <i class="fas fa-check-double text-white"></i>
                    <p class="mb-0 ml-1 task-btn">QUẢN LÝ ĐƠN NGHỈ PHÉP</p>
                </button>
            </li>
        </ul>
    </div>
</body>

</html>
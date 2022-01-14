"use strict";
// Jquery upload file
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function () {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
// ---------------------------- ADMIN ------------------------------------------
// ---------------------------- index.php --------------------------------------
// Lấy thông tin nhân viên và render ra giao diện
let accountsListHtml = document.querySelector("#accounts-list");
window.addEventListener("load", (e) => {
  let url = "http://localhost:8080/admin/account/get_accounts.php";
  fetch(url)
    .then((response) => response.json())
    .then((json) => {
      let accounts = json.data;
      accounts.forEach((account) => {
        let account_row = document.createElement("div");
        let depart_id = account.maPhongBan;
        let position;
        if (account.maChucVu === "NV") {
          position = "Nhân viên";
        } else {
          position = "Trưởng phòng";
        }
        // console.log(depart_id);
        fetch(
          "http://localhost:8080/admin/departmental/get_departmental.php?id=" +
            depart_id
        )
          .then((response) => response.json())
          .then((json) => {
            let depart = json.data;
            account_row.innerHTML = `
            <a href="account/account_detail_page.php?maNhanVien=${account.maNhanVien}" class="d-block text-body data-row">
            <div class='d-flex task-list border border-top-0 border-left-0' style='cursor: pointer' data-toggle='modal' data-target='#file-info-dialog'>
              <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                <p class='task-name  mb-0 p-1'>${account.maNhanVien}</p>
              </div>
              <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                <p class='task-description mb-0 p-1'>${account.hoTen}</p>
              </div>
              <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                <p class='mb-0 p-1'>${position}</p>
              </div>
              <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                <p class='mb-0 p-1'>${depart.tenPhongBan}</p>
              </div>
            </div>
            </a>
              `;
            if (accountsListHtml) {
              accountsListHtml.appendChild(account_row);
            }
          });
      });
    });
});

// Nhấn vào nút QUẢN LÝ PHÒNG BAN
function moveToDepartmentalManagerPage() {
  window.location.href = "departmental_manager_page.php";
}

function moveToIndexPage() {
  window.location.href = "index.php";
}

function moveToLeaveApplicationManagerPage() {
  window.location.href = "leave_application_manager_page.php";
}

// -------------------------------- add_account_page.php ---------------------------------------
// Xử lý thêm nhân viên
let formAddAccount = document.getElementById("form-add-account");
if (formAddAccount) {
  formAddAccount.addEventListener("submit", (e) => {
    e.preventDefault();
    // let add_error_message = document.getElementById("add-error-message");

    let user_id = document.getElementById("user-id").value;
    let name = document.getElementById("name").value;
    let birthday = document.getElementById("birthday").value;
    // let sex = document.getElementById("male").checked ? 1 : "";
    let sex = -1;
    if (document.getElementById("male").checked) {
      sex = 1;
    } else if (document.getElementById("female").checked) {
      sex = 0;
    }
    let phone_number = document.getElementById("phone-number").value;
    let address = document.getElementById("address").value;
    let email = document.getElementById("email").value;
    let position = document.getElementById("position").value.split(" - ")[0];
    let departmental = document
      .getElementById("departmental")
      .value.split(" - ")[0];
    let add_account_error = document.getElementById("add-account-error");
    if (
      user_id === "" ||
      name === "" ||
      birthday === "" ||
      phone_number === "" ||
      address === "" ||
      email === "" ||
      position === "" ||
      departmental === ""
    ) {
      add_account_error.innerHTML = "Vui lòng nhập đầy đủ thông tin";
    } else if (user_id.toLowerCase() === "admin") {
      add_account_error.innerHTML =
        "Mã nhân viên không được nhận giá trị admin";
    } else {
      let url = "http://localhost:8080/admin/account/add_account.php";
      let data = {
        user_id: user_id,
        name: name,
        birthday: birthday,
        sex: sex,
        phone_number: phone_number,
        address: address,
        email: email,
        position: position,
        departmental: departmental,
      };
      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
        .then((response) => response.json())
        .then((json) => {
          // Thành công
          if (json["code"] == 0) {
            // let success_model = document.getElementById("success-model");
            $("#success-model").modal("show");
            // success_model.style.display = "block";
            document
              .getElementById("btn-add-confirm")
              .addEventListener("click", (e) => {
                // location.reload();
                window.location.href = "../index.php";
              });
          }
          // Thất bại
          else {
            add_account_error.innerHTML = "Có lỗi, vui lòng thử lại";
          }
        });
    }
  });
}

// ----------------------------------- account_detail_page.php ----------------------------------
let btnEnableEditAccount = document.getElementById("btn-enable-edit-account");
let btnDeleleAccount = document.getElementById("btn-delele-account");
let btnConfirmEditAccount = document.getElementById("btn-confirm-edit-account");
let btnConfirmDeleteAccount = document.getElementById(
  "btn-confirm-delete-account"
);
let btnEditAccountSure = document.getElementById("btn-edit-account-sure");
let error_message = document.getElementById("error-message");
let btnConfirmResetAccountPass = document.getElementById(
  "btn-confirm-reset-account-pass"
);
let btnResetPassComplete = document.getElementById("btn-reset-pass-complete");
let btnUpdateAccountSuccess = document.getElementById(
  "btn-update-account-success"
);

// Nhấn nút Chỉnh sửa -> tắt disabled ở các inputs
if (btnEnableEditAccount) {
  btnEnableEditAccount.addEventListener("click", (e) => {
    // Tắt disabled -> bật chế độ chỉnh sửa
    // document.getElementById("user-id").disabled = false;
    document.getElementById("name").disabled = false;
    document.getElementById("birthday").disabled = false;
    document.getElementById("male").disabled = false;
    document.getElementById("female").disabled = false;
    document.getElementById("phone-number").disabled = false;
    document.getElementById("address").disabled = false;
    document.getElementById("email").disabled = false;
    // document.getElementById("position").disabled = false;
    // document.getElementById("departmental").disabled = false;
    document.getElementById("num-day").disabled = false;
    btnConfirmEditAccount.disabled = false;
  });
}

// Nhấn nút Xác nhận -> Cập nhật nhân viên
if (btnConfirmEditAccount) {
  btnConfirmEditAccount.addEventListener("click", (e) => {
    let user_id = document.getElementById("user-id").value;
    let name = document.getElementById("name").value;
    let birthday = document.getElementById("birthday").value;
    let sex = -1;
    if (document.getElementById("male").checked) {
      sex = 1;
    } else if (document.getElementById("female").checked) {
      sex = 0;
    }
    let phone_number = document.getElementById("phone-number").value;
    let address = document.getElementById("address").value;
    let email = document.getElementById("email").value;
    // let position = document.getElementById("position").value.split(" - ")[0];
    // let departmental = document
    //   .getElementById("departmental")
    //   .value.split(" - ")[0];
    let day = document.getElementById("num-day").value;

    if (
      user_id === "" ||
      name === "" ||
      birthday === "" ||
      sex === -1 ||
      phone_number === "" ||
      address === "" ||
      email === "" ||
      day === ""
    ) {
      if (
        !error_message.contains(document.querySelector(".add-product-error"))
      ) {
        let error = document.createElement("div");
        error.classList.add("alert");
        error.classList.add("alert-danger");
        error.classList.add("add-product-error");
        error.classList.add("font-weight-bold");
        error.innerHTML = "Vui lòng nhập đầy đủ thông tin";
        error_message.appendChild(error);
      }
    } else {
      $("#confirm-edit-account-model").modal("show");
      if (btnEditAccountSure) {
        btnEditAccountSure.addEventListener("click", (e) => {
          let url = "http://localhost:8080/admin/account/update_account.php";
          let data = {
            user_id: user_id,
            name: name,
            birthday: birthday,
            sex: sex,
            phone_number: phone_number,
            address: address,
            email: email,
            day: parseInt(day),
          };
          fetch(url, {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
          })
            .then((res) => res.json())
            .then((json) => {
              $("#confirm-edit-account-model").modal("hide");
              $("#update-account-success-model").modal("show");
              if (btnUpdateAccountSuccess) {
                btnUpdateAccountSuccess.addEventListener("click", (e) => {
                  location.reload();
                });
              }
            });
        });
      }
    }
  });
}

// Nhấn nút Xóa -> Xóa nhân viên
if (btnDeleleAccount) {
  btnDeleleAccount.addEventListener("click", (e) => {
    $("#confirm-delete-account-model").modal("show");
    if (btnConfirmDeleteAccount) {
      btnConfirmDeleteAccount.addEventListener("click", (e) => {
        let user_id = document.getElementById("user-id").value;
        if (user_id === "") {
          location.reload();
        }
        let url = "http://localhost:8080/admin/account/delete_account.php";
        let data = { user_id: user_id };
        fetch(url, {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then((res) => res.json())
          .then((json) => {
            if (json["code"] === 0) {
              window.location.href = "../index.php";
            }
          });
      });
    }
  });
}

// Nhấn nút Đặt lại mật khẩu -> reset mật khẩu
if (btnConfirmResetAccountPass) {
  btnConfirmResetAccountPass.addEventListener("click", (e) => {
    // call api
    let user_id = document.getElementById("user-id").value;
    if (user_id === "") {
      location.reload();
    }
    let url = "http://localhost:8080/admin/account/reset_pass.php";
    let data = {
      user_id: user_id,
    };
    fetch(url, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((json) => {
        if (json["code"] === 0) {
          $("#confirm-reset-account-password-model").modal("hide");
          $("#reset-pass-success-model").modal("show");
          btnResetPassComplete.addEventListener("click", (e) => {
            location.reload();
          });
        }
      });
  });
}

// -------------------------------------- departmental_manager_page.php -------------------------------------------
// Lấy thông tin toàn bộ phòng ban và hiển thị ra giao diện
let departmentals_list = document.getElementById("departmentals-list");
window.addEventListener("load", (e) => {
  let url = "http://localhost:8080/admin/departmental/get_departmentals.php";
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      let departmentals = data.data;
      departmentals.forEach((departmental) => {
        let manager_id = departmental.truongPhong;
        let departmental_row = document.createElement("div");
        if (manager_id) {
          fetch(
            "http://localhost:8080/admin/account/get_account.php?id=" +
              manager_id
          )
            .then((response) => response.json())
            .then((json) => {
              let manager_account = json.data;
              // console.log(manager_account.hoTen);
              departmental_row.innerHTML = `
                  <a href="departmental/departmental_detail_page.php?id=${departmental.maPhongBan}" class="d-block text-body data-row">
                    <div class='d-flex data-row border border-top-0 border-left-0' style='cursor: pointer' data-toggle='modal' data-target='#file-info-dialog'>
                      <div class='col-lg-2 border border-top-0 border-right-0  border-bottom-0'>
                        <p class='hide-redundant-content   mb-0 p-1'>${departmental.maPhongBan}</p>
                      </div>
                      <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                        <p class='hide-redundant-content  mb-0 p-1'>${departmental.tenPhongBan}</p>
                      </div>
                      <div class='col-lg-2 border border-top-0 border-right-0  border-bottom-0'>
                        <p class='hide-redundant-content  mb-0 p-1'>${departmental.soPhongBan}</p>
                      </div>
                      <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                        <p class='hide-redundant-content mb-0 p-1'>${departmental.moTa}</p>
                      </div>
                      <div class='col-lg-2 d-flex align-items-center justify-content-center border border-top-0 border-right-0  border-bottom-0'>
                        <p class='hide-redundant-content mb-0 p-1'>${manager_account.hoTen}</p>
                      </div>
                    </div>
                  </a>
                `;
            });
        } else {
          departmental_row.innerHTML = `
              <a href="departmental/departmental_detail_page.php?id=${departmental.maPhongBan}" class="d-block text-body data-row">
                <div class='d-flex data-row border border-top-0 border-left-0' style='cursor: pointer' data-toggle='modal' data-target='#file-info-dialog'>
                  <div class='col-lg-2 border border-top-0 border-right-0  border-bottom-0'>
                    <p class='hide-redundant-content   mb-0 p-1'>${departmental.maPhongBan}</p>
                  </div>
                  <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                    <p class='hide-redundant-content  mb-0 p-1'>${departmental.tenPhongBan}</p>
                  </div>
                  <div class='col-lg-2 border border-top-0 border-right-0  border-bottom-0'>
                    <p class='hide-redundant-content  mb-0 p-1'>${departmental.soPhongBan}</p>
                  </div>
                  <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                    <p class='hide-redundant-content mb-0 p-1'>${departmental.moTa}</p>
                  </div>
                  <div class='col-lg-2 d-flex align-items-center justify-content-center border border-top-0 border-right-0  border-bottom-0'>
                    <p class='hide-redundant-content mb-0 p-1'>Không có</p>
                  </div>
                </div>
              </a>
            `;
        }
        if (departmentals_list) {
          departmentals_list.appendChild(departmental_row);
        }
      });
    });
});

function refreshPage() {
  location.reload();
}

// Thêm phòng ban
function addDepartmental() {
  let id = document.getElementById("add-depart-id").value;
  let name = document.getElementById("add-depart-name").value;
  let num = document.getElementById("add-depart-num").value;
  let desc = document.getElementById("add-depart-desc").value;
  let add_depart_error = document.getElementById("add-depart-error");

  if (id === "" || name === "" || num === "" || desc === "") {
    add_depart_error.innerHTML = "Vui lòng nhập đầy đủ thông tin";
  } else {
    add_depart_error.innerHTML = "";
    let url = "http://localhost:8080/admin/departmental/add_departmental.php";
    let data = {
      id: id,
      name: name,
      num: num,
      desc: desc,
    };
    fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((json) => {
        // Thành công
        if (json["code"] == 0) {
          $("#add-departmental-modal").modal("hide");
          $("#add-departmental-success-model").modal("show");
        }
        // Thất bại
        else {
          add_depart_error.innerHTML = "Có lỗi, vui lòng thử lại";
        }
      });
  }
}

// Nhấn vào từng dòng -> hiển thị thông tin của phòng ban
function showDepartmentalDetail(id, name, num, desc) {
  $("#detail-departmental-modal").modal("show");
  document.getElementById("detail-depart-id").value = id;
  document.getElementById("detail-depart-name").value = name;
  document.getElementById("detail-depart-num").value = num;
  document.getElementById("detail-depart-desc").value = desc;
}

// Nhấn vào icon chỉnh sửa -> hiển thị modal cập nhật phòng ban
function showEditDepartmentalModal(id, name, num, desc) {
  $("#edit-departmental-modal").modal("show");
  document.getElementById("edit-depart-id").value = id;
  document.getElementById("edit-depart-name").value = name;
  document.getElementById("edit-depart-num").value = num;
  document.getElementById("edit-depart-desc").value = desc;
}

// Nhấn vào nút Cập nhật -> hiển thị modal xác nhận cập nhật
function editDepartmental() {
  let id = document.getElementById("edit-depart-id").value;
  let name = document.getElementById("edit-depart-name").value;
  let num = document.getElementById("edit-depart-num").value;
  let desc = document.getElementById("edit-depart-desc").value;
  let edit_error_mess = document.getElementById("edit-error-mess");
  if (name === "" || num === "" || desc === "") {
    if (
      !edit_error_mess.contains(document.querySelector(".add-product-error"))
    ) {
      let error = document.createElement("div");
      error.classList.add("alert");
      error.classList.add("alert-danger");
      error.classList.add("add-product-error");
      error.classList.add("font-weight-bold");
      error.classList.add("text-center");
      error.innerHTML = "Vui lòng nhập đầy đủ thông tin";
      edit_error_mess.appendChild(error);
    }
  } else {
    $("#edit-departmental-modal").modal("hide");
    $("#confirm-edit-departmental-modal").modal("show");
    document
      .getElementById("btn-confirm-edit-departmental")
      .setAttribute("depart-id", id);
    document
      .getElementById("btn-confirm-edit-departmental")
      .setAttribute("depart-name", name);
    document
      .getElementById("btn-confirm-edit-departmental")
      .setAttribute("depart-num", num);
    document
      .getElementById("btn-confirm-edit-departmental")
      .setAttribute("depart-desc", desc);
  }
}

// ---------------------------------------- departmental_detail_page.php -------------------------------------------
let depart_id = document.getElementById("depart-id");
let depart_name = document.getElementById("depart-name");
let depart_num = document.getElementById("depart-num");
let depart_desc = document.getElementById("depart-desc");
let depart_manager = document.getElementById("depart-manager");
let btn_confirm_edit_depart = document.getElementById(
  "btn-confirm-edit-depart"
);
let choose_manager_depart = document.getElementById("choose-manager-depart");

// Nhấn nút Chỉnh sửa -> bật chế độ chỉnh sửa Tên,Số, Mô tả phòng ban
function enableEditDepartmental() {
  depart_name.disabled = false;
  depart_num.disabled = false;
  depart_desc.disabled = false;
  btn_confirm_edit_depart.disabled = false;
}

// Xóa phòng ban
function confirmDeleteDepartmental(id) {
  if (id) {
    let url =
      "http://localhost:8080/admin/departmental/delete_departmental.php";
    let data = { id: id };
    fetch(url, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((json) => {
        if (json["code"] === 0) {
          window.location.href = "../departmental_manager_page.php";
        }
      });
  }
}

// Cập nhật phòng ban
function ConfirmEditDepartmental() {
  let id = depart_id.value;
  let name = depart_name.value;
  let num = depart_num.value;
  let desc = depart_desc.value;
  let url = "http://localhost:8080/admin/departmental/update_departmental.php";
  let data = {
    id: id,
    name: name,
    num: num,
    desc: desc,
  };
  fetch(url, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((res) => res.json())
    .then((json) => {
      $("#confirm-edit-departmental-modal").modal("hide");
      $("#edit-departmental-success-model").modal("show");
    });
}

function showConfirmAssignedManagerDepartmentalModal() {
  let employee_name = choose_manager_depart.value.split(" - ")[1];
  $("#assigned-manager-to-departmental-modal").modal("hide");
  document.getElementById(
    "confirm-assigned-manager-departmental-modal-header"
  ).innerHTML =
    "Bạn có chắc muốn bổ nhiệm " +
    employee_name +
    " làm trưởng phòng của phòng ban " +
    depart_name.value +
    "?";
}

// Bổ nhiệm trưởng phòng
function confirmAssignedManager() {
  $("#confirm-assigned-manager-departmental-modal").modal("hide");
  let employee_id = choose_manager_depart.value.split(" - ")[0];
  let id = depart_id.value;
  let url =
    "http://localhost:8080/admin/departmental/assigned_manager_departmental.php";
  let data = {
    id: id,
    employee_id: employee_id,
  };
  fetch(url, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((res) => res.json())
    .then((json) => {
      $("#assigned-manager-to-departmental-modal").modal("hide");
      $("#assigned-manager-departmental-success-model").modal("show");
    });
}

// Cập nhật chức vụ trưởng phòng cho nhân viên
function updateAccountPosition(manager_id) {
  let employee_id = choose_manager_depart.value.split(" - ")[0];
  let url = "http://localhost:8080/admin/account/update_account_manager.php";
  let data = {
    user_id: employee_id,
  };
  fetch(url, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((res) => res.json())
    .then((json) => {
      if (json["code"] === 0) {
        // refreshPage();
        // Xóa bỏ trưởng phòng cũ -> nhân viên
        if (manager_id === "") {
          refreshPage();
        } else {
          let url =
            "http://localhost:8080/admin/account/update_account_employee.php";
          let data = {
            user_id: manager_id,
          };
          fetch(url, {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
          })
            .then((res) => res.json())
            .then((json) => {
              if (json["code"] === 0) {
                refreshPage();
              }
            });
        }
      }
    });
}

// ---------------------------------------- admin_profile.php -------------------------------------------
// Bật chế độ cho phép chỉnh sửa
let admin_id = document.getElementById("admin-id");
let admin_name = document.getElementById("admin-name");
let admin_birth = document.getElementById("admin-birthday");
let admin_address = document.getElementById("admin-address");
let admin_male = document.getElementById("admin-male");
let admin_female = document.getElementById("admin-female");
let admin_phone = document.getElementById("admin-phone");
let admin_email = document.getElementById("admin-email");
let btn_confirm_edit_admin_profile = document.getElementById(
  "btn-confirm-edit-admin-profile"
);
function enableEditAdminProfileMode() {
  admin_name.disabled = false;
  admin_birth.disabled = false;
  admin_address.disabled = false;
  admin_male.disabled = false;
  admin_female.disabled = false;
  admin_phone.disabled = false;
  admin_email.disabled = false;
  btn_confirm_edit_admin_profile.disabled = false;
}

// Cập nhật thông tin giám đốc
function updateAdminProfile() {
  let id = admin_id.value;
  let name = admin_name.value;
  let birth = admin_birth.value;
  let address = admin_address.value;
  let sex = -1;
  if (admin_male.checked) {
    sex = 1;
  } else if (admin_female.checked) {
    sex = 0;
  }
  let phone_number = admin_phone.value;
  let email = admin_email.value;

  let url = "http://localhost:8080/admin/account/update_account_admin.php";
  let data = {
    id: id,
    name: name,
    birthday: birth,
    sex: sex,
    phone_number: phone_number,
    address: address,
    email: email,
  };
  fetch(url, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((res) => res.json())
    .then((json) => {
      $("#confirm-edit-admin-profile-modal").modal("hide");
      $("#update-account-admin-success-modal").modal("show");
    });
}

// Xử lý, kiểm tra trước khi gửi form thay đổi ảnh đại diện của giám đốc
function handleChangeAdminAvatar(e) {
  let avatar = document.getElementById("admin-avatar").value;
  let change_admin_avatar_error_message = document.getElementById(
    "change-admin-avatar-error-message"
  );
  // console.log(avatar);
  if (avatar === "") {
    e.preventDefault();
    change_admin_avatar_error_message.classList.add("card");
    change_admin_avatar_error_message.innerHTML = "Vui lòng chọn tập tin ảnh";
  } else {
    console.log(avatar);
    let splitArr = avatar.split("\\");
    let file_name = splitArr[splitArr.length - 1];
    let extension = file_name.split(".")[1];
    console.log(extension);
    if (extension !== "jpeg" && extension !== "png" && extension !== "jpg") {
      e.preventDefault();
      if (!change_admin_avatar_error_message.classList.contains("card")) {
        change_admin_avatar_error_message.classList.add("card");
      }
      change_admin_avatar_error_message.innerHTML =
        "Tập tin này không phải ảnh";
    }
  }
}

// ---------------------------------------- leave_application_manager_page.php -------------------------------------------
// Lấy danh sách đơn nghỉ phép và render ra giao diện
let admin_leave_application_list = document.getElementById(
  "admin-leave-application-list"
);
window.addEventListener("load", () => {
  let url =
    "http://localhost:8080/admin/application/get_manager_applications.php";
  fetch(url)
    .then((response) => response.json())
    .then((json) => {
      // Lấy danh sách đơn nghỉ phép của trưởng phòng
      let applications = json.data;
      // console.log(applications);
      applications.forEach((application) => {
        // console.log(typeof application.trangThai);
        let application_row = document.createElement("div");
        // let trangThai = "Đã xử lý";
        // if (parseInt(application.trangThai) === 0) {
        //   trangThai = "Chưa xử lý";
        //   application_row.classList.add("font-weight-bold");
        // }
        if (application.trangThai === "WAITING") {
          application_row.classList.add("font-weight-bold");
        }
        // console.log(application.trangThai);
        let manager_id = application.maNhanVien;
        // Lấy thông tin trưởng phòng
        if (manager_id) {
          fetch(
            "http://localhost:8080/admin/account/get_account.php?id=" +
              manager_id
          )
            .then((response) => response.json())
            .then((json) => {
              let manager_account = json.data;
              // console.log(manager_account.hoTen);
              application_row.innerHTML = `
                <a href="application/application_detail_page.php?maDon=${application.maDon}&hoTen=${manager_account.hoTen}" class="d-block text-body data-row">
                <div class='d-flex task-list border border-top-0 border-left-0' style='cursor: pointer' data-toggle='modal' data-target='#file-info-dialog'>
                  <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                    <p class='task-name  mb-0 p-1'>${application.maDon}</p>
                  </div>
                  <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                    <p class='task-description mb-0 p-1'>${manager_account.hoTen}</p>
                  </div>
                  <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                    <p class='mb-0 p-1'>${application.ngayTao}</p>
                  </div>
                  <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
                    <p class='mb-0 p-1'>${application.trangThai}</p>
                  </div>
                </div>
              </a>
                `;
            });
        }
        if (admin_leave_application_list) {
          admin_leave_application_list.appendChild(application_row);
        }
      });
    });
});

// ---------------------------------------- application_detail_page.php -------------------------------------------
// Nhấn nút Không đồng ý
function disagreeLeaveApp(id) {
  // console.log("disagree");
  let url =
    "http://localhost:8080/admin/application/approve_leave_application.php";
  let data = {
    id: id,
    status: "REFUSED",
  };
  fetch(url, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((res) => res.json())
    .then((json) => {
      refreshPage();
    });
}

// Nhấn nút Đồng ý
function agreeLeaveApp(id) {
  // console.log("agree");
  let url =
    "http://localhost:8080/admin/application/approve_leave_application.php";
  let data = {
    id: id,
    status: "APPROVED",
  };
  fetch(url, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((res) => res.json())
    .then((json) => {
      refreshPage();
    });
}

// ############################# TRƯỞNG PHÒNG #####################################
const m_readAPI = "http://localhost:8080/manager/api/get_task.php";

function loadTasks() {
  const countTask = 0;
  fetch(m_readAPI)
    .then((response) => response.json())
    .then((data) => {
      data.forEach((task) => {
        let tr = $("<tr></tr>");

        // countTask = countTask+1;
        console.log(task.trangThai);
        // console.log(data)
        if (task.trangThai === "IN PROGRESS") {
          tr.html(`
                
                        <td><span class="badge mission-status-color badge-primary" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `);
        } else if (task.trangThai === "CANCELED") {
          tr.html(`
                
                        <td><span class="badge mission-status-color badge-danger" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `);
        } else if (task.trangThai === "REJECTED") {
          tr.html(`
                
                        <td><span class="badge mission-status-color badge-warning" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `);
        } else if (task.trangThai === "WAITING") {
          tr.html(`
                
                        <td><span class="badge mission-status-color badge-secondary" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `);
        } else if (task.trangThai === "COMPLETED") {
          tr.html(`
                
                        <td><span class="badge mission-status-color badge-info" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `);
        } else {
          tr.html(`
                
                        <td><span class="badge mission-status-color badge-success" >${task.trangThai}</span></td>
                        <td><a href="infor.php?maNVu=${task.maNhiemVu}" class="tenNhiemVu">${task.tenNhiemVu}</a></td>
                        <td>${task.hanThucHien}</td>

                    `);
        }

        $("#list-task").append(tr);
      });
      document.querySelector(".countTask").innerHTML = data.length;
    });
}

// loadTasks();

// chọn ngày
// $(function(){
//   $('.datepicker').datepicker({
//      format: 'dd-mm-yyyy'
//    });
//  });

if ($("#m-trangThai").attr("value") != "WAITING") {
  $("#m-smDongY").attr("disabled", true);
  $("#m-smTuChoi").attr("disabled", true);
}
if ($("#trangThai").attr("value") == "NEW") {
  $("#sbUpdate").attr("disabled", false);
  $("#sbCancel").attr("disabled", false);
} else {
  $("#sbUpdate").attr("disabled", true);
  $("#sbCancel").attr("disabled", true);
}

// -----------------------Employee---------------------------------------- //
// ------------------------index.php---------------------------------------- //
// Lấy thông tin task có trạng thái new và render ra giao diện

const addAPIDayOff = "http://localhost:8080/employee/send_dayOff_task.php";
const addAPIInputTask = "http://localhost:8080/employee/send_file_task.php";
const getNewTask = "http://localhost:8080/employee/get_new_task.php";

function moveToGetAllTaskPage() {
  window.location.href = "index.php";
}

function moveToGetNewTaskPage() {
  window.location.href = "get_new_task.php";
}

function moveToGetCompleteTaskPage() {
  window.location.href = "get_completed_task.php";
}

function moveToGetRejectedTaskPage() {
  window.location.href = "get_rejected_task.php";
}

function moveToGetInProgressTaskPage() {
  window.location.href = "get_inprogress_task.php";
}

function moveToGetWaitingTaskPage() {
  window.location.href = "get_waiting_task.php";
}

function moveToTaskInfomationPage() {
  window.location.href = "task_infomation.php";
}

function moveToDayOffFormPage() {
  let sumDayOff = $("#sumDayOff").val();
  let countDayOff = $("#countDayOff").val();

  if (countDayOff > sumDayOff) {
    window.location.href = "dayOff_Form_disabled.php";
  } else {
    window.location.href = "dayOff_Form.php";
  }
}

function moveToDayOffListPage() {
  window.location.href = "dayOff_list.php";
}

function addDayOffForm(e) {
  // e.preventDefault();
  // console.log("stopped")
  let maNVDayOff = $("#maNVDayOff").val();
  let dayDayOff = $("#dayDayOff").val();
  let reasonDayOff = $("#reasonDayOff").val();
  let fileDayOff = $("#fileDayOff").val();

  // Kiểm tra dữ liệu có rỗng hay không
  if (
    maNVDayOff == "" ||
    dayDayOff == "" ||
    reasonDayOff == "" ||
    fileDayOff == ""
  ) {
    $(".empty").removeClass("d-none");
  } else {
    $(".empty").addClass("d-none");
  }

  let data = {
    maNVDayOff: maNVDayOff,
    dayDayOff: dayDayOff,
    reasonDayOff: reasonDayOff,
    fileDayOff: fileDayOff,
  };

  fetch(addAPIDayOff, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  }).then((res) => res.json());
  // .then(data => {
  //         if (data.code === 0) {
  // 			console.log(0)
  // $('#day-off-dialog').modal('toggle')
  // $('#responseMess').html(data.message);
  // $('#message-respone').modal('show');

  // $('tbody').children().remove()
  // loadTasks()
  // } else {
  // 	console.log(1)
  // $('#add-dialog').modal('toggle')
  // $('#responseMess').html(data.message);
  // $('#message-respone').modal('show');
  // }
  // })
}

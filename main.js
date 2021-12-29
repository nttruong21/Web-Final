"use strict";
// ------------ ADMIN ---------------
// ------------ index.php ---------------
// Lấy thông tin nhân viên và render ra giao diện
window.addEventListener("load", (e) => {
  let url = "http://localhost:8080/admin/account/get_accounts.php";
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      let accounts = data.data;
      let htmls = accounts.map((account) => {
        return `
        <a href="account/account_detail_page.php?maNhanVien=${account.maNhanVien}" class="d-block text-body data-row">
        <div onclick="moveToDetailPage(${data})" class='d-flex task-list border border-top-0 border-left-0' style='cursor: pointer' data-toggle='modal' data-target='#file-info-dialog'>
          <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
            <p class='task-name  mb-0 p-1'>${account.maNhanVien}</p>
          </div>
          <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
            <p class='task-description mb-0 p-1'>${account.hoTen}</p>
          </div>
          <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
            <p class='mb-0 p-1'>${account.maChucVu}</p>
          </div>
          <div class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
            <p class='mb-0 p-1'>${account.maPhongBan}</p>
          </div>
        </div>
        </a>`;
      });
      let accountsListHtml = document.querySelector("#accounts-list");
      if (accountsListHtml) {
        accountsListHtml.innerHTML = htmls.join("");
      }
    });
});

// Nhấn vào nút QUẢN LÝ PHÒNG BAN
function moveToDepartmentalManagerPage() {
  window.location.href = "departmental_manager_page.php";
}

function moveToIndexPage() {
  window.location.href = "index.php";
}

// ------------ add_account_page.php ---------------
// Xử lý thêm nhân viên
let formAddAccount = document.getElementById("form-add-account");
if (formAddAccount) {
  formAddAccount.addEventListener("submit", (e) => {
    e.preventDefault();
    let add_error_message = document.getElementById("add-error-message");

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
      if (
        !add_error_message.contains(
          document.querySelector(".add-product-error")
        )
      ) {
        error.innerHTML = "Vui lòng nhập đầy đủ thông tin";
        add_error_message.appendChild(error);
      }
    } else {
      let error = document.createElement("div");
      error.classList.add("alert");
      error.classList.add("alert-danger");
      error.classList.add("add-product-error");
      error.classList.add("font-weight-bold");
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
            if (
              add_error_message.contains(
                document.querySelector(".add-product-error")
              )
            ) {
              add_error_message.removeChild(
                document.querySelector(".add-product-error")
              );
            }
            // let success_model = document.getElementById("success-model");
            $("#success-model").modal("show");
            // success_model.style.display = "block";
            document
              .getElementById("btn-add-confirm")
              .addEventListener("click", (e) => {
                location.reload();
              });
          }
          // Thất bại
          else {
            if (
              add_error_message.contains(
                document.querySelector(".add-product-error")
              )
            ) {
              add_error_message.removeChild(
                document.querySelector(".add-product-error")
              );
            }
            error.innerHTML = "Có lỗi, vui lòng thử lại";
            add_error_message.appendChild(error);
          }
        });
    }
  });
}

// ------------ account_detail_page.php ---------------
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
    document.getElementById("departmental").disabled = false;
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
    let departmental = document
      .getElementById("departmental")
      .value.split(" - ")[0];
    let day = document.getElementById("num-day").value;

    if (
      user_id === "" ||
      name === "" ||
      birthday === "" ||
      sex === -1 ||
      phone_number === "" ||
      address === "" ||
      email === "" ||
      departmental === "" ||
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
            departmental: departmental,
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

// ------------------------ departmental_manager_page.php ---------------------
let departmentals_list = document.getElementById("departmentals-list");
// Lấy thông tin toàn bộ phòng ban và hiển thị ra giao diện
window.addEventListener("load", (e) => {
  let url = "http://localhost:8080/admin/departmental/get_departmentals.php";
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      let departmentals = data.data;
      let htmls = departmentals.map((departmental) => {
        return `
    <div class='d-flex data-row border border-top-0 border-left-0' style='cursor: pointer' data-toggle='modal' data-target='#file-info-dialog'>
      <div onclick="showDepartmentalDetail('${departmental.maPhongBan}', '${departmental.tenPhongBan}', '${departmental.soPhongBan}', '${departmental.moTa}');"  class='col-lg-2 border border-top-0 border-right-0  border-bottom-0'>
        <p class='hide-redundant-content   mb-0 p-1'>${departmental.maPhongBan}</p>
      </div>
      <div onclick="showDepartmentalDetail('${departmental.maPhongBan}', '${departmental.tenPhongBan}', '${departmental.soPhongBan}', '${departmental.moTa}');"  class='col-lg-3 border border-top-0 border-right-0  border-bottom-0'>
        <p class='hide-redundant-content  mb-0 p-1'>${departmental.tenPhongBan}</p>
      </div>
      <div onclick="showDepartmentalDetail('${departmental.maPhongBan}', '${departmental.tenPhongBan}', '${departmental.soPhongBan}', '${departmental.moTa}');"  class='col-lg-2 border border-top-0 border-right-0  border-bottom-0'>
        <p class='hide-redundant-content  mb-0 p-1'>${departmental.soPhongBan}</p>
      </div>
      <div onclick="showDepartmentalDetail('${departmental.maPhongBan}', '${departmental.tenPhongBan}', '${departmental.soPhongBan}', '${departmental.moTa}');"  class='col-lg-4 border border-top-0 border-right-0  border-bottom-0'>
        <p class='hide-redundant-content mb-0 p-1'>${departmental.moTa}</p>
      </div>
      <div class='col-lg-1 d-flex align-items-center justify-content-center border border-top-0 border-right-0  border-bottom-0'>
        <div style="font-size: 20px;" class="f-flex">
          <i onclick="showEditDepartmentalModal('${departmental.maPhongBan}', '${departmental.tenPhongBan}', '${departmental.soPhongBan}', '${departmental.moTa}');" class="fas fa-edit mr-2 text-primary"></i>
          <i onclick="showDeleteDepartmentalModal('${departmental.maPhongBan}');" class="fas fa-trash-alt text-danger"></i>
        </div>
      </div>
  </div>`;
      });
      if (departmentals_list) {
        departmentals_list.innerHTML = htmls.join("");
      }
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
  let add_error_mess = document.getElementById("add-error-mess");

  if (id === "" || name === "" || num === "" || desc === "") {
    if (!error_mess.contains(document.querySelector(".add-product-error"))) {
      let error = document.createElement("div");
      error.classList.add("alert");
      error.classList.add("alert-danger");
      error.classList.add("add-product-error");
      error.classList.add("font-weight-bold");
      error.classList.add("text-center");
      error.innerHTML = "Vui lòng nhập đầy đủ thông tin";
      error_mess.appendChild(error);
    }
  } else {
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
          if (
            error_mess.contains(document.querySelector(".add-product-error"))
          ) {
            error_mess.removeChild(
              document.querySelector(".add-product-error")
            );
          }
          error.innerHTML = "Có lỗi, vui lòng thử lại";
          error_mess.appendChild(error);
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

// Nhấn nút Đồng ý trong Confirm edit departmental model -> cập nhật phòng ban
function handleEditDepartmental(e) {
  let id = e.getAttribute("depart-id");
  let name = e.getAttribute("depart-name");
  let num = e.getAttribute("depart-num");
  let desc = e.getAttribute("depart-desc");
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

// Nhấn vào icon xóa -> hiển thị modal xóa phòng ban
function showDeleteDepartmentalModal(id) {
  $("#confirm-delete-departmental-modal").modal("show");
  document
    .getElementById("btn-confirm-delete-departmental")
    .setAttribute("depart-id", id);
}

// Nhấn nút Đồng ý trong Confirm delete departmental modal-> xóa phòng ban
function handleDeleteDepartmental(e) {
  let id = e.getAttribute("depart-id");
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
          refreshPage();
        }
      });
  }
}

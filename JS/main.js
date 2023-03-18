$(document).ready(function () {
  console.log("ready!");
  $(".fade-up").addClass("runFadeUp");
  $(".edit-container").addClass("active");
});

function addActive() {
  $(".bg-dark, .add-container").addClass("active");
}

function clearField() {
  $("form").each(function () {
    this.reset();
  });
}

function removeActive() {
  $(".bg-dark, .add-container, .edit-container").removeClass("active");
  clearField();
}

function showDelConfirm(id) {
  $(".bg-dark").addClass("active");
  $("#del-" + id).addClass("show");
  $("#yes-del-" + id).attr("href", "PHP/delete.php?id=" + id);
}
function showAddConfirm() {
  $(".bg-dark").addClass("active");
  $("#add").addClass("show");
}

function showEditConfirm() {
  $(".bg-dark").addClass("active");
  $("#edit").addClass("show");
}

function removeDelConfirm() {
  removeActive();
  $(".confirm-wrapper").removeClass("show");
}

function removeAddConfirm() {
  $(".confirm-wrapper").removeClass("show");
}

function yesAddBtnClick() {
  removeActive();
  removeAddConfirm();
}

function removeEditConfirm() {
  $(".confirm-wrapper").removeClass("show");
}

function yesEditBtnClick() {
  removeActive();
  removeAddConfirm();
}

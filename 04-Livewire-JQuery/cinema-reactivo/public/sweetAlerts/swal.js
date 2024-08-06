function swalConfirmMsg() {
    Swal.fire({
        text: "Operation Sucecessfully Completed!",
        icon: "success",
    });
}
function swalErrorMsg(error) {
    Swal.fire({
        text: error,
        icon: "error",
    });
}

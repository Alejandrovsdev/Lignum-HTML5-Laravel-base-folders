function swalConfirmMsg() {
    Swal.fire({
        text: "Operation Sucecessfully Completed!",
        icon: "success",
        confirmButtonColor: "#3085d6",
    }).then((result) => {
        if (result.isConfirmed) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },
            });
            Toast.fire({
                icon: "success",
                title: "Signed in successfully",
            });
        }
    });
}
function swalErrorMsg(error) {
    Swal.fire({
        text: error,
        icon: "error",
    });
}

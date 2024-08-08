document.addEventListener("livewire:navigated", () => {
    Livewire.on("swalConfirmMsg", () => {
        swalConfirmMsg();
    });

    Livewire.on("swalErrorMsg", (event) => {
        const message = event[0].message;
        swalErrorMsg(message);
    });
});

function toggleIcons() {
    var icons = document.getElementById("icons");
    if (icons.classList.contains("hidden")) {
        icons.classList.remove("hidden");
    } else {
        icons.classList.add("hidden");
    }
}

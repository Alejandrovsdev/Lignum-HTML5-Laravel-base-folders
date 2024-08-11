document.addEventListener("livewire:init", () => {
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
        icons.classList.add("flex");
    } else {
        icons.classList.remove("flex");
        icons.classList.add("hidden");
    }
}

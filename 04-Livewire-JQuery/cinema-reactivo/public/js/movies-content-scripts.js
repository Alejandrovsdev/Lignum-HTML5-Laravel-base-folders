document.addEventListener("livewire:navigated", () => {
    Livewire.on("swalConfirmMsg", () => {
        swalConfirmMsg();
    });
    Livewire.on("swalErrorMsg", (response) => {
        swalErrorMsg(response.response.general);
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

document.addEventListener("livewire:navigated", function () {
    $(document).off("click", ".edit-movie-button");

    $(document).on("click", ".edit-movie-button", function () {
        var movieId = $(this).data("id");
        var modal = $("#editMovieModal");
        modal.modal("show");

        $.ajax({
            url: "/admin/movies/edit/" + movieId,
            method: "GET",
            success: function (data) {
                $("#edit-movie-id").val(data.movie.MovieID);
                $("#edit-title").val(data.movie.Title);
                $("#edit-duration").val(data.movie.Duration);
                $("#edit-synopsis").val(data.movie.Synopsis);
                $("#edit-mainActor").val(data.movie.PrincipalActorID);
                $("#current-image").attr("src", data.movie.Image);
            },
        });
    });

    $(document).on("submit", "#edit-movie-form", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var movieId = $("#edit-movie-id").val();

        $.ajax({
            url: "/admin/movies/" + movieId,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "X-HTTP-Method-Override": "PUT",
            },
            success: function (response) {
                if (response.errors) {
                    const responseMsg = response.errors;
                    Livewire.dispatch("swalErrorMsg", {
                        response: responseMsg,
                    });
                } else {
                    $("#editMovieModal").modal("hide");
                    Livewire.dispatch("swalConfirmMsg");
                    updateTable(response.movie);
                }
            },
            error: function (response) {
                const responseMsg = response.errors;
                Livewire.dispatch("swalErrorMsg", {
                    response: responseMsg,
                });
            },
        });
    });

    function updateTable(movie) {
        var row = $("#movie-" + movie.MovieID);
        row.find(".title").text(movie.Title);
        row.find(".duration").text(movie.Duration);
        row.find(".main-actor").text(movie.nameActor);
        var image = row.find(".movie-image");
        if (movie.Image) {
            image.attr("src", movie.Image);
        }
    }
});

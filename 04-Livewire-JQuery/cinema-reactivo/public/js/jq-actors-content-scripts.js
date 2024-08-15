document.addEventListener("DOMContentLoaded", function () {

    $(document).off("click", "#createActorBtn");

    $(document).on("click", "#createActorBtn", function () {
        const createActorModal = $("#createActorModal");
        createActorModal.modal("show");
    });

    $(document).on("submit", "#createActorForm", function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const createActorModal = $("#createActorModal");
        const createActorForm = $("#createActorForm");

        $.ajax({
            url: "/jq-practice/create-actor",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {

                createActorModal.modal("hide");
                createActorForm[0].reset();

                const newRow = `
                    <tr>
                        <th scope="row">${response.ActorID}</th>
                        <td>${response.Name}</td>
                        <td>${response.Birthdate}</td>
                        <td>${response.CountryName}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button class="me-3 text-2xl" data-bs-toggle="modal" data-bs-target="#updateActorModal">
                                    <i class="fa-regular fa-pen-to-square text-blue-600"></i>
                                </button>
                                <button class="text-2xl" data-bs-toggle="modal" data-bs-target="#deleteActorModal">
                                    <i class="fa-solid fa-trash text-red-600 text-md"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                $("table tbody").append(newRow);
            },
            error: function (response) {
                const responseMsg = response.errors;
                console.log(responseMsg);
            },
        });
    });
});

$(document).ready(function () {

    $(document).on('click', '.admin-index .doctor-list .item .delete', function (e) {

        var doctorId = $(this).closest('.item').data('id');

        $.ajax({
            type: "POST",
            url: "/admin/delete-doctor.php",
            data: {
                "doctor_id": doctorId,
            },
            cache: false,

            success: function (response) {
                $('.admin-index .doctor-list-ajax').html(response);
            },
            error: function (response) {
                console.log("Ошибка сервера");
            }
        });

        e.preventDefault();
    });

    $(document).on('click', '.admin-view-doctor .no-active', function (e) {

        var doctorId = $(this).data('doctor-id');
        var button = $(this);

        $.ajax({
            type: "POST",
            url: "/admin/toggle-active.php",
            data: {
                "doctor_id": doctorId,
                "active": 0
            },
            cache: false,

            success: function (response) {
                button.removeClass('no-active').addClass('active').text("Сделать активным");
            },
            error: function (response) {
                console.log("Ошибка сервера");
            }
        });

        e.preventDefault();
    });

    $(document).on('click', '.admin-view-doctor .active', function (e) {

        var doctorId = $(this).data('doctor-id');
        var button = $(this);

        $.ajax({
            type: "POST",
            url: "/admin/toggle-active.php",
            data: {
                "doctor_id": doctorId,
                "active": 1
            },
            cache: false,

            success: function (response) {
                button.removeClass('active').addClass('no-active').text("Сделать неактивным");
            },
            error: function (response) {
                console.log("Ошибка сервера");
            }
        });

        e.preventDefault();
    });

});

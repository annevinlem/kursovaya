$(document).ready(function () {

    $(document).on('click', '.doctor-index .item .invite', function (e) {

        var queueId = $(this).closest('.item').data('id');
        var doctorId = $('input[name="doctor-id"]').val();
        var action = $(this).closest('.action');

        if (!action.hasClass('block')) {
            $.ajax({
                type: "POST",
                url: "/doctor/invite-patient.php",
                data: {
                    "queue_id": queueId,
                    "doctor_id": doctorId,
                },
                cache: false,

                success: function (response) {
                    $('.queue-list-ajax').html(response);
                },
                error: function (response) {
                    console.log("Ошибка сервера");
                }
            });
        }
    });

    $(document).on('click', '.doctor-index .item .come', function (e) {

        var queueId = $(this).closest('.item').data('id');
        var doctorId = $('input[name="doctor-id"]').val();
        var action = $(this).closest('.action');

        if (!action.hasClass('block')) {
            $.ajax({
                type: "POST",
                url: "/doctor/patient-come.php",
                data: {
                    "queue_id": queueId,
                    "doctor_id": doctorId,
                },
                cache: false,

                success: function (response) {
                    $('.queue-list-ajax').html(response);
                },
                error: function (response) {
                    console.log("Ошибка сервера");
                }
            });
        }
    });

    $(document).on('click', '.doctor-index .item .not_come', function (e) {

        var queueId = $(this).closest('.item').data('id');
        var doctorId = $('input[name="doctor-id"]').val();
        var action = $(this).closest('.action');

        if (!action.hasClass('block')) {
            $.ajax({
                type: "POST",
                url: "/doctor/finish-patient.php",
                data: {
                    "queue_id": queueId,
                    "doctor_id": doctorId,
                },
                cache: false,

                success: function (response) {
                    $('.queue-list-ajax').html(response);
                },
                error: function (response) {
                    console.log("Ошибка сервера");
                }
            });
        }
    });

    $(document).on('click', '.doctor-index .item .end', function (e) {

        var queueId = $(this).closest('.item').data('id');
        var doctorId = $('input[name="doctor-id"]').val();
        var action = $(this).closest('.action');

        if (!action.hasClass('block')) {
            $.ajax({
                type: "POST",
                url: "/doctor/finish-patient.php",
                data: {
                    "queue_id": queueId,
                    "doctor_id": doctorId,
                },
                cache: false,

                success: function (response) {
                    $('.queue-list-ajax').html(response);
                },
                error: function (response) {
                    console.log("Ошибка сервера");
                }

            });
        }
    });

});

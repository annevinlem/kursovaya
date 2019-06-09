$(document).ready(function () {

    var doctorId = $('input[name="doctor_id"]').val();

    setInterval(function () {
        updateScreen(doctorId);
    }, 2000);

});

function updateScreen(doctorId) {
    $.ajax({
        type: "POST",
        url: "/terminal/update-screen.php",
        data: {
            "doctor_id": doctorId,
        },
        cache: false,

        success: function (response) {
            $('.queue-info').html(response);
            console.log(response);
        },
        error: function (response) {
            console.log("Ошибка сервера");
        }
    });
}
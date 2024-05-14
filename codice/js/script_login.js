$(document).ready(function() {
    $('form').on('submit', function(e) {
        //la form non viene inviata
        e.preventDefault();
        //richiesta ajax
        $.ajax({
            type: "POST",
            url: "checkLogin.php",
            data: {
                username: $('#username').val(),
                password: CryptoJS.MD5($('#password').val()).toString()
            },
            success: function(response) {
                $('#response').html(response);
            },
            error: function() {
                $('#response').html("Si è verificato un errore.");
            }
        });
    });
});
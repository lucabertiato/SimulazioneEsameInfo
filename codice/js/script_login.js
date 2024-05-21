function login(){
    //richiesta ajax
    $.ajax({
        type: "POST",
        url: "../service/checkLogin.php",
        data: {
            username: $('#username').val(),
            password: CryptoJS.MD5($('#password').val()).toString()
        },
        success: function(response) {
            //response = JSON.parse(response);
            if (response.status == "success"){
                window.location.href = "./map.php";
            }
            else {
                alert("Invalid credentials");
            }
        },
        error: function() {
            $('#response').html("credenziali errate");
        }
    });
}
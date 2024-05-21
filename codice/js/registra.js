function registrazione(){
    //richiesta ajax
    $.ajax({
        type: "POST",
        url: "../service/insertUtente.php",
        data: {
            username: $('#username').val(),
            password: CryptoJS.MD5($('#password').val()).toString(),
            email: $('#email').val(),
            nome: $('#nome').val(),
            cognome: $('#cognome').val(),
            indirizzo: cambiaIndirizzo($('#indirizzo').val())
        },
        success: function(response) {
            if (response.status == "success"){
                $('#response').html(response.message + ' <a href="login.php"> Autenticati</a>');
            }
            else {
                $('#response').html(response.message);
            }
        },
        error: function() {
            $('#response').html("errore nella registrazione");
        }
    });
}

function cambiaIndirizzo(str) {
    if (typeof str !== 'string') {
        console.error('cambiaIndirizzo: expected a string but got', typeof str);
        return '';
    }
    var tmp = str.replace(/\b\w/g, char => char.toUpperCase());
    console.log(tmp);
    return tmp;
}
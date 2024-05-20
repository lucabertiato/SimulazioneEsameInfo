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
            indirizzo: cambiaIndirizzo($('#indirizzo'))
        },
        success: function(response) {
            if (response.status == "success"){
                window.location.href = "./login.php";
            }
            else {
                $('#response').html("Errore nell'inserimento dei dati");
            }
        },
        error: function() {
            $('#response').html("credenziali errate");
        }
    });
}

function cambiaIndirizzo(str) {
    var tmp = str.replace(/\b\w/g, char => char.toUpperCase());
    console.log(tmp);
    return tmp
}
  
function registrazione() {
    // Genera un codice univoco per la tessera
    controllaTessera().then(function(code) {
        // Effettua la richiesta AJAX con il codice generato
        $.ajax({
            type: "POST",
            url: "../service/insertUtente.php",
            data: {
                username: $('#username').val(),
                password: CryptoJS.MD5($('#password').val()).toString(),
                email: $('#email').val(),
                nome: $('#nome').val(),
                cognome: $('#cognome').val(),
                indirizzo: cambiaIndirizzo($('#indirizzo').val()),
                code: code
            },
            success: function(response) {
                if (response.status == "success") {
                    $('#response').html(response.message + ' <a href="login.php"> Autenticati</a>');
                } else {
                    $('#response').html(response.message);
                }
            },
            error: function() {
                $('#response').html("Errore nella registrazione");
            }
        });
    }).catch(function(error) {
        console.error(error);
    });
}

function controllaTessera() {
    return new Promise(function(resolve, reject) {
        let code;
        $.ajax({
            type: "POST",
            url: "../service/getTessere.php", 
            dataType: "json",
            success: function(response) {
                if (response.status == "success") {
                    let existingCodes = response.tessere;
                    do {
                        code = generateRandomCode();
                    } while (existingCodes.includes(code)); 
                    resolve(code); 
                } else {
                    reject("Errore nel recupero dei codici dal database");
                }
            },
            error: function() {
                reject("Errore nella richiesta al server");
            }
        });
    });
}

function generateRandomCode() {
    let code = "S";
    const characters = "0123456789";
    const charactersLength = characters.length;
    for (let i = 0; i < 5; i++) {
        code += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return code;
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

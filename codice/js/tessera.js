$(document).ready(caricaTessere());

function caricaTessere(){
    $.ajax({
        url: '../service/getDatiTessere.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var tableBody = $('#tessereTable tbody');
            tableBody.empty(); // Pulisce la tabella
            data.forEach(function (tessere) {
                let c;
                if(tessere.stato == 1)
                    c = '<button class="btn btn-danger" onclick="blocca(\'' + tessere.numero + '\')">Blocca</button>';
                else
                    c = '<button class="btn btn-primary" onclick="sblocca(\'' + tessere.numero + '\')">Sblocca</button>';
                var row = '<tr>' +
                    '<td>' + tessere.email + '</td>' +
                    '<td>' + tessere.numero + '</td>' +
                    '<td>' + tessere.stato + '</td>' +
                    '<td>' + c + '</td>' +
                    '</tr>';
                tableBody.append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

/*
implemento anche la blocca dal lato admin che puo scegliere di bloccare un utente per qualche motivo
 */
function blocca(numero){
    $.ajax({
        url: '../service/tesseraPersa.php',
        type: 'POST',
        data: {
            tessera: numero
        },
        success: function(response) {
            //ricarico
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
            alert('Si è verificato un errore durante la richiesta di blocco della tessera');
        }
    });
}

function sblocca(numero) {
    // Genera un codice univoco per la tessera
    controllaTessera().then(function(code) {
        // Effettua la richiesta AJAX con il codice generato
        $.ajax({
            type: "POST",
            url: "../service/updateTessera.php",
            data: {
                vecchia: numero,
                nuova: code
            },
            success: function(response) {
                if (response.status == "success") {
                    caricaTessere();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert("Errore nella richiesta di sblocco della tessera");
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

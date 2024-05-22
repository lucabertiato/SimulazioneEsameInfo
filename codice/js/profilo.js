$(document).ready(function() {
    //faccio richiesta per prendere lo stato della carta di credito e metto dei campi nel caso
    $.ajax({
        type: "POST",
        url: "../service/getStatoCC.php",
        data: {},
        success: function(response) {
            if (response.status != "success"){
                var htmlContent = `
                <h4>Inserisci carta di credito</h4>
                <input type="text" class="form-control input-margin" pattern="\\d{16}" placeholder="Numero Carta di Credito" aria-label="Numero Carta di Credito" id="numeroCC">
                <input type="text" class="form-control input-margin" placeholder="Titolare" aria-label="Titolare" id="titolare">
                <input type="text" class="form-control input-margin" pattern="\\d{3}" placeholder="CVV" aria-label="CVV" id="cvv">
                <input type="text" class="form-control input-margin" pattern="(0[1-9]|1[0-2])\\/\\d{2}" placeholder="Scadenza (MM/AA)" aria-label="Scadenza (MM/AA)" id="scadenza">
                <button type="submit" class="btn btn-primary btn-margin" onclick="insertCC()">Aggiorna dati</button>
                <p class="paragraph-margin" id="response"></p>`;
                $('#cc').html(htmlContent);
            }
        },
        error: function() {
            $('#response').html("errore nell'inserimento");
        }
    });
    //altra richiesta per la zona di modifica dei dati
    $.ajax({
        type: "POST",
        url: "../service/getDatiCliente.php",
        data: {},
        success: function(response) {
            if (response.status == "success"){  
                var htmlContent = `
                <h4>Modifica dati profilo</h4>
                <input type="email" class="form-control input-margin" placeholder="email" aria-label="email" id="email" value="${response.data.email}">
                <input type="text" class="form-control input-margin" placeholder="username" aria-label="username" id="username" value="${response.data.username}">
                <input type="text" class="form-control input-margin" placeholder="nome" aria-label="nome" id="nome" value="${response.data.nome}">
                <input type="text" class="form-control input-margin" placeholder="cognome" aria-label="cognome" id="cognome" value="${response.data.cognome}">
                <input type="password" class="form-control input-margin" placeholder="password" aria-label="password" id="password">
                <button type="submit" class="btn btn-primary btn-margin" onclick="updateData()">Aggiorna profilo</button>
                <p class="paragraph-margin" id="response"></p>`;
                $('#dati').html(htmlContent);
            }
        },
        error: function() {
            $('#response').html("errore nell'inserimento");
        }
    });
    //altra richiesta per la zona di modifica dei dati dell'indirizzo
    $.ajax({
        type: "POST",
        url: "../service/getDatiIndirizzo.php",
        data: {},
        success: function(response) {
            if (response.status == "success"){  
                var htmlContent = `
                <h4>Modifica dati indirizzo</h4>
                <input type="text" class="form-control input-margin" placeholder="via" aria-label="via" id="via" value="${response.data.Via}">
                <input type="number" class="form-control input-margin" placeholder="numero" aria-label="numero" id="numero" value="${response.data.NumeroCivico}">
                <button type="submit" class="btn btn-primary btn-margin" onclick="updateIndirizzo()">Aggiorna indirizzo</button>
                <p class="paragraph-margin" id="response"></p>`;
                $('#indirizzo').html(htmlContent);
            }
        },
        error: function() {
            $('#response').html("errore nell'inserimento");
        }
    });
});

function isValidCreditCardNumber(number) {
    return /^\d{16}$/.test(number);
}

function isValidCVV(cvv) {
    return /^\d{3}$/.test(cvv);
}

function isValidExpiryDate(date) {
    return /^(0[1-9]|1[0-2])\/\d{2}$/.test(date);
}

function updateIndirizzo(){
    var via = $('#via').val();
    var numero = $('#numero').val();
    $.ajax({
        type: "POST",
        url: "../service/updateIndirizzo.php",
        data: {
            via: via,
            numero: numero
        },
        success: function(response) {
            if (response.status == "success") {
                location.reload();
            } else {
                $('#response').html(response.message);
            }
        },
        error: function() {
            $('#response').html("Errore nell'inserimento");
        }
    });
}

function updateData(){
    var username = $('#username').val();
    var email = $('#email').val();
    var nome = $('#nome').val();
    var cognome = $('#cognome').val();
    var password = '';
    if($('#password').val().trim() !== '') {
        password = CryptoJS.MD5($('#password').val()).toString();
    }

    $.ajax({
        type: "POST",
        url: "../service/updateProfilo.php",
        data: {
            username: username,
            email: email,
            nome: nome,
            cognome: cognome,
            password: password
        },
        success: function(response) {
            if (response.status == "success") {
                location.reload();
            } else {
                $('#response').html(response.message);
            }
        },
        error: function() {
            $('#response').html("Errore nell'inserimento");
        }
    });
}

function insertCC(){
    //variabili
    var numeroCC = $('#numeroCC').val();
    var titolare = $('#titolare').val();
    var cvv = $('#cvv').val();
    var scadenza = $('#scadenza').val();
    //controlli
    if (!isValidCreditCardNumber(numeroCC)) {
        $('#response').html("Numero di carta di credito non valido. Deve contenere 16 cifre.");
        return;
    }

    if (!isValidCVV(cvv)) {
        $('#response').html("CVV non valido. Deve contenere 3 cifre.");
        return;
    }

    if (!isValidExpiryDate(scadenza)) {
        $('#response').html("Data di scadenza non valida. Deve essere nel formato MM/AA.");
        return;
    }
    //richiesta
    $.ajax({
        type: "POST",
        url: "../service/updateCC.php",
        data: {
            titolare: titolare,
            cvv: CryptoJS.MD5(cvv).toString(),
            scadenza: scadenza,
            numeroCC: CryptoJS.MD5(numeroCC).toString(),
            idUtente: $('#userID').val()
        },
        success: function(response) {
            if (response.status == "success") {
                location.reload();
            } else {
                $('#response').html(response.message);
            }
        },
        error: function() {
            $('#response').html("Errore nell'inserimento");
        }
    });
}
$(document).ready(function() {
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
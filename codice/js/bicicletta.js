$(document).ready(caricaTabella());

function caricaTabella() {
    //prendo le bici
    $.ajax({
        url: '../service/getBiciclette.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var tableBody = $('#bicicletteTable tbody');
            tableBody.empty(); // Pulisce la tabella
            data.forEach(function (bici) {
                let c;
                if((bici.lat !== null && bici.lon == 0) || (bici.lat !== 0 && bici.lon == 0))
                    c = "Posizione impossibile da rilevare";
                else
                    c = bici.lat + ' ' + bici.lon;
                
                if (bici.stato == 0)
                    var s = "Libera";
                else
                    var s = "Noleggiata";
                var row = '<tr>' +
                    '<td>' + bici.id + '</td>' +
                    '<td>' + bici.rfid + '</td>' +
                    '<td>' + bici.gps + '</td>' +
                    '<td>' + bici.km + '</td>' +
                    '<td>' + c + '</td>' +
                    '<td>' + s + '</td>' +
                    '<td><button class="btn btn-primary" onclick="modifica(' + bici.id + ')">Modifica</button></td>' +
                    '<td><button class="btn btn-danger" onclick="elimina(' + bici.id + ', \'' + bici.rfid + '\')">Elimina</button></td>' +
                    '</tr>';
                tableBody.append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
    //popolo la select
    $.ajax({
        url: '../service/getStazioni.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var select = $('#stazione');
            select.empty(); // Pulisce la select
            var row = "<option value= null disabled selected>Seleziona una stazione</option>";
            select.append(row);
            data.forEach(function (stazione) {
                var row = "<option value= " + stazione.id + ">" + stazione.nome + "</option>";
                select.append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function popolaStazioni(id) {
    $.ajax({
        url: '../service/getStazioni.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var select = $('#mod_stazione');
            select.empty(); // Pulisce la select
            data.forEach(function (stazione) {
                var row;
                if (id == stazione.id) {
                    row = "<option value='" + stazione.id + "' selected>" + stazione.nome + "</option>";
                } else {
                    row = "<option value='" + stazione.id + "'>" + stazione.nome + "</option>";
                }
                select.append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function addBicicletta() {
    $.ajax({
        type: "POST",
        url: "../service/insertBicicletta.php",
        data: {
            rfid: $('#rfid').val(),
            gps: $('#gps').val(),
            stazione: $('#stazione').val(),
        },
        success: function (response) {
            if (response.status == "success") {
                location.reload();
                $('#response').html(response.message);
            }
            else {
                $('#response').html(response.message);
            }
        },
        error: function () {
            $('#response').html("errore nella registrazione");
        }
    });
}

function modifica(id) {
    // Chiamata AJAX per ottenere i dati della stazione
    $.ajax({
        url: '../service/getSingolaBici.php',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function (data) {
            if (data.status === 'success') {
                // Popola gli input con i dati della stazione
                $('#mod_rfid').val(data.data.tagRFID);
                $('#mod_gps').val(data.data.gps);
                $('#mod_id').val(id);
                $('#mod_id_stazione').val(data.data.idStazione);
                if (data.data.stato != 1) {
                    //riempio la select e metto tutte le stazioni con quelle selezionate
                    $('#mod_stazione').empty();
                    popolaStazioni(data.data.idStazione);
                }
                else {
                    $('#mod_stazione').hide();
                }
                // Mostra il div di modifica
                $('#modifica').show();
            } else {
                console.error('Errore nel recupero dei dati della stazione:', data.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function salvaModifiche() {
    // Ottieni i valori aggiornati dalla form di modifica
    var id = $('#mod_id').val();
    var idStazionePrec = $('#mod_id_stazione').val();
    var idStazioneNew = $('#mod_stazione').val();
    var rfid = $('#mod_rfid').val();
    var gps = $('#mod_gps').val();
    let data = {};
    if (idStazioneNew == idStazionePrec) {
        data = { id: id, rfid: rfid, gps: gps };
    }
    else {
        data = { id: id, rfid: rfid, gps: gps, idStazione: idStazioneNew };
    }

    // Effettua una chiamata AJAX per salvare le modifiche
    $.ajax({
        url: '../service/updateBicicletta.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            if (data.status === 'success') {
                caricaTabella();
                $('#modifica').hide();
                //$('#modificaResponse').text('Modifica salvata con successo').removeClass('text-danger').addClass('text-success');
            } else {
                // Se c'è stato un errore nell'aggiornamento, mostra un messaggio di errore
                $('#modificaResponse').text('Errore nel salvataggio delle modifiche: ' + data.message).removeClass('text-success').addClass('text-danger');
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
            $('#modificaResponse').text('Errore nella richiesta AJAX: ' + status).removeClass('text-success').addClass('text-danger');
        }
    });
}

function elimina(id, tagRFID) {
    if (confirm('Sei sicuro di voler eliminare la bicicletta "' + tagRFID + '"?')) {
        $.ajax({
            url: '../service/eliminaBicicletta.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                alert('Bicicletta eliminata con successo');
                // Ricarica la tabella delle stazioni
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Errore nella richiesta AJAX:', status, error);
                alert('Si è verificato un errore durante l\'eliminazione della bicicletta.');
            }
        });
    }
}
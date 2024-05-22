function addStazioni() {
    // richiesta per latitudine e longitudine
    getCoordinates(function (coordinates) {
        if (coordinates && coordinates.length === 2) {
            //alert("Latitudine: " + coordinates[0] + ", Longitudine: " + coordinates[1]);
            //richiesta di inserimento nel db
            $.ajax({
                type: "POST",
                url: "../service/insertStazione.php",
                data: {
                    nome: $('#nome').val(),
                    slot: $('#slot').val(),
                    numero: $('#numero').val(),
                    indirizzo: cambiaIndirizzo($('#indirizzo').val()),
                    lat: coordinates[0],
                    lon: coordinates[1]
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
        } else {
            alert("Indirizzo non trovato");
        }
    });
}

function getCoordinates(callback) {
    // Splitta indirizzo
    var address = $('#indirizzo').val();
    var houseNumber = $('#numero').val();
    var street = encodeURIComponent(address);
    houseNumber = encodeURIComponent(houseNumber);
    var city = encodeURIComponent($('#city').val());
    var neighborhood = encodeURIComponent($('#neighborhood').val());
    var province = encodeURIComponent($('#province').val());
    var country = encodeURIComponent($('#country').val());
    var fullAddress = street + ' ' + houseNumber + ', ' + city;

    if (neighborhood.trim() !== '') {
        fullAddress += ', ' + neighborhood;
    }
    fullAddress += ', ' + province + ', ' + country;
    var url = 'https://nominatim.openstreetmap.org/search?q=' + fullAddress + '&format=json&addressdetails=1';

    var coordinates = [];

    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            if (data.length > 0) {
                coordinates.push(data[0].lat);
                coordinates.push(data[0].lon);
                callback(coordinates);
            } else {
                callback(null);
            }
        },
        error: function (xhr, status, error) {
            callback(null);
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

function elimina(id, nome) {
    if (confirm('Sei sicuro di voler eliminare la stazione "' + nome + '"?')) {
        $.ajax({
            url: '../service/eliminaStazione.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                alert('Stazione eliminata con successo');
                // Ricarica la tabella delle stazioni
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Errore nella richiesta AJAX:', status, error);
                alert('Si è verificato un errore durante l\'eliminazione della stazione.');
            }
        });
    }
}

function modifica(id) {
    // Chiamata AJAX per ottenere i dati della stazione
    $.ajax({
        url: '../service/getSingolaStazione.php',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(data) {
            if (data.status === 'success') {
                // Popola gli input con i dati della stazione
                $('#mod_nome').val(data.data.nome);
                $('#mod_slot').val(data.data.numeroSlot);
                $('#mod_id').val(id);
                // Mostra il div di modifica
                $('#modifica').show();
            } else {
                console.error('Errore nel recupero dei dati della stazione:', data.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function salvaModifiche() {
    // Ottieni i valori aggiornati dalla form di modifica
    var id = $('#mod_id').val();
    var nome = $('#mod_nome').val();
    var numeroSlot = $('#mod_slot').val();

    // Effettua una chiamata AJAX per salvare le modifiche
    $.ajax({
        url: '../service/updateStazione.php',
        type: 'POST',
        data: {
            id: id,
            nome: nome,
            numeroSlot: numeroSlot
        },
        dataType: 'json',
        success: function(data) {
            if (data.status === 'success') {
                location.reload();
                $('#modifica').hide();
                $('#modificaResponse').text('Modifica salvata con successo').removeClass('text-danger').addClass('text-success');
            } else {
                // Se c'è stato un errore nell'aggiornamento, mostra un messaggio di errore
                $('#modificaResponse').text('Errore nel salvataggio delle modifiche: ' + data.message).removeClass('text-success').addClass('text-danger');
            }
        },
        error: function(xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
            $('#modificaResponse').text('Errore nella richiesta AJAX: ' + status).removeClass('text-success').addClass('text-danger');
        }
    });
}



$(document).ready(function () {
    $.ajax({
        url: '../service/getStazioni.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var tableBody = $('#stazioniTable tbody');
            tableBody.empty(); // Pulisce la tabella
            data.forEach(function (stazione) {
                var row = '<tr>' +
                    '<td>' + stazione.nome + '</td>' +
                    '<td>' + stazione.numeroSlot + '</td>' +
                    '<td>' + stazione.via + '</td>' +
                    '<td>' + stazione.numeroCivico + '</td>' +
                    '<td><button class="btn btn-primary" onclick="modifica(' + stazione.id + ', \'' + stazione.nome + '\')">Modifica</button></td>' +
                    '<td><button class="btn btn-danger" onclick="elimina(' + stazione.id + ', \'' + stazione.nome + '\')">Elimina</button></td>' +
                    '</tr>';
                tableBody.append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
});
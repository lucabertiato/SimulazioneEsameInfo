$(document).ready(function () {
    // Carica le operazioni dell'utente dal server
    $.ajax({
        url: '../service/getRiepilogo.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let operazioni = response.operazioni;
                let table = $('#operazioniTable tbody');
                table.empty();
                operazioni.forEach(function (operazione) {
                    // Controlla se il nome della stazione è null
                    let nomeStazione = operazione.NomeStazione ? operazione.NomeStazione : 'Nessuna stazione';
                    // Verifica se l'operazione è in corso
                    let inCorso = operazione.tipo === 'Noleggio' && operazione.KMpercorsi == 0 ? 'Sì' : 'No';
                    table.append(`<tr>
                        <td>${operazione.tipo}</td>
                        <td>${operazione.dataora}</td>
                        <!--<td>${operazione.KMpercorsi}</td>-->
                        <td>${operazione.tagRFID}</td>
                        <td>${nomeStazione}</td>
                        <td>${inCorso}</td>
                    </tr>`);
                });
            } else {
                alert('Errore nel recupero delle operazioni.');
            }
        },
        error: function () {
            alert('Errore nella richiesta al server.');
        }
    });
});

<?php
header('Content-Type: application/json');

session_start();

// Credenziali per il database
$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

//connessione
$conn = new mysqli($host, $user, $psw, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Connessione fallita: " . $conn->connect_error)));
}

// Prendi i dati dalla richiesta POST
$tipo_operazione = $_POST['tipo_operazione'];
$id_bicicletta = $_POST['id_bicicletta'];
$tessera = $_POST['tessera'];

// Inizializza le variabili per l'ID della stazione e i KM percorsi
$id_stazione = null;
$km_percorsi = 0;

// Se l'operazione è di riconsegna, prendi anche l'ID della stazione e i KM percorsi
if ($tipo_operazione == "Riconsegna") {
    $id_stazione = $_POST['id_stazione'];
    $km_percorsi = $_POST['km_percorsi'];
}

//controllo se la tessera è attiva o meno
$query_check_tessera = "SELECT tessera_attiva FROM clienti WHERE tessera = ?";
$stmt_check_tessera = $conn->prepare($query_check_tessera);
$stmt_check_tessera->bind_param("s", $tessera);
$stmt_check_tessera->execute();
$result_check_tessera = $stmt_check_tessera->get_result();
$row_tessera = $result_check_tessera->fetch_assoc();
//se la tessera è persa o bloccata non fare più nulla   
if($row_tessera['tessera_attiva'] == 0){
    echo json_encode(array("status" => "error", "message" => "Tessera non attiva. Impossibile effettuare operazioni"));
    die();
}
//altrimenti posso proseguire
//controllo se la bicicletta si trova presso una qualcunque stazione
$query_check = "SELECT stato FROM bici WHERE ID = ?";
$stmt_check = $conn->prepare($query_check);
$stmt_check->bind_param("i", $id_bicicletta);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    $row = $result_check->fetch_assoc();
    $stato_bicicletta = $row['stato'];
    if ($stato_bicicletta == 0 && $tipo_operazione == "Noleggio") {
        $query_check = "SELECT stato FROM bici WHERE ID = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param("i", $id_bicicletta);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        $query = "INSERT INTO operazione (tipo, dataora, KMpercorsi, IDbici, tessera, IDstazione) VALUES (?, NOW(), 0, ?, ?, NULL)";
        $stmt = $conn->prepare($query);
        //metto i parametri
        $stmt->bind_param("sis", $tipo_operazione, $id_bicicletta, $tessera);
        //eseguo
        if ($stmt->execute()) {
            //aggiorno stato bici
            $stato_bicicletta = 1;
            $query_update = "UPDATE bici SET stato = ? WHERE ID = ?";
            $stmt_update = $conn->prepare($query_update);
            $stmt_update->bind_param("ii", $stato_bicicletta, $id_bicicletta);
            //
            if ($stmt_update->execute()) {
                $query_stazione_info = "SELECT i.Via AS Via, i.NumeroCivico AS NumeroCivico, i.lat AS Latitudine, i.lon AS Longitudine
                                        FROM operazione AS o
                                        JOIN stazione AS s ON o.IDstazione = s.ID
                                        JOIN indirizzi AS i ON s.IDindirizzo = i.ID
                                        WHERE o.tipo = 'Riconsegna' AND o.IDbici = ? 
                                        ORDER BY o.dataora DESC
                                        LIMIT 1";
                $stmt_stazione_info = $conn->prepare($query_stazione_info);
                $stmt_stazione_info->bind_param("i", $id_bicicletta);
                $stmt_stazione_info->execute();
                $result_stazione_info = $stmt_stazione_info->get_result();

                if ($result_stazione_info->num_rows > 0) {
                    $row_stazione_info = $result_stazione_info->fetch_assoc();
                    $latitudine_stazione = $row_stazione_info['Latitudine'];
                    $longitudine_stazione = $row_stazione_info['Longitudine'];

                    // Aggiornare latitudine e longitudine della bicicletta
                    $query_update_bicicletta = "UPDATE bici SET lat = ?, lon = ? WHERE ID = ?";
                    $stmt_update_bicicletta = $conn->prepare($query_update_bicicletta);
                    $stmt_update_bicicletta->bind_param("ddi", $latitudine_stazione, $longitudine_stazione, $id_bicicletta);

                    if ($stmt_update_bicicletta->execute()) {
                        // Operazione eseguita con successo
                        echo json_encode(array("status" => "success", "message" => "Operazione inserita con successo"));
                    } else {
                        // Errore durante l'aggiornamento dei dati della bicicletta
                        echo json_encode(array("status" => "error", "message" => "Errore durante l'aggiornamento dei dati della bicicletta: " . $stmt_update_bicicletta->error));
                    }
                } else {
                    // Nessuna informazione sulla stazione trovata
                    echo json_encode(array("status" => "error", "message" => "Nessuna informazione sulla stazione trovata"));
                }
            } else {
                echo json_encode(array("status" => "error", "message" => "Errore durante l'aggiornamento dello stato della bicicletta: " . $stmt_update->error));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Errore durante l'inserimento dell'operazione: " . $stmt->error));
        }
    } elseif ($stato_bicicletta == 1 && $tipo_operazione == "Riconsegna") {
        //controllo se cè spazio nella stazione
        $query_stazione = "SELECT stazione.Nome AS NomeStazione, stazione.NumeroSlot, IFNULL(COUNT(DISTINCT operazione.IDbici), 0) AS NumeroBiciclette 
                           FROM stazione 
                           LEFT JOIN operazione ON stazione.ID = operazione.IDstazione AND operazione.tipo = 'Riconsegna' 
                           LEFT JOIN bici ON operazione.IDbici = bici.ID
                           WHERE stazione.ID = ?
                           GROUP BY stazione.Nome, stazione.NumeroSlot
                           HAVING NumeroBiciclette < stazione.NumeroSlot";
        $stmt_stazione = $conn->prepare($query_stazione);
        $stmt_stazione->bind_param("i", $id_stazione);
        $stmt_stazione->execute();
        $result_stazione = $stmt_stazione->get_result();

        if ($result_stazione->num_rows > 0) {
            $query = "INSERT INTO operazione (tipo, dataora, KMpercorsi, IDbici, tessera, IDstazione) VALUES (?, NOW(), ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("siisi", $tipo_operazione, $km_percorsi, $id_bicicletta, $tessera, $id_stazione);
            if ($stmt->execute()) {
                //aggiorno stato bici
                $stato_bicicletta = 0;
                $query_update = "UPDATE bici SET stato = ? WHERE ID = ?";
                $stmt_update = $conn->prepare($query_update);
                $stmt_update->bind_param("ii", $stato_bicicletta, $id_bicicletta);
                //
                if ($stmt_update->execute()) {
                    $query_stazione_info = "SELECT i.lat, i.lon FROM stazione JOIN indirizzi as i ON i.ID = stazione.IDindirizzo WHERE stazione.ID = ?";
                    $stmt_stazione_info = $conn->prepare($query_stazione_info);
                    $stmt_stazione_info->bind_param("i", $id_stazione);
                    $stmt_stazione_info->execute();
                    $result_stazione_info = $stmt_stazione_info->get_result();

                    if ($result_stazione_info->num_rows > 0) {
                        $row_stazione_info = $result_stazione_info->fetch_assoc();
                        $latitudine_stazione = $row_stazione_info['lat'];
                        $longitudine_stazione = $row_stazione_info['lon'];

                        // Aggiornare latitudine e longitudine della bicicletta
                        $query_update_bicicletta = "UPDATE bici SET lat = ?, lon = ? WHERE ID = ?";
                        $stmt_update_bicicletta = $conn->prepare($query_update_bicicletta);
                        $stmt_update_bicicletta->bind_param("ddi", $latitudine_stazione, $longitudine_stazione, $id_bicicletta);

                        if ($stmt_update_bicicletta->execute()) {
                            // Operazione eseguita con successo
                            echo json_encode(array("status" => "success", "message" => "Operazione inserita con successo"));
                        } else {
                            // Errore durante l'aggiornamento dei dati della bicicletta
                            echo json_encode(array("status" => "error", "message" => "Errore durante l'aggiornamento dei dati della bicicletta: " . $stmt_update_bicicletta->error));
                        }
                    } else {
                        // Nessuna informazione sulla stazione trovata
                        echo json_encode(array("status" => "error", "message" => "Nessuna informazione sulla stazione trovata"));
                    }
                } else {
                    // Nessuna informazione sulla stazione trovata
                    echo json_encode(array("status" => "error", "message" => "Nessuna informazione sulla stazione trovata"));
                }
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Nessun slot disponibile nella stazione scelta"));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "La bicicletta non è disponibile per l'operazione richiesta"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Bicicletta non trovata"));
}

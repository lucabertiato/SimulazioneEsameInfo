<?php
header('Content-Type: application/json');
session_start();

// Credenziali per il database
$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

// Connessione al database
$conn = new mysqli($host, $user, $psw, $dbname);

// Check connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Prendo i dati
$rfid = $_POST['rfid'];
$gps = $_POST['gps'];
if(isset($_POST['idStazione'])){
    $idStazione = $_POST['idStazione'];
}
$id = $_POST['id'];

// Query per aggiornare i dati della bicicletta
$query = "UPDATE `bici` SET `tagRFID`=?, `gps`=? WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $rfid, $gps, $id);

// Eseguo l'aggiornamento dei dati della bicicletta
if ($stmt->execute()) {
    // Controllo se è settato l'ID della stazione
    if (isset($_POST['idStazione'])) {
        // Query che cerca se la stazione in cui si vuole inserire è libera
        $query1 = "SELECT stazione.Nome AS NomeStazione, stazione.NumeroSlot, IFNULL(COUNT(DISTINCT operazione.IDbici), 0) AS NumeroBiciclette, SUM(CASE WHEN bici.stato IS NULL THEN 1 ELSE 0 END) AS BicicletteStatoNull, SUM(CASE WHEN bici.stato IS NOT NULL THEN 1 ELSE 0 END) AS BicicletteStatoNonNull
                    FROM stazione 
                    LEFT JOIN operazione ON stazione.ID = operazione.IDstazione AND operazione.tipo = 'Riconsegna' 
                    LEFT JOIN bici ON operazione.IDbici = bici.ID
                    WHERE stazione.ID = ?
                    GROUP BY stazione.Nome, stazione.NumeroSlot
                    HAVING (NumeroBiciclette < stazione.NumeroSlot OR BicicletteStatoNull > 0) AND BicicletteStatoNonNull < stazione.NumeroSlot";
        // Preparazione ed esecuzione della query
        $stmt1 = $conn->prepare($query1);
        $stmt1->bind_param("i", $idStazione);
        $stmt1->execute();
        $result = $stmt1->get_result();
        
        // Se la stazione è libera, procedo con l'inserimento dell'operazione di riconsegna
        if ($result->num_rows > 0) {
            $query = "INSERT INTO operazione (tipo, dataora, KMpercorsi, IDbici, IDcliente, IDstazione) VALUES ('Riconsegna', NOW(), 0, ?, NULL, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $id, $idStazione);
            if ($stmt->execute()) {
                echo json_encode(array("status" => "success", "message" => "Bicicletta inserita con successo"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Errore durante l'inserimento dell'operazione di riconsegna"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Impossibile spostare la bicicletta"));
        }
    } else {
        // Se l'ID della stazione non è settato, restituisco un messaggio di successo per la modifica della bicicletta
        echo json_encode(array("status" => "success", "message" => "Modifica della bicicletta avvenuta con successo"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Errore durante l'aggiornamento dei dati della bicicletta"));
}

// Chiudo la connessione al database
$conn->close();

<?php
header('Content-Type: application/json');
session_start();

// solo admin
if (!isset($_SESSION['is_logged']) || $_SESSION['ruolo'] !== 'admin') {
    echo json_encode(array("status" => "error", "message" => "Non autorizzato"));
    exit();
}


//credenziali per il db
$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

//connessione al database
$conn = new mysqli($host, $user, $psw, $dbname);

//check connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

//prendo dati
$rfid = $_POST['rfid'];
$gps = $_POST['gps'];
$stazione = $_POST['stazione'];

//controllo se presente già qualche bici con queste credenziali univoche
$query = "SELECT * FROM bici WHERE tagRFID = ? or gps = ?";
//preparazione
$stmt = $conn->prepare($query);
//metto i parametri
$stmt->bind_param("ss", $rfid, $gps);
//eseguo
$stmt->execute();
//prendo i risultati
$result = $stmt->get_result();
//se trovo un risultato non posso inserire un nuovo utente
if ($result->num_rows > 0) {
    $conn->close();
    echo json_encode(array("status" => "error", "message" => "dati bicliclette gia utilizzati"));
    exit();
}
//query che cerca se la stazione in cui si vuole inserire è libera
$query = "SELECT stazione.Nome AS NomeStazione, stazione.NumeroSlot, IFNULL(COUNT(DISTINCT operazione.IDbici), 0) AS NumeroBiciclette, SUM(CASE WHEN bici.stato IS NULL THEN 1 ELSE 0 END) AS BicicletteStatoNull, SUM(CASE WHEN bici.stato IS NOT NULL THEN 1 ELSE 0 END) AS BicicletteStatoNonNull
            FROM stazione 
            LEFT JOIN operazione ON stazione.ID = operazione.IDstazione AND operazione.tipo = 'Riconsegna' 
            LEFT JOIN bici ON operazione.IDbici = bici.ID
            WHERE stazione.ID = ?
            GROUP BY stazione.Nome, stazione.NumeroSlot
            HAVING (NumeroBiciclette < stazione.NumeroSlot OR BicicletteStatoNull > 0) AND BicicletteStatoNonNull < stazione.NumeroSlot";
//preparazione ed esecuzione
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $stazione);
$stmt->execute();
$result = $stmt->get_result();
//se trovo risultati significa che posso aggiungere
if ($result->num_rows > 0) {
    $query = "INSERT INTO bici (tagRFID, gps, stato) VALUES (?, ?, 0)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $rfid, $gps);
    if ($stmt->execute()) {
        $biciId = $stmt->insert_id;
        //inserisco un'operazione di riconsegna
        $query = "INSERT INTO operazione (tipo, dataora, KMpercorsi, IDbici, IDcliente, IDstazione) VALUES ('Riconsegna', NOW(), 0, ?, NULL, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $biciId, $stazione);
        if ($stmt->execute()) {
            echo json_encode(array("status" => "success", "message" => "Bicicletta inserita con successo"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Errore durante l'inserimento dell'operazione di riconsegna"));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Errore durante l'inserimento della bicicletta"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Nessun slot disponibile nella stazione scelta"));
}



<?php
header('Content-Type: application/json');
session_start();

// è necessario essere autenticati
if (!isset($_SESSION['is_logged'])) {
    echo json_encode(array("status" => "error", "message" => "Non autorizzato"));
    exit();
}

// Credenziali db
$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

// Connessione e controllo
$conn = new mysqli($host, $user, $psw, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Connessione fallita: " . $conn->connect_error)));
}

$tessera = $_SESSION['tessera'];


// Query per ottenere tutte le operazioni di un utente
$query = "SELECT operazione.*, bici.tagRFID, bici.gps, stazione.Nome AS NomeStazione
            FROM operazione
            JOIN bici ON operazione.IDbici = bici.ID
            LEFT JOIN stazione ON operazione.IDstazione = stazione.ID
            WHERE operazione.tessera = ?";

// Preparazione ed esecuzione
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $tessera);
$stmt->execute();
$result = $stmt->get_result();

$operazioni = array();
while ($row = $result->fetch_assoc()) {
    
    $operazioni[] = $row;
}

// Chiudi la connessione
$conn->close();

// Restituisci i dati in formato JSON
echo json_encode(array("status" => "success", "operazioni" => $operazioni));

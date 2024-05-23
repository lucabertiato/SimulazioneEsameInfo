<?php
header('Content-Type: application/json');
session_start();

// Credenziali del database
$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

// Connessione al database
$conn = new mysqli($host, $user, $psw, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Connessione fallita: " . $conn->connect_error)));
}

// Query per ottenere i numeri delle tessere
$query = "SELECT tessera FROM clienti";

// Esecuzione della query
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $tessere = array();
    // Scorro i risultati e aggiungo i numeri delle tessere all'array
    while ($row = $result->fetch_assoc()) {
        $tessere[] = $row['tessera'];
    }
    // Chiudo la connessione
    $conn->close();
    // Restituisco i numeri delle tessere in formato JSON
    echo json_encode(array("status" => "success", "tessere" => $tessere));
} else {
    // Se non ci sono tessere nel database, restituisco un messaggio di errore
    $conn->close();
    echo json_encode(array("status" => "error", "message" => "Nessuna tessera trovata nel database"));
}
?>

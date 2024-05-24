<?php
header('Content-Type: application/json');
session_start();

// Non è necessaria l'autenticazione

// Credenziali per il DB
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

// Query per ottenere latitudine, longitudine e nome delle stazioni
$query = "SELECT s.nome, i.lat, i.lon, s.numeroSlot
          FROM stazione s
          JOIN indirizzi i ON s.IDindirizzo = i.id";

// Preparazione
$stmt = $conn->prepare($query);

// Esecuzione
$stmt->execute();

// Prendere i risultati
$result = $stmt->get_result();

$stazioni = array();

// Estrarre i risultati
while ($row = $result->fetch_assoc()) {
    $stazioni[] = array(
        "nome" => $row['nome'],
        "lat" => $row['lat'],
        "slot" => $row['numeroSlot'],
        "lon" => $row['lon']
    );
}

// Restituire i risultati in formato JSON
echo json_encode($stazioni);

// Chiudere la connessione
$stmt->close();
$conn->close();
?>

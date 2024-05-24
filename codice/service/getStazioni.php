<?php
header('Content-Type: application/json');
session_start();

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

// Query per ottenere i dati delle stazioni
$query = "SELECT s.ID, s.Nome, s.NumeroSlot, i.Via, i.NumeroCivico 
          FROM stazione s
          JOIN indirizzi i ON s.IDindirizzo = i.ID";

// Esecuzione della query
$result = $conn->query($query);

$stazioni = array();

// Estrarre i risultati
while ($row = $result->fetch_assoc()) {
    $stazioni[] = array(
        "nome" => $row['Nome'],
        "numeroSlot" => $row['NumeroSlot'],
        "via" => $row['Via'],
        "id" => $row['ID'],
        "numeroCivico" => $row['NumeroCivico']
    );
}

// Restituire i risultati in formato JSON
echo json_encode($stazioni);

// Chiudere la connessione
$conn->close();
?>

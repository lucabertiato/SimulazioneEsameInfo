<?php
header('Content-Type: application/json');

session_start();
// Solo admin può modificare lo stato
if (!isset($_SESSION['is_logged']) || $_SESSION['ruolo'] !== 'admin') {
    echo json_encode(array("status" => "error", "message" => "Non autorizzato"));
    exit();
}

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

// Query per ottenere i dati delle tessere
$query = "SELECT clienti.email, clienti.tessera, clienti.tessera_attiva FROM clienti";

// Esecuzione della query
$result = $conn->query($query);

$c = array();

// Estrarre i risultati
while ($row = $result->fetch_assoc()) {
    $c[] = array(
        "email" => $row['email'],
        "numero" => $row['tessera'],
        "stato" => $row['tessera_attiva']
    );
}

// Restituire i risultati in formato JSON
echo json_encode($c);

// Chiudere la connessione
$conn->close();
<?php
header('Content-Type: application/json');

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

// Query per ottenere i dati delle biciclette
$query = "SELECT b.ID, b.gps, b.KMtotali, b.tagRFID, b.stato FROM bici b WHERE b.stato IS NOT NULL";

// Esecuzione della query
$result = $conn->query($query);

$bici = array();

// Estrarre i risultati
while ($row = $result->fetch_assoc()) {
    $bici[] = array(
        "id" => $row['ID'],
        "gps" => $row['gps'],
        "rfid" => $row['tagRFID'],
        "km" => $row['KMtotali'],
        "stato" => $row['stato']
    );
}

// Restituire i risultati in formato JSON
echo json_encode($bici);

// Chiudere la connessione
$conn->close();
?>

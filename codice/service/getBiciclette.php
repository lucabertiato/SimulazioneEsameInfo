<?php
header('Content-Type: application/json');
session_start();

// Solo admin può vedere le biciclette
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

// Query per ottenere i dati delle biciclette
$query = "SELECT b.ID, b.gps, b.KMtotali, b.tagRFID, b.stato, b.lat, b.lon FROM bici b WHERE b.stato IS NOT NULL";

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
        "lat" => $row['lat'],
        "lon" => $row['lon'],
        "stato" => $row['stato']
    );
}

// Restituire i risultati in formato JSON
echo json_encode($bici);

// Chiudere la connessione
$conn->close();
?>

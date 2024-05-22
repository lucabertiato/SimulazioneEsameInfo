<?php
header('Content-Type: application/json');
session_start();

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
$nome = $_POST['username'];
$slot = $_POST['slot'];
$indirizzo = $_POST['indirizzo'];
$lat = $_POST['lat'];
$lon = $_POST['lon'];


//gestisco indirizzo
//splitto per gli spazi
$indirizzoSplit = explode(' ', $indirizzo);
//prendo via e numero civico
$numeroCivico = array_pop($indirizzoSplit);
$via = implode(' ', $indirizzoSplit);

//controllo se presente già qualche utente con queste credenziali univoche
$query = "SELECT * FROM stazioni WHERE nome = ?";
//preparazione
$stmt = $conn->prepare($query);
//metto i parametri
$stmt->bind_param("s", $nome);
//eseguo
$stmt->execute();
//prendo i risultati
$result = $stmt->get_result();
//se trovo un risultato non posso inserire un nuovo utente
if ($result->num_rows > 0) {
    $conn->close();
    echo json_encode(array("status" => "error", "message" => "credenziali già utilizzate"));
    exit();
} else {
    //faccio insert per indirizzo
    $query = "INSERT INTO `indirizzi`(`ID`, `Via`, `NumeroCivico`, `lat`, `lon`) VALUES (NULL, ?, ?, ?, ?)";
    //preparazione
    $stmt = $conn->prepare($query);
    //metto i parametri
    $stmt->bind_param("ssdd", $via, $numeroCivico, $lat, $lon);
    //eseguo
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        $conn->close();
        echo json_encode(array("status" => "error", "message" => "Errore durante l'inserimento dell'indirizzo"));
        exit();
    }
    //prendo i risultati
    $last_id = $stmt->insert_id;

    //faccio insert per utente
    $query = "INSERT INTO `stazione`(`ID`, `Nome`, `NumeroSlot`, `IDindirizzo`) VALUES (NULL, ?, ?, ?)";
    //preparazione
    $stmt = $conn->prepare($query);
    //metto i parametri
    $stmt->bind_param("sii", $nome, $slot, $last_id);
    //eseguo
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        $conn->close();
        echo json_encode(array("status" => "error", "message" => "Errore durante l'inserimento della stazione"));
        exit();
    }
    $conn->close();
    echo json_encode(array("status" => "success", "message" => "Stazione creat con successo"));
    exit();
}

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
$username = $_POST['username'];
$password = $_POST['password'];
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$indirizzo = $_POST['indirizzo'];

//gestisco indirizzo
//splitto per gli spazi
$indirizzoSplit = explode(' ', $indirizzo);
//prendo via e numero civico
$numeroCivico = array_pop($indirizzoSplit);
$via = implode(' ', $indirizzoSplit);

//controllo se presente già qualche utente con queste credenziali univoche
$query = "SELECT * FROM clienti WHERE email = ? or username = ?";
//preparazione
$stmt = $conn->prepare($query);
//metto i parametri
$stmt->bind_param("ss", $email, $username);
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
    $query = "INSERT INTO `indirizzi`(`ID`, `Via`, `NumeroCivico`) VALUES (NULL, ?, ?)";
    //preparazione
    $stmt = $conn->prepare($query);
    //metto i parametri
    $stmt->bind_param("ss", $via, $numeroCivico);
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
    $query = "INSERT INTO `clienti`(`ID`, `email`, `username`, `password`, `nome`, `cognome`, `IDindirizzo`, `IDcarta`) VALUES (NULL,?,?,?,?,?,?,NULL)";
    //preparazione
    $stmt = $conn->prepare($query);
    //metto i parametri
    $stmt->bind_param("sssssi", $email, $username, $password, $nome, $cognome, $last_id);
    //eseguo
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        $conn->close();
        echo json_encode(array("status" => "error", "message" => "Errore durante l'inserimento dell'utente"));
        exit();
    }
    $last_id_utente = $stmt->insert_id;
    $_SESSION['carta'] = True;
    $conn->close();
    echo json_encode(array("status" => "success", "message" => "Utente creato con successo"));
    exit();
}

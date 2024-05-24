<?php
header('Content-Type: application/json');
session_start();

// è necessaria l'autenticazione
if (!isset($_SESSION['is_logged']) ) {
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

//prendo 
$id = $_SESSION['ID'];

$query = "SELECT tessera_attiva FROM clienti WHERE id=?";
//preparazione
$stmt = $conn->prepare($query);
//metto i parametri
$stmt->bind_param("i", $id);
//eseguo
$stmt->execute();
//prendo i risultati
$result = $stmt->get_result();
//tiro i risultati
$row = $result->fetch_assoc();
//controllo se pari a 1 vuol dire che attiva e potrei averla persa
if($row["tessera_attiva"] == 1)
    echo json_encode(array("status" => "success"));
//altrimenti ho la tessera già persa
else
    echo json_encode(array("status" => "error"));
exit();

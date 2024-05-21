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

//prendo 
$id = $_SESSION['ID'];

$query = "SELECT IDcarta FROM clienti WHERE id=?";
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
//controllo
if($row["IDcarta"] == null)
    echo json_encode(array("status" => "error"));
else
    echo json_encode(array("status" => "success"));
exit();

<?php
header('Content-Type: application/json');
session_start();

$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

$conn = new mysqli($host, $user, $psw, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$numero = $_POST['numero'];
$via = $_POST['via'];
$idIndirizzo = $_SESSION['idUtente_indirizzo'];


$query = "UPDATE `indirizzi` SET `Via`=?,`NumeroCivico`=? WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sii", $via, $numero, $idIndirizzo);

if ($stmt->execute()) {
    $conn->close();
    echo json_encode(array("status" => "success", "message" => "inserimento andato a buon fine"));
    exit();
} else {
    $conn->close();
    echo json_encode(array("status" => "error", "message" => "errore inserimento"));
    exit();
}

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

$id = $_POST['id'];
$nome = $_POST['nome'];
$slot = $_POST['numeroSlot'];


$query = "UPDATE `stazione` SET `Nome`=?,`NumeroSlot`=? WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sii", $nome, $slot, $id);

if ($stmt->execute()) {
    $conn->close();
    echo json_encode(array("status" => "success", "message" => "inserimento andato a buon fine"));
    exit();
} else {
    $conn->close();
    echo json_encode(array("status" => "error", "message" => "errore inserimento"));
    exit();
}

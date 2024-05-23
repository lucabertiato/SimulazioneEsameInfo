<?php
header('Content-Type: application/json');
session_start();

// Solo admin può modificare lo stato
if (!isset($_SESSION['is_logged']) || $_SESSION['ruolo'] !== 'admin') {
    echo json_encode(array("status" => "error", "message" => "Non autorizzato"));
    exit();
}

// Prendo l'ID
if (!isset($_POST['id'])) {
    echo json_encode(array("status" => "error", "message" => "ID della bicicletta non fornito"));
    exit();
}
$id = $_POST['id'];

$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

// Connessione e controllo
$conn = new mysqli($host, $user, $psw, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Connessione fallita: " . $conn->connect_error)));
}

// Query per aggiornare lo stato della bicicletta
$query = "UPDATE bici SET stato = NULL WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

// Esegui l'aggiornamento
if ($stmt->execute()) {
    echo json_encode(array("status" => "success", "message" => "Stato della bicicletta aggiornato con successo"));
} else {
    echo json_encode(array("status" => "error", "message" => "Errore durante l'aggiornamento dello stato della bicicletta: " . $stmt->error));
}

// Chiudi la connessione
$stmt->close();
$conn->close();
?>

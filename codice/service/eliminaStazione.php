<?php
header('Content-Type: application/json');
session_start();

//solo admin puo cancellare
if (!isset($_SESSION['is_logged']) || $_SESSION['ruolo'] !== 'admin') {
    echo json_encode(array("status" => "error", "message" => "Non autorizzato"));
    exit();
}

//prendo id
if (!isset($_POST['id'])) {
    echo json_encode(array("status" => "error", "message" => "ID della stazione non fornito"));
    exit();
}
$id = $_POST['id'];

$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

//connessione e controllo
$conn = new mysqli($host, $user, $psw, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

//query per cancellare
$query = "DELETE FROM stazione WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
//esegue
if ($stmt->execute()) {
    echo json_encode(array("status" => "success", "message" => "Stazione eliminata con successo"));
} else {
    echo json_encode(array("status" => "error", "message" => "Errore durante l'eliminazione della stazione"));
}

// Chiudi la connessione
$stmt->close();
$conn->close();
?>

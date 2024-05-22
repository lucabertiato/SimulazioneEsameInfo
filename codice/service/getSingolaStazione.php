<?php
header('Content-Type: application/json');
session_start();

// Solo admin o cliente possono ottenere i dettagli della stazione
if (!isset($_SESSION['is_logged']) || ($_SESSION['ruolo'] !== 'admin' && $_SESSION['ruolo'] !== 'cliente')) {
    echo json_encode(array("status" => "error", "message" => "Non autorizzato"));
    exit();
}

// prendo id
if (!isset($_POST['id'])) {
    echo json_encode(array("status" => "error", "message" => "ID della stazione non fornito"));
    exit();
}
$id = $_POST['id'];

$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

// connessione e controllo
$conn = new mysqli($host, $user, $psw, $dbname);

if ($conn->connect_error) {
    echo json_encode(array("status" => "error", "message" => "Connessione fallita: " . $conn->connect_error));
    exit();
}

// query per ottenere i dettagli della stazione
$query = "SELECT nome, numeroSlot FROM stazione WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $stazione = $result->fetch_assoc();
    if ($stazione) {
        echo json_encode(array("status" => "success", "data" => $stazione));
    } else {
        echo json_encode(array("status" => "error", "message" => "Stazione non trovata"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Errore durante la richiesta"));
}

// chiudi la connessione
$stmt->close();
$conn->close();
?>

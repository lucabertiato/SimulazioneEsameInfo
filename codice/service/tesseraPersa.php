<?php
header('Content-Type: application/json');
session_start();

// solo autenticazione
if (!isset($_SESSION['is_logged'])) {
    echo json_encode(array("status" => "error", "message" => "Non autorizzato"));
    exit();
}


$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

$conn = new mysqli($host, $user, $psw, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
//se la richiesta la manda admin
if(isset($_POST['tessera']))
    $tessera = $_POST['tessera'];
//se la richiesta arriva da utente
else
    $tessera = $_SESSION['tessera'];
$stato = 0;

$query = "UPDATE `clienti` SET `tessera_attiva`=? WHERE tessera=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $stato, $tessera);

if ($stmt->execute()) {
    $conn->close();
    echo json_encode(array("status" => "success", "message" => "richiesta di blocco andata a buon fine"));
    exit();
} else {
    $conn->close();
    echo json_encode(array("status" => "error", "message" => "errore nella richiesta di blocco"));
    exit();
}
?>
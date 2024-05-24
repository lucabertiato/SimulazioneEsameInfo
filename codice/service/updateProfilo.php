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

$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = isset($_POST['password']) ? $_POST['password'] : "";
$id = $_SESSION['ID'];

if($password != ""){
    $query = "UPDATE `clienti` SET `email`=?,`username`=?,`password`=?,`nome`=?,`cognome`=? WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $email, $username, $password, $nome, $cognome, $id);
}
else{
    $query = "UPDATE `clienti` SET `email`=?,`username`=?,`nome`=?,`cognome`=? WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $email, $username, $nome, $cognome, $id);
}    

if($stmt->execute()){
    $conn->close();
    echo json_encode(array("status" => "success", "message" => "aggiornamento dati andato a buon fine"));
    exit();
}
else{
    $conn->close();
    echo json_encode(array("status" => "error", "message" => "errore aggiornamento dati"));
    exit();
}
?>

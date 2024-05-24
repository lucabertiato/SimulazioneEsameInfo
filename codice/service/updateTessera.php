<?php
header('Content-Type: application/json');
session_start();

// solo admin
if (!isset($_SESSION['is_logged']) || $_SESSION['ruolo'] !== 'admin') {
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

$vecchia = $_POST['vecchia'];
$nuova = $_POST['nuova'];

$query = "UPDATE `clienti` SET `tessera`=?,`tessera_attiva`=1 WHERE tessera = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $nuova, $vecchia);

if($stmt->execute()){
    $query1 = "UPDATE `operazione` SET `tessera`=? WHERE tessera = ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("ss", $nuova, $vecchia);
    if($stmt1->execute()){
        $conn->close();
        echo json_encode(array("status" => "success", "message" => "aggiornamento dati andato a buon fine"));
        exit();
    }
    else{
        $conn->close();
        echo json_encode(array("status" => "error", "message" => "errore aggiornamento dati"));
        exit();
    }
}
else{
    $conn->close();
    echo json_encode(array("status" => "error", "message" => "errore aggiornamento dati"));
    exit();
}
?>

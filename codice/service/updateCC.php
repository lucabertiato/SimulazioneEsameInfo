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

$cvv = $_POST['cvv'];
$scadenza = $_POST['scadenza'];
$titolare = $_POST['titolare'];
$numero = $_POST['numeroCC'];
$id = $_POST['idUtente'];

$query = "INSERT INTO `cartecredito`(`ID`, `Titolare`, `NumeroCarta`, `Scadenza`, `CVV`) VALUES (NULL,?,?,?,?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $titolare, $numero, $scadenza, $cvv);

if($stmt->execute()){
    $last_id_carta = $stmt->insert_id;
    $query = "UPDATE `clienti` SET `IDcarta`=? WHERE ID=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $last_id_carta, $id);
    if($stmt->execute()){
        $conn->close();
        echo json_encode(array("status" => "success", "message" => "inserimento andato a buon fine"));
        exit();
    }
    else{
        $conn->close();
        echo json_encode(array("status" => "error", "message" => "errore inserimento"));
        exit();
    }
}
else{
    $conn->close();
    echo json_encode(array("status" => "error", "message" => "errore inserimento"));
    exit();
}
?>

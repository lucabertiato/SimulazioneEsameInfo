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
$username = $_POST['username'];
$password = $_POST['password'];


//prima faccio la query nella tabella admin
$query = "SELECT * FROM admin WHERE username=? AND password=?";
//preparazione
$stmt = $conn->prepare($query);
//metto i parametri
$stmt->bind_param("ss", $username, $password);
//eseguo
$stmt->execute();
//prendo i risultati
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION["ID"] = $row["ID"];
    $_SESSION["is_logged"] = true;
    $_SESSION["ruolo"] = "admin";
    $conn->close();
    echo json_encode(array("status" => "success" , "ruolo" => "admin"));
    exit();
} else {
    //prima faccio la query nella tabella admin
    $query = "SELECT * FROM clienti WHERE username=? AND password=?";
    //preparazione
    $stmt = $conn->prepare($query);
    //metto i parametri
    $stmt->bind_param("ss", $username, $password);
    //eseguo
    $stmt->execute();
    //prendo i risultati
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION["ID"] = $row["ID"];
        $_SESSION["is_logged"] = true;
        $_SESSION["ruolo"] = "cliente";
        $conn->close();
        echo json_encode(array("status" => "success", "ruolo" => "cliente"));
        exit();
    }
    else{
        $conn->close();
        echo json_encode(array("status" => "error"));
        exit();
    }
}

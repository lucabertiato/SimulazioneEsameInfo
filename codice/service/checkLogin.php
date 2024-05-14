<?php
header('Content-Type: application/json');

//credenziali per il db
$host = "localhost";
$user= "root";
$psw = "";
$dbname = "biciclette";

//connessione al database
$conn = new mysqli($host, $user, $password, $dbname);

//check connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

//prendo 
$username = $_POST['username'];
$password = $_POST['password'];


//prima faccio la query nella tabella admin
$query = "SELECT * FROM admin WHERE email=? AND password=?";
//preparazione
$stmt = $conn->prepare($query);
//metto i parametri
$stmt->bind_param("ss", $email, $password);
//eseguo
$stmt->execute();
//prendo i risultati
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
} else {
    echo "Username non trovato.";
}

// Chiudi la connessione
$conn->close();
?>
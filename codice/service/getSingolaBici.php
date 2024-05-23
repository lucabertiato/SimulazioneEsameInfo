<?php
//credenziali
$host = "localhost";
$user = "root";
$psw = "";
$dbname = "biciclette";

//connessione
$conn = new mysqli($host, $user, $psw, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

//prendi id
$id_bicicletta = $_POST['id'];

// Query per selezionare i campi specificati della bicicletta e il nome della stazione associata
$query = "SELECT bici.tagRFID, bici.gps, bici.stato, stazione.ID AS IDStazione, stazione.Nome AS NomeStazione
            FROM operazione
            INNER JOIN bici ON operazione.IDbici = bici.ID
            INNER JOIN stazione ON operazione.IDstazione = stazione.ID
            WHERE operazione.ID = (
                SELECT MAX(ID) FROM operazione WHERE IDbici = ? AND tipo = 'Riconsegna'
            )AND bici.stato IS NOT NULL";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_bicicletta);
$stmt->execute();
$result = $stmt->get_result();

//controllo risultati
if ($result->num_rows > 0) {
    //prendi e crea vettore
    $row = $result->fetch_assoc();
    $response = array(
        "status" => "success",
        "data" => array(
            "tagRFID" => $row["tagRFID"],
            "gps" => $row["gps"],
            "stato" => $row["stato"],
            "idStazione" => $row["IDStazione"],
            "NomeStazione" => $row["NomeStazione"]
        )
    );
} else {
    $response = array("status" => "error", "message" => "Nessun risultato trovato");
}

$conn->close();
$stmt->close();

header('Content-Type: application/json');
echo json_encode($response);
?>

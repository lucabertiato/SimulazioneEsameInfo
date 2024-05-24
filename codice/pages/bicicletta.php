<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["is_logged"])) {
    header("Location: ./map.php");
    exit();
}
if (!isset($_SESSION["ruolo"]) || $_SESSION["ruolo"] !== "admin") {
    header("Location: ./map.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Gestione Biciclette</title>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/crypto-js.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
    <style>
        .navbar {
            margin-bottom: 20px;
        }

        .input-margin {
            margin-top: 10px;
        }

        .btn-margin {
            margin: 10px 10px;
        }

        .paragraph-margin {
            margin: 10px 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        #modifica {
            display: none;
            margin-top: 20px;
        }

        .row {
            align-items: flex-start;
        }

        .col-md-6 {
            margin-bottom: 20px;
        }
    </style>
    <script src="../js/bicicletta.js"></script>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../images/logo.jpg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                Rent a bike
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="map.php">Home</a>
                    </li>
                    <li class="nav-item">   
                        <a class="nav-link" href="stazioni.php">Gestisci Stazioni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="bicicletta.php">Gestisci Bicicletta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tessere.php">Gestisci Tessere</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h1>Gestione Biciclette</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>Tutte le biciclette</h4>
                <table class="table table-striped" id="bicicletteTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>RFID</th>
                            <th>GPS</th>
                            <th>KM totali</th>
                            <th>Posizione</th>
                            <th>Stato</th>
                            <th>Modifica bicicletta</th>
                            <th>Elimina bicicletta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dati delle biciclette verranno aggiunti qui -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h4>Inserimento di una nuova bicicletta</h4>
                <form id="biciclettaForm">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="rfid" placeholder="Tag RFID (R00001)">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="gps" placeholder="Tag GPS (G00001)">
                    </div>
                    <div class="mb-3">
                        <select name="stazione" id="stazione" class="form-control"></select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="addBicicletta()">Aggiungi Bicicletta</button>
                    <p class="paragraph-margin" id="response"></p>
                </form>
            </div>
            <div class="col-md-6">
                <div id="modifica">
                    <h4>Modifica Bicicletta</h4>
                    <form id="modificaBiciclettaForm">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="mod_id">
                            <input type="hidden" class="form-control" id="mod_id_stazione">
                            <input type="text" class="form-control" id="mod_rfid" placeholder="Tag RFID (R00001)">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="mod_gps" placeholder="Tag GPS (G00001)">
                        </div>
                        <div class="mb-3">
                            <select name="mod_stazione" id="mod_stazione" class="form-control"></select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="salvaModifiche()">Salva Modifiche</button>
                        <p class="paragraph-margin" id="modificaResponse"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

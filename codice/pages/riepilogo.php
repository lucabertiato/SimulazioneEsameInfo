<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["is_logged"])) {
    header("Location: ./map.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Riepilogo Operazioni</title>
    <script src="../js/jquery.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/riepilogo.js"></script>
    <style>
        .navbar {
            margin-bottom: 20px;
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
    </style>
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
                        <a class="nav-link " href="profilo.php">Profilo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="riepilogo.php">Riepilogo</a>
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
                <h1>Riepilogo Operazioni</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>Le tue operazioni</h4>
                <table class="table table-striped" id="operazioniTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Tipo</th>
                            <th>Data/Ora</th>
                            <th>KM Percorsi</th>
                            <th>ID Bicicletta</th>
                            <th>Stazione</th>
                            <th>In Corso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dati delle operazioni verranno aggiunti qui -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

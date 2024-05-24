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
    <title>Gestione Tessere</title>
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
    <script src="../js/tessera.js"></script>
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
                        <a class="nav-link" href="bicicletta.php">Gestisci Bicicletta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="tessere.php">Gestisci Tessere</a>
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
                <h1>Gestione Tessere</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>Tutte le Tessere</h4>
                <table class="table table-striped" id="tessereTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Email</th>
                            <th>Numero tessera</th>
                            <th>Stato tessera</th>
                            <th>Operazione</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dati delle tessere verranno aggiunti qui -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>

</html>

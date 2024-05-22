<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["is_logged"])) {
    header("Location: ./map.php");
    exit();
}
if (!isset($_SESSION["ruolo"]) || $_SESSION["ruolo"] !== "admin") {
    header("Location: ./logout.php");
    exit();
}
?>

<html>

<head>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/crypto-js.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
    <script src="../js/stazioni.js"></script>
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
    </style>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary navbar-dark bg-primary" data-bs-theme="dark">
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
                        <a class="nav-link active" href="stazioni.php">Gestisci Stazioni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gestisci Slot</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gestisci Bicicletta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row g-3">
        <h1>Stazioni</h1>
        <div id="inserimento">
            <h4>Inserimento di una nuova stazione</h4>
            <input type="hidden" id="city" value="Como" disabled> <!-- Il nome della città è impostato su Como -->
            <input type="hidden" id="neighborhood" placeholder="Frazione o Quartiere">
            <input type="hidden" id="province" value="Como" disabled> <!-- Il nome della provincia è impostato su Como -->
            <input type="hidden" id="country" value="Italia" disabled> <!-- Il nome del paese è impostato su Italia -->
            <input type="text" class="form-control input-margin" placeholder="Nome" aria-label="Nome" id="nome">
            <input type="text" class="form-control input-margin" placeholder="Indirizzo" aria-label="Indirizzo" id="indirizzo">
            <input type="number" class="form-control input-margin" placeholder="Numero slot max" aria-label="Numero slo max" id="slot" min="1" step="1">
            <button type="submit" class="btn btn-primary btn-margin" onclick="addStazioni()">Aggiungi stazione</button>
            <p class="paragraph-margin" id="response"></p>
        </div>
        <div id="modifica"></div>
    </div>
    
</body>

</html>

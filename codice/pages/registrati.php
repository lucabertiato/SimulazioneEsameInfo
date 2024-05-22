<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["is_logged"])) {
    header("Location: ./map.php");
    exit();
}

?>

<html>

<head>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/registra.js"></script>
    <script src="../js/crypto-js.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
    <style>
        .navbar {
            margin-bottom: 20px;
        }

        .input-margin {
            margin: 10px 10px;
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
                Rent a Bike
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
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="registrati.php">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row g-3">
        <input type="email" class="form-control input-margin" placeholder="Email" aria-label="email" id="email">
        <input type="text" class="form-control input-margin" placeholder="Username" aria-label="username" id="username">
        <input type="password" class="form-control input-margin" placeholder="Password" aria-label="password" id="password">
        <input type="text" class="form-control input-margin" placeholder="Nome" aria-label="nome" id="nome">
        <input type="text" class="form-control input-margin" placeholder="Cognome" aria-label="cognome" id="cognome">
        <input type="text" class="form-control input-margin" placeholder="Indirizzo" aria-label="indirizzo" id="indirizzo">
        <button type="submit" class="btn btn-primary btn-margin" onclick="registrazione()">Registrati</button>
        <p class="paragraph-margin" id="response"></p>
    </div>
</body>

</html>
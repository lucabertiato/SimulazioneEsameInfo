<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["is_logged"])) {
    header("Location: ./map.php");
    exit();
}
if (!isset($_SESSION["ruolo"]) || $_SESSION["ruolo"] !== "cliente") {
    header("Location: ./logout.php");
    exit();
}
?>

<html>

<head>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/registra.js"></script>
    <script src="../js/crypto-js.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
    <script src="../js/profilo.js"></script>
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
                        <a class="nav-link active" href="registrati.php">Profilo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="riepilogo.php">Riepilogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row g-3">
        <input type="hidden" name="userID" id="userID" value="<?php echo $_SESSION['ID']; ?>">
        <h1>Profilo</h1>
        <div id="cc"></div>
        <div id="dati"></div>
        <div id="indirizzo"></div>
    </div>
    
</body>

</html>

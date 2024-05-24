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

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo</title>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/registra.js"></script>
    <script src="../js/crypto-js.min.js"></script>
    <script src="../js/profilo.js"></script>
    <style>
        .navbar {
            margin-bottom: 20px;
        }

        .input-margin {
            margin-top: 10px;
        }

        .btn-margin {
            margin-top: 10px;
        }

        .paragraph-margin {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
                        <a class="nav-link active" href="profilo.php">Profilo</a>
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
    <div class="container">
        <div class="row g-3">
            <input type="hidden" name="userID" id="userID" value="<?php echo $_SESSION['ID']; ?>">
            <div class="col-12">
                <h1 class="text-center mb-4">Profilo</h1>
            </div>
            <div class="col-md-4" id="div_cc">
                <div class="card">
                    <div class="card-body" id="cc"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body" id="dati"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body" id="indirizzo"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tessera">
                    <div class="card-body" id="tessera_persa"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

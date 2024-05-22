<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["is_logged"])) {
    header("Location: ./map.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/script_login.js"></script>
    <script src="../js/crypto-js.min.js"></script>
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
                        <a class="nav-link active" href="#">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registrati.php">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Login</h2>
                <form>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" id="username">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Password" aria-label="Password" id="password">
                    </div>
                    <button type="button" class="btn btn-primary btn-block" onclick="login()">Login</button>
                    <p class="mt-3 text-center" id="response"></p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

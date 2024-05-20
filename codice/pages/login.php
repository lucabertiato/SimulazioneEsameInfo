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
    <script src="../js/script_login.js"></script>
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
    <nav class="navbar bg-body-tertiary" class="navbar bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand">Pagina di Login</a>
        </div>
    </nav>
    <div class="row g-3">
        <input type="text" class="form-control input-margin" placeholder="Username" aria-label="username" id="username">
        <input type="password" class="form-control input-margin" placeholder="Password" aria-label="password" id="password">
        <button type="submit" class="btn btn-primary btn-margin" onclick="login()">Login</button>
        <p class="paragraph-margin">Non hai ancora un account? <a href="registrati.php">Creane uno!</a></p>
    </div>
</body>

</html>
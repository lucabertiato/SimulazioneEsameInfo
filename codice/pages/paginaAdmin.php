<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["is_logged"]) && $_SESSION["is_logged"] !== true) {
    header("Location: ./login.php");
    exit();
}

if ($_SESSION["ruolo"] !== "admin") {
    header("Location: ./logout.php");
    exit();
}

?>

<html>
    <head>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/script_login.js"></script>
        <script src="../js/crypto-js.min.js"></script>
        <link rel="stylesheet" href="../cdn/bootstrap.min.css">
    </head>
    <body>
        <nav class="navbar bg-body-tertiary" class="navbar bg-primary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand">Pagina Admin</a>
            </div>
        </nav>
        <button onclick="window.location.href = 'logout.php'">LOGOUT</button>
    </body>
</html>

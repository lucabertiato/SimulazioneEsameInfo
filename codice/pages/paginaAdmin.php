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
    <body>
        <h1>pagina admin</h1>
        <button onclick="window.location.href = 'logout.php'">LOGOUT</button>
    </body>
</html>

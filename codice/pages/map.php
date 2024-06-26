<!DOCTYPE html>
<html>

<head>
    <title>Rent a bike in Como</title>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/crypto-js.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
    <style>
        #map {
            height: 700px;
            width: 100%;
        }
    </style>
    <script src="../js/mappa.js"></script>
</head>

<body>
    <?php
    session_start();
    ?>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
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
                        <a class="nav-link active" aria-current="page" href="map.php">Home</a>
                    </li>
                    <?php if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true) {
                        //if controllo se admin
                        if ($_SESSION['ruolo'] == 'admin') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="stazioni.php">Gestisci Stazioni</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="bicicletta.php">Gestisci Bicicletta</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="tessere.php">Gestisci Tessere</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                            <!--if controllo se utente-->
                        <?php } elseif ($_SESSION['ruolo'] == 'cliente') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="profilo.php">Profilo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="riepilogo.php">Riepilogo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        <?php } //chiudo if x controllo che tipo di utente
                    }
                    //se non esite nessun ruolo 
                    else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registrati.php">Sign Up</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="map"></div>
    <script>
        $(document).ready(function() {
            startaMappa();
        });
    </script>
</body>

</html>

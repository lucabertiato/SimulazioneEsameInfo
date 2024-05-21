<!DOCTYPE html>
<?php

if (!isset($_SESSION)) {
    session_start();
}

?>
<html>

<head>
    <title>Rent a bike in Como</title>
    <script>
        function login() {
            window.location.href = "login.php";
        }

        function logout() {
            window.location.href = "logout.php";
        }

        function profilo() {
            window.location.href = "profilo.php";
        }

        var map;

        function startaMappa() {
            var options = {
                center: [45.8105, 9.0852],
                zoom: 13
            };

            // Creazione oggetto mappa
            map = L.map('map').setView(options.center, options.zoom);

            // Layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Imposto i pin
            //addTag();
        }

        /*function addTag() {
            // Prendo tutte le stazioni e in base alla latitudine e longitudine metto i mark
            $.post("php/getStazioneMappa.php", {}, function(stazioni) {
                stazioni.forEach(function(stazione) {
                    var marker = L.marker([stazione.lat, stazione.longi]).addTo(map);
                    marker.bindPopup("<b>" + stazione.nome + "</b><br>" + stazione.altro);
                });
            }, 'json');
        }*/
    </script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/crypto-js.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
    <!-- API mappa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="../js/mappa.js"></script>
    <style>
        #map {
            height: 700px; /* Altezza della mappa */
            width: 100%; /* Larghezza della mappa */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                Rent a Bike
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <?php if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true) {
                        //if controllo se admin
                        if ($_SESSION['ruolo'] == 'admin') {?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Gestisci Stazioni</a>
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
                        <!--if controllo se utente-->
                        <?php } elseif ($_SESSION['ruolo'] == 'utente') {?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Profilo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Logout</a>
                            </li>
                        <?php } //chiudo if x controllo che tipo di utente
                    }
                    //se non esite nessun ruolo 
                    else {?>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php">Login</a>
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

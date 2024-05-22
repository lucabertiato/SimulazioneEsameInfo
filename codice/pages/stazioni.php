<!DOCTYPE html>
<html>

<head>
    <title>Gestione Stazioni</title>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/crypto-js.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        #modifica {
            display: none;
            margin-top: 20px;
        }

        .row {
            align-items: flex-start;
        }

        .col-md-6 {
            margin-bottom: 20px;
        }
    </style>
    <script src="../js/stazioni.js"></script>
</head>

<body>
    <?php
    session_start();
    ?>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
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
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h1>Gestione Stazioni</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>Tutte le stazioni</h4>
                <table class="table table-striped" id="stazioniTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Numero Slot</th>
                            <th>Via</th>
                            <th>Numero Civico</th>
                            <th>Modifica stazione</th>
                            <th>Elimina stazione</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dati delle stazioni verranno aggiunti qui -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h4>Inserimento di una nuova stazione</h4>
                <form id="stazioneForm">
                    <input type="hidden" id="city" value="Como" disabled>
                    <input type="hidden" id="neighborhood" placeholder="Frazione o Quartiere">
                    <input type="hidden" id="province" value="Como" disabled>
                    <input type="hidden" id="country" value="Italia" disabled>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="nome" placeholder="Nome">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="indirizzo" placeholder="Indirizzo">
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" id="numero" placeholder="Numero" min="1">
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" id="slot" placeholder="Numero slot max" min="1" step="1">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="addStazioni()">Aggiungi stazione</button>
                    <p class="paragraph-margin" id="response"></p>
                </form>
            </div>
            <div class="col-md-6">
                <div id="modifica">
                    <h4>Modifica Stazione</h4>
                    <form id="modificaStazioneForm">
                        <input type="hidden" id="mod_id">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="mod_nome" placeholder="Nome">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" id="mod_slot" placeholder="Numero slot max" min="1" step="1">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="salvaModifiche()">Salva Modifiche</button>
                        <p class="paragraph-margin" id="modificaResponse"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

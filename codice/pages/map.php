<html>

<head>
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
    </script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/crypto-js.min.js"></script>
    <link rel="stylesheet" href="../cdn/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" class="navbar bg-primary" data-bs-theme="dark">
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
                    <?php
                        if (isset($_SESSION['ruolo'])) {
                            if ($_SESSION['ruolo'] == 'admin'){
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Profilo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Logout</a>
                            </li>
                        <?php  
                        }
                            elseif ($_SESSION['ruolo'] == 'utente') {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profilo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Logout</a>
                        </li>
                    <?php   
                            }
                        } else {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php">Login</a>
                        </li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <!--qua si mette la mappa-->
</body>

</html>
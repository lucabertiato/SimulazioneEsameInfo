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
</head>

<body>
    <!--visaulizza bottoni-->
    <?php
    if (isset($_SESSION['log'])) {
        if ($_SESSION['log'] == 'admin')
            header("Location: admin.php");
        elseif ($_SESSION['log'] == 'utente') {
    ?>
            <button onclick="profilo()">PROFILO</button>
            <button onclick="logout()">LOGOUT</button>
        <?php
        }
    } else {
        ?>
        <button onclick="login()">LOGIN</button>
        <button onclick="logout()">LOGOUT</button>
    <?php
    }
    ?>
    <!--visualizzo la mappa-->
    <!--....-->
</body>

</html>
<?php

//se la sessione non è avviata la avvio
if(!isset($_SESSION))
    session_start();

//distruggo sessione
session_destroy();

//torna alla index
header("Location: ../index.php");
exit;
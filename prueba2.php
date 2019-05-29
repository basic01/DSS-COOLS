<?php
    session_start();
    if(isset($_SESSION['k'])){
        $hola = $_SESSION['k'];
        echo $hola;
    }
?>
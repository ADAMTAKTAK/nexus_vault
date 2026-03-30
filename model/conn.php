<?php
    date_default_timezone_set("America/Caracas");
    $conn = new mysqli("localhost", "root", "", "nexus_vault");
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        die("CRITICAL_ERROR: No se pudo conectar a la base de datos.");
    }
?>
<?php
    // Määritetään tietokannan yhteyteen liittyvät muuttujat
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'phptesti');
    define('DB_PASSWORD', '1234');
    define('DB_NAME', 'phptesti');

    // Otetaan yhteys tietokantaan
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Tarkistetaan onnistuiko yhteyden luominen
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>
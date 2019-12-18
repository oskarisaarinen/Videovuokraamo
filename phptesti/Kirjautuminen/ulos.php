<?php
// Alustetaan sessio
session_start();
 
// Tuhotaan kaikki session muttujat
$_SESSION = array();
 
// Tuhotaan sessio
session_destroy();
 
// Ohjataan käyttäjä index.php -sivulle
header("location: ../index.php");
exit;
?>
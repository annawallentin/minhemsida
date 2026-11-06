<?php

//har hand om processen för att logga ut en användare. Förstör sessionen och omdirigerar till inloggningssidan.

 
require_once 'include/bootstrap.php';
 
// Töm sessionsvariablerna
$_SESSION = [];
 
// Förstör sessionen
session_destroy();
 
//skicka till index.php (alltså startsidan) när detta är klart
header('Location: index.php');
exit;
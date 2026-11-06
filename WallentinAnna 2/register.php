
<?php
// Här kopplars allt som behövs för registreringssidan. Kopplar register.php som ligger i views och har
// hand om all html-kod för registreringssidan, sedan kopplas bootstrapen, headern och footern.
// Berättar mer om filerna i kommentarerna på dessa filer.
 
require_once __DIR__ . '/include/bootstrap.php';
 
// Hämtar eventuellt felmeddelande från sessionen (satt av register_process.php)
// och rensar det direkt så att det inte visas igen vid nästa sidladdning.
$error = $_SESSION['register_error'] ?? '';
unset($_SESSION['register_error']);
 
include __DIR__ . '/include/views/_header.php';
$pageTitle = 'Registrering';
include __DIR__ . '/include/views/register.php';
include 'include/views/_footer.php';

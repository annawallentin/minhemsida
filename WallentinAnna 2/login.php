<?php
// Här kopplars allt som behövs för inloggningssidan. Kopplar login.php som ligger i views och har
// hand om all html-kod på inloggningssidan, sedan kopplas bootstrapen, headern och footern.
// Berättar mer om filerna i kommentarerna på dessa filer.

require_once __DIR__ . '/include/bootstrap.php';

// Hämtar eventuellt felmeddelande från sessionen (satt av login_process.php)
// och rensar det direkt så att det inte visas igen vid nästa sidladdning.

$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);

$pageTitle = 'Logga in';
include __DIR__ . '/include/views/_header.php';
include __DIR__ . '/include/views/login.php';
include __DIR__ . '/include/views/_footer.php';
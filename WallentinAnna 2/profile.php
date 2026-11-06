
<?php
// Här kopplars allt som behövs för profilsidan. Kopplar profile.php som ligger i views och har
// hand om all html-kod för profilsidan, sedan kopplas bootstrapen, headern och footern.
// Berättar mer om filerna i kommentarerna på dessa filer.

require_once __DIR__ . '/include/bootstrap.php';

//profilsidan kräver inloggning
 
Authorizer::requireLogin();
 
// Hämtar inloggad användares data från databasen via användarens ID.
$user       = User::getById(Authorizer::getUserId());

// Hämtar eventuella success- och felmeddelanden från sessionen (satta av profile_process.php)
// och rensar dem direkt så att de inte visas igen vid nästa sidladdning.
$successMsg = $_SESSION['profile_success'] ?? '';
$error      = $_SESSION['profile_error'] ?? '';
unset($_SESSION['profile_success'], $_SESSION['profile_error']);

$pageTitle = 'Min profil';
include __DIR__ . '/include/views/_header.php';
include __DIR__ . '/include/views/profile.php';
include 'include/views/_footer.php';
?>
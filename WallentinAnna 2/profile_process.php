
<?php
// Denna fil hanterar alla uppdateringar som görs på profilsidan. Beroende på vilket formulär
// användaren skickat in så hanteras antingen byte av användarnamn, lösenord eller profilbild.
// Filen känner av vilket formulär som skickades via 'action'-fältet som är dolt i varje formulär.

require_once 'include/bootstrap.php';
 
//profilsidan kräver inloggning
Authorizer::requireLogin();
 
// Tillåter endast POST-anrop, annars skickas användaren tillbaka till profilsidan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: profile.php');
    exit;
}
 
// Hämtar vilken åtgärd som ska utföras och inloggad användares ID
$action = $_POST['action'] ?? '';
$userId = Authorizer::getUserId();
 
//byte av användarnamn om action är lika med name
if ($action === 'name') {
    $username = trim($_POST['name'] ?? '');
 
    //kontrollerar så att det nya användarnamnet är mellan 3 och 30 tecken
    if (strlen($username) < 3 || strlen($username) > 30) {
        $_SESSION['profile_error'] = 'Användarnamnet måste vara 3–30 tecken.';
        header('Location: profile.php');
        exit;
    }
 //om det är det uppdateras användarnamnet med hjälp av updateUsername som ligger i models/user
    $result = User::updateUsername($userId, $username);
 
    //returnerar true om det gick bra annars ett felmeddelande
    if ($result === true) {
        $_SESSION['profile_success'] = 'Användarnamnet uppdaterades.';
    } else {
        $_SESSION['profile_error'] = $result;
    }
 
//Byte av lösenord om action är lika med password
} elseif ($action === 'password') {
    // Hämtar alla tre lösenordsfälten från formuläret
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword     = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
 
    // Kontrollerar att alla fält är ifyllda
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['profile_error'] = 'Fyll i alla lösenordsfält.';
        header('Location: profile.php');
        exit;
    }
 // Kontrollerar att det nya lösenordet är minst 8 tecken
    if (strlen($newPassword) < 8) {
        $_SESSION['profile_error'] = 'Nytt lösenord måste vara minst 8 tecken.';
        header('Location: profile.php'); 
        exit;
    }

    // Kontrollerar att de två nya lösenorden matchar varandra
    if ($newPassword !== $confirmPassword) {
        $_SESSION['profile_error'] = 'De nya lösenorden matchar inte.';
        header('Location: profile.php');
        exit;
    }
 
    // Försöker uppdatera lösenordet via User-modellen
    // Returnerar true om det gick bra, annars ett felmeddelande
    $result = User::updatePassword($userId, $currentPassword, $newPassword);
 
    if ($result === true) {
        $_SESSION['profile_success'] = 'Lösenordet uppdaterades.';
    } else {
        $_SESSION['profile_error'] = $result;
    }
 
//Ladda upp profilbild om action är lika med avatar
} elseif ($action === 'avatar') {
    // Kontrollerar att användaren faktiskt valt en bild att ladda upp

    if (empty($_FILES['avatar']['name'])) {
        $_SESSION['profile_error'] = 'Välj en bild att ladda upp.';
        header('Location: profile.php');
        exit;
    }
 
    $file    = $_FILES['avatar'];
    $maxSize = 2 * 1024 * 1024; // 2 MB
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
 
    // Kontrollerar att uppladdningen gick bra utan tekniska fel
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['profile_error'] = 'Fel vid uppladdning.';
        header('Location: profile.php');
        exit;
    }
 
    // Kontrollerar att bilden inte är för stor
    if ($file['size'] > $maxSize) {
        $_SESSION['profile_error'] = 'Bilden är för stor (max 2 MB).';
        header('Location: profile.php');
        exit;
    }
 
 // Kontrollerar MIME-typen med finfo för att säkerställa att det verkligen är en bild.
    // finfo tittar inuti själva filen och kontrollerar vad den faktiskt innehåller.
    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
 
    if (!in_array($mimeType, $allowed)) {
        $_SESSION['profile_error'] = 'Ogiltigt bildformat. Tillåtna: JPG, PNG, GIF, WEBP.';
        header('Location: profile.php');
        exit;
    }
 
    // Genererar ett unikt filnamn med användarens ID för att undvika att filer skriver över varandra
    $ext       = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename  = 'avatar_' . $userId . '_' . uniqid() . '.' . strtolower($ext);
    $uploadDir = __DIR__ . '/img/uploads/';

    $uploadDir = __DIR__ . '/img/uploads/';
 
    // Flyttar den uppladdade filen till rätt mapp på servern
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        $_SESSION['profile_error'] = 'Kunde inte spara bilden.';
        header('Location: profile.php');
        exit;
    }
 
     // Tar bort den gamla profilbilden från servern om en sådan finns,
    // så att gamla bilder inte samlas upp i mappen i onödan
    $user = User::getById($userId);
    if ($user['avatar'] && file_exists($uploadDir . $user['avatar'])) {
        unlink($uploadDir . $user['avatar']);
    }
 
    // Sparar det nya filnamnet i databasen via User-modellen
    User::updateAvatar($userId, $filename);
    $_SESSION['profile_success'] = 'Profilbilden uppdaterades.';
 
} else {
    // Om action-värdet inte känns igen sparas ett felmeddelande
    $_SESSION['profile_error'] = 'Okänd åtgärd.';
}
// Skickar användaren tillbaka till profilsidan efter att åtgärden utförts
 
header('Location: profile.php');
exit;
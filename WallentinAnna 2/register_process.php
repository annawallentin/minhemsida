
<?php
// Denna fil hanterar processen när en ny användare registrerar sig. Den tar emot formulärdatan
// från register.php, validerar allt på serversidan och skapar ett nytt konto i databasen.
// Om något går fel skickas användaren tillbaka till registreringssidan med ett felmeddelande.
// Om allt går bra loggas användaren in direkt och skickas till inläggssidan.
 
//kopplar bootstrap
require_once 'include/bootstrap.php';
 
// Tillåter endast POST-anrop, annars skickas användaren tillbaka till registreringssidan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}
 // Hämtar och trimmar formulärdata från POST
$email = trim($_POST['email'] ?? '');
$name  = trim($_POST['name'] ?? '');
$password  = $_POST['password'] ?? '';
 
// Serversidesvalidering kollar så att inga fält är tomma, om de är de kommer meddelandet fyll i alla fält upp 
//och man skickas tillbaka till register.php
if (empty($email) || empty($name) || empty($password)) {
    $_SESSION['register_error'] = 'Fyll i alla fält.';
    header('Location: register.php');
    exit;
}
 
// Kontrollerar att e-postadressen har ett giltigt format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_error'] = 'Ogiltig e-postadress.';
    header('Location: register.php');
    exit;
}
 // Kontrollerar att användarnamnet är mellan 3 och 30 tecken
if (strlen($name) < 3 || strlen($name) > 30) {
    $_SESSION['register_error'] = 'Användarnamnet måste vara 3–30 tecken.';
    header('Location: register.php');
    exit;
}
 // Kontrollerar att lösenordet är minst 8 tecken långt
if (strlen($password) < 8) {
    $_SESSION['register_error'] = 'Lösenordet måste vara minst 8 tecken.';
    header('Location: register.php');
    exit;
}
 
// Försöker registrera användaren via User-modellen.
// Om e-post eller användarnamn redan är taget returneras ett felmeddelande,
// annars returneras true och registreringen lyckades.
$result = User::register($email, $name, $password);
 
if ($result !== true) {
    $_SESSION['register_error'] = $result;
    header('Location: register.php');
    exit;
}
 
// Loggar in användaren direkt efter registreringen så att de inte behöver
// logga in manuellt, och sparar användarens ID i sessionen
$user = User::login($email, $password);
$_SESSION['user_id'] = $user['id'];
 
//därefter skickas man till publiceringssidan posts.php
header('Location: posts.php');
exit;
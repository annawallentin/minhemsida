
<?php
//denna kod har hand om processen för att logga in en användare. Den har hand om post formuläret som skickades
//från views/login.php. Den gör en serverside validering. Med hjälp av metoden login som ligger i user loggas 
//användaren in om all validering godkänns. 
 
require_once 'include/bootstrap.php';
 
// Tillåt endast POST-anrop, annars skickas man tillbaka till inloggningssidan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

 
// Hämtar och trimmar formulärdata från POST
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
 
// Serversidesvalidering, kontrollerar att båda fälten är ifyllda

if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = 'Fyll i alla fält.';
    header('Location: login.php');
    exit;
}
 
// Kontrollerar att e-postadressen har ett giltigt format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_error'] = 'Ogiltig e-postadress.';
    header('Location: login.php');
    exit;
}
 
// Försöker logga in användaren via User-modellen
$user = User::login($email, $password);
 
// Om inloggningen misslyckas, skicka tillbaka med felmeddelande
if ($user === false) {
    $_SESSION['login_error'] = 'Felaktig e-postadress eller lösenord.';
    header('Location: login.php');
    exit;
}
 
// Spara användarens ID i sessionen
$_SESSION['user_id'] = $user['id'];
 
// Skickar användaren vidare till inläggssidan efter lyckad inloggning
header('Location: posts.php');
exit;
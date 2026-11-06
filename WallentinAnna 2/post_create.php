<?php
// Denna fil är en AJAX-endpoint, vilket betyder att den inte besöks direkt i webbläsaren
// utan anropas av JavaScript (posts.js) i bakgrunden. Detta gör att nya inlägg kan publiceras
// utan att hela sidan behöver laddas om. Filen svarar alltid med JSON istället för HTML
// så att posts.js kan läsa svaret och uppdatera sidan dynamiskt.

//kopplar bootstrap
require_once 'include/bootstrap.php';

// Sätter svarshuvudet till JSON så att webbläsaren förstår svarsformatet
header('Content-Type: application/json');

// Kontrollerar att användaren är inloggad, annars skickas ett 401-fel tillbaka
if (!Authorizer::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Ej inloggad.']);
    exit;
}

// Tillåter endast POST-anrop, annars skickas ett 405-fel tillbaka
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Metod ej tillåten.']);
    exit;
}

// Hämtar och trimmar meddelandet från formuläret
$message = trim($_POST['message'] ?? '');

// Kontrollerar att meddelandet inte är tomt
if (empty($message)) {
    echo json_encode(['success' => false, 'error' => 'Meddelandet får inte vara tomt.']);
    exit;
}

// Kontrollerar att meddelandet inte överstiger maxlängden på 2000 tecken
if (strlen($message) > 2000) {
    echo json_encode(['success' => false, 'error' => 'Meddelandet får max vara 2000 tecken.']);
    exit;
}

// Hanterar bilduppladdning om användaren valt att bifoga en bild
$imageFilename = null;

if (!empty($_FILES['image']['name'])) {
    $file    = $_FILES['image'];
    $maxSize = 2 * 1024 * 1024; // Max 2 MB
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    // Kontrollerar att uppladdningen gick bra
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'error' => 'Fel vid uppladdning av bild.']);
        exit;
    }

    // Kontrollerar att bilden inte är för stor
    if ($file['size'] > $maxSize) {
        echo json_encode(['success' => false, 'error' => 'Bilden är för stor (max 2 MB).']);
        exit;
    }

    // Kontrollerar MIME-typen med finfo för att säkerställa att det verkligen är en bild
    // och inte en fil som bara har rätt filändelse
    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!in_array($mimeType, $allowed)) {
        echo json_encode(['success' => false, 'error' => 'Ogiltigt bildformat. Tillåtna: JPG, PNG, GIF, WEBP.']);
        exit;
    }

    // Genererar ett unikt filnamn för att undvika att filer skriver över varandra
    $ext           = pathinfo($file['name'], PATHINFO_EXTENSION);
    $imageFilename = uniqid('post_', true) . '.' . strtolower($ext);
    $uploadDir     = __DIR__ . '/img/uploads/';

    // Flyttar den uppladdade filen till rätt mapp på servern
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $imageFilename)) {
        echo json_encode(['success' => false, 'error' => 'Kunde inte spara bilden.']);
        exit;
    }
}

// Hämtar inloggad användares ID och skapar inlägget i databasen via Post-modellen
$userId = Authorizer::getUserId();
$postId = Post::create($userId, $message, $imageFilename);
$post   = Post::getById($postId);

// Returnerar det nyskapade inlägget som JSON så att posts.js kan lägga till det i listan direkt
echo json_encode([
    'success' => true,
    'post'    => $post
]);
exit;
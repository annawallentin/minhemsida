
<?php
// Här kopplars allt som behövs för publiceringssidan. Kopplar posts.php som ligger i views och har
// hand om all html-kod på publiceringssidan, sedan kopplas bootstrapen, headern och footern.
// Berättar mer om filerna i kommentarerna på dessa filer.
require_once __DIR__ . '/include/bootstrap.php';
 
 
// Kräver inloggning
Authorizer::requireLogin();
 
// Hämtar sökfråga från URL-parametern q, trimmar bort onödiga mellanslag
$searchQuery = trim($_GET['q'] ?? '');
 
// Om sökfråga finns, hämta matchande inlägg — annars hämta alla inlägg
if ($searchQuery !== '') {
    $posts = Post::search($searchQuery);
} else {
    $posts = Post::getAll();
}

$pageTitle = 'posts';
include __DIR__ . '/include/views/_header.php';
include __DIR__ . '/include/views/posts.php';
include 'include/views/_footer.php';
?>
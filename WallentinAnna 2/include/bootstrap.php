
<?php
/** Denna är en startfil som inkluderas av alla toppnivåfiler. Den startar sessionen och laddar in alla 
 * modellklasser. 
 */

// Starta sessionen om den inte redan är igång
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 
// Ladda in alla modellklasser
require_once __DIR__ . '/models/db.php';
require_once __DIR__ . '/models/user.php';
require_once __DIR__ . '/models/post.php';
require_once __DIR__ . '/models/authorizer.php';
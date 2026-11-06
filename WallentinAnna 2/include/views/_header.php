
<?php
// View för sidans header och navigering. Den inkluderas i rot-filerna login.php, posts.php,
// register.php, profile.php och index.php så att headern visas längst upp på varje sida.
// Den tar emot variabeln $pageTitle som sätts i respektive rot-fil och används som flikens titel.
// Navigeringen anpassas automatiskt beroende på om användaren är inloggad eller inte —
// inloggade användare ser länkar till inlägg, profil och utloggning, medan utloggade
// användare ser länkar till inloggning och registrering.
// Kopplar även in Tabler Icons som används för ikonerna på startsidan.
//kopplar även min css så att alla sidor har en design. 
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Forum') ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>
<body>
<header class="site-header">
    <div class="header-inner">
        <a href="index.php" class="logo">Registrerings och inloggningssidan</a>
        <nav class="main-nav">
            <?php if (Authorizer::isLoggedIn()): ?>
                <a href="posts.php">Inlägg</a>
                <a href="profile.php">Min profil</a>
                <a href="logout_process.php" class="btn-logout">Logga ut</a>
            <?php else: ?>
                <a href="login.php">Logga in</a>
                <a href="register.php">Registrera</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="site-main">
<?php
// Här kopplars allt som behövs för startsidan,  kopplar _welcome.php som ligger i views och har
// hand om all html kod på startsidan, sedan är bootstapen kopplad även headern och footern. Berättar mer om
// filerna i kommentarerna på dessa filer
require_once __DIR__ . '/include/bootstrap.php';
$pageTitle = 'Välkommen';
include __DIR__ . '/include/views/_header.php';
include __DIR__ . '/include/views/_welcome.php';
include 'include/views/_footer.php';
?>
<?php
/**
 * Ansvarar för att kontrollera om en användare är inloggad.
 * Används för att skydda sidor som kräver inloggning.
 */
 
class Authorizer {
 
    /**
     * Kontrollerar om användaren är inloggad via sessionsvariabeln.
     * Returnerar true om inloggad, annars false.
     */
    public static function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }
 
    /**
     * Kräver att användaren är inloggad.
     * Om inte inloggad, omdirigeras användaren till inloggningssidan.
     */
    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header('Location: login.php');
            exit;
        }
    }
 
    /**
     * Returnerar ID:t för den inloggade användaren.
     * Returnerar null om ingen användare är inloggad.
     */
    public static function getUserId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }
}

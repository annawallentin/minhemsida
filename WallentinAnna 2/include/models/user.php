
<?php
/**
 * Modell för användare. Hanterar registrering, inloggning,
 * profiluppdatering och hämtning av användardata.
 */
 
require_once __DIR__ . '/db.php';
 
class User {
 
    /**
     * Registrerar en ny användare i databasen.
     * Hashar och saltar lösenordet med password_hash().
     * Returnerar true vid lyckat resultat, annars ett felmeddelande.
     */
    public static function register(string $email, string $name, string $password): true|string {
        $db = DB::getInstance();
 
        // Kontrollera om e-post redan används
        $stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return 'E-postadressen är redan registrerad.';
        }
 
        // Kontrollera om användarnamn redan används
        $stmt = $db->prepare('SELECT id FROM users WHERE name = ?');
        $stmt->execute([$name]);
        if ($stmt->fetch()) {
            return 'Användarnamnet är redan taget.';
        }
 
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare('INSERT INTO users (email, name, password) VALUES (?, ?, ?)');
        $stmt->execute([$email, $name, $hashed]);
        return true;
    }
 
    /**
     * Försöker logga in en användare med e-post och lösenord.
     * Returnerar användarens data som array, eller false vid misslyckande.
     */
    public static function login(string $email, string $password): array|false {
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
 
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
 
    /**
     * Hämtar en användare baserat på ID.
     * Returnerar användarens data som array, eller false om ej hittad.
     */
    public static function getById(int $id): array|false {
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
 
    /**
     * Uppdaterar användarnamnet för en given användare.
     * Returnerar true vid lyckat resultat, annars ett felmeddelande.
     */
    public static function updateUsername(int $id, string $name): true|string {
        $db = DB::getInstance();
 
        // Kontrollera om användarnamnet är taget av en annan användare
        $stmt = $db->prepare('SELECT id FROM users WHERE name = ? AND id != ?');
        $stmt->execute([$name, $id]);
        if ($stmt->fetch()) {
            return 'Användarnamnet är redan taget.';
        }
 
        $stmt = $db->prepare('UPDATE users SET name = ? WHERE id = ?');
        $stmt->execute([$name, $id]);
        return true;
    }
 
    /**
     * Uppdaterar lösenordet för en given användare.
     * Hashar det nya lösenordet innan det sparas.
     * Returnerar true vid lyckat resultat, annars ett felmeddelande.
     */
    public static function updatePassword(int $id, string $currentPassword, string $newPassword): true|string {
        $user = self::getById($id);
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return 'Nuvarande lösenord är felaktigt.';
        }
 
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        $db = DB::getInstance();
        $stmt = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([$hashed, $id]);
        return true;
    }
 
    /**
     * Uppdaterar profilbilden (filnamn) för en given användare.
     */
    public static function updateAvatar(int $id, string $filename): void {
        $db = DB::getInstance();
        $stmt = $db->prepare('UPDATE users SET avatar = ? WHERE id = ?');
        $stmt->execute([$filename, $id]);
    }
}
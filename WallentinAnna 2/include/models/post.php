<?php
/**
 * post.php
 * Denna fil fungerar som modell för alla inlägg i systemet.
 * Den ansvarar för att skapa nya inlägg, hämta alla inlägg,
 * söka bland inlägg och hämta ett specifikt inlägg via ID.
 *
 * Modellen pratar direkt med databasen via PDO och returnerar
 * rena arrayer som sedan används av controllers och views.
 */
 
require_once __DIR__ . '/db.php';
 
class Post {
 
    /**
     * Skapar ett nytt inlägg i databasen.
     * Kopplar inlägget till inloggad användare via user_id.
     * Returnerar det nya inläggets ID.
     */
    public static function create(int $userId, string $message, ?string $image = null): int {
        $db = DB::getInstance();
        $stmt = $db->prepare('INSERT INTO posts (user_id, message, image) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $message, $image]);
        return (int)$db->lastInsertId();
    }
 
    /**
     * Hämtar alla inlägg, sorterade med nyaste först.
     * Joinear med users-tabellen för att hämta användarnamn och avatar.
     * Returnerar en array med alla inlägg.
     */
    public static function getAll(): array {
        $db = DB::getInstance();
        $stmt = $db->prepare('
            SELECT posts.id, posts.message, posts.image, posts.created_at,
                   users.name, users.avatar
            FROM posts
            JOIN users ON posts.user_id = users.id
            ORDER BY posts.created_at DESC
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }
 
    /**
     * Söker bland inlägg baserat på ett sökord.
     * Söker i meddelandetexten (case-insensitiv via LIKE).
     * Returnerar matchande inlägg med användarnamn och avatar.
     */
    public static function search(string $query): array {
        $db = DB::getInstance();
        $like = '%' . $query . '%';
        $stmt = $db->prepare('
            SELECT posts.id, posts.message, posts.image, posts.created_at,
                   users.name, users.avatar
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.message LIKE ?
            ORDER BY posts.created_at DESC
        ');
        $stmt->execute([$like]);
        return $stmt->fetchAll();
    }
 
    /**
     * Hämtar ett specifikt inlägg via dess ID.
     * Returnerar inläggetsdata som array, eller false om ej hittat.
     */
    public static function getById(int $id): array|false {
        $db = DB::getInstance();
        $stmt = $db->prepare('
            SELECT posts.id, posts.message, posts.image, posts.created_at,
                   users.name, users.avatar
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.id = ?
        ');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}

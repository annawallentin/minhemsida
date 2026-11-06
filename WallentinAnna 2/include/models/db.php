<?php
/**
 * db.php
 * Denna fil ansvarar för att skapa och hantera anslutningen till SQLite‑databasen.
 * Den använder ett singleton‑mönster för att säkerställa att endast en enda
 * databasanslutning skapas under hela sidans körning. Detta sparar resurser
 * och gör databasanrop mer konsekventa.
 *
 * När anslutningen skapas första gången aktiveras foreign keys och tabellerna
 * skapas automatiskt om de inte redan finns. På så sätt behöver du aldrig
 * manuellt skapa databasen innan projektet körs.
 */
class DB {
        // Håller den enda instansen av PDO-anslutningen
    private static $instance = null;
 
    /**
     * Returnerar en singleton-instans av PDO-anslutningen.
     * Använder sig av SQLite och aktiverar foreign keys.
     */
    public static function getInstance(): PDO {
           // Kontrollera om anslutningen redan finns
        if (self::$instance === null) {
            // Sökvägen till SQLite-databasen
            $dbPath = __DIR__ . '/../../db/WallentinAnna.db';
             // Skapa PDO-anslutningen
            self::$instance = new PDO('sqlite:' . $dbPath);
              // Aktivera felrapportering så att PDO kastar exceptions vid fel
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Gör så att fetch() returnerar associativa arrayer som standard
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Aktiverar foreign key‑stöd i SQLite (avstängt som standard)
            self::$instance->exec('PRAGMA foreign_keys = ON;');
            // Skapa tabellerna om de inte finns
            self::createTables(self::$instance);
        }
          // Returnera den befintliga instansen
        return self::$instance;
    }
 
    /**
     * Skapar databastabellerna om de inte redan existerar.
     * Tabeller: users, posts
     */
    private static function createTables(PDO $db): void {
        $db->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT NOT NULL UNIQUE,
                name TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                avatar TEXT DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
 
            CREATE TABLE IF NOT EXISTS posts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                message TEXT NOT NULL,
                image TEXT DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            );
        ");
    }
}

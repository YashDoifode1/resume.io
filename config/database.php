<?php
// config/database.php

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Database connection failed. Please try again later.");
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Theme-related methods
    public function getActiveThemes() {
        try {
            $stmt = $this->connection->prepare("
                SELECT id, slug, name, description, file_name, is_active, is_premium 
                FROM themes 
                WHERE is_active = 1 
                ORDER BY name ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching themes: " . $e->getMessage());
            return [];
        }
    }
    
    public function getThemeBySlug($slug) {
        try {
            $stmt = $this->connection->prepare("
                SELECT id, slug, name, description, file_name, is_active, is_premium 
                FROM themes 
                WHERE slug = ? AND is_active = 1
            ");
            $stmt->execute([$slug]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error fetching theme by slug: " . $e->getMessage());
            return null;
        }
    }
    
    public function themeFileExists($fileName) {
        $themePath = THEMES_PATH . $fileName;
        return file_exists($themePath);
    }
}

// Create global PDO instance for backward compatibility
try {
    $pdo = Database::getInstance()->getConnection();
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
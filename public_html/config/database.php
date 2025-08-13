<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'u925328211_ncb');
define('DB_PASS', 'Aman123@f24tech24');
define('DB_NAME', 'u925328211_ncb');

// Create database connection
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        return null;
    }
}

// Database helper class
class DB {
    private static $connection = null;
    
    public static function getConnection() {
        if (self::$connection === null) {
            self::$connection = getDBConnection();
        }
        return self::$connection;
    }
    
    public static function query($sql, $params = []) {
        $pdo = self::getConnection();
        if (!$pdo) return false;
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            return false;
        }
    }
    
    public static function fetch($sql, $params = []) {
        $stmt = self::query($sql, $params);
        return $stmt ? $stmt->fetch() : false;
    }
    
    public static function fetchAll($sql, $params = []) {
        $stmt = self::query($sql, $params);
        return $stmt ? $stmt->fetchAll() : false;
    }
    
    public static function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        
        $stmt = self::query($sql, $data);
        return $stmt ? self::getConnection()->lastInsertId() : false;
    }
    
    public static function update($table, $data, $where) {
        $set = [];
        foreach (array_keys($data) as $key) {
            $set[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $set);
        
        $whereClause = [];
        $whereParams = [];
        foreach ($where as $key => $value) {
            $whereClause[] = "{$key} = :where_{$key}";
            $whereParams["where_{$key}"] = $value;
        }
        $whereClauseStr = implode(' AND ', $whereClause);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$whereClauseStr}";
        $params = array_merge($data, $whereParams);
        
        return self::query($sql, $params);
    }
    
    public static function delete($table, $where) {
        $whereClause = [];
        foreach (array_keys($where) as $key) {
            $whereClause[] = "{$key} = :{$key}";
        }
        $whereClauseStr = implode(' AND ', $whereClause);
        
        $sql = "DELETE FROM {$table} WHERE {$whereClauseStr}";
        return self::query($sql, $where);
    }
    
    public static function findOne($table, $conditions = []) {
        $whereClause = '';
        if ($conditions) {
            $whereConditions = [];
            foreach (array_keys($conditions) as $key) {
                $whereConditions[] = "{$key} = :{$key}";
            }
            $whereClause = 'WHERE ' . implode(' AND ', $whereConditions);
        }
        
        $sql = "SELECT * FROM {$table} {$whereClause} LIMIT 1";
        $stmt = self::query($sql, $conditions);
        return $stmt ? $stmt->fetch() : false;
    }
}

// Initialize database tables if they don't exist
function initializeDatabase() {
    $pdo = getDBConnection();
    if (!$pdo) return false;
    
    try {
        // Create projects table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS projects (
                id INT PRIMARY KEY AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                long_description TEXT,
                client VARCHAR(255),
                category VARCHAR(100),
                duration VARCHAR(100),
                team_size VARCHAR(50),
                image_url TEXT,
                challenge TEXT,
                solution TEXT,
                status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");
        
        // Create project features table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS project_features (
                id INT PRIMARY KEY AUTO_INCREMENT,
                project_id INT,
                feature TEXT,
                FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
            )
        ");
        
        // Create project technologies table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS project_technologies (
                id INT PRIMARY KEY AUTO_INCREMENT,
                project_id INT,
                technology VARCHAR(100),
                FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
            )
        ");
        
        // Create project tags table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS project_tags (
                id INT PRIMARY KEY AUTO_INCREMENT,
                project_id INT,
                tag VARCHAR(100),
                FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
            )
        ");
        
        // Create project results table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS project_results (
                id INT PRIMARY KEY AUTO_INCREMENT,
                project_id INT,
                result TEXT,
                FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
            )
        ");
        
        // Create project testimonials table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS project_testimonials (
                id INT PRIMARY KEY AUTO_INCREMENT,
                project_id INT,
                testimonial_text TEXT,
                author_name VARCHAR(255),
                author_role VARCHAR(255),
                FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
            )
        ");
        
        // Create contact submissions table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS contact_submissions (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                company VARCHAR(255),
                phone VARCHAR(50),
                service_interest VARCHAR(255),
                budget_range VARCHAR(100),
                message TEXT NOT NULL,
                status ENUM('new', 'contacted', 'qualified', 'closed') DEFAULT 'new',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Create newsletter subscriptions table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS newsletter_subscriptions (
                id INT PRIMARY KEY AUTO_INCREMENT,
                email VARCHAR(255) UNIQUE NOT NULL,
                status ENUM('active', 'unsubscribed') DEFAULT 'active',
                subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Create page views table for analytics
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS page_views (
                id INT PRIMARY KEY AUTO_INCREMENT,
                session_id VARCHAR(255),
                page_url VARCHAR(500),
                page_title VARCHAR(255),
                time_on_page INT DEFAULT 0,
                view_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        return true;
    } catch (PDOException $e) {
        error_log("Database initialization failed: " . $e->getMessage());
        return false;
    }
}

// Initialize database on first load
initializeDatabase();
?>
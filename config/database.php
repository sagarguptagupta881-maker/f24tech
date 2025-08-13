@@ .. @@
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
         
+        // Create blog posts table
+        $pdo->exec("
+            CREATE TABLE IF NOT EXISTS blog_posts (
+                id INT PRIMARY KEY AUTO_INCREMENT,
+                title VARCHAR(255) NOT NULL,
+                slug VARCHAR(255) UNIQUE NOT NULL,
+                excerpt TEXT,
+                content LONGTEXT NOT NULL,
+                featured_image VARCHAR(500),
+                author VARCHAR(255) DEFAULT 'F24Tech Team',
+                category VARCHAR(100),
+                tags TEXT,
+                meta_title VARCHAR(255),
+                meta_description TEXT,
+                meta_keywords TEXT,
+                status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
+                featured BOOLEAN DEFAULT FALSE,
+                views INT DEFAULT 0,
+                reading_time INT DEFAULT 0,
+                language VARCHAR(10) DEFAULT 'en',
+                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
+                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
+            )
+        ");
+        
+        // Create blog categories table
+        $pdo->exec("
+            CREATE TABLE IF NOT EXISTS blog_categories (
+                id INT PRIMARY KEY AUTO_INCREMENT,
+                name VARCHAR(100) UNIQUE NOT NULL,
+                slug VARCHAR(100) UNIQUE NOT NULL,
+                description TEXT,
+                color VARCHAR(7) DEFAULT '#3B82F6',
+                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
+            )
+        ");
+        
+        // Create blog comments table
+        $pdo->exec("
+            CREATE TABLE IF NOT EXISTS blog_comments (
+                id INT PRIMARY KEY AUTO_INCREMENT,
+                post_id INT,
+                name VARCHAR(255) NOT NULL,
+                email VARCHAR(255) NOT NULL,
+                comment TEXT NOT NULL,
+                status ENUM('pending', 'approved', 'spam') DEFAULT 'pending',
+                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
+                FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE
+            )
+        ");
+        
+        // Insert default blog categories
+        $pdo->exec("
+            INSERT IGNORE INTO blog_categories (name, slug, description, color) VALUES
+            ('Technology', 'technology', 'Latest technology trends and insights', '#3B82F6'),
+            ('AI & Machine Learning', 'ai-machine-learning', 'Artificial Intelligence and ML developments', '#8B5CF6'),
+            ('Web Development', 'web-development', 'Web development tips and tutorials', '#10B981'),
+            ('Mobile Development', 'mobile-development', 'Mobile app development insights', '#F59E0B'),
+            ('Cloud Computing', 'cloud-computing', 'Cloud solutions and best practices', '#06B6D4'),
+            ('Cybersecurity', 'cybersecurity', 'Security trends and best practices', '#EF4444'),
+            ('Data Analytics', 'data-analytics', 'Data science and analytics insights', '#8B5CF6'),
+            ('DevOps', 'devops', 'DevOps practices and tools', '#6366F1'),
+            ('UI/UX Design', 'ui-ux-design', 'Design trends and user experience', '#EC4899'),
+            ('Industry News', 'industry-news', 'Latest industry news and updates', '#6B7280')
+        ");
+        
         return true;
     } catch (PDOException $e) {
         error_log("Database initialization failed: " . $e->getMessage());
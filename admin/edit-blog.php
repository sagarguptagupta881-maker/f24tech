<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

$page_title = 'Edit Blog Post - Admin - F24Tech';
$success = '';
$error = '';
$post = null;

// Get post ID
$post_id = (int)($_GET['id'] ?? 0);

if (!$post_id) {
    header('Location: manage-blog.php');
    exit;
}

// Get post data
try {
    $post = DB::findOne('blog_posts', ['id' => $post_id]);
    if (!$post) {
        header('Location: manage-blog.php');
        exit;
    }
} catch (Exception $e) {
    $error = 'Error loading post: ' . $e->getMessage();
}

// Handle form submission
if ($_POST && $post) {
    try {
        $title = $_POST['title'] ?? '';
        $slug = $_POST['slug'] ?? '';
        $excerpt = $_POST['excerpt'] ?? '';
        $content = $_POST['content'] ?? '';
        $featured_image = $_POST['featured_image'] ?? '';
        $author = $_POST['author'] ?? 'F24Tech Team';
        $category = $_POST['category'] ?? '';
        $tags = $_POST['tags'] ?? '';
        $meta_title = $_POST['meta_title'] ?? $title;
        $meta_description = $_POST['meta_description'] ?? $excerpt;
        $meta_keywords = $_POST['meta_keywords'] ?? '';
        $status = $_POST['status'] ?? 'draft';
        $featured = isset($_POST['featured']) ? 1 : 0;
        $language = $_POST['language'] ?? 'en';
        
        // Calculate reading time
        $word_count = str_word_count(strip_tags($content));
        $reading_time = max(1, ceil($word_count / 200));
        
        // Check if slug already exists (excluding current post)
        $existing = DB::query("SELECT id FROM blog_posts WHERE slug = ? AND id != ?", [$slug, $post_id])->fetch();
        if ($existing) {
            $slug = $slug . '-' . time();
        }
        
        // Update blog post
        DB::update('blog_posts', [
            'title' => $title,
            'slug' => $slug,
            'excerpt' => $excerpt,
            'content' => $content,
            'featured_image' => $featured_image,
            'author' => $author,
            'category' => $category,
            'tags' => $tags,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'status' => $status,
            'featured' => $featured,
            'reading_time' => $reading_time,
            'language' => $language
        ], ['id' => $post_id]);
        
        $success = 'Blog post updated successfully!';
        
        // Refresh post data
        $post = DB::findOne('blog_posts', ['id' => $post_id]);
        
    } catch (Exception $e) {
        $error = 'Error updating post: ' . $e->getMessage();
    }
}

// Get categories
$categories = DB::query("SELECT * FROM blog_categories ORDER BY name")->fetchAll();

include '../includes/admin-header.php';
?>

<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Blog Post</h1>
                    <p class="text-gray-600">Update blog post content and settings</p>
                </div>
                <div class="flex space-x-4">
                    <a href="../?page=blog-post&slug=<?php echo urlencode($post['slug']); ?>" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        View Post
                    </a>
                    <a href="manage-blog.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Back to Blog Management
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if ($success): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($post): ?>
            <form method="POST" class="space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Basic Information -->
                        <div class="bg-white rounded-2xl p-8 shadow-lg">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Post Content</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                                    <input type="text" name="title" required value="<?php echo htmlspecialchars($post['title']); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug *</label>
                                    <input type="text" name="slug" required value="<?php echo htmlspecialchars($post['slug']); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <p class="text-sm text-gray-500 mt-1">URL: <?php echo $_SERVER['HTTP_HOST']; ?>/blog/<?php echo htmlspecialchars($post['slug']); ?></p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                                    <textarea name="excerpt" rows="3" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars($post['excerpt'] ?? ''); ?></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                                    <textarea name="content" required rows="20" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars($post['content']); ?></textarea>
                                    <p class="text-sm text-gray-500 mt-1">Current reading time: <?php echo $post['reading_time']; ?> minutes</p>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="bg-white rounded-2xl p-8 shadow-lg">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">SEO Settings</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                                    <input type="text" name="meta_title" maxlength="60" value="<?php echo htmlspecialchars($post['meta_title'] ?? ''); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                                    <textarea name="meta_description" rows="3" maxlength="160"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars($post['meta_description'] ?? ''); ?></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" value="<?php echo htmlspecialchars($post['meta_keywords'] ?? ''); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-8">
                        <!-- Post Stats -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Post Statistics</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Views:</span>
                                    <span class="font-semibold"><?php echo number_format($post['views']); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Reading Time:</span>
                                    <span class="font-semibold"><?php echo $post['reading_time']; ?> min</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Created:</span>
                                    <span class="font-semibold"><?php echo date('M j, Y', strtotime($post['created_at'])); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Updated:</span>
                                    <span class="font-semibold"><?php echo date('M j, Y', strtotime($post['updated_at'])); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Publish Settings -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Publish Settings</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="draft" <?php echo $post['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                        <option value="published" <?php echo $post['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                                        <option value="archived" <?php echo $post['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                                    <select name="language" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="en" <?php echo $post['language'] === 'en' ? 'selected' : ''; ?>>English</option>
                                        <option value="es" <?php echo $post['language'] === 'es' ? 'selected' : ''; ?>>Spanish</option>
                                        <option value="fr" <?php echo $post['language'] === 'fr' ? 'selected' : ''; ?>>French</option>
                                        <option value="de" <?php echo $post['language'] === 'de' ? 'selected' : ''; ?>>German</option>
                                        <option value="hi" <?php echo $post['language'] === 'hi' ? 'selected' : ''; ?>>Hindi</option>
                                        <option value="zh" <?php echo $post['language'] === 'zh' ? 'selected' : ''; ?>>Chinese</option>
                                        <option value="ja" <?php echo $post['language'] === 'ja' ? 'selected' : ''; ?>>Japanese</option>
                                    </select>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" name="featured" id="featured" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" <?php echo $post['featured'] ? 'checked' : ''; ?>>
                                    <label for="featured" class="ml-2 text-sm text-gray-700">Featured Post</label>
                                </div>
                            </div>
                        </div>

                        <!-- Post Details -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Post Details</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Author</label>
                                    <input type="text" name="author" value="<?php echo htmlspecialchars($post['author']); ?>"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo htmlspecialchars($category['name']); ?>" <?php echo $post['category'] === $category['name'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                    <input type="text" name="tags" value="<?php echo htmlspecialchars($post['tags'] ?? ''); ?>"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image URL</label>
                                    <input type="url" name="featured_image" value="<?php echo htmlspecialchars($post['featured_image'] ?? ''); ?>"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php if ($post['featured_image']): ?>
                                        <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="Featured Image" class="mt-2 w-full h-32 object-cover rounded">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-12 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors text-lg">
                        Update Blog Post
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Add Blog Post - Admin - F24Tech';
$success = '';
$error = '';

if ($_POST) {
    include '../config/database.php';
    
    try {
        $title = $_POST['title'] ?? '';
        $slug = $_POST['slug'] ?? strtolower(str_replace([' ', '_'], '-', preg_replace('/[^a-zA-Z0-9\s_-]/', '', $title)));
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
        
        // Calculate reading time (average 200 words per minute)
        $word_count = str_word_count(strip_tags($content));
        $reading_time = max(1, ceil($word_count / 200));
        
        // Check if slug already exists
        $existing = DB::findOne('blog_posts', ['slug' => $slug]);
        if ($existing) {
            $slug = $slug . '-' . time();
        }
        
        // Insert blog post
        $post_id = DB::insert('blog_posts', [
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
        ]);
        
        $success = 'Blog post created successfully!';
        
        // Send notification email
        $to = 'sales@f24tech.com';
        $subject = 'New Blog Post Created: ' . $title;
        $email_body = "
New blog post has been created:

Title: $title
Author: $author
Category: $category
Status: $status
Reading Time: $reading_time minutes

Excerpt:
$excerpt

View/Edit: " . $_SERVER['HTTP_HOST'] . "/admin/edit-blog.php?id=$post_id

---
F24Tech Admin System
";

        $headers = "From: F24Tech <noreply@f24tech.com>\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        mail($to, $subject, $email_body, $headers);
        
    } catch (Exception $e) {
        $error = 'Error creating blog post: ' . $e->getMessage();
    }
}

// Get categories
include '../config/database.php';
$categories = DB::query("SELECT * FROM blog_categories ORDER BY name")->fetchAll();

include '../includes/admin-header.php';
?>

<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Add New Blog Post</h1>
                    <p class="text-gray-600">Create a new blog post with SEO optimization</p>
                </div>
                <a href="manage-blog.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Back to Blog Management
                </a>
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
                                <input type="text" name="title" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter post title"
                                       onkeyup="generateSlug(this.value)">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug *</label>
                                <input type="text" name="slug" id="slug" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="url-friendly-slug">
                                <p class="text-sm text-gray-500 mt-1">URL: <?php echo $_SERVER['HTTP_HOST']; ?>/blog/<span id="slug-preview">your-slug</span></p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                                <textarea name="excerpt" rows="3" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                          placeholder="Brief description of the post (used in previews and meta description)"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                                <textarea name="content" required rows="20" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                          placeholder="Write your blog post content here... You can use HTML tags for formatting."></textarea>
                                <p class="text-sm text-gray-500 mt-1">You can use HTML tags for formatting. Reading time will be calculated automatically.</p>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">SEO Settings</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                                <input type="text" name="meta_title" maxlength="60"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="SEO title (leave empty to use post title)">
                                <p class="text-sm text-gray-500 mt-1">Recommended: 50-60 characters</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                                <textarea name="meta_description" rows="3" maxlength="160"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                          placeholder="SEO description (leave empty to use excerpt)"></textarea>
                                <p class="text-sm text-gray-500 mt-1">Recommended: 150-160 characters</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                                <input type="text" name="meta_keywords" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="AI, machine learning, technology, software development">
                                <p class="text-sm text-gray-500 mt-1">Comma-separated keywords for SEO</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Publish Settings -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Publish Settings</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                                <select name="language" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="en">English</option>
                                    <option value="es">Spanish</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                    <option value="hi">Hindi</option>
                                    <option value="zh">Chinese</option>
                                    <option value="ja">Japanese</option>
                                </select>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" name="featured" id="featured" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
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
                                <input type="text" name="author" value="F24Tech Team"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['name']); ?>">
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                <input type="text" name="tags" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="AI, Machine Learning, Technology">
                                <p class="text-sm text-gray-500 mt-1">Comma-separated tags</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image URL</label>
                                <input type="url" name="featured_image" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="https://images.pexels.com/...">
                            </div>
                        </div>
                    </div>

                    <!-- Trending Keywords -->
                    <div class="bg-blue-50 rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Trending Tech Keywords</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php
                            $trending_keywords = [
                                'AI', 'Machine Learning', 'ChatGPT', 'Blockchain', 'Web3', 'NFT', 'Metaverse',
                                'Cloud Computing', 'DevOps', 'Kubernetes', 'Docker', 'React', 'Next.js',
                                'TypeScript', 'Python', 'JavaScript', 'Node.js', 'GraphQL', 'REST API',
                                'Cybersecurity', 'Data Science', 'Big Data', 'IoT', 'Edge Computing',
                                '5G', 'Quantum Computing', 'AR/VR', 'Mobile Development', 'Flutter',
                                'React Native', 'Progressive Web Apps', 'Serverless', 'Microservices'
                            ];
                            
                            foreach (array_slice($trending_keywords, 0, 20) as $keyword): ?>
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs cursor-pointer hover:bg-blue-200"
                                      onclick="addKeyword('<?php echo $keyword; ?>')">
                                    <?php echo $keyword; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">Click to add to meta keywords</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" 
                        class="bg-blue-600 text-white px-12 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors text-lg">
                    Create Blog Post
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function generateSlug(title) {
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    
    document.getElementById('slug').value = slug;
    document.getElementById('slug-preview').textContent = slug || 'your-slug';
}

function addKeyword(keyword) {
    const keywordsInput = document.querySelector('input[name="meta_keywords"]');
    const currentKeywords = keywordsInput.value;
    
    if (currentKeywords) {
        if (!currentKeywords.includes(keyword)) {
            keywordsInput.value = currentKeywords + ', ' + keyword;
        }
    } else {
        keywordsInput.value = keyword;
    }
}

// Auto-generate meta title and description from title and excerpt
document.querySelector('input[name="title"]').addEventListener('input', function() {
    const metaTitleInput = document.querySelector('input[name="meta_title"]');
    if (!metaTitleInput.value) {
        metaTitleInput.value = this.value;
    }
});

document.querySelector('textarea[name="excerpt"]').addEventListener('input', function() {
    const metaDescInput = document.querySelector('textarea[name="meta_description"]');
    if (!metaDescInput.value) {
        metaDescInput.value = this.value;
    }
});
</script>

<?php include '../includes/admin-footer.php'; ?>
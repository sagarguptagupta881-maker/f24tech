<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

$page_title = 'Manage Categories - Admin - F24Tech';
$success = '';
$error = '';

// Handle actions
if ($_POST) {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add_category') {
        try {
            $name = $_POST['name'] ?? '';
            $slug = $_POST['slug'] ?? strtolower(str_replace([' ', '_'], '-', preg_replace('/[^a-zA-Z0-9\s_-]/', '', $name)));
            $description = $_POST['description'] ?? '';
            $color = $_POST['color'] ?? '#3B82F6';
            
            // Check if slug already exists
            $existing = DB::findOne('blog_categories', ['slug' => $slug]);
            if ($existing) {
                $slug = $slug . '-' . time();
            }
            
            DB::insert('blog_categories', [
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'color' => $color
            ]);
            
            $success = 'Category added successfully!';
        } catch (Exception $e) {
            $error = 'Error adding category: ' . $e->getMessage();
        }
    }
    
    if ($action === 'delete_category' && !empty($_POST['category_id'])) {
        try {
            $category_id = (int)$_POST['category_id'];
            DB::delete('blog_categories', ['id' => $category_id]);
            $success = 'Category deleted successfully!';
        } catch (Exception $e) {
            $error = 'Error deleting category: ' . $e->getMessage();
        }
    }
}

// Get all categories
$categories = DB::query("SELECT * FROM blog_categories ORDER BY name")->fetchAll();

include '../includes/admin-header.php';
?>

<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manage Categories</h1>
                    <p class="text-gray-600">Organize your blog posts with categories</p>
                </div>
                <a href="manage-blog.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Back to Blog Management
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Add Category Form -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Add New Category</h3>
                
                <form method="POST" class="space-y-6">
                    <input type="hidden" name="action" value="add_category">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                        <input type="text" name="name" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Technology">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                        <input type="text" name="slug" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="technology (auto-generated if empty)">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="Brief description of the category"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                        <input type="color" name="color" value="#3B82F6"
                               class="w-full h-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Add Category
                    </button>
                </form>
            </div>

            <!-- Categories List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Existing Categories</h3>
                    </div>
                    
                    <?php if ($categories): ?>
                        <div class="divide-y divide-gray-200">
                            <?php foreach ($categories as $category): ?>
                                <div class="p-6 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 rounded-full mr-4" style="background-color: <?php echo htmlspecialchars($category['color']); ?>"></div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($category['name']); ?></h4>
                                            <p class="text-sm text-gray-500">Slug: <?php echo htmlspecialchars($category['slug']); ?></p>
                                            <?php if ($category['description']): ?>
                                                <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($category['description']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <?php
                                        // Count posts in this category
                                        $post_count = DB::query("SELECT COUNT(*) as count FROM blog_posts WHERE category = ?", [$category['name']])->fetch()['count'] ?? 0;
                                        ?>
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                            <?php echo $post_count; ?> posts
                                        </span>
                                        
                                        <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            <input type="hidden" name="action" value="delete_category">
                                            <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-800 p-1" title="Delete Category">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="p-8 text-center text-gray-500">
                            No categories found. Add your first category using the form.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
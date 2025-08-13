<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

$page_title = 'Manage Blog - Admin - F24Tech';
$success = '';
$error = '';

// Handle actions
if ($_POST) {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'delete' && !empty($_POST['post_id'])) {
        try {
            $post_id = (int)$_POST['post_id'];
            
            // Delete related records first
            DB::delete('blog_comments', ['post_id' => $post_id]);
            
            // Delete blog post
            DB::delete('blog_posts', ['id' => $post_id]);
            
            $success = 'Blog post deleted successfully!';
        } catch (Exception $e) {
            $error = 'Error deleting blog post: ' . $e->getMessage();
        }
    }
    
    if ($action === 'update_status' && !empty($_POST['post_id']) && !empty($_POST['status'])) {
        try {
            DB::update('blog_posts', 
                ['status' => $_POST['status']], 
                ['id' => (int)$_POST['post_id']]
            );
            $success = 'Blog post status updated successfully!';
        } catch (Exception $e) {
            $error = 'Error updating status: ' . $e->getMessage();
        }
    }
    
    if ($action === 'toggle_featured' && !empty($_POST['post_id'])) {
        try {
            $post_id = (int)$_POST['post_id'];
            $current = DB::findOne('blog_posts', ['id' => $post_id]);
            $new_featured = $current['featured'] ? 0 : 1;
            
            DB::update('blog_posts', 
                ['featured' => $new_featured], 
                ['id' => $post_id]
            );
            $success = 'Featured status updated successfully!';
        } catch (Exception $e) {
            $error = 'Error updating featured status: ' . $e->getMessage();
        }
    }
}

// Get filters
$category_filter = $_GET['category'] ?? '';
$status_filter = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

// Build query
$where_conditions = [];
$params = [];

if ($category_filter) {
    $where_conditions[] = "category = ?";
    $params[] = $category_filter;
}

if ($status_filter) {
    $where_conditions[] = "status = ?";
    $params[] = $status_filter;
}

if ($search) {
    $where_conditions[] = "(title LIKE ? OR content LIKE ? OR author LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$where_clause = $where_conditions ? 'WHERE ' . implode(' AND ', $where_conditions) : '';
$posts = DB::query("SELECT * FROM blog_posts $where_clause ORDER BY updated_at DESC", $params)->fetchAll();

// Get categories for filter
$categories = DB::query("SELECT DISTINCT category FROM blog_posts WHERE category IS NOT NULL AND category != ''")->fetchAll();

include '../includes/admin-header.php';
?>

<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manage Blog</h1>
                    <p class="text-gray-600">View and manage all your blog posts</p>
                </div>
                <div class="flex space-x-4">
                    <a href="add-blog.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Add New Post
                    </a>
                    <a href="manage-categories.php" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Manage Categories
                    </a>
                    <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form method="GET" class="flex flex-wrap gap-4 items-center">
                <div>
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Search posts..." 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['category']); ?>" <?php echo $category_filter === $cat['category'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['category']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="draft" <?php echo $status_filter === 'draft' ? 'selected' : ''; ?>>Draft</option>
                        <option value="published" <?php echo $status_filter === 'published' ? 'selected' : ''; ?>>Published</option>
                        <option value="archived" <?php echo $status_filter === 'archived' ? 'selected' : ''; ?>>Archived</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Filter
                </button>
                <a href="manage-blog.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Clear
                </a>
            </form>
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

        <?php if ($posts): ?>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Post</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Views</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Updated</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($posts as $post): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <?php if ($post['featured_image']): ?>
                                                <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" 
                                                     alt="<?php echo htmlspecialchars($post['title']); ?>"
                                                     class="w-12 h-12 rounded-lg object-cover mr-4">
                                            <?php else: ?>
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg mr-4 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 flex items-center">
                                                    <?php echo htmlspecialchars($post['title']); ?>
                                                    <?php if ($post['featured']): ?>
                                                        <span class="ml-2 bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Featured</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo htmlspecialchars(substr($post['excerpt'] ?: strip_tags($post['content']), 0, 50)) . '...'; ?>
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    By <?php echo htmlspecialchars($post['author']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($post['category']): ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <?php echo htmlspecialchars($post['category']); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-400">No category</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="action" value="update_status">
                                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="text-xs font-semibold rounded-full px-2 py-1 border-0 <?php 
                                                    echo $post['status'] === 'published' ? 'bg-green-100 text-green-800' : 
                                                        ($post['status'] === 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800'); 
                                                    ?>">
                                                <option value="draft" <?php echo $post['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                                <option value="published" <?php echo $post['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                                                <option value="archived" <?php echo $post['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <?php echo number_format($post['views']); ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <?php echo date('M j, Y', strtotime($post['updated_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="../?page=blog-post&slug=<?php echo urlencode($post['slug']); ?>" 
                                               target="_blank"
                                               class="text-blue-600 hover:text-blue-800 p-1" title="View Post">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="edit-blog.php?id=<?php echo $post['id']; ?>" 
                                               class="text-green-600 hover:text-green-800 p-1" title="Edit Post">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form method="POST" class="inline">
                                                <input type="hidden" name="action" value="toggle_featured">
                                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-800 p-1" title="Toggle Featured">
                                                    <svg class="h-4 w-4 <?php echo $post['featured'] ? 'fill-current' : ''; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                                <button type="submit" class="text-red-600 hover:text-red-800 p-1" title="Delete Post">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="text-gray-500 mb-4">No blog posts found</div>
                <a href="add-blog.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Add Your First Post
                </a>
            </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php
            $total_posts = count($posts);
            $published_posts = count(array_filter($posts, fn($p) => $p['status'] === 'published'));
            $draft_posts = count(array_filter($posts, fn($p) => $p['status'] === 'draft'));
            $total_views = array_sum(array_column($posts, 'views'));
            ?>
            <div class="bg-blue-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo $total_posts; ?></div>
                <div class="text-gray-600">Total Posts</div>
            </div>
            <div class="bg-green-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2"><?php echo $published_posts; ?></div>
                <div class="text-gray-600">Published</div>
            </div>
            <div class="bg-yellow-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-yellow-600 mb-2"><?php echo $draft_posts; ?></div>
                <div class="text-gray-600">Drafts</div>
            </div>
            <div class="bg-purple-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2"><?php echo number_format($total_views); ?></div>
                <div class="text-gray-600">Total Views</div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
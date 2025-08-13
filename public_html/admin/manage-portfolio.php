<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

$page_title = 'Manage Portfolio - Admin - F24Tech';
$success = '';
$error = '';

// Handle actions
if ($_POST) {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'delete' && !empty($_POST['project_id'])) {
        try {
            $project_id = (int)$_POST['project_id'];
            
            // Delete related records first
            DB::delete('project_features', ['project_id' => $project_id]);
            DB::delete('project_technologies', ['project_id' => $project_id]);
            DB::delete('project_tags', ['project_id' => $project_id]);
            DB::delete('project_results', ['project_id' => $project_id]);
            DB::delete('project_testimonials', ['project_id' => $project_id]);
            
            // Delete project
            DB::delete('projects', ['id' => $project_id]);
            
            $success = 'Project deleted successfully!';
        } catch (Exception $e) {
            $error = 'Error deleting project: ' . $e->getMessage();
        }
    }
    
    if ($action === 'update_status' && !empty($_POST['project_id']) && !empty($_POST['status'])) {
        try {
            DB::update('projects', 
                ['status' => $_POST['status']], 
                ['id' => (int)$_POST['project_id']]
            );
            $success = 'Project status updated successfully!';
        } catch (Exception $e) {
            $error = 'Error updating status: ' . $e->getMessage();
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
    $where_conditions[] = "(title LIKE ? OR client LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$where_clause = $where_conditions ? 'WHERE ' . implode(' AND ', $where_conditions) : '';
$projects = DB::query("SELECT * FROM projects $where_clause ORDER BY updated_at DESC", $params)->fetchAll();

include '../includes/admin-header.php';
?>

<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manage Portfolio</h1>
                    <p class="text-gray-600">View and manage all your projects</p>
                </div>
                <div class="flex space-x-4">
                    <a href="add-project.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Add New Project
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
                           placeholder="Search projects..." 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        <option value="Web Development" <?php echo $category_filter === 'Web Development' ? 'selected' : ''; ?>>Web Development</option>
                        <option value="Mobile App" <?php echo $category_filter === 'Mobile App' ? 'selected' : ''; ?>>Mobile App</option>
                        <option value="Healthcare" <?php echo $category_filter === 'Healthcare' ? 'selected' : ''; ?>>Healthcare</option>
                        <option value="FinTech" <?php echo $category_filter === 'FinTech' ? 'selected' : ''; ?>>FinTech</option>
                        <option value="E-commerce" <?php echo $category_filter === 'E-commerce' ? 'selected' : ''; ?>>E-commerce</option>
                        <option value="IoT" <?php echo $category_filter === 'IoT' ? 'selected' : ''; ?>>IoT</option>
                        <option value="AI/ML" <?php echo $category_filter === 'AI/ML' ? 'selected' : ''; ?>>AI/ML</option>
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
                <a href="manage-portfolio.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
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

        <?php if ($projects): ?>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Project</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Updated</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($projects as $project): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <?php if ($project['image_url']): ?>
                                                <img src="<?php echo htmlspecialchars($project['image_url']); ?>" 
                                                     alt="<?php echo htmlspecialchars($project['title']); ?>"
                                                     class="w-12 h-12 rounded-lg object-cover mr-4">
                                            <?php else: ?>
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg mr-4 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo htmlspecialchars($project['title']); ?>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo htmlspecialchars(substr($project['description'], 0, 50)) . '...'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <?php echo htmlspecialchars($project['client'] ?? 'No client'); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <?php echo htmlspecialchars($project['category']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="action" value="update_status">
                                            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="text-xs font-semibold rounded-full px-2 py-1 border-0 <?php 
                                                    echo $project['status'] === 'published' ? 'bg-green-100 text-green-800' : 
                                                        ($project['status'] === 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800'); 
                                                    ?>">
                                                <option value="draft" <?php echo $project['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                                <option value="published" <?php echo $project['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                                                <option value="archived" <?php echo $project['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <?php echo date('M j, Y', strtotime($project['updated_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="../?page=portfolio&project=<?php echo urlencode(strtolower(str_replace(' ', '-', $project['title']))); ?>" 
                                               target="_blank"
                                               class="text-blue-600 hover:text-blue-800 p-1" title="View Project">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="edit-project.php?id=<?php echo $project['id']; ?>" 
                                               class="text-green-600 hover:text-green-800 p-1" title="Edit Project">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                                                <button type="submit" class="text-red-600 hover:text-red-800 p-1" title="Delete Project">
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
                <div class="text-gray-500 mb-4">No projects found</div>
                <a href="add-project.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Add Your First Project
                </a>
            </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php
            $total_projects = count($projects);
            $published_projects = count(array_filter($projects, fn($p) => $p['status'] === 'published'));
            $draft_projects = count(array_filter($projects, fn($p) => $p['status'] === 'draft'));
            $archived_projects = count(array_filter($projects, fn($p) => $p['status'] === 'archived'));
            ?>
            <div class="bg-blue-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo $total_projects; ?></div>
                <div class="text-gray-600">Total Projects</div>
            </div>
            <div class="bg-green-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2"><?php echo $published_projects; ?></div>
                <div class="text-gray-600">Published</div>
            </div>
            <div class="bg-yellow-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-yellow-600 mb-2"><?php echo $draft_projects; ?></div>
                <div class="text-gray-600">Drafts</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-gray-600 mb-2"><?php echo $archived_projects; ?></div>
                <div class="text-gray-600">Archived</div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
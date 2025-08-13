<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

$page_title = 'Edit Project - Admin - F24Tech';
$success = '';
$error = '';
$project = null;

// Get project ID
$project_id = (int)($_GET['id'] ?? 0);

if (!$project_id) {
    header('Location: manage-portfolio.php');
    exit;
}

// Get project data
try {
    $project = DB::findOne('projects', ['id' => $project_id]);
    if (!$project) {
        header('Location: manage-portfolio.php');
        exit;
    }
    
    // Get related data
    $features = DB::query("SELECT feature FROM project_features WHERE project_id = ?", [$project_id])->fetchAll();
    $technologies = DB::query("SELECT technology FROM project_technologies WHERE project_id = ?", [$project_id])->fetchAll();
    $tags = DB::query("SELECT tag FROM project_tags WHERE project_id = ?", [$project_id])->fetchAll();
    $results = DB::query("SELECT result FROM project_results WHERE project_id = ?", [$project_id])->fetchAll();
    $testimonial = DB::findOne('project_testimonials', ['project_id' => $project_id]);
    
} catch (Exception $e) {
    $error = 'Error loading project: ' . $e->getMessage();
}

// Handle form submission
if ($_POST && $project) {
    try {
        // Update project
        DB::update('projects', [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'long_description' => $_POST['long_description'] ?? '',
            'client' => $_POST['client'] ?? '',
            'category' => $_POST['category'] ?? '',
            'duration' => $_POST['duration'] ?? '',
            'team_size' => $_POST['team_size'] ?? '',
            'image_url' => $_POST['image_url'] ?? '',
            'challenge' => $_POST['challenge'] ?? '',
            'solution' => $_POST['solution'] ?? '',
            'status' => $_POST['status'] ?? 'draft'
        ], ['id' => $project_id]);
        
        // Delete and re-insert related data
        DB::delete('project_features', ['project_id' => $project_id]);
        DB::delete('project_technologies', ['project_id' => $project_id]);
        DB::delete('project_tags', ['project_id' => $project_id]);
        DB::delete('project_results', ['project_id' => $project_id]);
        DB::delete('project_testimonials', ['project_id' => $project_id]);
        
        // Insert features
        if (!empty($_POST['features'])) {
            $features_list = explode("\n", $_POST['features']);
            foreach ($features_list as $feature) {
                $feature = trim($feature);
                if ($feature) {
                    DB::insert('project_features', [
                        'project_id' => $project_id,
                        'feature' => $feature
                    ]);
                }
            }
        }
        
        // Insert technologies
        if (!empty($_POST['technologies'])) {
            $tech_list = explode("\n", $_POST['technologies']);
            foreach ($tech_list as $tech) {
                $tech = trim($tech);
                if ($tech) {
                    DB::insert('project_technologies', [
                        'project_id' => $project_id,
                        'technology' => $tech
                    ]);
                }
            }
        }
        
        // Insert tags
        if (!empty($_POST['tags'])) {
            $tags_list = explode(",", $_POST['tags']);
            foreach ($tags_list as $tag) {
                $tag = trim($tag);
                if ($tag) {
                    DB::insert('project_tags', [
                        'project_id' => $project_id,
                        'tag' => $tag
                    ]);
                }
            }
        }
        
        // Insert results
        if (!empty($_POST['results'])) {
            $results_list = explode("\n", $_POST['results']);
            foreach ($results_list as $result) {
                $result = trim($result);
                if ($result) {
                    DB::insert('project_results', [
                        'project_id' => $project_id,
                        'result' => $result
                    ]);
                }
            }
        }
        
        // Insert testimonial
        if (!empty($_POST['testimonial_text'])) {
            DB::insert('project_testimonials', [
                'project_id' => $project_id,
                'testimonial_text' => $_POST['testimonial_text'],
                'author_name' => $_POST['testimonial_author'] ?? '',
                'author_role' => $_POST['testimonial_role'] ?? ''
            ]);
        }
        
        $success = 'Project updated successfully!';
        
        // Refresh data
        $project = DB::findOne('projects', ['id' => $project_id]);
        $features = DB::query("SELECT feature FROM project_features WHERE project_id = ?", [$project_id])->fetchAll();
        $technologies = DB::query("SELECT technology FROM project_technologies WHERE project_id = ?", [$project_id])->fetchAll();
        $tags = DB::query("SELECT tag FROM project_tags WHERE project_id = ?", [$project_id])->fetchAll();
        $results = DB::query("SELECT result FROM project_results WHERE project_id = ?", [$project_id])->fetchAll();
        $testimonial = DB::findOne('project_testimonials', ['project_id' => $project_id]);
        
    } catch (Exception $e) {
        $error = 'Error updating project: ' . $e->getMessage();
    }
}

include '../includes/admin-header.php';
?>

<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Project</h1>
                    <p class="text-gray-600">Update project information</p>
                </div>
                <div class="flex space-x-4">
                    <a href="manage-portfolio.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Back to Portfolio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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

        <?php if ($project): ?>
            <form method="POST" class="space-y-8">
                <!-- Basic Information -->
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Title *</label>
                            <input type="text" name="title" required value="<?php echo htmlspecialchars($project['title']); ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Client Name</label>
                            <input type="text" name="client" value="<?php echo htmlspecialchars($project['client'] ?? ''); ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                            <select name="category" required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Category</option>
                                <?php
                                $categories = ['Web Development', 'Mobile App', 'Healthcare', 'FinTech', 'E-commerce', 'IoT', 'AI/ML'];
                                foreach ($categories as $cat):
                                ?>
                                    <option value="<?php echo $cat; ?>" <?php echo $project['category'] === $cat ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                            <input type="text" name="duration" value="<?php echo htmlspecialchars($project['duration'] ?? ''); ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Team Size</label>
                            <input type="text" name="team_size" value="<?php echo htmlspecialchars($project['team_size'] ?? ''); ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="draft" <?php echo $project['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                <option value="published" <?php echo $project['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                                <option value="archived" <?php echo $project['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Project Image URL</label>
                        <input type="url" name="image_url" value="<?php echo htmlspecialchars($project['image_url'] ?? ''); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Descriptions -->
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Project Descriptions</h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Short Description *</label>
                            <textarea name="description" required rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars($project['description']); ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Detailed Description</label>
                            <textarea name="long_description" rows="5" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars($project['long_description'] ?? ''); ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Challenge</label>
                            <textarea name="challenge" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars($project['challenge'] ?? ''); ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Solution</label>
                            <textarea name="solution" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars($project['solution'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Project Details -->
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Project Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Features (one per line)</label>
                            <textarea name="features" rows="6" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars(implode("\n", array_column($features, 'feature'))); ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Technologies (one per line)</label>
                            <textarea name="technologies" rows="6" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars(implode("\n", array_column($technologies, 'technology'))); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tags (comma separated)</label>
                            <input type="text" name="tags" value="<?php echo htmlspecialchars(implode(', ', array_column($tags, 'tag'))); ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Results (one per line)</label>
                            <textarea name="results" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars(implode("\n", array_column($results, 'result'))); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Testimonial -->
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Client Testimonial</h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Testimonial Text</label>
                            <textarea name="testimonial_text" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"><?php echo htmlspecialchars($testimonial['testimonial_text'] ?? ''); ?></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Author Name</label>
                                <input type="text" name="testimonial_author" value="<?php echo htmlspecialchars($testimonial['author_name'] ?? ''); ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Author Role</label>
                                <input type="text" name="testimonial_role" value="<?php echo htmlspecialchars($testimonial['author_role'] ?? ''); ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-12 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors text-lg">
                        Update Project
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
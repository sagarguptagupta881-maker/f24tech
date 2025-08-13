<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Add Project - Admin - F24Tech';
$success = '';
$error = '';

if ($_POST) {
    include '../config/database.php';
    
    try {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $long_description = $_POST['long_description'] ?? '';
        $client = $_POST['client'] ?? '';
        $category = $_POST['category'] ?? '';
        $duration = $_POST['duration'] ?? '';
        $team_size = $_POST['team_size'] ?? '';
        $image_url = $_POST['image_url'] ?? '';
        $challenge = $_POST['challenge'] ?? '';
        $solution = $_POST['solution'] ?? '';
        $status = $_POST['status'] ?? 'draft';
        
        // Insert project
        $project_id = DB::insert('projects', [
            'title' => $title,
            'description' => $description,
            'long_description' => $long_description,
            'client' => $client,
            'category' => $category,
            'duration' => $duration,
            'team_size' => $team_size,
            'image_url' => $image_url,
            'challenge' => $challenge,
            'solution' => $solution,
            'status' => $status
        ]);
        
        // Insert features
        if (!empty($_POST['features'])) {
            $features = explode("\n", $_POST['features']);
            foreach ($features as $feature) {
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
            $technologies = explode("\n", $_POST['technologies']);
            foreach ($technologies as $tech) {
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
            $tags = explode(",", $_POST['tags']);
            foreach ($tags as $tag) {
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
            $results = explode("\n", $_POST['results']);
            foreach ($results as $result) {
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
        
        $success = 'Project added successfully!';
        
    } catch (Exception $e) {
        $error = 'Error adding project: ' . $e->getMessage();
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
                    <h1 class="text-3xl font-bold text-gray-900">Add New Project</h1>
                    <p class="text-gray-600">Add a new project to your portfolio</p>
                </div>
                <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Back to Dashboard
                </a>
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

        <form method="POST" class="space-y-8">
            <!-- Basic Information -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Project Title *</label>
                        <input type="text" name="title" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="E-Commerce Platform">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client Name</label>
                        <input type="text" name="client" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="TechCorp Inc.">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select name="category" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Category</option>
                            <option value="Web Development">Web Development</option>
                            <option value="Mobile App">Mobile App</option>
                            <option value="Healthcare">Healthcare</option>
                            <option value="FinTech">FinTech</option>
                            <option value="E-commerce">E-commerce</option>
                            <option value="IoT">IoT</option>
                            <option value="AI/ML">AI/ML</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                        <input type="text" name="duration" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="6 months">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Team Size</label>
                        <input type="text" name="team_size" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="8 members">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Project Image URL</label>
                    <input type="url" name="image_url" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://images.pexels.com/...">
                </div>
            </div>

            <!-- Descriptions -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Project Descriptions</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Short Description *</label>
                        <textarea name="description" required rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="A brief description of the project..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Detailed Description</label>
                        <textarea name="long_description" rows="5" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="Detailed description of the project..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Challenge</label>
                        <textarea name="challenge" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="What challenges did the client face?"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Solution</label>
                        <textarea name="solution" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="How did you solve the challenges?"></textarea>
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
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="Real-time notifications&#10;User authentication&#10;Payment processing"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Technologies (one per line)</label>
                        <textarea name="technologies" rows="6" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="React&#10;Node.js&#10;MongoDB"></textarea>
                    </div>
                </div>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tags (comma separated)</label>
                        <input type="text" name="tags" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="React, Node.js, MongoDB, API">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Results (one per line)</label>
                        <textarea name="results" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="300% increase in sales&#10;50% reduction in load time"></textarea>
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
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="The project exceeded our expectations..."></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Author Name</label>
                            <input type="text" name="testimonial_author" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="John Smith">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Author Role</label>
                            <input type="text" name="testimonial_role" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="CEO, TechCorp Inc.">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" 
                        class="bg-blue-600 text-white px-12 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors text-lg">
                    Add Project
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
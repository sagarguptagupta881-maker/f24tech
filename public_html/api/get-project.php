<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$project_id = (int)($_GET['id'] ?? 0);

if (!$project_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Project ID is required']);
    exit;
}

include '../config/database.php';

try {
    // Get project details
    $project = DB::findOne('projects', ['id' => $project_id, 'status' => 'published']);
    
    if (!$project) {
        http_response_code(404);
        echo json_encode(['error' => 'Project not found']);
        exit;
    }
    
    // Get related data
    $features = DB::query("SELECT feature FROM project_features WHERE project_id = ?", [$project_id])->fetchAll();
    $technologies = DB::query("SELECT technology FROM project_technologies WHERE project_id = ?", [$project_id])->fetchAll();
    $tags = DB::query("SELECT tag FROM project_tags WHERE project_id = ?", [$project_id])->fetchAll();
    $results = DB::query("SELECT result FROM project_results WHERE project_id = ?", [$project_id])->fetchAll();
    $testimonial = DB::findOne('project_testimonials', ['project_id' => $project_id]);
    
    // Format the response
    $project['features'] = array_column($features, 'feature');
    $project['technologies'] = array_column($technologies, 'technology');
    $project['tags'] = array_column($tags, 'tag');
    $project['results'] = array_column($results, 'result');
    $project['testimonial'] = $testimonial;
    
    echo json_encode([
        'success' => true,
        'project' => $project
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch project details']);
}
?>
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';

// Basic validation
if (empty($email)) {
    http_response_code(400);
    echo json_encode(['error' => 'Email is required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email address']);
    exit;
}

// Database connection
try {
    include '../config/database.php';
    
    // Check if email already exists
    $existing = DB::findOne('newsletter_subscriptions', ['email' => $email]);
    
    if ($existing) {
        if ($existing['status'] === 'active') {
            echo json_encode(['success' => true, 'message' => 'You are already subscribed to our newsletter!']);
            exit;
        } else {
            // Reactivate subscription
            DB::update('newsletter_subscriptions', 
                ['status' => 'active', 'subscribed_at' => date('Y-m-d H:i:s')], 
                ['email' => $email]
            );
        }
    } else {
        // Insert new subscription
        DB::insert('newsletter_subscriptions', [
            'email' => $email,
            'status' => 'active'
        ]);
    }
    
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to subscribe']);
    exit;
}

// Send welcome email
$to = $email;
$subject = 'Welcome to F24Tech Newsletter!';

$email_body = "
Dear Subscriber,

Welcome to the F24Tech Softwares newsletter!

Thank you for subscribing to our newsletter. You'll now receive:
- Latest technology insights and trends
- Company updates and announcements  
- Exclusive content and resources
- Industry best practices and tips

We're excited to share our knowledge and keep you updated with the latest in software development and technology.

Best regards,
F24Tech Softwares Team

Contact Information:
Email: sales@f24tech.com
Phone: +91 8950773419
Address: Plot No. 44, Sector 44, Gurgaon, Haryana, 122003, INDIA

Website: https://f24tech.com

---
You can unsubscribe at any time by replying to this email with 'UNSUBSCRIBE' in the subject line.
";

$headers = "From: sales@f24tech.com\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

mail($to, $subject, $email_body, $headers);

// Send notification to admin
$admin_subject = 'New Newsletter Subscription';
$admin_body = "
New newsletter subscription received:

Email: $email
Subscribed at: " . date('Y-m-d H:i:s') . "

Total active subscribers: " . (DB::query("SELECT COUNT(*) as count FROM newsletter_subscriptions WHERE status = 'active'")->fetch()['count'] ?? 0) . "
";

mail('sales@f24tech.com', $admin_subject, $admin_body, $headers);

echo json_encode(['success' => true, 'message' => 'Successfully subscribed to newsletter! Check your email for confirmation.']);
?>
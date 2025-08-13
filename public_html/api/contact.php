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

// Get and sanitize form data
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

$name = sanitize($_POST['name'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$company = sanitize($_POST['company'] ?? '');
$phone = sanitize($_POST['phone'] ?? '');
$service = sanitize($_POST['service'] ?? '');
$budget = sanitize($_POST['budget'] ?? '');
$message = sanitize($_POST['message'] ?? '');

// Basic validation
if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['error' => 'Name, email, and message are required']);
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
    
    $contact_id = DB::insert('contact_submissions', [
        'name' => $name,
        'email' => $email,
        'company' => $company,
        'phone' => $phone,
        'service_interest' => $service,
        'budget_range' => $budget,
        'message' => $message,
        'status' => 'new'
    ]);
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save contact information']);
    exit;
}

// Email notification to sales
$to = 'sales@f24tech.com';
$subject = 'New Contact Form Submission from ' . $name;
$email_body = "
New Contact Form Submission

Name: $name
Email: $email
Company: " . ($company ?: 'Not provided') . "
Phone: " . ($phone ?: 'Not provided') . "
Service Interest: " . ($service ?: 'Not specified') . "
Budget Range: " . ($budget ?: 'Not specified') . "

Message:
$message

---
Submitted on: " . date('Y-m-d H:i:s') . "
Contact ID: $contact_id
";

$headers = "From: F24Tech <noreply@f24tech.com>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email to sales
if (!mail($to, $subject, $email_body, $headers)) {
    error_log("Failed to send email to sales for contact ID: $contact_id");
}

// Auto-reply to user
$auto_reply_subject = 'Thank you for contacting F24Tech Softwares';
$auto_reply_body = "
Dear $name,

Thank you for reaching out to F24Tech Softwares. We have received your inquiry and will get back to you within 24 hours.

Summary of your submission:
- Service Interest: " . ($service ?: 'General Inquiry') . "
- Budget Range: " . ($budget ?: 'To be discussed') . "

Our team will review your requirements and contact you soon.

Best regards,
F24Tech Softwares Team

Contact:
Email: sales@f24tech.com
Phone: +91 8950773419
Address: Plot No. 44, Sector 44, Gurgaon, Haryana, 122003, INDIA
Website: https://f24tech.com
";

$auto_reply_headers = "From: F24Tech <sales@f24tech.com>\r\n";
$auto_reply_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$auto_reply_headers .= "X-Mailer: PHP/" . phpversion();

// Send auto-reply
if (!mail($email, $auto_reply_subject, $auto_reply_body, $auto_reply_headers)) {
    error_log("Failed to send auto-reply to $email for contact ID: $contact_id");
}

echo json_encode([
    'success' => true,
    'message' => 'Thank you for your message. We will get back to you within 24 hours!'
]);
?>

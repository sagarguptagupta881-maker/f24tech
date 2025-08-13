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
$action = $input['action'] ?? '';

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=u925328211_ncb', 'u925328211_ncb', 'Aman123@f24tech24');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

switch ($action) {
    case 'session':
        handleSessionTracking($pdo, $input);
        break;
    case 'pageview':
        handlePageViewTracking($pdo, $input);
        break;
    case 'interaction':
        handleInteractionTracking($pdo, $input);
        break;
    case 'consent':
        handleConsentTracking($pdo, $input);
        break;
    case 'contact':
        handleContactTracking($pdo, $input);
        break;
    case 'newsletter':
        handleNewsletterTracking($pdo, $input);
        break;
    case 'performance':
        handlePerformanceTracking($pdo, $input);
        break;
    case 'end_session':
        handleSessionEnd($pdo, $input);
        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        exit;
}

function handleSessionTracking($pdo, $input) {
    $sessionId = $input['sessionId'] ?? '';
    $userConsent = $input['userConsent'] ?? false;
    $referrer = $input['referrer'] ?? null;
    $landingPage = $input['landingPage'] ?? '/';
    $country = $input['country'] ?? null;
    $city = $input['city'] ?? null;
    
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
    
    // Parse user agent for device info
    $deviceType = 'desktop';
    if (preg_match('/Mobile|Android|iPhone/', $userAgent)) {
        $deviceType = preg_match('/iPad/', $userAgent) ? 'tablet' : 'mobile';
    }
    
    $browser = 'Unknown';
    if (strpos($userAgent, 'Chrome') !== false) $browser = 'Chrome';
    elseif (strpos($userAgent, 'Firefox') !== false) $browser = 'Firefox';
    elseif (strpos($userAgent, 'Safari') !== false) $browser = 'Safari';
    elseif (strpos($userAgent, 'Edge') !== false) $browser = 'Edge';
    
    $os = 'Unknown';
    if (strpos($userAgent, 'Windows') !== false) $os = 'Windows';
    elseif (strpos($userAgent, 'Mac') !== false) $os = 'macOS';
    elseif (strpos($userAgent, 'Linux') !== false) $os = 'Linux';
    elseif (strpos($userAgent, 'Android') !== false) $os = 'Android';
    elseif (strpos($userAgent, 'iOS') !== false) $os = 'iOS';
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO analytics_sessions 
            (session_id, user_consent, ip_address, user_agent, country, city, device_type, browser, os, referrer, landing_page, session_start) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE 
            user_consent = VALUES(user_consent),
            country = VALUES(country),
            city = VALUES(city)
        ");
        
        $stmt->execute([
            $sessionId, $userConsent, $ipAddress, $userAgent, 
            $country, $city, $deviceType, $browser, $os, $referrer, $landingPage
        ]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to track session']);
    }
}

function handlePageViewTracking($pdo, $input) {
    $sessionId = $input['sessionId'] ?? '';
    $pageUrl = $input['pageUrl'] ?? '';
    $pageTitle = $input['pageTitle'] ?? '';
    $timeOnPage = $input['timeOnPage'] ?? 0;
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO page_views (session_id, page_url, page_title, time_on_page, view_time) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([$sessionId, $pageUrl, $pageTitle, $timeOnPage]);
        
        // Update session page count
        $stmt = $pdo->prepare("
            UPDATE analytics_sessions 
            SET total_pages = total_pages + 1, last_activity = NOW() 
            WHERE session_id = ?
        ");
        $stmt->execute([$sessionId]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to track page view']);
    }
}

function handleInteractionTracking($pdo, $input) {
    $sessionId = $input['sessionId'] ?? '';
    $interactionType = $input['interactionType'] ?? '';
    $elementId = $input['elementId'] ?? null;
    $elementText = $input['elementText'] ?? null;
    $pageUrl = $input['pageUrl'] ?? '';
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO user_interactions (session_id, interaction_type, element_id, element_text, page_url, interaction_time) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([$sessionId, $interactionType, $elementId, $elementText, $pageUrl]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to track interaction']);
    }
}

function handleConsentTracking($pdo, $input) {
    $sessionId = $input['sessionId'] ?? '';
    $consentType = $input['consentType'] ?? '';
    $consentGiven = $input['consentGiven'] ?? false;
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO user_consent (session_id, consent_type, consent_given, ip_address, consent_time) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([$sessionId, $consentType, $consentGiven, $ipAddress]);
        
        // Update session consent status
        if ($consentType === 'analytics' && $consentGiven) {
            $stmt = $pdo->prepare("
                UPDATE analytics_sessions 
                SET user_consent = TRUE 
                WHERE session_id = ?
            ");
            $stmt->execute([$sessionId]);
        }
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to record consent']);
    }
}

function handleContactTracking($pdo, $input) {
    // This would be called from the contact form
    echo json_encode(['success' => true]);
}

function handleNewsletterTracking($pdo, $input) {
    $email = $input['email'] ?? '';
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid email address']);
        return;
    }
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO newsletter_subscriptions (email, subscribed_at) 
            VALUES (?, NOW())
            ON DUPLICATE KEY UPDATE 
            status = 'active', 
            subscribed_at = NOW()
        ");
        
        $stmt->execute([$email]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to subscribe']);
    }
}

function handlePerformanceTracking($pdo, $input) {
    $sessionId = $input['sessionId'] ?? '';
    $metric = $input['metric'] ?? '';
    $value = $input['value'] ?? 0;
    
    try {
        // Store performance metrics (you might want a separate table for this)
        $stmt = $pdo->prepare("
            INSERT INTO user_interactions (session_id, interaction_type, element_text, page_url, interaction_time) 
            VALUES (?, 'performance', ?, ?, NOW())
        ");
        
        $stmt->execute([$sessionId, $metric . ':' . $value, window.location.pathname]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to track performance']);
    }
}

function handleSessionEnd($pdo, $input) {
    $sessionId = $input['sessionId'] ?? '';
    $sessionDuration = $input['sessionDuration'] ?? 0;
    
    try {
        $stmt = $pdo->prepare("
            UPDATE analytics_sessions 
            SET total_time_seconds = ?, session_end = NOW() 
            WHERE session_id = ?
        ");
        
        $stmt->execute([$sessionDuration, $sessionId]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to end session']);
    }
}
?>
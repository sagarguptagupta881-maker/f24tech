<?php
session_start();
$current_page = $_GET['page'] ?? 'home';
$title = 'F24Tech Softwares Professional Website';

// Simple routing
$valid_pages = ['home', 'about', 'services', 'service-detail', 'portfolio', 'contact', 'blog', 'careers', 'privacy', 'terms'];
if (!in_array($current_page, $valid_pages)) {
    $current_page = 'home';
}

// Set page-specific titles
$page_titles = [
    'home' => 'F24Tech Softwares - Professional Software Development',
    'about' => 'About Us - F24Tech Softwares',
    'services' => 'Our Services - F24Tech Softwares',
    'service-detail' => 'Service Details - F24Tech Softwares',
    'portfolio' => 'Portfolio - F24Tech Softwares',
    'contact' => 'Contact Us - F24Tech Softwares',
    'blog' => 'Blog - F24Tech Softwares',
    'careers' => 'Careers - F24Tech Softwares',
    'privacy' => 'Privacy Policy - F24Tech Softwares',
    'terms' => 'Terms of Service - F24Tech Softwares'
];

$title = $page_titles[$current_page] ?? $title;

// For service detail pages, customize the title based on the service
if ($current_page === 'service-detail' && isset($_GET['service'])) {
    $service_titles = [
        'custom-software' => 'Custom Software Development - F24Tech Softwares',
        'mobile-app' => 'Mobile App Development - F24Tech Softwares',
        'cloud-solutions' => 'Cloud Solutions - F24Tech Softwares',
        'data-analytics' => 'Data Analytics - F24Tech Softwares',
        'cybersecurity' => 'Cybersecurity Services - F24Tech Softwares',
        'ui-ux-design' => 'UI/UX Design Services - F24Tech Softwares'
    ];
    $service_id = $_GET['service'];
    $title = $service_titles[$service_id] ?? 'Service Details - F24Tech Softwares';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link rel="icon" type="image/svg+xml" href="assets/photos/logo.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'pulse': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <?php
        switch($current_page) {
            case 'about':
                include 'pages/about.php';
                break;
            case 'services':
                include 'pages/services.php';
                break;
            case 'service-detail':
                include 'pages/service-detail.php';
                break;
            case 'portfolio':
                include 'pages/portfolio.php';
                break;
            case 'contact':
                include 'pages/contact.php';
                break;
            case 'blog':
                include 'pages/blog.php';
                break;
            case 'careers':
                include 'pages/careers.php';
                break;
            case 'privacy':
                include 'pages/privacy.php';
                break;
            case 'terms':
                include 'pages/terms.php';
                break;
            default:
                include 'pages/home.php';
                break;
        }
        ?>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/cookie-consent.php'; ?>
    <?php include 'includes/chatbot.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script src="assets/js/analytics.js"></script>
    
    <script>
        // Newsletter subscription function
        function subscribeNewsletter() {
            const email = document.getElementById('newsletter-email').value;
            if (!email) {
                alert('Please enter your email address');
                return;
            }
            
            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return;
            }
            
            // Here you would typically send the email to your backend
            // For now, we'll just show a success message
            alert('Thank you for subscribing to our newsletter!');
            document.getElementById('newsletter-email').value = '';
        }
        
        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Handle Enter key in newsletter input
        document.addEventListener('DOMContentLoaded', function() {
            const newsletterInput = document.getElementById('newsletter-email');
            if (newsletterInput) {
                newsletterInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        subscribeNewsletter();
                    }
                });
            }
        });
    </script>
</body>
</html>
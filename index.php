// Simple routing
$valid_pages = ['home', 'about', 'services', 'service-detail', 'portfolio', 'contact', 'blog', 'blog-post', 'careers', 'privacy', 'terms'];
if (!in_array($current_page, $valid_pages)) {
    $current_page = 'home';
}

$page_titles = [
    'home' => 'F24Tech Softwares - Web Development & Digital Solutions',
    'about' => 'About Us - F24Tech Softwares',
    'services' => 'Our Services - F24Tech Softwares',
    'service-detail' => 'Service Details - F24Tech Softwares',
    'portfolio' => 'Portfolio - F24Tech Softwares',
    'contact' => 'Contact Us - F24Tech Softwares',
    'blog' => 'Blog - F24Tech Softwares',
    'blog-post' => 'Blog Post - F24Tech Softwares',
    'careers' => 'Careers - F24Tech Softwares',
    'privacy' => 'Privacy Policy - F24Tech Softwares',
    'terms' => 'Terms of Service - F24Tech Softwares'
];

// Include the appropriate page
switch ($current_page) {
    case 'home':
        include 'pages/home.php';
        break;
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
    case 'blog-post':
        include 'pages/blog-post.php';
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

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/cookie-consent.php'; ?>
    <?php include 'includes/chatbot.php'; ?>
    <?php include 'includes/language-selector.php'; ?>
    <?php include 'includes/google-analytics.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script src="assets/js/analytics.js"></script>
<?php
$slug = $_GET['slug'] ?? '';

if (!$slug) {
    header('Location: ?page=blog');
    exit;
}

// Get blog post from database
include 'config/database.php';

try {
    $post = DB::findOne('blog_posts', ['slug' => $slug, 'status' => 'published']);
    
    if (!$post) {
        header('Location: ?page=blog');
        exit;
    }
    
    // Increment view count
    DB::update('blog_posts', ['views' => $post['views'] + 1], ['id' => $post['id']]);
    
    // Get related posts
    $related_posts = DB::query("
        SELECT * FROM blog_posts 
        WHERE status = 'published' 
        AND id != ? 
        AND (category = ? OR tags LIKE ?) 
        ORDER BY created_at DESC 
        LIMIT 3
    ", [$post['id'], $post['category'], '%' . $post['tags'] . '%'])->fetchAll();
    
    // Get comments
    $comments = DB::query("
        SELECT * FROM blog_comments 
        WHERE post_id = ? AND status = 'approved' 
        ORDER BY created_at DESC
    ", [$post['id']])->fetchAll();
    
} catch (Exception $e) {
    header('Location: ?page=blog');
    exit;
}

// Handle comment submission
if ($_POST && isset($_POST['submit_comment'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $comment = $_POST['comment'] ?? '';
    
    if ($name && $email && $comment) {
        try {
            DB::insert('blog_comments', [
                'post_id' => $post['id'],
                'name' => $name,
                'email' => $email,
                'comment' => $comment,
                'status' => 'pending'
            ]);
            
            // Send notification email
            $to = 'sales@f24tech.com';
            $subject = 'New Blog Comment: ' . $post['title'];
            $email_body = "
New comment on blog post: {$post['title']}

From: $name ($email)
Comment: $comment

Post URL: " . $_SERVER['HTTP_HOST'] . "/?page=blog-post&slug=" . $post['slug'] . "

Approve comment in admin panel.
";
            
            $headers = "From: F24Tech <noreply@f24tech.com>\r\n";
            mail($to, $subject, $email_body, $headers);
            
            $comment_success = true;
        } catch (Exception $e) {
            $comment_error = 'Error submitting comment.';
        }
    }
}

// Set page title and meta tags
$page_title = $post['meta_title'] ?: $post['title'];
$meta_description = $post['meta_description'] ?: $post['excerpt'];
$meta_keywords = $post['meta_keywords'];
?>

<!DOCTYPE html>
<html lang="<?php echo $post['language'] ?? 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - F24Tech</title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php if ($meta_keywords): ?>
        <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <?php endif; ?>
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php if ($post['featured_image']): ?>
        <meta property="og:image" content="<?php echo htmlspecialchars($post['featured_image']); ?>">
    <?php endif; ?>
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php if ($post['featured_image']): ?>
        <meta property="twitter:image" content="<?php echo htmlspecialchars($post['featured_image']); ?>">
    <?php endif; ?>
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    
    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": "<?php echo htmlspecialchars($post['title']); ?>",
        "description": "<?php echo htmlspecialchars($meta_description); ?>",
        "image": "<?php echo htmlspecialchars($post['featured_image'] ?? ''); ?>",
        "author": {
            "@type": "Person",
            "name": "<?php echo htmlspecialchars($post['author']); ?>"
        },
        "publisher": {
            "@type": "Organization",
            "name": "F24Tech",
            "logo": {
                "@type": "ImageObject",
                "url": "<?php echo $_SERVER['HTTP_HOST']; ?>/assets/photos/logo.svg"
            }
        },
        "datePublished": "<?php echo date('c', strtotime($post['created_at'])); ?>",
        "dateModified": "<?php echo date('c', strtotime($post['updated_at'])); ?>",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
        }
    }
    </script>
    
    <link rel="icon" type="image/svg+xml" href="assets/photos/logo.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'GA_MEASUREMENT_ID');
    </script>
</head>
<body>
    <?php 
    $current_page = 'blog';
    include 'includes/header.php'; 
    ?>
    
    <div class="pt-24">
        <!-- Article Header -->
        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="?page=home" class="hover:text-blue-600">Home</a></li>
                    <li>/</li>
                    <li><a href="?page=blog" class="hover:text-blue-600">Blog</a></li>
                    <li>/</li>
                    <li class="text-gray-900"><?php echo htmlspecialchars($post['title']); ?></li>
                </ol>
            </nav>
            
            <!-- Article Meta -->
            <div class="mb-8">
                <?php if ($post['category']): ?>
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mb-4">
                        <?php echo htmlspecialchars($post['category']); ?>
                    </span>
                <?php endif; ?>
                
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    <?php echo htmlspecialchars($post['title']); ?>
                </h1>
                
                <?php if ($post['excerpt']): ?>
                    <p class="text-xl text-gray-600 mb-6 leading-relaxed">
                        <?php echo htmlspecialchars($post['excerpt']); ?>
                    </p>
                <?php endif; ?>
                
                <div class="flex flex-wrap items-center gap-6 text-gray-500 text-sm">
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        By <?php echo htmlspecialchars($post['author']); ?>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?php echo $post['reading_time']; ?> min read
                    </div>
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <?php echo number_format($post['views']); ?> views
                    </div>
                </div>
            </div>
            
            <!-- Featured Image -->
            <?php if ($post['featured_image']): ?>
                <div class="mb-12">
                    <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" 
                         alt="<?php echo htmlspecialchars($post['title']); ?>"
                         class="w-full h-64 md:h-96 object-cover rounded-2xl shadow-lg">
                </div>
            <?php endif; ?>
            
            <!-- Article Content -->
            <div class="prose prose-lg max-w-none mb-12">
                <?php echo $post['content']; ?>
            </div>
            
            <!-- Tags -->
            <?php if ($post['tags']): ?>
                <div class="mb-12">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php 
                        $tags = explode(',', $post['tags']);
                        foreach ($tags as $tag): 
                            $tag = trim($tag);
                            if ($tag): ?>
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                    <?php echo htmlspecialchars($tag); ?>
                                </span>
                            <?php endif;
                        endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Share Buttons -->
            <div class="mb-12 border-t border-b py-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this article</h3>
                <div class="flex gap-4">
                    <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($post['title']); ?>&url=<?php echo urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                       target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                       target="_blank" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors">
                        Facebook
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                       target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        LinkedIn
                    </a>
                    <button onclick="copyToClipboard()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Copy Link
                    </button>
                </div>
            </div>
        </article>
        
        <!-- Comments Section -->
        <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t">
            <h3 class="text-2xl font-bold text-gray-900 mb-8">Comments (<?php echo count($comments); ?>)</h3>
            
            <!-- Comment Form -->
            <div class="bg-gray-50 rounded-2xl p-8 mb-12">
                <h4 class="text-lg font-semibold text-gray-900 mb-6">Leave a Comment</h4>
                
                <?php if (isset($comment_success)): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
                        Thank you for your comment! It will be published after review.
                    </div>
                <?php endif; ?>
                
                <?php if (isset($comment_error)): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                        <?php echo $comment_error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text" name="name" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Comment *</label>
                        <textarea name="comment" required rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                    </div>
                    <button type="submit" name="submit_comment" 
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Post Comment
                    </button>
                </form>
            </div>
            
            <!-- Comments List -->
            <?php if ($comments): ?>
                <div class="space-y-8">
                    <?php foreach ($comments as $comment): ?>
                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-blue-600 font-semibold">
                                        <?php echo strtoupper(substr($comment['name'], 0, 1)); ?>
                                    </span>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-900"><?php echo htmlspecialchars($comment['name']); ?></h5>
                                    <p class="text-sm text-gray-500"><?php echo date('F j, Y \a\t g:i A', strtotime($comment['created_at'])); ?></p>
                                </div>
                            </div>
                            <p class="text-gray-700 leading-relaxed"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">No comments yet. Be the first to comment!</p>
            <?php endif; ?>
        </section>
        
        <!-- Related Posts -->
        <?php if ($related_posts): ?>
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 border-t">
                <h3 class="text-3xl font-bold text-gray-900 text-center mb-12">Related Articles</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($related_posts as $related): ?>
                        <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                            <?php if ($related['featured_image']): ?>
                                <img src="<?php echo htmlspecialchars($related['featured_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($related['title']); ?>"
                                     class="w-full h-48 object-cover">
                            <?php endif; ?>
                            <div class="p-6">
                                <h4 class="text-lg font-bold text-gray-900 mb-3">
                                    <a href="?page=blog-post&slug=<?php echo urlencode($related['slug']); ?>" class="hover:text-blue-600 transition-colors">
                                        <?php echo htmlspecialchars($related['title']); ?>
                                    </a>
                                </h4>
                                <p class="text-gray-600 mb-4">
                                    <?php echo htmlspecialchars(substr($related['excerpt'] ?: strip_tags($related['content']), 0, 100)) . '...'; ?>
                                </p>
                                <div class="text-sm text-gray-500">
                                    <?php echo date('M j, Y', strtotime($related['created_at'])); ?> • <?php echo $related['reading_time']; ?> min read
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/cookie-consent.php'; ?>
    <?php include 'includes/chatbot.php'; ?>
    
    <script src="assets/js/main.js"></script>
    <script src="assets/js/analytics.js"></script>
    
    <script>
    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Link copied to clipboard!');
        });
    }
    
    // Track reading progress
    window.addEventListener('scroll', function() {
        const article = document.querySelector('article');
        const scrollTop = window.pageYOffset;
        const docHeight = document.body.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        
        if (scrollPercent > 50 && !window.readingTracked) {
            window.readingTracked = true;
            if (window.analytics) {
                window.analytics.trackInteraction('reading_progress', 'blog_post', '50_percent');
            }
        }
    });
    </script>
</body>
</html>
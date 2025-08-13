@@ .. @@
     <!-- Blog Posts Grid -->
     <section class="py-20 bg-gray-50">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
+            <!-- Filters -->
+            <div class="mb-8 flex flex-wrap gap-4 justify-center">
+                <button onclick="filterPosts('all')" class="filter-btn active bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition-colors" data-category="all">
+                    All Posts
+                </button>
+                <?php
+                include 'config/database.php';
+                $categories = DB::query("SELECT DISTINCT category FROM blog_posts WHERE status = 'published' AND category IS NOT NULL AND category != '' ORDER BY category")->fetchAll();
+                foreach ($categories as $cat): ?>
+                    <button onclick="filterPosts('<?php echo htmlspecialchars($cat['category']); ?>')" class="filter-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-300 transition-colors" data-category="<?php echo htmlspecialchars($cat['category']); ?>">
+                        <?php echo htmlspecialchars($cat['category']); ?>
+                    </button>
+                <?php endforeach; ?>
+            </div>
+
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                 <?php
-                $blogPosts = [
-                    [
-                        'title' => 'The Future of AI in Software Development',
-                        'excerpt' => 'Exploring how artificial intelligence is revolutionizing the way we build and deploy software applications.',
-                        'author' => 'John Smith',
-                        'date' => '2024-01-15',
-                        'readTime' => '5 min read',
-                        'category' => 'AI/ML',
-                        'image' => 'https://images.pexels.com/photos/3861969/pexels-photo-3861969.jpeg'
-                    ],
-                    [
-                        'title' => 'Cloud Migration Best Practices for 2024',
-                        'excerpt' => 'A comprehensive guide to successfully migrating your applications to the cloud with minimal downtime.',
-                        'author' => 'Sarah Johnson',
-                        'date' => '2024-01-10',
-                        'readTime' => '7 min read',
-                        'category' => 'Cloud',
-                        'image' => 'https://images.pexels.com/photos/1181675/pexels-photo-1181675.jpeg'
-                    ],
-                    [
-                        'title' => 'Cybersecurity Trends Every Business Should Know',
-                        'excerpt' => 'Stay ahead of cyber threats with these emerging security trends and best practices for 2024.',
-                        'author' => 'Mike Chen',
-                        'date' => '2024-01-05',
-                        'readTime' => '6 min read',
-                        'category' => 'Security',
-                        'image' => 'https://images.pexels.com/photos/60504/security-protection-anti-virus-software-60504.jpeg'
-                    ],
-                    [
-                        'title' => 'Mobile App Development: Native vs Cross-Platform',
-                        'excerpt' => 'Comparing the pros and cons of native and cross-platform mobile development approaches.',
-                        'author' => 'Emily Davis',
-                        'date' => '2024-01-01',
-                        'readTime' => '8 min read',
-                        'category' => 'Mobile',
-                        'image' => 'https://images.pexels.com/photos/607812/pexels-photo-607812.jpeg'
-                    ],
-                    [
-                        'title' => 'Data Analytics: Turning Information into Insights',
-                        'excerpt' => 'Learn how modern data analytics can transform your business decision-making process.',
-                        'author' => 'Robert Williams',
-                        'date' => '2023-12-28',
-                        'readTime' => '9 min read',
-                        'category' => 'Analytics',
-                        'image' => 'https://images.pexels.com/photos/590041/pexels-photo-590041.jpeg'
-                    ],
-                    [
-                        'title' => 'UI/UX Design Principles for Better User Experience',
-                        'excerpt' => 'Essential design principles that create engaging and intuitive user experiences.',
-                        'author' => 'Lisa Anderson',
-                        'date' => '2023-12-25',
-                        'readTime' => '4 min read',
-                        'category' => 'Design',
-                        'image' => 'https://images.pexels.com/photos/196644/pexels-photo-196644.jpeg'
-                    ]
-                ];
+                // Get published blog posts from database
+                try {
+                    $blogPosts = DB::query("
+                        SELECT * FROM blog_posts 
+                        WHERE status = 'published' 
+                        ORDER BY featured DESC, created_at DESC
+                    ")->fetchAll();
+                } catch (Exception $e) {
+                    $blogPosts = [];
+                }
 
-                foreach ($blogPosts as $post): ?>
-                    <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group">
+                if ($blogPosts):
+                    foreach ($blogPosts as $post): ?>
+                    <article class="blog-post bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group" data-category="<?php echo htmlspecialchars($post['category'] ?? ''); ?>">
                         <div class="relative overflow-hidden">
+                            <?php if ($post['featured']): ?>
+                                <div class="absolute top-4 left-4 z-10">
+                                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-medium">
+                                        Featured
+                                    </span>
+                                </div>
+                            <?php endif; ?>
+                            
+                            <?php if ($post['featured_image']): ?>
+                                <img 
+                                    src="<?php echo htmlspecialchars($post['featured_image']); ?>" 
+                                    alt="<?php echo htmlspecialchars($post['title']); ?>"
+                                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500"
+                                />
+                            <?php else: ?>
+                                <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
+                                    <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
+                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
+                                    </svg>
+                                </div>
+                            <?php endif; ?>
+                            
+                            <?php if ($post['category']): ?>
+                                <div class="absolute top-4 right-4">
+                                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">
+                                        <?php echo htmlspecialchars($post['category']); ?>
+                                    </span>
+                                </div>
+                            <?php endif; ?>
+                        </div>
+                        
+                        <div class="p-6">
+                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
+                                <a href="?page=blog-post&slug=<?php echo urlencode($post['slug']); ?>">
+                                    <?php echo htmlspecialchars($post['title']); ?>
+                                </a>
+                            </h3>
+                            
+                            <p class="text-gray-600 mb-4 leading-relaxed">
+                                <?php echo htmlspecialchars($post['excerpt'] ?: substr(strip_tags($post['content']), 0, 150) . '...'); ?>
+                            </p>
+                            
+                            <div class="flex items-center text-sm text-gray-500 mb-4">
+                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
+                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
+                                </svg>
+                                <span class="mr-3"><?php echo htmlspecialchars($post['author']); ?></span>
+                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
+                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
+                                </svg>
+                                <span class="mr-3"><?php echo date('M j, Y', strtotime($post['created_at'])); ?></span>
+                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
+                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
+                                </svg>
+                                <span><?php echo $post['reading_time']; ?> min read</span>
+                            </div>
+                            
+                            <a href="?page=blog-post&slug=<?php echo urlencode($post['slug']); ?>" class="flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors group">
+                                Read More
+                                <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
+                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
+                                </svg>
+                            </a>
+                        </div>
+                    </article>
+                <?php endforeach;
+                else: ?>
+                    <div class="col-span-full text-center py-12">
+                        <svg class="h-24 w-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
+                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
+                        </svg>
+                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No Blog Posts Yet</h3>
+                        <p class="text-gray-600">We're working on some amazing content. Check back soon!</p>
+                    </div>
+                <?php endif; ?>
+            </div>
+        </div>
+    </section>
+
+    <script>
+    function filterPosts(category) {
+        const posts = document.querySelectorAll('.blog-post');
+        const buttons = document.querySelectorAll('.filter-btn');
+        
+        // Update active button
+        buttons.forEach(btn => {
+            btn.classList.remove('active', 'bg-blue-600', 'text-white');
+            btn.classList.add('bg-gray-200', 'text-gray-700');
+            if (btn.dataset.category === category) {
+                btn.classList.remove('bg-gray-200', 'text-gray-700');
+                btn.classList.add('active', 'bg-blue-600', 'text-white');
+            }
+        });
+        
+        // Filter posts
+        posts.forEach(post => {
+            if (category === 'all' || post.dataset.category === category) {
+                post.style.display = 'block';
+                post.classList.add('animate-fade-in');
+            } else {
+                post.style.display = 'none';
+            }
+        });
+    }
+    </script>
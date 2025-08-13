@@ .. @@
             // Get stats
             $total_projects = DB::query("SELECT COUNT(*) as count FROM projects")->fetch()['count'] ?? 0;
             $total_contacts = DB::query("SELECT COUNT(*) as count FROM contact_submissions")->fetch()['count'] ?? 0;
+            $total_blog_posts = DB::query("SELECT COUNT(*) as count FROM blog_posts WHERE status = 'published'")->fetch()['count'] ?? 0;
             $total_newsletter = DB::query("SELECT COUNT(*) as count FROM newsletter_subscriptions WHERE status = 'active'")->fetch()['count'] ?? 0;
             $recent_views = DB::query("SELECT COUNT(*) as count FROM page_views WHERE view_time >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetch()['count'] ?? 0;
             ?>
@@ .. @@
             <div class="bg-white rounded-xl p-6 shadow-lg">
                 <div class="flex items-center justify-between">
                     <div>
-                        <p class="text-sm text-gray-600 mb-1">Newsletter Subscribers</p>
-                        <p class="text-3xl font-bold text-gray-900"><?php echo $total_newsletter; ?></p>
+                        <p class="text-sm text-gray-600 mb-1">Blog Posts</p>
+                        <p class="text-3xl font-bold text-gray-900"><?php echo $total_blog_posts; ?></p>
                     </div>
                     <div class="bg-purple-100 p-3 rounded-lg">
                         <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
-                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
+                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                         </svg>
                     </div>
                 </div>
             </div>

             <div class="bg-white rounded-xl p-6 shadow-lg">
                 <div class="flex items-center justify-between">
                     <div>
-                        <p class="text-sm text-gray-600 mb-1">Page Views (30d)</p>
-                        <p class="text-3xl font-bold text-gray-900"><?php echo $recent_views; ?></p>
+                        <p class="text-sm text-gray-600 mb-1">Newsletter Subscribers</p>
+                        <p class="text-3xl font-bold text-gray-900"><?php echo $total_newsletter; ?></p>
                     </div>
                     <div class="bg-orange-100 p-3 rounded-lg">
                         <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
-                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
-                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
+                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                         </svg>
                     </div>
                 </div>
@@ .. @@
                 </div>
             </a>

+            <a href="add-blog.php" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
+                <div class="bg-purple-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
+                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
+                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
+                    </svg>
+                </div>
+                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
+                    Add Blog Post
+                </h3>
+                <p class="text-gray-600 leading-relaxed">
+                    Create new blog posts with SEO optimization and trending keywords.
+                </p>
+            </a>
+
+            <a href="manage-blog.php" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
+                <div class="bg-indigo-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
+                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
+                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
+                    </svg>
+                </div>
+                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
+                    Manage Blog
+                </h3>
+                <p class="text-gray-600 leading-relaxed">
+                    View, edit, and manage all your blog posts and categories.
+                </p>
+            </a>
+
             <a href="analytics.php" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                 <div class="bg-purple-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                     <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
@@ .. @@
                 <!-- Recent Projects -->
                 <div class="bg-white rounded-xl p-6 shadow-lg">
                     <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Projects</h3>
                     <?php
                     $recent_projects = DB::query("SELECT * FROM projects ORDER BY updated_at DESC LIMIT 5")->fetchAll();
                     if ($recent_projects): ?>
                         <div class="space-y-4">
                             <?php foreach ($recent_projects as $project): ?>
                                 <div class="flex items-center justify-between">
                                     <div>
                                         <p class="font-medium text-gray-900"><?php echo htmlspecialchars($project['title']); ?></p>
                                         <p class="text-sm text-gray-600"><?php echo htmlspecialchars($project['client'] ?? 'No client'); ?></p>
                                     </div>
                                     <span class="px-2 py-1 text-xs rounded-full <?php echo $project['status'] === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                         <?php echo ucfirst($project['status'] ?? 'draft'); ?>
                                     </span>
                                 </div>
                             <?php endforeach; ?>
                         </div>
                     <?php else: ?>
                         <p class="text-gray-500">No projects yet.</p>
                     <?php endif; ?>
                 </div>
+                
+                <!-- Recent Blog Posts -->
+                <div class="bg-white rounded-xl p-6 shadow-lg">
+                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Blog Posts</h3>
+                    <?php
+                    $recent_posts = DB::query("SELECT * FROM blog_posts ORDER BY updated_at DESC LIMIT 5")->fetchAll();
+                    if ($recent_posts): ?>
+                        <div class="space-y-4">
+                            <?php foreach ($recent_posts as $post): ?>
+                                <div class="flex items-center justify-between">
+                                    <div>
+                                        <p class="font-medium text-gray-900"><?php echo htmlspecialchars($post['title']); ?></p>
+                                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($post['author']); ?> • <?php echo number_format($post['views']); ?> views</p>
+                                    </div>
+                                    <span class="px-2 py-1 text-xs rounded-full <?php echo $post['status'] === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
+                                        <?php echo ucfirst($post['status'] ?? 'draft'); ?>
+                                    </span>
+                                </div>
+                            <?php endforeach; ?>
+                        </div>
+                    <?php else: ?>
+                        <p class="text-gray-500">No blog posts yet.</p>
+                    <?php endif; ?>
+                </div>
             </div>
         </div>
     </div>
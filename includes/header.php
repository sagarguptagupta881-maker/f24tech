@@ .. @@
                 $nav_items = [
                     'home' => 'Home',
                     'about' => 'About',
                     'services' => 'Services',
                     'portfolio' => 'Portfolio',
+                    'blog' => 'Blog',
                     'contact' => 'Contact'
                 ];
                 
                 foreach ($nav_items as $page => $label):
                     $is_active = ($current_page === $page) || 
-                                ($current_page === 'service-detail' && $page === 'services');
+                                ($current_page === 'service-detail' && $page === 'services') ||
+                                ($current_page === 'blog-post' && $page === 'blog');
                     $active_class = $is_active ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600';
                 ?>
                     <a href="?page=<?php echo $page; ?>" 
                        class="nav-link text-sm font-medium transition-colors <?php echo $active_class; ?>">
                         <?php echo $label; ?>
                     </a>
                 <?php endforeach; ?>
@@ .. @@
             <?php foreach ($nav_items as $page => $label):
                 $is_active = ($current_page === $page) || 
-                            ($current_page === 'service-detail' && $page === 'services');
+                            ($current_page === 'service-detail' && $page === 'services') ||
+                            ($current_page === 'blog-post' && $page === 'blog');
                 $active_class = $is_active ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600';
             ?>
                 <a href="?page=<?php echo $page; ?>" 
                    class="block px-4 py-2 transition-colors <?php echo $active_class; ?>">
                     <?php echo $label; ?>
                 </a>
             <?php endforeach; ?>
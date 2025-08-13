<header id="header" class="fixed w-full top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <a href="?page=home" class="flex items-center space-x-2">
                <img src="assets/photos/logo.svg" alt="F24Tech Logo" class="h-10 w-auto">
                <span id="logo-text" class="text-xl font-bold">F24Tech</span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8">
                <?php
                $nav_items = [
                    'home' => 'Home',
                    'about' => 'About',
                    'services' => 'Services',
                    'portfolio' => 'Portfolio',
                    'contact' => 'Contact'
                ];
                
                foreach ($nav_items as $page => $label):
                    $is_active = ($current_page === $page) || 
                                ($current_page === 'service-detail' && $page === 'services');
                    $active_class = $is_active ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600';
                ?>
                    <a href="?page=<?php echo $page; ?>" 
                       class="nav-link text-sm font-medium transition-colors <?php echo $active_class; ?>">
                        <?php echo $label; ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <!-- Mobile menu button -->
            <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md">
                <svg id="menu-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="close-icon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="md:hidden bg-white rounded-lg shadow-lg mt-2 py-2 hidden">
            <?php foreach ($nav_items as $page => $label):
                $is_active = ($current_page === $page) || 
                            ($current_page === 'service-detail' && $page === 'services');
                $active_class = $is_active ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600';
            ?>
                <a href="?page=<?php echo $page; ?>" 
                   class="block px-4 py-2 transition-colors <?php echo $active_class; ?>">
                    <?php echo $label; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</header>
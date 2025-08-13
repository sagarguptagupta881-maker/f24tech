<div class="pt-24">
    <!-- Hero Section -->
    <section class="py-20" style="background: linear-gradient(135deg, #1e40af 0%, #10b981 100%)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Tech Insights Blog</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Stay updated with the latest trends, insights, and best practices in technology and software development.
            </p>
        </div>
    </section>

    <!-- Blog Posts Grid -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $blogPosts = [
                    [
                        'title' => 'The Future of AI in Software Development',
                        'excerpt' => 'Exploring how artificial intelligence is revolutionizing the way we build and deploy software applications.',
                        'author' => 'John Smith',
                        'date' => '2024-01-15',
                        'readTime' => '5 min read',
                        'category' => 'AI/ML',
                        'image' => 'https://images.pexels.com/photos/3861969/pexels-photo-3861969.jpeg'
                    ],
                    [
                        'title' => 'Cloud Migration Best Practices for 2024',
                        'excerpt' => 'A comprehensive guide to successfully migrating your applications to the cloud with minimal downtime.',
                        'author' => 'Sarah Johnson',
                        'date' => '2024-01-10',
                        'readTime' => '7 min read',
                        'category' => 'Cloud',
                        'image' => 'https://images.pexels.com/photos/1181675/pexels-photo-1181675.jpeg'
                    ],
                    [
                        'title' => 'Cybersecurity Trends Every Business Should Know',
                        'excerpt' => 'Stay ahead of cyber threats with these emerging security trends and best practices for 2024.',
                        'author' => 'Mike Chen',
                        'date' => '2024-01-05',
                        'readTime' => '6 min read',
                        'category' => 'Security',
                        'image' => 'https://images.pexels.com/photos/60504/security-protection-anti-virus-software-60504.jpeg'
                    ],
                    [
                        'title' => 'Mobile App Development: Native vs Cross-Platform',
                        'excerpt' => 'Comparing the pros and cons of native and cross-platform mobile development approaches.',
                        'author' => 'Emily Davis',
                        'date' => '2024-01-01',
                        'readTime' => '8 min read',
                        'category' => 'Mobile',
                        'image' => 'https://images.pexels.com/photos/607812/pexels-photo-607812.jpeg'
                    ],
                    [
                        'title' => 'Data Analytics: Turning Information into Insights',
                        'excerpt' => 'Learn how modern data analytics can transform your business decision-making process.',
                        'author' => 'Robert Williams',
                        'date' => '2023-12-28',
                        'readTime' => '9 min read',
                        'category' => 'Analytics',
                        'image' => 'https://images.pexels.com/photos/590041/pexels-photo-590041.jpeg'
                    ],
                    [
                        'title' => 'UI/UX Design Principles for Better User Experience',
                        'excerpt' => 'Essential design principles that create engaging and intuitive user experiences.',
                        'author' => 'Lisa Anderson',
                        'date' => '2023-12-25',
                        'readTime' => '4 min read',
                        'category' => 'Design',
                        'image' => 'https://images.pexels.com/photos/196644/pexels-photo-196644.jpeg'
                    ]
                ];

                foreach ($blogPosts as $post): ?>
                    <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <div class="relative overflow-hidden">
                            <img 
                                src="<?php echo $post['image']; ?>" 
                                alt="<?php echo $post['title']; ?>"
                                class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500"
                            />
                            <div class="absolute top-4 left-4">
                                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <?php echo $post['category']; ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                                <?php echo $post['title']; ?>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                <?php echo $post['excerpt']; ?>
                            </p>
                            
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="mr-3"><?php echo $post['author']; ?></span>
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="mr-3"><?php echo date('M j, Y', strtotime($post['date'])); ?></span>
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span><?php echo $post['readTime']; ?></span>
                            </div>
                            
                            <a href="?page=contact" class="flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors group">
                                Read More
                                <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="rounded-2xl p-12 text-white" style="background: linear-gradient(to right, #2563eb, #16a34a)">
                <h3 class="text-3xl font-bold mb-4">Stay Updated</h3>
                <p class="text-xl mb-8 opacity-90">
                    Subscribe to our newsletter for the latest tech insights and company updates.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-md mx-auto">
                    <input
                        type="email"
                        id="blog-newsletter-email"
                        placeholder="Enter your email"
                        class="flex-1 px-4 py-3 rounded-lg text-gray-900 placeholder-gray-500"
                    />
                    <button 
                        onclick="subscribeNewsletter('blog-newsletter-email')"
                        class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors whitespace-nowrap"
                    >
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="pt-24">
    <!-- Hero Section -->
    <section class="py-20" style="background: linear-gradient(135deg, #1e40af 0%, #10b981 100%)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Our Services</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Comprehensive technology solutions designed to accelerate your business growth and digital transformation.
            </p>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $services = [
                    [
                        'slug' => 'custom-software',
                        'title' => 'Custom Software Development',
                        'description' => 'Tailored software solutions built to meet your specific business requirements and goals.',
                        'features' => ['Full-stack development', 'API integration', 'Legacy system modernization', 'Scalable architecture'],
                        'price' => 'Starting from $15,000',
                        'duration' => '3-6 months',
                        'color' => 'blue',
                        'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'
                    ],
                    [
                        'slug' => 'mobile-app',
                        'title' => 'Mobile App Development',
                        'description' => 'Native and cross-platform mobile applications for iOS and Android platforms.',
                        'features' => ['React Native', 'Flutter development', 'Native iOS/Android', 'App store optimization'],
                        'price' => 'Starting from $20,000',
                        'duration' => '4-8 months',
                        'color' => 'green',
                        'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'
                    ],
                    [
                        'slug' => 'cloud-solutions',
                        'title' => 'Cloud Solutions',
                        'description' => 'Comprehensive cloud services including migration, deployment, and management.',
                        'features' => ['AWS/Azure/GCP', 'DevOps automation', 'Microservices', 'Container orchestration'],
                        'price' => 'Starting from $10,000',
                        'duration' => '2-4 months',
                        'color' => 'purple',
                        'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z'
                    ],
                    [
                        'slug' => 'data-analytics',
                        'title' => 'Data Analytics',
                        'description' => 'Transform your data into actionable insights with advanced analytics solutions.',
                        'features' => ['Business intelligence', 'Real-time analytics', 'Machine learning', 'Data visualization'],
                        'price' => 'Starting from $12,000',
                        'duration' => '3-5 months',
                        'color' => 'orange',
                        'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4'
                    ],
                    [
                        'slug' => 'cybersecurity',
                        'title' => 'Cybersecurity',
                        'description' => 'Comprehensive security solutions to protect your digital assets and data.',
                        'features' => ['Security audits', 'Penetration testing', 'Compliance consulting', 'Incident response'],
                        'price' => 'Starting from $8,000',
                        'duration' => '1-3 months',
                        'color' => 'red',
                        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                    ],
                    [
                        'slug' => 'ui-ux-design',
                        'title' => 'UI/UX Design',
                        'description' => 'User-centered design that creates engaging and intuitive digital experiences.',
                        'features' => ['User research', 'Wireframing', 'Prototyping', 'Design systems'],
                        'price' => 'Starting from $5,000',
                        'duration' => '2-4 months',
                        'color' => 'pink',
                        'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4 4 4 0 004-4V5z'
                    ]
                ];

                $colorClasses = [
                    'blue' => 'bg-blue-100 text-blue-600',
                    'green' => 'bg-green-100 text-green-600',
                    'purple' => 'bg-purple-100 text-purple-600',
                    'orange' => 'bg-orange-100 text-orange-600',
                    'red' => 'bg-red-100 text-red-600',
                    'pink' => 'bg-pink-100 text-pink-600'
                ];

                foreach ($services as $service): ?>
                    <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 group">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6 <?php echo $colorClasses[$service['color']]; ?>">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $service['icon']; ?>"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
                            <a href="?page=service-detail&service=<?php echo $service['slug']; ?>" class="block">
                                <?php echo $service['title']; ?>
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            <?php echo $service['description']; ?>
                        </p>
                        
                        <ul class="space-y-3 mb-6">
                            <?php foreach ($service['features'] as $feature): ?>
                                <li class="flex items-center text-gray-600">
                                    <svg class="h-4 w-4 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <?php echo $feature; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="border-t pt-6 mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-500">Starting Price</span>
                                <span class="font-semibold text-gray-900"><?php echo $service['price']; ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Timeline</span>
                                <span class="font-semibold text-gray-900"><?php echo $service['duration']; ?></span>
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="?page=service-detail&service=<?php echo $service['slug']; ?>" class="flex items-center justify-center flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors group">
                                View Details
                                <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <a href="?page=contact" class="flex items-center justify-center px-4 py-3 border border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                                Quote
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="rounded-2xl p-12 text-white" style="background: linear-gradient(to right, #2563eb, #16a34a)">
                <h3 class="text-3xl font-bold mb-4">Ready to Transform Your Business?</h3>
                <p class="text-xl mb-8 opacity-90">
                    Let's discuss your project and create a custom solution that drives results.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="?page=contact" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-blue-50 transition-colors">
                        Get Free Consultation
                    </a>
                    <a href="mailto:sales@f24tech.com" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                        Email Us Directly
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
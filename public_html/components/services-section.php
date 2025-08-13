<section id="services" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Our Services
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                We offer comprehensive technology solutions to help your business thrive in the digital age.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $services = [
                [
                    'title' => 'Custom Software Development',
                    'description' => 'Tailored software solutions built to meet your specific business requirements and goals.',
                    'features' => ['Full-stack development', 'API integration', 'Legacy system modernization', 'Scalable architecture'],
                    'color' => 'blue',
                    'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'
                ],
                [
                    'title' => 'Mobile App Development',
                    'description' => 'Native and cross-platform mobile applications for iOS and Android platforms.',
                    'features' => ['React Native', 'Flutter development', 'Native iOS/Android', 'App store optimization'],
                    'color' => 'green',
                    'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'
                ],
                [
                    'title' => 'Cloud Solutions',
                    'description' => 'Comprehensive cloud services including migration, deployment, and management.',
                    'features' => ['AWS/Azure/GCP', 'DevOps automation', 'Microservices', 'Container orchestration'],
                    'color' => 'purple',
                    'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z'
                ],
                [
                    'title' => 'Data Analytics',
                    'description' => 'Transform your data into actionable insights with advanced analytics solutions.',
                    'features' => ['Business intelligence', 'Real-time analytics', 'Machine learning', 'Data visualization'],
                    'color' => 'orange',
                    'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4'
                ],
                [
                    'title' => 'Cybersecurity',
                    'description' => 'Comprehensive security solutions to protect your digital assets and data.',
                    'features' => ['Security audits', 'Penetration testing', 'Compliance consulting', 'Incident response'],
                    'color' => 'red',
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                ],
                [
                    'title' => 'UI/UX Design',
                    'description' => 'User-centered design that creates engaging and intuitive digital experiences.',
                    'features' => ['User research', 'Wireframing', 'Prototyping', 'Design systems'],
                    'color' => 'pink',
                    'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4 4 4 0 004-4V5z'
                ]
            ];

            $colorClasses = [
                'blue' => 'bg-blue-100 text-blue-600 border-blue-200',
                'green' => 'bg-green-100 text-green-600 border-green-200',
                'purple' => 'bg-purple-100 text-purple-600 border-purple-200',
                'orange' => 'bg-orange-100 text-orange-600 border-orange-200',
                'red' => 'bg-red-100 text-red-600 border-red-200',
                'pink' => 'bg-pink-100 text-pink-600 border-pink-200'
            ];

            foreach ($services as $index => $service): ?>
                <div class="bg-white border border-gray-200 rounded-2xl p-8 card-hover group">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6 <?php echo $colorClasses[$service['color']]; ?>">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $service['icon']; ?>"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
                        <?php echo $service['title']; ?>
                    </h3>
                    
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        <?php echo $service['description']; ?>
                    </p>
                    
                    <ul class="space-y-3 mb-8">
                        <?php foreach ($service['features'] as $feature): ?>
                            <li class="flex items-center text-gray-600">
                                <svg class="h-4 w-4 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <?php echo $feature; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <a href="?page=contact" class="flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors group">
                        Learn More
                        <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-16 text-center">
            <div class="rounded-2xl p-8 text-white" style="background: linear-gradient(to right, #2563eb, #16a34a)">
                <h3 class="text-3xl font-bold mb-4">Ready to Start Your Project?</h3>
                <p class="text-xl mb-8 opacity-90">
                    Let's discuss how we can help transform your business with technology.
                </p>
                <a href="?page=contact" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-blue-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Get Free Consultation
                </a>
            </div>
        </div>
    </div>
</section>
<div class="pt-24">
    <!-- Hero Section -->
    <section class="py-20" style="background: linear-gradient(135deg, #1e40af 0%, #10b981 100%)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Join Our Team</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto mb-8">
                Build the future of technology with us. We're looking for passionate individuals who want to make a difference.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#open-positions" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-blue-50 transition-colors">
                    View Open Positions
                </a>
                <a href="mailto:careers@f24tech.com" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    Send Your Resume
                </a>
            </div>
        </div>
    </section>

    <!-- Why Work With Us -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Why Work at F24Tech?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We're more than just a workplace – we're a community of innovators, creators, and problem-solvers.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $benefits = [
                    [
                        'title' => 'Health & Wellness',
                        'description' => 'Comprehensive health insurance, dental, vision, and wellness programs',
                        'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
                    ],
                    [
                        'title' => 'Work-Life Balance',
                        'description' => 'Flexible hours, remote work options, and unlimited PTO policy',
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'title' => 'Growth & Learning',
                        'description' => 'Professional development budget, conference attendance, and skill training',
                        'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'
                    ],
                    [
                        'title' => 'Competitive Package',
                        'description' => 'Competitive salary, equity options, and performance bonuses',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'title' => 'Great Culture',
                        'description' => 'Collaborative environment, team events, and inclusive workplace',
                        'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z'
                    ],
                    [
                        'title' => 'Financial Benefits',
                        'description' => '401(k) matching, stock options, and financial planning assistance',
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ]
                ];

                foreach ($benefits as $benefit): ?>
                    <div class="text-center p-6 bg-gray-50 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $benefit['icon']; ?>"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3"><?php echo $benefit['title']; ?></h3>
                        <p class="text-gray-600"><?php echo $benefit['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Open Positions -->
    <section id="open-positions" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Open Positions</h2>
                <p class="text-xl text-gray-600">
                    Find your next career opportunity with us. We're always looking for talented individuals.
                </p>
            </div>

            <div class="space-y-6">
                <?php
                $openPositions = [
                    [
                        'title' => 'Senior Full Stack Developer',
                        'department' => 'Engineering',
                        'location' => 'San Francisco, CA / Remote',
                        'type' => 'Full-time',
                        'salary' => '$120,000 - $160,000',
                        'description' => 'Join our engineering team to build scalable web applications using modern technologies.',
                        'requirements' => ['5+ years of experience', 'React/Node.js expertise', 'Cloud platforms knowledge']
                    ],
                    [
                        'title' => 'Mobile App Developer',
                        'department' => 'Engineering',
                        'location' => 'Remote',
                        'type' => 'Full-time',
                        'salary' => '$100,000 - $140,000',
                        'description' => 'Develop cutting-edge mobile applications for iOS and Android platforms.',
                        'requirements' => ['React Native/Flutter experience', 'Mobile UI/UX understanding', '3+ years experience']
                    ],
                    [
                        'title' => 'UI/UX Designer',
                        'department' => 'Design',
                        'location' => 'Los Angeles, CA / Remote',
                        'type' => 'Full-time',
                        'salary' => '$80,000 - $120,000',
                        'description' => 'Create beautiful and intuitive user experiences for our client projects.',
                        'requirements' => ['Figma/Sketch proficiency', 'User research experience', 'Portfolio required']
                    ]
                ];

                foreach ($openPositions as $position): ?>
                    <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-4 mb-3">
                                    <h3 class="text-2xl font-bold text-gray-900"><?php echo $position['title']; ?></h3>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                        <?php echo $position['department']; ?>
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 mb-4"><?php echo $position['description']; ?></p>
                                
                                <div class="flex flex-wrap gap-6 text-sm text-gray-500 mb-4">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        <?php echo $position['location']; ?>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <?php echo $position['type']; ?>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <?php echo $position['salary']; ?>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($position['requirements'] as $req): ?>
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                            <?php echo $req; ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <div class="mt-6 lg:mt-0 lg:ml-6">
                                <a href="mailto:careers@f24tech.com?subject=Application for <?php echo urlencode($position['title']); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center group">
                                    Apply Now
                                    <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                            <p class="text-blue-600 font-medium mb-1">Mon - Fri: 9am - 6pm IST</p>
                            </div>
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
                <h3 class="text-3xl font-bold mb-4">Don't See the Right Position?</h3>
                <p class="text-xl mb-8 opacity-90">
                    We're always interested in meeting talented individuals. Send us your resume and let's talk!
                </p>
                <a href="mailto:careers@f24tech.com?subject=General Application" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-blue-50 transition-colors">
                    Send Your Resume
                </a>
            </div>
        </div>
    </section>
</div>
<?php
$serviceId = $_GET['service'] ?? '';

$serviceDetails = [
    'custom-software' => [
        'title' => 'Custom Software Development',
        'description' => 'Transform your business with tailored software solutions designed specifically for your unique requirements.',
        'longDescription' => 'Our custom software development services help businesses create powerful, scalable applications that drive growth and efficiency. We work closely with you to understand your specific needs and deliver solutions that perfectly align with your business objectives.',
        'features' => [
            'Full-stack web application development',
            'Enterprise software solutions',
            'API development and integration',
            'Legacy system modernization',
            'Database design and optimization',
            'Third-party integrations',
            'Performance optimization',
            'Ongoing maintenance and support'
        ],
        'technologies' => ['React', 'Node.js', 'Python', 'Java', 'PostgreSQL', 'MongoDB', 'AWS', 'Docker'],
        'process' => [
            ['step' => 'Discovery', 'description' => 'Understanding your requirements and business goals'],
            ['step' => 'Planning', 'description' => 'Creating detailed project roadmap and architecture'],
            ['step' => 'Development', 'description' => 'Building your solution with regular updates'],
            ['step' => 'Testing', 'description' => 'Comprehensive testing and quality assurance'],
            ['step' => 'Deployment', 'description' => 'Launching your application to production'],
            ['step' => 'Support', 'description' => 'Ongoing maintenance and feature updates']
        ],
        'pricing' => 'Starting from $15,000',
        'timeline' => '3-6 months',
        'image' => 'https://images.pexels.com/photos/574071/pexels-photo-574071.jpeg'
    ],
    'mobile-app' => [
        'title' => 'Mobile App Development',
        'description' => 'Create engaging mobile experiences that connect with your users on iOS and Android platforms.',
        'longDescription' => 'Our mobile app development team specializes in creating high-performance, user-friendly applications that work seamlessly across all devices. Whether you need a native app or cross-platform solution, we deliver exceptional mobile experiences.',
        'features' => [
            'Native iOS and Android development',
            'Cross-platform development with React Native',
            'Flutter app development',
            'UI/UX design for mobile',
            'App store optimization',
            'Push notifications',
            'Offline functionality',
            'App analytics and monitoring'
        ],
        'technologies' => ['React Native', 'Flutter', 'Swift', 'Kotlin', 'Firebase', 'Redux', 'GraphQL', 'REST APIs'],
        'process' => [
            ['step' => 'Strategy', 'description' => 'Defining app concept and target audience'],
            ['step' => 'Design', 'description' => 'Creating wireframes and visual designs'],
            ['step' => 'Development', 'description' => 'Building the app with regular testing'],
            ['step' => 'Testing', 'description' => 'Device testing and performance optimization'],
            ['step' => 'Launch', 'description' => 'App store submission and launch'],
            ['step' => 'Growth', 'description' => 'Analytics, updates, and feature additions']
        ],
        'pricing' => 'Starting from $20,000',
        'timeline' => '4-8 months',
        'image' => 'https://images.pexels.com/photos/607812/pexels-photo-607812.jpeg'
    ],
    'cloud-solutions' => [
        'title' => 'Cloud Solutions',
        'description' => 'Leverage the power of cloud computing to scale your business and reduce infrastructure costs.',
        'longDescription' => 'Our cloud solutions help businesses migrate to the cloud, optimize their infrastructure, and implement modern DevOps practices. We work with all major cloud providers to deliver scalable, secure, and cost-effective solutions.',
        'features' => [
            'Cloud migration and strategy',
            'AWS, Azure, and GCP services',
            'DevOps and CI/CD implementation',
            'Microservices architecture',
            'Container orchestration with Kubernetes',
            'Serverless computing',
            'Cloud security and compliance',
            'Cost optimization'
        ],
        'technologies' => ['AWS', 'Azure', 'Google Cloud', 'Docker', 'Kubernetes', 'Terraform', 'Jenkins', 'GitLab CI'],
        'process' => [
            ['step' => 'Assessment', 'description' => 'Evaluating current infrastructure and needs'],
            ['step' => 'Strategy', 'description' => 'Developing cloud migration roadmap'],
            ['step' => 'Migration', 'description' => 'Moving applications and data to cloud'],
            ['step' => 'Optimization', 'description' => 'Fine-tuning performance and costs'],
            ['step' => 'Monitoring', 'description' => 'Setting up monitoring and alerts'],
            ['step' => 'Support', 'description' => 'Ongoing management and optimization']
        ],
        'pricing' => 'Starting from $10,000',
        'timeline' => '2-4 months',
        'image' => 'https://images.pexels.com/photos/1181675/pexels-photo-1181675.jpeg'
    ],
    'data-analytics' => [
        'title' => 'Data Analytics',
        'description' => 'Turn your data into actionable insights with advanced analytics and business intelligence solutions.',
        'longDescription' => 'Our data analytics services help businesses make data-driven decisions by implementing comprehensive analytics solutions, from data collection and processing to visualization and machine learning.',
        'features' => [
            'Business intelligence dashboards',
            'Real-time analytics',
            'Machine learning models',
            'Data visualization',
            'ETL pipeline development',
            'Data warehouse design',
            'Predictive analytics',
            'Custom reporting solutions'
        ],
        'technologies' => ['Python', 'R', 'Tableau', 'Power BI', 'Apache Spark', 'TensorFlow', 'Snowflake', 'BigQuery'],
        'process' => [
            ['step' => 'Data Audit', 'description' => 'Assessing current data sources and quality'],
            ['step' => 'Architecture', 'description' => 'Designing data pipeline and warehouse'],
            ['step' => 'Implementation', 'description' => 'Building ETL processes and analytics'],
            ['step' => 'Visualization', 'description' => 'Creating dashboards and reports'],
            ['step' => 'Training', 'description' => 'Training your team on new tools'],
            ['step' => 'Optimization', 'description' => 'Continuous improvement and updates']
        ],
        'pricing' => 'Starting from $12,000',
        'timeline' => '3-5 months',
        'image' => 'https://images.pexels.com/photos/590041/pexels-photo-590041.jpeg'
    ],
    'cybersecurity' => [
        'title' => 'Cybersecurity',
        'description' => 'Protect your business with comprehensive security solutions and expert consulting.',
        'longDescription' => 'Our cybersecurity experts help businesses protect their digital assets through comprehensive security assessments, implementation of security measures, and ongoing monitoring and support.',
        'features' => [
            'Security audits and assessments',
            'Penetration testing',
            'Compliance consulting (GDPR, HIPAA, SOC2)',
            'Incident response planning',
            'Security awareness training',
            'Network security implementation',
            'Identity and access management',
            '24/7 security monitoring'
        ],
        'technologies' => ['SIEM Tools', 'Firewalls', 'VPN', 'Multi-factor Authentication', 'Encryption', 'Vulnerability Scanners'],
        'process' => [
            ['step' => 'Assessment', 'description' => 'Comprehensive security audit'],
            ['step' => 'Planning', 'description' => 'Developing security strategy and policies'],
            ['step' => 'Implementation', 'description' => 'Deploying security measures'],
            ['step' => 'Testing', 'description' => 'Penetration testing and validation'],
            ['step' => 'Training', 'description' => 'Security awareness training for staff'],
            ['step' => 'Monitoring', 'description' => 'Ongoing security monitoring and updates']
        ],
        'pricing' => 'Starting from $8,000',
        'timeline' => '1-3 months',
        'image' => 'https://images.pexels.com/photos/60504/security-protection-anti-virus-software-60504.jpeg'
    ],
    'ui-ux-design' => [
        'title' => 'UI/UX Design',
        'description' => 'Create exceptional user experiences with our comprehensive design services.',
        'longDescription' => 'Our design team creates intuitive, engaging user experiences that drive conversions and user satisfaction. We combine user research, modern design principles, and usability testing to deliver outstanding digital experiences.',
        'features' => [
            'User experience research',
            'Wireframing and prototyping',
            'Visual design and branding',
            'Design system development',
            'Usability testing',
            'Responsive design',
            'Accessibility compliance',
            'Design handoff and support'
        ],
        'technologies' => ['Figma', 'Adobe Creative Suite', 'Sketch', 'InVision', 'Principle', 'Zeplin', 'Miro', 'Hotjar'],
        'process' => [
            ['step' => 'Research', 'description' => 'Understanding users and business goals'],
            ['step' => 'Strategy', 'description' => 'Defining design strategy and approach'],
            ['step' => 'Wireframing', 'description' => 'Creating low-fidelity wireframes'],
            ['step' => 'Design', 'description' => 'Developing high-fidelity designs'],
            ['step' => 'Testing', 'description' => 'User testing and iteration'],
            ['step' => 'Handoff', 'description' => 'Design system and developer handoff']
        ],
        'pricing' => 'Starting from $5,000',
        'timeline' => '2-4 months',
        'image' => 'https://images.pexels.com/photos/196644/pexels-photo-196644.jpeg'
    ]
];

$service = $serviceDetails[$serviceId] ?? null;

if (!$service): ?>
    <div class="pt-24 py-20 text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Service Not Found</h1>
        <a href="?page=services" class="text-blue-600 hover:text-blue-700">
            ← Back to Services
        </a>
    </div>
<?php else: ?>
    <div class="pt-24">
        <!-- Hero Section -->
        <section class="py-20" style="background: linear-gradient(135deg, #1e40af 0%, #10b981 100%)">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <a href="?page=services" class="inline-flex items-center text-white/80 hover:text-white mb-8">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Services
                </a>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-bold text-white mb-6"><?php echo $service['title']; ?></h1>
                        <p class="text-xl text-white/90 mb-8"><?php echo $service['description']; ?></p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="mailto:sales@f24tech.com?subject=Inquiry about <?php echo urlencode($service['title']); ?>" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-blue-50 transition-colors text-center">
                                Get Quote
                            </a>
                            <a href="?page=contact" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-colors text-center">
                                Schedule Consultation
                            </a>
                        </div>
                    </div>
                    <div>
                        <img src="<?php echo $service['image']; ?>" alt="<?php echo $service['title']; ?>" class="w-full rounded-2xl shadow-2xl">
                    </div>
                </div>
            </div>
        </section>

        <!-- Service Details -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <div class="lg:col-span-2">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Service Overview</h2>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed"><?php echo $service['longDescription']; ?></p>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">What's Included</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
                            <?php foreach ($service['features'] as $feature): ?>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700"><?php echo $feature; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Our Process</h3>
                        <div class="space-y-6">
                            <?php foreach ($service['process'] as $index => $step): ?>
                                <div class="flex items-start">
                                    <div class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold mr-4 flex-shrink-0">
                                        <?php echo $index + 1; ?>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2"><?php echo $step['step']; ?></h4>
                                        <p class="text-gray-600"><?php echo $step['description']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div>
                        <div class="bg-gray-50 rounded-2xl p-8 sticky top-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Project Details</h3>
                            
                            <div class="space-y-6 mb-8">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold text-gray-900">Starting Price</div>
                                        <div class="text-gray-600"><?php echo $service['pricing']; ?></div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold text-gray-900">Timeline</div>
                                        <div class="text-gray-600"><?php echo $service['timeline']; ?></div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold text-gray-900">Team Size</div>
                                        <div class="text-gray-600">3-8 experts</div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="font-semibold text-gray-900 mb-4">Technologies We Use</h4>
                            <div class="flex flex-wrap gap-2 mb-8">
                                <?php foreach ($service['technologies'] as $tech): ?>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm"><?php echo $tech; ?></span>
                                <?php endforeach; ?>
                            </div>

                            <a href="mailto:sales@f24tech.com?subject=Inquiry about <?php echo urlencode($service['title']); ?>&body=Hi, I'm interested in learning more about your <?php echo urlencode($service['title']); ?> services. Please provide more information about pricing and timeline for my project." class="w-full bg-blue-600 text-white py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors text-center block">
                                Request Quote
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php endif; ?>
<div class="pt-24">
    <!-- Hero Section -->
    <section class="py-20" style="background: linear-gradient(135deg, #1e40af 0%, #10b981 100%)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">About F24Tech</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                We're a passionate team of innovators, developers, and designers committed to transforming businesses through cutting-edge technology solutions.
            </p>
        </div>
    </section>

    <!-- Company Story -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        Founded in 2014, F24Tech began as a small startup with a big vision: to help businesses leverage technology for growth and innovation. What started as a two-person team has grown into a thriving company of 50+ professionals.
                    </p>
                    <p class="text-lg text-gray-600 mb-6">
                        Over the years, we've evolved from a local software development company to a global technology partner, serving clients across various industries and helping them navigate digital transformation.
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">10+</div>
                            <div class="text-gray-600">Years Experience</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">500+</div>
                            <div class="text-gray-600">Projects Delivered</div>
                        </div>
                    </div>
                </div>
                <div>
                    <img 
                        src="https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg" 
                        alt="Team collaboration" 
                        class="w-full rounded-2xl shadow-xl"
                    />
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-gray-900 text-center mb-16">Our Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $values = [
                    [
                        'title' => 'Mission-Driven',
                        'description' => 'Every project serves a purpose and drives meaningful impact',
                        'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'
                    ],
                    [
                        'title' => 'Visionary',
                        'description' => 'We see beyond today to build solutions for tomorrow',
                        'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'
                    ],
                    [
                        'title' => 'Excellence',
                        'description' => 'Quality is not negotiable in everything we deliver',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'title' => 'Innovation',
                        'description' => 'We embrace new technologies and creative solutions',
                        'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'
                    ]
                ];

                foreach ($values as $value): ?>
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $value['icon']; ?>"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4"><?php echo $value['title']; ?></h3>
                        <p class="text-gray-600"><?php echo $value['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>
<section id="about" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                About F24Tech
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Founded with a passion for technology and innovation, F24Tech has been at the forefront 
                of digital transformation, helping businesses leverage the power of modern software solutions.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-20">
            <div>
                <h3 class="text-3xl font-bold text-gray-900 mb-6">
                    Transforming Ideas into Reality
                </h3>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    With over a decade of experience in software development, we specialize in creating 
                    custom solutions that address unique business challenges. Our team of expert developers, 
                    designers, and consultants work collaboratively to deliver exceptional results.
                </p>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    From enterprise applications to mobile solutions, we leverage cutting-edge technologies 
                    to build scalable, secure, and user-friendly software that drives business success.
                </p>
                <div class="flex flex-wrap gap-4">
                    <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                        10+ Years Experience
                    </span>
                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">
                        Agile Development
                    </span>
                    <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-medium">
                        24/7 Support
                    </span>
                </div>
            </div>
            
            <div class="bg-white p-8 rounded-2xl shadow-xl">
                <img 
                    src="https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg" 
                    alt="Team collaboration" 
                    class="w-full h-64 object-cover rounded-xl mb-6"
                />
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <h4 class="text-2xl font-bold text-blue-600">50+</h4>
                        <p class="text-gray-600">Team Members</p>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-green-600">15+</h4>
                        <p class="text-gray-600">Technologies</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $values = [
                [
                    'title' => 'Mission',
                    'description' => 'To deliver innovative software solutions that drive business growth and digital transformation.',
                    'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'
                ],
                [
                    'title' => 'Vision',
                    'description' => 'To be the leading technology partner for businesses seeking cutting-edge digital solutions.',
                    'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'
                ],
                [
                    'title' => 'Excellence',
                    'description' => 'We maintain the highest standards of quality in every project we undertake.',
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                ],
                [
                    'title' => 'Innovation',
                    'description' => 'We embrace emerging technologies to create solutions that push boundaries.',
                    'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'
                ]
            ];

            foreach ($values as $value): ?>
                <div class="bg-white p-6 rounded-xl shadow-lg card-hover text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $value['icon']; ?>"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 mb-3"><?php echo $value['title']; ?></h4>
                    <p class="text-gray-600 leading-relaxed"><?php echo $value['description']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
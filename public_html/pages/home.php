<!-- Hero Section -->
<section id="home" class="min-h-screen flex items-center relative overflow-hidden pt-24 sm:pt-28 md:pt-32" style="background: linear-gradient(135deg, #1e40af 0%, #10b981 100%)">
    <div class="absolute inset-0 bg-black/20"></div>

    <!-- Animated background elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full blur-xl animate-pulse" style="animation-delay: 0s;"></div>
        <div class="absolute bottom-40 right-32 w-48 h-48 bg-white/5 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-white/10 rounded-full blur-lg animate-pulse" style="animation-delay: 0.5s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight mt-12 sm:mt-16">
                Innovating the
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-400">
                    Digital Future
                </span>
            </h1>

            <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed">
                F24Tech delivers cutting-edge software solutions that transform businesses
                and accelerate digital growth with innovative technology.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12 sm:mb-16">
                <a href="?page=contact" class="bg-white text-blue-700 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold hover:bg-blue-50 transition-all duration-300 flex items-center justify-center group shadow-lg hover:shadow-xl">
                    Get Started
                    <svg class="ml-2 h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a href="?page=about" class="border-2 border-white text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold hover:bg-white hover:text-blue-700 transition-all duration-300 text-center">
                    Learn More
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto px-4">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-white/20 p-4 rounded-full mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-white">500+</h3>
                    <p class="text-white/80">Projects Delivered</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="bg-white/20 p-4 rounded-full mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-white">200+</h3>
                    <p class="text-white/80">Happy Clients</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="bg-white/20 p-4 rounded-full mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-white">99.9%</h3>
                    <p class="text-white/80">Uptime Guarantee</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<?php include 'components/about-section.php'; ?>

<!-- Services Section -->
<?php include 'components/services-section.php'; ?>

<!-- Portfolio Section -->
<?php include 'components/portfolio-section.php'; ?>

<!-- Contact Section -->
<?php include 'components/contact-section.php'; ?>
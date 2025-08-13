<div class="pt-24">
    <!-- Hero Section -->
    <section class="py-20" style="background: linear-gradient(135deg, #1e40af 0%, #10b981 100%)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Contact Us</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Ready to start your next project? We'd love to hear from you. Get in touch and let's create something amazing together.
            </p>
        </div>
    </section>

    <!-- Contact Form and Info -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Contact Form -->
                <div class="bg-gray-50 rounded-2xl p-8">
                    <div class="flex items-center mb-6">
                        <svg class="h-6 w-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900">Send us a message</h3>
                    </div>
                    
                    <div id="contact-success" class="hidden text-center py-12">
                        <svg class="h-16 w-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">Message Sent!</h4>
                        <p class="text-gray-600">Thank you for your message. We'll get back to you within 24 hours.</p>
                    </div>

                    <form id="contact-form" action="api/contact.php" method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                                <input type="text" id="name" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Your name">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="your@email.com">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                                <input type="text" id="company" name="company" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Your company name">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Your phone number">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="service" class="block text-sm font-medium text-gray-700 mb-2">Service Interest</label>
                                <select id="service" name="service" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">Select a service</option>
                                    <option value="Custom Software Development">Custom Software Development</option>
                                    <option value="Mobile App Development">Mobile App Development</option>
                                    <option value="Cloud Solutions">Cloud Solutions</option>
                                    <option value="Data Analytics">Data Analytics</option>
                                    <option value="Cybersecurity">Cybersecurity</option>
                                    <option value="UI/UX Design">UI/UX Design</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">Budget Range</label>
                                <select id="budget" name="budget" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">Select budget range</option>
                                    <option value="Under ₹5,00,000">Under ₹5,00,000</option>
                                    <option value="₹5,00,000 - ₹15,00,000">₹5,00,000 - ₹15,00,000</option>
                                    <option value="₹15,00,000 - ₹30,00,000">₹15,00,000 - ₹30,00,000</option>
                                    <option value="₹30,00,000 - ₹60,00,000">₹30,00,000 - ₹60,00,000</option>
                                    <option value="Over ₹60,00,000">Over ₹60,00,000</option>
                                    <option value="Not sure yet">Not sure yet</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                            <textarea id="message" name="message" required rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Tell us about your project..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-all duration-300 flex items-center justify-center group shadow-lg hover:shadow-xl">
                            Send Message
                            <svg class="ml-2 h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-8">Get in Touch</h3>
                    
                    <div class="space-y-6 mb-12">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4 flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-1">Email</h4>
                                <a href="mailto:sales@f24tech.com" class="text-blue-600 font-medium mb-1 hover:text-blue-700 transition-colors">sales@f24tech.com</a>
                                <p class="text-gray-600 text-sm">Send us an email anytime!</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4 flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-1">Phone</h4>
                                <a href="tel:+918950773419" class="text-blue-600 font-medium mb-1 hover:text-blue-700 transition-colors">+91 8950773419</a>
                                <p class="text-gray-600 text-sm">Mon-Fri from 9am to 6pm IST</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4 flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-1">Office</h4>
                                <p class="text-blue-600 font-medium mb-1">Plot No. 44, Sector 44</p>
                                <p class="text-blue-600 font-medium mb-1">Gurgaon, Haryana, 122003</p>
                                <p class="text-blue-600 font-medium mb-1">INDIA</p>
                                <p class="text-gray-600 text-sm">Come say hello at our office</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4 flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-1">Working Hours</h4>
                                <p class="text-blue-600 font-medium mb-1">Mon - Fri: 9am - 6pm IST</p>
                                <p class="text-gray-600 text-sm">We respond within 24 hours</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Box -->
                    <div class="rounded-2xl p-6 text-white" style="background: linear-gradient(to right, #2563eb, #16a34a)">
                        <h4 class="text-xl font-bold mb-2">Ready to get started?</h4>
                        <p class="mb-4 opacity-90">Schedule a free consultation to discuss your project.</p>
                        <a href="mailto:sales@f24tech.com?subject=Free Consultation Request&body=Hi, I'd like to schedule a free consultation to discuss my project." class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                            Book a Call
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
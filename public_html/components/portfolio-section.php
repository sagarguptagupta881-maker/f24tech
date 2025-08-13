<section id="portfolio" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Our Portfolio
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Discover some of our recent projects that showcase our expertise across various industries and technologies.
            </p>
        </div>

        <?php
        // Get published projects from database
        include 'config/database.php';
        
        try {
            $projects = DB::query("
                SELECT p.*, 
                       GROUP_CONCAT(DISTINCT pt.technology) as technologies,
                       GROUP_CONCAT(DISTINCT ptag.tag) as tags
                FROM projects p
                LEFT JOIN project_technologies pt ON p.id = pt.project_id
                LEFT JOIN project_tags ptag ON p.id = ptag.project_id
                WHERE p.status = 'published'
                GROUP BY p.id
                ORDER BY p.updated_at DESC
                LIMIT 6
            ")->fetchAll();
        } catch (Exception $e) {
            $projects = [];
        }
        ?>

        <?php if ($projects): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($projects as $project): ?>
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover group">
                        <div class="relative overflow-hidden">
                            <?php if ($project['image_url']): ?>
                                <img 
                                    src="<?php echo htmlspecialchars($project['image_url']); ?>" 
                                    alt="<?php echo htmlspecialchars($project['title']); ?>"
                                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500"
                                />
                            <?php else: ?>
                                <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-green-500 flex items-center justify-center">
                                    <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <div class="absolute top-4 left-4">
                                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <?php echo htmlspecialchars($project['category']); ?>
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div class="flex space-x-4">
                                    <button onclick="showProjectDetails(<?php echo $project['id']; ?>)" class="bg-white/90 p-3 rounded-full hover:bg-white transition-colors">
                                        <svg class="h-5 w-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <a href="?page=contact" class="bg-white/90 p-3 rounded-full hover:bg-white transition-colors">
                                        <svg class="h-5 w-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                                <?php echo htmlspecialchars($project['title']); ?>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                <?php echo htmlspecialchars($project['description']); ?>
                            </p>
                            
                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php 
                                $technologies = $project['technologies'] ? explode(',', $project['technologies']) : [];
                                foreach (array_slice($technologies, 0, 3) as $tech): 
                                ?>
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
                                        <?php echo htmlspecialchars(trim($tech)); ?>
                                    </span>
                                <?php endforeach; ?>
                                <?php if (count($technologies) > 3): ?>
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
                                        +<?php echo count($technologies) - 3; ?> more
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <button onclick="showProjectDetails(<?php echo $project['id']; ?>)" 
                                    class="flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors group">
                                View Case Study
                                <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <svg class="h-24 w-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No Projects Yet</h3>
                <p class="text-gray-600">We're working on some amazing projects. Check back soon!</p>
            </div>
        <?php endif; ?>

        <div class="text-center mt-12">
            <a href="?page=portfolio" class="bg-blue-600 text-white px-8 py-4 rounded-full font-semibold hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                View All Projects
            </a>
        </div>
    </div>
</section>
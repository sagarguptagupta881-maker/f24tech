<div class="pt-24">
    <!-- Hero Section -->
    <section class="py-20" style="background: linear-gradient(135deg, #1e40af 0%, #10b981 100%)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Our Portfolio</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Explore our successful projects across various industries and discover how we've helped businesses achieve their digital transformation goals.
            </p>
        </div>
    </section>

    <!-- Portfolio Grid -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                ")->fetchAll();
            } catch (Exception $e) {
                $projects = [];
            }
            ?>

            <?php if ($projects): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($projects as $project): ?>
                        <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group">
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
                                
                                <div class="flex items-center justify-between">
                                    <button onclick="showProjectDetails(<?php echo $project['id']; ?>)" 
                                            class="flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors group">
                                        View Details
                                        <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                    <?php if ($project['duration']): ?>
                                        <span class="text-sm text-gray-500"><?php echo htmlspecialchars($project['duration']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-20">
                    <svg class="h-24 w-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No Projects Yet</h3>
                    <p class="text-gray-600 mb-8">We're working on some amazing projects. Check back soon!</p>
                    <a href="?page=contact" class="bg-blue-600 text-white px-8 py-4 rounded-full font-semibold hover:bg-blue-700 transition-colors">
                        Start Your Project
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="rounded-2xl p-12 text-white" style="background: linear-gradient(to right, #2563eb, #16a34a)">
                <h3 class="text-3xl font-bold mb-4">Ready to Start Your Project?</h3>
                <p class="text-xl mb-8 opacity-90">
                    Let's discuss how we can help bring your vision to life with our proven expertise.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="mailto:sales@f24tech.com?subject=New Project Inquiry" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-blue-50 transition-colors">
                        Start Your Project
                    </a>
                    <a href="?page=contact" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                        Schedule Consultation
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Project Details Modal -->
<div id="project-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div id="modal-content">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<script>
function showProjectDetails(projectId) {
    const modal = document.getElementById('project-modal');
    const content = document.getElementById('modal-content');
    
    // Show loading
    content.innerHTML = `
        <div class="p-8 text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
            <p class="mt-4 text-gray-600">Loading project details...</p>
        </div>
    `;
    modal.classList.remove('hidden');
    
    // Fetch project details
    fetch('api/get-project.php?id=' + projectId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                content.innerHTML = generateProjectModal(data.project);
            } else {
                content.innerHTML = `
                    <div class="p-8 text-center">
                        <p class="text-red-600">Error loading project details</p>
                        <button onclick="closeModal()" class="mt-4 bg-gray-600 text-white px-4 py-2 rounded-lg">Close</button>
                    </div>
                `;
            }
        })
        .catch(error => {
            content.innerHTML = `
                <div class="p-8 text-center">
                    <p class="text-red-600">Error loading project details</p>
                    <button onclick="closeModal()" class="mt-4 bg-gray-600 text-white px-4 py-2 rounded-lg">Close</button>
                </div>
            `;
        });
}

function generateProjectModal(project) {
    return `
        <div class="relative">
            <button onclick="closeModal()" class="absolute top-4 right-4 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            ${project.image_url ? `
                <img src="${project.image_url}" alt="${project.title}" class="w-full h-64 object-cover">
            ` : `
                <div class="w-full h-64 bg-gradient-to-br from-blue-500 to-green-500 flex items-center justify-center">
                    <svg class="h-24 w-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            `}
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl font-bold text-gray-900">${project.title}</h2>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">${project.category}</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    ${project.client ? `
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Client</h4>
                            <p class="text-gray-600">${project.client}</p>
                        </div>
                    ` : ''}
                    ${project.duration ? `
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Duration</h4>
                            <p class="text-gray-600">${project.duration}</p>
                        </div>
                    ` : ''}
                    ${project.team_size ? `
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Team Size</h4>
                            <p class="text-gray-600">${project.team_size}</p>
                        </div>
                    ` : ''}
                </div>
                
                <div class="mb-8">
                    <h4 class="text-xl font-semibold text-gray-900 mb-4">Project Description</h4>
                    <p class="text-gray-600 leading-relaxed">${project.long_description || project.description}</p>
                </div>
                
                ${project.challenge ? `
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold text-gray-900 mb-4">Challenge</h4>
                        <p class="text-gray-600 leading-relaxed">${project.challenge}</p>
                    </div>
                ` : ''}
                
                ${project.solution ? `
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold text-gray-900 mb-4">Solution</h4>
                        <p class="text-gray-600 leading-relaxed">${project.solution}</p>
                    </div>
                ` : ''}
                
                ${project.features && project.features.length > 0 ? `
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold text-gray-900 mb-4">Key Features</h4>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            ${project.features.map(feature => `
                                <li class="flex items-center text-gray-600">
                                    <svg class="h-4 w-4 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    ${feature}
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                ` : ''}
                
                ${project.technologies && project.technologies.length > 0 ? `
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold text-gray-900 mb-4">Technologies Used</h4>
                        <div class="flex flex-wrap gap-2">
                            ${project.technologies.map(tech => `
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">${tech}</span>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}
                
                ${project.results && project.results.length > 0 ? `
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold text-gray-900 mb-4">Results</h4>
                        <ul class="space-y-2">
                            ${project.results.map(result => `
                                <li class="flex items-center text-gray-600">
                                    <svg class="h-4 w-4 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    ${result}
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                ` : ''}
                
                ${project.testimonial ? `
                    <div class="bg-gray-50 rounded-xl p-6 mb-8">
                        <h4 class="text-xl font-semibold text-gray-900 mb-4">Client Testimonial</h4>
                        <blockquote class="text-gray-600 italic mb-4">"${project.testimonial.testimonial_text}"</blockquote>
                        <div class="flex items-center">
                            <div>
                                <p class="font-semibold text-gray-900">${project.testimonial.author_name}</p>
                                <p class="text-sm text-gray-600">${project.testimonial.author_role}</p>
                            </div>
                        </div>
                    </div>
                ` : ''}
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="mailto:sales@f24tech.com?subject=Inquiry about ${project.title}&body=Hi, I'm interested in learning more about the ${project.title} project." 
                       class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors text-center">
                        Start Similar Project
                    </a>
                    <a href="?page=contact" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors text-center">
                        Get Quote
                    </a>
                </div>
            </div>
        </div>
    `;
}

function closeModal() {
    document.getElementById('project-modal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('project-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
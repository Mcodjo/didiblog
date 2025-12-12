    <!-- Newsletter Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-orange-600">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">
                Ne rate aucun conseil !
            </h2>
            <p class="text-lg mb-8 max-w-2xl mx-auto">
                Reçois mes nouveaux articles directement dans ta boîte mail
            </p>
            
            <form action="<?= SITE_URL ?>/newsletter.php" method="POST" class="max-w-md mx-auto flex flex-col sm:flex-row gap-4">
                <input type="email" name="email" placeholder="Ton email" required
                       class="flex-1 px-6 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                
                <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
                <input type="hidden" name="source" value="<?= basename($_SERVER['PHP_SELF']) ?>">
                
                <button type="submit" class="px-8 py-3 bg-white text-orange-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                    S'abonner
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo et description -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                            <img src="https://page.gensparksite.com/v1/base64_upload/a456eb81c0763b6540288c7203d94cf5" 
                                 alt="Coach Didi Logo" 
                                 class="w-8 h-8 object-cover rounded-full">
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xl font-bold">Emploi Connect</span>
                            <div class="w-3 h-3 bg-gradient-to-r from-orange-500 to-blue-600 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">
                        Le blog de référence pour décrocher un emploi plus vite. Coach Didi t'accompagne vers l'emploi de tes rêves avec des conseils pratiques et des formations efficaces.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="<?= SITE_URL ?>" class="text-gray-400 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="<?= SITE_URL ?>/formations.php" class="text-gray-400 hover:text-white transition-colors">Formations</a></li>
                        <li><a href="<?= SITE_URL ?>/blog.php" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="<?= SITE_URL ?>/contact.php" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="<?= SITE_URL ?>/guide-gratuit.php" class="text-gray-400 hover:text-white transition-colors">Guide Gratuit</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <div class="space-y-2 text-gray-400">
                        <p class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <?= CONTACT_EMAIL ?>
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            +229 66 68 34 87
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Lun-Ven 9h-18h
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Bénin
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        © <?= date('Y') ?> Emploi Connect - Coach Didi. Tous droits réservés.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="<?= SITE_URL ?>/mentions-legales.php" class="text-gray-400 hover:text-white text-sm transition-colors">Mentions légales</a>
                        <a href="<?= SITE_URL ?>/politique-confidentialite.php" class="text-gray-400 hover:text-white text-sm transition-colors">Politique de confidentialité</a>
                        <a href="<?= SITE_URL ?>/cgv.php" class="text-gray-400 hover:text-white text-sm transition-colors">CGV</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?= SITE_URL ?>/js/app.js"></script>
    
    <!-- Animation des compteurs -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Initialisation animation compteurs...');
            
            const counters = document.querySelectorAll('.stat-counter');
            console.log('Compteurs trouvés:', counters.length);
            
            if (counters.length === 0) return;

            const observerOptions = {
                threshold: 0.2,
                rootMargin: '0px'
            };

            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        console.log('Animation déclenchée pour:', entry.target.getAttribute('data-target'));
                        animateCounter(entry.target);
                        counterObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            counters.forEach(counter => {
                counterObserver.observe(counter);
            });

            function animateCounter(counterElement) {
                const targetValue = counterElement.getAttribute('data-target');
                const counterValueElement = counterElement.querySelector('.counter-value');
                
                if (!targetValue || !counterValueElement) return;

                const numericValue = parseInt(targetValue.replace(/[^\d]/g, ''));
                const suffix = targetValue.replace(/[\d]/g, '');
                
                let currentValue = 0;
                const duration = 2000;
                const startTime = performance.now();

                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    const easedProgress = 1 - Math.pow(1 - progress, 3);
                    currentValue = Math.floor(numericValue * easedProgress);
                    
                    counterValueElement.textContent = currentValue + suffix;
                    
                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        counterValueElement.textContent = targetValue;
                    }
                }

                requestAnimationFrame(updateCounter);
            }
        });
    </script>

</body>
</html>

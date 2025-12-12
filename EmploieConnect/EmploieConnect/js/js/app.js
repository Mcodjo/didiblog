// =========================================
// EMPLOI CONNECT - VERSION DYNAMIQUE PHP
// =========================================

// Les données sont maintenant gérées par la base de données PHP
// Ce fichier ne contient que les fonctionnalités UI essentielles

class EmploiConnectApp {
    constructor() {
        this.init();
    }

    init() {
        console.log('🚀 Initialisation d\'Emploi Connect...');
        
        // Fonctionnalités UI essentielles uniquement
        this.setupThemeToggle();
        this.setupMobileMenu();
        this.setupStickyHeader();
        this.setupSmoothScrolling();
        this.setupEventListeners();
        this.setupAnimations();
        this.setupCoachCarousel();
        
        // Délai pour s'assurer que le DOM est complètement chargé
        setTimeout(() => {
            this.setupCounterAnimations();
        }, 100);
        
        console.log('✅ Emploi Connect - Application initialisée');
    }

    // Gestion du thème sombre/clair
    setupThemeToggle() {
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        if (!themeToggle || !themeIcon) return;

        // Récupération du thème sauvegardé
        const savedTheme = localStorage.getItem('theme');
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        const currentTheme = savedTheme || systemTheme;

        // Application du thème initial
        if (currentTheme === 'dark') {
            html.classList.add('dark');
            themeIcon.className = 'fas fa-moon text-gray-600 dark:text-gray-300';
        } else {
            html.classList.remove('dark');
            themeIcon.className = 'fas fa-sun text-gray-600 dark:text-gray-300';
        }

        // Écouteur pour basculer le thème
        themeToggle.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                themeIcon.className = 'fas fa-sun text-gray-600 dark:text-gray-300';
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                themeIcon.className = 'fas fa-moon text-gray-600 dark:text-gray-300';
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    // Gestion du menu mobile
    setupMobileMenu() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuIcon = document.getElementById('mobile-menu-icon');

        if (!mobileMenuToggle || !mobileMenu || !mobileMenuIcon) return;

        mobileMenuToggle.addEventListener('click', () => {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                mobileMenuIcon.className = 'fas fa-times text-gray-600 dark:text-gray-300';
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenuIcon.className = 'fas fa-bars text-gray-600 dark:text-gray-300';
            }
        });

        // Fermeture du menu mobile lors du clic sur un lien
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                mobileMenuIcon.className = 'fas fa-bars text-gray-600 dark:text-gray-300';
            });
        });
    }

    // Header sticky
    setupStickyHeader() {
        const header = document.getElementById('header');
        if (!header) return;
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('sticky-header');
            } else {
                header.classList.remove('sticky-header');
            }
        });
    }

    // Défilement doux
    setupSmoothScrolling() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    const headerHeight = document.getElementById('header')?.offsetHeight || 80;
                    const targetPosition = targetElement.offsetTop - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // Les articles et catégories sont maintenant générés côté serveur PHP
    // Plus besoin de génération JavaScript

    // Validation email
    validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Notifications
    showNotification(message, type = 'info') {
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notif => notif.remove());

        const notification = document.createElement('div');
        notification.className = `notification fixed top-20 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
            'bg-blue-500 text-white'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} mr-2"></i>
                <span>${message}</span>
                <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, 5000);
    }

    // Animations
    setupAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        const animatedElements = document.querySelectorAll('.article-card, .formation-card');
        animatedElements.forEach(el => observer.observe(el));
    }

    // Fonctionnalités PWA et notifications désactivées
    // Le site utilise maintenant uniquement la base de données PHP

    // Écouteurs d'événements
    setupEventListeners() {
        document.addEventListener('click', (e) => {
            // Boutons "Lire la suite" redirigent vers le blog
            if (e.target.textContent && e.target.textContent.includes('Lire la suite')) {
                e.preventDefault();
                window.location.href = 'blog.php';
            }
        });

        // Redimensionnement
        window.addEventListener('resize', () => {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuIcon = document.getElementById('mobile-menu-icon');
            
            if (mobileMenu && mobileMenuIcon && window.innerWidth >= 1024) {
                mobileMenu.classList.add('hidden');
                mobileMenuIcon.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });

        // Clavier
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const mobileMenu = document.getElementById('mobile-menu');
                const mobileMenuIcon = document.getElementById('mobile-menu-icon');
                
                if (mobileMenu && mobileMenuIcon && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuIcon.className = 'fas fa-bars text-gray-600 dark:text-gray-300';
                }
            }
        });
    }

    // Gestion du carousel Coach Didi
    setupCoachCarousel() {
        const carousel = document.getElementById('coach-carousel');
        if (!carousel) return;

        const slides = carousel.querySelectorAll('.carousel-slide');
        const indicators = carousel.querySelectorAll('.carousel-indicator');
        const prevBtn = document.getElementById('prev-slide');
        const nextBtn = document.getElementById('next-slide');

        if (slides.length <= 1) return; // Pas de carousel si une seule image

        let currentSlide = 0;
        let autoplayInterval;

        // Fonction pour afficher une slide
        const showSlide = (index) => {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
                slide.style.opacity = i === index ? '1' : '0';
            });

            indicators.forEach((indicator, i) => {
                if (i === index) {
                    indicator.classList.remove('bg-white', 'bg-opacity-50');
                    indicator.classList.add('bg-white');
                } else {
                    indicator.classList.remove('bg-white');
                    indicator.classList.add('bg-white', 'bg-opacity-50');
                }
            });

            currentSlide = index;
        };

        // Navigation suivante
        const nextSlide = () => {
            const next = (currentSlide + 1) % slides.length;
            showSlide(next);
        };

        // Navigation précédente
        const prevSlide = () => {
            const prev = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prev);
        };

        // Démarrer l'autoplay
        const startAutoplay = () => {
            autoplayInterval = setInterval(nextSlide, 4000); // Change toutes les 4 secondes
        };

        // Arrêter l'autoplay
        const stopAutoplay = () => {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
                autoplayInterval = null;
            }
        };

        // Écouteurs d'événements
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                stopAutoplay();
                nextSlide();
                startAutoplay();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                stopAutoplay();
                prevSlide();
                startAutoplay();
            });
        }

        // Indicateurs
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                stopAutoplay();
                showSlide(index);
                startAutoplay();
            });
        });

        // Pause sur hover
        carousel.addEventListener('mouseenter', stopAutoplay);
        carousel.addEventListener('mouseleave', startAutoplay);

        // Support tactile pour mobile
        let startX = 0;
        let endX = 0;

        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            stopAutoplay();
        });

        carousel.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            const diff = startX - endX;

            if (Math.abs(diff) > 50) { // Seuil minimum pour le swipe
                if (diff > 0) {
                    nextSlide(); // Swipe vers la gauche
                } else {
                    prevSlide(); // Swipe vers la droite
                }
            }
            startAutoplay();
        });

        // Initialiser l'autoplay
        startAutoplay();
    }

    // Animation des compteurs de statistiques
    setupCounterAnimations() {
        const counters = document.querySelectorAll('.stat-counter');
        console.log('🔢 Compteurs trouvés:', counters.length);
        
        if (counters.length === 0) {
            console.warn('❌ Aucun compteur trouvé avec la classe .stat-counter');
            return;
        }

        // Détection mobile pour ajuster les paramètres
        const isMobile = window.innerWidth <= 768;
        
        const observerOptions = {
            threshold: isMobile ? 0.05 : 0.1, // Seuil encore plus bas sur mobile
            rootMargin: isMobile ? '0px 0px -20px 0px' : '0px 0px -50px 0px' // Marge très réduite sur mobile
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                console.log('👁️ Intersection:', entry.isIntersecting, entry.target.getAttribute('data-target'));
                if (entry.isIntersecting) {
                    // Petit délai pour s'assurer que l'élément est bien visible
                    setTimeout(() => {
                        this.animateCounter(entry.target);
                    }, isMobile ? 200 : 100);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        counters.forEach(counter => {
            console.log('🎯 Observing counter:', counter.getAttribute('data-target'));
            counterObserver.observe(counter);
        });
    }

    // Animation d'un compteur individuel
    animateCounter(counterElement) {
        const targetValue = counterElement.getAttribute('data-target');
        const counterValueElement = counterElement.querySelector('.counter-value');
        
        console.log('🎬 Animation compteur:', targetValue, counterValueElement);
        
        if (!targetValue || !counterValueElement) {
            console.error('❌ Éléments manquants pour l\'animation');
            return;
        }

        // Extraire le nombre du texte (ex: "4300+" -> 4300, "85%" -> 85, "2-3" -> 2)
        let numericValue;
        let suffix;
        
        if (targetValue.includes('-')) {
            // Cas spécial pour "2-3"
            numericValue = parseInt(targetValue.split('-')[0]);
            suffix = targetValue;
        } else {
            numericValue = parseInt(targetValue.replace(/[^\d]/g, ''));
            suffix = targetValue.replace(/[\d]/g, '');
        }
        
        console.log('📊 Valeurs:', { numericValue, suffix, targetValue });
        
        let currentValue = 0;
        // Durée plus courte sur mobile pour une meilleure expérience
        const isMobile = window.innerWidth <= 768;
        const duration = isMobile ? 1500 : 2000;
        const startTime = performance.now();

        const updateCounter = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            const easedProgress = this.easeOutCubic(progress);
            currentValue = Math.floor(numericValue * easedProgress);
            
            if (targetValue.includes('-')) {
                // Cas spécial pour "2-3" - afficher directement la valeur finale
                counterValueElement.textContent = targetValue;
            } else {
                counterValueElement.textContent = currentValue + suffix;
            }
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                counterValueElement.textContent = targetValue;
                console.log('✅ Animation terminée:', targetValue);
            }
        };

        requestAnimationFrame(updateCounter);
    }

    // Fonction d'easing pour une animation plus naturelle
    easeOutCubic(t) {
        return 1 - Math.pow(1 - t, 3);
    }
}

// =========================================
// STYLES ESSENTIELS
// =========================================

const essentialStyles = document.createElement('style');
essentialStyles.textContent = `
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .interactive-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .interactive-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    /* Styles pour le carousel Coach Didi */
    .carousel-container {
        position: relative;
        width: 100%;
        height: 320px;
    }
    
    .carousel-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
    
    .carousel-slide.active {
        opacity: 1;
    }
    
    .carousel-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0.75rem;
    }
`;

document.head.appendChild(essentialStyles);

// =========================================
// INITIALISATION
// =========================================

document.addEventListener('DOMContentLoaded', () => {
    new EmploiConnectApp();
});
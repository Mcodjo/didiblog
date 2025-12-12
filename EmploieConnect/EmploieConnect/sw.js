// Service Worker désactivé - Site maintenant entièrement dynamique avec PHP
// Ce fichier est conservé pour éviter les erreurs mais ne fait plus de mise en cache

console.log('⚠️ Service Worker désactivé - Site dynamique PHP uniquement');

// Désactiver immédiatement le service worker
self.addEventListener('install', event => {
  console.log('🚫 Service Worker: Installation annulée - Fonctionnalité désactivée');
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  console.log('🗑️ Service Worker: Nettoyage des anciens caches...');
  
  event.waitUntil(
    caches.keys()
      .then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            console.log('🗑️ Suppression du cache:', cacheName);
            return caches.delete(cacheName);
          })
        );
      })
      .then(() => {
        console.log('✅ Tous les caches supprimés - Site maintenant entièrement dynamique');
        return self.clients.claim();
      })
  );
});

// Aucune interception des requêtes - tout passe par le serveur PHP
self.addEventListener('fetch', event => {
  // Laisser toutes les requêtes passer normalement vers le serveur
  return;
});
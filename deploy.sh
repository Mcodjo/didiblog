#!/bin/bash
set -e

echo "========================================"
echo "   Déploiement Didiblog - Docker + Nginx"
echo "========================================"

# Vérification du .env
if [ ! -f .env ]; then
    echo "⚠ Fichier .env introuvable. Copie depuis .env.example..."
    cp .env.example .env
fi

echo ""
echo "--> Build et démarrage des conteneurs..."
docker compose up -d --build

echo ""
echo "--> Attente que la base de données soit prête..."
sleep 10

echo ""
echo "--> Génération de la clé APP_KEY (si vide)..."
docker compose exec app php artisan key:generate --no-interaction --force

echo ""
echo "--> Installation des dépendances Node et build des assets..."
npm install && npm run build

echo ""
echo "--> Exécution des migrations..."
docker compose exec app php artisan migrate --force

echo ""
echo "--> Création du lien storage..."
docker compose exec app php artisan storage:link

echo ""
echo "--> Mise en cache de la config, routes et vues..."
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

echo ""
echo "✅ Déploiement terminé !"
echo "   👉 http://localhost"

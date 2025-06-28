#!/bin/bash

# Management script untuk ServisKu Backend

case "$1" in
    "start")
        echo "🚀 Starting ServisKu Backend..."
        docker compose up -d
        ;;
    "stop")
        echo "⏹️ Stopping ServisKu Backend..."
        docker compose down
        ;;
    "restart")
        echo "🔄 Restarting ServisKu Backend..."
        docker compose restart
        ;;
    "logs")
        echo "📋 Showing logs..."
        docker compose logs -f app
        ;;
    "shell")
        echo "🐚 Opening shell in container..."
        docker compose exec app bash
        ;;
    "migrate")
        echo "🔧 Running migrations..."
        docker compose exec app php artisan migrate
        ;;
    "seed")
        echo "🌱 Running seeders..."
        docker compose exec app php artisan db:seed
        ;;
    "cache-clear")
        echo "🧹 Clearing cache..."
        docker compose exec app php artisan cache:clear
        docker compose exec app php artisan config:clear
        docker compose exec app php artisan route:clear
        docker compose exec app php artisan view:clear
        ;;
    "cache-optimize")
        echo "⚡ Optimizing cache..."
        docker compose exec app php artisan config:cache
        docker compose exec app php artisan route:cache
        docker compose exec app php artisan view:cache
        ;;
    "status")
        echo "📊 Container status:"
        docker compose ps
        echo ""
        echo "🔍 Health check:"
        curl -f http://localhost:8080/api/health 2>/dev/null && echo "✅ Healthy" || echo "❌ Unhealthy"
        ;;
    "backup")
        echo "💾 Creating backup..."
        timestamp=$(date +%Y%m%d_%H%M%S)
        docker compose exec app php artisan backup:run --only-db
        echo "Backup completed: $timestamp"
        ;;
    "update")
        echo "🔄 Updating application..."
        git pull
        docker compose down
        docker compose up --build -d
        docker compose exec app php artisan migrate --force
        docker compose exec app php artisan config:cache
        docker compose exec app php artisan route:cache
        docker compose exec app php artisan view:cache
        echo "✅ Update completed!"
        ;;
    "build")
        echo "🔨 Building application..."
        docker compose build --no-cache
        ;;
    "deploy")
        echo "🚀 Full deployment..."
        source .env.docker
        docker compose down
        docker compose up --build -d
        sleep 40
        docker compose exec app php artisan migrate --force
        docker compose exec app php artisan config:cache
        docker compose exec app php artisan route:cache
        docker compose exec app php artisan view:cache
        echo "✅ Deployment completed!"
        ;;
    "test")
        echo "🧪 Running tests..."
        docker compose exec app php artisan test
        ;;
    "fresh")
        echo "🔄 Fresh migration with seed..."
        docker compose exec app php artisan migrate:fresh --seed
        ;;
    "queue")
        echo "⚡ Starting queue worker..."
        docker compose exec app php artisan queue:work
        ;;
    "refresh-demo")
        echo "🔄 Refreshing demo data..."
        docker compose exec app php artisan migrate:fresh --seed
        echo "✅ Demo data refreshed!"
        ;;
    "composer-install")
        echo "📦 Installing Composer dependencies for production..."
        docker compose exec app composer install --no-dev --optimize-autoloader
        echo "✅ Composer install completed!"
        ;;
    "composer-dev")
        echo "📦 Installing Composer dependencies with dev packages..."
        docker compose exec app composer install --optimize-autoloader
        echo "✅ Composer dev install completed!"
        ;;
    "fix-pail")
        echo "🔧 Fixing Laravel Pail issue..."
        docker compose exec app composer remove laravel/pail
        docker compose exec app php artisan package:discover --ansi
        docker compose exec app composer dump-autoload
        echo "✅ Laravel Pail removed!"
        ;;
    "deploy-production")
        echo "🚀 Production deployment..."
        source .env.docker
        echo "📋 Stopping containers..."
        docker compose down
        echo "🔨 Building containers..."
        docker compose up --build -d
        echo "⏳ Waiting for containers to start..."
        sleep 40
        echo "📦 Installing production dependencies..."
        docker compose exec app composer install --no-dev --optimize-autoloader
        echo "🔧 Running migrations..."
        docker compose exec app php artisan migrate --force
        echo "⚡ Optimizing for production..."
        docker compose exec app php artisan config:cache
        docker compose exec app php artisan route:cache
        docker compose exec app php artisan view:cache
        docker compose exec app php artisan storage:link
        echo "🔍 Setting permissions..."
        docker compose exec app chown -R www-data:www-data storage bootstrap/cache
        docker compose exec app chmod -R 775 storage bootstrap/cache
        echo "✅ Production deployment completed!"
        ;;
    *)
        echo "📖 Usage: $0 {start|stop|restart|logs|shell|migrate|seed|cache-clear|cache-optimize|status|backup|update|build|deploy|test|fresh|queue|composer-install|composer-dev|fix-pail|deploy-production}"
        echo ""
        echo "Commands:"
        echo "  start            - Start the application"
        echo "  stop             - Stop the application"
        echo "  restart          - Restart the application"
        echo "  logs             - Show application logs"
        echo "  shell            - Open shell in container"
        echo "  migrate          - Run database migrations"
        echo "  seed             - Run database seeders"
        echo "  cache-clear      - Clear all cache"
        echo "  cache-optimize   - Optimize cache for production"
        echo "  status           - Show container and health status"
        echo "  backup           - Create database backup"
        echo "  update           - Update application from git"
        echo "  build            - Build the application"
        echo "  deploy           - Deploy the application"
        echo "  deploy-production - Deploy for production environment"
        echo "  test             - Run application tests"
        echo "  fresh            - Fresh migration and seed"
        echo "  queue            - Start the queue worker"
        echo "  composer-install - Install production dependencies"
        echo "  composer-dev     - Install dev dependencies"
        echo "  fix-pail         - Fix Laravel Pail error"
        exit 1
        ;;
esac

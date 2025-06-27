#!/bin/bash

# Management script untuk ServisKu Backend

case "$1" in
    "start")
        echo "🚀        echo "📖 Usage: $0 {start|stop|restart|logs|shell|migrate|seed|cache-clear|cache-optimize|status|backup|update|build|deploy|test|fresh|queue|refresh-demo}"
        echo ""
        echo "Commands:"
        echo "  start         - Start the application"
        echo "  stop          - Stop the application"
        echo "  restart       - Restart the application"
        echo "  logs          - Show application logs"
        echo "  shell         - Open shell in container"
        echo "  migrate       - Run database migrations"
        echo "  seed          - Run database seeders"
        echo "  cache-clear   - Clear all cache"
        echo "  cache-optimize - Optimize cache for production"
        echo "  status        - Show container and health status"
        echo "  backup        - Create database backup"
        echo "  update        - Update application from git"
        echo "  build         - Build Docker image from scratch"
        echo "  deploy        - Full deployment with migration"
        echo "  test          - Run Laravel tests"
        echo "  fresh         - Fresh migration with seeding"
        echo "  queue         - Start queue worker"
        echo "  refresh-demo  - Refresh database with demo data"sKu Backend..."
        docker-compose up -d
        ;;
    "stop")
        echo "⏹️ Stopping ServisKu Backend..."
        docker-compose down
        ;;
    "restart")
        echo "🔄 Restarting ServisKu Backend..."
        docker-compose restart
        ;;
    "logs")
        echo "📋 Showing logs..."
        docker-compose logs -f app
        ;;
    "shell")
        echo "🐚 Opening shell in container..."
        docker-compose exec app bash
        ;;
    "migrate")
        echo "🔧 Running migrations..."
        docker-compose exec app php artisan migrate
        ;;
    "seed")
        echo "🌱 Running seeders..."
        docker-compose exec app php artisan db:seed
        ;;
    "cache-clear")
        echo "🧹 Clearing cache..."
        docker-compose exec app php artisan cache:clear
        docker-compose exec app php artisan config:clear
        docker-compose exec app php artisan route:clear
        docker-compose exec app php artisan view:clear
        ;;
    "cache-optimize")
        echo "⚡ Optimizing cache..."
        docker-compose exec app php artisan config:cache
        docker-compose exec app php artisan route:cache
        docker-compose exec app php artisan view:cache
        ;;
    "status")
        echo "📊 Container status:"
        docker-compose ps
        echo ""
        echo "🔍 Health check:"
        curl -f http://localhost:8080/api/health 2>/dev/null && echo "✅ Healthy" || echo "❌ Unhealthy"
        ;;
    "backup")
        echo "💾 Creating backup..."
        timestamp=$(date +%Y%m%d_%H%M%S)
        docker-compose exec app php artisan backup:run --only-db
        echo "Backup completed: $timestamp"
        ;;
    "update")
        echo "🔄 Updating application..."
        git pull
        docker-compose down
        docker-compose up --build -d
        docker-compose exec app php artisan migrate --force
        docker-compose exec app php artisan config:cache
        docker-compose exec app php artisan route:cache
        docker-compose exec app php artisan view:cache
        echo "✅ Update completed!"
        ;;
    "build")
        echo "🔨 Building application..."
        docker-compose build --no-cache
        ;;
    "deploy")
        echo "🚀 Full deployment..."
        source .env.docker
        docker-compose down
        docker-compose up --build -d
        sleep 40
        docker-compose exec app php artisan migrate --force
        docker-compose exec app php artisan config:cache
        docker-compose exec app php artisan route:cache
        docker-compose exec app php artisan view:cache
        echo "✅ Deployment completed!"
        ;;
    "test")
        echo "🧪 Running tests..."
        docker-compose exec app php artisan test
        ;;
    "fresh")
        echo "🔄 Fresh migration with seed..."
        docker-compose exec app php artisan migrate:fresh --seed
        ;;
    "queue")
        echo "⚡ Starting queue worker..."
        docker-compose exec app php artisan queue:work
        ;;
    "refresh-demo")
        echo "🔄 Refreshing demo data..."
        $DOCKER_COMPOSE exec app php artisan migrate:fresh --seed
        echo "✅ Demo data refreshed!"
        ;;
    *)
        echo "📖 Usage: $0 {start|stop|restart|logs|shell|migrate|seed|cache-clear|cache-optimize|status|backup|update|build|deploy|test|fresh|queue}"
        echo ""
        echo "Commands:"
        echo "  start         - Start the application"
        echo "  stop          - Stop the application"
        echo "  restart       - Restart the application"
        echo "  logs          - Show application logs"
        echo "  shell         - Open shell in container"
        echo "  migrate       - Run database migrations"
        echo "  seed          - Run database seeders"
        echo "  cache-clear   - Clear all cache"
        echo "  cache-optimize - Optimize cache for production"
        echo "  status        - Show container and health status"
        echo "  backup        - Create database backup"
        echo "  update        - Update application from git"
        echo "  build         - Build the application"
        echo "  deploy        - Deploy the application"
        echo "  test          - Run application tests"
        echo "  fresh         - Fresh migration and seed"
        echo "  queue         - Start the queue worker"
        exit 1
        ;;
esac

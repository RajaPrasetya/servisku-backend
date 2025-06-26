#!/bin/bash

# Deploy script untuk ServisKu Backend
echo "🚀 Starting ServisKu Backend deployment..."

# Load environment variables
if [ -f .env.docker ]; then
    export $(cat .env.docker | grep -v '#' | xargs)
fi

# Stop existing containers
echo "⏹️  Stopping existing containers..."
docker-compose down

# Build and start new containers
echo "🔨 Building and starting containers..."
docker-compose up --build -d

# Wait for container to be ready
echo "⏳ Waiting for application to be ready..."
sleep 30

# Run Laravel commands
echo "🔧 Running Laravel setup commands..."
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Check container status
echo "✅ Checking container status..."
docker-compose ps

echo "🎉 Deployment completed!"
echo "📱 Application is running at: https://laravel.rajaprasetya.web.id"
echo "🔍 Check logs with: docker-compose logs -f app"

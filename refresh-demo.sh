#!/bin/bash

echo "🔄 Refreshing database with updated demo data..."

# Fresh migration and seeding
docker-compose exec app php artisan migrate:fresh --seed

echo ""
echo "✅ Database refreshed successfully!"
echo ""
echo "🔑 Demo Login Credentials:"
echo "Admin: admin@servisku.com / password"
echo "Teknisi 1: teknisi1@servisku.com / password"
echo "Teknisi 2: teknisi2@servisku.com / password"
echo ""
echo "📊 Demo Data Created:"
echo "- 3 Users (1 Admin, 2 Teknisi)"
echo "- 5 Customers"
echo "- 7 Form Services"
echo "- 7 Detail Services"
echo "- 8 Unit Services"
echo "- 7 Status Garansi"
echo ""
echo "🌐 Test API endpoints:"
echo "GET /api/form-services - List all form services with complete relations"
echo "GET /api/form-services/1 - Show specific form service with details"

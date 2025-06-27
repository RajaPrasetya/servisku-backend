# ServisKu Backend API

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![Docker](https://img.shields.io/badge/Docker-Ready-blue.svg)](https://docker.com)

## 📝 About ServisKu

ServisKu adalah sistem manajemen service elektronik yang memungkinkan admin dan teknisi untuk mengelola form service dengan data relasional yang lengkap. Sistem ini menyediakan API yang robust untuk manajemen customer, user, dan form service dengan fitur authentication dan authorization berbasis role.

## ✨ Key Features

### 🔐 Authentication & Authorization
- **JWT Token-based authentication** dengan Laravel Sanctum
- **Role-based access control** (Admin, Teknisi)
- **Token validation endpoint** untuk mengecek validitas token
- **Multi-user support** dengan roles yang berbeda

### 📋 Form Service Management
- **Single endpoint creation** untuk form service lengkap
- **Complete relational data** (detail_service, unit_services, status_garansi)
- **Database transactions** untuk konsistensi data
- **Multiple units support** dalam satu form service
- **Auto-generated form numbers**

### 👥 User & Customer Management
- **Customer management** dengan search dan statistics
- **User management** dengan role assignment
- **Profile management** untuk authenticated users

### 📊 Advanced Features
- **Statistics and reporting** untuk admin
- **Search and filtering** pada semua endpoints
- **Pagination support** untuk large datasets
- **Error handling** dengan response yang konsisten

## 🚀 API Endpoints

### Authentication
```
POST   /api/login              # User login
GET    /api/validate-token     # Validate token validity
POST   /api/logout             # User logout
GET    /api/profile            # Get user profile
POST   /api/refresh-token      # Refresh authentication token
```

### Form Services
```
POST   /api/form-services      # Create complete form service (Admin & Teknisi)
GET    /api/form-services      # List all form services (Admin)
GET    /api/form-services/{id} # Get specific form service
PUT    /api/form-services/{id} # Update form service (Admin)
DELETE /api/form-services/{id} # Delete form service (Admin)
GET    /api/form-services/statistics # Get statistics (Admin)
```

### Customers
```
GET    /api/customers          # List customers
POST   /api/customers          # Create customer
GET    /api/customers/{id}     # Get specific customer
PUT    /api/customers/{id}     # Update customer
DELETE /api/customers/{id}     # Delete customer
GET    /api/customers/search   # Search customers
GET    /api/customers/statistics # Customer statistics
```

## 🔧 Installation & Setup

### Using Docker (Recommended)

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd servisku-backend
   ```

2. **Environment setup**
   ```bash
   cp .env.docker .env
   # Edit .env with your configuration
   ```

3. **Build and run with Docker**
   ```bash
   # Build and start containers
   docker-compose up -d --build
   
   # Install dependencies
   docker-compose exec app composer install
   
   # Generate application key
   docker-compose exec app php artisan key:generate
   
   # Run migrations
   docker-compose exec app php artisan migrate
   
   # Seed demo data
   docker-compose exec app php artisan db:seed --class=DemoSeeder
   ```

### Manual Installation

1. **Requirements**
   - PHP 8.1+
   - MySQL 5.7+
   - Composer
   - Node.js & NPM

2. **Setup**
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   php artisan db:seed --class=DemoSeeder
   php artisan serve
   ```

## 📚 Documentation

### API Documentation Files
- `API_RESPONSE_HELPER.md` - Response format standards
- `COMPLETE_FORM_SERVICE_API.md` - Complete form service endpoint
- `TOKEN_VALIDATION_API.md` - Token validation endpoint
- `CUSTOMER_API.md` - Customer management API
- `POSTMAN_COLLECTION_GUIDE.md` - Postman collection guide

### Database Documentation
- `FORMSERVICE_PRODUCTION_READY.md` - Production deployment guide
- `SINGLE_ENDPOINT_SUMMARY.md` - Single endpoint implementation

## 🧪 Testing

### Using Postman
1. Import `ServisKu_API_Collection.postman_collection.json`
2. Import `ServisKu_Environment.postman_environment.json`
3. Set environment variables (base_url, etc.)
4. Test authentication and API endpoints

### Demo Users
```
Admin:
- Email: admin@servisku.com
- Password: password

Teknisi 1:
- Email: teknisi1@servisku.com
- Password: password

Teknisi 2:
- Email: teknisi2@servisku.com
- Password: password
```

## 🐳 Docker Management

### Available Scripts
```bash
# Start services
./manage.sh start

# Stop services
./manage.sh stop

# Deploy to production
./deploy.sh

# Refresh demo data
./refresh-demo.sh
```

## 🔒 Security Features

- **Token-based authentication** dengan expiration
- **Role-based authorization** middleware
- **Input validation** pada semua endpoints
- **SQL injection protection** dengan Eloquent ORM
- **Error handling** tanpa information disclosure

## 📊 Production Deployment

### Environment Requirements
- **Docker & Docker Compose**
- **Nginx** untuk reverse proxy
- **SSL Certificate** untuk HTTPS
- **MySQL** database server

### Deployment Steps
1. Setup server dengan Docker
2. Configure Nginx dengan SSL
3. Run deployment script: `./deploy.sh`
4. Configure environment variables
5. Run database migrations dan seeding

## 🛠️ Development

### Code Structure
```
app/
├── Http/Controllers/    # API Controllers
├── Models/             # Eloquent Models
├── Http/Resources/     # API Resources
├── Http/Requests/      # Form Requests
├── Middleware/         # Custom Middleware
└── Traits/            # Reusable Traits

database/
├── migrations/        # Database migrations
├── seeders/          # Data seeders
└── factories/        # Model factories
```

### Key Components
- **ApiResponseTrait** - Consistent API responses
- **RoleMiddleware** - Role-based access control
- **FormServiceResource** - Complete relational data formatting
- **DemoSeeder** - Production-ready demo data

## 📝 License

This project is proprietary software. All rights reserved.

## 🤝 Support

For technical support or questions about the API, please contact the development team.

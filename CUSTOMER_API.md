# Customer API Documentation

## Overview
API untuk mengelola data customer di aplikasi ServisKu Backend.

## Model Structure
- **Primary Key**: `id_customer` (auto increment)
- **Fields**: 
  - `nama` (string, 255) - Nama customer
  - `no_telp` (string, 20) - Nomor telepon
  - `alamat` (text, 500) - Alamat lengkap
- **Relations**: 
  - hasMany FormServices

## API Endpoints

### Authentication Required
Semua endpoint memerlukan authentication dengan Sanctum token:
```
Authorization: Bearer {token}
```

### Role-Based Access
- **Admin & Teknisi**: Full access to customer data
- Customer data dapat diakses oleh semua authenticated users

## Endpoints

### 1. Get All Customers
```http
GET /api/customers
```

**Query Parameters:**
- `search` (optional): Search by nama, no_telp, or alamat
- `nama` (optional): Filter by nama (partial match)
- `no_telp` (optional): Filter by no_telp (partial match)
- `with_services` (optional): Include form services data (true/false)
- `per_page` (optional): Items per page (default: 10)

**Response:**
```json
{
    "success": true,
    "message": "Customers retrieved successfully",
    "data": [
        {
            "id_customer": 1,
            "nama": "John Doe",
            "no_telp": "08123456789",
            "alamat": "Jl. Contoh No. 123, Jakarta",
            "created_at": "2025-06-26 10:00:00",
            "updated_at": "2025-06-26 10:00:00",
            "form_services": null,
            "total_services": null
        }
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 10,
        "total": 50,
        "from": 1,
        "to": 10,
        "has_more_pages": true
    }
}
```

### 2. Create Customer
```http
POST /api/customers
```

**Request Body:**
```json
{
    "nama": "John Doe",
    "no_telp": "08123456789",
    "alamat": "Jl. Contoh No. 123, Jakarta"
}
```

**Validation Rules:**
- `nama`: required, string, max 255 characters
- `no_telp`: required, string, max 20 characters
- `alamat`: required, string, max 500 characters

**Response (201):**
```json
{
    "success": true,
    "message": "Customer created successfully",
    "data": {
        "id_customer": 1,
        "nama": "John Doe",
        "no_telp": "08123456789",
        "alamat": "Jl. Contoh No. 123, Jakarta",
        "created_at": "2025-06-26 10:00:00",
        "updated_at": "2025-06-26 10:00:00"
    }
}
```

### 3. Get Single Customer
```http
GET /api/customers/{id_customer}
```

**Query Parameters:**
- `with_services` (optional): Include form services data (true/false)

**Response:**
```json
{
    "success": true,
    "message": "Customer retrieved successfully",
    "data": {
        "id_customer": 1,
        "nama": "John Doe",
        "no_telp": "08123456789",
        "alamat": "Jl. Contoh No. 123, Jakarta",
        "created_at": "2025-06-26 10:00:00",
        "updated_at": "2025-06-26 10:00:00",
        "form_services": [
            {
                "no_form": 1,
                "status": "diterima",
                "created_at": "2025-06-26 10:30:00"
            }
        ],
        "total_services": 1
    }
}
```

### 4. Update Customer
```http
PUT /api/customers/{id_customer}
```

**Request Body (all optional):**
```json
{
    "nama": "John Doe Updated",
    "no_telp": "08123456789",
    "alamat": "Jl. Contoh No. 456, Jakarta"
}
```

**Validation Rules:**
- `nama`: optional, string, max 255 characters
- `no_telp`: optional, string, max 20 characters
- `alamat`: optional, string, max 500 characters

### 5. Delete Customer
```http
DELETE /api/customers/{id_customer}
```

**Note:** Customer cannot be deleted if they have existing form services.

**Response (200):**
```json
{
    "success": true,
    "message": "Customer deleted successfully",
    "data": null
}
```

**Response (400) - Has Services:**
```json
{
    "success": false,
    "message": "Cannot delete customer. Customer has existing form services."
}
```

### 6. Search Customers
```http
GET /api/customers/search
```

**Query Parameters:**
- `q` (required): Search query (minimum 2 characters)
- `fields` (optional): Array of fields to search in ['nama', 'no_telp', 'alamat']
- `per_page` (optional): Items per page (default: 10)

**Example:**
```
GET /api/customers/search?q=john&fields[]=nama&fields[]=no_telp
```

### 7. Customer Statistics
```http
GET /api/customers/statistics
```

**Response:**
```json
{
    "success": true,
    "message": "Customer statistics retrieved successfully",
    "data": {
        "total_customers": 150,
        "customers_today": 5,
        "customers_this_month": 25,
        "customers_with_services": 120,
        "customers_without_services": 30
    }
}
```

### 8. Get Customer Form Services
```http
GET /api/customers/{customerId}/form-services
```

**Query Parameters:**
- `status` (optional): Filter by status
- `per_page` (optional): Items per page

## Fixed Issues
✅ **Model**: Added proper primary key (`id_customer`)
✅ **Migration**: Updated columns to match actual usage (`nama`, `no_telp`, `alamat`)
✅ **Validation**: Complete validation with custom error messages
✅ **Resource**: API resource transformation with optional relationships
✅ **Controller**: Enhanced with search, filtering, and statistics
✅ **Routes**: Added search and statistics endpoints
✅ **Error Handling**: Proper error handling and prevention of cascading deletes

## Error Responses

### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "nama": ["Nama customer wajib diisi"],
        "no_telp": ["Nomor telepon maksimal 20 karakter"]
    }
}
```

### Not Found (404)
```json
{
    "success": false,
    "message": "Resource not found"
}
```

### Server Error (500)
```json
{
    "success": false,
    "message": "Failed to create customer: [error details]"
}
```

## Features
- ✅ Full CRUD operations
- ✅ Advanced search and filtering
- ✅ Input validation with Indonesian messages
- ✅ Resource transformation
- ✅ Statistics endpoint
- ✅ Relationship management
- ✅ Pagination support
- ✅ Prevention of cascading deletes
- ✅ Error handling
- ✅ Route model binding with custom primary key

## Database Migration Required
Run migration to update customer table structure:
```bash
php artisan migrate:fresh
```

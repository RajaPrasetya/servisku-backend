# Form Service API Documentation

## Overview
API untuk mengelola form layanan (form services) di aplikasi ServisKu Backend.

## Model Structure
- **Primary Key**: `no_form` (auto increment)
- **Status**: `diterima`, `proses`, `selesai`
- **Relations**: 
  - belongsTo Customer (`id_customer`)
  - belongsTo User/Teknisi (`id_user`)
  - hasOne DetailService
  - hasMany UnitServices

## API Endpoints

### Authentication Required
Semua endpoint memerlukan authentication dengan Sanctum token:
```
Authorization: Bearer {token}
```

### Role-Based Access

#### Admin Access (role: admin)
- Full CRUD access to all form services
- Access to statistics

#### Teknisi Access (role: teknisi)
- Read access to assigned form services
- Update status of assigned form services

#### General Access (auth required)
- Read form services by customer
- Read form services by user

## Endpoints

### 1. Get All Form Services
**Admin Only**
```http
GET /api/form-services
```

**Query Parameters:**
- `status` (optional): Filter by status (`diterima`, `proses`, `selesai`)
- `id_customer` (optional): Filter by customer ID
- `id_user` (optional): Filter by user/teknisi ID
- `search` (optional): Search by customer name or user name
- `per_page` (optional): Items per page (default: 10)

**Response:**
```json
{
    "success": true,
    "message": "Form services retrieved successfully",
    "data": [
        {
            "no_form": 1,
            "status": "diterima",
            "status_label": "Diterima",
            "created_at": "2025-06-26 10:00:00",
            "updated_at": "2025-06-26 10:00:00",
            "customer": {
                "id_customer": 1,
                "nama": "John Doe",
                "no_telp": "08123456789",
                "alamat": "Jl. Contoh No. 123"
            },
            "user": {
                "id_user": 1,
                "name": "Teknisi 1",
                "email": "teknisi@example.com",
                "phone": "08111111111",
                "role": "teknisi"
            },
            "detail_service": null
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

### 2. Create Form Service
**Admin Only**
```http
POST /api/form-services
```

**Request Body:**
```json
{
    "status": "diterima",
    "id_customer": 1,
    "id_user": 1
}
```

**Validation Rules:**
- `status`: optional, enum (`diterima`, `proses`, `selesai`)
- `id_customer`: required, must exist in customers table
- `id_user`: required, must exist in users table

### 3. Get Single Form Service
**Admin Only**
```http
GET /api/form-services/{no_form}
```

### 4. Update Form Service
**Admin Only**
```http
PUT /api/form-services/{no_form}
```

**Request Body:**
```json
{
    "status": "proses",
    "id_customer": 1,
    "id_user": 2
}
```

### 5. Delete Form Service
**Admin Only**
```http
DELETE /api/form-services/{no_form}
```

### 6. Get Form Services by Customer
**Authenticated Users**
```http
GET /api/customers/{customerId}/form-services
```

**Query Parameters:**
- `status` (optional): Filter by status
- `per_page` (optional): Items per page

### 7. Get Form Services by User/Teknisi
**Authenticated Users**
```http
GET /api/users/{userId}/form-services
```

**Query Parameters:**
- `status` (optional): Filter by status
- `per_page` (optional): Items per page

### 8. Update Form Service Status
**Teknisi Only**
```http
PUT /api/teknisi/form-services/{no_form}/status
```

**Request Body:**
```json
{
    "status": "selesai"
}
```

### 9. Get Form Services for Teknisi
**Teknisi Only**
```http
GET /api/teknisi/form-services
```

**Query Parameters:** Same as general index

### 10. Get Single Form Service for Teknisi
**Teknisi Only**
```http
GET /api/teknisi/form-services/{no_form}
```

### 11. Get Form Service Statistics
**Admin Only**
```http
GET /api/form-services/statistics
```

**Response:**
```json
{
    "success": true,
    "message": "Form service statistics retrieved successfully",
    "data": {
        "total": 150,
        "diterima": 45,
        "proses": 30,
        "selesai": 75,
        "today": 5,
        "this_month": 25
    }
}
```

## Status Flow
1. **diterima** → **proses** → **selesai**
2. Status dapat diupdate oleh:
   - Admin: semua status
   - Teknisi: hanya form service yang ditugaskan kepadanya

## Error Responses

### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "id_customer": ["Customer tidak ditemukan"],
        "status": ["Status harus berupa: diterima, proses, atau selesai"]
    }
}
```

### Unauthorized (401)
```json
{
    "success": false,
    "message": "Unauthorized. Please login first."
}
```

### Forbidden (403)
```json
{
    "success": false,
    "message": "Forbidden. You do not have permission to access this resource.",
    "required_role": "admin",
    "your_role": "teknisi"
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
    "message": "Failed to create form service: [error details]"
}
```

## Features
- ✅ Role-based access control
- ✅ Input validation with custom messages
- ✅ Comprehensive filtering and search
- ✅ Pagination support
- ✅ Resource transformation
- ✅ Error handling
- ✅ Statistics endpoint
- ✅ Status management
- ✅ Relationship loading

## Best Practices
1. Always include `Authorization` header with Bearer token
2. Use appropriate HTTP methods (GET, POST, PUT, DELETE)
3. Handle pagination for large datasets
4. Check user role before accessing restricted endpoints
5. Validate input data before submission
6. Handle error responses appropriately in frontend

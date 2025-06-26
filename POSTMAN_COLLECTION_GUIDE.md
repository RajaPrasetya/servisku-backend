# ServisKu API Postman Collection 📮

## 📋 **Overview**
Complete Postman collection untuk testing ServisKu Backend API dengan authentication, customer management, dan form service management.

## 📁 **Files**
- `ServisKu_API_Collection.postman_collection.json` - Main collection file
- `ServisKu_Environment.postman_environment.json` - Environment variables

## 🚀 **Setup Instructions**

### 1. **Import Collection**
1. Buka Postman
2. Click **Import** button
3. Drag & drop atau pilih file `ServisKu_API_Collection.postman_collection.json`
4. Click **Import**

### 2. **Import Environment**
1. Click gear icon (⚙️) di pojok kanan atas
2. Click **Import**
3. Pilih file `ServisKu_Environment.postman_environment.json`
4. Click **Import**
5. Select environment "ServisKu Environment"

### 3. **Set Base URL**
Update environment variable `base_url`:
- **Local Development**: `http://localhost:8000/api`
- **Production**: `https://yourdomain.com/api`

### 4. **Set Authentication Token**
1. Dapatkan token dari login endpoint atau database
2. Set variable `auth_token` dengan Bearer token Anda
3. Token akan otomatis diterapkan ke semua requests

## 📊 **Collection Structure**

### 🔐 **Authentication**
- **Get User Profile** - Get current authenticated user
- **Get Profile with Role** - Get user profile dengan role information

### 👑 **Admin Routes**
- **Admin Dashboard** - Test admin access
- **Get All Users** - List all users (admin only)

### 🔧 **Teknisi Routes**
- **Teknisi Dashboard** - Test teknisi access
- **Get Teknisi Services** - Test teknisi services access

### 👥 **Customer Management**
- **Get All Customers** - List customers dengan filtering
- **Create Customer** - Create new customer
- **Get Single Customer** - Get customer by ID
- **Update Customer** - Update customer data
- **Delete Customer** - Delete customer
- **Search Customers** - Advanced customer search
- **Customer Statistics** - Get customer statistics

### 📋 **Form Service Management (Admin)**
- **Get Form Service Statistics** - Service statistics
- **Get All Form Services** - List all form services
- **Create Form Service** - Create new form service
- **Get Single Form Service** - Get form service by ID
- **Update Form Service** - Update form service
- **Delete Form Service** - Delete form service

### 🔧 **Form Service Management (Teknisi)**
- **Get Assigned Form Services** - List assigned services
- **Get Single Form Service** - Get assigned service detail
- **Update Form Service Status** - Update service status

### 🔗 **Relationship Queries**
- **Get Customer Form Services** - Services by customer
- **Get User Form Services** - Services by user/teknisi

### ❌ **Error Testing**
- **Unauthorized Access** - Test tanpa token
- **Forbidden Access** - Test wrong role access
- **Validation Error** - Test validation errors
- **Not Found** - Test non-existent resources

## 🔧 **Environment Variables**

| Variable | Description | Example |
|----------|-------------|---------|
| `base_url` | API base URL | `http://localhost:8000/api` |
| `auth_token` | Bearer authentication token | `your-sanctum-token-here` |
| `customer_id` | Customer ID for testing | `1` |
| `form_service_id` | Form Service ID for testing | `1` |
| `user_id` | User ID for testing | `1` |

## 📝 **Usage Guide**

### **Step 1: Authentication**
1. Set `auth_token` variable dengan valid token
2. Test dengan "Get User Profile" request
3. Verify role dengan "Get Profile with Role"

### **Step 2: Test Role Access**
1. **Admin Role**: Test admin dashboard dan admin endpoints
2. **Teknisi Role**: Test teknisi dashboard dan teknisi endpoints

### **Step 3: Test Customer CRUD**
1. Create customer dengan "Create Customer"
2. Update `customer_id` variable dengan ID yang baru dibuat
3. Test Get, Update, Delete operations
4. Test search dan statistics

### **Step 4: Test Form Service Management**
1. **Admin**: Test full CRUD operations
2. **Teknisi**: Test assigned services dan status updates
3. Test relationship queries

### **Step 5: Test Error Scenarios**
1. Test unauthorized access (tanpa token)
2. Test forbidden access (wrong role)
3. Test validation errors (invalid data)
4. Test not found errors (non-existent IDs)

## 🎯 **Testing Scenarios**

### **Admin User Testing:**
```
1. Set auth_token dengan admin token
2. Test: Admin Dashboard ✅
3. Test: Get All Form Services ✅
4. Test: Create Form Service ✅
5. Test: Form Service Statistics ✅
6. Test: Customer Management ✅
```

### **Teknisi User Testing:**
```
1. Set auth_token dengan teknisi token
2. Test: Teknisi Dashboard ✅
3. Test: Get Assigned Services ✅
4. Test: Update Service Status ✅
5. Test: Admin Dashboard ❌ (Should get 403)
```

### **Error Testing:**
```
1. Remove auth_token
2. Test: Any protected endpoint ❌ (Should get 401)
3. Set teknisi token
4. Test: Admin endpoint ❌ (Should get 403)
5. Send invalid data
6. Test: Create Customer ❌ (Should get 422)
```

## 🔍 **Query Parameters**

### **Customer Endpoints:**
- `per_page` - Items per page (default: 10)
- `with_services` - Include form services (true/false)
- `search` - Search term
- `nama` - Filter by name
- `no_telp` - Filter by phone

### **Form Service Endpoints:**
- `per_page` - Items per page (default: 10)
- `status` - Filter by status (diterima/proses/selesai)
- `id_customer` - Filter by customer
- `id_user` - Filter by teknisi
- `search` - Search by customer/user name

## 📊 **Expected Response Format**

### **Success Response:**
```json
{
    "success": true,
    "message": "Data retrieved successfully",
    "data": [...],
    "pagination": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 10,
        "total": 50
    }
}
```

### **Error Response:**
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        "field": ["Error detail"]
    }
}
```

## 🎯 **HTTP Status Codes**
- `200` - OK
- `201` - Created
- `204` - No Content
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

## 🚀 **Quick Start Checklist**

### Before Testing:
- ✅ Laravel server running (`php artisan serve`)
- ✅ Database migrated (`php artisan migrate`)
- ✅ Postman collection imported
- ✅ Environment configured
- ✅ Auth token set

### Test Sequence:
1. ✅ Authentication endpoints
2. ✅ Role-based access
3. ✅ Customer CRUD operations
4. ✅ Form Service operations
5. ✅ Error scenarios
6. ✅ Relationship queries

## 🎉 **Collection Features**

### ✅ **Complete Coverage:**
- All API endpoints included
- Role-based testing
- Error scenario testing
- Relationship testing

### ✅ **Easy Configuration:**
- Environment variables
- Automatic token authentication
- Configurable base URL
- Dynamic ID variables

### ✅ **Production Ready:**
- Proper error handling testing
- Security testing
- Performance testing queries
- Complete CRUD workflows

## 🔧 **Troubleshooting**

### **Common Issues:**
1. **401 Unauthorized**: Check auth_token variable
2. **403 Forbidden**: Check user role permissions
3. **404 Not Found**: Check endpoint URLs and IDs
4. **422 Validation Error**: Check request body format
5. **500 Server Error**: Check Laravel server logs

### **Debug Tips:**
- Enable Postman Console untuk detailed logs
- Check Laravel logs: `storage/logs/laravel.log`
- Verify database data dengan Artisan Tinker
- Test endpoints satu per satu

Happy Testing! 🎊

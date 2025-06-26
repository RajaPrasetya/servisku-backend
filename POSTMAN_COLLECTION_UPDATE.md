# Postman Collection Update Guide

## Perubahan Terbaru

### 1. Authentication Endpoints Baru

Sekarang tersedia endpoint authentication lengkap:

#### **Login**
- **Method**: POST
- **URL**: `{{base_url}}/login`
- **Body (JSON)**:
```json
{
    "email": "admin@servisku.com",
    "password": "password"
}
```
- **Response**: Akan menyimpan token otomatis ke environment variable `auth_token`

#### **Logout**
- **Method**: POST
- **URL**: `{{base_url}}/logout`
- **Headers**: Bearer Token

#### **Get Profile**
- **Method**: GET
- **URL**: `{{base_url}}/profile`
- **Headers**: Bearer Token

#### **Refresh Token**
- **Method**: POST
- **URL**: `{{base_url}}/refresh-token`
- **Headers**: Bearer Token
- **Response**: Akan memperbarui token di environment variable `auth_token`

### 2. Multiple Login Options

Collection sekarang menyediakan 3 opsi login siap pakai:

1. **Login as Admin**
   - Email: `admin@servisku.com`
   - Password: `password`
   - Role: `admin`

2. **Login as Teknisi 1**
   - Email: `teknisi1@servisku.com`
   - Password: `password`
   - Role: `teknisi`

3. **Login as Teknisi 2**
   - Email: `teknisi2@servisku.com`
   - Password: `password`
   - Role: `teknisi`

### 3. Environment Variables Baru

Environment sekarang include:

- `admin_email`: admin@servisku.com
- `teknisi1_email`: teknisi1@servisku.com
- `teknisi2_email`: teknisi2@servisku.com
- `default_password`: password

### 4. Auto Token Management

Semua endpoint login memiliki script yang otomatis:
- Mengambil token dari response
- Menyimpan ke environment variable `auth_token`
- Dapat langsung digunakan untuk request selanjutnya

## Cara Menggunakan

### Step 1: Import Collection dan Environment
1. Import `ServisKu_API_Collection.postman_collection.json`
2. Import `ServisKu_Environment.postman_environment.json`
3. Set environment aktif ke "ServisKu Environment"

### Step 2: Setup Database
```bash
php artisan db:seed --class=DemoSeeder
```

### Step 3: Login
1. Pilih salah satu dari 3 login options
2. Send request
3. Token akan tersimpan otomatis
4. Semua request berikutnya akan menggunakan token ini

### Step 4: Test API
Sekarang semua endpoint lain dapat digunakan karena token sudah tersimpan.

## Testing Flow yang Disarankan

1. **Login as Admin** → Test admin routes
2. **Login as Teknisi 1** → Test teknisi routes  
3. **Login as Teknisi 2** → Test teknisi routes dengan user berbeda
4. **Logout** → Test token revocation
5. **Refresh Token** → Test token renewal

## Notes

- Token disimpan sebagai `secret` type di environment untuk security
- Semua authenticated requests menggunakan Bearer token dari variable `{{auth_token}}`
- Login requests tidak menggunakan authentication (noauth)
- Test scripts otomatis handle token management

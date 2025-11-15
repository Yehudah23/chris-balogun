# Admin Authentication System - Complete Setup ✅

## Overview
A complete admin authentication and file management system with:
- **Login page** with admin-only access
- **Admin panel** for CV and Publications management
- **Laravel Sanctum** authentication with tokens
- **File upload/download/delete** functionality

---

## 🎉 What's Been Created

### Frontend Components
1. **LogIn.vue** (`resources/js/components/LogIn.vue`)
   - Beautiful gradient login form
   - Admin-only authentication check
   - Real-time validation and loading states
   - Auto-redirect to admin panel on success

2. **AdminView.vue** (`resources/js/components/AdminView.vue`)
   - Tabbed interface for CV and Publications
   - File upload with title
   - List existing uploads with delete option
   - Redirects to login if not authenticated

### Backend (Laravel)
1. **AuthController** (`app/Http/Controllers/Api/AuthController.php`)
   - `POST /api/login` - Authenticate admin users
   - `POST /api/logout` - Revoke tokens
   - `GET /api/me` - Get current user
   - Returns Sanctum token on successful login

2. **DocumentController** (`app/Http/Controllers/Api/DocumentController.php`)
   - `GET /api/documents` - List all documents (filtered by type)
   - `POST /api/documents` - Upload document (auth required)
   - `DELETE /api/documents/{id}` - Delete document (auth required)

3. **Database**
   - `users` table - Added `is_admin` boolean column
   - `documents` table - Stores file metadata
   - **Test admin user created**: `admin@admin.com` / `password`

### Routes
- **GET /login** - Login page
- **GET /admin** - Admin panel (client-side protected)
- **POST /api/login** - Login API endpoint
- **POST /api/logout** - Logout API endpoint
- **GET /api/me** - Get authenticated user
- **GET /api/documents** - List documents
- **POST /api/documents** - Upload document
- **DELETE /api/documents/{id}** - Delete document

---

## 🚀 Quick Start

### 1. Start Laravel Server
```bash
php artisan serve
```

Server runs at: **http://127.0.0.1:8000**

### 2. Login as Admin
Visit: **http://127.0.0.1:8000/login**

**Test Credentials:**
- Email: `admin@admin.com`
- Password: `password`

### 3. Access Admin Panel
After login, you'll be redirected to: **http://127.0.0.1:8000/admin**

### 4. Upload Files
- Switch between CV and Publications tabs
- Enter optional title
- Select file (PDF, DOC, images, etc.)
- Click upload
- Files appear in the list below
- Click delete to remove

---

## 📁 File Structure

```
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── AuthController.php       # Login/Logout/Me endpoints
│   │   └── DocumentController.php   # Document CRUD operations
│   └── Models/
│       ├── User.php                 # Added is_admin field
│       └── Document.php             # Document model with file_url
├── database/
│   ├── migrations/
│   │   ├── 2025_11_14_000000_create_documents_table.php
│   │   └── 2025_11_14_080443_add_is_admin_to_users_table.php
│   └── seeders/
│       └── AdminUserSeeder.php      # Creates test admin user
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   ├── AdminView.vue        # Admin panel component
│   │   │   └── LogIn.vue            # Login form component
│   │   ├── app.js                   # Vue app entry (mounts both components)
│   │   └── bootstrap.js             # Axios config
│   └── views/
│       ├── admin.blade.php          # Admin panel page
│       └── login.blade.php          # Login page
├── routes/
│   ├── api.php                      # API routes (auth + documents)
│   └── web.php                      # Web routes (login + admin pages)
└── storage/app/public/uploads/      # Uploaded files stored here
    ├── cvs/
    └── publications/
```

---

## 🔐 Authentication Flow

### Login Process
1. User enters email/password on `/login`
2. Frontend sends `POST /api/login` request
3. Backend validates credentials and checks `is_admin` field
4. If admin, returns user data with Sanctum token
5. Frontend stores user + token in `localStorage.laraveluser`
6. Redirects to `/admin`

### Admin Panel Access
1. AdminView component reads `localStorage.laraveluser`
2. Checks if user has `is_admin === true`
3. If not admin or not logged in, redirects to `/login`
4. If admin, shows upload interface

### API Requests
All protected API calls include:
```javascript
headers: {
  Authorization: 'Bearer ' + user.token
}
```

---

## 📡 API Documentation

### POST /api/login
**Request:**
```json
{
  "email": "admin@admin.com",
  "password": "password"
}
```

**Success Response (status 202):**
```json
{
  "status": 202,
  "msg": "Login successful",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@admin.com",
    "is_admin": 1,
    "token": "1|abc123...",
    "access_token": "1|abc123...",
    "api_token": "1|abc123..."
  }
}
```

**Error Response (status 201):**
```json
{
  "status": 201,
  "msg": "Invalid email or password"
}
```

### POST /api/documents
**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Body:**
- `file` (file) - The file to upload
- `type` (string) - 'cv' or 'publication'
- `title` (string, optional) - Document title

**Response:**
```json
{
  "msg": "Uploaded",
  "document": {
    "id": 1,
    "title": "My CV",
    "type": "cv",
    "path": "uploads/cvs/xyz.pdf",
    "original_name": "resume.pdf",
    "mime": "application/pdf",
    "size": 152400,
    "file_url": "http://127.0.0.1:8000/storage/uploads/cvs/xyz.pdf"
  }
}
```

### GET /api/documents
**Query Parameters:**
- `type` (optional) - Filter by 'cv' or 'publication'

**Examples:**
```bash
# Get all documents
curl http://127.0.0.1:8000/api/documents

# Get CVs only
curl http://127.0.0.1:8000/api/documents?type=cv

# Get Publications only
curl http://127.0.0.1:8000/api/documents?type=publication
```

**Response:**
```json
[
  {
    "id": 1,
    "title": "My CV",
    "type": "cv",
    "path": "uploads/cvs/xyz.pdf",
    "original_name": "resume.pdf",
    "mime": "application/pdf",
    "size": 152400,
    "file_url": "http://127.0.0.1:8000/storage/uploads/cvs/xyz.pdf",
    "created_at": "2025-11-14T08:00:00.000000Z",
    "updated_at": "2025-11-14T08:00:00.000000Z"
  }
]
```

### DELETE /api/documents/{id}
**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "msg": "Deleted"
}
```

### POST /api/logout
**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "status": 200,
  "msg": "Logged out successfully"
}
```

### GET /api/me
**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "status": 200,
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@admin.com",
    "is_admin": 1,
    "email_verified_at": null,
    "created_at": "2025-11-14T08:00:00.000000Z",
    "updated_at": "2025-11-14T08:00:00.000000Z"
  }
}
```

---

## 🔧 Configuration

### Database (MySQL)
Located in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### Laravel Sanctum
Sanctum is configured and ready to use. Token expiration and middleware are set up.

### File Storage
Files are stored in:
- **Physical location:** `storage/app/public/uploads/`
- **Public URL:** `http://127.0.0.1:8000/storage/uploads/`
- **Symlink:** `public/storage` → `storage/app/public` (already created)

---

## 👨‍💼 Managing Admin Users

### Create Admin User via Seeder
```bash
php artisan db:seed --class=AdminUserSeeder
```

### Create Admin User Manually (MySQL)
```bash
# Using tinker
php artisan tinker

# Then run:
$user = new App\Models\User();
$user->name = 'New Admin';
$user->email = 'newadmin@example.com';
$user->password = Hash::make('password123');
$user->is_admin = true;
$user->save();
```

### Update Existing User to Admin
```bash
php artisan tinker

# Then:
$user = App\Models\User::where('email', 'user@example.com')->first();
$user->is_admin = true;
$user->save();
```

### Using MySQL directly
```sql
-- Create new admin user
INSERT INTO users (name, email, password, is_admin, created_at, updated_at)
VALUES ('Admin', 'admin2@admin.com', '$2y$10$encrypted_password_here', 1, NOW(), NOW());

-- Make existing user an admin
UPDATE users SET is_admin = 1 WHERE email = 'user@example.com';
```

---

## 🧪 Testing the System

### Test Login Flow
1. Visit http://127.0.0.1:8000/login
2. Enter: `admin@admin.com` / `password`
3. Should redirect to `/admin` with success message
4. Check browser console for user object
5. Check `localStorage.laraveluser` in DevTools

### Test Upload
1. Login first
2. Go to Admin panel
3. Select CV tab
4. Enter title (optional)
5. Choose a file
6. Click "Upload CV"
7. File should appear in list below
8. Click delete button to test deletion

### Test API with cURL
```bash
# 1. Login and get token
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@admin.com","password":"password"}'

# Copy the token from response

# 2. Upload file
curl -X POST http://127.0.0.1:8000/api/documents \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "file=@/path/to/file.pdf" \
  -F "type=cv" \
  -F "title=Test CV"

# 3. List documents
curl http://127.0.0.1:8000/api/documents

# 4. Delete document (replace 1 with actual ID)
curl -X DELETE http://127.0.0.1:8000/api/documents/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 🛠 Development Commands

### Frontend
```bash
# Compile assets for development
npm run dev

# Watch for changes
npm run watch

# Production build
npm run prod
```

### Backend
```bash
# Start server
php artisan serve

# Run migrations
php artisan migrate

# Create storage symlink
php artisan storage:link

# Seed admin user
php artisan db:seed --class=AdminUserSeeder

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## 🐛 Troubleshooting

### "Access denied for user 'root'@'localhost'"
- Solution: MySQL database `laravel` created ✅
- If still issues: Check MySQL is running

### "Unauthenticated" on file upload
- Check token is being sent in Authorization header
- Verify user is logged in (check localStorage)
- Ensure Sanctum is configured properly

### Files not accessible after upload
- Run: `php artisan storage:link` ✅ (already done)
- Check `storage/app/public/uploads/` directory exists
- Verify `public/storage` symlink exists

### Login always fails
- Check user exists: `SELECT * FROM users WHERE email = 'admin@admin.com';`
- Verify password is hashed correctly
- Check `is_admin` field is 1
- Look at network tab for response from `/api/login`

### Vue components not loading
- Run: `npm run dev` to compile assets ✅ (already done)
- Check `public/js/app.js` exists
- Clear browser cache
- Check console for JS errors

---

## 📊 Database Schema

### users table
```sql
id              BIGINT UNSIGNED PRIMARY KEY
name            VARCHAR(255)
email           VARCHAR(255) UNIQUE
email_verified_at TIMESTAMP NULL
password        VARCHAR(255)
is_admin        BOOLEAN DEFAULT FALSE  -- ← New field
remember_token  VARCHAR(100) NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### documents table
```sql
id              BIGINT UNSIGNED PRIMARY KEY
title           VARCHAR(255) NULL
type            VARCHAR(255) INDEX  -- 'cv' or 'publication'
path            VARCHAR(255)
original_name   VARCHAR(255) NULL
mime            VARCHAR(255) NULL
size            BIGINT NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### personal_access_tokens table (Sanctum)
```sql
id              BIGINT UNSIGNED PRIMARY KEY
tokenable_type  VARCHAR(255)
tokenable_id    BIGINT UNSIGNED
name            VARCHAR(255)
token           VARCHAR(64) UNIQUE
abilities       TEXT NULL
last_used_at    TIMESTAMP NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

---

## ✨ Features Summary

### Authentication
✅ Admin-only login page  
✅ Email/password authentication  
✅ Laravel Sanctum token generation  
✅ Protected API routes  
✅ Auto-redirect on login/logout  
✅ Client-side admin check  
✅ localStorage session persistence  

### File Management
✅ Upload CVs and Publications  
✅ Optional file titles  
✅ File type validation (frontend)  
✅ List existing uploads  
✅ Download files (click title)  
✅ Delete files  
✅ Separate folders for CVs/Publications  
✅ File metadata storage (name, size, mime)  

### UI/UX
✅ Beautiful gradient login form  
✅ Responsive design  
✅ Loading states  
✅ Success/error messages  
✅ Tabbed interface  
✅ Smooth animations  
✅ Hover effects  
✅ Emoji icons  

---

## 🎯 Next Steps (Optional Enhancements)

1. **Email Verification**
   - Send verification email on registration
   - Require verified email for admin login

2. **Password Reset**
   - Forgot password functionality
   - Email password reset link

3. **Multi-factor Authentication**
   - Add 2FA via Google Authenticator
   - SMS verification

4. **Admin Dashboard**
   - Show total uploads count
   - Recent activity log
   - Storage usage stats

5. **User Management**
   - Admin can create/edit/delete users
   - Assign admin roles
   - User activity logs

6. **Advanced File Features**
   - File preview (PDF/images)
   - Bulk upload
   - Drag and drop
   - Progress bars
   - File categories/tags

7. **Security Enhancements**
   - Rate limiting on login
   - IP-based access control
   - Failed login notifications
   - Session timeout

---

## 📝 Summary

**Everything is ready to use!** 🎉

**Test credentials:**
- Email: `admin@admin.com`
- Password: `password`

**Pages:**
- Login: http://127.0.0.1:8000/login
- Admin: http://127.0.0.1:8000/admin

**Commands to start:**
```bash
php artisan serve
```

Then visit the login page and start uploading files!

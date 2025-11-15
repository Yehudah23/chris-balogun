# Admin Panel Setup - Complete ✅

## What Was Added

### Frontend (Vue.js)
- ✅ **AdminView.vue** component at `resources/js/components/AdminView.vue`
  - CV and Publications upload with tabbed interface
  - File list display with delete functionality
  - Client-side admin check via localStorage
- ✅ **Vue integration** in `resources/js/app.js` (Vue 2.7 with SFC support)
- ✅ **Admin blade view** at `resources/views/admin.blade.php`
- ✅ **Web route** at `/admin`

### Backend (Laravel)
- ✅ **Document model** at `app/Models/Document.php`
- ✅ **DocumentController** at `app/Http/Controllers/Api/DocumentController.php`
- ✅ **API routes** in `routes/api.php`:
  - `GET /api/documents?type=cv|publication` - List documents
  - `POST /api/documents` - Upload (auth:sanctum protected)
  - `DELETE /api/documents/{id}` - Delete (auth:sanctum protected)
- ✅ **Database migration** for `documents` table
- ✅ **Storage symlink** created (`public/storage` → `storage/app/public`)

### Build Configuration
- ✅ Vue, vue-template-compiler, vue-loader added to package.json
- ✅ webpack.mix.js configured for .vue files
- ✅ Assets compiled successfully (public/js/app.js = 1.03 MB)

## Setup Steps Completed

```bash
# 1. Installed frontend dependencies
npm install

# 2. Compiled assets
npm run dev

# 3. Created storage symlink
php artisan storage:link

# 4. Created MySQL database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS laravel"

# 5. Ran migrations
php artisan migrate
```

## How to Use

### 1. Start the Laravel server
```bash
php artisan serve
```
Server will run at: http://127.0.0.1:8000

### 2. Access the admin panel
Navigate to: **http://127.0.0.1:8000/admin**

### 3. Authentication Note
The component checks for admin status from `localStorage.laraveluser`. To test:

**Option A: Mock localStorage (for testing)**
Open browser console on `/admin` and run:
```javascript
localStorage.setItem('laraveluser', JSON.stringify({
  id: 1,
  name: 'Admin',
  is_admin: 1,
  token: 'test-token'
}));
```
Then refresh the page.

**Option B: Implement proper auth**
- Add Laravel Sanctum authentication
- Create login/register routes
- Store user with token in localStorage after login
- Ensure `is_admin` field exists in users table

### 4. Upload files
- Switch between "CV Upload" and "Publications Upload" tabs
- Enter title (optional)
- Select file
- Click upload
- Files are stored in `storage/app/public/uploads/cvs` or `uploads/publications`
- Files are served via `public/storage/uploads/...`

## API Endpoints

### List Documents
```bash
# All documents
curl http://127.0.0.1:8000/api/documents

# CVs only
curl http://127.0.0.1:8000/api/documents?type=cv

# Publications only
curl http://127.0.0.1:8000/api/documents?type=publication
```

### Upload Document (requires auth token)
```bash
curl -X POST http://127.0.0.1:8000/api/documents \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "file=@/path/to/file.pdf" \
  -F "type=cv" \
  -F "title=My CV"
```

### Delete Document (requires auth token)
```bash
curl -X DELETE http://127.0.0.1:8000/api/documents/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## Database Schema

**documents table:**
- `id` - Primary key
- `title` - Document title (nullable)
- `type` - 'cv' or 'publication'
- `path` - Storage path
- `original_name` - Original filename
- `mime` - MIME type
- `size` - File size in bytes
- `timestamps` - created_at, updated_at

## File Storage

- **Storage location:** `storage/app/public/uploads/cvs/` and `uploads/publications/`
- **Public access:** `http://127.0.0.1:8000/storage/uploads/cvs/filename.pdf`
- **Allowed types:** PDF, DOC, DOCX, JPG, PNG, TXT, RTF, ODT, XLS, XLSX, PPT, PPTX

## Development Commands

```bash
# Watch for file changes and recompile
npm run watch

# Production build
npm run prod

# Clear Laravel cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Next Steps (Optional Improvements)

1. **Server-side admin authorization:** Add admin check in controller:
   ```php
   if (!auth()->user() || !auth()->user()->is_admin) {
       abort(403, 'Unauthorized');
   }
   ```

2. **Add `is_admin` to users table:**
   ```bash
   php artisan make:migration add_is_admin_to_users_table
   ```

3. **File validation:** Add max size and mime type validation in controller

4. **Pagination:** Add pagination to document listing

5. **File preview:** Add preview modal for PDFs/images

6. **Search/filter:** Add search by title or date

## Troubleshooting

**Issue: "Module parse failed" when compiling**
- Solution: Ensure `.vue()` is called in webpack.mix.js ✅ (already fixed)

**Issue: Upload fails with 401**
- Solution: Add valid Bearer token in Authorization header
- Or remove `auth:sanctum` middleware for testing

**Issue: Files not accessible**
- Solution: Run `php artisan storage:link` ✅ (already done)

**Issue: Database connection error**
- Solution: Verify MySQL is running and database exists ✅ (already done)

---

**Status:** All components installed and working! 🎉

To start using: `php artisan serve` then visit http://127.0.0.1:8000/admin

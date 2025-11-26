# Portfolio Laravel - نظام إدارة البروتوفوليو

نظام إدارة بروتوفوليو احترافي مبني بـ Laravel مع Dashboard إدمن كامل.

## المميزات

- ✅ Dashboard إدمن احترافي مع إحصائيات
- ✅ إدارة الملف الشخصي
- ✅ إدارة المهارات
- ✅ إدارة المشاريع مع معرض صور
- ✅ إدارة الشهادات
- ✅ إدارة روابط التواصل الاجتماعي
- ✅ إدارة الرسائل الواردة
- ✅ رفع الصور والملفات
- ✅ Validation كامل
- ✅ تصميم احترافي وحديث

## متطلبات التشغيل

- PHP >= 8.1
- Composer
- MySQL أو SQLite
- Node.js & NPM (لـ assets)

## التثبيت

1. **نسخ المشروع:**
```bash
cd /home/marwa-abd-el-whed/Downloads/cv/portfolio-laravel
```

2. **تثبيت Dependencies:**
```bash
composer install
npm install
```

3. **إعداد ملف البيئة:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **إنشاء قاعدة البيانات MySQL:**
```bash
mysql -u root -p
```
ثم في MySQL:
```sql
CREATE DATABASE portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

5. **تعديل ملف .env:**
افتح ملف `.env` وتأكد من وجود الإعدادات التالية:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```
**ملاحظة:** استبدل `your_mysql_password` بكلمة مرور MySQL الخاصة بك.

6. **تشغيل Migrations:**
```bash
php artisan migrate
```

7. **إنشاء Storage Link:**
```bash
php artisan storage:link
```

8. **تشغيل المشروع:**
```bash
php artisan serve
```

**ملاحظة:** تأكد من أن خدمة MySQL تعمل قبل تشغيل المشروع.

## استخدام Dashboard

1. افتح المتصفح على: `http://localhost:8000/admin/dashboard`
2. ابدأ بإضافة الملف الشخصي من قسم "الملف الشخصي"
3. أضف المهارات من قسم "المهارات"
4. أضف المشاريع من قسم "المشاريع"
5. أضف الشهادات من قسم "الشهادات"
6. أضف روابط التواصل من قسم "روابط التواصل"

## هيكل المشروع

```
portfolio-laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controllers للـ Dashboard
│   │   └── Frontend/       # Controllers للـ Frontend
│   └── Models/             # Models
├── database/
│   └── migrations/         # Migrations
├── resources/
│   └── views/
│       ├── admin/          # Views للـ Dashboard
│       ├── frontend/       # Views للـ Frontend
│       └── layouts/        # Layouts
├── routes/
│   └── web.php             # Routes
└── storage/
    └── app/
        └── public/         # الملفات المرفوعة
```

## Routes

### Frontend
- `/` - الصفحة الرئيسية

### Admin
- `/admin/dashboard` - لوحة التحكم
- `/admin/profile` - إدارة الملف الشخصي
- `/admin/skills` - إدارة المهارات
- `/admin/projects` - إدارة المشاريع
- `/admin/certificates` - إدارة الشهادات
- `/admin/contacts` - إدارة الرسائل
- `/admin/social-links` - إدارة روابط التواصل

## ملاحظات مهمة

1. **رفع الصور:**
   - الصور الشخصية: `storage/app/public/profiles/`
   - صور المشاريع: `storage/app/public/projects/`
   - صور الشهادات: `storage/app/public/certificates/`

2. **رفع الملفات:**
   - السيرة الذاتية: `storage/app/public/cv/`
   - ملفات PDF للشهادات: `storage/app/public/certificates/pdf/`

3. **الصلاحيات:**
   - حالياً لا يوجد نظام Authentication
   - يمكن إضافة Laravel Breeze أو Laravel Jetstream لاحقاً

## التطوير المستقبلي

- [ ] إضافة نظام Authentication
- [ ] إضافة API
- [ ] تحسين Frontend Views
- [ ] إضافة المزيد من الإحصائيات
- [ ] إضافة Export للبيانات

## الدعم

للمساعدة أو الاستفسارات، يرجى التواصل.

---

**تم التطوير بـ ❤️ باستخدام Laravel**

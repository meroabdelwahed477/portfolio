# تعليمات التثبيت السريعة

## خطوات التثبيت

1. **تثبيت Dependencies:**
```bash
cd /home/marwa-abd-el-whed/Downloads/cv/portfolio-laravel
composer install
```

2. **إعداد ملف .env:**
```bash
cp .env.example .env
php artisan key:generate
```

3. **تعديل قاعدة البيانات في .env:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=root
DB_PASSWORD=
```

4. **تشغيل Migrations:**
```bash
php artisan migrate
```

5. **إنشاء Storage Link:**
```bash
php artisan storage:link
```

6. **تشغيل المشروع:**
```bash
php artisan serve
```

## الوصول إلى Dashboard

افتح المتصفح على: `http://localhost:8000/admin/dashboard`

## ملاحظات

- تأكد من أن مجلد `storage/app/public` قابل للكتابة
- تأكد من إعداد قاعدة البيانات بشكل صحيح
- جميع الصور والملفات ستُحفظ في `storage/app/public`

## الخطوات التالية

1. افتح Dashboard
2. أضف الملف الشخصي
3. أضف المهارات
4. أضف المشاريع
5. أضف الشهادات
6. أضف روابط التواصل


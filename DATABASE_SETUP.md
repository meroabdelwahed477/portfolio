# إعداد قاعدة البيانات MySQL

## الإعدادات الحالية

تم تحديث ملف `.env` لاستخدام MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=root
DB_PASSWORD=
```

## خطوات إنشاء قاعدة البيانات

### الطريقة 1: من سطر الأوامر

```bash
mysql -u root -p
```

ثم في MySQL:

```sql
CREATE DATABASE portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### الطريقة 2: من phpMyAdmin

1. افتح phpMyAdmin
2. اضغط على "New" (جديد)
3. أدخل اسم قاعدة البيانات: `portfolio`
4. اختر Collation: `utf8mb4_unicode_ci`
5. اضغط "Create" (إنشاء)

## تشغيل Migrations

بعد إنشاء قاعدة البيانات، قم بتشغيل:

```bash
cd /home/marwa-abd-el-whed/Downloads/cv/portfolio-laravel
php artisan migrate
```

## ملاحظات مهمة

- تأكد من أن MySQL يعمل
- تأكد من أن المستخدم `root` لديه صلاحيات إنشاء قواعد البيانات
- إذا كان لديك كلمة مرور لـ MySQL، أضفها في `.env` في `DB_PASSWORD`
- قاعدة البيانات تستخدم `utf8mb4` لدعم اللغة العربية بشكل كامل

## التحقق من الاتصال

يمكنك التحقق من الاتصال بقاعدة البيانات:

```bash
php artisan tinker
```

ثم في Tinker:

```php
DB::connection()->getPdo();
```

إذا ظهرت معلومات PDO، فالاتصال ناجح.

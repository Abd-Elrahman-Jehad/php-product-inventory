# استخدام صورة PHP مع Apache [cite: 50, 54]
FROM php:8.2-apache

# تحديد مجلد العمل داخل الحاوية [cite: 51]
WORKDIR /var/www/html

# نسخ الكود من مجلد src (تأكد أن ملف index.php داخل مجلد اسمه src) [cite: 52]
COPY src/ .

# فتح المنفذ 80 [cite: 62]
EXPOSE 80


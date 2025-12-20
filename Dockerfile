# استخدام صورة PHP مع Apache 
FROM php:8.2-apache

# تحديد مجلد العمل داخل الحاوية 
WORKDIR /var/www/html

# نسخ الكود من مجلد src 
COPY src/ .

# فتح المنفذ 80 
EXPOSE 80


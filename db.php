<?php
// 1. تفعيل الجلسة لضمان عمل نظام تسجيل الدخول في كامل الموقع
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. إعدادات الاتصال بقاعدة البيانات
$host = "localhost";
$user = "root";
$pass = "";
$db   = "cordoba_db"; // تأكدي أن هذا هو اسم قاعدة بياناتك في phpMyAdmin

// 3. إنشاء الاتصال
$conn = mysqli_connect($host, $user, $pass, $db);

// 4. ضبط الترميز للغة العربية
mysqli_set_charset($conn, "utf8mb4");

// 5. التحقق من الاتصال
if (!$conn) {
    die("خطأ في الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}
?>

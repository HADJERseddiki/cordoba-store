<?php 
// 1. الاتصال بقاعدة البيانات (يشمل session_start تلقائياً)
include 'db.php'; 

// 2. إذا كان المدير مسجلاً دخوله مسبقاً، لا داعي لإعادة تسجيل الدخول، حوليه للوحة التحكم مباشرة
if(isset($_SESSION['admin_auth'])){
    header("Location: admin.php");
    exit();
}

// 3. التحقق من بيانات الدخول عند إرسال النموذج
if(isset($_POST['login_btn'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // الاستعلام عن المستخدم في قاعدة البيانات
    $query = "SELECT * FROM admin_users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($query);
    
    if($result->num_rows > 0){
        // إذا وجدت البيانات صحيحة، ننشئ جلسة للمدير
        $_SESSION['admin_auth'] = true;
        header("Location: admin.php"); // الذهاب للوحة التحكم
        exit();
    } else {
        $error = "بيانات الدخول غير صحيحة!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل دخول المدير - قرطبة للعطور</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-box { width: 300px; margin: 100px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background: white; text-align: center; }
        input { width: 90%; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>دخول الإدارة</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form method="POST">
        <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        <input type="password" name="password" placeholder="كلمة المرور" required>
        <button type="submit" name="login_btn" class="btn" style="width:95%;">دخول</button>
    </form>
</div>

</body>
</html>
 ?>







<?php 
// تضمين ملف الاتصال بقاعدة البيانات في أول سطر
include 'db.php'; 

// التحقق من أن المدير قد سجل دخوله، إذا لم يكن كذلك يتم تحويله لصفحة الدخول
if(!isset($_SESSION['admin_auth'])) { 
    header("Location: login.php"); 
    exit(); 
}

// 1. منطق إضافة عطر جديد
if(isset($_POST['add_perfume'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $cat = mysqli_real_escape_string($conn, $_POST['cat']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    
    // رفع الصورة إلى مجلد images
    $img_name = time() . '_' . $_FILES['perfume_image']['name'];
    move_uploaded_file($_FILES['perfume_image']['tmp_name'], "images/" . $img_name);
    
    $conn->query("INSERT INTO perfumes (name, category, type, description, image) VALUES ('$name', '$cat', '$type', '$desc', '$img_name')");
    header("Location: admin.php"); exit();
}

// 2. منطق إضافة حجم وسعر لعطر معين
if(isset($_POST['add_size'])){
    $pid = intval($_POST['p_id']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $conn->query("INSERT INTO perfume_sizes (perfume_id, size, price, stock) VALUES ($pid, '$size', '$price', '$stock')");
    header("Location: admin.php"); exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم المدير</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <img src="images/logo.png" alt="شعار قرطبة" style="max-width: 150px; display: block; margin: 0 auto;">
    <h1>لوحة التحكم - قرطبة للعطور</h1>
</header>

<div class="admin-box">
    <h3>1. إضافة عطر جديد</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="اسم العطر" required style="width:100%; margin-bottom:10px;">
        <input type="file" name="perfume_image" accept="image/*" required style="width:100%; margin-bottom:10px;">
        <textarea name="desc" placeholder="وصف العطر..." required style="width:100%; height:80px; margin-bottom:10px;"></textarea>
        
        <label>الصنف:</label>
        <select name="cat" required style="width:100%; margin-bottom:10px;">
            <option value="رجالي">رجالي</option>
            <option value="نسائي">نسائي</option>
            <option value="جنسين">كلا الجنسين</option>
        </select>
        
        <label>النوع:</label>
        <input type="text" name="type" placeholder="أدخل النوع (مثال: فرنسي، عود، مسك...)" required style="width:100%; margin-bottom:10px;">
        
        <button name="add_perfume" class="btn" style="width:100%;">حفظ العطر</button>
    </form>
</div>

<div class="admin-box" style="max-width: 1000px;">
    <h3>2. إدارة الأحجام والأسعار لكل عطر</h3>
    <table>
        <tr>
            <th>اسم العطر</th>
            <th>إضافة حجم (الحجم، السعر، الكمية)</th>
        </tr>
        <?php 
        $res = $conn->query("SELECT * FROM perfumes ORDER BY id DESC");
        while($row = $res->fetch_assoc()){ ?>
            <tr>
                <td><b><?php echo $row['name']; ?></b></td>
                <td>
                    <form method="POST" style="display:flex; gap:5px;">
                        <input type="hidden" name="p_id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="size" placeholder="الحجم (ml)" required style="width:80px;">
                        <input type="number" name="price" placeholder="السعر" required style="width:80px;">
                        <input type="number" name="stock" placeholder="الكمية" required style="width:80px;">
                        <button name="add_size" class="btn">إضافة</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <a href="view_orders.php" class="btn" style="background:#432818;">عرض الطلبات</a>
    <a href="admin.php?logout=1" style="color:red; margin-right:20px; font-weight:bold;">تسجيل خروج</a>
</div>

</body>
</html>





<?php 
include 'db.php'; 

// التحقق من أن الزبون اختار حجماً معيناً
if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$size_id = intval($_GET['id']);

// جلب تفاصيل الحجم، السعر، والكمية المتوفرة
$query = "SELECT perfume_sizes.*, perfumes.name 
          FROM perfume_sizes 
          JOIN perfumes ON perfume_sizes.perfume_id = perfumes.id 
          WHERE perfume_sizes.id = $size_id";
$res = $conn->query($query);
$item = $res->fetch_assoc();

if(!$item) { echo "هذا الحجم غير متوفر."; exit(); }
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إتمام الطلب - قرطبة للعطور</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .input-group { margin-bottom: 15px; }
        input, select { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-cancel { background-color: #d90429 !important; }
        .btn-back { background-color: #f4f4f4 !important; color: #333 !important; border: 1px solid #ccc; }
    </style>
</head>
<body>

<div class="admin-box" style="max-width: 600px; margin: 30px auto; padding: 20px; background: white; border-radius: 10px;">
    <h2 style="text-align:center;">إتمام الطلبية: <?php echo $item['name']; ?></h2>
    <p style="text-align:center;">الحجم: <?php echo $item['size']; ?> | السعر: <?php echo $item['price']; ?> دج</p>
    <p style="text-align:center; color: #d90429;"><b>الكمية المتوفرة حالياً: <?php echo $item['stock']; ?></b></p>
    
    <form action="confirm.php" method="POST">
        <input type="hidden" name="size_id" value="<?php echo $item['id']; ?>">
        <input type="hidden" name="perfume_id" value="<?php echo $item['perfume_id']; ?>">
        <input type="hidden" name="size" value="<?php echo $item['size']; ?>">
        <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
        
        <div class="input-group"><input type="text" name="customer_name" placeholder="الاسم واللقب" required></div>
        <div class="input-group"><input type="tel" name="phone" placeholder="رقم الهاتف" required></div>
        <div class="input-group"><input type="email" name="email" placeholder="البريد الإلكتروني"></div>
        <div class="input-group">
            <select name="state" required>
                <option value="">اختر الولاية</option>
                <option value="الجزائر">الجزائر</option>
                <option value="وهران">وهران</option>
                <option value="قسنطينة">قسنطينة</option>
                <option value="عنابة">عنابة</option>
            </select>
        </div>
        <div class="input-group"><input type="text" name="city" placeholder="البلدية" required></div>
        <div class="input-group"><input type="text" name="address" placeholder="عنوان التوصيل بالتفصيل" required></div>
        
        <label>الكمية:</label>
        <div class="input-group"><input type="number" name="quantity" value="1" min="1" max="<?php echo $item['stock']; ?>" required></div>
        
        <button type="submit" name="submit_order" class="btn" style="width:100%; padding:15px;">تأكيد الطلب</button>
        
        <div style="margin-top: 15px; display: flex; justify-content: space-between; gap: 10px;">
            <a href="index.php" class="btn btn-back" style="flex: 1; text-align: center; padding: 10px; text-decoration: none; border-radius: 5px;">العودة للمتجر</a>
            <a href="index.php" onclick="return confirm('هل أنت متأكد أنك تريد إلغاء الطلبية؟');" class="btn btn-cancel" style="flex: 1; text-align: center; padding: 10px; text-decoration: none; border-radius: 5px; color: white;">إلغاء الطلبية</a>
        </div>
    </form>
</div>

</body>
</html>





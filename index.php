<?php 
include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قرطبة للعطور - الصفحة الرئيسية</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .perfume-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; padding: 20px; }
        .card { background: #fff; border: 1px solid #ddd; border-radius: 12px; padding: 15px; text-align: center; }
        .card img { width: 100%; height: 250px; object-fit: cover; border-radius: 8px; }
        .size-badge { background: #f0f0f0; padding: 8px; margin: 5px 0; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body>

<header>
    <a href="index.php">
        <img src="images/logo.png" alt="شعار قرطبة" style="max-width: 180px; display: block; margin: 0 auto;">
    </a>
    <h1 style="text-align: center; color: white;">مرحباً بكم في قرطبة للعطور</h1>
</header>

<div class="perfume-grid">
    <?php 
    $res = $conn->query("SELECT * FROM perfumes ORDER BY id DESC");
    
    if($res->num_rows > 0) {
        while($row = $res->fetch_assoc()){ 
            $pid = $row['id'];
    ?>
            <div class="card">
                <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h2><?php echo $row['name']; ?></h2>
                <p><i><?php echo $row['category']; ?> - <?php echo $row['type']; ?></i></p>
                <p><?php echo $row['description']; ?></p>
                
                <hr>
                <div style="text-align: right;">
                    <strong>الأحجام المتوفرة:</strong>
                    <?php 
                    $sizes = $conn->query("SELECT * FROM perfume_sizes WHERE perfume_id = $pid");
                    while($size = $sizes->fetch_assoc()){
                        echo "<div class='size-badge'>
                                <span>{$size['size']}</span>
                                <span><b>{$size['price']} دج</b></span>";
                                
                        // التحقق من وجود كمية: إذا كان هناك مخزون يظهر زر الطلب، إذا لا يظهر "نفاذ الكمية"
                        if($size['stock'] > 0) {
                            echo "<a href='cart.php?id={$size['id']}' class='btn' style='background:#432818; color:white; padding:5px 10px; text-decoration:none;'>طلب</a>";
                        } else {
                            echo "<span style='color:red; font-size:12px;'>نفاذ الكمية</span>";
                        }
                        
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
    <?php 
        } 
    } else {
        echo "<p style='text-align:center;'>لا توجد عطور معروضة حالياً.</p>";
    }
    ?>
</div>

</body>
</html>

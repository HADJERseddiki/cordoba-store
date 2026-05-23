<?php 
include 'db.php'; 

if(isset($_POST['submit_order'])) {
    
    // 1. استقبال البيانات من نموذج cart.php
    $size_id       = intval($_POST['size_id']);
    $perfume_id    = intval($_POST['perfume_id']);
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $phone         = mysqli_real_escape_string($conn, $_POST['phone']);
    $email         = mysqli_real_escape_string($conn, $_POST['email']);
    $state         = mysqli_real_escape_string($conn, $_POST['state']);
    $city          = mysqli_real_escape_string($conn, $_POST['city']);
    $address       = mysqli_real_escape_string($conn, $_POST['address']);
    $quantity      = intval($_POST['quantity']);
    $size          = mysqli_real_escape_string($conn, $_POST['size']);
    $price         = floatval($_POST['price']);
    $total         = $quantity * $price;

    // 2. التحقق من المخزون
    $check_stock = $conn->query("SELECT stock FROM perfume_sizes WHERE id = $size_id");
    $data = $check_stock->fetch_assoc();

    if($data && $data['stock'] >= $quantity) {
        
        // 3. تحديث المخزون (خصم الكمية)
        $conn->query("UPDATE perfume_sizes SET stock = stock - $quantity WHERE id = $size_id");
        
        // 4. حفظ الطلب مع كافة بيانات الزبون الجديدة
        $sql = "INSERT INTO orders (customer_name, phone, email, state, city, address, perfume_id, size, quantity, total_price) 
                VALUES ('$customer_name', '$phone', '$email', '$state', '$city', '$address', $perfume_id, '$size', $quantity, $total)";
        
        if($conn->query($sql)) {
            echo "<div style='text-align:center; padding:50px; font-family:sans-serif;'>
                    <h2 style='color: #2a9d8f;'>تم تأكيد طلبكم بنجاح!</h2>
                    <p>شكراً لثقتكم في قرطبة للعطور، سنتصل بكم قريباً.</p>
                    <a href='index.php' style='padding:10px 20px; background:#432818; color:white; text-decoration:none; border-radius:5px;'>العودة للرئيسية</a>
                  </div>";
        } else {
            echo "حدث خطأ أثناء حفظ الطلب: " . $conn->error;
        }
        
    } else {
        echo "<div style='text-align:center; padding:50px; color:red;'>
                <h2>عذراً، الكمية المطلوبة لم تعد متوفرة!</h2>
                <a href='index.php'>العودة للرئيسية</a>
              </div>";
    }

} else {
    header("Location: index.php");
    exit();
}
?>

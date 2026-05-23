<?php
include 'db.php';
// جلب الطلبات من الأحدث إلى الأقدم مع كافة الأعمدة
$query = "SELECT * FROM orders ORDER BY id DESC";
$res = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طلبات الزبائن - لوحة التحكم</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: sans-serif; background-color: #f9f9f9; padding: 20px; }
        h2 { text-align: center; color: #432818; }
        .table-container { overflow-x: auto; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #432818; color: white; padding: 12px; font-size: 14px; }
        td { padding: 10px; border: 1px solid #ddd; text-align: center; font-size: 13px; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .back-link { display: block; text-align: center; margin-bottom: 20px; color: #2a9d8f; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <h2>سجل طلبات الزبائن</h2>
    <a href="admin.php" class="back-link">← العودة للوحة التحكم</a>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>الاسم واللقب</th>
                    <th>الهاتف</th>
                    <th>البريد الإلكتروني</th>
                    <th>الولاية - البلدية</th>
                    <th>العنوان</th>
                    <th>العطر</th>
                    <th>الكمية</th>
                    <th>الإجمالي</th>
                    <th>تاريخ الطلب</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $res->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['state'] . " - " . $row['city']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['size']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['total_price']; ?> دج</td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>


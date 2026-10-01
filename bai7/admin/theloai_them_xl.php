<?php
include_once('../connect.php');

if (!isset($_POST['Them'])) {
    header('Location: theloai_them.php');
    exit;
}

$theloai = trim($_POST['TenTL'] ?? '');
$thutu = (int)($_POST['ThuTu'] ?? 0);
$an = (int)($_POST['AnHien'] ?? 1);

if ($theloai === '') {
    die('Tên thể loại không được để trống.');
}

$icon = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $originalName = basename($_FILES['image']['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed, true)) {
        die('Chỉ cho phép ảnh JPG, JPEG, PNG, GIF hoặc WEBP.');
    }

    $icon = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
    $target = '../image/' . $icon;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        die('Không thể upload ảnh.');
    }
}

$stmt = mysqli_prepare($connect, 'INSERT INTO theloai (TenTL, ThuTu, AnHien, icon) VALUES (?, ?, ?, ?)');
mysqli_stmt_bind_param($stmt, 'siis', $theloai, $thutu, $an, $icon);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Thêm thành công'); location.href='theloai.php';</script>";
} else {
    if ($icon !== '' && file_exists('../image/' . $icon)) {
        @unlink('../image/' . $icon);
    }
    echo 'Lỗi: ' . htmlspecialchars(mysqli_stmt_error($stmt), ENT_QUOTES, 'UTF-8');
}

mysqli_stmt_close($stmt);
mysqli_close($connect);
?>

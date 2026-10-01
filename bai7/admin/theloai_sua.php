<?php
include_once('../connect.php');

$idTL = filter_input(INPUT_GET, 'idTL', FILTER_VALIDATE_INT);
if (!$idTL) {
    die('idTL không hợp lệ.');
}

$stmt = mysqli_prepare($connect, 'SELECT * FROM theloai WHERE idTL = ?');
mysqli_stmt_bind_param($stmt, 'i', $idTL);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$d = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$d) {
    die('Không tìm thấy thể loại.');
}

if (isset($_POST['Sua'])) {
    $theloai = trim($_POST['TenTL'] ?? '');
    $thutu = (int)($_POST['ThuTu'] ?? 0);
    $an = (int)($_POST['AnHien'] ?? 1);
    $oldIcon = $_POST['ten_anh'] ?? '';
    $icon = $oldIcon;
    $newIcon = '';

    if ($theloai === '') {
        die('Tên thể loại không được để trống.');
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $originalName = basename($_FILES['image']['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed, true)) {
            die('Chỉ cho phép ảnh JPG, JPEG, PNG, GIF hoặc WEBP.');
        }

        $newIcon = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $target = '../image/' . $newIcon;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            die('Không thể upload ảnh mới.');
        }

        $icon = $newIcon;
    }

    $update = mysqli_prepare($connect, 'UPDATE theloai SET TenTL = ?, ThuTu = ?, AnHien = ?, icon = ? WHERE idTL = ?');
    mysqli_stmt_bind_param($update, 'siisi', $theloai, $thutu, $an, $icon, $idTL);

    if (mysqli_stmt_execute($update)) {
        if ($newIcon !== '' && $oldIcon !== '' && $oldIcon !== $newIcon && file_exists('../image/' . $oldIcon)) {
            @unlink('../image/' . $oldIcon);
        }
        mysqli_stmt_close($update);
        mysqli_close($connect);
        echo "<script>alert('Sửa thành công'); location.href='theloai.php';</script>";
        exit;
    }

    if ($newIcon !== '' && file_exists('../image/' . $newIcon)) {
        @unlink('../image/' . $newIcon);
    }

    $error = mysqli_stmt_error($update);
    mysqli_stmt_close($update);
    die('Lỗi cập nhật: ' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8'));
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sửa thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">Bài 7 Admin</div>
        <div class="menu-title">Quản lý</div>
        <nav class="menu">
            <a href="theloai.php">Dashboard</a>
            <a class="active" href="theloai.php">Thể loại</a>
            <a href="theloai_them.php">Thêm thể loại</a>
        </nav>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h1>Sửa thể loại</h1>
                <div class="subtext">Cập nhật thông tin thể loại #<?= (int)$idTL ?></div>
            </div>
            <a class="btn" href="theloai.php">← Quay lại</a>
        </div>

        <section class="card form-card">
            <h2 class="card-title">Thông tin thể loại</h2>

            <form action="theloai_sua.php?idTL=<?= (int)$idTL ?>" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <label for="TenTL">Tên thể loại</label>
                    <input id="TenTL" type="text" name="TenTL" value="<?= htmlspecialchars($d['TenTL'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-row">
                    <label for="ThuTu">Thứ tự</label>
                    <input id="ThuTu" type="number" name="ThuTu" value="<?= (int)$d['ThuTu'] ?>" required>
                </div>

                <div class="form-row">
                    <label for="AnHien">Ẩn / Hiện</label>
                    <select id="AnHien" name="AnHien">
                        <option value="1" <?= ((int)$d['AnHien'] === 1) ? 'selected' : '' ?>>Hiện</option>
                        <option value="0" <?= ((int)$d['AnHien'] === 0) ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Icon hiện tại</label>
                    <div class="current-icon">
                        <?php if (!empty($d['icon'])): ?>
                            <img class="icon" src="../image/<?= rawurlencode($d['icon']) ?>" alt="icon">
                            <span><?= htmlspecialchars($d['icon'], ENT_QUOTES, 'UTF-8') ?></span>
                        <?php else: ?>
                            <span>Không có icon</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-row">
                    <label for="image">Đổi icon</label>
                    <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">
                    <input type="hidden" name="ten_anh" value="<?= htmlspecialchars($d['icon'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="note">Không chọn file mới thì hệ thống giữ nguyên icon cũ.</div>
                </div>

                <div class="form-actions">
                    <input type="submit" name="Sua" value="Lưu thay đổi">
                    <input type="reset" value="Hoàn tác">
                    <a class="btn" href="theloai.php">Hủy</a>
                </div>
            </form>
        </section>
    </main>
</div>
</body>
</html>
<?php mysqli_close($connect); ?>

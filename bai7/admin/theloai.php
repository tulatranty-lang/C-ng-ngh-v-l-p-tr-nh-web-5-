<?php
include_once('../connect.php');

$sql = 'SELECT * FROM theloai ORDER BY ThuTu ASC, idTL ASC';
$results = mysqli_query($connect, $sql);

if (!$results) {
    die('Lỗi truy vấn: ' . mysqli_error($connect));
}

$rowsList = [];
$total = 0;
$visible = 0;
$hidden = 0;

while ($row = mysqli_fetch_assoc($results)) {
    $rowsList[] = $row;
    $total++;

    if ((int)$row['AnHien'] === 1) {
        $visible++;
    } else {
        $hidden++;
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">Bài 7 Admin</div>

        <div class="menu-title">Quản lý</div>
        <nav class="menu">
            <a class="active" href="theloai.php">Dashboard</a>
            <a href="theloai.php">Thể loại</a>
            <a href="theloai_them.php">Thêm thể loại</a>
        </nav>

        <div class="menu-title">Khác</div>
        <nav class="menu">
            <a href="../index.php">Trang chủ</a>
            <a href="http://localhost/phpmyadmin/">phpMyAdmin</a>
        </nav>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h1>Dashboard</h1>
                <div class="subtext">Quản lý dữ liệu bảng thể loại</div>
            </div>
            <a class="btn btn-dark" href="theloai_them.php">+ Thêm thể loại</a>
        </div>

        <section class="stats">
            <div class="stat-card">
                <div class="label">Tổng thể loại</div>
                <div class="number"><?= $total ?></div>
            </div>
            <div class="stat-card">
                <div class="label">Đang hiển thị</div>
                <div class="number"><?= $visible ?></div>
            </div>
            <div class="stat-card">
                <div class="label">Đang ẩn</div>
                <div class="number"><?= $hidden ?></div>
            </div>
        </section>

        <section class="card">
            <h2 class="card-title">Danh sách thể loại</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên thể loại</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th>Biểu tượng</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rowsList as $rows): ?>
                        <tr>
                            <td>#<?= (int)$rows['idTL'] ?></td>
                            <td><?= htmlspecialchars($rows['TenTL'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= (int)$rows['ThuTu'] ?></td>
                            <td>
                                <span class="badge">
                                    <?= ((int)$rows['AnHien'] === 1) ? 'Hiện' : 'Ẩn' ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($rows['icon'])): ?>
                                    <img class="icon" src="../image/<?= rawurlencode($rows['icon']) ?>" alt="icon">
                                <?php else: ?>
                                    Không có
                                <?php endif; ?>
                            </td>
                            <td class="actions">
                                <a href="theloai_sua.php?idTL=<?= (int)$rows['idTL'] ?>">Sửa</a>
                                <a class="btn-danger"
                                   href="theloai_xoa.php?idTL=<?= (int)$rows['idTL'] ?>"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
</body>
</html>
<?php mysqli_close($connect); ?>

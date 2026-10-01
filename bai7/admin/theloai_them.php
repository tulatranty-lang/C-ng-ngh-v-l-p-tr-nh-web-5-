<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thêm thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">Bài 7 Admin</div>
        <div class="menu-title">Quản lý</div>
        <nav class="menu">
            <a href="theloai.php">Dashboard</a>
            <a href="theloai.php">Thể loại</a>
            <a class="active" href="theloai_them.php">Thêm thể loại</a>
        </nav>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h1>Thêm thể loại</h1>
                <div class="subtext">Nhập thông tin thể loại mới</div>
            </div>
            <a class="btn" href="theloai.php">← Quay lại</a>
        </div>

        <section class="card form-card">
            <h2 class="card-title">Thông tin thể loại</h2>

            <form action="theloai_them_xl.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <label for="TenTL">Tên thể loại</label>
                    <input id="TenTL" type="text" name="TenTL" placeholder="Ví dụ: Giải trí" required>
                </div>

                <div class="form-row">
                    <label for="ThuTu">Thứ tự</label>
                    <input id="ThuTu" type="number" name="ThuTu" value="0" required>
                </div>

                <div class="form-row">
                    <label for="AnHien">Ẩn / Hiện</label>
                    <select id="AnHien" name="AnHien">
                        <option value="1" selected>Hiện</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

                <div class="form-row">
                    <label for="image">Icon</label>
                    <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">
                    <div class="note">Có thể chọn JPG, PNG, GIF hoặc WEBP.</div>
                </div>

                <div class="form-actions">
                    <input type="submit" name="Them" value="Thêm thể loại">
                    <input type="reset" value="Nhập lại">
                    <a class="btn" href="theloai.php">Hủy</a>
                </div>
            </form>
        </section>
    </main>
</div>
</body>
</html>

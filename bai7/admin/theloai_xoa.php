<?php
include_once('../connect.php');

$idTL = filter_input(INPUT_GET, 'idTL', FILTER_VALIDATE_INT);
if (!$idTL) {
    die('idTL không hợp lệ.');
}

// Lấy tên ảnh trước để có thể xóa file sau khi xóa bản ghi.
$stmt = mysqli_prepare($connect, 'SELECT icon FROM theloai WHERE idTL = ?');
mysqli_stmt_bind_param($stmt, 'i', $idTL);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    die('Không tìm thấy thể loại.');
}

$stmt = mysqli_prepare($connect, 'DELETE FROM theloai WHERE idTL = ?');
mysqli_stmt_bind_param($stmt, 'i', $idTL);

if (mysqli_stmt_execute($stmt)) {
    if (!empty($row['icon']) && file_exists('../image/' . $row['icon'])) {
        @unlink('../image/' . $row['icon']);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
    echo "<script>alert('Xóa thành công'); location.href='theloai.php';</script>";
    exit;
}

$error = mysqli_stmt_error($stmt);
mysqli_stmt_close($stmt);
mysqli_close($connect);
die('Lỗi xóa: ' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8'));
?>

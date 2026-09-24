<?php
require_once('database.php');

$category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
if ($category_id === null || $category_id === false) {
    $error = 'Invalid category ID.';
    include('error.php');
    exit();
}

$query = 'SELECT * FROM categories WHERE categoryID = :category_id';
$statement = $db->prepare($query);
$statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$statement->execute();
$category = $statement->fetch();
$statement->closeCursor();

if (!$category) {
    $error = 'Category not found.';
    include('error.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<header><h1>Product Manager</h1></header>
<main>
    <h1>Update Category</h1>

    <form action="update_category.php" method="post" id="update_category_form">
        <input type="hidden" name="category_id"
               value="<?php echo $category['categoryID']; ?>">

        <label>Name:</label>
        <input type="text" name="name" required
               value="<?php echo htmlspecialchars($category['categoryName']); ?>">
        <input type="submit" value="Update">
    </form>

    <br>
    <p><a href="category_list.php">Back to Category List</a></p>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.</p>
</footer>
</body>
</html>

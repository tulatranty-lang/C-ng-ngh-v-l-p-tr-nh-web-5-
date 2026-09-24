<?php
require_once('database.php');

// Get all categories
$query = 'SELECT * FROM categories ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
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
    <h1>Category List</h1>

    <table>
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($categories as $category) : ?>
        <tr>
            <td><?php echo htmlspecialchars($category['categoryName']); ?></td>
            <td class="category-actions">
                <form action="update_category_form.php" method="get">
                    <input type="hidden" name="category_id"
                           value="<?php echo $category['categoryID']; ?>">
                    <input type="submit" value="Update">
                </form>

                <form action="delete_category.php" method="post"
                      onsubmit="return confirm('Delete this category?');">
                    <input type="hidden" name="category_id"
                           value="<?php echo $category['categoryID']; ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Add Category</h2>
    <form action="add_category.php" method="post" id="add_category_form">
        <label>Name:</label>
        <input type="text" name="name" required>
        <input type="submit" value="Add">
    </form>

    <br>
    <p><a href="index.php">List Products</a></p>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.</p>
</footer>
</body>
</html>

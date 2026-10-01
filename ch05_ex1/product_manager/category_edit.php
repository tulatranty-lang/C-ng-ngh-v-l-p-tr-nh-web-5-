<?php include '../view/header.php'; ?>
<main>
    <h1>Edit Category</h1>

    <form id="edit_category_form" action="index.php" method="post">
        <input type="hidden" name="action" value="update_category" />
        <input type="hidden" name="category_id"
               value="<?php echo $category['categoryID']; ?>" />

        <label>Name:</label>
        <input type="text" name="name"
               value="<?php echo htmlspecialchars($category['categoryName'], ENT_QUOTES, 'UTF-8'); ?>"
               required />
        <input type="submit" value="Update" />
    </form>

    <p><a href="index.php?action=list_categories">Back to Category List</a></p>
</main>
<?php include '../view/footer.php'; ?>

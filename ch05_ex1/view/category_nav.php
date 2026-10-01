<nav>
    <ul>
        <?php foreach($categories as $category) : ?>
        <li>
            <a href="?category_id=<?php echo $category['categoryID']; ?>">
                <?php echo htmlspecialchars($category['categoryName'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>

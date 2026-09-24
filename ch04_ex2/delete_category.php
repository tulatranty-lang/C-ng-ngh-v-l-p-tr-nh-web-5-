<?php
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

if ($category_id === null || $category_id === false) {
    $error = 'Invalid category ID.';
    include('error.php');
    exit();
}

require_once('database.php');

try {
    $query = 'DELETE FROM categories WHERE categoryID = :category_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();
} catch (PDOException $e) {
    $error = 'This category cannot be deleted because it is being used by one or more products.';
    include('error.php');
    exit();
}

header('Location: category_list.php');
exit();

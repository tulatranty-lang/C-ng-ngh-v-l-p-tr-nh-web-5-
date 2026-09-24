<?php
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$name = trim((string) filter_input(INPUT_POST, 'name'));

if ($category_id === null || $category_id === false || $name === '') {
    $error = 'Invalid category data. Please check the category name and try again.';
    include('error.php');
    exit();
}

require_once('database.php');

$query = 'UPDATE categories
          SET categoryName = :name
          WHERE categoryID = :category_id';
$statement = $db->prepare($query);
$statement->bindValue(':name', $name);
$statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$statement->execute();
$statement->closeCursor();

header('Location: category_list.php');
exit();

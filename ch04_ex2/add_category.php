<?php
$name = trim((string) filter_input(INPUT_POST, 'name'));

if ($name === '') {
    $error = 'Invalid category name. Please enter a category name.';
    include('error.php');
    exit();
}

require_once('database.php');

$query = 'INSERT INTO categories (categoryName) VALUES (:name)';
$statement = $db->prepare($query);
$statement->bindValue(':name', $name);
$statement->execute();
$statement->closeCursor();

header('Location: category_list.php');
exit();

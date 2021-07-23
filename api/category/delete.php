<?php
include_once '../config/partials/display_errors.php';
include_once '../config/headers/DELETE.php';
include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database;
$connection = $database->connection();

$table_name = 'categories';
$category = new Category($connection, $table_name);

$data = json_decode(file_get_contents("php://input"), false);
$category->id = $data->id;

if ($category->destroy()) {
    echo json_encode(
        array('message' => 'Category deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not deleted')
    );
}

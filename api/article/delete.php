<?php
include_once '../config/partials/display_errors.php';
include_once '../config/headers/DELETE.php';
include_once '../../config/Database.php';
include_once '../../models/Article.php';

$database = new Database;
$connection = $database->connection();

$table_name = 'articles';
$article = new Article($connection, $table_name);

$data = json_decode(file_get_contents("php://input"));
$article->id = $data->id;

if ($article->destroy()) {
    echo json_encode(
        array('message' => 'Article deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Article Not deleted')
    );
}

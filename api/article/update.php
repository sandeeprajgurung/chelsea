<?php
include_once '../config/partials/display_errors.php';
include_once '../config/headers/PUT.php';
include_once '../../config/Database.php';
include_once '../../models/Article.php';

$database = new Database;
$connection = $database->connection();

$table_name = 'articles';
$article = new Article($connection, $table_name);

$data = json_decode(file_get_contents("php://input"));
$article->id = $data->id;
$article->title = $data->title;
$article->content = $data->content;
$article->featured_image = $data->featured_image;
$article->slug = $data->slug;
// $article->tag_id = $data->tag_id;
$article->category_id = $data->category_id;

if ($article->update()) {
    echo json_encode(
        array('message' => 'Article Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Article Not updated')
    );
}

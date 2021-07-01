<?php
include_once '../config/partials/display_errors.php';
include_once '../config/headers/POST.php';
include_once '../../config/Database.php';
include_once '../../models/Article.php';

$database = new Database;
$conn = $database->connection();

$table_name = 'articles';
$article = new Article($conn, $table_name);

$data = json_decode(file_get_contents("php://input"));
$article->title = $data->title;
$article->content = $data->content;
$article->featured_image = $data->featured_image;
$article->slug = $data->slug;

$article->category_id = $data->category_id;
// $article->tag_id = $data->tag_id;

if ($article->create()) {
    echo json_encode(
        array('message' => 'Article created')
    );
} else {
    echo json_encode(
        array('message' => 'Article Not created')
    );
}

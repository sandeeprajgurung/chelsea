<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Post.php';

$post = new Post($db);

$result = $post->read();
$num = $result->rowCount();

if($num > 0) {
    $posts_arr = [];
    $posts_arr['data'] = [];

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'content' => html_entity_decode($content),
            'tag' => $tag,
            'created_at' => $created_at
        );

        array_push($posts_arr['data'], $post_item);
    }
    echo json_encode($posts_arr['data']);
} else {
    echo json_encode(
        array('message' => 'No post found')
    );
}
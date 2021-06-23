<?php
class Post
{
    private $conn;
    private $table = 'news';

    public $id;
    public $title;
    public $content;
    public $tag;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = '';
        $statement = $this->conn->prepare($query);
        if ($statement->execute()) {
            return $statement;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }
}

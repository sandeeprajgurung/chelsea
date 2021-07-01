<?php
class Article
{
    /** @var PDO */
    private $conn;

    /** @var string */
    private $table;

    /** @var int */
    public $id;

    /** @var string */
    public $title;

    /** @var string */
    public $content;

    /** @var string */
    public $featured_image;

    /** @var string */
    public $slug;

    /** @var int */
    public $category_id;

    public $tag_id;

    /** @var date */
    public $date;

    public function __construct(PDO $db, string $table)
    {
        $this->conn = $db;
        $this->table = $table;
    }

    public function create(): bool
    {
        $query = 'INSERT INTO ' . $this->table .
            ' SET title = :title,
        content = :content,
        featured_image = :featured_image,
        slug = :slug';

        $statement = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $statement->bindParam(':title', $this->title);

        // $this->content = htmlspecialchars(strip_tags($this->content));
        $statement->bindParam(':content', $this->content);

        $this->featured_image = htmlspecialchars(strip_tags($this->featured_image));
        $statement->bindParam(':featured_image', $this->featured_image);

        $this->slug = htmlspecialchars(strip_tags($this->slug));
        $statement->bindParam(':slug', $this->slug);

        if ($statement->execute()) {
            $this->article_id = $this->conn->lastInsertId();

            if ($this->category_id && $this->article_id) {
                $query = 'INSERT INTO articles_categories
                SET category_id = :category_id,
                article_id = :article_id';

                $statement = $this->conn->prepare($query);

                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                $statement->bindParam(':category_id', $this->category_id);

                $this->article_id = htmlspecialchars(strip_tags($this->article_id));
                $statement->bindParam(':article_id', $this->article_id);

                if ($statement->execute()) {
                    return true;
                }

                printf("Error: %s.\n", $statement->error);
                return false;
            }

            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function read(): object
    {
        $query = 'SELECT ';
        $statement = $this->conn->prepare($query);

        if ($statement->execute()) {
            return $statement;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function update(): bool
    {
        $query = 'UPDATE ' . $this->table .
        ' SET title = :title,
        content = :content,
        featured_image = :featured_image,
        slug = :slug
        WHERE id = :id';

        $statement = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $statement->bindParam(':id', $this->id);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $statement->bindParam(':title', $this->title);

        // $this->content = htmlspecialchars(strip_tags($this->content));
        $statement->bindParam(':content', $this->content);

        $this->featured_image = htmlspecialchars(strip_tags($this->featured_image));
        $statement->bindParam(':featured_image', $this->featured_image);

        $this->slug = htmlspecialchars(strip_tags($this->slug));
        $statement->bindParam(':slug', $this->slug);

        if ($statement->execute()) {
            $this->article_id = $this->id;

            if ($this->category_id && $this->article_id) {
                $query = 'UPDATE articles_categories
                SET category_id = :category_id,
                article_id = :article_id
                WHERE article_id = :article_id';

                $statement = $this->conn->prepare($query);

                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                $statement->bindParam(':category_id', $this->category_id);

                $this->article_id = htmlspecialchars(strip_tags($this->article_id));
                $statement->bindParam(':article_id', $this->article_id);

                if ($statement->execute()) {
                    return true;
                }

                printf("Error: %s.\n", $statement->error);
                return false;
            }
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function destroy(): bool
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $statement = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $statement->bindParam(':id', $this->id);

        if ($statement->execute()) {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }
}

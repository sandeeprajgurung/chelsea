<?php

class Articles_tags
{
    private $conn;
    private $table_name = 'articles_tags';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * @param mixed[] $statement
     */
    public function addSql(string $sql) : object
    {
        $statement = $this->conn->prepare($sql);
        if ($statement->execute()) {
            return $statement;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function up() : void
    {
        $result = $this->addSql(
            "CREATE TABLE IF NOT EXISTS $this->table_name (
                `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `tag_id` INT(11) UNSIGNED NOT NULL,
                `article_id` INT(11) UNSIGNED NOT NULL,
                `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX tag_id (tag_id),
                FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE ON UPDATE CASCADE,
                INDEX article_id (article_id),
                FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
        );

        if ($result) {
            echo "$this->table_name is created.".PHP_EOL;
        } else {
            echo "Noting to migrate for $this->table_name";
        }
    }
}

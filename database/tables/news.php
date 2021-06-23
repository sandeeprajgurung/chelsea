<?php

class News
{
    private $conn;
    private $table_name = 'news';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * @param mixed[] $statement
     */
    public function addSql(string $sql): object
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
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                heading VARCHAR(30) NOT NULL,
                content VARCHAR(30) NOT NULL,
                tag_id INT(6) UNSIGNED NOT NULL,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX tag_id (tag_id),
                FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
        );

        if ($result) {
            echo "$this->table_name is created.";
        } else {
            echo "Noting to migrate for $this->table_name";
        }
    }
}

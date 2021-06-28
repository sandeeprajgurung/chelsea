<?php

class Categories
{
    private $conn;
    private $table_name = 'categories';

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
                `name` VARCHAR(32) NOT NULL,
                `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",
        );

        if ($result) {
            echo "$this->table_name is created.".PHP_EOL;
        } else {
            echo "Noting to migrate for $this->table_name";
        }
    }
}

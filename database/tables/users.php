<?php

class Users
{
    private $conn;
    private $table_name = 'users';

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
                `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `first_name` VARCHAR(32) NOT NULL,
                `last_name` VARCHAR(32) NOT NULL,
                `middle_name` VARCHAR(32) DEFAULT NULL,
                `email` VARCHAR(32) NOT NULL,
                `password` VARCHAR(32) NOT NULL,
                `profile_img` BLOB DEFAULT NULL,
                `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT uc_email UNIQUE (email)
            )",
        );

        if ($result) {
            echo "$this->table_name is created.".PHP_EOL;
        } else {
            echo "Noting to migrate for $this->table_name";
        }
    }
}

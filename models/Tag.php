<?php
class Tag
{
    /** @var PDO */
    private $conn;

    /** @var string */
    private $table;

    /** @var int */
    public $id;

    /** @var string */
    public $name;

    public function __construct(PDO $db, string $table)
    {
        $this->conn = $db;
        $this->table = $table;
    }

    public function create(): bool
    {
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name';
        $statement = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $statement->bindParam(':name', $this->name);

        if ($statement->execute()) {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function read(): object
    {
        $query = 'SELECT * FROM  ' . $this->table . '';
        $statement = $this->conn->prepare($query);

        if ($statement->execute()) {
            return $statement;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function getLastRecord(): object
    {
        $query = 'SELECT * FROM  ' . $this->table . ' ORDER BY id DESC LIMIT 1';
        $statement = $this->conn->prepare($query);

        if ($statement->execute()) {
            return $statement;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function update(): bool
    {
        $query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id';
        $statement = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));

        $statement->bindParam(':id', $this->id);
        $statement->bindParam(':name', $this->name);

        if ($statement->execute()) {
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

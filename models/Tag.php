<?php
class Tag
{
    /** @var PDO */
    private $conn;

    /** @var string */
    private $table;

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

        if($statement->execute()) {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function read()
    {
        $query = 'SELECT * FROM  ' . $this->table . '';
        $statement = $this->conn->prepare($query);

        if($statement->execute()) {
            return $statement;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}

<?php
class BoardRepository
{
    public PDO $db;
    private $queries = array(
        "GetAll" => "SELECT id, name, description FROM boards;",
        "Create" => "INSERT INTO `boards` VALUES (':name',':description',CURRENT_TIMESTAMP());"
    );
    public function __construct()
    {
        $this->db = $GLOBALS["Database"];
    }

    public function GetAll()
    {
        try {
            $stm = $this->db->query($this->queries['GetAll']);
            return $stm->fetchAll(PDO::FETCH_CLASS, "board");
        } catch (Exception $e) {
            throw ("Fallo en " . __METHOD__ . "(" . __CLASS__ . ") =>" . $e->getMessage());
        }
    }
    public function Create($name, $description)
    {

        try {
            $param = array(':name' => $name, ':description' => $description);
            $query = str_template($this->queries['Create'], $param);
            $this->db->query($query);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            throw ("Fallo en " . __METHOD__ . "(" . __CLASS__ . ") =>" . $e->getMessage());
        }
    }
}

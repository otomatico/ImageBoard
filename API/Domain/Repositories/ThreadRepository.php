<?php
class ThreadRepository
{
    private PDO $db;
    private $queries = array(
        "GetByBoard" => "SELECT id, board_id, subject FROM `threads` where board_id = :board_id;",
        "Create" => "INSERT INTO `theards` VALUES (:board_id,':subject',CURRENT_TIMESTAMP());"
    );
    public function __construct()
    {
        $this->db = $GLOBALS["Database"];
    }

    public function GetByBoard($id)
    {
        try {
            $param = [':board_id' => $id];
            $query = str_template($this->queries['GetByBoard'], $param);
            $stm = $this->db->query($query);
            return $stm->fetchAll(PDO::FETCH_CLASS, "thread");
        } catch (Exception $e) {
            throw ("Fallo en " . __METHOD__ . "(" . __CLASS__ . ") =>" . $e->getMessage());
        }
    }
    public function Create($board_id, $subject)
    {

        try {
            $param = array(':board_id' => $board_id, ':subject' => $subject);
            $query = str_template($this->queries['Create'], $param);
            $this->db->query($query);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            throw ("Fallo en " . __METHOD__ . "(" . __CLASS__ . ") =>" . $e->getMessage());
        }
    }
}

<?php
class ThreadRepository
{
    private PDO $db;
    private $queries = array(
        "GetByBoard" => "SELECT id, board_id, subject FROM `threads` where board_id = :board_id;",
        "GetTotalByBoard" => "SELECT Count(id) as Total FROM `threads` where board_id = :board_id;",
        "GetPaginedByBoard" => "SELECT id, board_id, subject FROM `threads` where board_id = :board_id; ORDER BY id LIMIT  :pageSize OFFSET (:curretPage - 1)* :pageSize )",
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
    public function GetTotalByBoard($id): int
    {
        try {
            $param = [':board_id' => $id];
            $query = str_template($this->queries['GetTotalByBoard'], $param);
            $stm = $this->db->query($query);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result["Total"];
        } catch (Exception $e) {
            throw ("Fallo en " . __METHOD__ . "(" . __CLASS__ . ") =>" . $e->getMessage());
        }
    }
    public function GetPaginedByBoard($boardId, $currentPage, $pageSize)
    {
        try {
            $param = [':board_id' => $boardId, ':currentPage' => $currentPage, ':pageSize' => $pageSize];
            $query = str_template($this->queries['GetPaginedByBoard'], $param);
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

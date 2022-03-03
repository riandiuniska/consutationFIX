<?php


class Chats {
    private $chat_id;
    private $user_id;
    private $message;
    private $created_at;
    private $db_conn;


    public function __construct()
    {
        require_once("DbConnect.php");
        $db = new DbConnect;
        $this->db_conn = $db->connect();
    }

    public function getChatId() {
        return $this->chat_id;
    }

    public function setChatId($chat_id) {
        return $this->chat_id = $chat_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        return $this->user_id = $user_id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        return $this->message = $message;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        return $this->created_at = $created_at;
    }

    public function saveChat() {
        $statement = $this->db_conn->prepare('INSERT INTO chats VALUES(null, :user_id, :message, :created_at)');
        $statement->bindParam(":user_id", $this->user_id);
        $statement->bindParam(":message", $this->message);
        $statement->bindParam(":created_at", $this->created_at);

        if($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllChat() {
        $statement = $this->db_conn->prepare("SELECT * FROM chats INNER JOIN users ON chats.user_id = users.user_id");
        $statement->execute();
        $chatsData = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $chatsData;
    }

}
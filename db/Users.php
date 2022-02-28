<?php

    class Users {
        private $id;
        private $name;
        private $email;
        private $login_status;
        private $last_login;
        private $db_conn;


        public function __construct() {
            require_once("DbConnect.php");
            $db = new DbConnect();
            $this->db_conn = $db->connect();
        }


        function getId() { 
            return $this->id; 
        }

        function setId($id) { 
            return $this->id = $id; 
        }

        function getName() {
            return $this->name;
        }

        function setName($name) {
            return $this->name = $name;
        }

        function getEmail() {
            return  $this->email;
        }

        function setEmail($email) {
            return $this->email = $email;
        }

        function getLoginStatus() {
            return $this->login_status;
        }

        function setLoginStatus($login_status) {
            return $this->login_status = $login_status;
        }

        function getLastLogin() {
            return $this->last_login;
        }

        function setLastLogin($last_login) {
            return $this->last_login = $last_login;
        }


        public function insertData() {
            $sql = "INSERT INTO `users`(`user_id`, `name`, `email`, `login_status`, `last_login`) VALUES (null, :name, :email, :login_status, :last_login)";

            $statement = $this->db_conn->prepare($sql);

            $statement->bindParam(":name", $this->name);
            $statement->bindParam(":email", $this->email);
            $statement->bindParam(":login_status", $this->login_status);
            $statement->bindParam(":last_login", $this->last_login);

            try {
                if($statement->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public function getUserByEmail() {
            $statement = $this->db_conn->prepare("SELECT * FROM users WHERE email = :email");
            $statement->bindParam(":email", $this->email);
            try {
                if($statement->execute()){
                    $user = $statement->fetch(PDO::FETCH_ASSOC);
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }

            return $user;
        }

        public function getUserById() {
            $statement = $this->db_conn->prepare("SELECT * FROM users WHERE user_id = :id");
            $statement->bindParam(":id", $this->id);
            try {
                if($statement->execute()){
                    $user = $statement->fetch(PDO::FETCH_ASSOC);
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }

            return $user;
        }

        public function updateLoginStatus() {
            $statement = $this->db_conn->prepare("UPDATE users SET login_status = :login_status, last_login = :last_Login WHERE id = :id");
            $statement->bindParam(":login_status", $this->login_status);
            $statement->bindParam(":last_login", $this->last_login);
            $statement->bindParam(":id", $this->id);

            try {
                if($statement->execute()){
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        public function getAllUser() {
            $statement = $this->db_conn->prepare("SELECT * FROM users");
            $statement->execute();
            $userData = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $userData;
        }
    }
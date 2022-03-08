<?php

    class DbConnect {
        // DbConnect properties
        private $host = "localhost";
        private $user = "root";
        private $password = "";
        private $db_name = "db_chatroom";

        public function connect() {
            try {
                // Initialize database connection
                $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->db_name, $this->user, $this->password);
                $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $conn;
            } catch (PDOException $e) {
                echo "Database Error: " . $e->getMessage(); 
            }  
        }
    }
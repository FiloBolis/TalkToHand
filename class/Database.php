<?php
    class Database {
        private $conn;
        private static $instance = null;

        private function __construct() {
            $this->conn = new mysqli("localhost", "root", "", "talktohand");
        }

        public static function getInstance() {
            if(self::$instance == null)
                $instance = new Database();
            return $instance;
        }

        public function doLogin($username, $password) {
            $query = "SELECT * FROM utenti WHERE username = ? AND password = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows < 1)
                return null;
            $row = $result->fetch_assoc();
            return $row["id"];
        }

        public function doRegister($username, $password, $email) {
            $query = "INSERT INTO utenti (username, password, email) VALUES(?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            if(!$stmt)
                return null;
            $stmt->bind_param("sss", $username, $password, $email);
            if($stmt->execute())
                return $stmt->insert_id;
            else
                return null;
        }

        public function getUsername($id) {
            $query = "SELECT username FROM utenti WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows < 1)
                return null;
            $row = $result->fetch_assoc();
            return $row["username"];
        }
    }
?>
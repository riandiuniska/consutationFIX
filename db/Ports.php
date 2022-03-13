<?php

class Ports {
    // properties for class ports
    private $port_id;
    private $value;
    private $status;
    private $person1;
    private $person2;
    private $db_conn;

    // constructor
    public function __construct()
    {
        require_once("DbConnect.php");
        $db = new DbConnect;
        $this->db_conn = $db->connect();
    }

    public function get_port_id() {
        return $this->port_id;
    }

    public function set_port_id($port_id) {
        $this->port_id = $port_id;
    }

    public function get_value() {
        return $this->value;
    }

    public function set_value($value) {
        $this->value = $value;
    }

    public function get_status() {
        return $this->status;
    }

    public function set_status($status) {
        $this->status = $status;
    }

    public function get_person1() {
        return $this->person1;
    }

    public function set_person1($person1) {
        $this->person1 = $person1;
    }

    public function get_person2() {
        return $this->person2;
    }

    public function set_person2($person2) {
        $this->person1 = $person2;
    }

    public function get_all_ports() {
        $stmt = $this->db_conn->prepare("SELECT * FROM ports");
        try {
            if($stmt->execute()) {
                $portData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $portData;
    }

    public function get_all_free_port() {
        $stmt = $this->db_conn->prepare("SELECT * FROM ports WHERE status = :status");
        $stmt->bindParam(":status", $this->status);
        try{
            if($stmt->execute()) {
                $freePort = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $freePort;
    }
}
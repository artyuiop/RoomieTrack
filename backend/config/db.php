<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
$data = json_decode(file_get_contents("php://input"), true);

class Database
{
    private $host = 'localhost';
    private $dbname = 'room';
    private $user = 'root';
    private $pass = '';
    private $conn;

    // 😒ฟังชั่น เชื่อมต่อฐานข้อมูล
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname->$this->dbname", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "pass";
        } catch (PDOException $e) {
            echo "connect to mysql error" . $e->getMessage();
        }
    }

    // 😒ฟังชั่น เรียกใช้เชื่อมต่อฐานข่อมูล
    public function getDB()
    {
        return $this->conn;
    }
}

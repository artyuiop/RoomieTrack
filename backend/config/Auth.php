<?php
require_once './db.php';

class Auth{
    private $conn;
    
    public function __construct()
    {
        $db = new Database();
        $this->conn  = $db->getDB();
    }

    //ฟังชั่น เข้าสู่ระบบ
    public function Login($username, $password){
        try{
            $stmt = $this->conn->prepare("SELECT username FROM user WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            // เช็ค username กับ password
            if($user && password_verify($password, $user['password'])){
                $_SESSION['user_login'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                return ["status" => "success"];
            }else{
                return ["status" => "error"];
            }
        }catch(PDOException $e){
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }
}

$auth = new Auth();

// ตัวจัดการ เรียกใช้ ฟังชั่นเข้าสู่ระบบ
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $action = $data['action'] ?? '';

    if($action == 'send_login'){
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        $hashpassword = password_hash($password, PASSWORD_DEFAULT);
        $res = $auth->Login($username, $hashpassword);
        echo json_encode($res);
        exit;
    }
}
?>
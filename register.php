<?php
require_once 'functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username==='' || $password==='') {
        flash_set('กรอก username และ password');
    } else {
        // check exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            flash_set('ชื่อผู้ใช้มีแล้ว');
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username,email,password,fullname,role) VALUES (?,?,?,?,?)");
            $stmt->execute([$username,$email,$hash,$username,'user']);
            flash_set('สมัครสำเร็จ กรุณาเข้าสู่ระบบ');
            header('Location: login.php');
            exit;
        }
    }
}
$msg = flash_get();
?>
<?php include 'nav.php'; ?>
<div style="padding:20px">
  <h3>Register</h3>
  <?php if($msg) echo "<p style='color:red'>$msg</p>"; ?>
  <form method="post">
    <label>Username<br><input name="username"></label><br>
    <label>Email<br><input name="email"></label><br>
    <label>Password<br><input name="password" type="password"></label><br>
    <button>Register</button>
  </form>
</div>

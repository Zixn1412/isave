<?php
require_once 'functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT id,password,role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $u = $stmt->fetch();
    if ($u && password_verify($password, $u['password'])) {
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $u['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Login failed';
    }
}
?>
<?php include 'nav.php'; ?>
<div style="padding:20px">
  <h3>Login</h3>
  <?php if(!empty($error)) echo "<p style='color:red'>".htmlspecialchars($error)."</p>"; ?>
  <form method="post">
    <label>Username<br><input name="username"></label><br>
    <label>Password<br><input name="password" type="password"></label><br>
    <button>Login</button>
  </form>
</div>

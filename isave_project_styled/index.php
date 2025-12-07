<?php include 'nav.php'; ?>
<div style="padding:20px">
  <h2>Welcome to iSave — ระบบแจ้งซ่อมครุภัณฑ์</h2>
  <?php if(is_logged_in()): ?>
    <p>Hello, <?=htmlspecialchars($_SESSION['username'])?>! Role: <?=htmlspecialchars($_SESSION['role'])?></p>
    <?php if($_SESSION['role'] === 'user'): ?>
      <p><a href="user/submit_request.php">แจ้งซ่อมใหม่</a> | <a href="user/my_requests.php">รายการของฉัน</a></p>
    <?php elseif($_SESSION['role'] === 'admin'): ?>
      <p><a href="admin/dashboard.php">Admin Dashboard</a></p>
    <?php elseif($_SESSION['role'] === 'tech'): ?>
      <p><a href="tech/dashboard.php">ช่าง Dashboard</a></p>
    <?php endif; ?>
  <?php else: ?>
    <p><a href="login.php">Login</a> or <a href="register.php">Register</a></p>
  <?php endif; ?>
</div>

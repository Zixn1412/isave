<?php
require_once 'functions.php';
$u = current_user();
?>
<nav style="background:#2c3e50;color:white;padding:10px;display:flex;justify-content:space-between">
  <div><a href="/isave_project/" style="color:white;text-decoration:none;font-weight:bold">iSave — ระบบแจ้งซ่อมครุภัณฑ์</a></div>
  <div>
    <?php if($u): ?>
      <?=htmlspecialchars($u['username'])?> (<?=htmlspecialchars($u['role'])?>)
      <a href="/isave_project/logout.php" style="color:white;margin-left:10px">Logout</a>
      <?php if($u['role']==='admin'): ?>
        <a href="/isave_project/admin/dashboard.php" style="color:white;margin-left:10px">Admin</a>
        <a href="/isave_project/admin/manage_roles.php" style="color:white;margin-left:10px">รับสมัคร</a>
      <?php endif; ?>
      <?php if($u['role']==='tech'): ?>
        <a href="/isave_project/tech/dashboard.php" style="color:white;margin-left:10px">ช่าง</a>
      <?php endif; ?>
    <?php else: ?>
      <a href="/isave_project/login.php" style="color:white;margin-left:10px">Login</a>
      <a href="/isave_project/register.php" style="color:white;margin-left:10px">Register</a>
    <?php endif; ?>
  </div>
</nav>

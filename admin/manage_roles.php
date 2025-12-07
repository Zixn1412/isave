<?php
require_once '../functions.php';
require_role('admin');
include '../nav.php';

// list users except admins
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['make_admin'])) {
        $id = (int)$_POST['user_id'];
        $pdo->prepare("UPDATE users SET role='admin' WHERE id=?")->execute([$id]);
        flash_set('อัปเดตเป็น admin');
        header('Location: manage_roles.php'); exit;
    }
    if (isset($_POST['make_tech'])) {
        $id = (int)$_POST['user_id'];
        $pdo->prepare("UPDATE users SET role='tech' WHERE id=?")->execute([$id]);
        flash_set('อัปเดตเป็น tech');
        header('Location: manage_roles.php'); exit;
    }
}
$msg = flash_get();
$users = $pdo->query("SELECT id,username,role FROM users WHERE role!='admin' ORDER BY created_at DESC")->fetchAll();
?>
<div style="padding:20px">
  <h3>รับสมัคร Admin / ช่าง</h3>
  <?php if($msg) echo "<p style='color:green'>$msg</p>"; ?>
  <table border="1" cellpadding="5"><tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>
  <?php foreach($users as $u): ?>
    <tr>
      <td><?=$u['id']?></td>
      <td><?=htmlspecialchars($u['username'])?></td>
      <td><?=htmlspecialchars($u['role'])?></td>
      <td>
        <form method="post" style="display:inline">
          <input type="hidden" name="user_id" value="<?=$u['id']?>">
          <button name="make_admin">เป็น Admin</button>
        </form>
        <form method="post" style="display:inline">
          <input type="hidden" name="user_id" value="<?=$u['id']?>">
          <button name="make_tech">เป็น ช่าง</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </table>
</div>

<?php
require_once '../functions.php';
require_role('admin');
include '../nav.php';

// Approve/Reject/Assign actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve_id'])) {
        $id = (int)$_POST['approve_id'];
        $stmt = $pdo->prepare("UPDATE repair_requests SET status='approved', approved_by=?, approved_at=NOW() WHERE id=?");
        $stmt->execute([$_SESSION['user_id'],$id]);
        flash_set('อนุมัติแล้ว');
        header('Location: dashboard.php'); exit;
    }
    if (isset($_POST['assign_id'])) {
        $id = (int)$_POST['assign_id'];
        $tech = (int)$_POST['tech_id'];
        $stmt = $pdo->prepare("UPDATE repair_requests SET status='assigned', assigned_to=?, assigned_at=NOW() WHERE id=?");
        $stmt->execute([$tech,$id]);
        flash_set('ส่งงานให้ช่างแล้ว');
        header('Location: dashboard.php'); exit;
    }
}

$msg = flash_get();
// pending list
$rows = $pdo->query("SELECT r.*, u.username as requester FROM repair_requests r JOIN users u ON r.user_id=u.id WHERE r.status='pending' ORDER BY r.created_at DESC")->fetchAll();
// tech list
$techs = $pdo->query("SELECT id,username FROM users WHERE role='tech'")->fetchAll();
?>
<div style="padding:20px">
  <h3>Admin Dashboard</h3>
  <?php if($msg) echo "<p style='color:green'>$msg</p>"; ?>
  <h4>รายการรออนุมัติ</h4>
  <table border="1" cellpadding="5"><tr><th>ID</th><th>Asset</th><th>Requester</th><th>Problem</th><th>Action</th></tr>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><?=$r['id']?></td>
      <td><?=htmlspecialchars($r['asset_number'])?></td>
      <td><?=htmlspecialchars($r['requester'])?></td>
      <td><?=htmlspecialchars($r['problem'])?></td>
      <td>
        <form method="post" style="display:inline">
          <input type="hidden" name="approve_id" value="<?=$r['id']?>">
          <button>อนุมัติ</button>
        </form>
        <form method="post" style="display:inline">
          <input type="hidden" name="assign_id" value="<?=$r['id']?>">
          <select name="tech_id">
            <?php foreach($techs as $t): ?>
              <option value="<?=$t['id']?>"><?=htmlspecialchars($t['username'])?></option>
            <?php endforeach; ?>
          </select>
          <button>มอบหมาย</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </table>
</div>

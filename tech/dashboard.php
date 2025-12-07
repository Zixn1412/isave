<?php
require_once '../functions.php';
require_role('tech');
include '../nav.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['complete_id'])) {
        $id = (int)$_POST['complete_id'];
        $sig = $_POST['tech_signature'] ?? '';
        $company = $_POST['company_repaired_by'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $stmt = $pdo->prepare("UPDATE repair_requests SET status='completed', tech_signature=?, company_repaired_by=?, notes=? WHERE id=? AND assigned_to=?");
        $stmt->execute([$sig,$company,$notes,$id,$_SESSION['user_id']]);
        flash_set('ปิดงานเรียบร้อย');
        header('Location: dashboard.php'); exit;
    }
}

$rows = $pdo->prepare("SELECT * FROM repair_requests WHERE assigned_to = ? ORDER BY assigned_at DESC");
$rows->execute([$_SESSION['user_id']]);
$tasks = $rows->fetchAll();
$msg = flash_get();
?>
<div style="padding:20px">
  <h3>ช่าง Dashboard</h3>
  <?php if($msg) echo "<p style='color:green'>$msg</p>"; ?>
  <table border="1" cellpadding="5"><tr><th>ID</th><th>Asset</th><th>Problem</th><th>Action</th></tr>
  <?php foreach($tasks as $t): ?>
    <tr>
      <td><?=$t['id']?></td>
      <td><?=htmlspecialchars($t['asset_number'])?></td>
      <td><?=htmlspecialchars($t['problem'])?></td>
      <td>
        <form method="post">
          <input type="hidden" name="complete_id" value="<?=$t['id']?>">
          <label>ชื่อลงชื่อ<br><input name="tech_signature"></label><br>
          <label>บริษัท (ถ้ามี)<br><input name="company_repaired_by"></label><br>
          <label>หมายเหตุ<br><textarea name="notes"></textarea></label><br>
          <button>ปิดงาน</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </table>
</div>

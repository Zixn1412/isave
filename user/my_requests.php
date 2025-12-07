<?php
require_once '../functions.php';
if (!is_logged_in()) { header('Location: ../login.php'); exit; }
include '../nav.php';
$stmt = $pdo->prepare("SELECT * FROM repair_requests WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$rows = $stmt->fetchAll();
?>
<div style="padding:20px">
  <h3>รายการของฉัน</h3>
  <table border="1" cellpadding="5"><tr><th>ID</th><th>Asset</th><th>Room</th><th>Status</th><th>Image</th></tr>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><?= $r['id'] ?></td>
      <td><?= htmlspecialchars($r['asset_number']) ?></td>
      <td><?= htmlspecialchars($r['room']) ?></td>
      <td><?= $r['status'] ?></td>
      <td><?php if($r['image']) echo '<a href="../'.htmlspecialchars($r['image']).'" target="_blank">ดูภาพ</a>' ?></td>
    </tr>
  <?php endforeach; ?>
  </table>
</div>

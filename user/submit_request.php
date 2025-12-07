<?php
require_once '../functions.php';
if (!is_logged_in()) { header('Location: ../login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asset = $_POST['asset_number'] ?? '';
    $room = $_POST['room'] ?? '';
    $problem = $_POST['problem'] ?? '';
    $warranty = $_POST['warranty'] ?? 'no';
    $responsible = $_POST['responsible_person'] ?? '';
    $imgpath = null;
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['image/jpeg','image/png'];
        if (in_array($_FILES['image']['type'],$allowed) && $_FILES['image']['error']===0) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('img_').'.'.$ext;
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $filename);
            $imgpath = 'uploads/' . $filename;
        }
    }
    $stmt = $pdo->prepare("INSERT INTO repair_requests (user_id,asset_number,image,room,problem,warranty,responsible_person) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([$_SESSION['user_id'],$asset,$imgpath,$room,$problem,$warranty,$responsible]);
    flash_set('ส่งคำร้องสำเร็จ');
    header('Location: my_requests.php');
    exit;
}
$msg = flash_get();
include '../nav.php';
?>
<div style="padding:20px">
  <h3>แจ้งซ่อมครุภัณฑ์</h3>
  <?php if($msg) echo "<p style='color:green'>".htmlspecialchars($msg)."</p>"; ?>
  <form method="post" enctype="multipart/form-data">
    <label>เลขครุภัณฑ์<br><input name="asset_number" required></label><br>
    <label>ภาพ (jpg/png)<br><input type="file" name="image"></label><br>
    <label>ห้อง<br><input name="room"></label><br>
    <label>สาเหตุ/อาการ<br><textarea name="problem"></textarea></label><br>
    <label>ประกัน<br>
      <label><input type="radio" name="warranty" value="yes"> ประกัน</label>
      <label><input type="radio" name="warranty" value="no" checked> ไม่มีประกัน</label>
    </label><br>
    <label>ผู้รับผิดชอบ<br><input name="responsible_person"></label><br>
    <button>Submit</button>
    <button type="reset">ล้างข้อมูล</button>
  </form>
</div>

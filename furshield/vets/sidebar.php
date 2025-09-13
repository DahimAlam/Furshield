<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('vet');

if (!defined('BASE')) define('BASE', '/furshield');

$me = user();
$avatar = !empty($me['avatar']) ? htmlspecialchars($me['avatar']) : BASE.'/assets/img/avatar-vet.png';

$subtitle = '';
$uid = (int)$me['id'];
$q = $conn->prepare("SELECT specialization FROM vets WHERE user_id=? LIMIT 1");
if ($q && $q->bind_param('i', $uid) && $q->execute()) {
  $r = $q->get_result()->fetch_assoc();
  if (!empty($r['specialization'])) $subtitle = $r['specialization'];
}

$curr = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (!function_exists('vet_is_active')) {
  function vet_is_active($files){ global $curr; return in_array($curr,(array)$files,true) ? 'active' : ''; }
}
?>
<aside id="vetSidebar" class="vet-aside vh-100 d-flex flex-column">
  <div class="aside-brand px-3 py-3">
    <a class="d-flex align-items-center gap-2 text-decoration-none" href="<?= BASE ?>/vets/dashboard.php">
      <span class="brand-mark"><i class="bi bi-heart-pulse-fill"></i></span>
      <div class="brand-text">
        <div class="title">FurShield • Vet</div>
        <small class="subtitle">Care Dashboard</small>
      </div>
    </a>
  </div>

  <div class="aside-profile px-3">
    <div class="card-mini">
      <img src="<?= $avatar ?>" alt="Avatar" class="avatar">
      <div class="meta">
        <div class="name"><?= htmlspecialchars($me['name'] ?? 'Vet') ?></div>
        <small class="role"><?= htmlspecialchars($subtitle ?: 'Veterinary Professional') ?></small>
      </div>
      <a href="<?= BASE ?>/vets/profile.php" class="btn btn-sm btn-light border">Edit</a>
    </div>
  </div>

  <nav class="mt-2 flex-grow-1 px-2">
    <ul class="nav-list">
      <li><a class="nav-link <?= vet_is_active(['dashboard.php']) ?>" href="<?= BASE ?>/vets/dashboard.php"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a></li>
      <li><a class="nav-link <?= vet_is_active(['appointments.php','appointment-view.php']) ?>" href="<?= BASE ?>/vets/appointments.php"><i class="bi bi-calendar2-check"></i><span>Appointments</span></a></li>
      <li><a class="nav-link <?= vet_is_active(['pets.php','pet-view.php']) ?>" href="<?= BASE ?>/vets/pets.php"><i class="bi bi-clipboard2-heart"></i><span>Pets Under Care</span></a></li>
      <li><a class="nav-link <?= vet_is_active(['slots.php']) ?>" href="<?= BASE ?>/vets/slots.php"><i class="bi bi-clock-history"></i><span>My Slots & Availability</span></a></li>
      <li><a class="nav-link <?= vet_is_active(['messages.php']) ?>" href="<?= BASE ?>/vets/messages.php"><i class="bi bi-chat-dots"></i><span>Messages</span></a></li>
      <li><a class="nav-link <?= vet_is_active(['settings.php','profile.php']) ?>" href="<?= BASE ?>/vets/settings.php"><i class="bi bi-gear"></i><span>Settings</span></a></li>
    </ul>

    <div class="mt-3 px-2">
      <div class="small text-muted mb-2">Quick Links</div>
      <div class="d-grid gap-2">
        <a class="btn btn-sm btn-outline-dark" href="<?= BASE ?>/">Home</a>
        <a class="btn btn-sm btn-outline-danger" href="<?= BASE ?>/logout.php">Logout</a>
      </div>
    </div>
  </nav>

  <div class="aside-foot px-3 mt-auto">
    <div class="small text-muted">© <?= date('Y') ?> FurShield</div>
  </div>
</aside>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('vet');

if (!defined('BASE')) define('BASE','/furshield');
$conn->set_charset('utf8mb4');

$me  = user();
$uid = (int)$me['id'];

$apptTotal      = (int)($conn->query("SELECT COUNT(*) c FROM appointments WHERE vet_id=$uid")->fetch_assoc()['c'] ?? 0);
$apptUpcoming   = (int)($conn->query("SELECT COUNT(*) c FROM appointments WHERE vet_id=$uid AND appointment_time>=NOW() AND status IN ('pending','confirmed')")->fetch_assoc()['c'] ?? 0);
$petsUnderCare  = (int)($conn->query("SELECT COUNT(DISTINCT pet_id) c FROM appointments WHERE vet_id=$uid AND status='completed'")->fetch_assoc()['c'] ?? 0);
$slotsAvailable = (int)($conn->query("SELECT JSON_LENGTH(slots_json) c FROM vets WHERE user_id=$uid")->fetch_assoc()['c'] ?? 0);

$util = ($slotsAvailable>0) ? max(0,min(100,(int)round(($apptUpcoming/$slotsAvailable)*100))) : 0;

$recent = $conn->query("
  SELECT a.id, a.appointment_time, a.status,
         p.name AS pet_name, u.name AS owner_name
  FROM appointments a
  JOIN pets p   ON a.pet_id=p.id
  JOIN users u  ON a.owner_id=u.id
  WHERE a.vet_id=$uid
  ORDER BY a.appointment_time DESC
  LIMIT 8
");

$rows = $conn->query("
  SELECT DATE(appointment_time) d, COUNT(*) c
  FROM appointments
  WHERE vet_id=$uid AND appointment_time >= (CURRENT_DATE - INTERVAL 6 DAY)
  GROUP BY DATE(appointment_time)
  ORDER BY d
");
$map = [];
if ($rows) while ($r=$rows->fetch_assoc()) $map[$r['d']] = (int)$r['c'];
$labels = []; $series = [];
for ($i=6; $i>=0; $i--) {
  $d = (new DateTimeImmutable("-$i day"))->format('Y-m-d');
  $labels[] = (new DateTimeImmutable($d))->format('M j');
  $series[] = (int)($map[$d] ?? 0);
}

$rows = $conn->query("
  SELECT LOWER(status) s, COUNT(*) c
  FROM appointments
  WHERE vet_id=$uid
  GROUP BY LOWER(status)
");
$statusLabels = []; $statusData = [];
if ($rows) while ($r=$rows->fetch_assoc()) { $statusLabels[] = ucfirst($r['s']); $statusData[] = (int)$r['c']; }

$avatar = !empty($me['avatar']) ? htmlspecialchars($me['avatar']) : BASE.'/assets/img/avatar-vet.png';
$subtitle = '';
$q = $conn->prepare("SELECT specialization FROM vets WHERE user_id=? LIMIT 1");
if ($q && $q->bind_param('i',$uid) && $q->execute()) {
  $rr = $q->get_result()->fetch_assoc();
  if (!empty($rr['specialization'])) $subtitle = $rr['specialization'];
}
$curr = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (!function_exists('vet_is_active')) {
  function vet_is_active($files){ global $curr; return in_array($curr,(array)$files,true) ? 'active' : ''; }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vet Dashboard • FurShield</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <link rel="stylesheet" href="../assets/css/theme-sand-sunset.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-app">

<button class="btn btn-light d-lg-none position-fixed"
        style="left:14px; top:14px; z-index:1051; box-shadow:0 10px 30px rgba(0,0,0,.08);"
        data-bs-toggle="offcanvas" data-bs-target="#offcanvasVetNav" aria-controls="offcanvasVetNav">
  <i class="bi bi-list"></i>
</button>

<div class="container-fluid vet-main">
  <div class="row g-0">
    <div class="col-lg-3 col-xl-2 p-0 d-none d-lg-block">
      <?php include __DIR__.'/sidebar.php'; ?>
    </div>

    <div class="col-lg-9 col-xl-10 px-3 px-xl-4 py-4">
      <div class="page-head d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1">Welcome back, <?= htmlspecialchars($me['name']) ?></h2>
          <div class="text-muted small">Your practice snapshot.</div>
        </div>
        <div class="d-flex gap-2">
          <a href="<?= BASE ?>/vets/appointments.php" class="btn btn-gradient"><i class="bi bi-plus-lg me-1"></i> New Appointment</a>
          <a href="<?= BASE ?>/vets/slots.php" class="btn btn-outline-sunset"><i class="bi bi-clock-history me-1"></i> Manage Slots</a>
        </div>
      </div>

      <div class="row g-4 mb-4 dash-grid">
        <div class="col-6 col-md-3">
          <div class="card dash-card"><div class="card-body">
            <div class="dash-icon ring-primary"><i class="bi bi-calendar-event"></i></div>
            <div class="dash-value"><?= $apptTotal ?></div>
            <div class="dash-label">Total Appointments</div>
          </div></div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card dash-card"><div class="card-body">
            <div class="dash-icon ring-accent"><i class="bi bi-clock"></i></div>
            <div class="dash-value"><?= $apptUpcoming ?></div>
            <div class="dash-label">Upcoming</div>
          </div></div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card dash-card"><div class="card-body">
            <div class="dash-icon ring-success"><i class="bi bi-heart"></i></div>
            <div class="dash-value"><?= $petsUnderCare ?></div>
            <div class="dash-label">Pets Under Care</div>
          </div></div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card dash-card"><div class="card-body">
            <div class="dash-icon ring-info"><i class="bi bi-clock-history"></i></div>
            <div class="dash-value"><?= $slotsAvailable ?></div>
            <div class="dash-label">Available Slots</div>
          </div></div>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-12 col-xxl-8">
          <div class="card shadow-sm chart-card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Appointments — Last 7 Days</h5>
              <span class="small text-muted">Daily volume</span>
            </div>
            <div class="card-body">
              <div class="chart-wrap"><canvas id="line7d"></canvas></div>
            </div>
          </div>

          <div class="card shadow-sm mt-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Recent Appointments</h5>
              <a href="<?= BASE ?>/vets/appointments.php" class="btn btn-sm btn-soft">View All</a>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead class="table-light">
                    <tr><th>Pet</th><th>Owner</th><th>Date & Time</th><th>Status</th></tr>
                  </thead>
                  <tbody>
                  <?php if ($recent && $recent->num_rows): while($row=$recent->fetch_assoc()): ?>
                    <?php $st=$row['status']; $cls=($st==='completed'?'success':(($st==='pending'||$st==='confirmed')?'warning':'secondary')); ?>
                    <tr>
                      <td><?= htmlspecialchars($row['pet_name']) ?></td>
                      <td><?= htmlspecialchars($row['owner_name']) ?></td>
                      <td><?= date('d M Y, H:i', strtotime($row['appointment_time'])) ?></td>
                      <td><span class="badge bg-<?= $cls ?>"><?= ucfirst($st) ?></span></td>
                    </tr>
                  <?php endwhile; else: ?>
                    <tr><td colspan="4" class="text-center py-3">No recent appointments</td></tr>
                  <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-xxl-4">
          <div class="card shadow-sm mb-4 chart-card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
              <h6 class="mb-0">Status Mix</h6>
              <span class="small text-muted">All-time</span>
            </div>
            <div class="card-body">
              <div class="chart-wrap small-height"><canvas id="doughnutStatus"></canvas></div>
            </div>
          </div>

          <div class="card shadow-sm mb-4">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Today’s Utilization</h6>
                <span class="text-muted small"><?= $util ?>%</span>
              </div>
              <div class="meter"><span style="width:<?= $util ?>%"></span></div>
              <div class="small text-muted mt-2">Upcoming vs available slots</div>
            </div>
          </div>

          <div class="card shadow-sm">
            <div class="card-body">
              <h6 class="mb-3">Quick Actions</h6>
              <div class="d-grid gap-2">
                <a href="<?= BASE ?>/vets/appointments.php" class="btn btn-gradient"><i class="bi bi-plus-lg me-1"></i>Create Appointment</a>
                <a href="<?= BASE ?>/vets/slots.php" class="btn btn-outline-sunset"><i class="bi bi-clock-history me-1"></i>Update Availability</a>
                <a href="<?= BASE ?>/vets/messages.php" class="btn btn-outline-sunset"><i class="bi bi-chat-dots me-1"></i>Open Messages</a>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /row -->
    </div><!-- /content -->
  </div><!-- /row -->
</div><!-- /container -->

<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasVetNav" aria-labelledby="offcanvasVetNavLabel" style="width:280px;">
  <div class="offcanvas-header">
    <h6 class="offcanvas-title" id="offcanvasVetNavLabel" style="font-family:Montserrat;">FurShield • Vet</h6>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-0">
    <div class="p-3 border-bottom d-flex align-items-center gap-3">
      <img src="<?= $avatar ?>" class="rounded-circle" style="width:44px;height:44px;object-fit:cover;" alt="">
      <div>
        <div class="fw-semibold text-truncate"><?= htmlspecialchars($me['name'] ?? 'Vet') ?></div>
        <small class="text-muted text-truncate"><?= htmlspecialchars($subtitle ?: 'Veterinary Professional') ?></small>
      </div>
    </div>
    <ul class="list-unstyled m-0 p-2">
      <li><a class="d-block px-3 py-2 rounded-3 text-decoration-none <?= vet_is_active(['dashboard.php']) ?>" href="<?= BASE ?>/vets/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
      <li><a class="d-block px-3 py-2 rounded-3 text-decoration-none <?= vet_is_active(['appointments.php','appointment-view.php']) ?>" href="<?= BASE ?>/vets/appointments.php"><i class="bi bi-calendar2-check me-2"></i>Appointments</a></li>
      <li><a class="d-block px-3 py-2 rounded-3 text-decoration-none <?= vet_is_active(['pets.php','pet-view.php']) ?>" href="<?= BASE ?>/vets/pets.php"><i class="bi bi-clipboard2-heart me-2"></i>Pets Under Care</a></li>
      <li><a class="d-block px-3 py-2 rounded-3 text-decoration-none <?= vet_is_active(['slots.php']) ?>" href="<?= BASE ?>/vets/slots.php"><i class="bi bi-clock-history me-2"></i>My Slots & Availability</a></li>
      <li><a class="d-block px-3 py-2 rounded-3 text-decoration-none <?= vet_is_active(['messages.php']) ?>" href="<?= BASE ?>/vets/messages.php"><i class="bi bi-chat-dots me-2"></i>Messages</a></li>
      <li><a class="d-block px-3 py-2 rounded-3 text-decoration-none <?= vet_is_active(['settings.php','profile.php']) ?>" href="<?= BASE ?>/vets/settings.php"><i class="bi bi-gear me-2"></i>Settings</a></li>
      <li class="mt-2 px-2"><a class="btn btn-sm btn-outline-danger w-100" href="<?= BASE ?>/logout.php">Logout</a></li>
    </ul>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

<script>
  const DASH = {
    line: {
      labels: <?= json_encode($labels, JSON_UNESCAPED_UNICODE) ?>,
      data:   <?= json_encode($series, JSON_UNESCAPED_UNICODE) ?>
    },
    doughnut: {
      labels: <?= json_encode($statusLabels, JSON_UNESCAPED_UNICODE) ?>,
      data:   <?= json_encode($statusData, JSON_UNESCAPED_UNICODE) ?>
    }
  };

  const css = getComputedStyle(document.documentElement);
  const cPrimary = css.getPropertyValue('--primary').trim() || '#F59E0B';
  const cAccent  = css.getPropertyValue('--accent').trim()  || '#EF4444';
  const cText    = css.getPropertyValue('--text').trim()    || '#1F2937';
  const cGrid    = 'rgba(0,0,0,.06)';

  const lineEl = document.getElementById('line7d');
  if (lineEl) new Chart(lineEl, {
    type: 'line',
    data: {
      labels: DASH.line.labels,
      datasets: [{
        label: 'Appointments',
        data: DASH.line.data,
        borderColor: cPrimary,
        backgroundColor: cPrimary + '33',
        pointRadius: 3,
        tension: .35,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: { grid: { color: cGrid }, ticks: { color: cText } },
        y: { grid: { color: cGrid }, ticks: { color: cText, precision:0 }, beginAtZero: true }
      },
      plugins: { legend: { display:false } }
    }
  });

  const doughEl = document.getElementById('doughnutStatus');
  if (doughEl) new Chart(doughEl, {
    type: 'doughnut',
    data: {
      labels: DASH.doughnut.labels,
      datasets: [{
        data: DASH.doughnut.data,
        backgroundColor: [cPrimary, cAccent, '#10b981', '#3b82f6', '#6b7280', '#f59e0b'],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom', labels: { color: cText } } },
      cutout: '65%'
    }
  });
</script>
</body>
</html>

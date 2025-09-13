<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/auth.php';
require_role('admin');

if (!defined('BASE')) define('BASE','/furshield');
$conn->set_charset('utf8mb4');

/* --- Fetch Active Vets --- */
$vets = [];
$res = $conn->query("
    SELECT u.id, u.name, u.email, u.created_at, u.status,
           v.specialization, v.experience_years, v.clinic_address, v.city, v.country, v.profile_image, v.cnic_image
    FROM users u
    JOIN vets v ON v.user_id = u.id
    WHERE u.role='vet' AND u.status='active'
    ORDER BY u.created_at DESC
");
if ($res) while ($r = $res->fetch_assoc()) $vets[] = $r;

include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

<main class="admin-main p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold text-dark">Vets</h1>
  </div>

  <div class="card shadow-sm rounded-4 border-0">
    <div class="card-body p-4">
      <?php if(!$vets): ?>
        <div class="alert alert-info">No vets found.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table align-middle table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Profile</th>
                <th>Name</th>
                <th>Email</th>
                <th>Specialization</th>
                <th>Experience</th>
                <th>Clinic</th>
                <th>City</th>
                <th>Country</th>
                <th>CNIC / License</th>
                <th>Status</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($vets as $i=>$v): ?>
              <tr>
                <td><?php echo $i+1; ?></td>
                <td>
                  <?php if($v['profile_image'] && file_exists(__DIR__."/../../../".$v['profile_image'])): ?>
                    <img src="<?php echo BASE.'/'.$v['profile_image']; ?>" alt="Profile" class="rounded-circle" width="45" height="45">
                  <?php else: ?>
                    <span class="badge bg-secondary">No Image</span>
                  <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($v['name']); ?></td>
                <td><?php echo htmlspecialchars($v['email']); ?></td>
                <td><span class="badge bg-info"><?php echo htmlspecialchars($v['specialization']); ?></span></td>
                <td><?php echo (int)($v['experience_years']); ?> yrs</td>
                <td><?php echo htmlspecialchars($v['clinic_address']); ?></td>
                <td><?php echo htmlspecialchars($v['city']); ?></td>
                <td><?php echo htmlspecialchars($v['country']); ?></td>
                <td>
                  <?php if($v['cnic_image'] && file_exists(__DIR__."/../../../".$v['cnic_image'])): ?>
                    <a href="<?php echo BASE.'/'.$v['cnic_image']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                  <?php else: ?>
                    <span class="badge bg-secondary">Not Uploaded</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if($v['status'] === 'active'): ?>
                    <span class="badge bg-success">Active</span>
                  <?php else: ?>
                    <span class="badge bg-warning"><?php echo htmlspecialchars($v['status']); ?></span>
                  <?php endif; ?>
                </td>
                <td><?php echo date("d M Y", strtotime($v['created_at'])); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

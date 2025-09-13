<?php
session_start();
require_once __DIR__."/../includes/db.php";
require_once __DIR__."/../includes/auth.php";
require_role('shelter');

// Fetch profile (graceful if table missing)
$u = user();
$profile = null;
try {
  $stmt = $conn->prepare("
    SELECT u.name, u.email, s.org_name, s.contact_name, s.phone, s.city, s.address, s.about
    FROM users u
    LEFT JOIN shelters s ON s.user_id = u.id
    WHERE u.id = ? LIMIT 1
  ");
  $stmt->bind_param("i", $u['id']);
  $stmt->execute();
  $profile = $stmt->get_result()->fetch_assoc();
} catch (Throwable $e) {
  $profile = ['name'=>$u['name'], 'email'=>$u['email']];
}

include __DIR__."/../includes/header.php";
?>
<div class="row g-3">
  <div class="col-lg-7">
    <div class="card card-soft p-4">
      <h2 class="h5 mb-3">Shelter Profile</h2>
      <dl class="row mb-0">
        <dt class="col-sm-3">Organization</dt>
        <dd class="col-sm-9"><?php echo htmlspecialchars($profile['org_name'] ?? $profile['name'] ?? ''); ?></dd>

        <dt class="col-sm-3">Contact</dt>
        <dd class="col-sm-9"><?php echo htmlspecialchars($profile['contact_name'] ?? '—'); ?></dd>

        <dt class="col-sm-3">Email</dt>
        <dd class="col-sm-9"><?php echo htmlspecialchars($profile['email'] ?? ''); ?></dd>

        <dt class="col-sm-3">Phone</dt>
        <dd class="col-sm-9"><?php echo htmlspecialchars($profile['phone'] ?? '—'); ?></dd>

        <dt class="col-sm-3">City</dt>
        <dd class="col-sm-9"><?php echo htmlspecialchars($profile['city'] ?? '—'); ?></dd>

        <dt class="col-sm-3">Address</dt>
        <dd class="col-sm-9"><?php echo htmlspecialchars($profile['address'] ?? '—'); ?></dd>

        <dt class="col-sm-3">About</dt>
        <dd class="col-sm-9"><?php echo nl2br(htmlspecialchars($profile['about'] ?? '—')); ?></dd>
      </dl>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card card-soft p-4">
      <h2 class="h6 mb-3">Quick Actions</h2>
      <div class="d-grid gap-2">
        <a class="btn btn-primary" href="#">Add Adoption Listing</a>
        <a class="btn btn-outline-primary" href="#">Manage Listings</a>
        <a class="btn btn-outline-primary" href="#">Update Profile</a>
      </div>
      <div class="small text-muted mt-3">
        Tip: keep your details updated to build adopter trust (phone, address, and mission statement).
      </div>
    </div>
  </div>
</div>
<?php include __DIR__."/../includes/footer.php"; ?>

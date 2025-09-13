<?php
session_start();
require_once __DIR__."/includes/db.php";
require_once __DIR__."/includes/auth.php";

$q = trim($_GET['q'] ?? '');
$like = "%$q%";
$pets=$vets=$products=[];

if ($q !== '') {
  // Pets
  $stmt=$conn->prepare("SELECT id,name,species,avatar FROM pets WHERE name LIKE ? OR species LIKE ? LIMIT 8");
  $stmt->bind_param("ss",$like,$like); $stmt->execute();
  $pets=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);

  // Vets
  $sql="SELECT u.id,u.name,v.specialization FROM users u JOIN vets v ON v.user_id=u.id
       WHERE u.role='vet' AND (u.name LIKE ? OR v.specialization LIKE ?) LIMIT 8";
  $stmt=$conn->prepare($sql); $stmt->bind_param("ss",$like,$like); $stmt->execute();
  $vets=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);

  // Products
  $stmt=$conn->prepare("SELECT id,name,price,image FROM products WHERE name LIKE ? LIMIT 8");
  $stmt->bind_param("s",$like); $stmt->execute();
  $products=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

include __DIR__."/includes/header.php";
?>
<h2 class="h5 mb-3">Search Results <?php if($q!=='') echo 'for “'.htmlspecialchars($q).'”'; ?></h2>

<?php if ($q===''): ?>
  <div class="alert alert-warning">Type something to search.</div>
<?php else: ?>
<div class="row g-3">
  <div class="col-md-4">
    <div class="card card-soft p-3 h-100">
      <h6 class="mb-3">Pets</h6>
      <?php if(!$pets): ?><div class="text-muted small">No pets found.</div><?php endif; ?>
      <?php foreach($pets as $p): ?>
        <a class="d-flex align-items-center gap-2 text-decoration-none mb-2" href="<?php echo BASE; ?>/owners/pet-view.php?id=<?php echo (int)$p['id']; ?>">
          <img src="<?php echo BASE.'/uploads/pets/'.htmlspecialchars($p['avatar'] ?: 'pet.png'); ?>" style="width:56px;height:56px;border-radius:10px;object-fit:cover;background:#f2f2f2" onerror="this.src='<?php echo BASE; ?>/assets/img/placeholder.png'">
          <div>
            <div class="small fw-semibold"><?php echo htmlspecialchars($p['name']); ?></div>
            <div class="small text-muted"><?php echo htmlspecialchars($p['species']??''); ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-soft p-3 h-100">
      <h6 class="mb-3">Vets</h6>
      <?php if(!$vets): ?><div class="text-muted small">No vets found.</div><?php endif; ?>
      <?php foreach($vets as $v): ?>
        <a class="d-flex align-items-center gap-2 text-decoration-none mb-2" href="<?php echo BASE; ?>/vets/dashboard.php?vid=<?php echo (int)$v['id']; ?>">
          <img src="<?php echo BASE; ?>/assets/img/vet.png" style="width:56px;height:56px;border-radius:10px;background:#f2f2f2">
          <div>
            <div class="small fw-semibold"><?php echo htmlspecialchars($v['name']); ?></div>
            <div class="small text-muted"><?php echo htmlspecialchars($v['specialization']??'Veterinarian'); ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-soft p-3 h-100">
      <h6 class="mb-3">Products</h6>
      <?php if(!$products): ?><div class="text-muted small">No products found.</div><?php endif; ?>
      <?php foreach($products as $p): ?>
        <a class="d-flex align-items-center gap-2 text-decoration-none mb-2" href="<?php echo BASE; ?>/product-detail.php?id=<?php echo (int)$p['id']; ?>">
          <img src="<?php echo BASE.'/uploads/products/'.htmlspecialchars($p['image'] ?: 'product.png'); ?>" style="width:56px;height:56px;border-radius:10px;object-fit:cover;background:#f2f2f2" onerror="this.src='<?php echo BASE; ?>/assets/img/placeholder.png'">
          <div>
            <div class="small fw-semibold"><?php echo htmlspecialchars($p['name']); ?></div>
            <div class="small text-muted">$<?php echo number_format((float)$p['price'], 2); ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>

<?php include __DIR__."/includes/footer.php"; ?>

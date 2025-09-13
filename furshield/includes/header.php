<?php
require_once __DIR__."/db.php";
require_once __DIR__."/auth.php";

$u = user();
$avatar = $u['avatar'] ?? 'avatar.png';
$avatarUrl = BASE.'/assets/img/'.$avatar;

// Cart count (session-based)
$cartCount = 0;
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
  foreach($_SESSION['cart'] as $it){ $cartCount += (int)($it['qty'] ?? 0); }
}

// Simple role → dashboard map
$dashUrl = BASE."/";
if ($u) {
  $map = [
    'owner'   => BASE.'/owners/dashboard.php',
    'vet'     => BASE.'/vets/dashboard.php',
    'shelter' => BASE.'/shelters/dashboard.php',
    'admin'   => BASE.'/admin/dashboard.php',
  ];
  $dashUrl = $map[$u['role']] ?? BASE.'/';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FurShield</title>

  <!-- Fonts + Bootstrap + Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Theme + App CSS -->
  <link rel="stylesheet" href="<?php echo BASE; ?>/assets/css/theme-sand-sunset.css">
  <link rel="stylesheet" href="<?php echo BASE; ?>/assets/css/style.css">
</head>
<body class="bg-app">
  <!-- Topbar -->
  <div class="topbar text-white small">
    <div class="container d-flex justify-content-between align-items-center py-1">
      <span class="opacity-75">🌍 International Competition Build</span>
      <span class="opacity-75">Owners • Vets • Shelters • Catalog</span>
    </div>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top bg-glass border-bottom">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE; ?>/">
        <span class="logo-badge me-2"><i class="bi bi-shield-heart text-white"></i></span>
        <span class="fw-bold brand-text">FurShield</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Desktop search -->
      <form action="<?php echo BASE; ?>/search.php" method="get" class="d-none d-lg-flex ms-3 flex-grow-1" role="search">
        <div class="search-wrap w-100">
          <i class="bi bi-search"></i>
          <input name="q" class="form-control" type="search" placeholder="Search pets, vets, products…" autocomplete="off">
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
        </div>
      </form>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-lg-3 me-auto my-2 my-lg-0">
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE; ?>/adoption.php">Adopt</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE; ?>/vets/dashboard.php">Vets</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE; ?>/product-list.php">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE; ?>/about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE; ?>/contact.php">Contact</a></li>
          
        </ul>

        <!-- Mobile search -->
        <form action="<?php echo BASE; ?>/search.php" method="get" class="d-lg-none mb-2" role="search">
          <div class="search-wrap w-100">
            <i class="bi bi-search"></i>
            <input name="q" class="form-control" type="search" placeholder="Search…" autocomplete="off">
            <button class="btn btn-primary btn-sm" type="submit">Go</button>
          </div>
        </form>

        <!-- Right side -->
        <?php if (!logged_in()) { ?>
          <div class="d-flex gap-2">
            <a href="<?php echo BASE; ?>/login.php" class="btn btn-outline-primary">Login</a>
            <a href="<?php echo BASE; ?>/register.php" class="btn btn-accent">Register</a>
            <a href="<?php echo BASE; ?>/register-vet.php" class="btn btn-primary">Register as Vet</a>
            <a href="<?php echo BASE; ?>/register-shelter.php" class="btn btn-outline-primary">Register Shelter</a>

          </div>
        <?php } else { ?>
          <div class="d-flex align-items-center gap-3">
            <a href="<?php echo BASE; ?>/cart.php" class="btn btn-outline-primary position-relative">
              <i class="bi bi-cart"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount"><?php echo (int)$cartCount; ?></span>
            </a>

            <div class="dropdown">
              <a class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" href="#">
                <img src="<?php echo $avatarUrl; ?>" onerror="this.src='<?php echo BASE; ?>/assets/img/avatar.png'" class="rounded-circle me-2" width="34" height="34" alt="">
                <div class="lh-1 me-2">
                  <div class="fw-semibold small"><?php echo htmlspecialchars($u['name']); ?></div>
                  <div class="badge bg-light text-dark text-capitalize"><?php echo htmlspecialchars($u['role']); ?></div>
                </div>
                <i class="bi bi-caret-down-fill small ms-1"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow">
                <li><a class="dropdown-item" href="<?php echo $dashUrl; ?>">Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?php echo BASE; ?>/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
              </ul>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </nav>

  <!-- Page wrapper -->
  <main class="py-4">
    <div class="container">

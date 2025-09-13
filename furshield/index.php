<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'ur'], true)) $_SESSION['lang'] = $_GET['lang'];
$lang = $_SESSION['lang'] ?? 'en';

$t = [
  'en' => [
    'find_vet' => 'Find a Vet',
    'adopt_pet' => 'Adopt a Pet',
    'browse_products' => 'Browse Products',
    'view_all' => 'View All',
    'built_for' => 'Built for every role',
    'owners' => 'Owners',
    'vets' => 'Vets',
    'shelters' => 'Shelters',
    'explore' => 'Explore',
    'adoption_h' => 'Adoption Highlights',
    'products_h' => 'Top Products',
    'blogs_h' => 'Care Guides & Blogs',
    'read_more' => 'Read more',
    'vet_cta_h' => 'Join verified vets & serve the community',
    'vet_cta_p' => 'Manage availability, appointments & treatment notes.',
    'register_vet' => 'Register as Vet',
    'see_vets' => 'See Vets',
    'testimonials_h' => 'What our community says',
    'faq_h' => 'Frequently Asked Questions',
    'stats_h' => 'Our impact',
    'pets' => 'Pets',
    'verified_vets' => 'Verified Vets',
    'active_shelters' => 'Active Shelters',
    'gallery_h' => 'Community Gallery',
    'events_h' => 'Upcoming Events',
    'newsletter_h' => 'Stay updated with FurShield',
    'newsletter_p' => 'Get tips, drives & product news.',
    'subscribe' => 'Subscribe',
    'how_h' => 'How it works',
    'city_h' => 'Browse by City',
    'success_h' => 'Success Stories',
    'brands_h' => 'Featured Brands',
    'search_ph' => 'Search pets, vets, products…',
    'open_dash' => 'Open Dashboard',
    'adopt_now' => 'Adopt Now'
  ]
];

function rows($conn, $sql)
{
  $res = @$conn->query($sql);
  return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}
function row($conn, $sql)
{
  $res = @$conn->query($sql);
  return $res ? $res->fetch_assoc() : null;
}

$settings = row($conn, "SELECT * FROM homepage_settings WHERE id=1");
$hero_title = $settings['hero_title'] ?? "Your pet’s health, organized & care made simple.";
$hero_sub = $settings['hero_subtitle'] ?? "Owners, Vets & Shelters: appointments, health records, adoption, and curated products.";
$hero_img = $settings['hero_image'] ?? BASE . "/assets/img/hero-sand.jpg";
$c1t = $settings['cta_primary_text'] ?? $t[$lang]['find_vet'];
$c1u = $settings['cta_primary_url'] ?? BASE . "/vets.php";
$c2t = $settings['cta_secondary_text'] ?? $t[$lang]['adopt_pet'];
$c2u = $settings['cta_secondary_url'] ?? BASE . "/adopt.php";

$adopt_mode = $settings['adoption_mode'] ?? 'latest';
$prod_mode  = $settings['products_mode'] ?? 'latest';

$counts = [
  'pets' => (int)($conn->query("SELECT COUNT(*) c FROM pets")->fetch_assoc()['c'] ?? 0),
  'vets' => (int)($conn->query("SELECT COUNT(*) c FROM users WHERE role='vet' AND status='active'")->fetch_assoc()['c'] ?? 0),
  'shel' => (int)($conn->query("SELECT COUNT(*) c FROM users WHERE role='shelter' AND status='active'")->fetch_assoc()['c'] ?? 0),
];

$pets = rows($conn, $adopt_mode === 'featured'
  ? "SELECT * FROM pets WHERE featured=1 ORDER BY id DESC LIMIT 6"
  : "SELECT * FROM pets ORDER BY id DESC LIMIT 6");

$urgent = rows($conn, "SELECT * FROM pets WHERE spotlight=1 OR (urgent_until IS NOT NULL AND urgent_until>=CURDATE()) ORDER BY COALESCE(urgent_until, NOW()) ASC LIMIT 3");
$products = rows($conn, $prod_mode === 'featured'
  ? "SELECT * FROM products WHERE featured=1 ORDER BY id DESC LIMIT 4"
  : "SELECT * FROM products ORDER BY id DESC LIMIT 4");
$blogs = rows($conn, "SELECT id,title,image,created_at FROM blogs WHERE is_active=1 ORDER BY id DESC LIMIT 4");
$faqs  = rows($conn, "SELECT id,question,answer FROM faqs WHERE is_active=1 ORDER BY id DESC LIMIT 6");
$testimonials = rows($conn, "SELECT name,role,rating,message,avatar FROM testimonials WHERE is_active=1 ORDER BY id DESC LIMIT 10");
$gallery = rows($conn, "SELECT image,caption FROM gallery WHERE is_approved=1 ORDER BY id DESC LIMIT 6");
$events  = rows($conn, "SELECT id,title,date,city,image,link FROM events WHERE is_active=1 AND date>=CURDATE() ORDER BY date ASC LIMIT 4");
$cities  = rows($conn, "SELECT DISTINCT city FROM shelters WHERE city IS NOT NULL AND city<>'' ORDER BY city LIMIT 8");
$brands  = rows($conn, "SELECT logo,link FROM brands WHERE is_active=1 ORDER BY id DESC LIMIT 8");
$stories = rows($conn, "SELECT id,pet_id,title,image,summary FROM stories WHERE is_active=1 ORDER BY id DESC LIMIT 3");
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="bg-light" style="background:var(--bg);">
  <!-- Hero -->
  <section class="py-5 py-lg-6 position-relative hero-section">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-7">
          <h1 class="display-5 fw-bold hero-title"><?php echo htmlspecialchars($hero_title); ?></h1>
          <p class="lead text-secondary mb-4"><?php echo htmlspecialchars($hero_sub); ?></p>
          <form class="d-flex mb-4" role="search" action="<?php echo BASE . '/search.php'; ?>">
            <input name="q" class="form-control form-control-lg me-2" placeholder="<?php echo $t[$lang]['search_ph']; ?>" />
            <button class="btn btn-lg btn-warning" style="background:var(--primary);border:none">
              <i class="bi bi-search me-1"></i><?php echo $t[$lang]['browse_products']; ?>
            </button>
          </form>
          <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-lg btn-warning" href="<?php echo htmlspecialchars($c1u); ?>" style="background:var(--primary);border:none">
              <i class="bi bi-heart-pulse me-1"></i><?php echo htmlspecialchars($c1t); ?>
            </a>
            <a class="btn btn-lg btn-outline-danger" href="<?php echo htmlspecialchars($c2u); ?>">
              <i class="bi bi-paw me-1"></i><?php echo htmlspecialchars($c2t); ?>
            </a>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card border-0 shadow" style="border-radius:var(--radius)">
            <img src="<?php echo htmlspecialchars($hero_img); ?>" class="card-img-top" alt="FurShield" style="object-fit:cover;height:300px;border-top-left-radius:var(--radius);border-top-right-radius:var(--radius)">
            <div class="card-body">
              <div class="d-flex justify-content-between small text-muted">
                <span><?php echo $counts['vets']; ?> <?php echo $t[$lang]['verified_vets']; ?></span>
                <span><?php echo $counts['shel']; ?> <?php echo $t[$lang]['active_shelters']; ?></span>
                <span><?php echo $counts['pets']; ?> <?php echo $t[$lang]['pets']; ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Roles -->
  <section class="py-5">
    <div class="container">
      <div class="d-flex align-items-center mb-4">
        <h2 class="h3 m-0"><?php echo $t[$lang]['built_for']; ?></h2>
      </div>
      <div class="row g-3">
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h3 class="h5"><?php echo $t[$lang]['owners']; ?></h3>
              <p class="text-muted">Create pet profiles, track health, set reminders.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h3 class="h5"><?php echo $t[$lang]['vets']; ?></h3>
              <p class="text-muted">Manage slots, appointments & treatment notes.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h3 class="h5"><?php echo $t[$lang]['shelters']; ?></h3>
              <p class="text-muted">List adoptable pets & handle interest.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Browse by City -->
  <?php if ($cities) { ?><section class="py-4 bg-white">
      <div class="container">
        <h2 class="h4"><?php echo $t[$lang]['city_h']; ?></h2>
        <div class="d-flex flex-wrap gap-2"><?php foreach ($cities as $c): ?><a class="btn btn-sm btn-outline-secondary" href="<?php echo BASE . '/adopt.php?city=' . urlencode($c['city']); ?>"><?php echo htmlspecialchars($c['city']); ?></a><?php endforeach; ?></div>
      </div>
    </section><?php } ?>

  <!-- Urgent -->
  <?php if ($urgent) { ?><section class="py-4">
      <div class="container">
        <div class="alert alert-danger"><i class="bi bi-exclamation-octagon me-2"></i><?php foreach ($urgent as $u) {
                                                                                        echo '<a class="link-dark me-3" href="' . BASE . '/pet.php?id=' . $u['id'] . '">' . htmlspecialchars($u['name']) . '</a>';
                                                                                      } ?></div>
      </div>
    </section><?php } ?>

  <!-- Pets -->
  <section class="py-5">
    <div class="container">
      <h2 class="h3 mb-3"><?php echo $t[$lang]['adoption_h']; ?></h2>
      <div class="row g-4"><?php foreach ($pets as $p): ?><div class="col-6 col-md-4 col-lg-3">
            <div class="pet-card">
              <div class="pet-thumb"><img src="<?php echo BASE . '/uploads/pets/' . htmlspecialchars($p['avatar']); ?>"></div>
              <div class="pet-body">
                <h5><?php echo htmlspecialchars($p['name']); ?></h5>
                <div class="pet-badges"><span class="badge"><?php echo htmlspecialchars($p['species']); ?></span><span class="badge"><?php echo htmlspecialchars($p['breed']); ?></span><?php if (!empty($p['city'])): ?><span class="badge"><?php echo htmlspecialchars($p['city']); ?></span><?php endif; ?></div><a href="<?php echo BASE . '/pet.php?id=' . $p['id']; ?>" class="btn btn-sm btn-outline-primary"><?php echo $t[$lang]['adopt_now']; ?></a>
              </div>
            </div>
          </div><?php endforeach; ?></div>
    </div>
  </section>

  <!-- Stats -->
  <section class="py-5 bg-white">
    <div class="container">
      <h2 class="h3 mb-4"><?php echo $t[$lang]['stats_h']; ?></h2>
      <div class="row g-3 text-center">
        <div class="col-4">
          <div class="stat-card">
            <div class="stat-num counter" data-target="<?php echo $counts['pets']; ?>">0</div>
            <div class="small text-muted"><?php echo $t[$lang]['pets']; ?></div>
          </div>
        </div>
        <div class="col-4">
          <div class="stat-card">
            <div class="stat-num counter" data-target="<?php echo $counts['vets']; ?>">0</div>
            <div class="small text-muted"><?php echo $t[$lang]['verified_vets']; ?></div>
          </div>
        </div>
        <div class="col-4">
          <div class="stat-card">
            <div class="stat-num counter" data-target="<?php echo $counts['shel']; ?>">0</div>
            <div class="small text-muted"><?php echo $t[$lang]['active_shelters']; ?></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Products -->
<section class="py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="h3 m-0"><?php echo $t[$lang]['products_h']; ?></h2>
      <a class="btn btn-sm btn-outline-secondary" href="<?php echo BASE.'/catalog.php'; ?>">
        <?php echo $t[$lang]['view_all']; ?>
      </a>
    </div>
    <div class="row g-4">
      <?php foreach ($products as $pr): ?>
        <div class="col-6 col-md-3">
          <div class="card h-100 shadow-sm" style="border-radius:var(--radius)">
            <img src="<?php echo BASE.'/uploads/products/'.htmlspecialchars($pr['image']); ?>"
                 class="card-img-top prod-img"
                 alt="<?php echo htmlspecialchars($pr['name']); ?>">
            <div class="card-body d-flex flex-column">
              <h6 class="fw-semibold mb-1"><?php echo htmlspecialchars($pr['name']); ?></h6>
              <div class="text-muted mb-2">$<?php echo number_format((float)$pr['price'],2); ?></div>
              <div class="mt-auto d-flex gap-2">
                <a href="<?php echo BASE.'product.php?id='.$pr['id']; ?>"
                   class="btn btn-sm btn-outline-secondary flex-grow-1">
                   View
                </a>
                <a href="<?php echo BASE.'/actions/cart-add.php?id='.$pr['id']; ?>"
                   class="btn btn-sm btn-warning flex-grow-1"
                   style="background:var(--primary);border:none">
                   Add to Cart
                </a>
                <a href="<?php echo BASE.'/actions/wishlist-add.php?id='.$pr['id']; ?>"
                   class="btn btn-sm btn-outline-danger"
                   title="Add to Wishlist">
                   <i class="bi bi-heart"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; if(!$products){ echo '<p class="text-muted">No products yet.</p>'; } ?>
    </div>
  </div>
</section>


  <!-- Blogs -->
  <section class="py-5 bg-white">
    <div class="container">
      <h2 class="h3 mb-3"><?php echo $t[$lang]['blogs_h']; ?></h2>
      <div class="row g-3"><?php foreach ($blogs as $b): ?><div class="col-md-3 col-6">
            <div class="card"><img src="<?php echo BASE . '/uploads/blog/' . htmlspecialchars($b['image']); ?>">
              <div class="card-body">
                <h6><?php echo htmlspecialchars($b['title']); ?></h6>
              </div>
            </div>
          </div><?php endforeach; ?></div>
    </div>
  </section>

  <!-- Stories -->
  <?php if ($stories) { ?><section class="py-5">
      <div class="container">
        <h2 class="h3 mb-3"><?php echo $t[$lang]['success_h']; ?></h2>
        <div class="row g-3"><?php foreach ($stories as $s): ?><div class="col-md-4">
              <div class="card"><img src="<?php echo BASE . '/uploads/stories/' . htmlspecialchars($s['image']); ?>">
                <div class="card-body">
                  <h6><?php echo htmlspecialchars($s['title']); ?></h6>
                  <p><?php echo htmlspecialchars(mb_strimwidth($s['summary'], 0, 100, '…')); ?></p>
                </div>
              </div>
            </div><?php endforeach; ?></div>
      </div>
    </section><?php } ?>

  <!-- Testimonials -->
  <?php if ($testimonials) { ?><section class="py-5 bg-white">
      <div class="container">
        <h2 class="h3 mb-3"><?php echo $t[$lang]['testimonials_h']; ?></h2>
        <div class="row g-3"><?php foreach ($testimonials as $ts): ?><div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h6><?php echo htmlspecialchars($ts['name']); ?></h6>
                  <p><?php echo htmlspecialchars($ts['message']); ?></p>
                </div>
              </div>
            </div><?php endforeach; ?></div>
      </div>
    </section><?php } ?>

  <!-- FAQ -->
  <section class="py-5">
    <div class="container">
      <h2 class="h3 mb-3"><?php echo $t[$lang]['faq_h']; ?></h2>
      <div class="accordion" id="faqAcc"><?php $i = 0;
                                          foreach ($faqs as $f): $i++; ?><div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button <?php echo $i > 1 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#f<?php echo $i; ?>"><?php echo htmlspecialchars($f['question']); ?></button></h2>
            <div id="f<?php echo $i; ?>" class="accordion-collapse collapse <?php echo $i === 1 ? 'show' : ''; ?>">
              <div class="accordion-body"><?php echo nl2br(htmlspecialchars($f['answer'])); ?></div>
            </div>
          </div><?php endforeach; ?></div>
    </div>
  </section>

  <!-- Gallery -->
  <?php if ($gallery) { ?><section class="py-5 bg-white">
      <div class="container">
        <h2 class="h3 mb-3"><?php echo $t[$lang]['gallery_h']; ?></h2>
        <div class="row g-3"><?php foreach ($gallery as $g): ?><div class="col-6 col-md-3"><a href="<?php echo BASE . '/uploads/gallery/' . htmlspecialchars($g['image']); ?>"><img src="<?php echo BASE . '/uploads/gallery/' . htmlspecialchars($g['image']); ?>" class="img-fluid rounded"></a></div><?php endforeach; ?></div>
      </div>
    </section><?php } ?>

  <!-- Events -->
  <?php if ($events) { ?><section class="py-5">
      <div class="container">
        <h2 class="h3 mb-3"><?php echo $t[$lang]['events_h']; ?></h2>
        <div class="row g-3"><?php foreach ($events as $e): ?><div class="col-md-3">
              <div class="card"><img src="<?php echo BASE . '/uploads/events/' . htmlspecialchars($e['image']); ?>">
                <div class="card-body">
                  <h6><?php echo htmlspecialchars($e['title']); ?></h6><small><?php echo date('M d, Y', strtotime($e['date'])); ?> - <?php echo htmlspecialchars($e['city']); ?></small>
                </div>
              </div>
            </div><?php endforeach; ?></div>
      </div>
    </section><?php } ?>

  <!-- Newsletter -->
  <section class="py-5 bg-white">
    <div class="container">
      <div class="row g-3 align-items-center">
        <div class="col-md-6">
          <h3><?php echo $t[$lang]['newsletter_h']; ?></h3>
          <p><?php echo $t[$lang]['newsletter_p']; ?></p>
        </div>
        <div class="col-md-6">
          <form method="post" action="<?php echo BASE . '/newsletter-subscribe.php'; ?>" class="d-flex"><input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf_token']; ?>"><input type="email" required name="email" class="form-control me-2" placeholder="you@email.com"><button class="btn btn-warning" style="background:var(--primary);border:none"><?php echo $t[$lang]['subscribe']; ?>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
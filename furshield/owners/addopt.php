<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>FurShield • Adoption</title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>

  <style>
    :root{
      --primary:#F59E0B;
      --accent:#EF4444;
      --bg:#FFF7ED;
      --text:#1F2937;
      --card:#FFFFFF;
      --muted:#6B7280;
      --border:#f1e6d7;
      --radius:18px;
      --shadow:0 10px 30px rgba(0,0,0,.08);
      --shadow-sm:0 6px 16px rgba(0,0,0,.06);
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{margin:0}
    body.bg-app{background:var(--bg);color:var(--text);font-family:Poppins,system-ui,sans-serif;line-height:1.5}

    /* Page shell */
    .page{margin-left:280px;padding:28px 24px 60px}

    /* Head */
    .page-head{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:18px}
    .page-title h1{margin:0;font-family:Montserrat,sans-serif;font-size:28px}
    .breadcrumbs{font-size:13px;color:var(--muted)}
    .tag{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:999px;background:#fff;border:1px solid var(--border);font-size:12px}

    /* Cards */
    .card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:18px;box-shadow:var(--shadow)}
    .card-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
    .card-head h2{margin:0;font-family:Montserrat,sans-serif;font-size:20px}
    .muted{color:var(--muted)}

    /* Controls */
    .toolbar{display:flex;flex-wrap:wrap;gap:10px;align-items:center;margin-bottom:12px}
    .input,.select{border:1px solid var(--border);background:#fff;border-radius:12px;padding:10px 12px;font-size:14px;outline:0}
    .input:focus,.select:focus{box-shadow:0 0 0 4px #ffe7c6;border-color:#f2cf97}
    .btn{display:inline-flex;align-items:center;gap:8px;border:0;border-radius:12px;padding:10px 14px;cursor:pointer;font-weight:600}
    .btn-primary{background:linear-gradient(135deg,var(--primary),#ffb444);color:#fff}
    .btn-ghost{background:#fff;border:1px solid var(--border);color:#92400e}
    .btn-danger{background:linear-gradient(135deg,#f87171,#ef4444);color:#fff}
    .stat{display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:999px;background:#fff;border:1px solid var(--border);font-weight:600}

    /* Catalog grid */
    .grid-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
    .pet-card{display:grid;grid-template-rows:auto 1fr auto;gap:8px;border:1px solid var(--border);border-radius:16px;background:#fff;overflow:hidden;box-shadow:var(--shadow-sm)}
    .pet-card .thumb{aspect-ratio:16/11;width:100%;object-fit:cover}
    .pet-card .content{padding:12px}
    .pet-card b{font-family:Montserrat,sans-serif}
    .meta{font-size:13px;color:var(--muted)}
    .chips{display:flex;gap:6px;flex-wrap:wrap;margin-top:8px}
    .chip{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:999px;border:1px solid var(--border);background:#fff;font-size:12px}
    .chip.ok{background:#ecfdf5;border-color:#bbf7d0;color:#047857}
    .chip.info{background:#eef2ff;border-color:#e0e7ff;color:#3730a3}
    .card-actions{display:flex;gap:8px;align-items:center;padding:12px;border-top:1px dashed #f3e7d9}
    .pill{display:inline-flex;align-items:center;gap:6px;padding:8px 12px;border-radius:999px;background:linear-gradient(135deg,var(--primary),#ffb444);color:#fff;font-weight:600;font-size:13px;text-decoration:none;cursor:pointer}
    .pill.ghost{background:#fff;border:1px solid var(--border);color:#92400e}

    /* Table (requests) */
    .table-wrap{overflow:auto;border:1px solid var(--border);border-radius:14px}
    table{width:100%;border-collapse:separate;border-spacing:0}
    thead th{position:sticky;top:0;background:#fff7ef;border-bottom:1px solid var(--border);text-align:left;font-size:13px;padding:12px;color:#92400e}
    tbody td{padding:12px;border-bottom:1px solid #f6efe4;font-size:14px;vertical-align:middle}
    tbody tr:hover{background:#fffdfa}
    .icon-btn{display:grid;place-items:center;width:36px;height:36px;border-radius:10px;background:#fff;border:1px solid var(--border);cursor:pointer}
    .icon-btn:hover{box-shadow:var(--shadow-sm);transform:translateY(-1px)}
    .chip.warn{background:#fff7ed;border-color:#fde68a;color:#b45309}
    .chip.danger{background:#fee2e2;border-color:#fecaca;color:#b91c1c}
    .empty{padding:24px;text-align:center;color:var(--muted)}

    /* Responsive */
    @media (max-width: 1280px){ .grid-cards{grid-template-columns:repeat(3,1fr)} }
    @media (max-width: 860px){ .grid-cards{grid-template-columns:repeat(2,1fr)} }
    @media (max-width: 640px){
      .page{margin-left:0}
      .grid-cards{grid-template-columns:1fr}
    }
  </style>
</head>
<body class="bg-app">

<?php include("sidebar.php")?>

<main class="page">
  <div class="page-head">
    <div class="page-title">
      <div class="breadcrumbs">Owner • Adoption</div>
      <h1>Adoption</h1>
    </div>
    <span class="tag"><i class="bi bi-heart"></i> Find a Friend</span>
  </div>

  <!-- Catalog -->
  <section class="card">
    <div class="card-head">
      <h2>Browse Pets</h2>
      <div class="stat"><i class="bi bi-clipboard-heart"></i> Requests: <span id="reqCount">0</span></div>
    </div>

    <div class="toolbar">
      <select class="select" id="fSpecies">
        <option value="All">All Species</option>
        <option>Dog</option>
        <option>Cat</option>
        <option>Bird</option>
        <option>Rabbit</option>
        <option>Other</option>
      </select>
      <select class="select" id="fGender">
        <option value="All">Any Gender</option>
        <option>Male</option>
        <option>Female</option>
      </select>
      <select class="select" id="fAge">
        <option value="All">Any Age</option>
        <option value="<1">Less than 1y</option>
        <option value="1-3">1–3 years</option>
        <option value=">3">Over 3y</option>
      </select>
      <select class="select" id="fCity">
        <option value="All">All Cities</option>
        <option>Karachi</option>
        <option>Lahore</option>
        <option>Islamabad</option>
        <option>Multan</option>
        <option>Faisalabad</option>
      </select>
      <input class="input" id="search" placeholder="Search name, breed, shelter…"/>
      <button class="btn btn-ghost" id="clearFilters"><i class="bi bi-eraser"></i> Clear</button>
    </div>

    <div class="grid-cards" id="catalogGrid">
      <!-- cards go here -->
    </div>
  </section>

  <!-- Requests -->
  <section class="card" style="margin-top:16px">
    <div class="card-head">
      <h2>My Requests</h2>
      <select class="select" id="reqStatusFilter" style="min-width:180px">
        <option value="All">All Status</option>
        <option value="Pending">Pending</option>
        <option value="Approved">Approved</option>
        <option value="Rejected">Rejected</option>
        <option value="Cancelled">Cancelled</option>
      </select>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Pet</th>
            <th>Species / Breed</th>
            <th>City • Shelter</th>
            <th>Applied On</th>
            <th>Status</th>
            <th style="width:160px">Actions</th>
          </tr>
        </thead>
        <tbody id="reqTbody">
          <tr><td colspan="6" class="empty">No adoption requests yet.</td></tr>
        </tbody>
      </table>
    </div>
  </section>
</main>

<script>
(() => {
  const LS_PETS = 'fs_shelter_pets';
  const LS_REQS = 'fs_adoption_requests';
  const $ = id => document.getElementById(id);

  let catalog = [];
  let requests = [];

  // ------ Seeds (Catalog) ------
  const seeds = [
    {id:'p1', name:'Bella', species:'Dog', breed:'Beagle', gender:'Female', ageMonths:24, city:'Karachi', shelter:'PAWS Karachi',
      tags:['Vaccinated','Good with kids'],
      img:'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=800&auto=format&fit=crop'},
    {id:'p2', name:'Snow', species:'Cat', breed:'Turkish Angora', gender:'Female', ageMonths:12, city:'Lahore', shelter:'Lahore Rescue',
      tags:['Spayed'],
      img:'https://images.unsplash.com/photo-1516726817505-f5ed825624d8?q=80&w=800&auto=format&fit=crop'},
    {id:'p3', name:'Rex', species:'Dog', breed:'German Shepherd', gender:'Male', ageMonths:48, city:'Islamabad', shelter:'Capital Shelter',
      tags:['Trained'],
      img:'https://images.unsplash.com/photo-1567752881298-894bb81f9379?q=80&w=800&auto=format&fit=crop'},
    {id:'p4', name:'Kiwi', species:'Bird', breed:'Macaw', gender:'Male', ageMonths:20, city:'Karachi', shelter:'Birds Haven',
      tags:['Hand-raised'],
      img:'https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=800&auto=format&fit=crop'},
    {id:'p5', name:'Misty', species:'Cat', breed:'Persian', gender:'Female', ageMonths:36, city:'Multan', shelter:'Multan Animal Care',
      tags:['Vaccinated'],
      img:'https://images.unsplash.com/photo-1511044568932-338cba0ad803?q=80&w=800&auto=format&fit=crop'},
    {id:'p6', name:'Coco', species:'Rabbit', breed:'Mini Lop', gender:'Male', ageMonths:8, city:'Faisalabad', shelter:'FSD Shelter',
      tags:['Gentle'],
      img:'https://images.unsplash.com/photo-1547733549-77dfa4dcb83e?q=80&w=800&auto=format&fit=crop'},
    {id:'p7', name:'Tiger', species:'Cat', breed:'Tabby', gender:'Male', ageMonths:6, city:'Karachi', shelter:'Street Savers',
      tags:['Dewormed'],
      img:'https://images.unsplash.com/photo-1543852786-1cf6624b9987?q=80&w=800&auto=format&fit=crop'},
    {id:'p8', name:'Luna', species:'Dog', breed:'Labrador', gender:'Female', ageMonths:30, city:'Lahore', shelter:'Lahore Rescue',
      tags:['Vaccinated','Friendly'],
      img:'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?q=80&w=800&auto=format&fit=crop'}
  ];

  // ------ Elements ------
  const grid = $('catalogGrid');
  const reqTbody = $('reqTbody');
  const reqCount = $('reqCount');

  const fSpecies = $('fSpecies');
  const fGender  = $('fGender');
  const fAge     = $('fAge');
  const fCity    = $('fCity');
  const search   = $('search');
  const clearFilters = $('clearFilters');
  const reqStatusFilter = $('reqStatusFilter');

  // ------ Helpers ------
  function load(){
    const rawC = localStorage.getItem(LS_PETS);
    const rawR = localStorage.getItem(LS_REQS);
    catalog = rawC ? safeJSON(rawC, []) : seeds;
    requests = rawR ? safeJSON(rawR, []) : [];
    if (!rawC) localStorage.setItem(LS_PETS, JSON.stringify(seeds));
  }
  function save(){ localStorage.setItem(LS_REQS, JSON.stringify(requests)); }
  function safeJSON(str, fallback){ try { return JSON.parse(str); } catch { return fallback; } }

  function ageLabel(mo){
    if (mo < 12) return `${mo} mo`;
    const y = Math.floor(mo/12), r = mo%12;
    return r ? `${y}y ${r}mo` : `${y}y`;
  }

  function matchesAge(mo, rule){
    if (rule==='All') return true;
    if (rule==='<1') return mo < 12;
    if (rule==='1-3') return mo >= 12 && mo <= 36;
    if (rule==='>3') return mo > 36;
    return true;
  }

  function hasActiveRequest(petId){
    return requests.some(r => r.petId === petId && r.status !== 'Cancelled');
  }

  function todayISO(){
    const d = new Date();
    return d.toISOString().slice(0,10);
  }

  // ------ Render Catalog ------
  function renderCatalog(){
    const sp = fSpecies.value;
    const gd = fGender.value;
    const ag = fAge.value;
    const ct = fCity.value;
    const q  = (search.value||'').trim().toLowerCase();

    const filtered = catalog.filter(p => {
      const okSp = sp==='All' || p.species===sp;
      const okG  = gd==='All' || p.gender===gd;
      const okA  = matchesAge(p.ageMonths, ag);
      const okC  = ct==='All' || p.city===ct;
      const hay  = `${p.name} ${p.breed} ${p.shelter}`.toLowerCase();
      const okQ  = !q || hay.includes(q);
      return okSp && okG && okA && okC && okQ;
    });

    grid.innerHTML = filtered.map(p => {
      const disabled = hasActiveRequest(p.id);
      return `
        <div class="pet-card">
          <img class="thumb" src="${p.img}" alt="${p.name}">
          <div class="content">
            <b>${p.name}</b>
            <div class="meta">${p.species} • ${p.breed || '-'} • ${p.gender} • ${ageLabel(p.ageMonths)}</div>
            <div class="meta"><i class="bi bi-geo-alt"></i> ${p.city} • ${p.shelter}</div>
            <div class="chips">
              ${p.tags.map(t=>`<span class="chip ${t==='Vaccinated'?'ok':'info'}">${t}</span>`).join('')}
            </div>
          </div>
          <div class="card-actions">
            <button class="pill" data-action="apply" data-id="${p.id}" ${disabled?'disabled':''}>
              <i class="bi bi-heart"></i> ${disabled?'Requested':'Apply'}
            </button>
            <button class="pill ghost" data-action="details" data-id="${p.id}">
              <i class="bi bi-eye"></i> Details
            </button>
          </div>
        </div>
      `;
    }).join('') || `<div class="empty" style="grid-column:1/-1">No pets found. Try different filters.</div>`;
  }

  // ------ Render Requests ------
  function chip(status){
    if (status==='Approved') return '<span class="chip ok"><i class="bi bi-check2-circle"></i> Approved</span>';
    if (status==='Pending')  return '<span class="chip warn"><i class="bi bi-hourglass-split"></i> Pending</span>';
    if (status==='Rejected') return '<span class="chip danger"><i class="bi bi-x-circle"></i> Rejected</span>';
    return '<span class="chip"><i class="bi bi-slash-circle"></i> Cancelled</span>';
  }

  function renderRequests(){
    reqCount.textContent = requests.length;

    const st = reqStatusFilter.value;
    const rows = requests
      .filter(r => st==='All' || r.status===st)
      .map(r => {
        const p = catalog.find(x => x.id === r.petId);
        if (!p) return '';
        const canCancel = r.status==='Pending';
        const canDelete = r.status==='Cancelled' || r.status==='Rejected' || r.status==='Approved';
        return `
          <tr data-id="${r.id}">
            <td><b>${p.name}</b></td>
            <td>${p.species}${p.breed? ' • '+p.breed:''}</td>
            <td>${p.city} • <span class="muted">${p.shelter}</span></td>
            <td>${r.appliedOn}</td>
            <td>${chip(r.status)}</td>
            <td>
              ${canCancel ? `<button class="icon-btn" data-action="cancel" title="Cancel Request"><i class="bi bi-slash-circle"></i></button>` : ''}
              ${canDelete ? `<button class="icon-btn" data-action="delete" title="Remove from history"><i class="bi bi-trash3"></i></button>` : ''}
            </td>
          </tr>
        `;
      })
      .filter(Boolean)
      .join('');

    reqTbody.innerHTML = rows || `<tr><td colspan="6" class="empty">No matching requests.</td></tr>`;
  }

  // ------ Actions ------
  function applyForPet(petId){
    if (hasActiveRequest(petId)) return alert('You already have an active request for this pet.');
    const pet = catalog.find(p=>p.id===petId);
    if (!pet) return;
    if (!confirm(`Send adoption request for ${pet.name}?`)) return;
    const req = {
      id: 'r_'+(Date.now().toString(36)+Math.random().toString(36).slice(2,8)),
      petId,
      appliedOn: todayISO(),
      status: 'Pending'
    };
    requests.unshift(req);
    save();
    renderCatalog();
    renderRequests();
  }

  function cancelRequest(id){
    const idx = requests.findIndex(r=>r.id===id);
    if (idx<0) return;
    const pet = catalog.find(p=>p.id===requests[idx].petId);
    if (!confirm(`Cancel request for ${pet?.name || 'this pet'}?`)) return;
    requests[idx].status = 'Cancelled';
    save();
    renderCatalog();
    renderRequests();
  }

  function deleteRequest(id){
    const idx = requests.findIndex(r=>r.id===id);
    if (idx<0) return;
    const pet = catalog.find(p=>p.id===requests[idx].petId);
    if (!confirm(`Remove ${pet?.name || 'this pet'} from your history?`)) return;
    requests.splice(idx,1);
    save();
    renderCatalog();
    renderRequests();
  }

  // ------ Events ------
  grid.addEventListener('click', (e)=>{
    const btn = e.target.closest('button');
    if (!btn) return;
    const id = btn.dataset.id;
    const action = btn.dataset.action;
    if (action==='apply') applyForPet(id);
    if (action==='details'){
      const p = catalog.find(x=>x.id===id);
      if (!p) return;
      alert(`${p.name}\n${p.species} • ${p.breed || '-'} • ${p.gender} • ${ageLabel(p.ageMonths)}\n${p.city} • ${p.shelter}\nTags: ${p.tags.join(', ')}`);
    }
  });

  reqTbody.addEventListener('click', (e)=>{
    const btn = e.target.closest('button.icon-btn');
    if (!btn) return;
    const tr = btn.closest('tr');
    const id = tr.dataset.id;
    const action = btn.dataset.action;
    if (action==='cancel') cancelRequest(id);
    if (action==='delete') deleteRequest(id);
  });

  [fSpecies,fGender,fAge,fCity].forEach(el => el.addEventListener('change', renderCatalog));
  search.addEventListener('input', renderCatalog);
  clearFilters.addEventListener('click', ()=>{ fSpecies.value='All'; fGender.value='All'; fAge.value='All'; fCity.value='All'; search.value=''; renderCatalog(); });
  reqStatusFilter.addEventListener('change', renderRequests);

  // Init
  load();
  renderCatalog();
  renderRequests();
})();
</script>
</body>
</html>

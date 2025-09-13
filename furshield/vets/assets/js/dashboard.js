(function(){
  const s = getComputedStyle(document.documentElement);
  const cPrimary = s.getPropertyValue('--primary').trim() || '#F59E0B';
  const cAccent  = s.getPropertyValue('--accent').trim()  || '#EF4444';
  const cText    = s.getPropertyValue('--text').trim()    || '#1F2937';
  const cGrid    = 'rgba(0,0,0,.06)';

  const dash = window.__DASH || { line:{labels:[],data:[]}, doughnut:{labels:[],data:[]} };

  const lineEl = document.getElementById('line7d');
  if (lineEl) {
    new Chart(lineEl, {
      type: 'line',
      data: {
        labels: dash.line.labels,
        datasets: [{
          label: 'Appointments',
          data: dash.line.data,
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
        plugins: {
          legend: { display: false },
          tooltip: { enabled: true }
        }
      }
    });
  }

  const doughEl = document.getElementById('doughnutStatus');
  if (doughEl) {
    const colors = [cPrimary, cAccent, '#10b981', '#3b82f6', '#6b7280', '#f59e0b'];
    new Chart(doughEl, {
      type: 'doughnut',
      data: {
        labels: dash.doughnut.labels,
        datasets: [{ data: dash.doughnut.data, backgroundColor: colors, borderWidth: 0 }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom', labels: { color: cText } }
        },
        cutout: '65%'
      }
    });
  }
})();

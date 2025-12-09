<?php
session_start();
include('verifica_login.php');
include('conexao.php');

// ========== CARD 1: Total de alunos ==========
$sqlTotal = "SELECT COUNT(*) AS total FROM alunos_cadastrados";
$totalAlunos = mysqli_fetch_assoc(mysqli_query($conexao, $sqlTotal))['total'];

// ========== CARD 2: Total de cursos ==========
$sqlTotalCursos = "SELECT COUNT(DISTINCT curso) AS total FROM alunos_cadastrados";
$totalCursos = mysqli_fetch_assoc(mysqli_query($conexao, $sqlTotalCursos))['total'];

// ========== CARD 3: Total de tipos de responsáveis ==========
$sqlTotalResponsaveis = "SELECT COUNT(DISTINCT tipo) AS total FROM alunos_cadastrados";
$totalResponsaveis = mysqli_fetch_assoc(mysqli_query($conexao, $sqlTotalResponsaveis))['total'];

// ========== CARD 4: Total de bairros ==========
$sqlTotalBairros = "SELECT COUNT(DISTINCT bairro) AS total FROM alunos_cadastrados";
$totalBairros = mysqli_fetch_assoc(mysqli_query($conexao, $sqlTotalBairros))['total'];

// ========== GRÁFICO 1: Alunos por Curso ==========
$sqlCursos = "SELECT curso, COUNT(*) AS total FROM alunos_cadastrados GROUP BY curso";
$resultCursos = mysqli_query($conexao, $sqlCursos);
$cursos = [];
$totaisCursos = [];
while ($row = mysqli_fetch_assoc($resultCursos)) {
    $cursos[] = $row['curso'];
    $totaisCursos[] = (int)$row['total'];
}

// ========== GRÁFICO 2: Tipos de Responsáveis ==========
$sqlTipos = "SELECT tipo, COUNT(*) AS total FROM alunos_cadastrados GROUP BY tipo";
$resultTipos = mysqli_query($conexao, $sqlTipos);
$tipos = [];
$totaisTipos = [];
while ($row = mysqli_fetch_assoc($resultTipos)) {
    $tipos[] = $row['tipo'];
    $totaisTipos[] = (int)$row['total'];
}

// ========== GRÁFICO 3: Alunos por Bairro ==========
$sqlBairros = "SELECT bairro, COUNT(*) AS total FROM alunos_cadastrados GROUP BY bairro";
$resultBairros = mysqli_query($conexao, $sqlBairros);
$bairros = [];
$totaisBairros = [];
while ($row = mysqli_fetch_assoc($resultBairros)) {
    $bairros[] = $row['bairro'];
    $totaisBairros[] = (int)$row['total'];
}

// ========== GRÁFICO 4: Idade dos Alunos ==========
$sqlIdades = "SELECT data_nascimento FROM alunos_cadastrados";
$resultIdades = mysqli_query($conexao, $sqlIdades);
$idades = [];
while ($row = mysqli_fetch_assoc($resultIdades)) {
    $idade = date_diff(date_create($row['data_nascimento']), date_create('today'))->y;
    $idades[] = (int)$idade;
}

$contadorIdades = $idades ? array_count_values($idades) : [];
ksort($contadorIdades);
$labelsIdades = array_keys($contadorIdades);
$totaisIdades = array_values($contadorIdades);

// ========== GRÁFICO 5: Cadastros por mês ==========
$sqlMeses = "
    SELECT MONTH(data_nascimento) AS mes, COUNT(*) AS total
    FROM alunos_cadastrados
    GROUP BY MONTH(data_nascimento)
";
$resultMeses = mysqli_query($conexao, $sqlMeses);
$meses = [];
$totaisMeses = [];
$nomesMeses = [1=>'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];

while ($row = mysqli_fetch_assoc($resultMeses)) {
    $m = (int)$row['mes'];
    $meses[] = $nomesMeses[$m];
    $totaisMeses[] = (int)$row['total'];
}

// Small safety: ensure arrays not empty to avoid Chart.js errors
if (empty($cursos)) { $cursos = ['—']; $totaisCursos = [0]; }
if (empty($tipos)) { $tipos = ['—']; $totaisTipos = [0]; }
if (empty($bairros)) { $bairros = ['—']; $totaisBairros = [0]; }
if (empty($labelsIdades)) { $labelsIdades = [0]; $totaisIdades = [0]; }
if (empty($meses)) { $meses = ['—']; $totaisMeses = [0]; }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EEEP MANOEL MANO</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body { background: #f6f7fb; }
        .contador { font-size: 40px; font-weight: bold; }
        .card { border-radius: 10px; }

        /* ======== MODO ESCURO ======== */
        .dark-mode { background-color: #0f1113 !important; color: #e6e6e6 !important; }
        .dark-mode .card { background: #131516 !important; color: #e6e6e6 !important; border-color: #222 !important; }
        .dark-mode nav.navbar { background: #0b0c0d !important; border-bottom: 1px solid #222 !important; }
        .dark-mode .nav-link, .dark-mode .navbar-brand { color: #e6e6e6 !important; }

        /* layout for 10 charts: grid with responsive columns */
        .charts-grid { display: grid; gap: 16px; grid-template-columns: repeat(2, 1fr); }
        @media (max-width: 900px) { .charts-grid { grid-template-columns: 1fr; } }
        .chart-card { padding: 12px; border-radius: 10px; }
        canvas { width: 100% !important; height: 300px !important; }
    </style>
</head>
<body>

<!-- NAVBAR COM BOTÃO AO LADO DE "SISTEMA" -->
<nav class="navbar navbar-expand-lg bg-body-tertiary mb-4" id="navbar">
  <div class="container-fluid">
    <div style="display:flex; align-items:center; gap:15px;">
        <a class="navbar-brand" href="#" style="font-weight:700;">Painel de Registros</a>
        <!-- BOTÃO DE MODO ESCURO -->
        <button id="toggleDarkMode"
            style="padding: 8px 15px; border: none; border-radius: 8px; background: #222; color: #fff; cursor: pointer; font-weight: bold;">
            🌙 Escuro
        </button>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="painel.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="formulario.php">Formulário</a></li>
        <li class="nav-item"><a class="nav-link" href="painel.php">Gráficos</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">

    <!-- CARDS -->
    <div class="row text-center mb-4">
        <div class="col-md-3 mb-3"><div class="card text-bg-primary p-3"><h6>Total de Alunos</h6><div class="contador" id="c1">0</div></div></div>
        <div class="col-md-3 mb-3"><div class="card text-bg-success p-3"><h6>Cursos Cadastrados</h6><div class="contador" id="c2">0</div></div></div>
        <div class="col-md-3 mb-3"><div class="card text-bg-warning p-3"><h6>Tipos de Responsável</h6><div class="contador" id="c3">0</div></div></div>
        <div class="col-md-3 mb-3"><div class="card text-bg-danger p-3"><h6>Bairros</h6><div class="contador" id="c4">0</div></div></div>
    </div>

    <!-- GRÁFICOS (GRID 2 colunas) -->
    <div class="charts-grid">
        <div class="card chart-card"><h6 class="text-center">Alunos por Curso </h6><canvas id="g1"></canvas></div>
        <div class="card chart-card"><h6 class="text-center">Tipos de Responsável </h6><canvas id="g2"></canvas></div>

        <div class="card chart-card"><h6 class="text-center">Alunos por Bairro </h6><canvas id="g3"></canvas></div>
        <div class="card chart-card"><h6 class="text-center">Idade dos Alunos </h6><canvas id="g4"></canvas></div>

        <div class="card chart-card"><h6 class="text-center">Cadastros por Mês </h6><canvas id="g5"></canvas></div>
        <div class="card chart-card"><h6 class="text-center">Cursos </h6><canvas id="g6"></canvas></div>

        <div class="card chart-card"><h6 class="text-center">Responsáveis </h6><canvas id="g7"></canvas></div>
        <div class="card chart-card"><h6 class="text-center">Cursos </h6><canvas id="g8"></canvas></div>

        <div class="card chart-card"><h6 class="text-center">Idade x Curso </h6><canvas id="g9"></canvas></div>
        <div class="card chart-card"><h6 class="text-center">Média por Curso </h6><canvas id="g10"></canvas></div>
    </div>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// ----- Dados PHP → JS -----
const cursos = <?= json_encode($cursos, JSON_UNESCAPED_UNICODE) ?>;
const totaisCursos = <?= json_encode($totaisCursos) ?>;

const tipos = <?= json_encode($tipos, JSON_UNESCAPED_UNICODE) ?>;
const totaisTipos = <?= json_encode($totaisTipos) ?>;

const bairros = <?= json_encode($bairros, JSON_UNESCAPED_UNICODE) ?>;
const totaisBairros = <?= json_encode($totaisBairros) ?>;

const labelsIdades = <?= json_encode($labelsIdades) ?>;
const totaisIdades = <?= json_encode($totaisIdades) ?>;

const meses = <?= json_encode($meses, JSON_UNESCAPED_UNICODE) ?>;
const totaisMeses = <?= json_encode($totaisMeses) ?>;

// ----- Contadores animados -----
function animar(id, valorFinal) {
    let cont = 0;
    const passo = Math.max(1, Math.round(valorFinal / 60));
    let intervalo = setInterval(() => {
        cont += passo;
        if (cont >= valorFinal) cont = valorFinal;
        document.getElementById(id).innerText = cont;
        if (cont >= valorFinal) clearInterval(intervalo);
    }, 16);
}

animar("c1", <?= $totalAlunos ?>);
animar("c2", <?= $totalCursos ?>);
animar("c3", <?= $totalResponsaveis ?>);
animar("c4", <?= $totalBairros ?>);

// ===========================
// 🎨 CORES (claro / escuro)
// ===========================
const lightColors = [
    'rgba(52,152,219,0.85)',   // azul
    'rgba(46,204,113,0.85)',   // verde
    'rgba(241,196,15,0.85)',   // amarelo
    'rgba(155,89,182,0.85)',   // roxo
    'rgba(230,126,34,0.85)',   // laranja
    'rgba(231,76,60,0.85)',    // vermelho
    'rgba(26,188,156,0.85)'    // turquesa
];

const darkColors = [
    'rgba(41,128,185,1)',   // azul neon
    'rgba(39,174,96,1)',    // verde neon
    'rgba(241,196,15,1)',   // amarelo
    'rgba(142,68,173,1)',   // roxo
    'rgba(230,126,34,1)',   // laranja
    'rgba(231,76,60,1)',    // vermelho
    'rgba(26,188,156,1)'    // turquesa
];

function getColors(n) {
    const base = document.body.classList.contains("dark-mode") ? darkColors : lightColors;
    // replicate/trim to length n
    const out = [];
    for (let i=0; i<n; i++) out.push(base[i % base.length]);
    return out;
}

// ===========================
// 🧠 ARMAZENAR INSTÂNCIAS
// ===========================
let charts = [];

// ===========================
// 🔄 CRIAR OS 10 GRÁFICOS
// ===========================
function createCharts() {
    // destruir existentes
    charts.forEach(c => c.destroy());
    charts = [];

    // cores para quantidade de itens
    charts.push(new Chart(document.getElementById('g1'), {
        type: 'bar',
        data: {
            labels: cursos,
            datasets: [{ label: 'Alunos', data: totaisCursos, backgroundColor: getColors(cursos.length), borderColor: getColors(cursos.length), borderWidth: 1 }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    }));

    charts.push(new Chart(document.getElementById('g2'), {
        type: 'pie',
        data: { labels: tipos, datasets: [{ data: totaisTipos, backgroundColor: getColors(tipos.length) }] },
        options: { responsive: true, maintainAspectRatio: false }
    }));

    charts.push(new Chart(document.getElementById('g3'), {
        type: 'bar',
        data: { labels: bairros, datasets: [{ label: 'Alunos', data: totaisBairros, backgroundColor: getColors(bairros.length) }] },
        options: { responsive: true, maintainAspectRatio: false }
    }));

    charts.push(new Chart(document.getElementById('g4'), {
        type: 'line',
        data: { labels: labelsIdades, datasets: [{ label: 'Alunos', data: totaisIdades, borderColor: getColors(1)[0], backgroundColor: getColors(1)[0], tension: 0.35, fill: false }] },
        options: { responsive: true, maintainAspectRatio: false }
    }));

    charts.push(new Chart(document.getElementById('g5'), {
        type: 'bar',
        data: { labels: meses, datasets: [{ label: 'Cadastros', data: totaisMeses, backgroundColor: getColors(meses.length) }] },
        options: { responsive: true, maintainAspectRatio: false }
    }));

    // g6 doughnut (usamos top 7 colors or repeated)
    charts.push(new Chart(document.getElementById('g6'), {
        type: 'doughnut',
        data: { labels: cursos, datasets: [{ data: totaisCursos, backgroundColor: getColors(cursos.length) }] },
        options: { responsive: true, maintainAspectRatio: false }
    }));

    // g7 radar - use tipos
    charts.push(new Chart(document.getElementById('g7'), {
        type: 'radar',
        data: { labels: tipos, datasets: [{ label: 'Responsáveis', data: totaisTipos, backgroundColor: (document.body.classList.contains("dark-mode") ? 'rgba(142,68,173,0.35)' : 'rgba(155,89,182,0.35)'), borderColor: getColors(1)[0], borderWidth: 2 }] },
        options: { responsive: true, maintainAspectRatio: false, scales: { r: { ticks: { backdropColor: 'transparent' } } } }
    }));

    // g8 horizontal bar (indexAxis: 'y')
    charts.push(new Chart(document.getElementById('g8'), {
        type: 'bar',
        data: { labels: cursos, datasets: [{ label: 'Alunos', data: totaisCursos, backgroundColor: getColors(cursos.length) }] },
        options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false }
    }));

    // g9 bubble: create safe bubble dataset (x=index, y=valor, r scaled)
    const bubbleDatasets = [];
    for (let i = 0; i < cursos.length; i++) {
        bubbleDatasets.push({
            label: cursos[i],
            data: [{ x: i + 1, y: (totaisCursos[i] || 0), r: Math.max(4, (totaisCursos[i] || 0) * 0.6) }],
            backgroundColor: getColors(1)[0],
        });
    }
    charts.push(new Chart(document.getElementById('g9'), {
        type: 'bubble',
        data: { datasets: bubbleDatasets },
        options: { responsive: true, maintainAspectRatio: false, scales: { x: { ticks: { stepSize: 1, callback: function(v){ return ''; } } } } }
    }));

    // g10 area (line filled) - média por curso = aqui usamos totaisCursos (pode adaptar)
    charts.push(new Chart(document.getElementById('g10'), {
        type: 'line',
        data: { labels: cursos, datasets: [{ label: 'Média (ex.)', data: totaisCursos, borderColor: getColors(1)[0], backgroundColor: (document.body.classList.contains("dark-mode") ? 'rgba(41,128,185,0.25)' : 'rgba(52,152,219,0.25)'), fill: true, tension: 0.3 }] },
        options: { responsive: true, maintainAspectRatio: false }
    }));
}

// criar na primeira vez
createCharts();

// ======== MODO ESCURO: comportamento do botão e recriar gráficos ========
const btnDark = document.getElementById("toggleDarkMode");

if (localStorage.getItem("darkMode") === "enabled") {
    document.body.classList.add("dark-mode");
    btnDark.textContent = "☀️ Claro";
    btnDark.style.background = "#f1c40f";
    btnDark.style.color = "#000";
}

btnDark.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("darkMode", "enabled");
        btnDark.textContent = "☀️ Claro";
        btnDark.style.background = "#f1c40f";
        btnDark.style.color = "#000";
    } else {
        localStorage.setItem("darkMode", "disabled");
        btnDark.textContent = "🌙 Escuro";
        btnDark.style.background = "#222";
        btnDark.style.color = "#fff";
    }

    // pequenos delay para aplicar classes e depois recriar os charts com novas cores
    setTimeout(() => { createCharts(); }, 120);
});
</script>

</body>
</html>

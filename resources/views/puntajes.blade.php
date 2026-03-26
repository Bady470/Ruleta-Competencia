<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking de Equipos - SENA EPP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <style>
        :root {
            --green: #00E676;
            --green-dim: #00C853;
            --blue: #0D47A1;
            --cyan: #00E5FF;
            --bg: #080E1A;
            --surface: #0F1923;
            --surface2: #162232;
            --border: rgba(0,230,118,0.15);
            --text: #E8F5E9;
            --text-dim: #7B9E87;
            --gold: #FFD600;
            --silver: #B0BEC5;
            --bronze: #FF8A65;
            --danger: #FF1744;
            --purple: #CE93D8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            padding: 24px;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: -200px; left: 50%;
            transform: translateX(-50%);
            width: 1000px; height: 700px;
            background: radial-gradient(ellipse, rgba(0,230,118,0.05) 0%, transparent 70%);
            pointer-events: none; z-index: 0;
        }

        .main { max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; }

        /* ── HEADER ── */
        header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 36px; padding-bottom: 24px;
            border-bottom: 1px solid var(--border);
        }

        .logo-area h1 {
            font-family: 'Syne', sans-serif; font-size: 30px; font-weight: 800;
            letter-spacing: -1px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--green) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        .logo-area p { color: var(--text-dim); font-size: 13px; margin-top: 4px; }

        .header-actions { display: flex; align-items: center; gap: 12px; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: 10px; border: none;
            font-family: 'Space Grotesk', sans-serif; font-weight: 600;
            font-size: 13px; cursor: pointer; transition: all 0.2s; letter-spacing: 0.3px;
        }

        .btn-ghost {
            background: transparent; color: var(--text-dim);
            border: 1px solid var(--border);
        }
        .btn-ghost:hover { background: var(--surface2); color: var(--text); }

        .btn-green {
            background: var(--green); color: #000; font-weight: 700;
            box-shadow: 0 0 20px rgba(0,230,118,0.3);
        }
        .btn-green:hover:not(:disabled) {
            background: #00FF85; box-shadow: 0 0 30px rgba(0,230,118,0.5);
            transform: translateY(-1px);
        }
        .btn-green:disabled { opacity: 0.3; cursor: not-allowed; box-shadow: none; }

        .btn-gold {
            background: var(--gold); color: #000; font-weight: 700;
            box-shadow: 0 0 20px rgba(255,214,0,0.3);
        }
        .btn-gold:hover { background: #FFE033; box-shadow: 0 0 30px rgba(255,214,0,0.5); transform: translateY(-1px); }

        .btn-danger {
            background: transparent; color: var(--danger);
            border: 1px solid rgba(255,23,68,0.3);
        }
        .btn-danger:hover { background: rgba(255,23,68,0.1); }

        /* ── LAYOUT ── */
        .layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 24px;
        }

        /* ── PANEL ── */
        .panel {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 20px; padding: 28px;
        }

        .panel-header {
            display: flex; align-items: center; gap: 10px; margin-bottom: 24px;
        }

        .panel-header-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(0,230,118,0.12);
            display: flex; align-items: center; justify-content: center;
            color: var(--green); font-size: 16px;
        }

        .panel-header h2 { font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 700; }

        /* ── TEAM SETUP ── */
        .team-setup-list {
            display: flex; flex-direction: column; gap: 10px;
            max-height: 420px; overflow-y: auto;
            padding-right: 4px;
        }

        .team-setup-list::-webkit-scrollbar { width: 4px; }
        .team-setup-list::-webkit-scrollbar-track { background: transparent; }
        .team-setup-list::-webkit-scrollbar-thumb { background: var(--surface2); border-radius: 4px; }

        .team-row {
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: 14px; padding: 14px 16px;
            display: flex; align-items: center; gap: 12px;
            transition: all 0.2s;
            animation: slideIn 0.3s ease-out both;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-16px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .team-row:hover { border-color: rgba(0,230,118,0.25); background: #1a2a38; }

        .team-num-badge {
            width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 800;
        }

        .team-name-input {
            flex: 1; background: var(--bg); border: 1px solid var(--border);
            border-radius: 8px; padding: 8px 12px; color: var(--text);
            font-family: 'Space Grotesk', sans-serif; font-size: 13px; font-weight: 600;
            outline: none; transition: all 0.2s;
        }

        .team-name-input:focus { border-color: var(--green); box-shadow: 0 0 0 2px rgba(0,230,118,0.1); }

        .team-del-btn {
            background: none; border: none; color: var(--text-dim); cursor: pointer;
            font-size: 16px; padding: 4px; border-radius: 6px; transition: all 0.15s;
            flex-shrink: 0;
        }
        .team-del-btn:hover { color: var(--danger); background: rgba(255,23,68,0.1); }

        .add-team-area {
            margin-top: 16px; display: flex; gap: 8px;
        }

        .add-team-input {
            flex: 1; background: var(--surface2); border: 1px solid var(--border);
            border-radius: 10px; padding: 11px 14px; color: var(--text);
            font-family: 'Space Grotesk', sans-serif; font-size: 13px; outline: none;
            transition: all 0.2s;
        }

        .add-team-input:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(0,230,118,0.1); }
        .add-team-input::placeholder { color: var(--text-dim); }

        /* ── RIGHT PANEL ── */
        .right-panel { display: flex; flex-direction: column; gap: 20px; }

        /* ── SCORING AREA ── */
        .scoring-panel {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 20px; padding: 28px;
        }

        .scoring-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px;
        }

        .scoring-title {
            font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700;
            display: flex; align-items: center; gap: 10px;
        }

        .scoring-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
        }

        .score-card {
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: 16px; padding: 18px; text-align: center;
            transition: all 0.25s; cursor: default;
            position: relative; overflow: hidden;
        }

        .score-card::after {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at top, rgba(0,230,118,0.04) 0%, transparent 70%);
        }

        .score-card:hover { border-color: rgba(0,230,118,0.3); transform: translateY(-2px); }

        .score-card-name {
            font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700;
            color: var(--text-dim); margin-bottom: 12px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .score-display {
            font-family: 'Syne', sans-serif; font-size: 42px; font-weight: 800;
            color: var(--green); line-height: 1; margin-bottom: 12px;
            transition: all 0.3s;
        }

        .score-controls {
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .score-btn {
            width: 34px; height: 34px; border-radius: 8px; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 700; transition: all 0.15s;
        }

        .score-btn-minus {
            background: rgba(255,23,68,0.12); color: var(--danger);
        }
        .score-btn-minus:hover { background: rgba(255,23,68,0.25); transform: scale(1.1); }

        .score-btn-plus {
            background: rgba(0,230,118,0.12); color: var(--green);
        }
        .score-btn-plus:hover { background: rgba(0,230,118,0.25); transform: scale(1.1); }

        .score-input-direct {
            width: 54px; text-align: center; background: var(--bg);
            border: 1px solid var(--border); border-radius: 8px;
            color: var(--text); font-family: 'Syne', sans-serif;
            font-size: 14px; font-weight: 700; padding: 6px 4px;
            outline: none; transition: all 0.2s;
        }

        .score-input-direct:focus { border-color: var(--green); }

        /* Points step selector */
        .step-selector {
            display: flex; align-items: center; gap: 8px;
        }

        .step-label { font-size: 12px; color: var(--text-dim); font-weight: 600; }

        .step-pill {
            padding: 4px 10px; border-radius: 20px; border: 1px solid var(--border);
            background: var(--surface2); color: var(--text-dim);
            font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.15s;
        }

        .step-pill.active { background: var(--green); color: #000; border-color: var(--green); }
        .step-pill:hover:not(.active) { border-color: var(--green); color: var(--green); }

        /* ── RANKING ── */
        .ranking-panel {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 20px; padding: 28px;
        }

        .ranking-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px;
        }

        .ranking-title {
            font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700;
            display: flex; align-items: center; gap: 10px;
        }

        .ranking-list { display: flex; flex-direction: column; gap: 8px; }

        .ranking-item {
            display: flex; align-items: center; gap: 14px;
            background: var(--surface2); border: 1px solid var(--border);
            border-radius: 14px; padding: 14px 18px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative; overflow: hidden;
        }

        .ranking-item.rank-1 { border-color: rgba(255,214,0,0.4); background: rgba(255,214,0,0.05); }
        .ranking-item.rank-2 { border-color: rgba(176,190,197,0.35); background: rgba(176,190,197,0.04); }
        .ranking-item.rank-3 { border-color: rgba(255,138,101,0.35); background: rgba(255,138,101,0.04); }

        .rank-pos {
            width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 800;
        }

        .pos-1 { background: rgba(255,214,0,0.15); color: var(--gold); }
        .pos-2 { background: rgba(176,190,197,0.15); color: var(--silver); }
        .pos-3 { background: rgba(255,138,101,0.15); color: var(--bronze); }
        .pos-other { background: var(--bg); color: var(--text-dim); font-size: 13px; }

        .rank-name {
            flex: 1; font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700;
        }

        .rank-bar-wrap {
            flex: 2; display: flex; align-items: center; gap: 10px;
        }

        .rank-bar-track {
            flex: 1; height: 8px; background: var(--bg); border-radius: 4px; overflow: hidden;
        }

        .rank-bar-fill {
            height: 100%; border-radius: 4px;
            transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .fill-1 { background: linear-gradient(90deg, #FFD600, #FFF176); }
        .fill-2 { background: linear-gradient(90deg, #B0BEC5, #ECEFF1); }
        .fill-3 { background: linear-gradient(90deg, #FF8A65, #FFCCBC); }
        .fill-other { background: linear-gradient(90deg, #00E676, #00E5FF); }

        .rank-score {
            font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 800;
            min-width: 60px; text-align: right;
        }

        .score-1 { color: var(--gold); }
        .score-2 { color: var(--silver); }
        .score-3 { color: var(--bronze); }
        .score-other { color: var(--green); }

        .rank-trophy { font-size: 20px; flex-shrink: 0; }

        /* Empty ranking */
        .ranking-empty {
            text-align: center; padding: 32px 20px; color: var(--text-dim);
        }
        .ranking-empty i { font-size: 36px; margin-bottom: 10px; opacity: 0.25; display: block; }
        .ranking-empty p { font-size: 13px; }

        /* ── HISTORY LOG ── */
        .history-panel {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 20px; padding: 24px;
        }

        .history-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 14px;
        }

        .history-title {
            font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700;
            display: flex; align-items: center; gap: 8px;
        }

        .history-scroll {
            max-height: 160px; overflow-y: auto; display: flex; flex-direction: column;
            gap: 6px; padding-right: 4px;
        }
        .history-scroll::-webkit-scrollbar { width: 3px; }
        .history-scroll::-webkit-scrollbar-track { background: transparent; }
        .history-scroll::-webkit-scrollbar-thumb { background: var(--surface2); border-radius: 3px; }

        .history-entry {
            display: flex; align-items: center; gap: 10px;
            padding: 7px 12px; background: var(--surface2); border-radius: 8px;
            font-size: 12px; animation: logIn 0.25s ease-out;
        }

        @keyframes logIn { from { opacity: 0; transform: translateX(8px); } to { opacity: 1; transform: translateX(0); } }

        .history-entry .h-team { font-weight: 700; color: var(--text); }
        .history-entry .h-delta { font-weight: 800; font-size: 13px; }
        .history-entry .h-delta.plus { color: var(--green); }
        .history-entry .h-delta.minus { color: var(--danger); }
        .history-entry .h-total { color: var(--text-dim); margin-left: auto; font-weight: 600; }
        .history-entry .h-time { color: rgba(123,158,135,0.5); font-size: 10px; }

        .history-empty { color: var(--text-dim); font-size: 12px; text-align: center; padding: 16px; }

        /* ── ALERT ── */
        .alert-bar {
            position: fixed; top: 20px; left: 50%;
            transform: translateX(-50%) translateY(-80px);
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 12px; padding: 14px 24px;
            font-size: 13px; font-weight: 600;
            display: flex; align-items: center; gap: 10px;
            z-index: 1000; box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            min-width: 260px; text-align: center; justify-content: center;
        }
        .alert-bar.show { transform: translateX(-50%) translateY(0); }
        .alert-bar.success { border-color: rgba(0,230,118,0.3); }
        .alert-bar.success i { color: var(--green); }
        .alert-bar.error { border-color: rgba(255,23,68,0.3); }
        .alert-bar.error i { color: var(--danger); }

        /* ── MODAL EXPORT ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.85); backdrop-filter: blur(8px);
            z-index: 200; display: flex; align-items: center; justify-content: center;
            padding: 24px; opacity: 0; pointer-events: none; transition: opacity 0.3s;
        }
        .modal-overlay.open { opacity: 1; pointer-events: all; }

        .modal {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 24px; width: 100%; max-width: 560px;
            overflow: hidden; display: flex; flex-direction: column;
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-overlay.open .modal { transform: scale(1); }

        .modal-header {
            padding: 24px 28px 18px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-header h2 { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 800; }
        .modal-close {
            width: 32px; height: 32px; border-radius: 8px;
            background: var(--surface2); border: 1px solid var(--border);
            color: var(--text-dim); cursor: pointer;
            display: flex; align-items: center; justify-content: center; font-size: 16px;
            transition: all 0.2s;
        }
        .modal-close:hover { color: var(--text); background: var(--bg); }

        .modal-body { padding: 24px 28px; }

        .export-text {
            background: var(--bg); border: 1px solid var(--border);
            border-radius: 12px; padding: 18px;
            font-family: monospace; font-size: 12px; color: var(--green);
            white-space: pre; overflow-x: auto; line-height: 1.7;
            max-height: 340px; overflow-y: auto;
        }

        .modal-footer {
            padding: 18px 28px; border-top: 1px solid var(--border);
            display: flex; gap: 8px; justify-content: flex-end;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .layout { grid-template-columns: 1fr; }
            .scoring-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .scoring-grid { grid-template-columns: 1fr; }
            header { flex-direction: column; gap: 14px; align-items: flex-start; }
        }

        /* Pulse animation for score change */
        @keyframes scorePop {
            0% { transform: scale(1); }
            40% { transform: scale(1.18); }
            100% { transform: scale(1); }
        }

        .score-pop { animation: scorePop 0.3s ease-out; }
    </style>
</head>
<body>

<!-- Alert -->
<div class="alert-bar" id="alertBar">
    <i id="alertIcon"></i>
    <span id="alertMsg"></span>
</div>

<!-- Export Modal -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="bi bi-download"></i> Exportar Resultados</h2>
            <button class="modal-close" onclick="cerrarModal()"><i class="bi bi-x"></i></button>
        </div>
        <div class="modal-body">
            <div class="export-text" id="exportText"></div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="cerrarModal()"><i class="bi bi-x"></i> Cerrar</button>
            <button class="btn btn-green" onclick="copiarExport()"><i class="bi bi-clipboard"></i> Copiar</button>
        </div>
    </div>
</div>

<div class="main">

    <!-- Header -->
    <header>
        <div class="logo-area">
            <h1><i class="bi bi-trophy-fill" style="-webkit-text-fill-color:initial;color:var(--gold)"></i> Ranking de Equipos</h1>
            <p>SENA EPP · Asigna puntajes y visualiza el ranking en tiempo real</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-ghost" onclick="resetPuntajes()"><i class="bi bi-arrow-counterclockwise"></i> Reset Puntajes</button>
            <button class="btn btn-ghost" onclick="abrirExport()"><i class="bi bi-download"></i> Exportar</button>
        </div>
    </header>

    <div class="layout">

        <!-- LEFT: Team Setup -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-header-icon"><i class="bi bi-people-fill"></i></div>
                <h2>Equipos</h2>
            </div>

            <div class="team-setup-list" id="teamSetupList">
                <!-- rendered by JS -->
            </div>

            <div class="add-team-area">
                <input class="add-team-input" id="addTeamInput" type="text" placeholder="Nombre del nuevo equipo…" autocomplete="off">
                <button class="btn btn-green" onclick="agregarEquipo()"><i class="bi bi-plus-lg"></i> Agregar</button>
            </div>

            <!-- Presets -->
            <div style="margin-top:14px;">
                <div style="font-size:11px;color:var(--text-dim);font-weight:600;letter-spacing:1px;text-transform:uppercase;margin-bottom:8px;">Carga rápida</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <button class="btn btn-ghost" style="font-size:12px;padding:7px 14px;" onclick="cargar9Equipos()"><i class="bi bi-lightning-fill"></i> 9 Equipos SENA</button>
                    <button class="btn btn-danger" style="font-size:12px;padding:7px 14px;" onclick="limpiarEquipos()"><i class="bi bi-trash3"></i> Limpiar</button>
                </div>
            </div>

            <!-- Step selector -->
            <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
                <div style="font-size:11px;color:var(--text-dim);font-weight:600;letter-spacing:1px;text-transform:uppercase;margin-bottom:10px;">Puntos por acción</div>
                <div class="step-selector" style="flex-wrap:wrap;gap:6px;">
                    <span class="step-pill active" data-val="1" onclick="setStep(1, this)">+1</span>
                    <span class="step-pill" data-val="5" onclick="setStep(5, this)">+5</span>
                    <span class="step-pill" data-val="10" onclick="setStep(10, this)">+10</span>
                    <span class="step-pill" data-val="25" onclick="setStep(25, this)">+25</span>
                    <span class="step-pill" data-val="50" onclick="setStep(50, this)">+50</span>
                    <span class="step-pill" data-val="100" onclick="setStep(100, this)">+100</span>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="right-panel">

            <!-- Scoring Cards -->
            <div class="scoring-panel">
                <div class="scoring-header">
                    <div class="scoring-title">
                        <i class="bi bi-plus-slash-minus" style="color:var(--green)"></i>
                        Asignar Puntajes
                    </div>
                    <div style="font-size:12px;color:var(--text-dim);">Haz clic en <b style="color:var(--green)">+</b> o <b style="color:var(--danger)">−</b> para modificar</div>
                </div>
                <div class="scoring-grid" id="scoringGrid">
                    <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--text-dim);font-size:13px;">
                        <i class="bi bi-people" style="font-size:36px;display:block;margin-bottom:12px;opacity:0.2;"></i>
                        Agrega equipos para comenzar
                    </div>
                </div>
            </div>

            <!-- Ranking -->
            <div class="ranking-panel">
                <div class="ranking-header">
                    <div class="ranking-title">
                        <i class="bi bi-bar-chart-fill" style="color:var(--gold)"></i>
                        Ranking en Vivo
                    </div>
                    <div style="font-size:12px;color:var(--text-dim);">De mayor a menor puntaje</div>
                </div>
                <div class="ranking-list" id="rankingList">
                    <div class="ranking-empty">
                        <i class="bi bi-trophy"></i>
                        <p>El ranking aparecerá aquí cuando<br>asignes puntajes a los equipos</p>
                    </div>
                </div>
            </div>

            <!-- History Log -->
            <div class="history-panel">
                <div class="history-header">
                    <div class="history-title">
                        <i class="bi bi-clock-history" style="color:var(--cyan)"></i>
                        Historial de Cambios
                    </div>
                    <button class="btn btn-ghost" style="font-size:11px;padding:5px 12px;" onclick="limpiarHistorial()">
                        <i class="bi bi-trash3"></i> Limpiar
                    </button>
                </div>
                <div class="history-scroll" id="historyScroll">
                    <div class="history-empty">Sin cambios aún…</div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // ── STATE ────────────────────────────────────────────
    let equipos = []; // { id, nombre, puntaje }
    let historial = [];
    let paso = 1;
    let idCounter = 1;

    const COLORES = [
        '#00E676','#00E5FF','#FFD600','#FF80AB','#CE93D8',
        '#80DEEA','#A5D6A7','#FFB74D','#EF9A9A','#B0BEC5',
        '#4FC3F7','#81C784'
    ];

    // ── INIT ─────────────────────────────────────────────
    cargar9Equipos();

    function cargar9Equipos() {
        equipos = Array.from({ length: 9 }, (_, i) => ({
            id: idCounter++,
            nombre: `Equipo ${i + 1}`,
            puntaje: 0
        }));
        historial = [];
        renderAll();
        mostrarAlerta('9 equipos cargados', 'success');
    }

    function limpiarEquipos() {
        equipos = [];
        historial = [];
        renderAll();
    }

    function agregarEquipo() {
        const input = document.getElementById('addTeamInput');
        const nombre = input.value.trim();
        if (!nombre) { mostrarAlerta('Escribe el nombre del equipo', 'error'); return; }
        if (equipos.length >= 12) { mostrarAlerta('Máximo 12 equipos', 'error'); return; }
        equipos.push({ id: idCounter++, nombre, puntaje: 0 });
        input.value = '';
        renderAll();
    }

    function eliminarEquipo(id) {
        equipos = equipos.filter(e => e.id !== id);
        renderAll();
    }

    function renombrarEquipo(id, nuevoNombre) {
        const eq = equipos.find(e => e.id === id);
        if (eq) eq.nombre = nuevoNombre;
        renderRanking();
        renderScoringGrid();
    }

    function setStep(val, el) {
        paso = val;
        document.querySelectorAll('.step-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
    }

    // ── SCORING ───────────────────────────────────────────
    function cambiarPuntaje(id, delta) {
        const eq = equipos.find(e => e.id === id);
        if (!eq) return;
        const antes = eq.puntaje;
        eq.puntaje = Math.max(0, eq.puntaje + delta);
        const diff = eq.puntaje - antes;
        if (diff === 0) return;

        // Register history
        const now = new Date();
        const h = `${now.getHours().toString().padStart(2,'0')}:${now.getMinutes().toString().padStart(2,'0')}`;
        historial.unshift({ nombre: eq.nombre, delta: diff, total: eq.puntaje, hora: h });
        if (historial.length > 50) historial.pop();

        renderAll();

        // Pop animation on score display
        const scoreEl = document.getElementById(`score-display-${id}`);
        if (scoreEl) {
            scoreEl.classList.remove('score-pop');
            void scoreEl.offsetWidth;
            scoreEl.classList.add('score-pop');
        }
    }

    function setPuntajeDirecto(id, val) {
        const eq = equipos.find(e => e.id === id);
        if (!eq) return;
        const n = parseInt(val);
        if (isNaN(n) || n < 0) return;
        const diff = n - eq.puntaje;
        eq.puntaje = n;

        const now = new Date();
        const h = `${now.getHours().toString().padStart(2,'0')}:${now.getMinutes().toString().padStart(2,'0')}`;
        historial.unshift({ nombre: eq.nombre, delta: diff, total: eq.puntaje, hora: h });
        if (historial.length > 50) historial.pop();

        renderAll();
    }

    function resetPuntajes() {
        equipos.forEach(e => e.puntaje = 0);
        historial = [];
        renderAll();
        mostrarAlerta('Puntajes reiniciados', 'success');
    }

    function limpiarHistorial() {
        historial = [];
        renderHistorial();
    }

    // ── RENDER ────────────────────────────────────────────
    function renderAll() {
        renderTeamSetup();
        renderScoringGrid();
        renderRanking();
        renderHistorial();
    }

    function renderTeamSetup() {
        const list = document.getElementById('teamSetupList');
        if (equipos.length === 0) {
            list.innerHTML = `<div style="text-align:center;padding:30px;color:var(--text-dim);font-size:13px;">
                <i class="bi bi-people" style="font-size:28px;display:block;margin-bottom:8px;opacity:0.2;"></i>
                Sin equipos. Agrega uno o carga los 9 de SENA.
            </div>`;
            return;
        }
        list.innerHTML = equipos.map((eq, i) => `
            <div class="team-row" style="animation-delay:${i * 0.04}s">
                <div class="team-num-badge" style="background:${COLORES[i % COLORES.length]}22;color:${COLORES[i % COLORES.length]}">${i + 1}</div>
                <input class="team-name-input" value="${esc(eq.nombre)}"
                    oninput="renombrarEquipo(${eq.id}, this.value)"
                    placeholder="Nombre del equipo">
                <button class="team-del-btn" onclick="eliminarEquipo(${eq.id})"><i class="bi bi-x"></i></button>
            </div>
        `).join('');
    }

    function renderScoringGrid() {
        const grid = document.getElementById('scoringGrid');
        if (equipos.length === 0) {
            grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--text-dim);font-size:13px;">
                <i class="bi bi-people" style="font-size:36px;display:block;margin-bottom:12px;opacity:0.2;"></i>
                Agrega equipos para comenzar
            </div>`;
            return;
        }
        grid.innerHTML = equipos.map((eq, i) => `
            <div class="score-card">
                <div class="score-card-name" title="${esc(eq.nombre)}">${esc(eq.nombre)}</div>
                <div class="score-display" id="score-display-${eq.id}">${eq.puntaje}</div>
                <div class="score-controls">
                    <button class="score-btn score-btn-minus" onclick="cambiarPuntaje(${eq.id}, -${paso})">−</button>
                    <input class="score-input-direct" type="number" min="0" value="${eq.puntaje}"
                        onchange="setPuntajeDirecto(${eq.id}, this.value)"
                        title="Escribe el puntaje directamente">
                    <button class="score-btn score-btn-plus" onclick="cambiarPuntaje(${eq.id}, ${paso})">+</button>
                </div>
            </div>
        `).join('');
    }

    function renderRanking() {
        const list = document.getElementById('rankingList');
        if (equipos.length === 0) {
            list.innerHTML = `<div class="ranking-empty"><i class="bi bi-trophy"></i><p>Agrega equipos para ver el ranking</p></div>`;
            return;
        }

        const sorted = [...equipos].sort((a, b) => b.puntaje - a.puntaje);
        const maxScore = sorted[0]?.puntaje || 1;

        const trophies = ['🥇','🥈','🥉'];

        // Check if all zeros
        const allZero = sorted.every(e => e.puntaje === 0);

        list.innerHTML = sorted.map((eq, i) => {
            const pos = i + 1;
            const pct = maxScore > 0 ? (eq.puntaje / maxScore) * 100 : 0;
            const posClass = pos <= 3 ? `rank-${pos}` : '';
            const posNumClass = pos <= 3 ? `pos-${pos}` : 'pos-other';
            const fillClass = pos <= 3 ? `fill-${pos}` : 'fill-other';
            const scoreClass = pos <= 3 ? `score-${pos}` : 'score-other';
            const trophy = pos <= 3 ? trophies[pos - 1] : '';

            return `
                <div class="ranking-item ${posClass}" style="animation-delay:${i * 0.05}s;">
                    <div class="rank-pos ${posNumClass}">${pos <= 3 ? trophy : pos}</div>
                    <div class="rank-name">${esc(eq.nombre)}</div>
                    <div class="rank-bar-wrap">
                        <div class="rank-bar-track">
                            <div class="rank-bar-fill ${fillClass}" style="width:${allZero ? 0 : pct}%"></div>
                        </div>
                    </div>
                    <div class="rank-score ${scoreClass}">${eq.puntaje}</div>
                </div>
            `;
        }).join('');
    }

    function renderHistorial() {
        const scroll = document.getElementById('historyScroll');
        if (historial.length === 0) {
            scroll.innerHTML = `<div class="history-empty">Sin cambios aún…</div>`;
            return;
        }
        scroll.innerHTML = historial.map(h => `
            <div class="history-entry">
                <span class="h-team">${esc(h.nombre)}</span>
                <span class="h-delta ${h.delta >= 0 ? 'plus' : 'minus'}">${h.delta >= 0 ? '+' : ''}${h.delta}</span>
                <span class="h-total">→ ${h.total} pts</span>
                <span class="h-time">${h.hora}</span>
            </div>
        `).join('');
    }

    // ── EXPORT ────────────────────────────────────────────
    function abrirExport() {
        const sorted = [...equipos].sort((a, b) => b.puntaje - a.puntaje);
        let txt = `RANKING DE EQUIPOS - SENA EPP\n`;
        txt += `${'═'.repeat(40)}\n`;
        txt += `Generado: ${new Date().toLocaleString('es-CO')}\n\n`;
        const trophies = ['🥇','🥈','🥉'];
        sorted.forEach((eq, i) => {
            const pos = i + 1;
            const prefix = pos <= 3 ? trophies[pos - 1] : `#${pos}`;
            txt += `${prefix}  ${eq.nombre.padEnd(20)} ${eq.puntaje} pts\n`;
        });
        txt += `\n${'─'.repeat(40)}\n`;
        txt += `Total equipos: ${equipos.length}\n`;
        const totalPts = equipos.reduce((s, e) => s + e.puntaje, 0);
        txt += `Total puntos: ${totalPts}\n`;
        document.getElementById('exportText').textContent = txt;
        document.getElementById('modalOverlay').classList.add('open');
    }

    function copiarExport() {
        const txt = document.getElementById('exportText').textContent;
        navigator.clipboard.writeText(txt).then(() => {
            mostrarAlerta('Copiado al portapapeles', 'success');
            cerrarModal();
        }).catch(() => mostrarAlerta('No se pudo copiar', 'error'));
    }

    function cerrarModal() {
        document.getElementById('modalOverlay').classList.remove('open');
    }

    document.getElementById('modalOverlay').addEventListener('click', e => {
        if (e.target === document.getElementById('modalOverlay')) cerrarModal();
    });

    // ── UTILS ─────────────────────────────────────────────
    function esc(str) {
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    let alertTimer;
    function mostrarAlerta(msg, tipo) {
        const bar = document.getElementById('alertBar');
        const icon = document.getElementById('alertIcon');
        document.getElementById('alertMsg').textContent = msg;
        bar.className = `alert-bar ${tipo}`;
        icon.className = `bi bi-${tipo === 'success' ? 'check-circle-fill' : 'exclamation-circle-fill'}`;
        bar.classList.add('show');
        clearTimeout(alertTimer);
        alertTimer = setTimeout(() => bar.classList.remove('show'), 3000);
    }

    // Enter to add team
    document.getElementById('addTeamInput').addEventListener('keypress', e => {
        if (e.key === 'Enter') agregarEquipo();
    });
</script>
</body>
</html>

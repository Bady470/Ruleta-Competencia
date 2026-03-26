<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ruleta SENA EPP</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<style>
:root {
  --bg: #0a0a0f;
  --surface: #111118;
  --surface2: #18181f;
  --surface3: #1e1e28;
  --accent: #c6f135;
  --accent2: #7efff5;
  --accent3: #ff6b35;
  --gold: #f5c842;
  --silver: #a8b8c8;
  --bronze: #e8855a;
  --text: #f0f0f8;
  --text2: #8888aa;
  --text3: #44445a;
  --border: rgba(198,241,53,0.12);
  --border2: rgba(198,241,53,0.25);
  --danger: #ff4466;
  --r: 14px;
  --r2: 20px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  overflow-x: hidden;
}

body::before {
  content: '';
  position: fixed; inset: 0;
  background-image:
    linear-gradient(rgba(198,241,53,0.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(198,241,53,0.03) 1px, transparent 1px);
  background-size: 48px 48px;
  pointer-events: none; z-index: 0;
}

body::after {
  content: '';
  position: fixed;
  top: -30vh; left: 50%;
  transform: translateX(-50%);
  width: 80vw; height: 60vh;
  background: radial-gradient(ellipse, rgba(198,241,53,0.06) 0%, transparent 70%);
  pointer-events: none; z-index: 0;
}

.app { max-width: 1280px; margin: 0 auto; padding: 32px 24px; position: relative; z-index: 1; }

/* ── HEADER ── */
.header {
  display: flex; align-items: flex-end; justify-content: space-between;
  margin-bottom: 40px; padding-bottom: 28px;
  border-bottom: 1px solid var(--border);
  gap: 16px; flex-wrap: wrap;
}
.brand { display: flex; flex-direction: column; gap: 4px; }
.brand-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 52px; line-height: 1; letter-spacing: 2px; color: var(--text);
}
.brand-title span { color: var(--accent); }
.brand-sub { font-size: 12px; letter-spacing: 3px; text-transform: uppercase; color: var(--text2); font-weight: 500; }
.header-right { display: flex; gap: 10px; align-items: center; }

/* ── TABS ── */
.tabs {
  display: flex; gap: 2px;
  background: var(--surface); border: 1px solid var(--border);
  border-radius: var(--r2); padding: 4px;
  margin-bottom: 32px; width: fit-content; flex-wrap: wrap;
}
.tab {
  padding: 10px 24px; border-radius: calc(var(--r2) - 4px);
  font-size: 13px; font-weight: 500; letter-spacing: 0.5px;
  cursor: pointer; border: none; background: transparent;
  color: var(--text2); transition: all 0.2s; font-family: 'DM Sans', sans-serif;
  display: flex; align-items: center; gap: 8px;
}
.tab:hover { color: var(--text); }
.tab.active { background: var(--accent); color: #000; font-weight: 600; }
.tab .badge {
  background: rgba(0,0,0,0.2); border-radius: 20px;
  padding: 1px 8px; font-size: 11px; font-family: 'DM Mono', monospace;
}
.tab:not(.active) .badge { background: var(--surface2); color: var(--text2); }
.tab:disabled { opacity: 0.35; cursor: not-allowed; pointer-events: none; }

/* ── BUTTONS ── */
.btn {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 10px 20px; border-radius: var(--r); border: none;
  font-family: 'DM Sans', sans-serif; font-weight: 500;
  font-size: 13px; cursor: pointer; transition: all 0.18s;
}
.btn-accent { background: var(--accent); color: #000; font-weight: 600; }
.btn-accent:hover:not(:disabled) { background: #d4ff44; transform: translateY(-1px); }
.btn-accent:disabled { opacity: 0.3; cursor: not-allowed; }
.btn-ghost { background: transparent; color: var(--text2); border: 1px solid var(--border2); }
.btn-ghost:hover { background: var(--surface2); color: var(--text); border-color: var(--border2); }
.btn-danger { background: transparent; color: var(--danger); border: 1px solid rgba(255,68,102,0.25); }
.btn-danger:hover { background: rgba(255,68,102,0.08); }
.btn-sm { padding: 7px 14px; font-size: 12px; }

/* ── LAYOUT ── */
.layout { display: grid; grid-template-columns: 320px 1fr; gap: 20px; }
@media (max-width: 900px) { .layout { grid-template-columns: 1fr; } }

/* ── PANELS ── */
.panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r2); padding: 24px; }
.panel-label {
  font-size: 10px; letter-spacing: 3px; text-transform: uppercase;
  color: var(--text3); font-weight: 600; margin-bottom: 16px;
  display: flex; align-items: center; gap: 8px;
}
.panel-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }

/* ── INPUT ── */
.input-row { display: flex; gap: 8px; margin-bottom: 12px; }
input[type="text"], input[type="number"] {
  background: var(--surface2); border: 1px solid var(--border);
  border-radius: var(--r); padding: 10px 14px;
  color: var(--text); font-family: 'DM Sans', sans-serif; font-size: 13px;
  outline: none; transition: all 0.2s; width: 100%;
}
input[type="text"]:focus, input[type="number"]:focus {
  border-color: var(--accent); box-shadow: 0 0 0 3px rgba(198,241,53,0.08);
}
input::placeholder { color: var(--text3); }

/* ── NOMBRE EQUIPO CARD ── */
.team-name-card {
  background: var(--surface2);
  border: 1px solid var(--border2);
  border-radius: var(--r);
  padding: 14px 16px;
  margin-bottom: 14px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.team-name-label {
  font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
  color: var(--accent); font-weight: 600;
  display: flex; align-items: center; gap: 6px;
}
.team-name-input-wrap { display: flex; gap: 8px; align-items: center; }
.team-name-input-wrap input {
  background: var(--bg);
  border: 1px solid var(--border2);
  font-size: 14px; font-weight: 500;
}
.team-name-input-wrap input:focus { border-color: var(--accent); }

/* ── CHIPS ── */
.chips-wrap {
  background: var(--bg); border: 1px solid var(--border);
  border-radius: var(--r); padding: 10px;
  max-height: 180px; overflow-y: auto;
  display: flex; flex-wrap: wrap; gap: 5px;
  margin-bottom: 12px; min-height: 56px; align-content: flex-start;
}
.chips-wrap::-webkit-scrollbar { width: 3px; }
.chips-wrap::-webkit-scrollbar-thumb { background: var(--surface3); border-radius: 3px; }
.chip {
  display: inline-flex; align-items: center; gap: 4px;
  background: var(--surface2); border: 1px solid var(--border);
  border-radius: 8px; padding: 4px 8px 4px 10px;
  font-size: 11px; color: var(--text); font-weight: 500;
  animation: chipIn 0.2s ease-out;
}
@keyframes chipIn { from { opacity:0; transform:scale(0.8); } to { opacity:1; transform:scale(1); } }
.chip.assigned { opacity: 0.25; text-decoration: line-through; }
.chip-del { background: none; border: none; cursor: pointer; color: var(--text3); font-size: 14px; line-height: 1; padding: 0 2px; border-radius: 4px; transition: color 0.15s; }
.chip-del:hover { color: var(--danger); }
.chips-empty { font-size: 12px; color: var(--text3); text-align: center; width: 100%; padding: 8px 0; }

/* ── PRESETS BAR ── */
.preset-bar { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px; }

/* ── STEP SELECTOR ── */
.step-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; padding-top: 20px; border-top: 1px solid var(--border); margin-top: 16px; }
.step-label { font-size: 11px; color: var(--text2); letter-spacing: 2px; text-transform: uppercase; font-weight: 600; white-space: nowrap; }
.step-pill {
  padding: 5px 12px; border-radius: 20px; border: 1px solid var(--border);
  background: var(--surface2); color: var(--text2);
  font-size: 12px; font-weight: 600; cursor: pointer;
  font-family: 'DM Mono', monospace; transition: all 0.15s;
}
.step-pill.active { background: var(--accent); color: #000; border-color: var(--accent); }
.step-pill:hover:not(.active) { border-color: var(--accent); color: var(--accent); }

/* ── RIGHT PANEL ── */
.right-col { display: flex; flex-direction: column; gap: 20px; }

/* ── WHEEL SECTION ── */
.wheel-panel {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: var(--r2); padding: 28px;
  display: flex; gap: 32px; align-items: center;
}
@media (max-width: 700px) { .wheel-panel { flex-direction: column; } }
.wheel-wrap { position: relative; flex-shrink: 0; }
#wheelCanvas { border-radius: 50%; filter: drop-shadow(0 0 24px rgba(198,241,53,0.15)); display: block; }
.wheel-pointer {
  position: absolute; right: -20px; top: 50%;
  transform: translateY(-50%);
  width: 0; height: 0;
  border-top: 14px solid transparent;
  border-bottom: 14px solid transparent;
  border-left: 22px solid var(--accent);
  filter: drop-shadow(0 0 6px rgba(198,241,53,0.7));
}

/* ── WHEEL SIDE ── */
.wheel-side { flex: 1; display: flex; flex-direction: column; gap: 14px; min-width: 0; }
.sel-card {
  background: var(--surface2); border: 1px solid var(--border);
  border-radius: var(--r2); padding: 20px;
  min-height: 100px; display: flex; flex-direction: column;
  align-items: center; justify-content: center; text-align: center; position: relative; overflow: hidden;
}
.sel-card::before {
  content: ''; position: absolute; inset: 0;
  background: radial-gradient(ellipse at 50% 0%, rgba(198,241,53,0.04) 0%, transparent 60%);
}
.sel-name { font-family: 'Bebas Neue', sans-serif; font-size: 28px; letter-spacing: 2px; color: var(--accent); line-height: 1; margin-bottom: 6px; }
.sel-role {
  font-size: 11px; letter-spacing: 2px; text-transform: uppercase; font-weight: 600; color: var(--text2);
  background: var(--surface3); border: 1px solid var(--border);
  border-radius: 20px; padding: 4px 14px; display: inline-flex; align-items: center; gap: 5px;
}
.sel-placeholder { font-size: 13px; color: var(--text3); }

/* ── STATS ── */
.stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; }
.stat { background: var(--bg); border: 1px solid var(--border); border-radius: var(--r); padding: 14px; text-align: center; }
.stat-n { font-family: 'Bebas Neue', sans-serif; font-size: 30px; letter-spacing: 1px; color: var(--text); line-height: 1; }
.stat-l { font-size: 10px; color: var(--text3); letter-spacing: 2px; text-transform: uppercase; margin-top: 2px; font-weight: 600; }

/* ── SPIN BUTTON ── */
.spin-btn {
  width: 100%; padding: 15px;
  background: linear-gradient(135deg, var(--accent) 0%, #a8e830 100%);
  color: #000; border: none; border-radius: var(--r);
  font-family: 'Bebas Neue', sans-serif; font-size: 20px; letter-spacing: 3px;
  cursor: pointer; transition: all 0.2s;
  display: flex; align-items: center; justify-content: center; gap: 12px;
}
.spin-btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(198,241,53,0.3); }
.spin-btn:disabled { opacity: 0.25; cursor: not-allowed; transform: none; box-shadow: none; }
.spin-btn.spinning { animation: spinPulse 0.6s ease-in-out infinite alternate; }
@keyframes spinPulse { from { box-shadow: 0 0 20px rgba(198,241,53,0.2); } to { box-shadow: 0 0 50px rgba(198,241,53,0.6); } }

/* ── SLOTS ── */
.slots-panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r2); padding: 20px; }
.slots-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
.slots-title { font-size: 12px; color: var(--text2); letter-spacing: 1px; font-weight: 600; }
.slots-title strong { color: var(--accent); font-family: 'Bebas Neue', sans-serif; font-size: 16px; letter-spacing: 2px; }
.slots-count { font-family: 'DM Mono', monospace; font-size: 12px; color: var(--text3); }
.slots { display: flex; gap: 8px; }
.slot {
  flex: 1; background: var(--bg); border: 1px dashed var(--border);
  border-radius: var(--r); padding: 12px 6px;
  min-height: 76px; display: flex; flex-direction: column;
  align-items: center; justify-content: center; gap: 4px; transition: all 0.3s;
}
.slot.filled { border-style: solid; border-color: var(--border2); background: var(--surface2); animation: slotPop 0.35s cubic-bezier(0.34,1.56,0.64,1); }
@keyframes slotPop { from { transform: scale(0.7); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.slot.leader { border-color: rgba(245,200,66,0.4); background: rgba(245,200,66,0.05); }
.slot-role { font-size: 8px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; }
.slot-role.r-lider { color: var(--gold); }
.slot-role.r-tester { color: var(--accent2); }
.slot-role.r-dev { color: var(--text2); }
.slot-name { font-size: 10px; font-weight: 600; color: var(--text); word-break: break-word; line-height: 1.2; text-align: center; }
.slot-empty { font-size: 20px; color: var(--surface3); }

/* ══════════════════════
   EQUIPOS TAB
══════════════════════ */
.equipos-toolbar {
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
}
.equipos-search input {
  width: 260px; background: var(--surface);
  border: 1px solid var(--border); border-radius: var(--r);
  padding: 9px 14px; color: var(--text); font-size: 13px; outline: none;
}
.equipos-search input:focus { border-color: var(--accent); }

.equipos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 16px;
}

.equipo-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--r2);
  overflow: hidden;
  transition: border-color 0.2s, transform 0.2s;
  animation: eqCardIn 0.3s ease-out both;
}
@keyframes eqCardIn { from { opacity:0; transform:translateY(8px); } }
.equipo-card:hover { border-color: var(--border2); transform: translateY(-2px); }

.equipo-card-header {
  padding: 14px 18px 12px;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between; gap: 8px;
}
.equipo-card-num {
  font-size: 10px; letter-spacing: 3px; text-transform: uppercase;
  color: var(--text3); font-weight: 600;
}
.equipo-card-name {
  font-family: 'Bebas Neue', sans-serif; font-size: 22px; letter-spacing: 2px;
  color: var(--accent); line-height: 1;
}
.equipo-card-count {
  font-family: 'DM Mono', monospace; font-size: 11px; color: var(--text3);
  background: var(--surface2); border: 1px solid var(--border);
  border-radius: 20px; padding: 3px 10px;
}
.equipo-card-members { padding: 10px 18px 14px; display: flex; flex-direction: column; gap: 6px; }
.member-row {
  display: flex; align-items: center; gap: 10px;
  padding: 8px 10px; border-radius: 10px;
  background: var(--surface2); border: 1px solid var(--border);
}
.member-row.is-lider { border-color: rgba(245,200,66,0.25); background: rgba(245,200,66,0.04); }
.member-row.is-tester { border-color: rgba(126,255,245,0.15); background: rgba(126,255,245,0.03); }
.member-avatar {
  width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px;
}
.av-lider { background: rgba(245,200,66,0.15); }
.av-tester { background: rgba(126,255,245,0.12); }
.av-dev { background: var(--surface3); }
.member-info { flex: 1; min-width: 0; }
.member-name { font-size: 13px; font-weight: 500; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.member-rol { font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 600; margin-top: 1px; }
.mr-lider { color: var(--gold); }
.mr-tester { color: var(--accent2); }
.mr-dev { color: var(--text3); }
.equipo-empty { text-align: center; padding: 40px 20px; color: var(--text3); font-size: 13px; }
.equipo-empty i { font-size: 32px; display: block; margin-bottom: 10px; opacity: 0.2; }

/* ══════════════════════
   SCORING TAB
══════════════════════ */
.scoring-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
.scoring-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 14px; margin-bottom: 24px; }
.score-card {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: var(--r2); padding: 20px;
  text-align: center; position: relative; overflow: hidden; transition: transform 0.2s, border-color 0.2s;
}
.score-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: var(--accent); opacity: 0; transition: opacity 0.2s; }
.score-card:hover { transform: translateY(-2px); border-color: var(--border2); }
.score-card:hover::before { opacity: 1; }
.score-card-team { font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: var(--text3); font-weight: 600; margin-bottom: 2px; }
.score-card-name { font-size: 15px; font-weight: 600; color: var(--accent); letter-spacing: 0.5px; margin-bottom: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.score-num { font-family: 'Bebas Neue', sans-serif; font-size: 52px; letter-spacing: 2px; color: var(--accent); line-height: 1; margin-bottom: 12px; transition: transform 0.2s; }
.score-num.pop { animation: numPop 0.25s ease-out; }
@keyframes numPop { 0%{transform:scale(1)} 40%{transform:scale(1.2)} 100%{transform:scale(1)} }
.score-ctrl { display: flex; align-items: center; justify-content: center; gap: 8px; }
.sc-btn {
  width: 32px; height: 32px; border-radius: var(--r); border: 1px solid var(--border2);
  background: var(--surface2); color: var(--text);
  cursor: pointer; font-size: 18px; font-weight: 600;
  display: flex; align-items: center; justify-content: center; transition: all 0.15s;
  font-family: 'DM Mono', monospace;
}
.sc-btn.minus:hover { background: rgba(255,68,102,0.15); border-color: rgba(255,68,102,0.4); color: var(--danger); }
.sc-btn.plus:hover { background: rgba(198,241,53,0.12); border-color: var(--accent); color: var(--accent); }
.sc-input { width: 56px; text-align: center; font-family: 'DM Mono', monospace; font-size: 13px; background: var(--bg); border: 1px solid var(--border); border-radius: 8px; color: var(--text); padding: 6px 4px; }

/* ── RANKING ── */
.ranking-panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r2); padding: 24px; }
.ranking-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
.ranking-title { font-family: 'Bebas Neue', sans-serif; font-size: 20px; letter-spacing: 3px; color: var(--text); display: flex; align-items: center; gap: 10px; }
.ranking-title span { color: var(--gold); }
.rank-list { display: flex; flex-direction: column; gap: 6px; }
.rank-item {
  display: flex; align-items: center; gap: 14px;
  background: var(--surface2); border: 1px solid var(--border);
  border-radius: var(--r); padding: 12px 16px;
  transition: all 0.4s cubic-bezier(0.34,1.56,0.64,1);
  animation: rankIn 0.3s ease-out both;
}
@keyframes rankIn { from { opacity:0; transform:translateX(-10px); } }
.rank-item.p1 { border-color: rgba(245,200,66,0.3); background: rgba(245,200,66,0.04); }
.rank-item.p2 { border-color: rgba(168,184,200,0.25); }
.rank-item.p3 { border-color: rgba(232,133,90,0.25); }
.rank-pos { width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-family: 'Bebas Neue', sans-serif; font-size: 14px; letter-spacing: 1px; }
.rp1 { background: rgba(245,200,66,0.15); color: var(--gold); }
.rp2 { background: rgba(168,184,200,0.1); color: var(--silver); }
.rp3 { background: rgba(232,133,90,0.12); color: var(--bronze); }
.rpN { background: var(--surface3); color: var(--text3); font-size: 12px; }
.rank-name { flex: 1; }
.rank-name-main { font-size: 14px; font-weight: 500; color: var(--text); }
.rank-name-sub { font-size: 11px; color: var(--text3); letter-spacing: 1px; text-transform: uppercase; }
.rank-bar-wrap { flex: 2; display: flex; align-items: center; gap: 10px; }
.rank-bar { flex: 1; height: 6px; background: var(--bg); border-radius: 3px; overflow: hidden; }
.rank-bar-fill { height: 100%; border-radius: 3px; transition: width 0.6s cubic-bezier(0.34,1.56,0.64,1); }
.rb1 { background: linear-gradient(90deg, var(--gold), #fff8c2); }
.rb2 { background: linear-gradient(90deg, var(--silver), #eceff1); }
.rb3 { background: linear-gradient(90deg, var(--bronze), #ffccbc); }
.rbN { background: linear-gradient(90deg, var(--accent), var(--accent2)); }
.rank-score { font-family: 'Bebas Neue', sans-serif; font-size: 24px; letter-spacing: 1px; min-width: 60px; text-align: right; }
.rs1 { color: var(--gold); }
.rs2 { color: var(--silver); }
.rs3 { color: var(--bronze); }
.rsN { color: var(--accent); }

/* ── ALERT ── */
.alert {
  position: fixed; top: 20px; left: 50%;
  transform: translateX(-50%) translateY(-80px);
  background: var(--surface2); border: 1px solid var(--border2);
  border-radius: var(--r2); padding: 12px 24px;
  font-size: 13px; font-weight: 500;
  display: flex; align-items: center; gap: 10px;
  z-index: 1000; box-shadow: 0 20px 60px rgba(0,0,0,0.5);
  transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
  min-width: 260px; justify-content: center;
}
.alert.show { transform: translateX(-50%) translateY(0); }
.alert.success { border-color: rgba(198,241,53,0.4); }
.alert.success i { color: var(--accent); }
.alert.error { border-color: rgba(255,68,102,0.4); }
.alert.error i { color: var(--danger); }

/* ── MODAL NOMBRE EQUIPO ── */
.modal-backdrop {
  position: fixed; inset: 0; background: rgba(10,10,15,0.85);
  display: flex; align-items: center; justify-content: center;
  z-index: 500; opacity: 0; pointer-events: none; transition: opacity 0.25s;
}
.modal-backdrop.open { opacity: 1; pointer-events: all; }
.modal {
  background: var(--surface); border: 1px solid var(--border2);
  border-radius: var(--r2); padding: 32px; width: 360px; max-width: 90vw;
  display: flex; flex-direction: column; gap: 20px;
  transform: scale(0.92); transition: transform 0.25s;
}
.modal-backdrop.open .modal { transform: scale(1); }
.modal-title { font-family: 'Bebas Neue', sans-serif; font-size: 26px; letter-spacing: 2px; color: var(--text); }
.modal-title span { color: var(--accent); }
.modal-sub { font-size: 13px; color: var(--text2); margin-top: -12px; }
.modal-input {
  background: var(--surface2); border: 1px solid var(--border2);
  border-radius: var(--r); padding: 12px 16px;
  color: var(--text); font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 500;
  outline: none; width: 100%; transition: all 0.2s;
}
.modal-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(198,241,53,0.08); }
.modal-input::placeholder { color: var(--text3); }
.modal-actions { display: flex; gap: 10px; }
.modal-actions .btn { flex: 1; justify-content: center; padding: 12px; }
</style>
</head>
<body>

<div class="alert" id="alertBar">
  <i id="alertIcon"></i>
  <span id="alertMsg"></span>
</div>

<!-- MODAL NOMBRE DE EQUIPO -->
<div class="modal-backdrop" id="modalBackdrop">
  <div class="modal">
    <div>
      <div class="modal-title">EQUIPO <span id="modalNum">1</span></div>
      <div class="modal-sub">Dale un nombre a este equipo</div>
    </div>
    <input class="modal-input" id="modalInput" type="text" placeholder="Ej: Los Titanes, Alpha, Grupo A…" maxlength="30">
    <div class="modal-actions">
      <button class="btn btn-ghost" onclick="cerrarModal()">Omitir</button>
      <button class="btn btn-accent" onclick="confirmarNombre()"><i class="bi bi-check-lg"></i> Confirmar</button>
    </div>
  </div>
</div>

<div class="app">

  <!-- HEADER -->
  <header class="header">
    <div class="brand">
      <div class="brand-title">RULETA <span>COMPETENCIA</span></div>
      <div class="brand-sub">SENA · Asignación de equipos en tiempo real</div>
    </div>
    <div class="header-right">
      <button class="btn btn-ghost btn-sm" onclick="limpiarTodo()"><i class="bi bi-arrow-counterclockwise"></i> Reiniciar</button>
    </div>
  </header>

  <!-- TABS -->
  <div class="tabs">
    <button class="tab active" id="tabRuletaBtn" onclick="switchTab('ruleta')">
      <i class="bi bi-shuffle"></i> Ruleta
    </button>
    <button class="tab" id="tabEquiposBtn" onclick="switchTab('equipos')" disabled>
      <i class="bi bi-people-fill"></i> Equipos
      <span class="badge" id="eqBadge2">0/9</span>
    </button>
    <button class="tab" id="tabPuntajeBtn" onclick="switchTab('puntaje')" disabled>
      <i class="bi bi-trophy-fill"></i> Puntaje
      <span class="badge" id="eqBadge">0/9</span>
    </button>
  </div>

  <!-- ══ RULETA TAB ══ -->
  <div id="tabRuleta">
    <div class="layout">

      <!-- LEFT -->
      <div class="panel">
        <div class="panel-label"><i class="bi bi-people-fill"></i> Participantes</div>

        <div class="input-row">
          <input type="text" id="personaInput" placeholder="Nombre del participante…" autocomplete="off">
          <button class="btn btn-accent btn-sm" onclick="addPersona()"><i class="bi bi-plus-lg"></i></button>
        </div>

        <div class="chips-wrap" id="chipsList">
          <span class="chips-empty">Sin participantes aún</span>
        </div>

        <div class="preset-bar">
          <button class="btn btn-accent btn-sm" onclick="cargar45()"><i class="bi bi-lightning-fill"></i> Cargar 45</button>
          <button class="btn btn-danger btn-sm" onclick="limpiarTodo()"><i class="bi bi-trash3"></i> Limpiar</button>
        </div>

        <div class="step-row">
          <span class="step-label">Paso de puntaje</span>
          <span class="step-pill active" onclick="setStep(1,this)">1</span>
          <span class="step-pill" onclick="setStep(5,this)">5</span>
          <span class="step-pill" onclick="setStep(10,this)">10</span>
          <span class="step-pill" onclick="setStep(25,this)">25</span>
          <span class="step-pill" onclick="setStep(50,this)">50</span>
          <span class="step-pill" onclick="setStep(100,this)">100</span>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="right-col">

        <!-- WHEEL -->
        <div class="wheel-panel">
          <div class="wheel-wrap">
            <canvas id="wheelCanvas" width="280" height="280"></canvas>
            <div class="wheel-pointer"></div>
          </div>

          <div class="wheel-side">

            <!-- NOMBRE EQUIPO ACTUAL -->
            <div class="team-name-card" id="teamNameCard">
              <div class="team-name-label"><i class="bi bi-tag-fill"></i> Nombre del equipo <span id="teamNameNumLabel">1</span></div>
              <div class="team-name-input-wrap">
                <input type="text" id="teamNameInput" placeholder="Ej: Los Titanes, Alpha…" maxlength="30">
                <button class="btn btn-ghost btn-sm" onclick="guardarNombreEquipo()" style="white-space:nowrap;"><i class="bi bi-check-lg"></i></button>
              </div>
            </div>

            <div class="sel-card" id="selCard">
              <p class="sel-placeholder"><i class="bi bi-arrow-left"></i> Gira la ruleta</p>
            </div>

            <div class="stats-row">
              <div class="stat">
                <div class="stat-n" id="sRestantes">0</div>
                <div class="stat-l">Restantes</div>
              </div>
              <div class="stat">
                <div class="stat-n" id="sEquipos">0/9</div>
                <div class="stat-l">Equipos</div>
              </div>
              <div class="stat">
                <div class="stat-n" id="sTotal">0</div>
                <div class="stat-l">Total</div>
              </div>
            </div>

            <button class="spin-btn" id="spinBtn" disabled onclick="girar()">
              <i class="bi bi-play-circle-fill"></i> GIRAR RULETA
            </button>
          </div>
        </div>

        <!-- SLOTS -->
        <div class="slots-panel">
          <div class="slots-header">
            <div class="slots-title">Equipo en formación — <strong id="equipoNombreActual">Equipo 1</strong></div>
            <div class="slots-count" id="slotCount">0 / 5</div>
          </div>
          <div class="slots" id="teamSlots"></div>
        </div>

      </div>
    </div>
  </div>

  <!-- ══ EQUIPOS TAB ══ -->
  <div id="tabEquipos" style="display:none;">
    <div class="equipos-toolbar">
      <div class="equipos-search">
        <input type="text" id="equiposSearch" placeholder="Buscar integrante o equipo…" oninput="renderEquipos()">
      </div>
      <div style="font-size:12px;color:var(--text3);" id="equiposTotalLabel">0 equipos formados</div>
    </div>
    <div class="equipos-grid" id="equiposGrid"></div>
  </div>

  <!-- ══ PUNTAJE TAB ══ -->
  <div id="tabPuntaje" style="display:none;">

    <div class="scoring-toolbar">
      <div class="step-row" style="padding-top:0;border-top:none;margin-top:0;">
        <span class="step-label">Puntos por acción</span>
        <span class="step-pill active" id="sp1" onclick="setStep(1,this)">1</span>
        <span class="step-pill" id="sp5" onclick="setStep(5,this)">5</span>
        <span class="step-pill" id="sp10" onclick="setStep(10,this)">10</span>
        <span class="step-pill" id="sp25" onclick="setStep(25,this)">25</span>
        <span class="step-pill" id="sp50" onclick="setStep(50,this)">50</span>
        <span class="step-pill" id="sp100" onclick="setStep(100,this)">100</span>
      </div>
      <button class="btn btn-ghost btn-sm" onclick="resetPuntajes()"><i class="bi bi-arrow-counterclockwise"></i> Reset puntajes</button>
    </div>

    <div class="scoring-grid" id="scoringGrid"></div>

    <div class="ranking-panel">
      <div class="ranking-head">
        <div class="ranking-title"><span>🏆</span> RANKING EN VIVO</div>
        <div style="font-size:12px;color:var(--text3);">Actualización automática</div>
      </div>
      <div class="rank-list" id="rankList"></div>
    </div>

  </div>

</div>

<script>
let personas = [];
let asignados = [];
let equipoActual = [];
let equipos = [];
let girando = false;
let rotacion = 0;
let paso = 1;
let nombreEquipoActual = '';
let pendingEquipoNombre = null; // índice del equipo recién completado esperando nombre en modal

const ROLES = ["Líder","Tester","Desarrollador","Desarrollador","Desarrollador"];
const canvas = document.getElementById('wheelCanvas');
const ctx = canvas.getContext('2d');
const COLS = ['#c6f135','#7efff5','#ff6b35','#f5c842','#ff80ab','#ce93d8','#80deea','#a5d6a7','#ffb74d','#ef9a9a','#b0bec5','#4fc3f7','#81c784','#ffca28','#5c6bc0','#26c6da','#ff7043','#26a69a','#ef5350','#ab47bc','#66bb6a','#42a5f5','#ffa726','#8d6e63','#ec407a'];

// ── TABS ─────────────────────────────────────────────
function switchTab(tab) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  ['tabRuleta','tabEquipos','tabPuntaje'].forEach(id => {
    document.getElementById(id).style.display = 'none';
  });
  document.getElementById('tab' + tab.charAt(0).toUpperCase() + tab.slice(1)).style.display = '';
  document.getElementById('tab' + tab.charAt(0).toUpperCase() + tab.slice(1) + 'Btn').classList.add('active');
  if (tab === 'puntaje') { renderScoring(); renderRanking(); }
  if (tab === 'equipos') { renderEquipos(); }
}

// ── PERSONAS ─────────────────────────────────────────
function addPersona() {
  const inp = document.getElementById('personaInput');
  const n = inp.value.trim(); if (!n) return;
  if (personas.length >= 45) { alerta('Máximo 45 personas','error'); return; }
  personas.push(n); inp.value = ''; actualizarUI();
}

function cargar45() {
  personas = Array.from({length:45},(_,i)=>`Persona ${i+1}`);
  asignados=[]; equipoActual=[]; equipos=[]; rotacion=0; nombreEquipoActual='';
  document.getElementById('teamNameInput').value = '';
  document.getElementById('selCard').innerHTML='<p class="sel-placeholder"><i class="bi bi-arrow-left"></i> Gira la ruleta</p>';
  actualizarUI(); alerta('45 personas cargadas ✓','success');
}

function limpiarTodo() {
  personas=[]; asignados=[]; equipoActual=[]; equipos=[]; rotacion=0; nombreEquipoActual='';
  document.getElementById('teamNameInput').value = '';
  document.getElementById('selCard').innerHTML='<p class="sel-placeholder"><i class="bi bi-arrow-left"></i> Gira la ruleta</p>';
  actualizarUI();
}

// ── NOMBRE EQUIPO INLINE ─────────────────────────────
function guardarNombreEquipo() {
  const v = document.getElementById('teamNameInput').value.trim();
  nombreEquipoActual = v;
  actualizarNombreSlot();
  if (v) alerta(`Nombre "${v}" guardado ✓`, 'success');
}

function actualizarNombreSlot() {
  const num = equipos.length + 1;
  const nombre = nombreEquipoActual || `Equipo ${num}`;
  document.getElementById('equipoNombreActual').textContent = nombre;
}

// ── MODAL ─────────────────────────────────────────────
function abrirModal(numEquipo) {
  pendingEquipoNombre = numEquipo;
  document.getElementById('modalNum').textContent = numEquipo;
  document.getElementById('modalInput').value = '';
  document.getElementById('modalBackdrop').classList.add('open');
  setTimeout(() => document.getElementById('modalInput').focus(), 100);
}

function cerrarModal() {
  document.getElementById('modalBackdrop').classList.remove('open');
  pendingEquipoNombre = null;
}

function confirmarNombre() {
  const v = document.getElementById('modalInput').value.trim();
  if (pendingEquipoNombre !== null) {
    const idx = pendingEquipoNombre - 1;
    if (equipos[idx]) {
      equipos[idx].nombre = v || `Equipo ${pendingEquipoNombre}`;
    }
  }
  cerrarModal();
  actualizarUI();
}

document.getElementById('modalInput').addEventListener('keypress', e => {
  if (e.key === 'Enter') confirmarNombre();
});
document.getElementById('modalBackdrop').addEventListener('click', e => {
  if (e.target === document.getElementById('modalBackdrop')) cerrarModal();
});

// ── ACTUALIZAR UI ─────────────────────────────────────
function actualizarUI() {
  renderChips();
  dibujarRuleta();
  renderSlots();
  const disp = personas.filter(p=>!asignados.includes(p));
  document.getElementById('sRestantes').textContent = disp.length;
  document.getElementById('sEquipos').textContent = equipos.length+'/9';
  document.getElementById('sTotal').textContent = personas.length;
  document.getElementById('eqBadge').textContent = equipos.length+'/9';
  document.getElementById('eqBadge2').textContent = equipos.length+'/9';
  const num = equipos.length + 1;
  document.getElementById('teamNameNumLabel').textContent = num;
  actualizarNombreSlot();
  const canSpin = disp.length>0 && equipos.length<9 && !girando;
  document.getElementById('spinBtn').disabled = !canSpin;
  const tabPBtn = document.getElementById('tabPuntajeBtn');
  const tabEBtn = document.getElementById('tabEquiposBtn');
  tabPBtn.disabled = equipos.length === 0;
  tabEBtn.disabled = equipos.length === 0;
}

function renderChips() {
  const c = document.getElementById('chipsList');
  if (!personas.length) { c.innerHTML='<span class="chips-empty">Sin participantes aún</span>'; return; }
  c.innerHTML = personas.map((p,i)=>{
    const a = asignados.includes(p);
    return `<span class="chip${a?' assigned':''}">${p}${!a?`<button class="chip-del" onclick="delPersona(${i})">×</button>`:''}</span>`;
  }).join('');
}

function delPersona(i) { personas.splice(i,1); actualizarUI(); }

// ── SLOTS ─────────────────────────────────────────────
function renderSlots() {
  const c = document.getElementById('teamSlots');
  c.innerHTML = ROLES.map((rol,i)=>{
    const filled = i < equipoActual.length;
    const name = filled ? equipoActual[i] : '';
    const rc = rol==='Líder'?'r-lider':rol==='Tester'?'r-tester':'r-dev';
    const lc = rol==='Líder'?' leader':'';
    return `<div class="slot${filled?' filled'+lc:''}">
      ${filled
        ?`<div class="slot-role ${rc}">${rol}</div><div class="slot-name">${name}</div>`
        :`<i class="bi bi-person slot-empty"></i><div class="slot-role ${rc}">${rol}</div>`
      }
    </div>`;
  }).join('');
}

// ── WHEEL ─────────────────────────────────────────────
function dibujarRuleta() {
  const W=280,H=280,cx=140,cy=140,R=136;
  ctx.clearRect(0,0,W,H);
  const disp = personas.filter(p=>!asignados.includes(p));
  if (!disp.length) {
    ctx.beginPath(); ctx.arc(cx,cy,R,0,Math.PI*2);
    ctx.fillStyle='#111118'; ctx.fill();
    ctx.strokeStyle='rgba(198,241,53,0.2)'; ctx.lineWidth=2; ctx.stroke();
    ctx.fillStyle='rgba(198,241,53,0.5)'; ctx.font='bold 14px DM Sans'; ctx.textAlign='center'; ctx.textBaseline='middle';
    ctx.fillText('¡Completado!',cx,cy); return;
  }
  const n=disp.length, seg=(Math.PI*2)/n;
  disp.forEach((p,i)=>{
    const s=i*seg+rotacion, e=(i+1)*seg+rotacion;
    ctx.beginPath(); ctx.moveTo(cx,cy); ctx.arc(cx,cy,R,s,e); ctx.closePath();
    ctx.fillStyle=COLS[i%COLS.length]; ctx.fill();
    ctx.strokeStyle='#0a0a0f'; ctx.lineWidth=1.5; ctx.stroke();
    const mid=(s+e)/2, tr=R*0.64, tx=cx+Math.cos(mid)*tr, ty=cy+Math.sin(mid)*tr;
    const ml=n>15?6:n>8?8:11, lbl=p.length>ml?p.slice(0,ml)+'…':p;
    const fs=n>20?8:n>10?10:12;
    ctx.save(); ctx.translate(tx,ty); ctx.rotate(mid+Math.PI/2);
    ctx.fillStyle='#000'; ctx.font=`bold ${fs}px DM Sans`; ctx.textAlign='center'; ctx.textBaseline='middle';
    ctx.fillText(lbl,0,0); ctx.restore();
  });
  const hub=40;
  ctx.beginPath(); ctx.arc(cx,cy,hub,0,Math.PI*2);
  ctx.fillStyle='#0a0a0f'; ctx.fill();
  ctx.strokeStyle='rgba(198,241,53,0.3)'; ctx.lineWidth=2; ctx.stroke();
  ctx.fillStyle='#c6f135'; ctx.font=`bold 13px Bebas Neue`; ctx.textAlign='center'; ctx.textBaseline='middle';
  ctx.fillText(disp.length,cx,cy);
}

// ── SPIN ──────────────────────────────────────────────
function girar() {
  if (girando) return;
  const disp = personas.filter(p=>!asignados.includes(p));
  if (!disp.length) return;
  girando=true;
  const btn = document.getElementById('spinBtn');
  btn.disabled=true; btn.classList.add('spinning');
  const n=disp.length, seg=(Math.PI*2)/n;
  const total=(5+Math.random()*5)*(Math.PI*2)+Math.random()*(Math.PI*2);
  const startRot=rotacion, t0=Date.now(), dur=3000+Math.random()*1000;
  const anim=()=>{
    const el=Date.now()-t0, pr=Math.min(el/dur,1), t=1-Math.pow(1-pr,3);
    rotacion=startRot+total*t; dibujarRuleta();
    if (pr<1){requestAnimationFrame(anim);return;}
    const norm=((rotacion%(Math.PI*2))+(Math.PI*2))%(Math.PI*2);
    const pInW=((-norm)%(Math.PI*2)+(Math.PI*2))%(Math.PI*2);
    const idx=Math.floor(pInW/seg)%n;
    const ganador=disp[idx];
    equipoActual.push(ganador); asignados.push(ganador);
    const rol=ROLES[equipoActual.length-1];
    const rc=rol==='Líder'?'r-lider':rol==='Tester'?'r-tester':'r-dev';
    document.getElementById('selCard').innerHTML=`<div class="sel-name">${ganador}</div><div class="sel-role"><i class="bi bi-${rol==='Líder'?'star-fill':rol==='Tester'?'bug-fill':'code-slash'}"></i> ${rol}</div>`;
    if (equipoActual.length===5) {
      // Toma nombre del input inline, si no hay uno lo deja como "Equipo N"
      const nombreGuardado = nombreEquipoActual.trim();
      const numEquipo = equipos.length + 1;
      equipos.push({
        numero: numEquipo,
        nombre: nombreGuardado || `Equipo ${numEquipo}`,
        miembros: equipoActual.map((nm,i)=>({nombre:nm,rol:ROLES[i]})),
        puntaje: 0
      });
      equipoActual = [];
      nombreEquipoActual = '';
      document.getElementById('teamNameInput').value = '';
      setTimeout(()=>{
        confetti({particleCount:100,spread:70,origin:{y:0.5},colors:['#c6f135','#7efff5','#f5c842']});
        const eqNom = equipos[equipos.length-1].nombre;
        alerta(`¡"${eqNom}" completado! 🎉`, 'success');
        document.getElementById('selCard').innerHTML='<p class="sel-placeholder"><i class="bi bi-check-circle"></i> Equipo completado</p>';
        actualizarUI();
      },400);
    }
    girando=false; btn.classList.remove('spinning');
    actualizarUI();
  };
  requestAnimationFrame(anim);
}

// ── STEP ──────────────────────────────────────────────
function setStep(v,el) {
  paso=v;
  document.querySelectorAll('.step-pill').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.step-pill').forEach(p=>{ if(parseInt(p.textContent)==v) p.classList.add('active'); });
}

// ── EQUIPOS TAB ───────────────────────────────────────
function renderEquipos() {
  const grid = document.getElementById('equiposGrid');
  const query = (document.getElementById('equiposSearch')?.value || '').toLowerCase();
  document.getElementById('equiposTotalLabel').textContent = `${equipos.length} equipo${equipos.length!==1?'s':''} formado${equipos.length!==1?'s':''}`;

  if (!equipos.length) {
    grid.innerHTML = `<div class="equipo-empty" style="grid-column:1/-1">
      <i class="bi bi-people"></i>
      <p>Aún no hay equipos formados.<br>Ve a la ruleta y comienza a girar.</p>
    </div>`; return;
  }

  const filtrados = query
    ? equipos.filter(eq =>
        eq.nombre.toLowerCase().includes(query) ||
        eq.miembros.some(m => m.nombre.toLowerCase().includes(query))
      )
    : equipos;

  if (!filtrados.length) {
    grid.innerHTML = `<div class="equipo-empty" style="grid-column:1/-1"><i class="bi bi-search"></i><p>Sin resultados para "${query}"</p></div>`;
    return;
  }

  grid.innerHTML = filtrados.map(eq => {
    const miembros = eq.miembros.map(m => {
      const isLider = m.rol === 'Líder';
      const isTester = m.rol === 'Tester';
      const rowCls = isLider ? 'is-lider' : isTester ? 'is-tester' : '';
      const avCls = isLider ? 'av-lider' : isTester ? 'av-tester' : 'av-dev';
      const icon = isLider ? 'bi-star-fill' : isTester ? 'bi-bug-fill' : 'bi-code-slash';
      const rolCls = isLider ? 'mr-lider' : isTester ? 'mr-tester' : 'mr-dev';
      const iconColor = isLider ? '#f5c842' : isTester ? '#7efff5' : '#44445a';
      return `<div class="member-row ${rowCls}">
        <div class="member-avatar ${avCls}"><i class="bi ${icon}" style="color:${iconColor};font-size:13px;"></i></div>
        <div class="member-info">
          <div class="member-name">${m.nombre}</div>
          <div class="member-rol ${rolCls}">${m.rol}</div>
        </div>
      </div>`;
    }).join('');

    return `<div class="equipo-card">
      <div class="equipo-card-header">
        <div>
          <div class="equipo-card-num">Equipo ${eq.numero}</div>
          <div class="equipo-card-name">${eq.nombre}</div>
        </div>
        <div class="equipo-card-count">${eq.miembros.length} integrantes</div>
      </div>
      <div class="equipo-card-members">${miembros}</div>
    </div>`;
  }).join('');
}

// ── SCORING ───────────────────────────────────────────
function cambiarPuntaje(idx,delta) {
  equipos[idx].puntaje=Math.max(0,equipos[idx].puntaje+delta);
  const el=document.getElementById('sn-'+idx);
  if(el){el.textContent=equipos[idx].puntaje; el.classList.remove('pop'); void el.offsetWidth; el.classList.add('pop');}
  const inp=document.getElementById('si-'+idx); if(inp) inp.value=equipos[idx].puntaje;
  renderRanking();
}

function setPuntajeDirecto(idx,val) {
  const n=parseInt(val); if(isNaN(n)||n<0)return;
  equipos[idx].puntaje=n;
  const el=document.getElementById('sn-'+idx); if(el){el.textContent=n;}
  renderRanking();
}

function resetPuntajes() {
  equipos.forEach(e=>e.puntaje=0);
  renderScoring(); renderRanking(); alerta('Puntajes reiniciados','success');
}

function renderScoring() {
  const g=document.getElementById('scoringGrid');
  if(!equipos.length){g.innerHTML='<p style="color:var(--text3);font-size:13px;">Completa equipos en la ruleta primero.</p>';return;}
  g.innerHTML=equipos.map((eq,i)=>`
    <div class="score-card">
      <div class="score-card-team">Equipo ${eq.numero}</div>
      <div class="score-card-name">${eq.nombre}</div>
      <div class="score-num" id="sn-${i}">${eq.puntaje}</div>
      <div class="score-ctrl">
        <button class="sc-btn minus" onclick="cambiarPuntaje(${i},-${paso})">−</button>
        <input class="sc-input" id="si-${i}" type="number" min="0" value="${eq.puntaje}" onchange="setPuntajeDirecto(${i},this.value)">
        <button class="sc-btn plus" onclick="cambiarPuntaje(${i},${paso})">+</button>
      </div>
    </div>
  `).join('');
}

function renderRanking() {
  const r=document.getElementById('rankList');
  if(!equipos.length){r.innerHTML='<div style="text-align:center;padding:40px 20px;color:var(--text3);font-size:13px;"><i class="bi bi-trophy" style="font-size:32px;display:block;margin-bottom:10px;opacity:0.2;"></i><p>Sin equipos aún</p></div>';return;}
  const sorted=[...equipos].sort((a,b)=>b.puntaje-a.puntaje);
  const max=sorted[0].puntaje||1;
  const trophies=['🥇','🥈','🥉'];
  r.innerHTML=sorted.map((eq,i)=>{
    const pos=i+1, pct=eq.puntaje>0?(eq.puntaje/max)*100:0;
    const pc=pos<=3?`p${pos}`:'';
    const rpc=pos<=3?`rp${pos}`:'rpN';
    const bfc=pos<=3?`rb${pos}`:'rbN';
    const rsc=pos<=3?`rs${pos}`:'rsN';
    const lbl=pos<=3?trophies[pos-1]:pos;
    return `<div class="rank-item ${pc}">
      <div class="rank-pos ${rpc}">${lbl}</div>
      <div class="rank-name">
        <div class="rank-name-main">${eq.nombre}</div>
        <div class="rank-name-sub">Equipo ${eq.numero}</div>
      </div>
      <div class="rank-bar-wrap"><div class="rank-bar"><div class="rank-bar-fill ${bfc}" style="width:${pct}%"></div></div></div>
      <div class="rank-score ${rsc}">${eq.puntaje}</div>
    </div>`;
  }).join('');
}

// ── ALERT ──────────────────────────────────────────────
let alertT;
function alerta(msg,tipo) {
  const bar=document.getElementById('alertBar');
  const ic=document.getElementById('alertIcon');
  document.getElementById('alertMsg').textContent=msg;
  bar.className=`alert ${tipo}`;
  ic.className=`bi bi-${tipo==='success'?'check-circle-fill':'exclamation-circle-fill'}`;
  bar.classList.add('show');
  clearTimeout(alertT);
  alertT=setTimeout(()=>bar.classList.remove('show'),3000);
}

// ── INIT ───────────────────────────────────────────────
document.getElementById('personaInput').addEventListener('keypress',e=>{if(e.key==='Enter')addPersona();});
document.getElementById('teamNameInput').addEventListener('keypress',e=>{if(e.key==='Enter')guardarNombreEquipo();});
actualizarUI();
</script>
</body>
</html>

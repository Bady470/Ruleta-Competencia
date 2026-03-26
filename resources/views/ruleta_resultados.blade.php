<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Equipos - SENA EPP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sena-green: #39A900;
            --sena-blue: #406479;
            --sena-dark: #1F3B4D;
            --bg: linear-gradient(135deg, #1F3B4D 0%, #0c0c0c 100%);
            --card-bg: #ffffff;
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: #2d3748;
            min-height: 100vh;
            padding: 20px;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .header h1 {
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 12px;
            border: none;
            font-weight: 800;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
            box-shadow: 0 10px 20px rgba(57, 169, 0, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(57, 169, 0, 0.3);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .teams-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .team-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
            border-left: 6px solid var(--sena-green);
            animation: slideIn 0.5s ease-out;
            transition: all 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .team-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #edf2f7;
        }

        .team-number {
            background: linear-gradient(135deg, var(--sena-blue), var(--sena-green));
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
        }

        .team-name {
            font-size: 20px;
            font-weight: 800;
            color: var(--sena-dark);
        }

        .team-members {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .member {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid var(--sena-green);
            transition: all 0.3s ease;
        }

        .member:hover {
            background: #edf2f7;
            transform: translateX(5px);
        }

        .member-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .member-name {
            font-weight: 800;
            color: var(--sena-dark);
            font-size: 14px;
        }

        .member-role {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            width: fit-content;
        }

        .role-lider {
            background: #FFE5E5;
            color: #C41E3A;
        }

        .role-tester {
            background: #D4F8F7;
            color: #0D7377;
        }

        .role-desarrollador {
            background: #D6EAF8;
            color: #0C5AA0;
        }

        .stats-section {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-box {
            text-align: center;
            padding: 20px;
            background: #f8fafc;
            border-radius: 16px;
            border: 2px solid #edf2f7;
        }

        .stat-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 800;
            color: var(--sena-green);
        }

        .summary-section {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .summary-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--sena-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .summary-title i {
            color: var(--sena-green);
            font-size: 28px;
        }

        .role-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .role-item {
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            border: 2px solid #edf2f7;
        }

        .role-item-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .role-item-count {
            font-size: 28px;
            font-weight: 800;
            color: var(--sena-green);
        }

        .role-item-names {
            font-size: 11px;
            color: #4a5568;
            margin-top: 8px;
            max-height: 60px;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .header h1 { font-size: 28px; }
            .teams-grid { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }

        @media print {
            body { background: white; }
            .action-buttons { display: none; }
            .header { margin-bottom: 20px; }
            .team-card { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="header">
        <h1><i class="bi bi-check-circle-fill"></i> Resultados de Asignación</h1>
        <p>Todos los equipos formados con sus respectivos roles</p>

        <div class="action-buttons">
            <button class="btn btn-primary" onclick="imprimirPagina()">
                <i class="bi bi-printer"></i> Imprimir
            </button>
            <button class="btn btn-primary" onclick="descargarJSON()">
                <i class="bi bi-download"></i> Descargar JSON
            </button>
            <button class="btn btn-primary" onclick="copiarAlPortapapeles()">
                <i class="bi bi-clipboard"></i> Copiar Texto
            </button>
            <button class="btn btn-secondary" onclick="volverARuleta()">
                <i class="bi bi-arrow-left"></i> Volver a la Ruleta
            </button>
        </div>
    </div>

    <!-- ESTADÍSTICAS -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-label">Total de Equipos</div>
                <div class="stat-value">{{ count($equipos) }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total de Personas</div>
                <div class="stat-value">{{ count($equipos) * 5 }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Líderes</div>
                <div class="stat-value">{{ count($equipos) }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Testers</div>
                <div class="stat-value">{{ count($equipos) }}</div>
            </div>
        </div>
    </div>

    <!-- RESUMEN POR ROLES -->
    <div class="summary-section">
        <div class="summary-title">
            <i class="bi bi-pie-chart-fill"></i> Distribución de Roles
        </div>
        <div class="role-summary">
            <div class="role-item" style="border-color: #FFE5E5;">
                <div class="role-item-label">Líderes</div>
                <div class="role-item-count">{{ count($equipos) }}</div>
                <div class="role-item-names">
                    @foreach($equipos as $equipo)
                        @foreach($equipo['miembros'] as $miembro)
                            @if($miembro['rol'] === 'Líder')
                                {{ $miembro['nombre'] }}<br>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
            <div class="role-item" style="border-color: #D4F8F7;">
                <div class="role-item-label">Testers</div>
                <div class="role-item-count">{{ count($equipos) }}</div>
                <div class="role-item-names">
                    @foreach($equipos as $equipo)
                        @foreach($equipo['miembros'] as $miembro)
                            @if($miembro['rol'] === 'Tester')
                                {{ $miembro['nombre'] }}<br>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
            <div class="role-item" style="border-color: #D6EAF8;">
                <div class="role-item-label">Desarrolladores</div>
                <div class="role-item-count">{{ count($equipos) * 3 }}</div>
                <div class="role-item-names">
                    @foreach($equipos as $equipo)
                        @foreach($equipo['miembros'] as $miembro)
                            @if($miembro['rol'] === 'Desarrollador')
                                {{ $miembro['nombre'] }}<br>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- EQUIPOS -->
    <div class="teams-grid">
        @foreach($equipos as $equipo)
            <div class="team-card">
                <div class="team-header">
                    <div class="team-number">{{ $equipo['numero'] }}</div>
                    <div class="team-name">Equipo {{ $equipo['numero'] }}</div>
                </div>
                <div class="team-members">
                    @foreach($equipo['miembros'] as $miembro)
                        <div class="member">
                            <div class="member-info">
                                <div class="member-name">{{ $miembro['nombre'] }}</div>
                            </div>
                            <span class="member-role role-{{ strtolower(str_replace(' ', '-', $miembro['rol'])) }}">
                                {{ $miembro['rol'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function imprimirPagina() {
        window.print();
    }

    function descargarJSON() {
        const equipos = @json($equipos);
        const dataStr = JSON.stringify(equipos, null, 2);
        const dataBlob = new Blob([dataStr], { type: 'application/json' });
        const url = URL.createObjectURL(dataBlob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `equipos_${new Date().getTime()}.json`;
        link.click();
    }

    function copiarAlPortapapeles() {
        const equipos = @json($equipos);
        let texto = 'RESULTADOS DE ASIGNACIÓN DE EQUIPOS\n';
        texto += '='.repeat(50) + '\n\n';

        equipos.forEach(equipo => {
            texto += `EQUIPO ${equipo.numero}\n`;
            texto += '-'.repeat(50) + '\n';
            equipo.miembros.forEach(miembro => {
                texto += `  • ${miembro.nombre} - ${miembro.rol}\n`;
            });
            texto += '\n';
        });

        navigator.clipboard.writeText(texto).then(() => {
            alert('¡Copiado al portapapeles!');
        });
    }

    function volverARuleta() {
        window.location.href = '{{ route("ruleta.index") }}';
    }
</script>

</body>
</html>

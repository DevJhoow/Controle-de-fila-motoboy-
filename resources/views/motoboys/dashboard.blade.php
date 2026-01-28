<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel do Motoboy</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(180deg, #0d1b2a, #000);
            color: #fff;
            min-height: 100vh;
        }
        .card {
            background-color: #0b2545;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
        .btn-primary {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border: none;
            border-radius: 12px;
            font-weight: bold;
        }
        .badge-status {
            font-size: 0.9rem;
        }
        .fila-item {
            background-color: rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 10px 14px;
            margin-bottom: 8px;
        }
        .fila-item.proximo {
            border: 2px solid #22c55e;
            background-color: rgba(34,197,94,0.15);
        }
    </style>
</head>
<body>

<div class="container py-4">

    <!-- Cabeçalho -->
    <div class="text-center mb-4">
        <h3 class="fw-bold">Olá, {{ $motoboy->nome }} 👋</h3>
        <p class="mb-0 text-info">
            <i class="bi bi-shop"></i>
            {{ $motoboy->restaurante->nome }}
        </p>
    </div>

    <!-- Status -->
    <div class="card p-3 mb-4 text-center">
        <p class="mb-1">Status atual</p>
        <span id="status" class="badge bg-warning text-dark badge-status">
            Aguardando
        </span>
    </div>

    <!-- Botão Jornada -->
    <div class="d-grid mb-4">
        <button class="btn btn-primary btn-lg" onclick="iniciarMonitoramento({{ $motoboy->id }})">
            <i class="bi bi-geo-alt-fill"></i>
            Iniciar jornada
        </button>
    </div>

    <!-- Fila -->
    <div class="card p-3">
        <h5 class="mb-3">
            <i class="bi bi-list-ol"></i>
            Fila de espera
        </h5>

        <div id="fila-lista">
            <p class="text-muted">Carregando fila...</p>
        </div>
    </div>

</div>

<script>
let monitoramentoAtivo = false;
let intervalo = null;

function iniciarMonitoramento(motoboyId) {

    console.log('🚀 Monitoramento iniciado', motoboyId);

    if (monitoramentoAtivo) return;

    monitoramentoAtivo = true;
    document.getElementById('status').innerText = 'Localizando...';

    if (!navigator.geolocation) {
        alert("GPS não suportado");
        return;
    }

    intervalo = setInterval(() => {

        navigator.geolocation.getCurrentPosition(
            pos => {

                const latitude = pos.coords.latitude;
                const longitude = pos.coords.longitude;

                fetch('/motoboys/' + motoboyId + '/localizacao', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ latitude, longitude })
                });

                fetch('/fila/verificar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        motoboy_id: motoboyId,
                        latitude,
                        longitude
                    })
                })
                .then(r => r.json())
                .then(data => {
                    document.getElementById('status').innerText =
                        data.status + ' (' + data.distancia.toFixed(1) + ' m)';
                });

            },
            () => {
                document.getElementById('status').innerText = 'Ative o GPS';
            }
        );

    }, 5000);
}

function atualizarFila(restauranteId) {
    fetch('/fila/' + restauranteId)
        .then(res => res.json())
        .then(fila => {

            const lista = document.getElementById('fila-lista');
            lista.innerHTML = '';

            if (fila.length === 0) {
                lista.innerHTML = '<p class="text-muted">Nenhum motoboy aguardando.</p>';
                return;
            }

            fila.forEach((item, index) => {
                const div = document.createElement('div');

                div.classList.add('fila-item');
                if (index === 0) {
                    div.classList.add('proximo');
                }

                div.innerHTML = `
                    <strong>${item.posicao}º</strong> —
                    ${item.nome} ${item.sobrenome}
                    ${index === 0 ? '<span class="badge bg-success ms-2">Próximo</span>' : ''}
                `;

                lista.appendChild(div);
            });
        })
        .catch(() => {
            document.getElementById('fila-lista').innerHTML =
                '<p class="text-danger">Erro ao carregar fila</p>';
        });
}

// carrega ao abrir
atualizarFila({{ $motoboy->restaurante_id }});

// atualiza a cada 5 segundos
setInterval(() => {
    atualizarFila({{ $motoboy->restaurante_id }});
}, 5000);

</script>

</body>
</html>

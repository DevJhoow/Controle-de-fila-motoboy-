<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro realizado</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            background: linear-gradient(180deg, #0d1b2a, #000814);
            min-height: 100vh;
            color: #fff;
        }

        .card-success {
            background-color: #0b132b;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,.4);
        }

        .btn-primary {
            background-color: #1f6feb;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 18px;
        }

        .btn-primary:hover {
            background-color: #1158c7;
        }

        .icon-success {
            font-size: 64px;
            color: #2ecc71;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100 px-3">

    <div class="card card-success w-100" style="max-width: 420px;">
        <div class="card-body text-center p-4">

            <div class="mb-3">
                <i class="bi bi-check-circle-fill icon-success"></i>
            </div>

            <h4 class="fw-bold mb-2">Cadastro realizado com sucesso</h4>

            <p class="text-secondary mb-3">
                Bem-vindo, <strong>{{ $motoboy->nome }} {{ $motoboy->sobrenome }}</strong>
            </p>

            <div class="alert alert-dark border-0 rounded-3 text-start">
                <i class="bi bi-shop me-2 text-primary"></i>
                Restaurante:
                <strong>{{ $motoboy->restaurante->nome }}</strong>
            </div>

            <p class="small text-secondary mb-4">
                Ative o GPS e aguarde instruções para entrar na fila de entregas.
            </p>

            <a href="{{ route('motoboys.dashboard', $motoboy->id) }}"
               class="btn btn-primary w-100">
                <i class="bi bi-speedometer2 me-2"></i>
                Ir para o painel
            </a>

        </div>
    </div>

</div>

</body>
</html>

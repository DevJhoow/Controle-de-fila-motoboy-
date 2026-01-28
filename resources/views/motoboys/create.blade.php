<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro Motoboy</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(180deg, #0d6efd 0%, #020617 60%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .card {
            border-radius: 1.25rem;
            background-color: #0b1220;
            color: #fff;
            border: 1px solid rgba(255,255,255,.08);
        }
        .form-control, .form-select {
            background-color: #020617;
            border: 1px solid #1e293b;
            color: #fff;
        }
        .form-control:focus, .form-select:focus {
            background-color: #020617;
            color: #fff;
            border-color: #0d6efd;
            box-shadow: 0 0 0 .2rem rgba(13,110,253,.25);
        }
        .btn-primary {
            border-radius: 999px;
            padding: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-6 col-lg-4">
            <div class="card shadow-lg p-4">

                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-bicycle fs-1 text-primary"></i>
                    </div>
                    <h4 class="fw-bold">Cadastro do Motoboy</h4>
                    <p class="text-secondary mb-0">
                        Entre na fila de entregas com segurança
                    </p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('motoboys.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-primary">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" name="nome" class="form-control" placeholder="Seu nome" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sobrenome</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-primary">
                                <i class="bi bi-person-badge"></i>
                            </span>
                            <input type="text" name="sobrenome" class="form-control" placeholder="Seu sobrenome" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Restaurante</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-primary">
                                <i class="bi bi-shop"></i>
                            </span>
                            <select name="restaurante_id" class="form-select" required>
                                <option value="">Selecione o restaurante</option>
                                @foreach ($restaurantes as $restaurante)
                                    <option value="{{ $restaurante->id }}">
                                        {{ $restaurante->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-2"></i>
                        Cadastrar e iniciar
                    </button>
                </form>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <small class="text-secondary">
                        Ao se cadastrar, você concorda com as regras da fila
                    </small>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
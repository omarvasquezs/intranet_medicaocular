<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clínica Médica Ocular - INTRANET</title>
    <link rel="icon" href="https://medicaocular.pe/wp-content/uploads/2023/08/Icon-Medica-Ocular-150x150.png" sizes="32x32">
    <link rel="icon" href="https://medicaocular.pe/wp-content/uploads/2023/08/Icon-Medica-Ocular.png" sizes="192x192">
    <link rel="apple-touch-icon" href="https://medicaocular.pe/wp-content/uploads/2023/08/Icon-Medica-Ocular.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img width="150"
                    src="https://medicaocular.pe/wp-content/uploads/2023/08/Logotipo-Medica-Ocular.png" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item px-2">
                        <a class="nav-link active" aria-current="page" href="#">INICIO</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" aria-current="page" href="#">DIRECTORIO</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" aria-current="page" href="#">BOLETAS DE PAGO</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" aria-current="page" href="#">REPOSITORIO DE DOCUMENTOS</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" aria-current="page" href="#">PERMISOS Y LICENCIAS</a>
                    </li>
                    <!-- Add more navigation items here -->
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> USER1
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">PERFIL</a></li>
                            <li><a class="dropdown-item" href="#">CAMBIO DE CLAVE</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">SALIR</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mt-4">
        {% block content %}
        {% endblock %}
    </main>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">Clínica Médica Ocular - Médica Ocular</span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
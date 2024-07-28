<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clínica Médica Ocular - INTRANET</title>
    <!-- ICONS -->
    <link rel="icon" href="https://medicaocular.pe/wp-content/uploads/2023/08/Icon-Medica-Ocular-150x150.png"
        sizes="32x32">
    <link rel="icon" href="https://medicaocular.pe/wp-content/uploads/2023/08/Icon-Medica-Ocular.png" sizes="192x192">
    <link rel="apple-touch-icon" href="https://medicaocular.pe/wp-content/uploads/2023/08/Icon-Medica-Ocular.png">
    <!-- END -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- SASS -->
    <link href="<?= base_url() ?>themes/medicaocular/style.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="container">
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="login-container rounded-0">
            <img class="img-fluid mb-4"
                src="https://medicaocular.pe/wp-content/uploads/2023/08/Logotipo-Medica-Ocular.png">
            <form class="login-form" action="/authenticate" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control rounded-0" id="username" name="username"
                        placeholder="USUARIO" required>
                </div>
                <div class="mb-5">
                    <input type="password" class="form-control rounded-0" id="password" name="password"
                        placeholder="CONTRASEÑA" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary login-button rounded-0 border-info">ACCEDER</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- CUSTOM JS -->
    <script type="text/javascript" src="<?= base_url() ?>themes/medicaocular/theme.js"></script>
</body>

</html>
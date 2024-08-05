<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cambiar Contraseña - Clínica Médica Ocular</title>
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
        <?php if (session()->has('message')): ?>
            <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                <?= session('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="login-container rounded-0">
            <img class="img-fluid mb-4"
                src="https://medicaocular.pe/wp-content/uploads/2023/08/Logotipo-Medica-Ocular.png">
            <form class="login-form" action="<?= base_url('change-password') ?>" method="post">
                <div class="mb-3">
                    <input type="password" class="form-control rounded-0" id="new_password" name="new_password"
                        placeholder="NUEVA CONTRASEÑA" required>
                </div>
                <div class="mb-5">
                    <input type="password" class="form-control rounded-0" id="confirm_password" name="confirm_password"
                        placeholder="CONFIRMAR CONTRASEÑA" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary login-button rounded-0 border-info">CAMBIAR
                        CONTRASEÑA</button>
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
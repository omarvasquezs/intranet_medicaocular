<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Clínica Médica Ocular - INTRANET</title>
    <!-- ICONS -->
    <link rel="icon" href="https://medicaocular.pe/wp-content/uploads/2023/08/Icon-Medica-Ocular-150x150.png"
        sizes="32x32">
    <link rel="icon" href="https://medicaocular.pe/wp-content/uploads/2023/08/Icon-Medica-Ocular.png" sizes="192x192">
    <link rel="apple-touch-icon" href="https://medicaocular.pe/wp-content/uploads/2023/08/Icon-Medica-Ocular.png">
    <!-- END -->
    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>themes/startbootstrap-sb-admin-2/vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- end -->
    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>themes/startbootstrap-sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>themes/medicaocular/style.css" rel="stylesheet">
    <!-- end -->
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion pt-1" id="accordionSidebar">

                <?php if (array_intersect(session()->get('roles'), [4])): ?>

                    <!-- DASHBOARD BLOCK -->

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- END DASHBOARD BLOCK -->

                    <!-- BOLETAS & PERMISOS BLOCK -->

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        General
                    </div>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="true" aria-controls="collapseTwo">
                            <i class="fa fa-search"></i>
                            <span>CONSULTAR</span>
                        </a>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">HISTORICO:</h6>
                                <a class="collapse-item" href="<?= base_url() ?>mis_boletas">Mis Boletas</a>
                                <a class="collapse-item" href="<?= base_url() ?>mis_cts">Mis Depósitos CTS</a>
                                <a class="collapse-item" href="<?= base_url() ?>registrar_permiso">Mis Permisos y
                                    Descansos</a>
                                <a class="collapse-item" href="<?= base_url() ?>mis_amonestaciones">Mis Amonestaciones</a>
                            </div>
                        </div>
                    </li>

                    <!-- Nav Item - Utilities Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                            aria-expanded="true" aria-controls="collapseUtilities">
                            <i class="fas fa-pencil-alt"></i>
                            <span>REGISTRAR</span>
                        </a>
                        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                            data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="<?= base_url() ?>registrar_permiso/add">Permiso o
                                    Descanso</a>
                            </div>
                        </div>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- END BOLETAS & PERMISOS BLOCK -->

                    <!-- DOCUMENTOS & DIRECTORIO BLOCK -->

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Informativo
                    </div>

                    <!-- Nav Item - Charts -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>documentos">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>DOCUMENTOS</span></a>
                    </li>

                    <!-- Nav Item - Tables -->
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="fas fa-fw fa-sitemap"></i>
                            <span>DIRECTORIO</span></a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider d-none d-md-block">

                    <!-- END DOCUMENTOS & DIRECTORIO BLOCK -->

                <?php endif; ?>

                <?php if (array_intersect(session()->get('roles'), [3])): ?>

                    <!-- CONTABILIDAD BLOCK -->

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Contabilidad
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>contabilidad_boletas/add">
                            <i class="fas fa-fw fa-upload"></i>
                            <span>SUBIR BOLETA</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>contabilidad_boletas_cts/add">
                            <i class="fas fa-fw fa-upload"></i>
                            <span>SUBIR DEPÓSITO CTS</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>contabilidad_boletas">
                            <i class="fas fa-fw fa-history"></i>
                            <span>TODAS LAS BOLETAS</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>contabilidad_boletas_cts">
                            <i class="fas fa-fw fa-history"></i>
                            <span>TODAS LAS CTS</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= base_url() ?>amonestaciones" class="nav-link">
                            <i class="fas fa-fw fa-angry"></i>
                            <span>AMONESTACIONES</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- END CONTABILIDAD -->

                <?php endif; ?>

                <?php if (array_intersect(session()->get('roles'), [1, 5])): ?>

                    <!-- GERENCIA AND JEFATURA BLOCK -->

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Permisos y Descansos
                    </div>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>permisos_pendientes" data-toggle="tooltip"
                            data-placement="bottom">
                            <i class="fa fa-fw fa-list"></i>
                            <span>PENDIENTES</span>
                        </a>
                    </li>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>permisos_aprobados" data-toggle="tooltip"
                            data-placement="bottom">
                            <i class="fa fa-fw fa-check"></i>
                            <span>APROBADOS</span>
                        </a>
                    </li>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>permisos_rechazados" data-toggle="tooltip"
                            data-placement="bottom">
                            <i class="fa fa-fw fa-times"></i>
                            <span>RECHAZADOS</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- END OF GERENCIA AND JEFATURA BLOCK -->

                <?php endif; ?>

                <?php if (array_intersect(session()->get('roles'), [2])): ?>

                    <!-- IT BLOCK -->

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Administrar
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>users">
                            <i class="fas fa-fw fa-users"></i>
                            <span>USUARIOS</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>cargos">
                            <i class="fa fa-medal"></i>
                            <span>CARGOS</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>areas">
                            <i class="fa fa-id-card"></i>
                            <span>ÁREAS</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- END OF IT BLOCK -->

                <?php endif; ?>

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>
        </div>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light custom-top-bar topbar static-top fixed-top">
                    <!-- Logo -->
                    <a class="navbar-brand" href="/">
                        <img src="https://medicaocular.pe/wp-content/uploads/2023/08/Logotipo-Medica-Ocular.png"
                            alt="Logo" style="height: 60px;">
                    </a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/" data-toggle="tooltip" data-placement="bottom"
                                title="INICIO / PUBLICACIONES"><i class="fas fa-home fa-lg"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>mis_boletas" data-toggle="tooltip"
                                data-placement="bottom" title="MIS BOLETAS"><i
                                    class="fas fa-file-invoice-dollar fa-lg"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>registrar_permiso/add" data-toggle="tooltip"
                                data-placement="bottom" title="REGISTRAR PERMISO"><i
                                    class="fas fa-file-medical fa-lg"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>documentos" data-toggle="tooltip"
                                data-placement="bottom" title="DOCUMENTOS"><i class="fas fa-folder fa-lg"></i></a>
                        </li>
                    </ul>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-400 small"><?= session()->get('nombres'); ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url() ?>assets/eye.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item"
                                    href="<?= base_url() ?>perfil/edit/<?= session()->get('user_id') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar Sesion
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid pt-3">
                    <?php if (session()->has('message')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session('message') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <!-- TO DO -->
                    <?php
                    if (!empty($output)) {
                        echo $output;
                    }
                    ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Médica Ocular &copy; <?= date('Y') ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Listo para Salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "CERRAR SESION" ahi abajo si esta seguro de finalizar su sesion.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">CANCELAR</button>
                    <a class="btn btn-primary" href="<?= base_url() ?>logout">CERRAR SESION</a>
                </div>
            </div>
        </div>
    </div>

    <!-- HB Modal -->
    <div class="modal fade" id="hbModal" tabindex="-1" aria-labelledby="hbModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/happy-birthday-to-you-design-template-8c4f0f1ad7ebd16b67d241edd85d26ef_screen.jpg?ts=1695985225"
                        width="100%">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>themes/startbootstrap-sb-admin-2/vendor/jquery/jquery.min.js"></script>
    <script
        src="<?= base_url() ?>themes/startbootstrap-sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- end -->
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>themes/startbootstrap-sb-admin-2/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- end -->
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>themes/startbootstrap-sb-admin-2/js/sb-admin-2.js"></script>
    <!-- end -->
    <!-- Grocery Crud js files -->
    <?php
    if (!empty($js_files)) {
        foreach ($js_files as $file) { ?>
            <script src="<?php echo $file; ?>"></script>
        <?php }
    }
    ?>
    <!-- end -->
    <!-- Custom theme JS -->
    <script type="text/javascript" src="<?= base_url() ?>themes/medicaocular/theme.js"></script>
    <!-- end -->
</body>

</html>
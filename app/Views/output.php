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
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon">
                    <img width="58" height="58" src="<?= base_url() ?>assets/eye.png">
                </div>
                <div class="sidebar-brand-text mx-3"><img width="100" src="<?= base_url() ?>assets/medica_ocular.png"
                        alt="Logo">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <?php if (array_intersect(session()->get('roles'), [4])): ?>

                <!-- DASHBOARD BLOCK -->

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>INICIO</span></a>
                </li>

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
                            <a class="collapse-item" href="<?=base_url()?>mis_boletas">Mis Boletas</a>
                            <a class="collapse-item" href="<?= base_url() ?>registrar_permiso">Mis Permisos y Descansos</a>
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
                            <a class="collapse-item" href="<?= base_url() ?>registrar_permiso/add">Permiso o Descanso</a>
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
                    <a class="nav-link" href="<?=base_url()?>contabilidad_boletas/add">
                        <i class="fas fa-fw fa-upload"></i>
                        <span>SUBIR BOLETA</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url()?>contabilidad_boletas_rechazadas">
                        <i class="fas fa-fw fa-exclamation-triangle"></i>
                        <span>BOLETAS RECHAZADAS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url()?>contabilidad_boletas">
                        <i class="fas fa-fw fa-history"></i>
                        <span>H. BOLETAS</span>
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
                    Gerencia y/o Jefatura
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#gerenciaSOLMenu"
                        aria-expanded="true" aria-controls="gerenciaSOLMenu">
                        <i class="fa fa-fw fa-list"></i>
                        <span>SOL. PENDIENTES</span>
                    </a>
                    <div id="gerenciaSOLMenu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Por aprobar:</h6>
                            <?= (array_intersect(session()->get('roles'), [1])) ? '<a class="collapse-item" href="'. base_url() .'boletas_pendientes">Boletas</a>' : '' ?>
                            <a class="collapse-item" href="<?= base_url() ?>permisos_pendientes">Permisos y Descansos</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#gerenciaSOLaproMenu"
                        aria-expanded="true" aria-controls="gerenciaSOLaproMenu">
                        <i class="fa fa-fw fa-check"></i>
                        <span>SOL. APROBADAS</span>
                    </a>
                    <div id="gerenciaSOLaproMenu" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <?= (array_intersect(session()->get('roles'), [1])) ? '<a class="collapse-item" href="'. base_url() .'boletas_aprobadas">Boletas Aprobadas</a>' : '' ?>
                            <a class="collapse-item" href="<?=base_url()?>permisos_aprobados">Permisos y Descansos Aprobados</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#gerenciaSOLrechaMenu"
                        aria-expanded="true" aria-controls="gerenciaSOLrechaMenu">
                        <i class="fa fa-fw fa-times"></i>
                        <span>SOL. RECHAZADAS</span>
                    </a>
                    <div id="gerenciaSOLrechaMenu" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <?= (array_intersect(session()->get('roles'), [1])) ? '<a class="collapse-item" href="'. base_url() .'contabilidad_boletas_rechazadas">Boletas Rechazadas</a>' : '' ?>
                            <a class="collapse-item" href="<?=base_url()?>permisos_rechazados">Permisos y Descansos Rechazados</a>
                        </div>
                    </div>
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
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?= session()->get('nombres'); ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url() ?>assets/eye.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?=base_url()?>perfil/edit/<?=session()->get('user_id')?>">
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
                <div class="container-fluid">
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
                        <span>Médica Ocular &copy; 2024</span>
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
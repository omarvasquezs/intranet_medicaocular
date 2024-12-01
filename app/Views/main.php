<div class="row">
    <div class="col-lg-9 col-md-12 mx-auto">
        <?php if (array_intersect(session()->get('roles'), [1, 2])): ?>
            <div>
                <a href="<?= base_url('editar_publicaciones') ?>" class="btn btn-outline-dark">
                    <i class="fas fa-pencil-alt"></i> Editar Publicaciones
                </a>
            </div>
        <?php endif; ?>

        <?php if (!empty($publicaciones)): ?>
            <?php foreach ($publicaciones as $publicacion): ?>
                <?php if (!is_null($publicacion)): ?>
                    <div class="row my-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex card-text ck-content">
                                        <div class="flex-fill">
                                            <?php echo $publicacion['publicacion']; ?>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div><small class="text-muted">Publicado:
                                                <?php echo $publicacion['fecha_creacion']; ?></small></div>
                                        <div><small class="text-muted">Autor:
                                                <?php echo $publicacion['nombres']; ?></small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="row my-4">
                <div class="col-md-12">
                    <h4>No hay publicaciones disponibles.</h4>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
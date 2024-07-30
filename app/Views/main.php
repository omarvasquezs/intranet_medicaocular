<div class="row mt-5">
    <div class="col-lg-9 col-md-12 mx-auto">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="publicaciones-tab" data-toggle="tab" data-target="#publicaciones"
                    type="button" role="tab" aria-controls="publicaciones" aria-selected="true">Publicaciones</button>
            </li>
            <?php if (array_intersect(session()->get('roles'), [1, 2])): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="editar-tab" data-toggle="tab" data-target="#editar" type="button"
                        role="tab" aria-controls="editar" aria-selected="false">Editar</button>
                </li>
            <?php endif; ?>
        </ul>
        <div class="tab-content p-2" id="myTabContent">
            <div class="tab-pane fade show active" id="publicaciones" role="tabpanel"
                aria-labelledby="publicaciones-tab">

                <?php if (!empty($publicaciones)): ?>
                    <?php foreach ($publicaciones as $publicacion): ?>
                        <?php if (!is_null($publicacion)): ?>
                            <div class="row my-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text"><?php echo $publicacion['publicacion']; ?></p>
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
            <div class="tab-pane fade" id="editar" role="tabpanel" aria-labelledby="editar-tab">
                <iframe src="<?= base_url() ?>editar_publicaciones" frameborder="0" width="100%"
                    style="height: 100%;min-height: 500px;"></iframe>
            </div>
        </div>
    </div>
</div>
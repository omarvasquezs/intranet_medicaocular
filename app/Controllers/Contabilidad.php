<?php

namespace App\Controllers;

class Contabilidad extends BaseController
{
    public function contabilidad_boletas()
    {
        $this->gc->setTable('boletas')
            ->setSubject('BOLETA', 'SUBIR BOLETA')
            ->unsetEdit()
            ->unsetDelete()
            ->unsetExport()
            ->unsetPrint()
            ->unsetFilters()
            ->setRead()
            ->setRelation('id_estado_boleta', 'estado_boletas', 'estado_boleta')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('subido_por', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->setFieldUpload('adjunto', 'assets/uploads/boletas/', base_url() . 'assets/uploads/boletas/', [
                'maxUploadSize' => '20M', // 20 Mega Bytes
                'minUploadSize' => '1K', // 1 Kilo Byte
                'allowedFileTypes' => ['pdf']
            ])
            ->unsetFields(['subido_por', 'revisado_por', 'id_estado_boleta', 'fecha_creacion', 'fecha_modificacion', 'observaciones'])
            ->unsetColumns(['subido_por', 'id_estado_boleta', 'fecha_modificacion', 'observaciones'])
            ->unsetSearchColumns(['adjunto'])
            ->displayAs([
                'id_usuario' => 'EMPLEADO',
                'fecha_creacion' => 'FECHA DE CREACION',
                'adjunto' => 'BOLETA',
                'id_estado_boleta' => 'ESTADO DE LA BOLETA',
                'subido_por' => 'SUBIDO POR',
                'fecha_modificacion' => 'FECHA DE MODIFICACION',
                'revisado_por' => 'REVISADO POR',
                'observaciones' => 'OBSERVACIONES'
            ]);

        // Rendering the CRUD
        $output = $this->gc->render();
        return $this->_mainOutput($output);
    }
    public function contabilidad_boletas_rechazadas()
    {
        $this->gc->setTable('boletas')
            ->setSubject('BOLETA', 'BOLETAS RECHAZADAS')
            ->unsetEdit()
            ->unsetDelete()
            ->unsetExport()
            ->unsetPrint()
            ->unsetFilters()
            ->unsetAdd()
            ->where(['id_estado_boleta' => 3])
            ->setRead()
            ->setRelation('id_estado_boleta', 'estado_boletas', 'estado_boleta')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('subido_por', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->setFieldUpload('adjunto', 'assets/uploads/boletas/', base_url() . 'assets/uploads/boletas/', [
                'maxUploadSize' => '20M', // 20 Mega Bytes
                'minUploadSize' => '1K', // 1 Kilo Byte
                'allowedFileTypes' => ['pdf']
            ])
            ->unsetColumns(['subido_por', 'id_estado_boleta', 'fecha_modificacion', 'observaciones'])
            ->unsetSearchColumns(['adjunto'])
            ->displayAs([
                'id_usuario' => 'EMPLEADO',
                'fecha_creacion' => 'FECHA DE CREACION',
                'adjunto' => 'BOLETA',
                'id_estado_boleta' => 'ESTADO DE LA BOLETA',
                'subido_por' => 'SUBIDO POR',
                'fecha_modificacion' => 'FECHA DE MODIFICACION',
                'revisado_por' => 'REVISADO POR',
                'observaciones' => 'OBSERVACIONES'
            ]);

        // Rendering the CRUD
        $output = $this->gc->render();
        return $this->_mainOutput($output);
    }
}

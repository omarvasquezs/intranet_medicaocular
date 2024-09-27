<?php

namespace App\Controllers;

class Contabilidad extends BaseController
{
    public function contabilidad_boletas()
    {
        $this->gc->setTable('boletas')
            ->setSubject('BOLETA', 'HISTORICO BOLETAS')
            ->defaultOrdering('boletas.fecha_creacion', 'desc')
            ->unsetEdit()
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
                'minUploadSize' => '1K' // 1 Kilo Byte
            ])
            ->requiredFields(['id_usuario', 'adjunto'])
            ->addFields(['id_usuario', 'adjunto'])
            ->unsetColumns(['subido_por', 'fecha_modificacion', 'observaciones'])
            ->unsetSearchColumns(['adjunto'])
            ->columns(['id_usuario', 'adjunto', 'id_estado_boleta', 'fecha_creacion', 'revisado_por'])
            ->readFields(['id_usuario', 'adjunto', 'id_estado_boleta', 'fecha_creacion', 'fecha_modificacion', 'subido_por', 'revisado_por', 'observaciones'])
            ->callbackBeforeInsert(function ($stateParameters) {
                $filename = $stateParameters->data['adjunto'];
                $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
                if (strtolower($fileExtension) !== 'pdf') {
                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
                    return $errorMessage->setMessage("Solo puede subir PDFs!\n");
                }
                $currentMonth = date('Y-m');
                $lastDayOfMonth = date('t', strtotime($currentMonth));
                $existingBoleta = $this->boletas->where([
                    'id_usuario' => $stateParameters->data['id_usuario'],
                    'fecha_creacion >=' => $currentMonth . '-01',
                    'fecha_creacion <=' => $currentMonth . '-' . $lastDayOfMonth,
                    'id_estado_boleta !=' => 3
                ])->countAllResults() > 0;
                if ($existingBoleta) {
                    // The error message as a return parameter is only available at Enterprise version
                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
                    return $errorMessage->setMessage("Ya hay boleta registrada de este mes para este usuario.\n");
                }
                $stateParameters->data['subido_por'] = session()->get('user_id');
                $stateParameters->data['id_estado_boleta'] = 1;
                return $stateParameters;
            })
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
        return $this->mainOutput($output);
    }
    public function contabilidad_boletas_rechazadas()
    {
        $this->gc->setTable('boletas')
            ->setSubject('BOLETA', 'BOLETAS RECHAZADAS')
            ->defaultOrdering('boletas.fecha_creacion', 'desc')
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
        return $this->mainOutput($output);
    }
}

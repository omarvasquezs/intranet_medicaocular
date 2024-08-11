<?php

namespace App\Controllers;

class General extends BaseController
{
    public function registrar_permiso()
    {
        $usuarios = $this->usuarios;
        $this->gc->setTable("registro_permisos")
            ->setSubject("PERMISO", "PERMISOS")
            ->unsetFilters()
            ->unsetPrint()
            ->unsetExport()
            ->unsetEdit()
            ->unsetDelete()
            ->setRead()
            ->where([
                'registro_permisos.id_usuario' => session()->get('user_id')
            ])
            ->requiredFields(['id_tipo_permiso', 'sustentacion', 'fecha_inicio', 'fecha_fin'])
            ->readFields(['id_tipo_permiso', 'id_estado_permiso', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'sustentacion', 'adjunto', 'observaciones', 'revisado_por'])
            ->columns(['id_tipo_permiso', 'id_estado_permiso', 'fecha_creacion', 'rango', 'fecha_inicio'])
            ->fieldTypeColumn('rango', 'varchar')
            ->fieldTypeColumn('fecha_inicio', 'invisible')
            ->mapColumn('rango', 'fecha_fin')
            ->callbackColumn('rango', function ($value, $row) {
                // the $value in our case is fecha_fin
                return $row->fecha_inicio . ' - ' . $value;
            })
            ->addFields(['id_tipo_permiso', 'sustentacion', 'fecha_inicio', 'fecha_fin', 'adjunto'])
            ->displayAs('id_usuario', 'USUARIO')
            ->displayAs('id_tipo_permiso', 'TIPO DE PERMISO')
            ->displayAs('id_estado_permiso', 'ESTADO DEL PERMISO')
            ->displayAs('sustentacion', 'SU SUSTENTACIÓN')
            ->displayAs('observaciones', 'OBSERVACIONES DE JEFATURA')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('adjunto', 'CITT (NO ES OBLIGATORIO PARA VACACIONES)')
            ->displayAs('rango', 'RANGO DE FECHAS')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->setRelation('id_tipo_permiso', 'tipo_permisos', 'permiso')
            ->setRelation('id_estado_permiso', 'estado_permisos', 'estado_permiso')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->setFieldUploadMultiple('adjunto', 'assets/uploads/permisos', base_url() . 'assets/uploads/permisos/', [
                'maxUploadSize' => '20M', // 20 Mega Bytes
                'minUploadSize' => '1K', // 1 Kilo Byte
                'allowedFileTypes' => [
                    'gif',
                    'jpeg',
                    'jpg',
                    'png',
                    'tiff',
                    'pdf',
                    'doc',
                    'docx',
                    'xls',
                    'xlsx',
                    'ppt',
                    'pptx',
                    'txt',
                    'zip',
                    'rar'
                ]
            ])
            ->fieldType('sustentacion', 'text')
            ->fieldType('observaciones', 'text')
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date')
            ->callbackReadField('revisado_por', function ($fieldValue, $primaryKeyValue) use ($usuarios) {
                return $usuarios->find($fieldValue)['nombres'];
            })
            ->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['id_estado_permiso'] = 1;
                $stateParameters->data['id_usuario'] = session()->get('user_id');
                $existingPermiso = $this->permisos->where('id_usuario', session()->get('user_id'))
                    ->whereIn('id_estado_permiso', [1, 2])
                    ->groupStart()
                    ->where('fecha_inicio <=', $stateParameters->data['fecha_fin'])
                    ->where('fecha_fin >=', $stateParameters->data['fecha_inicio'])
                    ->groupEnd()
                    ->countAllResults() > 0;

                $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();

                if (in_array($stateParameters->data['id_tipo_permiso'], [1, 2, 4]) && empty($stateParameters->data['adjunto'])) {
                    return $errorMessage->setMessage("NECESITA SUBIR ADJUNTO PARA: MATERNIDAD, DESCANSO MEDICO O PERMISO TEMPORAL\n");
                }

                if ($stateParameters->data['fecha_inicio'] < date('Y-m-d')) {
                    return $errorMessage->setMessage("La fecha de inicio no puede ser anterior a hoy.\n");
                }

                if ($stateParameters->data['fecha_fin'] < date('Y-m-d')) {
                    return $errorMessage->setMessage("La fecha de fin no puede ser anterior a hoy.\n");
                }

                if ($stateParameters->data['fecha_fin'] <= $stateParameters->data['fecha_inicio']) {
                    return $errorMessage->setMessage("La fecha de fin debe ser posterior a la fecha de inicio.\n");
                }

                if ($existingPermiso) {
                    return $errorMessage->setMessage("YA HAY UNA SOLICITUD PENDIENTE DE APROBACION O APROBADA PARA EL RANGO DE FECHAS, CONSULTE A SU JEFATURA.\n");
                }

                return $stateParameters;
            });

        $output = $this->gc->render();

        return $this->_mainOutput($output);
    }
    public function mis_boletas()
    {
        $this->gc->setTable('boletas')
            ->setSubject('BOLETA', 'BOLETAS DE ' . session()->get('nombres'))
            ->unsetExport()
            ->unsetPrint()
            ->unsetFilters()
            ->unsetOperations()
            ->defaultOrdering('boletas.fecha_creacion', 'desc')
            ->where([
                'id_usuario' => session()->get('user_id'),
                'id_estado_boleta' => 2
            ])
            ->setFieldUpload('adjunto', 'assets/uploads/boletas/', base_url() . 'assets/uploads/boletas/', [
                'maxUploadSize' => '20M', // 20 Mega Bytes
                'minUploadSize' => '1K', // 1 Kilo Byte
                'allowedFileTypes' => ['pdf']
            ])
            ->columns(['fecha_creacion', 'adjunto'])
            ->unsetColumns(['id_usuario', 'subido_por', 'id_estado_boleta', 'fecha_modificacion', 'revisado_por', 'observaciones'])
            ->unsetSearchColumns(['adjunto', 'fecha_creacion'])
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

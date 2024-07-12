<?php

namespace App\Controllers;

class General extends BaseController
{
    public function registrar_permiso()
    {
        $usuarios = $this->usuarios;
        $this->gc->setTable("registro_permisos")
            ->setSubject("REGISTRO / PERMISO")
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

                if (($stateParameters->data['id_tipo_permiso'] == 1 || $stateParameters->data['id_tipo_permiso'] == 3) && empty($stateParameters->data['adjunto'])) {
                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
                    return $errorMessage->setMessage("Necesita añadir ADJUNTO para MATERNIDAD o DESCANSO MEDICO.\n");
                }

                if ($stateParameters->data['fecha_inicio'] < date('Y-m-d')) {
                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
                    return $errorMessage->setMessage("La fecha de inicio no puede ser anterior a hoy.\n");
                }

                if ($stateParameters->data['fecha_fin'] < date('Y-m-d')) {
                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
                    return $errorMessage->setMessage("La fecha de fin no puede ser anterior a hoy.\n");
                }

                if ($stateParameters->data['fecha_fin'] <= $stateParameters->data['fecha_inicio']) {
                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
                    return $errorMessage->setMessage("La fecha de fin debe ser posterior a la fecha de inicio.\n");
                }

                return $stateParameters;
            });

        $output = $this->gc->render();

        return $this->_mainOutput($output);
    }
}

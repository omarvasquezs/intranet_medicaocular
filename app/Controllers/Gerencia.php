<?php

namespace App\Controllers;

class Gerencia extends BaseController
{
    public function permisos_pendientes()
    {
        $this->gc->setTable("registro_permisos")
            ->setSubject("PERMISOS PENDIENTES DE APROBACION", "PERMISOS PENDIENTES DE APROBACION")
            ->unsetFilters()
            ->unsetPrint()
            ->unsetExport()
            ->unsetAdd()
            ->unsetDelete()
            ->setRead()
            ->where([
                'registro_permisos.id_estado_permiso' => 1
            ])
            ->requiredFields(['id_estado_permiso'])
            ->readFields(['id_tipo_permiso', 'id_estado_permiso', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'sustentacion', 'adjunto', 'observaciones', 'revisado_por'])
            ->columns(['id_tipo_permiso', 'id_usuario', 'fecha_creacion', 'rango', 'fecha_inicio'])
            ->readOnlyEditFields(['id_usuario', 'id_tipo_permiso', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'sustentacion'])
            ->unsetEditFields(['revisado_por', 'fecha_creacion', 'adjunto', 'sustentacion'])
            ->unsetReadFields(['observaciones', 'revisado_por'])
            ->fieldTypeColumn('rango', 'varchar')
            ->fieldTypeColumn('fecha_inicio', 'invisible')
            ->mapColumn('rango', 'fecha_fin')
            ->callbackColumn('rango', function ($value, $row) {
                // the $value in our case is fecha_fin
                return $row->fecha_inicio . ' - ' . $value;
            })
            ->callbackReadField('adjunto', function ($fieldValue, $primaryKeyValue) {
                return '<a href="' . base_url() . 'assets/uploads/permisos/' . $fieldValue . '" target="_blank">' . $fieldValue . '</a>';
            })
            ->callbackBeforeUpdate(function ($stateParameters) {
                $stateParameters->data['revisado_por'] = session()->get('user_id');
                return $stateParameters;
            })
            ->displayAs('id_usuario', 'SOLICITADO POR')
            ->displayAs('id_tipo_permiso', 'TIPO DE PERMISO')
            ->displayAs('id_estado_permiso', 'ESTADO DEL PERMISO')
            ->displayAs('sustentacion', 'SUSTENTACIÓN')
            ->displayAs('observaciones', 'OBSERVACIONES DE JEFATURA')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('adjunto', 'CITT')
            ->displayAs('rango', 'DURACION DEL PERMISO')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('id_tipo_permiso', 'tipo_permisos', 'permiso')
            ->setRelation('id_estado_permiso', 'estado_permisos', 'estado_permiso')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->fieldType('sustentacion', 'text')
            ->fieldType('observaciones', 'text')
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date');

        $output = $this->gc->render();

        return $this->_mainOutput($output);
    }
}

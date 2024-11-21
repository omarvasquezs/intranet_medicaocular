<?php

namespace App\Controllers;

use App\Models\PermisosGerenciaCustom;

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
            ->callbackEditField('adjunto', function ($fieldValue, $primaryKeyValue, $rowData) {
                if ($fieldValue !== null) {
                    $links = [];
                    foreach (explode(',', $fieldValue) as $file) {
                        $links[] = anchor(base_url() . 'assets/uploads/permisos/' . trim($file), trim($file), ['target' => '_blank', 'rel' => 'noopener noreferrer']);
                    }
                    $output = implode('<br>', $links) . '<input type="hidden" name="adjunto" value="' . $fieldValue . '">';
                    return $output;
                } else {
                    return '<span style="color: #999;">NO APLICA.</span><input type="hidden" name="adjunto" value="">';
                }
            })
            ->setFieldUploadMultiple(
                'adjunto',
                'assets/uploads/permisos',
                base_url() . 'assets/uploads/permisos/',
                [
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
                ]
            )
            ->setRead()
            ->where([
                'registro_permisos.id_estado_permiso' => 1
            ])
            ->requiredFields(['id_estado_permiso'])
            ->editFields(['id_usuario', 'id_tipo_permiso', 'fecha_inicio', 'fecha_fin', 'fecha_retorno', 'id_estado_permiso', 'observaciones', 'adjunto'])
            ->readFields(['id_usuario', 'id_tipo_permiso', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno', 'sustentacion', 'adjunto', 'observaciones', 'revisado_por'])
            ->columns(['id_tipo_permiso', 'id_usuario', 'fecha_creacion', 'rango', 'fecha_inicio', 'fecha_retorno'])
            ->readOnlyEditFields(['id_usuario', 'id_tipo_permiso', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno', 'sustentacion'])
            ->unsetEditFields(['revisado_por', 'fecha_creacion', 'sustentacion'])
            ->unsetReadFields(['observaciones', 'revisado_por'])
            ->fieldTypeColumn('rango', 'varchar')
            ->fieldTypeColumn('fecha_inicio', 'invisible')
            ->mapColumn('rango', 'fecha_fin')
            ->callbackColumn('rango', function ($value, $row) {
                return $row->fecha_inicio . ' - ' . $value;
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
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('adjunto', 'CITT o ADJUNTOS')
            ->displayAs('rango', 'DURACION DEL PERMISO')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('id_tipo_permiso', 'tipo_permisos', 'permiso')
            ->setRelation('id_estado_permiso', 'estado_permisos', 'estado_permiso')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->fieldType('sustentacion', 'text')
            ->fieldType('observaciones', 'text')
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date');

        if (!in_array(1, session()->get('roles'))) {
            $this->gc->setModel(new PermisosGerenciaCustom($this->getDbData()));
        }

        $output = $this->gc->render();

        return $this->mainOutput($output);
    }
    public function permisos_aprobados()
    {
        $this->gc->setTable("registro_permisos")
            ->setSubject("PERMISOS APROBADOS", "HISTORICO DE PERMISOS APROBADOS")
            ->unsetFilters()
            ->unsetPrint()
            ->unsetExport()
            ->unsetAdd()
            ->unsetEdit()
            ->setFieldUploadMultiple(
                'adjunto',
                'assets/uploads/permisos',
                base_url() . 'assets/uploads/permisos/',
                [
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
                ]
            )
            ->setRead()
            ->where([
                'registro_permisos.id_estado_permiso' => 2
            ])
            ->readFields(['id_usuario', 'id_tipo_permiso', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno', 'sustentacion', 'adjunto', 'observaciones', 'revisado_por'])
            ->columns(['id_tipo_permiso', 'id_usuario', 'fecha_creacion', 'rango', 'fecha_inicio', 'fecha_retorno'])
            ->fieldTypeColumn('rango', 'varchar')
            ->fieldTypeColumn('fecha_inicio', 'invisible')
            ->mapColumn('rango', 'fecha_fin')
            ->callbackColumn('rango', function ($value, $row) {
                // the $value in our case is fecha_fin
                return $row->fecha_inicio . ' - ' . $value;
            })
            ->displayAs('id_usuario', 'SOLICITADO POR')
            ->displayAs('id_tipo_permiso', 'TIPO DE PERMISO')
            ->displayAs('id_estado_permiso', 'ESTADO DEL PERMISO')
            ->displayAs('sustentacion', 'SUSTENTACIÓN')
            ->displayAs('observaciones', 'OBSERVACIONES DE JEFATURA')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('adjunto', 'CITT o ADJUNTO')
            ->displayAs('rango', 'DURACION DEL PERMISO')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('id_tipo_permiso', 'tipo_permisos', 'permiso')
            ->setRelation('id_estado_permiso', 'estado_permisos', 'estado_permiso')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->fieldType('sustentacion', 'text')
            ->fieldType('observaciones', 'text')
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date');

        if (!in_array(1, session()->get('roles'))) {
            $this->gc->setModel(new PermisosGerenciaCustom($this->getDbData()));
        }

        $output = $this->gc->render();

        return $this->mainOutput($output);
    }
    public function permisos_rechazados()
    {
        $this->gc->setTable("registro_permisos")
            ->setSubject("PERMISOS RECHAZADOS", "HISTORICO DE PERMISOS RECHAZADOS")
            ->unsetFilters()
            ->unsetPrint()
            ->unsetExport()
            ->unsetAdd()
            ->unsetEdit()
            ->setFieldUploadMultiple(
                'adjunto',
                'assets/uploads/permisos',
                base_url() . 'assets/uploads/permisos/',
                [
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
                ]
            )
            ->setRead()
            ->where([
                'registro_permisos.id_estado_permiso' => 3
            ])
            ->readFields(['id_usuario', 'id_tipo_permiso', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno', 'sustentacion', 'adjunto', 'observaciones', 'revisado_por'])
            ->columns(['id_tipo_permiso', 'id_usuario', 'fecha_creacion', 'rango', 'fecha_inicio', 'fecha_retorno'])
            ->fieldTypeColumn('rango', 'varchar')
            ->fieldTypeColumn('fecha_inicio', 'invisible')
            ->mapColumn('rango', 'fecha_fin')
            ->callbackColumn('rango', function ($value, $row) {
                // the $value in our case is fecha_fin
                return $row->fecha_inicio . ' - ' . $value;
            })
            ->displayAs('id_usuario', 'SOLICITADO POR')
            ->displayAs('id_tipo_permiso', 'TIPO DE PERMISO')
            ->displayAs('id_estado_permiso', 'ESTADO DEL PERMISO')
            ->displayAs('sustentacion', 'SUSTENTACIÓN')
            ->displayAs('observaciones', 'OBSERVACIONES DE JEFATURA')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA DE RETORNO')
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

        if (!in_array(1, session()->get('roles'))) {
            $this->gc->setModel(new PermisosGerenciaCustom($this->getDbData()));
        }

        $output = $this->gc->render();

        return $this->mainOutput($output);
    }
}

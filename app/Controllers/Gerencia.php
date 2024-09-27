<?php

namespace App\Controllers;

use App\Models\PermisosGerenciaCustom;
use setasign\Fpdi\Tcpdf\Fpdi;

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
            ->setRead()
            ->where([
                'registro_permisos.id_estado_permiso' => 1
            ])
            ->requiredFields(['id_estado_permiso'])
            ->editFields(['id_usuario', 'id_tipo_permiso', 'fecha_inicio', 'fecha_fin', 'id_estado_permiso', 'observaciones'])
            ->readFields(['id_usuario', 'id_tipo_permiso', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'sustentacion', 'adjunto', 'observaciones', 'revisado_por'])
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

        if (!in_array(1, session()->get('roles'))) {
            $this->gc->setModel(new PermisosGerenciaCustom($this->_getDbData()));
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
            ->setRead()
            ->where([
                'registro_permisos.id_estado_permiso' => 2
            ])
            ->readFields(['id_usuario', 'id_tipo_permiso', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'sustentacion', 'adjunto', 'observaciones', 'revisado_por'])
            ->columns(['id_tipo_permiso', 'id_usuario', 'fecha_creacion', 'rango', 'fecha_inicio'])
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

        if (!in_array(1, session()->get('roles'))) {
            $this->gc->setModel(new PermisosGerenciaCustom($this->_getDbData()));
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
            ->unsetDelete()
            ->unsetEdit()
            ->setRead()
            ->where([
                'registro_permisos.id_estado_permiso' => 3
            ])
            ->readFields(['id_usuario', 'id_tipo_permiso', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'sustentacion', 'adjunto', 'observaciones', 'revisado_por'])
            ->columns(['id_tipo_permiso', 'id_usuario', 'fecha_creacion', 'rango', 'fecha_inicio'])
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

        if (!in_array(1, session()->get('roles'))) {
            $this->gc->setModel(new PermisosGerenciaCustom($this->_getDbData()));
        }

        $output = $this->gc->render();

        return $this->mainOutput($output);
    }
    public function boletas_pendientes()
    {
        $this->gc->setTable("boletas")
            ->setSubject("BOLETA PENDIENTE DE APROBACION", "BOLETAS PENDIENTES DE APROBACION")
            ->defaultOrdering('boletas.fecha_creacion', 'desc')
            ->unsetFilters()
            ->unsetPrint()
            ->unsetExport()
            ->unsetAdd()
            ->unsetDelete()
            ->setRead()
            ->where([
                'boletas.id_estado_boleta' => 1
            ])
            ->requiredFields(['id_estado_boleta'])
            ->editFields(['id_usuario', 'adjunto', 'id_estado_boleta', 'observaciones'])
            ->readFields(['id_usuario', 'fecha_creacion', 'adjunto', 'id_estado_boleta', 'observaciones', 'revisado_por'])
            ->columns(['id_usuario', 'fecha_creacion', 'adjunto', 'id_estado_boleta'])
            ->readOnlyEditFields(['id_usuario', 'fecha_creacion', 'adjunto'])
            ->unsetEditFields(['revisado_por', 'fecha_creacion'])
            ->unsetReadFields(['observaciones', 'revisado_por'])
            ->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['subido_por'] = session()->get('user_id');
                $stateParameters->data['id_estado_boleta'] = 1;
                return $stateParameters;
            })
            ->callbackBeforeUpdate(function ($stateParameters) {
                $stateParameters->data['revisado_por'] = session()->get('user_id');
                return $stateParameters;
            })
            ->displayAs('id_usuario', 'EMPLEADO')
            ->displayAs('id_estado_boleta', 'ESTADO DE LA BOLETA')
            ->displayAs('adjunto', 'BOLETA')
            ->displayAs('observaciones', 'OBSERVACIONES')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('id_estado_boleta', 'estado_boletas', 'estado_boleta')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->fieldType('observaciones', 'text')
            ->callbackColumn('adjunto', function ($value, $row) {
                return "<a href='" . site_url('assets/uploads/boletas/' . $row->adjunto) . "' target='" . "_blank" . "'>$row->adjunto</a>";
            })
            ->callbackReadField('adjunto', function ($fieldValue, $primaryKeyValue) {
                return "<a href='" . site_url('assets/uploads/boletas/' . $fieldValue) . "' target='" . "_blank" . "'>$fieldValue</a>";
            })
            ->callbackAfterUpdate(function ($stateParameters) {
                if ($stateParameters->data['id_estado_boleta'] == 2) {
                    $existingPdfPath = FCPATH . 'assets/uploads/boletas/' . $this->boletas->find($stateParameters->primaryKeyValue)['adjunto'];

                    // Create new FPDI instance
                    $pdf = new Fpdi();

                    // Disable automatic page break
                    $pdf->SetAutoPageBreak(false, 0);

                    $pdf->setPrintHeader(false);

                    // Import the existing PDF
                    $pdf->setSourceFile($existingPdfPath);

                    // We'll only work with the first page
                    $templateId = $pdf->importPage(1);
                    $size = $pdf->getTemplateSize($templateId);

                    // Add only one page
                    $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));

                    // Use the template
                    $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height'], true);

                    $firmaPath = FCPATH . 'assets/uploads/firmas/' . $this->usuarios->find(session()->get('user_id'))['firma'];

                    if (is_file($firmaPath) && is_readable($firmaPath)) {
                        // Get signature dimensions
                        list($sigWidth, $sigHeight) = getimagesize($firmaPath);

                        // Calculate scaling factor to fit within 20x10
                        $scale = min(40 / $sigWidth, 20 / $sigHeight);
                        $newWidth = $sigWidth * $scale;
                        $newHeight = $sigHeight * $scale;

                        $x = 47;  // Adjust this value to move left or right

                        // First signature position (adjust as needed)
                        $y1 = 118;  // Adjust this value to move up or down

                        // Second signature position (adjust as needed)
                        $y2 = 269; // Adjust this value to move up or down

                        // Add the first signature image
                        $pdf->Image($firmaPath, $x, $y1, $newWidth, $newHeight, 'PNG');

                        // Add the second signature image
                        $pdf->Image($firmaPath, $x, $y2, $newWidth, $newHeight, 'PNG');
                    } else {
                        log_message('error', 'Signature file not found or not readable: ' . $firmaPath);
                    }

                    // Save the modified PDF
                    $pdf->Output($existingPdfPath, 'F');
                }
                return $stateParameters;
            });

        $output = $this->gc->render();

        return $this->mainOutput($output);
    }
    public function boletas_aprobadas()
    {
        $this->gc->setTable("boletas")
            ->setSubject("BOLETA ABONADA", "BOLETAS ABONADAS")
            ->defaultOrdering('boletas.fecha_creacion', 'desc')
            ->unsetFilters()
            ->unsetPrint()
            ->unsetExport()
            ->unsetAdd()
            ->unsetDelete()
            ->unsetEdit()
            ->setRead()
            ->where([
                'boletas.id_estado_boleta' => 2
            ])
            ->requiredFields(['id_estado_boleta'])
            ->editFields(['id_usuario', 'adjunto', 'id_estado_boleta', 'observaciones'])
            ->readFields(['id_usuario', 'fecha_creacion', 'adjunto', 'id_estado_boleta', 'observaciones', 'revisado_por'])
            ->columns(['id_usuario', 'fecha_creacion', 'adjunto', 'id_estado_boleta'])
            ->readOnlyEditFields(['id_usuario', 'fecha_creacion', 'adjunto'])
            ->unsetEditFields(['revisado_por', 'fecha_creacion'])
            ->unsetReadFields(['observaciones', 'revisado_por'])
            ->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['subido_por'] = session()->get('user_id');
                $stateParameters->data['id_estado_boleta'] = 1;
                return $stateParameters;
            })
            ->callbackBeforeUpdate(function ($stateParameters) {
                $stateParameters->data['revisado_por'] = session()->get('user_id');
                return $stateParameters;
            })
            ->displayAs('id_usuario', 'EMPLEADO')
            ->displayAs('id_estado_boleta', 'ESTADO DE LA BOLETA')
            ->displayAs('adjunto', 'BOLETA')
            ->displayAs('observaciones', 'OBSERVACIONES')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('id_estado_boleta', 'estado_boletas', 'estado_boleta')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->fieldType('observaciones', 'text')
            ->setFieldUpload('adjunto', 'assets/uploads/boletas/', base_url() . 'assets/uploads/boletas/', [
                'maxUploadSize' => '20M', // 20 Mega Bytes
                'minUploadSize' => '1K', // 1 Kilo Byte
                'allowedFileTypes' => ['pdf']
            ]);

        $output = $this->gc->render();

        return $this->mainOutput($output);
    }
}

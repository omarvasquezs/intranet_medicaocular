<?php

/**
 * General Controller
 * php version 8.2
 *
 * @category Controllers
 * @package  App\Controllers
 * @author   Omar Vásquez <omarvs91@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://omarvasquezs.github.io
 */

namespace App\Controllers;
use setasign\Fpdi\Tcpdf\Fpdi;
/**
 * Class General
 *
 * @category Controllers
 * @package  App\Controllers
 * @author   Omar Vásquez <omarvs91@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://omarvasquezs.github.io
 */
class General extends BaseController
{
    /**
     * Handles the registrar_permiso page.
     *
     * @return mixed
     */
    public function registrarPermiso()
    {
        $usuarios = $this->usuarios;
        $this->gc->setTable("registro_permisos")
            ->defaultOrdering('registro_permisos.id', 'desc')
            ->setSubject("PERMISO", "PERMISOS")
            ->unsetFilters()
            ->unsetPrint()
            ->unsetExport()
            ->setRead()
            ->where(
                [
                    'registro_permisos.id_usuario' => session()->get('user_id')
                ]
            )
            ->editFields(
                [
                    'id_usuario',
                    'id_tipo_permiso',
                    'id_estado_permiso',
                    'fecha_inicio',
                    'fecha_fin',
                    'fecha_retorno',
                    'sustentacion',
                    'adjunto'
                ]
            )
            ->readOnlyEditFields(
                [
                    'id_usuario',
                    'id_tipo_permiso',
                    'fecha_creacion',
                    'id_estado_permiso'
                ]
            )
            ->requiredFields(
                ['id_tipo_permiso', 'sustentacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno']
            )
            ->requiredEditFields(['fecha_inicio', 'fecha_fin', 'fecha_retorno'])
            ->readFields(
                [
                    'id_tipo_permiso',
                    'id_estado_permiso',
                    'fecha_creacion',
                    'fecha_inicio',
                    'fecha_fin',
                    'fecha_retorno',
                    'sustentacion',
                    'adjunto',
                    'observaciones',
                    'revisado_por',
                    'goce_haber'
                ]
            )
            ->columns(
                [
                    'id_tipo_permiso',
                    'id_estado_permiso',
                    'rango',
                    'fecha_inicio',
                    'fecha_retorno',
                    'fecha_creacion',
                    'goce_haber'
                ]
            )
            ->fieldTypeColumn('rango', 'varchar')
            ->fieldTypeColumn('fecha_inicio', 'invisible')
            ->mapColumn('rango', 'fecha_fin')
            ->callbackColumn(
                'rango',
                function ($value, $row) {
                    // the $value in our case is fecha_fin
                    return $row->fecha_inicio . ' - ' . $value;
                }
            )
            ->addFields(
                [
                    'id_tipo_permiso',
                    'sustentacion',
                    'fecha_inicio',
                    'fecha_fin',
                    'fecha_retorno',
                    'adjunto'
                ]
            )
            ->displayAs('id_usuario', 'USUARIO')
            ->displayAs('id_tipo_permiso', 'TIPO DE PERMISO')
            ->displayAs('id_estado_permiso', 'ESTADO DEL PERMISO')
            ->displayAs('sustentacion', 'SU SUSTENTACIÓN')
            ->displayAs('observaciones', 'OBSERVACIONES DE JEFATURA')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('adjunto', 'CITT (NO ES OBLIGATORIO PARA VACACIONES)')
            ->displayAs('rango', 'RANGO DE FECHAS')
            ->displayAs('goce_haber', 'GOCE DE HABER')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->setRelation('id_tipo_permiso', 'tipo_permisos', 'permiso')
            ->setRelation('id_estado_permiso', 'estado_permisos', 'estado_permiso')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->setDeleteMultiple()
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
            ->callbackReadField('adjunto', function ($fieldValue, $primaryKeyValue, $rowData) {
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
            ->fieldType('sustentacion', 'text')
            ->fieldType('observaciones', 'text')
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date')
            ->fieldType('fecha_retorno', 'native_date')
            ->fieldType('goce_haber', 'dropdown', [
                0 => 'NO',
                1 => 'SI'
            ])
            ->callbackReadField(
                'revisado_por',
                function ($fieldValue, $primaryKeyValue) use ($usuarios) {
                    return $usuarios->find($fieldValue)['nombres'];
                }
            )
            ->callbackBeforeUpdate(
                function ($stateParameters) {
                    $fecha_inicio = $stateParameters->data['fecha_inicio'];
                    $fecha_fin = $stateParameters->data['fecha_fin'];
                    $fecha_retorno = $stateParameters->data['fecha_retorno'];
                    
                    $existingPermiso = $this->permisos
                        ->where('id_usuario', session()->get('user_id'))
                        ->whereIn('id_estado_permiso', [1, 2])
                        ->where('id !=', $stateParameters->primaryKeyValue)
                        ->groupStart()
                        ->where(
                            'fecha_inicio <=',
                            $stateParameters->data['fecha_fin']
                        )
                        ->where(
                            'fecha_fin >=',
                            $stateParameters->data['fecha_inicio']
                        )
                        ->groupEnd()
                        ->countAllResults() > 0;

                    $id_tipo_permiso = $this->permisos
                        ->find(
                            $stateParameters->primaryKeyValue
                        )['id_tipo_permiso'];
                    $id_estado_permiso = $this->permisos
                        ->find(
                            $stateParameters->primaryKeyValue
                        )['id_estado_permiso'];

                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();

                    if ($fecha_fin < $fecha_inicio) {
                        return $errorMessage->setMessage(
                            "La fecha de fin debe ser igual o posterior
                            a la fecha de inicio.\n"
                        );
                    }

                    if ($fecha_retorno < $fecha_fin) {
                        return $errorMessage->setMessage(
                            "La fecha de retorno debe ser igual o posterior
                            a la fecha de inicio.\n"
                        );
                    }

                    if (
                        in_array($id_tipo_permiso, [1, 2, 4])
                        && empty($stateParameters->data['adjunto'])
                    ) {
                        return $errorMessage->setMessage(
                            "NECESITA SUBIR ADJUNTO PARA:
                        MATERNIDAD, DESCANSO MEDICO O PERMISO TEMPORAL\n"
                        );
                    }

                    if (in_array($id_estado_permiso, [2, 3])) {
                        return $errorMessage->setMessage(
                            "ESTE PERMISO ESTA APROBADO o RECHAZADO,
                        YA NO SE PUEDE MODIFICAR."
                        );
                    }

                    if ($existingPermiso) {
                        return $errorMessage->setMessage(
                            "YA HAY UNA SOLICITUD PENDIENTE DE APROBACION
                            O APROBADA PARA EL RANGO DE FECHAS,
                            CONSULTE A SU JEFATURA.\n"
                        );
                    }

                    return $stateParameters;
                }
            )
            ->callbackBeforeInsert(
                function ($stateParameters) {
                    $fecha_inicio = $stateParameters->data['fecha_inicio'];
                    $fecha_fin = $stateParameters->data['fecha_fin'];
                    $fecha_retorno = $stateParameters->data['fecha_retorno'];

                    $stateParameters->data['id_estado_permiso'] = 1;
                    $stateParameters->data['id_usuario'] = session()->get('user_id');
                    $existingPermiso = $this->permisos
                        ->where('id_usuario', session()->get('user_id'))
                        ->whereIn('id_estado_permiso', [1, 2])
                        ->groupStart()
                        ->where(
                            'fecha_inicio <=',
                            $stateParameters->data['fecha_fin']
                        )
                        ->where(
                            'fecha_fin >=',
                            $stateParameters->data['fecha_inicio']
                        )
                        ->groupEnd()
                        ->countAllResults() > 0;

                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();

                    if (
                        in_array(
                            $stateParameters->data['id_tipo_permiso'],
                            [1, 2, 4]
                        )
                        && empty($stateParameters->data['adjunto'])
                    ) {
                        return $errorMessage->setMessage(
                            "NECESITA SUBIR ADJUNTO PARA: MATERNIDAD,
                            DESCANSO MEDICO O PERMISO TEMPORAL\n"
                        );
                    }
                    /*
                    if ($fecha_fin < date('Y-m-d')) {
                        return $errorMessage->setMessage(
                            "La fecha de fin no puede ser anterior a hoy.\n"
                        );
                    }
                    */
                    if ($fecha_fin < $fecha_inicio) {
                        return $errorMessage->setMessage(
                            "La fecha de fin debe ser igual o posterior
                            a la fecha de inicio.\n"
                        );
                    }

                    if ($fecha_retorno < $fecha_fin) {
                        return $errorMessage->setMessage(
                            "La fecha de retorno debe ser igual o posterior
                            a la fecha de inicio.\n"
                        );
                    }

                    if ($existingPermiso) {
                        return $errorMessage->setMessage(
                            "YA HAY UNA SOLICITUD PENDIENTE DE APROBACION
                            O APROBADA PARA EL RANGO DE FECHAS,
                            CONSULTE A SU JEFATURA.\n"
                        );
                    }

                    return $stateParameters;
                }
            )
            ->callbackDelete(
                function ($stateParameters) {
                    $id_estado_permiso = $this->permisos
                        ->find(
                            $stateParameters->primaryKeyValue
                        )['id_estado_permiso'];
                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
                    if ($id_estado_permiso != 1) {
                        return $errorMessage->setMessage(
                            "NO PUEDE BORRAR PERMISO YA APROBADO
                            o RECHAZADO.\n"
                        );
                    } else {
                        $this->permisos
                            ->where(
                                'id',
                                $stateParameters->primaryKeyValue
                            )->delete();
                    }
                    return $stateParameters;
                }
            );

        $output = $this->gc->render();

        return $this->mainOutput($output);
    }
    /**
     * Handles the mis_boletas page.
     *
     * @return mixed
     */
    public function misBoletas()
    {
        $this->gc->setTable('boletas')
            ->setSubject('BOLETA', 'BOLETAS DE ' . session()->get('nombres'))
            ->unsetExport()
            ->unsetPrint()
            ->unsetFilters()
            ->unsetOperations()
            ->defaultOrdering('boletas.fecha_creacion', 'desc')
            ->where(
                [
                    'id_usuario' => session()->get('user_id'),
                    'id_estado_boleta' => 2
                ]
            )
            ->setFieldUpload(
                'adjunto',
                'assets/uploads/boletas/',
                base_url() . 'assets/uploads/boletas/',
                [
                    'maxUploadSize' => '20M', // 20 Mega Bytes
                    'minUploadSize' => '1K', // 1 Kilo Byte
                    'allowedFileTypes' => ['pdf']
                ]
            )
            ->columns(['fecha_creacion', 'adjunto', 'boleta_firmada'])
            ->unsetColumns(
                [
                    'id_usuario',
                    'subido_por',
                    'id_estado_boleta',
                    'fecha_modificacion',
                    'revisado_por',
                    'observaciones'
                ]
            )
            ->unsetSearchColumns(['adjunto', 'fecha_creacion', 'boleta_firmada'])
            ->callbackColumn(
                'boleta_firmada',
                function ($value, $row) {
                    switch ($value) {
                        case 0:
                            return "YA FIRMADO";
                        case 1:
                            return "AUN NO FIRMADO";
                        default:
                            return "NO DATA";
                    }
                }
            )
            ->callbackColumn(
                'adjunto',
                function ($value, $row) {
                    return '<a href="' . base_url('updateBoletaVisto/' . $row->id) . 
                           '" target="_blank" rel="noopener noreferrer">' . $value . '</a>';
                }
            )
            ->displayAs(
                [
                    'id_usuario' => 'EMPLEADO',
                    'fecha_creacion' => 'FECHA DE CREACION',
                    'adjunto' => 'BOLETA',
                    'id_estado_boleta' => 'ESTADO DE LA BOLETA',
                    'subido_por' => 'SUBIDO POR',
                    'fecha_modificacion' => 'FECHA DE MODIFICACION',
                    'revisado_por' => 'REVISADO POR',
                    'observaciones' => 'OBSERVACIONES',
                    'boleta_firmada' => 'FIRMADA POR USUARIO'
                ]
            )
            ->setActionButton(
                'FIRMAR',
                'fas fa-signature',
                function ($row) {
                    return '/firmar_boleta/' . $row->id;
                },
                false
            );

        // Rendering the CRUD
        $output = $this->gc->render();
        return $this->mainOutput($output);
    }
    /**
     * Handles the mis_boletas page.
     *
     * @return mixed
     */
    public function misBoletasCTS()
    {
        $this->gc->setTable('boletas_cts')
            ->setSubject('BOLETA DE CTS', 'BOLETAS DE CTS DE ' . session()->get('nombres'))
            ->unsetExport()
            ->unsetPrint()
            ->unsetFilters()
            ->unsetOperations()
            ->defaultOrdering('boletas_cts.fecha_creacion', 'desc')
            ->where(
                [
                    'id_usuario' => session()->get('user_id'),
                    'id_estado_boleta' => 2
                ]
            )
            ->setFieldUpload(
                'adjunto',
                'assets/uploads/cts/',
                base_url() . 'assets/uploads/cts/',
                [
                    'maxUploadSize' => '20M', // 20 Mega Bytes
                    'minUploadSize' => '1K', // 1 Kilo Byte
                    'allowedFileTypes' => ['pdf']
                ]
            )
            ->columns(['fecha_creacion', 'adjunto', 'boleta_firmada'])
            ->unsetColumns(
                [
                    'id_usuario',
                    'subido_por',
                    'id_estado_boleta',
                    'fecha_modificacion',
                    'revisado_por',
                    'observaciones'
                ]
            )
            ->unsetSearchColumns(['adjunto', 'fecha_creacion', 'boleta_firmada'])
            ->callbackColumn(
                'boleta_firmada',
                function ($value, $row) {
                    switch ($value) {
                        case 0:
                            return "YA FIRMADO";
                        case 1:
                            return "AUN NO FIRMADO";
                        default:
                            return "NO DATA";
                    }
                }
            )
            ->callbackColumn(
                'adjunto',
                function ($value, $row) {
                    return '<a href="' . base_url('updateBoletaCTSVisto/' . $row->id) . 
                           '" target="_blank" rel="noopener noreferrer">' . $value . '</a>';
                }
            )
            ->displayAs(
                [
                    'id_usuario' => 'EMPLEADO',
                    'fecha_creacion' => 'FECHA DE CREACION',
                    'adjunto' => 'BOLETA',
                    'id_estado_boleta' => 'ESTADO DE LA BOLETA',
                    'subido_por' => 'SUBIDO POR',
                    'fecha_modificacion' => 'FECHA DE MODIFICACION',
                    'revisado_por' => 'REVISADO POR',
                    'observaciones' => 'OBSERVACIONES',
                    'boleta_firmada' => 'FIRMADA POR USUARIO'
                ]
            )
            ->setActionButton(
                'FIRMAR',
                'fas fa-signature',
                function ($row) {
                    return '/firmar_boleta_cts/' . $row->id;
                },
                false
            );

        // Rendering the CRUD
        $output = $this->gc->render();
        return $this->mainOutput($output);
    }

    /**
     * Updates the 'visto' field to 1 for a regular boleta and redirects to the PDF file
     *
     * @param int $id The ID of the boleta
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function updateBoletaVisto($id)
    {
        $boleta = $this->boletas->find($id);
        
        if ($boleta && $boleta['id_usuario'] == session()->get('user_id')) {
            try {
                // Check if the database has the 'visto' field
                $db = \Config\Database::connect();
                $fields = $db->getFieldData('boletas');
                $hasVistoField = false;
                
                foreach ($fields as $field) {
                    if ($field->name === 'visto') {
                        $hasVistoField = true;
                        break;
                    }
                }
                
                if ($hasVistoField) {
                    // Check if the 'visto' field is already set to 1
                    if ($boleta['visto'] != 1) {
                        // Update the visto field to 1
                        $data = ['visto' => 1];
                        $this->boletas->update($id, $data);
                        log_message('info', 'Boleta visto updated successfully for ID: ' . $id);
                    }
                } else {
                    log_message('warning', 'The visto field does not exist in the boletas table');
                }
            } catch (\Exception $e) {
                // Log any errors that occur
                log_message('error', 'Error updating boleta visto: ' . $e->getMessage());
            }
        } else {
            // Log if boleta not found or not owned by user
            log_message('warning', 'Boleta not found or unauthorized access for ID: ' . $id);
        }
        
        // Redirect to the actual PDF file
        if ($boleta && isset($boleta['adjunto'])) {
            return redirect()->to(base_url('assets/uploads/boletas/' . $boleta['adjunto']));
        } else {
            // Redirect back if no boleta found
            return redirect()->back()->with('error', 'Boleta no encontrada');
        }
    }

    /**
     * Updates the 'visto' field to 1 for a CTS boleta and redirects to the PDF file
     *
     * @param int $id The ID of the boleta_cts
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function updateBoletaCTSVisto($id)
    {
        $boleta = $this->cts->find($id);
        
        if ($boleta && $boleta['id_usuario'] == session()->get('user_id')) {
            try {
                // Check if the database has the 'visto' field
                $db = \Config\Database::connect();
                $fields = $db->getFieldData('boletas_cts');
                $hasVistoField = false;
                
                foreach ($fields as $field) {
                    if ($field->name === 'visto') {
                        $hasVistoField = true;
                        break;
                    }
                }
                
                if ($hasVistoField) {
                    // Check if the 'visto' field is already set to 1
                    if ($boleta['visto'] != 1) {
                        // Update the visto field to 1
                        $data = ['visto' => 1];
                        $this->cts->update($id, $data);
                        log_message('info', 'Boleta CTS visto updated successfully for ID: ' . $id);
                    }
                } else {
                    log_message('warning', 'The visto field does not exist in the boletas_cts table');
                }
            } catch (\Exception $e) {
                // Log any errors that occur
                log_message('error', 'Error updating boleta CTS visto: ' . $e->getMessage());
            }
        } else {
            // Log if boleta not found or not owned by user
            log_message('warning', 'Boleta CTS not found or unauthorized access for ID: ' . $id);
        }
        
        // Redirect to the actual PDF file
        if ($boleta && isset($boleta['adjunto'])) {
            return redirect()->to(base_url('assets/uploads/cts/' . $boleta['adjunto']));
        } else {
            // Redirect back if no boleta found
            return redirect()->back()->with('error', 'Boleta CTS no encontrada');
        }
    }

    /**
     * Handles the firmar_boleta page.
     *
     * @return mixed
     */
    public function firmarBoleta()
    {
        if (!$this->usuarios->find(session()->get('user_id'))['firma']) {
            return redirect()
                ->back()->with(
                    'error',
                    'DEBE SUBIR SU FIRMA PRIMERO
                ANTES DE FIRMAR SU BOLETA.'
                );
        }

        if (
            $this->boletas->find(
                $this->request->getUri()->getSegment(2)
            )['boleta_firmada'] == 0
        ) {
            return redirect()
                ->back()->with('error', 'ESTA BOLETA YA ESTA FIRMADA.');
        }

        if (
            $this->boletas->find(
                $this->request->getUri()->getSegment(2)
            )['id_usuario'] != session()->get('user_id')
        ) {
            return redirect()
                ->back()->with(
                    'error',
                    'NO PUEDE FIRMAR
                BOLETAS AJENAS.'
                );
        }

        $existingPdfPath = FCPATH . 'assets/uploads/boletas/' . $this->boletas->find(
            $this->request->getUri()->getSegment(2)
        )['adjunto'];

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

        $firmaPath = FCPATH . 'assets/uploads/firmas/' . $this->usuarios->find(
            session()->get('user_id')
        )['firma'];

        if (is_file($firmaPath) && is_readable($firmaPath)) {
            // Get signature dimensions
            list($sigWidth, $sigHeight) = getimagesize($firmaPath);

            // Calculate scaling factor to fit within 20x10
            $scale = min(40 / $sigWidth, 20 / $sigHeight);
            $newWidth = $sigWidth * $scale;
            $newHeight = $sigHeight * $scale;

            $x = 147;  // Adjust this value to move left or right

            // First signature vertical position (adjust as needed)
            $y1 = 118;  // Adjust this value to move up or down

            // Second signature vertical position (adjust as needed)
            $y2 = 269; // Adjust this value to move up or down

            // Add the first signature image
            $pdf->Image($firmaPath, $x, $y1, $newWidth, $newHeight, 'PNG');

            // Add the second signature image
            $pdf->Image($firmaPath, $x, $y2, $newWidth, $newHeight, 'PNG');

            // Updating firma boleta_firmada
            $this->boletas->set('boleta_firmada', 0)
                ->where(
                    'id',
                    $this->request->getUri()->getSegment(2)
                )->update();
        } else {
            log_message(
                'error',
                'Signature file not found or not readable: ' . $firmaPath
            );
        }

        // Save the modified PDF
        $pdf->Output($existingPdfPath, 'F');

        return redirect()->back()->with('message', 'Se firma la boleta con éxito.');
    }
    public function firmarBoletaCTS()
    {
        if (!$this->usuarios->find(session()->get('user_id'))['firma']) {
            return redirect()
                ->back()->with(
                    'error',
                    'DEBE SUBIR SU FIRMA PRIMERO
                ANTES DE FIRMAR SU BOLETA.'
                );
        }

        if (
            $this->cts->find(
                $this->request->getUri()->getSegment(2)
            )['boleta_firmada'] == 0
        ) {
            return redirect()
                ->back()->with('error', 'ESTA BOLETA DE CTS YA ESTA FIRMADA.');
        }

        if (
            $this->cts->find(
                $this->request->getUri()->getSegment(2)
            )['id_usuario'] != session()->get('user_id')
        ) {
            return redirect()
                ->back()->with(
                    'error',
                    'NO PUEDE FIRMAR
                BOLETAS AJENAS.'
                );
        }

        $existingPdfPath = FCPATH . 'assets/uploads/cts/' . $this->cts->find(
            $this->request->getUri()->getSegment(2)
        )['adjunto'];

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

        $firmaPath = FCPATH . 'assets/uploads/firmas/' . $this->usuarios->find(
            session()->get('user_id')
        )['firma'];

        if (is_file($firmaPath) && is_readable($firmaPath)) {
            // Get signature dimensions
            list($sigWidth, $sigHeight) = getimagesize($firmaPath);

            // Calculate scaling factor to fit within 20x10
            $scale = min(40 / $sigWidth, 20 / $sigHeight);
            $newWidth = $sigWidth * $scale;
            $newHeight = $sigHeight * $scale;

            $x = 142;  // Adjust this value to move left or right

            // Second signature vertical position (adjust as needed)
            $y2 = 218; // Adjust this value to move up or down

            // Add the second signature image
            $pdf->Image($firmaPath, $x, $y2, $newWidth, $newHeight, 'PNG');

            // Updating firma boleta_firmada
            $this->cts->set('boleta_firmada', 0)
                ->where(
                    'id',
                    $this->request->getUri()->getSegment(2)
                )->update();
        } else {
            log_message(
                'error',
                'Signature file not found or not readable: ' . $firmaPath
            );
        }

        // Save the modified PDF
        $pdf->Output($existingPdfPath, 'F');

        return redirect()->back()->with('message', 'Se firma la boleta con éxito.');
    }
}

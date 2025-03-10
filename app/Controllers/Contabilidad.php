<?php

namespace App\Controllers;
use setasign\Fpdi\Tcpdf\Fpdi;

class Contabilidad extends BaseController
{
    public function contabilidad_boletas()
    {
        // Get the signature user ID from configuration
        $configModel = model('ConfiguracionModel');
        $config = $configModel->first();
        $firmaUserId = $config['id_usuario_doc_firma'] ?? 5; // Fallback to 5 if not found

        $this->gc->setTable('boletas')
            ->setSubject('BOLETA', 'HISTORICO BOLETAS')
            ->defaultOrdering('boletas.fecha_creacion', 'desc')
            ->unsetEdit()
            ->unsetPrint()
            ->unsetExportPdf()
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
            ->columns(['id_usuario', 'adjunto', 'fecha_creacion', 'boleta_firmada', 'visto'])
            ->readFields(['id_usuario', 'adjunto', 'fecha_creacion', 'fecha_modificacion', 'subido_por', 'revisado_por', 'boleta_firmada', 'visto'])
            ->fieldType('boleta_firmada', 'dropdown_search', [
                1 => 'NO',
                0 => 'SI'
            ])
            ->fieldType('visto', 'dropdown_search', [
                0 => 'NO',
                1 => 'SI'
            ]);
        // Check if current operation is export  
        if ($this->gc->getState() === 'Export') {
            $this->gc->callbackColumn('boleta_firmada', function ($value, $row) {
                return ($value == '0') ? 'SI' : 'NO';
            });
            $this->gc->callbackColumn('visto', function ($value, $row) {
                return ($value == '0') ? 'NO' : 'SI';
            });
        }
        $this->gc->callbackBeforeInsert(function ($stateParameters) use ($firmaUserId) {
            $filename = $stateParameters->data['adjunto'];
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            if (strtolower($fileExtension) !== 'pdf') {
                $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
                return $errorMessage->setMessage("Solo puede subir PDFs!\n");
            }
            $stateParameters->data['subido_por'] = session()->get('user_id');
            $stateParameters->data['id_estado_boleta'] = 2;
            $stateParameters->data['revisado_por'] = $firmaUserId;
            $stateParameters->data['boleta_firmada'] = 1; // Not signed yet
            $stateParameters->data['visto'] = 0; // Not viewed yet
            return $stateParameters;
        })
            ->callbackAfterInsert(function ($stateParameters) use ($firmaUserId) {
                $existingPdfPath = FCPATH . 'assets/uploads/boletas/' . $this->boletas->find($stateParameters->insertId)['adjunto'];

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

                $firmaPath = FCPATH . 'assets/uploads/firmas/' . $this->usuarios->find($firmaUserId)['firma'];

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
                'observaciones' => 'OBSERVACIONES',
                'boleta_firmada' => 'FIRMADA',
                'visto' => 'VISTO'
            ]);

        // Rendering the CRUD
        $output = $this->gc->render();
        return $this->mainOutput($output);
    }

    public function contabilidad_boletas_cts()
    {
        // Get the signature user ID from configuration
        $configModel = model('ConfiguracionModel');
        $config = $configModel->first();
        $firmaUserId = $config['id_usuario_doc_firma'] ?? 5; // Fallback to 5 if not found

        $this->gc->setTable('boletas_cts')
            ->setSubject('CTS', 'HISTORICO CTS')
            ->defaultOrdering('boletas_cts.fecha_creacion', 'desc')
            ->unsetEdit()
            ->unsetExportPdf()  // Changed from unsetExport() to unsetExportPdf()
            ->unsetPrint()
            ->unsetFilters()
            ->setRead()
            ->setRelation('id_estado_boleta', 'estado_boletas', 'estado_boleta')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('subido_por', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->setFieldUpload('adjunto', 'assets/uploads/cts/', base_url() . 'assets/uploads/cts/', [
                'maxUploadSize' => '20M', // 20 Mega Bytes
                'minUploadSize' => '1K' // 1 Kilo Byte
            ])
            ->requiredFields(['id_usuario', 'adjunto'])
            ->addFields(['id_usuario', 'adjunto'])
            ->unsetColumns(['subido_por', 'fecha_modificacion', 'observaciones'])
            ->unsetSearchColumns(['adjunto'])
            ->columns(['id_usuario', 'adjunto', 'fecha_creacion', 'boleta_firmada', 'visto'])
            ->readFields(['id_usuario', 'adjunto', 'id_estado_boleta', 'fecha_creacion', 'fecha_modificacion', 'subido_por', 'revisado_por', 'observaciones', 'boleta_firmada', 'visto'])
            ->fieldType('boleta_firmada', 'dropdown_search', [
                1 => 'NO',
                0 => 'SI'
            ])
            ->fieldType('visto', 'dropdown_search', [
                0 => 'NO',
                1 => 'SI'
            ]);
        // Check if current operation is export  
        if ($this->gc->getState() === 'Export') {
            $this->gc->callbackColumn('boleta_firmada', function ($value, $row) {
                return ($value == '0') ? 'SI' : 'NO';
            });
            $this->gc->callbackColumn('visto', function ($value, $row) {
                return ($value == '0') ? 'NO' : 'SI';
            });
        }
        $this->gc->callbackBeforeInsert(function ($stateParameters) use ($firmaUserId) {
            $filename = $stateParameters->data['adjunto'];
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            if (strtolower($fileExtension) !== 'pdf') {
                $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
                return $errorMessage->setMessage("Solo puede subir PDFs!\n");
            }
            $stateParameters->data['subido_por'] = session()->get('user_id');
            $stateParameters->data['id_estado_boleta'] = 2;
            $stateParameters->data['revisado_por'] = $firmaUserId;
            $stateParameters->data['boleta_firmada'] = 1; // Not signed yet
            $stateParameters->data['visto'] = 0; // Not viewed yet
            return $stateParameters;
        })
        ->callbackAfterInsert(function ($stateParameters) use ($firmaUserId) {
            $existingPdfPath = FCPATH . 'assets/uploads/cts/' . $this->cts->find($stateParameters->insertId)['adjunto'];

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

            $firmaPath = FCPATH . 'assets/uploads/firmas/' . $this->usuarios->find($firmaUserId)['firma'];

            if (is_file($firmaPath) && is_readable($firmaPath)) {
                // Get signature dimensions
                list($sigWidth, $sigHeight) = getimagesize($firmaPath);

                // Calculate scaling factor to fit within 20x10
                $scale = min(70 / $sigWidth, 30 / $sigHeight);
                $newWidth = $sigWidth * $scale;
                $newHeight = $sigHeight * $scale;

                $x = 40;  // Adjust this value to move left or right

                // Second signature position (adjust as needed)
                $y = 218; // Adjust this value to move up or down

                // Add the second signature image
                $pdf->Image($firmaPath, $x, $y, $newWidth, $newHeight, 'PNG');
            } else {
                log_message('error', 'Signature file not found or not readable: ' . $firmaPath);
            }

            // Save the modified PDF
            $pdf->Output($existingPdfPath, 'F');
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
            'observaciones' => 'OBSERVACIONES',
            'boleta_firmada' => 'FIRMADA',
            'visto' => 'VISTO'
        ]);

        // Rendering the CRUD
        $output = $this->gc->render();
        return $this->mainOutput($output);
    }
}

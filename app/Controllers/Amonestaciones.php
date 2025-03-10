<?php

namespace App\Controllers;

use setasign\Fpdi\Tcpdf\Fpdi;

class Amonestaciones extends BaseController
{
    public function index()
    {
        $this->gc->setTable('amonestaciones')
            ->setSubject('AMONESTACION', 'AMONESTACIONES')
            ->unsetAddFields(['fecha_creacion', 'revisado_por'])
            ->unsetEditFields(['fecha_creacion', 'revisado_por', 'firmado', 'visto'])
            ->unsetPrint()
            ->unsetExportPdf()
            ->unsetFilters()
            ->setDeleteMultiple()
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->displayAs('id_usuario', 'USUARIO')
            ->displayAs('sustentacion', 'SUSTENTACIÓN')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('goce_haber', 'GOCE DE HABER')
            ->displayAs('firmado', 'FIRMADO')
            ->displayAs('visto', 'VISTO')
            ->fieldType('goce_haber', 'dropdown', [
                0 => 'NO',
                1 => 'SI'
            ])
            ->fieldType('firmado', 'dropdown', [
                0 => 'NO',
                1 => 'SI'
            ])
            ->fieldType('visto', 'dropdown', [
                0 => 'NO',
                1 => 'SI'
            ]);
            if ($this->gc->getState() === 'Export') {
                $this->gc->callbackColumn('firmado', function ($value, $row) {
                    return ($value == '0') ? 'NO' : 'SI';
                });
                $this->gc->callbackColumn('visto', function ($value, $row) {
                    return ($value == '0') ? 'NO' : 'SI';
                });
                $this->gc->callbackColumn('goce_haber', function ($value, $row) {
                    return ($value == '0') ? 'NO' : 'SI';
                });
            }
            $this->gc->setRead()
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date')
            ->fieldType('fecha_retorno', 'native_date')
            ->requiredFields(
                ['id_usuario', 'sustentacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno', 'goce_haber']
            )
            ->requiredEditFields(['id_usuario', 'sustentacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno'])
            ->callbackReadField(
                'revisado_por',
                function ($fieldValue, $primaryKeyValue) {
                    return $this->usuarios->find($fieldValue)['nombres'];
                }
            )
            ->callbackBeforeInsert(
                function ($stateParameters) {
                    $fecha_inicio = $stateParameters->data['fecha_inicio'];
                    $fecha_fin = $stateParameters->data['fecha_fin'];
                    $fecha_retorno = $stateParameters->data['fecha_retorno'];

                    $stateParameters->data['revisado_por'] = session()->get('user_id');

                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();

                    if ($fecha_fin < $fecha_inicio) {
                        return $errorMessage->setMessage(
                            "La fecha fin no debe ser menor
                            a la fecha de inicio.\n"
                        );
                    }

                    if ($fecha_retorno < $fecha_fin) {
                        return $errorMessage->setMessage(
                            "La fecha de retorno no debe ser menor
                            a la fecha fin.\n"
                        );
                    }

                    return $stateParameters;
                }
            )
            ->callbackBeforeUpdate(
                function ($stateParameters) {
                    $fecha_inicio = $stateParameters->data['fecha_inicio'];
                    $fecha_fin = $stateParameters->data['fecha_fin'];
                    $fecha_retorno = $stateParameters->data['fecha_retorno'];

                    $stateParameters->data['revisado_por'] = session()->get('user_id');

                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();

                    if ($fecha_fin < $fecha_inicio) {
                        return $errorMessage->setMessage(
                            "La fecha fin no debe ser menor
                            a la fecha de inicio.\n"
                        );
                    }

                    if ($fecha_retorno < $fecha_fin) {
                        return $errorMessage->setMessage(
                            "La fecha de retorno no debe ser menor
                            a la fecha fin.\n"
                        );
                    }

                    return $stateParameters;
                }
            )
            ->columns(['id_usuario', 'fecha_inicio', 'fecha_fin', 'fecha_retorno', 'goce_haber', 'fecha_creacion', 'firmado', 'visto'])
            ->addFields(['id_usuario', 'sustentacion', 'fecha_inicio', 'fecha_fin', 'goce_haber', 'fecha_retorno']);
        $output = $this->gc->render();
        return $this->mainOutput($output);
    }
    public function mis_amonestaciones()
    {
        $this->gc->setTable('amonestaciones')
            ->setSubject('AMONESTACION', 'AMONESTACIONES DE ' . session()->get('nombres'))
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->unsetAddFields(['fecha_creacion', 'revisado_por'])
            ->unsetEditFields(['fecha_creacion', 'revisado_por'])
            ->displayAs('id_usuario', 'USUARIO')
            ->displayAs('sustentacion', 'SUSTENTACIÓN')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('goce_haber', 'GOCE DE HABER')
            ->fieldType('goce_haber', 'boolean')
            ->callbackReadField(
                'revisado_por',
                function ($fieldValue, $primaryKeyValue) {
                    return $this->usuarios->find($fieldValue)['nombres'];
                }
            )
            ->unsetExport()
            ->unsetPrint()
            ->unsetFilters()
            ->unsetEdit()
            ->unsetAdd()
            ->unsetDelete()
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date')
            ->fieldType('fecha_retorno', 'native_date')
            ->columns(['fecha_inicio', 'fecha_fin', 'fecha_retorno', 'fecha_creacion'])
            ->setActionButton('VER', 'as fa-file-pdf', function ($row) {
                return base_url("generate_amonestacion_pdf/{$row->id}") . "?view=inline";
            }, true)
            ->where(
                [
                    'id_usuario' => session()->get('user_id')
                ]
            );
        $output = $this->gc->render();
        return $this->mainOutput($output);
    }

    /**
     * Format date to Spanish readable format
     * 
     * @param string $dateStr Date string in Y-m-d format
     * @return string Formatted date in Spanish
     */
    private function formatSpanishDate($dateStr) 
    {
        $days = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        
        $months = [
            'January' => 'enero',
            'February' => 'febrero',
            'March' => 'marzo',
            'April' => 'abril',
            'May' => 'mayo',
            'June' => 'junio',
            'July' => 'julio',
            'August' => 'agosto',
            'September' => 'septiembre',
            'October' => 'octubre',
            'November' => 'noviembre',
            'December' => 'diciembre'
        ];
        
        $date = new \DateTime($dateStr);
        $dayName = $days[$date->format('l')];
        $day = $date->format('j');
        $month = $months[$date->format('F')];
        $year = $date->format('Y');
        
        return "$dayName $day de $month $year";
    }

    public function generatePdf($id)
    {
        // Debug the ID to make sure it's being passed correctly
        error_log("generatePdf method called with ID: " . $id);
        
        try {
            // Direct database query to get the amonestacion
            $db = \Config\Database::connect();
            $amonestacionQuery = $db->query("SELECT * FROM amonestaciones WHERE id = ?", [$id]);
            $amonestacion = $amonestacionQuery->getRow();
            
            if (!$amonestacion) {
                error_log("Amonestacion not found for ID: " . $id);
                return redirect()->to(base_url('mis_amonestaciones'));
            }
            
            // If the current user is viewing their own amonestacion, update visto to 1 if not already marked
            if ($amonestacion->id_usuario == session()->get('user_id') && $amonestacion->visto != 1) {
                $db->query("UPDATE amonestaciones SET visto = 1 WHERE id = ?", [$id]);
                error_log("Updated visto status to 1 for amonestacion ID: " . $id);
            }
            
            $usuarioQuery = $db->query("SELECT * FROM usuarios WHERE id = ?", [$amonestacion->id_usuario]);
            $usuario = $usuarioQuery->getRow();
            
            if (!$usuario) {
                error_log("Usuario not found for ID: " . $amonestacion->id_usuario);
                return redirect()->to(base_url('mis_amonestaciones'));
            }
            
            // Get the count/order number of this amonestacion for this user
            $countQuery = $db->query(
                "SELECT COUNT(*) as position FROM amonestaciones 
                 WHERE id_usuario = ? AND fecha_creacion <= ? 
                 ORDER BY fecha_creacion ASC",
                [$amonestacion->id_usuario, $amonestacion->fecha_creacion]
            );
            
            $position = $countQuery->getRow()->position;
            
            // Debug the objects
            error_log("Amonestacion: " . json_encode($amonestacion));
            error_log("Usuario: " . json_encode($usuario));
            error_log("Position: " . $position);
            
            // Create PDF
            $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Médica Ocular');
            $pdf->SetTitle('AMONESTACIÓN N° ' . $position);
            $pdf->SetSubject('AMONESTACIÓN N° ' . $position);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(20, 20, 20);
            $pdf->SetAutoPageBreak(true, 20);
            
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 12);
            
            // Add creation date at the top right
            $fechaCreacion = new \DateTime($amonestacion->fecha_creacion);
            $fechaCreacionFormatted = $fechaCreacion->format('d/m/Y H:i:s');
            
            // Save current position
            $currentX = $pdf->GetX();
            $currentY = $pdf->GetY();
            
            // Set position for the date (top right)
            $pdf->SetXY(120, 10);
            $pdf->SetFont('helvetica', 'I', 10);
            $pdf->Cell(70, 10, 'Fecha: ' . $fechaCreacionFormatted, 0, 0, 'R');
            
            // Add amonestacion number at the top left
            $pdf->SetXY(20, 10);
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(70, 10, 'AMONESTACIÓN N° ' . $position, 0, 0, 'L');
            
            // Restore position for the rest of the content
            $pdf->SetXY($currentX, $currentY);
            $pdf->SetFont('helvetica', '', 12);
            
            // Use the local logo image directly
            $logoPath = FCPATH . 'assets/Logotipo-Medica-Ocular.png';
            
            // Add the logo to the PDF (centered at the top)
            if (file_exists($logoPath)) {
                $pdf->Image($logoPath, 80, 20, 50); // Adjusted Y position to accommodate the date
                error_log("Successfully loaded logo from: " . $logoPath);
            } else {
                error_log("Logo file not found at: " . $logoPath);
            }
            
            $pdf->Ln(40); // Increased space from 30 to 40 to accommodate the date and logo
            
            $pdf->Cell(0, 10, 'Estimado(a) ' . $usuario->nombres . ',', 0, 1);
            $pdf->Ln(10);
            
            $pdf->MultiCell(0, 10, 'El presente documento es para informarle que usted a sido percibido o amonestado por la siguiente razón:', 0, 'L');
            $pdf->Ln(5);
            
            // Format dates in a user-friendly way
            $fechaInicioFormatted = $this->formatSpanishDate($amonestacion->fecha_inicio);
            $fechaFinFormatted = $this->formatSpanishDate($amonestacion->fecha_fin);
            $fechaRetornoFormatted = $this->formatSpanishDate($amonestacion->fecha_retorno);
            
            $pdf->MultiCell(0, 10, $amonestacion->sustentacion, 0, 'L');
            $pdf->Ln(5);
            
            // Use the formatted dates in the text
            $pdf->MultiCell(0, 10, 'Iniciando el ' . $fechaInicioFormatted . 
                ' con fecha de retorno el ' . $fechaRetornoFormatted . ', ' . 
                ($amonestacion->goce_haber ? 'con goce de haber' : 'sin goce de haber') . '.', 0, 'L');
            
            // Increase space before signatures from 20mm to 40mm
            $pdf->Ln(40);
            
            // Create signature lines first (above the text)
            $currentX = $pdf->GetX();
            $currentY = $pdf->GetY();
            
            // Draw signature lines (first line)
            $pdf->Cell(70, 0, '', 'T', 0, 'C'); // Line for GERENTE
            $pdf->Cell(30, 0, '', 0, 0, 'C'); // Space between lines
            $pdf->Cell(70, 0, '', 'T', 1, 'C'); // Line for TRABAJADOR
            
            // Reduce space between line and text from 10mm to 3mm
            $pdf->Ln(3);
            
            // Set font for signatures
            $pdf->SetFont('helvetica', 'B', 12);
            
            // Then add the signature texts below the lines - centered with their lines
            $pdf->Cell(70, 10, 'FIRMA GERENTE', 0, 0, 'C');
            $pdf->Cell(30, 10, '', 0, 0, 'C'); // Space between texts
            $pdf->Cell(70, 10, 'FIRMA TRABAJADOR', 0, 1, 'C');
            
            // Reset font
            $pdf->SetFont('helvetica', '', 12);
            
            // Set PDF output options
            $pdf->SetTitle('AMONESTACIÓN N° ' . $position);
            
            // Enable output buffering
            ob_clean();
            
            // Determine output mode based on the query parameter
            $outputMode = $this->request->getGet('view') === 'inline' ? 'I' : 'D';
            $filename = 'Amonestacion_N' . $position . '.pdf';
            
            // Output the PDF - I for inline viewing in the browser, D for download
            $pdf->Output($filename, $outputMode);
            exit; // Important: prevent any other output
        } catch (\Exception $e) {
            error_log("Error generating PDF: " . $e->getMessage());
            error_log("Error trace: " . $e->getTraceAsString());
            return redirect()->to(base_url('mis_amonestaciones'))->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }
}

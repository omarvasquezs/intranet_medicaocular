<?php

namespace App\Controllers;

class Informativo extends BaseController
{
    public function documentos()
    {
        $this->gc->setTable('documentos')
            ->setSubject('DOCUMENTO', 'DOCUMENTOS')
            ->displayAs(['titulo' => 'TITULO DEL DOCUMENTO'])
            // Upload documento
            ->setFieldUpload('adjunto', 'assets/uploads/documentos/', base_url() . 'assets/uploads/documentos/', $this->_uploadDocumentoValidations())
            ->unsetExport()
            ->unsetPrint()
            ->unsetColumns(['adjunto'])
            ->unsetFilters()
            ->callbackColumn('titulo', function ($value, $row) {
                return "<a href='" . site_url('assets/uploads/documentos/' . $this->documentos->getAdjunto($row->id)) . "' target='" . "_blank" . "'>$row->titulo</a>";
            })
            ->callbackBeforeUpload(function ($uploadData) {
                $fieldName = $uploadData->uploadFieldName;

                $filename = !empty($_FILES["data"]) ? $_FILES["data"]["name"][$fieldName][0] : '';

                if (!preg_match('/\.(doc|docx|ppt|pptx|xls|xlsx|pdf)$/', $filename)) {
                    return (new \GroceryCrud\Core\Error\ErrorMessage())
                        ->setMessage("La extension del archivo: '" . $filename . "'' no es soportada!");
                }

                // Don't forget to return the uploadData at the end
                return $uploadData;
            });

        if (!array_intersect(session()->get('roles'), [1, 2])) {
            $this->gc->unsetOperations()
                ->unsetSettings();
        }

        $output = $this->gc->render();

        return $this->_mainOutput($output);
    }
}

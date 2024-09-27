<?php

/**
 * Informativo Controller
 * php version 8.2
 * This controller handles the document management functionalities.
 *
 * @category Controllers
 * @package  App\Controllers
 * @author   Omar Vásquez <omarvs91@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://omarvasquezs.github.io
 */

namespace App\Controllers;

/**
 * Class Informativo
 *
 * @category Controllers
 * @package  App\Controllers
 * @author   Omar Vásquez <omarvs91@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://omarvasquezs.github.io
 */
class Informativo extends BaseController
{
    /**
     * Handles the document display and upload functionalities.
     *
     * @return mixed
     */
    public function documentos()
    {
        // Set the table to 'documentos' for CRUD operations
        $this->gc->setTable('documentos')
        // Set the subject for the CRUD interface
            ->setSubject('DOCUMENTO', 'DOCUMENTOS')
        // Display the 'titulo' field as 'TITULO DEL DOCUMENTO'
            ->displayAs(['titulo' => 'TITULO DEL DOCUMENTO'])
        // Configure file upload settings for the 'adjunto' field
            ->setFieldUpload(
                'adjunto', // Field name
                'assets/uploads/documentos/', // Private upload folder
                base_url() . 'assets/uploads/documentos/', // Public folder path
                $this->uploadDocumentoValidations() // Upload validations
            )
        // Disable export functionality
            ->unsetExport()
        // Disable print functionality
            ->unsetPrint()
        // Remove 'adjunto' from the displayed columns
            ->unsetColumns(['adjunto'])
        // Disable filters
            ->unsetFilters()
        // Customize the display of the 'titulo' column
            ->callbackColumn(
                'titulo',
                function ($value, $row) {
                    // Create a hyperlink for the document title
                    return "<a href='" . site_url(
                        'assets/uploads/documentos/'
                        . $this->documentos->getAdjunto($row->id)
                    ) . "' target='_blank'>$row->titulo</a>";
                }
            )
        // Validate file before upload
        ->callbackBeforeUpload(
            function ($uploadData) {
                $fieldName = $uploadData->uploadFieldName;

                // Get the filename from the uploaded data
                $filename = !empty($_FILES["data"])
                    ? $_FILES["data"]["name"][$fieldName][0]
                    : '';

                // Check if the file extension is allowed
                if (!preg_match(
                    '/\.(doc|docx|ppt|pptx|xls|xlsx|pdf)$/',
                    $filename
                )
                ) {
                    // Return an error message if the extension is not supported
                    return (new \GroceryCrud\Core\Error\ErrorMessage())
                        ->setMessage(
                            "La extension del archivo: '" .
                            $filename . "' no es soportada!"
                        );
                }

                // Return the upload data if validation passes
                return $uploadData;
            }
        );

        // Check user roles and disable operations if not authorized
        if (!array_intersect(session()->get('roles'), [1, 2])) {
            $this->gc->unsetOperations()
                ->unsetSettings();
        }

        // Render the output of the CRUD operations
        $output = $this->gc->render();

        // Return the main output
        return $this->mainOutput($output);
    }
}

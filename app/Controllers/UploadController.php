<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class UploadController extends ResourceController
{
    public function index()
    {
        $file = $this->request->getFile('upload');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Generate a new name to avoid conflicts
            $newName = $file->getRandomName();

            // Move the file to the public/assets/uploads/files directory
            if ($file->move(FCPATH . 'assets/uploads/files', $newName)) {
                // Return the URL of the uploaded file to CKEditor
                return $this->respond([
                    'uploaded' => true,
                    'url' => base_url('assets/uploads/files/' . $newName)
                ]);
            } else {
                log_message('error', 'File move failed.');
                return $this->fail('File move failed.', 500);
            }
        }

        // Handle errors if the file upload fails
        log_message('error', 'File upload failed: ' . $file->getErrorString());
        return $this->fail([
            'uploaded' => false,
            'error' => [
                'message' => 'File upload failed: ' . $file->getErrorString()
            ]
        ], 400);
    }
}

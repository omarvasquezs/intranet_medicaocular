<?php

/**
 * Home Controller
 * php version 8.2
 *
 * @category Controllers
 * @package  App\Controllers
 * @author   Omar Vásquez <omarvs91@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://omarvasquezs.github.io
 */

namespace App\Controllers;
/**
 * Class Home
 *
 * @category Controllers
 * @package  App\Controllers
 * @author   Omar Vásquez <omarvs91@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://omarvasquezs.github.io
 */
class Home extends BaseController
{
    /**
     * Handles the main page visuals.
     *
     * @return mixed
     */
    public function index()
    {
        // Prepare the data array for the view
        $data = [
            // Fetch the latest 5 publications
            'publicaciones' => $this->publicaciones
                // Select fields from publicaciones and usuarios
                ->select('publicaciones.*, usuarios.nombres')
                // Join with the usuarios table to get user names
                ->join('usuarios', 'publicaciones.id_usuario = usuarios.id')
                // Order the results by creation date in descending order
                ->orderBy('fecha_creacion', 'DESC')
                // Limit the results to the latest 5 entries
                ->findAll(5)
        ];

        // Prepare the output object for rendering
        $output = (object) [
            // Array to hold any CSS files needed for the view
            'css_files' => [],
            // Array to hold any JavaScript files needed for the view
            'js_files' => [],
            // Render the 'main' view with the prepared data
            'output' => view('main', $data)
        ];

        // Return the main output for rendering
        return $this->mainOutput($output);
    }
    /**
     * Handles the main page entries.
     *
     * @return mixed
     */
    public function editarPublicaciones()
    {
        // Set up the Grocery CRUD configuration for the 'publicaciones' table
        // Specify the table to be used
        $this->gc->setTable('publicaciones')
            // Set the subject for the CRUD interface
            ->setSubject('PUBLICACION', 'PUBLICACIONES')
            // Set default ordering by creation date in descending order
            ->defaultOrdering('publicaciones.fecha_creacion', 'desc')
            // Disable the export functionality
            ->unsetExport()
            // Disable the print functionality
            ->unsetPrint()
            // Disable filtering options
            ->unsetFilters()
            // Set a relation to the 'usuarios' table to display user names
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            // Specify that the 'publicacion' field is required
            ->requiredFields(['publicacion'])
            // Add 'publicacion' field to the form for creating new entries
            ->addFields(['publicacion'])
            // Specify 'publicacion' field for editing existing entries
            ->editFields(['publicacion'])
            // Set a text editor for 'publicacion' and 'full_text' fields
            ->setTexteditor(['publicacion', 'full_text'])
            // Define which columns to display in the table
            ->columns(['fecha_creacion', 'fecha_actualizacion', 'id_usuario'])
            // Set the 'id_usuario' field to
            // the current user's ID before inserting a new record
            ->callbackBeforeInsert(
                function ($stateParameters) {
                    $stateParameters->data['id_usuario'] = session()->get('user_id');
                    return $stateParameters; // Return modified state parameters
                }
            )
            // ckeditor 5
            ->callbackAddField('publicacion', function ($fieldType, $fieldName) {
                return '<textarea id="publicacion-editor" name="publicacion"></textarea>';
            })
            ->callbackEditField('publicacion', function ($fieldValue, $primaryKeyValue, $rowData) {
                return '<textarea id="publicacion-editor" name="publicacion">' . $fieldValue . '</textarea>';
            })
            // Display field names in a user-friendly format
            ->displayAs(
                [
                    // Display 'id_usuario' as 'AUTOR'
                    'id_usuario' => 'AUTOR',
                    // Display 'fecha_creacion' as 'CREACION'
                    'fecha_creacion' => 'CREACION',
                    // Display 'fecha_actualizacion' as 'ACTUALIZADO'
                    'fecha_actualizacion' => 'ACTUALIZADO',
                    // Display 'publicacion' as 'PUBLICACION'
                    'publicacion' => 'PUBLICACION'
                ]
            );

        // Render the output for the CRUD interface
        // Generate the output based on the configured settings
        $output = $this->gc->render();

        // Return the main output for the Grocery CRUD interface
        return $this->mainOutput($output);
    }
    /**
     * Handles the main perfil form page.
     *
     * @return mixed
     */
    public function perfil()
    {
        // Set up the Grocery CRUD configuration for the 'usuarios' table
        $this->gc->setTable('usuarios')
            // Set the subject for the CRUD interface using the current user's name
            ->setSubject(
                session()->get('usuario'),
                'PERFIL DE ' . session()->get('usuario')
            )
            // Define the where clause to filter the user by their ID
            ->where(
                [
                    'usuarios.id' => session()->get('user_id')
                ]
            )
            // Set user-friendly labels for the fields
            ->displayAs(
                [
                    // Display 'nombres' as 'NOMBRES'
                    'nombres' => 'NOMBRES',
                    // Display 'usuario' as 'USUARIO'
                    'usuario' => 'USUARIO',
                    // Display 'estado' as 'ESTADO'
                    'estado' => 'ESTADO',
                    // Display 'dni' as 'DNI'
                    'dni' => 'DNI',
                    // Display 'id_cargo' as 'CARGO'
                    'id_cargo' => 'CARGO',
                    // Display 'id_area' as 'ÁREA'
                    'id_area' => 'ÁREA',
                    // Display 'roles' as 'ROLES'
                    'roles' => 'ROLES',
                    // Display 'birthday' as 'FECHA DE NACIMIENTO'
                    'birthday' => 'FECHA DE NACIMIENTO',
                    // Display 'firma' as 'FIRMA DIGITAL'
                    'firma' => 'FIRMA DIGITAL',
                    // Display 'pass' as 'NUEVA CONTRASEÑA'
                    'pass' => 'NUEVA CONTRASEÑA'
                ]
            )
            // Specify which columns to display in the table
            ->columns(['nombres', 'usuario', 'dni', 'id_cargo', 'birthday'])
            // Set a relation to the 'cargos' table to display the cargo name
            ->setRelation('id_cargo', 'cargos', 'cargo')
            // Set the field type for 'birthday' to a native date picker
            ->fieldType('birthday', 'native_date')
            // Remove unnecessary fields from the form
            ->unsetFields(['fecha_creacion', 'fecha_actualizacion'])
            // Disable filtering options
            ->unsetFilters()
            // Disable export functionality
            ->unsetExport()
            // Disable print functionality
            ->unsetPrint()
            // Disable the option to add new entries
            ->unsetAdd()
            // Disable the option to delete entries
            ->unsetDelete()
            // Disable search functionality for specified columns
            ->unsetSearchColumns(
                ['nombres', 'usuario', 'dni', 'birthday', 'id_cargo']
            )
            // Customize the edit field for 'pass' to include a password input
            ->callbackEditField(
                'pass',
                function ($fieldValue, $primaryKeyValue, $rowData) {
                    return '<input class="form-control"
                name="pass" type="password" value=""  />
                        <p>Dejar en blanco si no desea cambiar la contraseña</p>';
                }
            )
            // Callback to handle password field before updating
            ->callbackBeforeUpdate(
                function ($stateParameters) {
                    // If the password field is empty, unset it from the data
                    if (empty($stateParameters->data['pass'])) {
                        unset($stateParameters->data['pass']);
                    }
                    return $stateParameters; // Return modified state parameters
                }
            )
            // Set validation rule for 'usuario' to disallow spaces
            ->setRule('usuario', 'noSpacesBetweenLetters')
            // Specify available fields on the edit form
            ->editFields(
                [
                    'nombres',
                    'usuario',
                    'dni',
                    'id_cargo',
                    'birthday',
                    'pass',
                    'firma'
                ]
            )
            // Configure file upload for the signature field
            ->setFieldUpload(
                'firma',
                'assets/uploads/firmas/', // Directory for uploads
                base_url() . 'assets/uploads/firmas/', // Public URL for uploads
                $this->uploadFirmaValidations() // Validation rules for uploads
            )
            // Set fields to be read-only on the edit form
            ->readOnlyEditFields(['nombres', 'usuario', 'dni', 'id_cargo']);

        // Render the output for the CRUD interface
        // Generate the output based on the configured settings
        $output = $this->gc->render();

        // Return the main output for the Grocery CRUD interface
        return $this->mainOutput($output);

    }
}

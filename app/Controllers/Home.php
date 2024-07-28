<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $output = (object) [
            'css_files' => [],
            'js_files' => [],
            'output' => view('main')
        ];
        return $this->_mainOutput($output);
    }
    public function perfil()
    {
        $this->gc->setTable('usuarios')
            // Subject
            ->setSubject(session()->get('usuario'), 'PERFIL DE ' . session()->get('usuario'))
            // Where clause
            ->where([
                'usuarios.id' => session()->get('user_id')
            ])
            // Labels
            ->displayAs([
                'nombres' => 'NOMBRES',
                'usuario' => 'USUARIO',
                'estado' => 'ESTADO',
                'dni' => 'DNI',
                'id_cargo' => 'CARGO',
                'id_area' => 'ÁREA',
                'roles' => 'ROLES',
                'birthday' => 'FECHA DE NACIMIENTO',
                'firma' => 'FIRMA DIGITAL',
                'pass' => 'NUEVA CONTRASEÑA'
            ])
            // Columns
            ->columns(['nombres', 'usuario', 'dni', 'id_cargo', 'birthday'])
            // Upload sign
            ->setFieldUpload('firma', 'assets/uploads/firmas/', base_url() . 'assets/uploads/firmas/', $this->_uploadFirmaValidations())
            // Relations
            ->setRelation('id_cargo', 'cargos', 'cargo')
            // Field type
            ->fieldType('birthday', 'native_date')
            // Unset things
            ->unsetFields(['fecha_creacion', 'fecha_actualizacion'])
            ->unsetFilters()
            ->unsetExport()
            ->unsetPrint()
            ->unsetAdd()
            ->unsetDelete()
            ->unsetSearchColumns(['nombres', 'usuario', 'dni', 'birthday', 'id_cargo'])
            ->callbackEditField('pass', function ($fieldValue, $primaryKeyValue, $rowData) {
                return '<input class="form-control" name="pass" type="password" value=""  /><p>Dejar en blanco si no desea cambiar la contraseña</p>';
            })
            ->callbackBeforeUpdate(function ($stateParameters) {
                if (empty($stateParameters->data['pass'])) {
                    unset($stateParameters->data['pass']);
                }
                return $stateParameters;
            })
            ->setRule('usuario', 'noSpacesBetweenLetters');

        // Edit fields based on the rol
        if (array_intersect(session()->get('roles'), [1])) {
            $this->gc->editFields(['nombres', 'usuario', 'dni', 'id_cargo', 'birthday', 'pass', 'firma']);
        } else {
            $this->gc->editFields(['nombres', 'usuario', 'dni', 'id_cargo', 'birthday', 'pass']);
        }

        $this->gc->readOnlyEditFields(['nombres', 'usuario', 'dni', 'id_cargo']);

        // Rendering the CRUD
        $output = $this->gc->render();
        return $this->_mainOutput($output);
    }
}
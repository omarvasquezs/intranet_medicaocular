<?php

namespace App\Controllers;

class Admin extends BaseController
{
    // USUARIOS
    public function users()
    {
        $usuarios = $this->usuarios;
        $this->gc->setTable('usuarios')
            // Subject
            ->setSubject('USUARIO')
            // Labels
            ->displayAs([
                'nombres' => 'NOMBRES',
                'usuario' => 'USUARIO',
                'estado' => 'ESTADO',
                'dni' => 'DNI',
                'id_cargo' => 'CARGO',
                'id_area' => 'ÁREA',
                'id_jefe' => 'JEFE DIRECTO',
                'roles' => 'ROLES',
                'birthday' => 'FECHA DE NACIMIENTO',
                'firma' => 'FIRMA DIGITAL'
            ])
            // Columns
            ->columns(['nombres', 'usuario', 'dni', 'estado'])
            // Relations
            ->setRelation('id_cargo', 'cargos', 'cargo')
            ->setRelation('id_area', 'areas', 'area')
            ->setRelationNtoN('roles', 'usuarios_roles', 'roles', 'id_usuario', 'id_rol', 'rol')
            // jefe inmediato field and its callbacks
            ->callbackAddField('id_jefe', function () {
                $options = $this->usuarios->getUsersWithRole('JEFATURA');
                $dropdown = form_dropdown('id_jefe', ['' => 'SELECCIONAR JEFE DIRECTO'] + $options, '', ['class' => 'form-control']);
                return $dropdown;
            })
            ->callbackEditField('id_jefe', function ($value, $primaryKey) {
                $options = $this->usuarios->getUsersWithRole('JEFATURA');
                $dropdown = form_dropdown('id_jefe', ['' => 'SELECCIONAR JEFE DIRECTO'] + $options, $value, ['class' => 'form-control']);
                return $dropdown;
            })
            ->callbackReadField('id_jefe', function ($fieldValue, $primaryKeyValue) use ($usuarios) {
                return $usuarios->find($fieldValue)['nombres'];
            })
            // Custom action buttons
            ->setActionButton('Reiniciar Clave', 'fa fa-key', function ($row) {
                return 'reset_pass/' . $row->id;
            })
            // Upload sign
            ->setFieldUpload('firma', 'assets/uploads/firmas/', base_url() . 'assets/uploads/firmas/', $this->_uploadFirmaValidations())
            // Field type
            ->fieldType('estado', 'boolean')
            ->fieldType('birthday', 'native_date')
            // Unique Fields
            ->uniqueFields(['usuario', 'dni'])
            // Unset things
            ->unsetFields(['fecha_creacion', 'fecha_actualizacion', 'pass'])
            ->unsetSettings()
            ->unsetFilters()
            ->unsetExport()
            ->unsetPrint()
            ->setRead()
            // Generate password after INSERT
            ->callbackAfterInsert(function ($stateParameters) use ($usuarios) {
                $usuarios->updatePassword($stateParameters->insertId);
                return $stateParameters;
            })
            ->setRule('usuario', 'noSpacesBetweenLetters');

        // Rendering the CRUD
        $output = $this->gc->render();
        return $this->_mainOutput($output);
    }
    // CARGOS
    public function cargos()
    {
        $this->gc->setTable('cargos')
            ->setSubject('CARGO')
            ->displayAs(['cargo' => 'CARGO'])
            ->unsetExport()
            ->unsetPrint();

        $output = $this->gc->render();

        return $this->_mainOutput($output);
    }
    // AREAS
    public function areas()
    {
        $this->gc->setTable('areas')
            ->setSubject('AREA')
            ->displayAs(['area' => 'AREA'])
            ->unsetExport()
            ->unsetPrint();

        $output = $this->gc->render();

        return $this->_mainOutput($output);
    }

    public function reset_pass($userId)
    {
        // Retrieve the usuario value based on userId
        $usuarioName = $this->usuarios->find($userId)['usuario'];

        $passwordUpdateSuccess = $this->usuarios->update($userId, (object) ['pass' => "12345678"]);

        if ($passwordUpdateSuccess) {
            // Password update was successful
            return redirect()->to('/users')->with('message', 'Se restableció la clave a 12345678 para el/la usuario: ' . $usuarioName);
        } else {
            // Password update failed
            return redirect()->back()->with('error', 'No se puedo restablecer clave para el/la usuario: ' . $usuarioName);
        }
    }
}

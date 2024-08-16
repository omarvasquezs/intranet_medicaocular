<?php

namespace App\Controllers;

class Admin extends BaseController
{
    // USUARIOS
    public function users()
    {
        $this->gc->setTable('usuarios')
            // Subject
            ->setSubject('USUARIO', 'USUARIOS')
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
                'categoria' => 'CATEGORÍA'
            ])
            // Columns
            ->columns(['nombres', 'usuario', 'dni', 'categoria', 'estado'])
            // Relations
            ->setRelation('id_cargo', 'cargos', 'cargo')
            ->setRelation('id_area', 'areas', 'area')
            ->setRelationNtoN('roles', 'usuarios_roles', 'roles', 'id_usuario', 'id_rol', 'rol')
            // Custom action buttons
            ->setActionButton('Reiniciar Clave', 'fa fa-key', function ($row) {
                return 'reset_pass/' . $row->id;
            })
            // Upload sign
            ->setFieldUpload('firma', 'assets/uploads/firmas/', base_url() . 'assets/uploads/firmas/', $this->_uploadFirmaValidations())
            // Field type
            ->callbackColumn('estado', function ($value, $row) {
                switch ($value) {
                    case 0:
                        return "DESHABILITADO";
                    case 1:
                        return "HABILITADO";
                    default:
                        return "NO DATA"; // You can customize this fallback value
                }
            })
            ->fieldType('birthday', 'native_date')
            // Unique Fields
            ->uniqueFields(['usuario', 'dni'])
            // Unset things
            ->unsetFields(['fecha_creacion', 'fecha_actualizacion', 'pass', 'password_reset_required'])
            ->unsetFilters()
            ->unsetExport()
            ->unsetPrint()
            ->setRead()
            ->fieldType('categoria', 'dropdown', [
                'I' => 'INTERNO',
                'E' => 'EXTERNO'
            ])
            ->fieldType('dni', 'int')
            ->addFields(['nombres','usuario','categoria','dni','birthday','id_cargo','id_area','roles'])
            ->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['nombres'] = strtoupper($stateParameters->data['nombres']);
                $stateParameters->data['usuario'] = strtoupper($stateParameters->data['usuario']);
                $stateParameters->data['pass'] = '12345678';
                $stateParameters->data['estado'] = 1;
                return $stateParameters;
            })
            ->callbackBeforeUpdate(function ($stateParameters) {
                $stateParameters->data['nombres'] = strtoupper($stateParameters->data['nombres']);
                $stateParameters->data['usuario'] = strtoupper($stateParameters->data['usuario']);
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
            ->setSubject('CARGO', 'CARGOS')
            ->displayAs([
                'cargo' => 'CARGO',
            ])
            ->unsetExport()
            ->unsetPrint();

        $output = $this->gc->render();

        return $this->_mainOutput($output);
    }
    // AREAS
    public function areas()
    {
        $usuarios = $this->usuarios;
        $this->gc->setTable('areas')
            ->setSubject('AREA', 'ÁREAS')
            ->displayAs([
                'area' => 'AREA',
                'id_jefe' => 'JEFE INMEDIATO'
            ])
            ->setRelation('id_jefe', 'usuarios', 'nombres')
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
            ->unsetExport()
            ->unsetPrint();

        $output = $this->gc->render();

        return $this->_mainOutput($output);
    }

    public function reset_pass($userId)
    {
        // Retrieve the usuario value based on userId
        $usuarioName = $this->usuarios->find($userId)['usuario'];

        $passwordUpdateSuccess = $this->usuarios->update($userId, (object) [
            'pass' => "12345678",
            'password_reset_required' => 1
        ]);

        if ($passwordUpdateSuccess) {
            // Password update was successful
            return redirect()->to('/users')->with('message', 'Se restableció la clave a 12345678 para el/la usuario: ' . $usuarioName);
        } else {
            // Password update failed
            return redirect()->back()->with('error', 'No se puedo restablecer clave para el/la usuario: ' . $usuarioName);
        }
    }
}

<?php

namespace App\Models;

use GroceryCrud\Core\Model;

class PermisosGerenciaCustom extends Model
{
    public function extraWhereStatements($select)
    {
        // Join the 'usuarios' table with 'areas' on 'id_area' to access 'id_jefe'
        $select->join('usuarios', 'usuarios.id = registro_permisos.id_usuario')
            ->join('areas', 'areas.id = usuarios.id_area')
            ->where("areas.id_jefe = '" . session()->get('user_id') . "'");

        return $select;
    }
}

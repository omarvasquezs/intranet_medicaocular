<?php

namespace App\Models;

use GroceryCrud\Core\Model;
use GroceryCrud\Core\Model\ModelFieldType;

class CustomRegistroPermisosModel extends Model
{
    public function getList()
    {
        $userId = session()->get('user_id');

        // Assuming you're using CI4's Query Builder, start building your query
        $this->db->table($this->table_name)
            ->select('registro_permisos.*') // Adjust based on what you want to select
            ->join('usuarios', 'registro_permisos.usuario_id = usuarios.id', 'left') // Adjust the join condition based on your schema
            ->where('registro_permisos.id_estado_permiso', 1)
            ->where('usuarios.id_jefe', $userId);

        // Execute the query
        $query = $this->db->get();
        $result = $query->getResult();

        // Format the result as expected by Grocery CRUD
        $finalResult = [];
        foreach ($result as $row) {
            $finalResult[] = (array)$row;
        }

        return $finalResult;
    }
}

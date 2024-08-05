<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuarios extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','nombres','usuario','pass','dni','id_cargo','id_area','estado','firma','fecha_creacion','password_reset_required'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_creacion';
    protected $updatedField  = 'fecha_actualizacion';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    public function getUsersWithRole($roleName) {
        $builder = $this->db->table('usuarios');
        $builder->select('usuarios.id, usuarios.nombres');
        $builder->join('usuarios_roles', 'usuarios.id = usuarios_roles.id_usuario', 'inner');
        $builder->join('roles', 'usuarios_roles.id_rol = roles.id', 'inner');
        $builder->where('roles.rol', $roleName);
        $query = $builder->get();
        $result = $query->getResultArray();

        $options = [];
        foreach ($result as $row) {
            $options[$row['id']] = $row['nombres'];
        }
        return $options;
    }
}

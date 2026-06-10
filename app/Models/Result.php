<?php

namespace App\Models;

use CodeIgniter\Model;

class Result extends Model
{
    // Opravený název tabulky podle tvé DB
    protected $table            = 'koloslaf_result';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    
    // Soft Deletes vypnuté, dokud nepřidáš sloupec deleted_at do DB
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Povolené sloupce pro zápis/úpravu
    protected $allowedFields    = ['id_rider', 'time', 'rank'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates - vypnuté, aby to nehledalo chybějící sloupce created_at/updated_at
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
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
}
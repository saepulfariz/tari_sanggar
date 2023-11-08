<?php


require('application/models/BaseModel.php');

class SanggarModel extends BaseModel
{
    public $table            = 'tb_sanggar';
    public $primaryKey       = 'id';
    public $useAutoIncrement = true;
    public $insertID         = 0;
    public $useSoftDeletes   = false;
    public $returnType       = 'array';

    public $useTimestamps = false;
    public $dateFormat    = 'datetime';
    public $createdField  = 'created_at';
    public $updatedField  = 'updated_at';
    public $deletedField  = 'deleted_at';

    public $logName = false;
    public $logId = false;

    public function __construct()
    {
        parent::__construct();
    }
}

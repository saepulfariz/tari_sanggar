<?php


require_once('application/models/BaseModel.php');

class UserModel extends BaseModel
{
    public $table            = 'tb_user';
    public $primaryKey       = 'id';
    public $useAutoIncrement = true;
    public $insertID         = 0;
    public $useSoftDeletes   = true;
    public $returnType       = 'array';

    public $useTimestamps = true;
    public $dateFormat    = 'datetime';
    public $createdField  = 'created_at';
    public $updatedField  = 'updated_at';
    public $deletedField  = 'deleted_at';

    public $logName = true;
    public $logId = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserLogin($username)
    {
        $this->db->select('tb_user.*, nama_role');
        $this->db->where('username ', $username);
        $this->db->or_where('email', $username);
        $this->db->join('tb_role', 'tb_user.id_role = tb_role.id');
        return $this->db->get('tb_user');
    }


    public function getRole()
    {
        return $this->db->get('tb_role')->result_array();
    }

    public function getUser($id_role = null)
    {
        $this->db->select('tb_user.*, nama_role');
        $this->db->join('tb_role', 'tb_user.id_role = tb_role.id');
        if ($id_role != null) {
            $this->db->where('id_role', $id_role);
        }
        return $this->db->get('tb_user')->result_array();
    }
}

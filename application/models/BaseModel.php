<?php



class BaseModel extends CI_Model
{
    public $table;
    public $primaryKey = 'id';
    public $useAutoIncrement = true;
    public $insertID;
    public $useSoftDeletes   = false;
    public $returnType       = 'array';

    public $useTimestamps = false;
    public $dateFormat    = 'datetime';
    public $createdField  = 'created_at';
    public $updatedField  = 'updated_at';
    public $deletedField  = 'deleted_at';

    private $withDeleted = false;
    private $onlyDeleted = false;

    public $logName = false;
    public $logId = false;

    public $createdNameField  = 'cname';
    public $updatedNameField  = 'uname';
    public $deletedNameField  = 'dname';


    public $createdIdField  = 'cid';
    public $updatedIdField  = 'uid';
    public $deletedIdField  = 'did';

    public $logged = false;
    public $nameLogged = false;


    public function __construct()
    {
        parent::__construct();
        // $this->load->database();
        if ($this->logId == true || $this->logName == true) {
            // helper('basic');
            // $this->logged = logged('id');
            $res_profile = getProfile();
            if ($res_profile) {
                $this->logged = $res_profile['id'];
                $this->nameLogged = $res_profile['username'];
            }
        }
    }

    public function select($select)
    {
        $this->db->select($select);

        return $this;
    }


    public function join($table, $on_key)
    {
        $this->db->join($table, $on_key);

        return $this;
    }

    public function where($key, $value)
    {
        $this->db->where($key, $value);

        return $this;
    }

    public function find($id)
    {
        $this->db->where($this->table . '.' . $this->primaryKey, $id);

        $this->checkDeleted();

        if ($this->returnType == 'array') {
            $data = $this->db->get($this->table)->row_array();
        } else {
            $data = $this->db->get($this->table)->row();
        }
        return $data;
    }

    public function findAll()
    {
        $this->checkDeleted();

        if ($this->returnType == 'array') {
            $data = $this->db->get($this->table)->result_array();
        } else {
            $data = $this->db->get($this->table)->result();
        }
        return $data;
    }

    public function first()
    {
        $this->db->limit(1);
        $this->checkDeleted();

        if ($this->returnType == 'array') {
            $data = $this->db->get($this->table)->row_array();
        } else {
            $data = $this->db->get($this->table)->row();
        }
        return $data;
    }

    public function orderBy($column, $sort = 'ASC')
    {
        $this->db->order_by($column, $sort);
        return $this;
    }

    public function groupBy($column)
    {
        $this->db->group_by($column);
        return $this;
    }

    public function save($data)
    {
        if ($this->useTimestamps == true) {
            $data[$this->createdField] = date('Y-m-d H:i:s');
            $data[$this->updatedField] = date('Y-m-d H:i:s');
        }

        if ($this->logId == true) {
            $data[$this->createdIdField] = $this->logged;
        }
        if ($this->logName == true) {
            if ($this->logged) {
                $data[$this->createdNameField] = $this->nameLogged;
            }
        }
        return $this->db->insert($this->table, $data);
    }

    public function update($id = false, $data = [])
    {
        if ($id != false) {
            $this->db->where($this->primaryKey, $id);
        }
        if ($this->useTimestamps == true) {
            $data[$this->updatedField] = date('Y-m-d H:i:s');
        }

        if ($this->logId == true) {
            $data[$this->updatedIdField] = $this->logged;
        }
        if ($this->logName == true) {
            if ($this->logged) {
                $data[$this->updatedNameField] = $this->nameLogged;
            }
        }

        return $this->db->update($this->table, $data);
    }


    public function delete($id = false)
    {
        if ($id != false) {
            $this->db->where($this->primaryKey, $id);
        }
        if ($this->useSoftDeletes == true) {
            $data[$this->deletedField] = date('Y-m-d H:i:s');

            if ($this->logId == true) {
                $data[$this->deletedIdField] = $this->logged;
            }
            if ($this->logName == true) {
                if ($this->logged) {
                    $data[$this->deletedNameField] = $this->nameLogged;
                }
            }

            return $this->update($id, $data);
        } else {
            return $this->db->delete($this->table);
        }
    }

    public function withDeleted()
    {
        $this->withDeleted = true;
        return $this;
    }

    public function onlyDeleted()
    {
        $this->onlyDeleted = true;
        return $this;
    }

    public function checkDeleted()
    {
        if ($this->onlyDeleted == true) {
            $this->db->where("$this->deletedField IS NOT NULL");
        } else {
            if ($this->withDeleted == false) {
                if ($this->useSoftDeletes == true) {
                    $this->db->where("$this->deletedField IS NULL");
                }
            }
        }
    }


    public function lastId()
    {
        $this->db->limit(1);
        $this->db->order_by($this->primaryKey, 'DESC');

        if ($this->returnType == 'array') {
            $data = $this->db->get($this->table)->row_array();
        } else {
            $data = $this->db->get($this->table)->row();
        }
        return $data[$this->primaryKey];
    }
}

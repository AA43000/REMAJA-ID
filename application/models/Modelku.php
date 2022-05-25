<?php 
class Modelku extends CI_Model
{
    function select($select = NULL,$table = NULL,$limit = NULL,$like = NULL,$order = NULL,$join = NULL,$where = NULL,$where2 = NULL,$group_by = NULL) {
        $this->db->select($select);
        $this->db->from($table);
        if ($join) {
            for ($i=0; $i<sizeof($join['data']) ; $i++) { 
                $this->db->join($join['data'][$i]['table'],$join['data'][$i]['join'],$join['data'][$i]['type']);
            }
        }
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $this->db->where($where['data'][$i]['column'],$where['data'][$i]['param']);
            }
        }
        if ($where2) {
            $this->db->where($where2);
        }
        if ($like) {
            for ($i=0; $i<sizeof($like['data']) ; $i++) { 
                $this->db->like('CONCAT_WS(" ", '.$like['data'][$i]['column'].')',$like['data'][$i]['param']);
            }
        }
        if ($limit) {
            $this->db->limit($limit['finish'],$limit['start']);
        }
        if ($order) {
            for ($i=0; $i<sizeof($order['data']) ; $i++) { 
                $this->db->order_by($order['data'][$i]['column'], $order['data'][$i]['type']);
            }
        }
        if ($group_by) {
            $this->db->group_by($group_by);
        }
        
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function update($table, $data, $where) {
        $this->db->where($where);
        $update = $this->db->update($table, $data);
        return $update;
    }
}
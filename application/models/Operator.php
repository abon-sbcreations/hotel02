<?php
class Operator extends CI_Model{
    private $_website_operator = "website_operator";
    public function checkOperator($arr){
        $this->db->from($this->_website_operator." as wo");
        $this->db->select("wo.*");
        $this->db->where([
            'wo.operator_username' => $arr['uname'],
            'wo.admin_password' => md5($this->config->item('encryption_key').
                    $arr['password'])
                ]);
       $query = $this->db->get();
       $res = $query->result_array();
       return !empty($res) ? "true": "false";
    }
    public function getOperator($params){
        if(!empty($key) && !empty($value)){
            $this->db->from($this->_website_operator." as wo");
            $this->db->select("wo.operator_username,wo.operator_id,wo.operator_display_name");
            $this->db->where($params['where']);
            $query = $this->db->get();
            return $query->result_array();
        }
    }
}
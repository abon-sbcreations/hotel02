<?php
class Admin extends CI_Model{
    private $_super_admin = "tbl_super_admin";
    private $_hotel_admin_master = "hotel_admin_master";
    private $_hotel_master = "tbl_hotel_master";
    public function checkAdmin($arr){
        $this->db->from($this->_super_admin." as sa");
        $this->db->select("sa.*");
        $this->db->where([
            'sa.admin_username'=>$arr['uname'],
            'sa.admin_password'=>md5($this->config->item('encryption_key').
                    $arr['password'])
                ]);
       $query = $this->db->get();
       $res = $query->result_array();
       return !empty($res) ? "0": "1";
    }
    public function getAdmin($key='',$value=''){
        if(!empty($key) && !empty($value)){
            $this->db->from($this->_super_admin." as sa");
            $this->db->select("sa.*");
            $this->db->where([
                $key => $value
            ]);
            $query = $this->db->get();
            $user = $query->result_array();
            if($user[0]['admin_type']=="Hotel"){
                $this->db->from($this->_hotel_admin_master." as ham");
                $this->db->join($this->_super_admin." as sa","sa.admin_id = ham.admin_user_id","left");
                $this->db->join($this->_hotel_master." as hm","hm.hotel_id = ham.hotel_id","left");
                $this->db->select("ham.*,sa.*,hm.hotel_name");
                $this->db->where(['admin_user_id'=>$user[0]['admin_id']]);
                $query2 = $this->db->get();
                return $query2->result_array();        
            }else{
                return $user;
            }
        }
    }
}
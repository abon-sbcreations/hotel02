<?php
class HotelAdmin extends CI_Model{
    private $_hotel_admin_master = "hotel_admin_master";
    private $__hotel_master = "tbl_hotel_master";
    public function checkHotelAdmin($arr){
        $this->db->from($this->_hotel_admin_master." as ham");
        $this->db->select("ham.*");
        $this->db->where([
            'ham.hotel_userid'=>$arr['hotel_userid'],
            'ham.hotel_passwd'=>md5($this->config->item('encryption_key').
                    $arr['hotel_passwd'])
                ]);
       $query = $this->db->get();
       $res = $query->result_array();
       return !empty($res) ? "true": "false";
    }
    public function getHotelAdmin($key='',$value=''){
        if(!empty($key) && !empty($value)){
            $this->db->from($this->_hotel_admin_master." as ham");
            $this->db->join($this->__hotel_master." as hm","ham.hotel_id = hm.hotel_id","left");
            $this->db->select("ham.hotel_admin_id,ham.hotel_userid,hm.hotel_name");
            $this->db->where([
                $key => $value
            ]);
            $query = $this->db->get();
            return $query->result_array();
        }
    }
}
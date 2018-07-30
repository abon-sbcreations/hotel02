<?php

class Hotel_admin extends CI_Model {

    private $_hotel_master = "tbl_hotel_master";
    private $_hotel_admin_master = "hotel_admin_master";
    private $_super_admin = "tbl_super_admin";
    public function getHotelAdmin($params) {
        $this->db->select("ham.*,sa.admin_username,hm.hotel_name");
         $this->db->from($this->_hotel_admin_master." as ham");
                $this->db->join($this->_super_admin." as sa","sa.admin_id = ham.admin_user_id","left");
                $this->db->join($this->_hotel_master." as hm","hm.hotel_id = ham.hotel_id","left");
        if (isset($params['where']) && !empty($params['where'])) {
            $this->db->where($params['where']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    private function moduleToJson($moduleArr){
        $legends = [0=>'view',1=>'add',2=>'edit',3=>'delete'];
        $jsonStr = "{";
        foreach ($moduleArr as $module_id=>$permissions){
            $perString = "";
            foreach ($permissions as $legend=>$val){
                $perString .="\"".$legends[$legend]."\",";
            }
            $jsonStr .= "\"{$module_id}\":[".rtrim($perString,",")."],";            
        }
        return rtrim($jsonStr,",")."}";
        
    }
    public function postHotelAdmin($master) {
        $this->db->insert($this->_super_admin,[
            'admin_username' => $master['admin_username'],
            'admin_password' => md5($this->config->item('encryption_key').$master['admin_username']),
            'admin_type'=>'Hotel'
        ]);
        $insId =  $this->db->insert_id();
        $this->db->insert($this->_hotel_admin_master, [
            'hotel_id' => $master['hotel_id'],
            'admin_user_id'=>$insId,
            'hotel_module_permission' => $this->moduleToJson($master['module']),
            'hotel_access_activation' => $master['hotel_access_activation'],
            'hotel_access_duration' => $master['hotel_access_duration'],
            'hotel_access_rent' => $master['hotel_access_rent'],
            'is_rent_paid' => $master['is_rent_paid'],
            'hotel_admin_status' => $master['hotel_admin_status']
        ]);
    }
    public function putHotelAdmin($master) {
        $this->db->update(
            $this->_super_admin,[
            'admin_username' => $master['admin_username'],
            ], ['admin_id' => $master['admin_user_id']]
           );
        $this->db->update($this->_hotel_admin_master, [
            'hotel_id' => $master['hotel_id'],
            'hotel_module_permission' => $this->moduleToJson($master['module']),
            'hotel_access_activation' => $master['hotel_access_activation'],
            'hotel_access_duration' => $master['hotel_access_duration'],
            'hotel_access_rent' => $master['hotel_access_rent'],
            'is_rent_paid' => $master['is_rent_paid'],
            'hotel_admin_status' => $master['hotel_admin_status']
           ], ['admin_user_id' => $master['admin_user_id']]);
    }
    public function putHotelAdminPassword($post){
        $status = 0;        $message = "";
        if($post['rehotel_passwd'] == $post['hotel_passwd']){
            $qry = $this->db->from($this->_super_admin)->where([
                'admin_id'=>$post['admin_user_id'],
                'admin_password'=> md5($this->config->item('encryption_key').$post['oldHotel_passwd'])
                ])->get();
            $res = $qry->result();
            if(!empty($res)){
                $this->db->update($this->_super_admin
                        ,['admin_password'=> md5($this->config->item('encryption_key').$post['hotel_passwd'])]
                        ,['admin_id' => $post['admin_user_id']]);
                $status = 1;
                $message = "Password Changed SuccessFully";
            }else{
                $status = -1;
                $message = "wrong Old password entered";
            }
        }else{
            $status = -1;
            $message = "confirm password not matching with new password";
        }
        return json_encode(['status'=>$status,'message'=>$message]);
    }
    public function deleteHotelAdmin($where) {
        $this->db->delete($this->_super_admin, ['admin_id'=>$where['admin_user_id']]);
        $this->db->delete($this->_hotel_admin_master, ['admin_user_id'=>$where['admin_user_id']]);
    }

}

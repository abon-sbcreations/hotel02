<?php

class Membership_master extends CI_Model {

    private $_membership_master = "hotel_membership_master";
    private $_hotel_master = "tbl_hotel_master";

    public function getMembershipMasters($params) {
        $this->db->from($this->_membership_master." as mm");
        $this->db->join($this->_hotel_master." as hm","hm.hotel_id = mm.hotel_id","left");
        $this->db->select("mm.membership_id,mm.hotel_id,hm.hotel_name,mm.membership_card,"
               ."mm.membership_card_value,mm.membership_validity,mm.membership_validity,mm.membership_amenity");
        if (isset($params['where']) && !empty($params['where'])) {
            $this->db->where($params['where']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function postMembershipMaster($membership) {
            $this->db->insert($this->_membership_master, [
            'hotel_id' => $this->session->userdata('hotel_id'),
            'membership_card' => $membership['membership_card'],
            'membership_card_value' => $membership['membership_card_value'],
            'membership_validity' => $membership['membership_validity'],
            'membership_amenity' => $this->amenitiesList($membership['amenity']),
        ]);
    }

    public function putMembershipMaster($membership) {
        $this->db->update($this->_membership_master, [
            'hotel_id' => $this->session->userdata('hotel_id'),
            'membership_card' => $membership['membership_card'],
            'membership_card_value' => $membership['membership_card_value'],
            'membership_validity' => $membership['membership_validity'],
            'membership_amenity' => $this->amenitiesList($membership['amenity'])
        ], ['membership_id' => $membership['membership_id']]);
    }
    public function deleteMembership($where) {
        $this->db->delete($this->_membership_master, $where);
    }
    private function amenitiesList($arr){
        $list = "";
        if(!empty($arr)){
            foreach ($arr as $key=>$val){
                $list .= "{$key},";
            }
        }        
        return rtrim($list,',');
    }
}

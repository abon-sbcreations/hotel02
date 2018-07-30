<?php

class Item_master extends CI_Model{
    private $_room_item_master = "tbl_item_master";
    public function getItemMaster($params) {
        $this->db->select("room_item_id,room_item_cat,room_item_subcat,	room_item_name");
        $this->db->from($this->_room_item_master);
        if (isset($params['where']) && !empty($params['where'])) {
            $this->db->where($params['where']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    public function postItemMaster($master) {
        $this->db->insert($this->_room_item_master, ['room_item_name' => $master['room_item_name'],
            'room_item_subcat' => $master['room_item_subcat'],
            'room_item_cat' => $master['room_item_cat']
        ]);
    }
    public function putitemMaster($master) {
        $this->db->update($this->_room_item_master, ['room_item_name' => $master['room_item_name'],
            'room_item_subcat' => $master['room_item_subcat'],
            'room_item_cat' => $master['room_item_cat'],
                ], ['room_item_id' => $master['room_item_id']]);
    }
    public function deleteitemMaster($where) {
        $this->db->delete($this->_room_item_master, $where);
    }
}
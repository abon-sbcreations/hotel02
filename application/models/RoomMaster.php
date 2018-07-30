<?php
class RoomMaster extends CI_Model {
    private $_room_master = "tbl_room_master";
    public function getRoomsMaster($params) {
        $this->db->select("rm.room_master_id,rm.room_type,rm.room_type_Desc,rm.room_type_status");
        $this->db->from($this->_room_master . " as rm");
        if (isset($params['where']) && !empty($params['where'])) {
            $this->db->where($params['where']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    public function postRoomMaster($master) {
        $this->db->insert($this->_room_master, ['room_type' => $master['room_type'],
            'room_type_Desc' => $master['room_type_Desc'],
            'room_type_status' => $master['room_type_status']
        ]);
    }
    public function putRoomMaster($master) {
        $this->db->update($this->_room_master, ['room_type' => $master['room_type'],
            'room_type_Desc' => $master['room_type_Desc'],
                ], ['room_master_id' => $master['room_master_id']]);
    }
    public function deleteRoomMaster($where) {
        $this->db->delete($this->_room_master, $where);
    }
}

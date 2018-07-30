<?php

class Amenity extends CI_Model {

    private $_amenities_master = "tbl_amenities_master";

    public function getAminity($params) {
        $this->db->select("amenity_id,amenity_name,amenity_desc");
        $this->db->from($this->_amenities_master);
        if (isset($params['where']) && !empty($params['where'])) {
            $this->db->where($params['where']);
        }
        if (isset($params['where_in']) && !empty($params['where_in'])) {
            $this->db->where_in($params['where_in']['attr'],$params['where_in']['list']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    public function postAmenity($amenity) {
        $this->db->insert($this->_amenities_master, ['amenity_name' => $amenity['amenity_name'],
            'amenity_desc' => $amenity['amenity_desc'],
                ], ['amenity_id' => $amenity['amenity_id']]);
    }

    public function putAmenity($amenity) {
        $this->db->update($this->_amenities_master, ['amenity_name' => $amenity['amenity_name'],
            'amenity_desc' => $amenity['amenity_desc'],
                ], ['amenity_id' => $amenity['amenity_id']]);
    }

    public function deleteAmenity($where) {
        $this->db->delete($this->_amenities_master, $where);
    }

}

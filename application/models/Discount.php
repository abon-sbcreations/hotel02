<?php
class Discount extends CI_Model {
    private $_discounts_list = "discounts_list";
    private $_module_master = "tbl_module_master";
    public function getDiscounts($params) {
        $this->db->select("dl.*,mm.* ");
        $this->db->from($this->_discounts_list . " as dl");
        $this->db->join($this->_module_master . " as mm","mm.module_id = dl.discount_sub","left");
        if (isset($params['where']) && !empty($params['where'])) {
            $this->db->where($params['where']);
        }
        $query = $this->db->get();
        $discounts = $query->result_array();
        $discountArr = [];
        foreach ($discounts as $key1 => $disc1){            
            $this->db->from($disc1['table_name']);
            $this->db->select($disc1['display_attr']);
            $this->db->where([$disc1['primary_attr'] => $disc1['discount_sub_id']]);
            $query1 = $this->db->get();
            $res2 = $query1->result_array();
            $disc1['sub_display'] = isset($res2[0][$disc1['display_attr']]) ? $res2[0][$disc1['display_attr']] : ""; 
            $discountArr[] = $disc1;
        }
        return $discountArr;
    }
    public function postDiscount($discount) {
        $this->db->insert($this->_discounts_list, [
            'discount_type' => $discount['discount_type'],
            'discount_price' => $discount['discount_price'],
            'hotel_id' => $this->session->userdata('hotel_id'),
            'discount_from' => $discount['discount_from'],
            'discount_to' => $discount['discount_to'],
            'discount_sub' => $discount['discount_sub'],
            'discount_sub_id' => $discount['discount_sub_id']
        ]);
    }
    public function putDiscount($discount) {
        $this->db->update($this->_discounts_list, [
            'discount_type' => $discount['discount_type'],
            'discount_price' => $discount['discount_price'],
             'hotel_id' => $this->session->userdata('hotel_id'),
            'discount_from' => $discount['discount_from'],
            'discount_to' => $discount['discount_to'],
            'discount_sub' => $discount['discount_sub'],
            'discount_sub_id' => $discount['discount_sub_id']
                ], ['discount_id' => $discount['discount_id']]);
    }
    public function deleteDiscount($where) {
        $this->db->delete($this->_discounts_list, $where);
    }
    public function getModuleList(){
        $this->db->from($this->_module_master);
        $this->db->where("table_name is not null and table_name <> ''");
        $qry1 = $this->db->get();        
        $modules = $qry1->result_array();
        $moduleList = [];
        $subModuleList = [];
        foreach ($modules as $key1=>$mod1){
            $moduleList[$mod1['module_id']] = $mod1['module_name'];
            $this->db->from($mod1['table_name']);
            $this->db->select("{$mod1['primary_attr']},{$mod1['display_attr']}");
            $this->db->where("{$mod1['display_attr']} is not null and {$mod1['display_attr']} <> ''");
            $qry2 = $this->db->get();
            $subMods = $qry2->result_array();
            foreach ($subMods as $key2 => $subM){
              $subModuleList[$mod1['module_id']][$subM[$mod1['primary_attr']]] = $subM[$mod1['display_attr']];
            }
        }
        return ['subModuleList'=>$subModuleList,'moduleList'=>$moduleList];
    }
}


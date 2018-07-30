<?php

class Company extends CI_Model {

    private $_company_master = "tbl_company_master";

    public function getCompany($params) {
        $this->db->select("comp_id,comp_name,comp_reg_no,comp_gst_no,comp_pan_no,comp_address");
        $this->db->from($this->_company_master);
        if (isset($params['where']) && !empty($params['where'])) {
            $this->db->where($params['where']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function postCompany($company) {
        $this->db->insert($this->_company_master, [
            'comp_name' => ucfirst(strtolower($company['comp_name'])),
            'comp_reg_no' => $company['comp_reg_no'],
            'comp_gst_no' => $company['comp_gst_no'],
            'comp_pan_no' => $company['comp_pan_no'],
            'comp_address' => $company['comp_address']
                ]);
    }
    public function putCompany($company) {
        $this->db->update($this->_company_master, [
            'comp_name' => ucfirst(strtolower($company['comp_name'])),
            'comp_reg_no' => $company['comp_reg_no'],
            'comp_gst_no' => $company['comp_gst_no'],
            'comp_pan_no' => $company['comp_pan_no'],
            'comp_address' => $company['comp_address']
                ], ['comp_id' => $company['comp_id']]);
    }

    public function deleteCompany($where) {
        $this->db->delete($this->_company_master, $where);
    }

}

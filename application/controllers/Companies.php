<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Companies extends CI_Controller {
    private $_company_master = "tbl_company_master";
    public function __construct() {
        parent::__construct();
        $this->load->helper('form', 'security');
        $this->load->helper('commonmisc_helper');
        $this->load->helper('validationmisc_helper');
        $this->load->library('form_validation', 'session');
        $this->load->model('Company');
        $u1 = $this->session->userdata('logged_id');
        if (!isset($u1)) {
            redirect('/admins', 'refresh');
        }
    }

    public function index() {
        $loggedDisplay = $this->session->userdata('logged_display');
        $head01Temp = $this->load->view('templates/head01',['loggedDisplay'=>$loggedDisplay],TRUE);
        $leftmenu01Temp = $this->load->view('templates/leftMenu01',['activeMenu'=>'companies'],TRUE); 
        $this->load->view('companies/company_list', [
            'head01Temp'=>$head01Temp,
            'leftmenu01Temp'=>$leftmenu01Temp,
            'timeSlotOptions' => timeSlotOptions()
        ]);
    }

    public function ajaxAllCompaniesMasterDataTable() {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $companies = $this->Company->getCompany([]);
        $rows = [];
        foreach ($companies as $k => $company) {
            $rows[] = [
                "DT_RowId" => "row_" . $company['comp_id'],
                "comp_id" => $company['comp_id'],
                'comp_name' => ucwords(strtolower($company['comp_name'])),
                'comp_reg_no' => $company['comp_reg_no'],
                'comp_gst_no' => $company['comp_gst_no'],
                'comp_pan_no' => $company['comp_pan_no'],
                'comp_address' =>$company['comp_address']
            ];
        }
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => count($companies),
            "recordsFiltered" => count($companies),
            "data" => $rows
        ]);
    }

    public function ajaxCompanyMasterDetails() {
        $params = [
            'where' => ['comp_id' => $this->input->post('comp_id')]
        ];
        $company = $this->Company->getCompany($params);
        echo json_encode($company[0]);
    }

    public function ajaxCompanyMasterDelete() {
        $where = ['comp_id' => $this->input->post('comp_id')];
        $comp = $this->Company->deleteCompany($where);
        return json_encode(['true']);
    }

    public function ajaxCompaniesMasterSubmit() {
        $post = $this->input->post();
        if (isset($post['comp_id']) && !empty($post['comp_id'])) {
            $this->Company->putCompany($post);
        } else {
            $this->Company->postCompany($post);
        }
    }
    public function ajaxUniqueCompanyAttr(){
        $post = $this->input->post();
        if (isset($post['primaryVal']) && !empty($post['primaryVal'])) {
            echo checkTableUnique([
                'table' => $this->_company_master,
                'primary_id' => "comp_id",
                'primaryVal' => $post['primaryVal'],
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
                    ]);
        } else {
            echo checkTableUnique([
                'table' => $this->_company_master,
                'primary_id' => "comp_id",
                'primaryVal' => 0,
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
                    ]);
        }        
    }
}

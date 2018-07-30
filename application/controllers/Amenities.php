<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Amenities extends CI_Controller {
     private $_amenities_master = "tbl_amenities_master";
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('commonmisc_helper');
        $this->load->helper('validationmisc_helper');
        $this->load->model('Amenity');
        $u1 = $this->session->userdata('logged_id');
        if (!isset($u1)) {
            redirect('/admins', 'refresh');
        }
    }
    public function amenity_list() {
        $loggedDisplay = $this->session->userdata('logged_display');
        $head01Temp = $this->load->view('templates/head01',['loggedDisplay'=>$loggedDisplay],TRUE);
        $leftmenu01Temp = $this->load->view('templates/leftMenu01',['activeMenu'=>'amenities/amenity_list'],TRUE);   
        $this->load->view('amenities/amenity_list', [
            'head01Temp'=>$head01Temp,
            'leftmenu01Temp'=>$leftmenu01Temp,
            'timeSlotOptions' => timeSlotOptions()
        ]);
    }
    public function ajaxAllAmenitiesMasterDataTable() {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $amenities = $this->Amenity->getAminity([]);
        $rows = [];
        foreach ($amenities as $k => $amenity) {
            $rows[] = [
                "DT_RowId" => "row_" . $amenity['amenity_id'],
                "amenity_id" => $amenity['amenity_id'],
                'amenity_name' => ucwords(strtolower($amenity['amenity_name'])),
				'amenity_desc' =>  substr($amenity['amenity_desc'],0,100).(strlen($amenity['amenity_desc'])>100?"...":""),
            ];
        }
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => count($amenities),
            "recordsFiltered" => count($amenities),
            "data" => $rows
        ]);
    }
    public function ajaxAmenityMasterDetails() {
        $params = [
            'where' => ['amenity_id' => $this->input->post('amenity_id')]
        ];       
        $aminity = $this->Amenity->getAminity($params);
        echo json_encode($aminity[0]);
    }
    public function ajaxAmenityMasterSubmit(){
        $post = $this->input->post();
        if (isset($post['amenity_id']) && !empty($post['amenity_id'])) {
            $this->Amenity->putAmenity($post);
        } else {
            $this->Amenity->postAmenity($post);
        }
    }
    public function ajaxAmenityMasterDelete() {
        $where = ['amenity_id' => $this->input->post('amenity_id')];
        $aminity = $this->Amenity->deleteAmenity($where);
        
        return json_encode(['true']);
    }
    public function ajaxUniqueAmenityAttr(){
        $post = $this->input->post();
        if (isset($post['primaryVal']) && !empty($post['primaryVal'])) {
            echo checkTableUnique([
                'table' => $this->_amenities_master,
                'primary_id' => "amenity_id",
                'primaryVal' => $post['primaryVal'],
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
                    ]);
        } else {
            echo checkTableUnique([
                'table' => $this->_amenities_master,
                'primary_id' => "amenity_id",
                'primaryVal' => 0,
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
                    ]);
        }        
    }
}

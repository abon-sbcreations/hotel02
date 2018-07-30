<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel_admins extends CI_Controller {
    private $_hotel_admin_master = "hotel_admin_master";
    private $_super_admin = "tbl_super_admin";
    public function __construct() {
        parent::__construct();
        $this->load->helper('form', 'security');
        $this->load->helper('commonmisc_helper');
        $this->load->helper('validationmisc_helper');
        $this->load->library('form_validation', 'session');
        $this->load->model('Hotel_admin');
        $u1 = $this->session->userdata('logged_id');
        if (!isset($u1)) {
            redirect('/admins', 'refresh');
        }
    }
    public function admins() {
        $loggedDisplay = $this->session->userdata('logged_display');
        $head01Temp = $this->load->view('templates/head01',['loggedDisplay'=>$loggedDisplay],TRUE);
        $leftmenu01Temp = $this->load->view('templates/leftMenu01',['activeMenu'=>'hotel_admins/admins'],TRUE);  
        $this->load->view('hotel_admins/listing', [
            'head01Temp'=>$head01Temp,
            'leftmenu01Temp'=>$leftmenu01Temp,
            'hotelOptions' =>hotelOptions(),
            'moduleOptions' =>getModuleOptions(),
            'isActive' => getStatus(),
            'yesNo' => getItemAvailable()
            
        ]);
    }
    public function ajaxAllHotelAdminDataTable() {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $hotelAdmins = $this->Hotel_admin->getHotelAdmin([]);        
        $rows = [];
        foreach ($hotelAdmins as $k => $room){
            $rows[] = [
                "DT_RowId" => "row_" . $room['admin_user_id'],
                "admin_user_id" => $room['admin_user_id'],
                'hotel_name' => ucwords(strtolower($room['hotel_name'])),
				'hotel_admin_status'=>$room['hotel_admin_status'],
				'is_rent_paid' => $room['is_rent_paid']=='Y'?"Yes":"No",
				'hotel_access_rent' =>$room['hotel_access_rent'],
                'admin_username' => $room['admin_username'],
                'hotel_access_activation' => $room['hotel_access_activation'],
                'hotel_access_duration' => $room['hotel_access_duration']
            ];
        }
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => count($hotelAdmins),
            "recordsFiltered" => count($hotelAdmins),
            "data" => $rows
        ]);
    }
    public function ajaxHotelAdminDetails() {
        $params = [
            'where' => ['admin_user_id' => $this->input->post('admin_user_id')]
        ];
        $admin = $this->Hotel_admin->getHotelAdmin($params);
        echo json_encode($admin[0]);
    }
    public function ajaxHotelAdminDelete() {
        $where = ['admin_user_id' => $this->input->post('admin_user_id')];
        $comp = $this->Hotel_admin->deleteHotelAdmin($where);
        return json_encode(['true']);
    }
    public function ajaxHotelAdminSubmit() {
        $post = $this->input->post();
        if (isset($post['admin_user_id']) && !empty($post['admin_user_id'])) {
            $this->Hotel_admin->putHotelAdmin($post);
        } else {
            $this->Hotel_admin->postHotelAdmin($post);
        }
    }
    public function ajaxHotelAdminPasswordsSubmit(){
        $post = $this->input->post();
        if (isset($post['admin_user_id']) && !empty($post['admin_user_id'])) {
           echo $this->Hotel_admin->putHotelAdminPassword($post);
        }else{
            echo json_encode(['status'=>-1,'message'=>"invalid form submission"]);
        }
    }
    public function ajaxUniqueHotelAdminAttr(){
        $post = $this->input->post();
        $table; $primary_key;
        $table = $post['attr'] == "admin_username" ? $this->_super_admin : $this->_hotel_admin_master;
        $primary_key = $post['attr'] == "admin_username" ? "admin_id" : "admin_user_id";
        if (isset($post['primaryVal']) && !empty($post['primaryVal'])) {
            echo checkTableUnique([
                'table' => $table,
                'primary_id' => $primary_key,
                'primaryVal' => $post['primaryVal'],
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
             ]);
        } else {
            echo checkTableUnique([
                'table' => $table,
                'primary_id' => $primary_key,
                'primaryVal' => 0,
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
              ]);
        }        
    }
}

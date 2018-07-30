<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Membership_masters extends CI_Controller {
     private $_membership_master = "hotel_membership_master";
    public function __construct() {
        parent::__construct();
        $this->load->helper('form', 'security');
        $this->load->helper('commonmisc_helper');
        $this->load->helper('validationmisc_helper');
        $this->load->library('form_validation', 'session');
        $this->load->model('Membership_master');
        $this->load->model('Amenity');
        $u1 = $this->session->userdata('admin_user_id');
         if(!isset($u1)){
            redirect('/admins', 'refresh');
        }
    }
    public function master() {
        $loggedHotelAdmin = $this->session->all_userdata();
        $head02Temp = $this->load->view('templates/head02',['loggedHotelAdmin'=>$loggedHotelAdmin],TRUE);
        $leftmenu02Temp = $this->load->view('templates/leftMenu02',['activeMenu'=>'membership_masters/master'],TRUE);
        $this->load->view('membership_masters/membership_type_master', [
            'head02Temp'=>$head02Temp,
            'leftmenu02Temp'=>$leftmenu02Temp,
            'hotelOptions' =>hotelOptions(),
            'amenityOptions' => amenityOptions(),
            'hotelId' =>$this->session->userdata('hotel_id')
        ]);
    }
    public function ajaxAllMembershipDataTable() {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $memberships = $this->Membership_master->getMembershipMasters([]);        
        $rows = [];
        foreach ($memberships as $k => $membership) {
            $amenityList = explode(",",trim($membership['membership_amenity'],","));
            $amenityDbList = $this->Amenity->getAminity(['where_in'=>[
                'attr'=>'amenity_id',
                'list' =>$amenityList
            ]]);
            $amtList = "<ul>";
            foreach ($amenityDbList as $key=>$amt){
                $amtList .= "<li>{$amt['amenity_name']}</li>";
            }
            $amtList .= "</ul>";
            $rows[] = [
                "DT_RowId" => "row_" . $membership['membership_id'],
                "membership_id" => $membership['membership_id'],
                /*'hotel_name' => $membership['hotel_name'],*/
                'membership_card' => ucwords($membership['membership_card']),
                'membership_card_value' => $membership['membership_card_value'],
                'membership_validity' => $membership['membership_validity'],
                'membership_amenity' => $amtList
            ];
        }
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => count($memberships),
            "recordsFiltered" => count($memberships),
            "data" => $rows
        ]);
    }
    public function ajaxMembershipDetails() {
        $params = [
            'where' => ['membership_id' => $this->input->post('membership_id')]
        ];
        $room = $this->Membership_master->getMembershipMasters($params);
        echo json_encode($room[0]);
    }
    public function ajaxMembershipMasterDelete() {
        $where = ['membership_id' => $this->input->post('membership_id')];
        $comp = $this->Membership_master->deleteMembership($where);
        return json_encode(['true']);
    }
    public function ajaxMembershipMasterSubmit() {
        $post = $this->input->post();
        if (isset($post['membership_id']) && !empty($post['membership_id'])) {
            $this->Membership_master->putMembershipMaster($post);
        } else {
            $this->Membership_master->postMembershipMaster($post);
        }
    } 
    public function ajaxUniqueMemberHotelAttr(){
        $post = $this->input->post();
        if (isset($post['hotelIdValue']) && !empty($post['hotelIdValue'])) {
            echo checkHotelUnique([
                'table' => $this->_membership_master,
                'primary_id' => "membership_id",
                'primaryVal' => $post['primaryVal'],
                'hotelIdValue' => $post['hotelIdValue'],
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
                    ]);
        } else {
            echo checkHotelUnique([
                'table' => $this->_membership_master,
                'primary_id' => "membership_id",
                'primaryVal' => 0,
                'hotelIdValue' => $post['hotelIdValue'],
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
                    ]);
        }        
    }
}

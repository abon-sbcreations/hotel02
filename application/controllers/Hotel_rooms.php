<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel_rooms extends CI_Controller {
private $_hotel_room_detail = "tbl_hotel_room_detail";
    public function __construct() {
        parent::__construct();
        $this->load->helper('form', 'security');
        $this->load->helper('commonmisc_helper');
        $this->load->helper('validationmisc_helper');
        $this->load->library('form_validation', 'session');
        $this->load->model('Hotel_room');
        $this->load->model('Amenity');
        $u1 = $this->session->userdata('admin_user_id');
         if(!isset($u1)){
           redirect('/admins', 'refresh');
        }
    }
    public function master() {
        getModulePermission($this->session->userdata('admin_user_id'));
        $loggedHotelAdmin = $this->session->all_userdata();
        $head02Temp = $this->load->view('templates/head02',['loggedHotelAdmin'=>$loggedHotelAdmin],TRUE);
        $leftmenu02Temp = $this->load->view('templates/leftMenu02',['activeMenu'=>'hotel_rooms/master'],TRUE);
        $this->load->view('hotel_rooms/room_type_list', [
            'head02Temp'=>$head02Temp,
            'leftmenu02Temp'=>$leftmenu02Temp,
            'roomTypeOptions' => roomTypeOptions($this->session->userdata('hotel_id')),
            'hotelOptions' =>hotelOptions(),
            'amenityOptions' => amenityOptions()
        ]);
    }
    public function ajaxAllHotelRoomTypeDataTable() {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
       $hotelRooms = $this->Hotel_room->getHotelRooms(['where'=>['hrd.hotel_id'=>$this->session->userdata('hotel_id')]]);  
       $rows = [];
        foreach ($hotelRooms as $k => $room) {
            $amenityList = explode(",",trim($room['hotel_room_amenities'],","));
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
                "DT_RowId" => "row_" . $room['hotel_room_master_id'],
                "hotel_room_master_id" => $room['hotel_room_master_id'],
                "room_type" => ucwords($room['room_type']),
                'hotel_room_desc' => $room['hotel_room_desc'],
                'hotel_room_rent' => $room['hotel_room_rent'],
                'hotel_room_amenities' => $amtList
            ];
        }
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => count($hotelRooms),
            "recordsFiltered" => count($hotelRooms),
            "data" => $rows
        ]);
    }
    public function ajaxHotelRoomDetails() {
        $params = [
            'where' => ['hotel_room_master_id' => $this->input->post('hotel_room_master_id')]
        ];
        $room = $this->Hotel_room->getHotelRooms($params);
        echo json_encode($room[0]);
    }
    public function ajaxHotelRoomMasterDelete() {
        $where = ['hotel_room_master_id' => $this->input->post('hotel_room_master_id')];
        $comp = $this->Hotel_room->deleteHotelRoom($where);
        return json_encode(['true']);
    }
    public function ajaxHotelRoomMasterSubmit() {
        $post = $this->input->post();
        if (isset($post['hotel_room_master_id']) && !empty($post['hotel_room_master_id'])) {
            $this->Hotel_room->putHotelRoom($post);
        } else {
            $this->Hotel_room->postHotelRoom($post);
        }
    }
    public function ajaxUniqueHotelRoomAttr(){
        $post = $this->input->post();
        if (isset($post['primaryVal']) && !empty($post['primaryVal'])) {
            echo checkHotelUnique([
                'table' => $this->_hotel_room_detail,
                'primary_id' => "hotel_room_master_id",
                'primaryVal' => $post['primaryVal'],
                 'hotelIdValue'=>$this->session->userdata('hotel_id'),
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
                    ]);
        } else {
            echo checkHotelUnique([
                'table' => $this->_hotel_room_detail,
                'primary_id' => "hotel_room_master_id",
                'primaryVal' => 0,
                'hotelIdValue'=>$this->session->userdata('hotel_id'),
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
                    ]);
        }
    }
}

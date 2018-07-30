<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hotels extends CI_Controller {
    private $_hotel_master = "tbl_hotel_master";
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('commonmisc_helper');
        $this->load->helper('validationmisc_helper');
        $this->load->model('hotel');
        $this->load->model('company');
        $u1 = $this->session->userdata('logged_id');
        if (!isset($u1)) {
            redirect('/admins', 'refresh');
        }
    }
    public function hotels() {
        $loggedDisplay = $this->session->userdata('logged_display');
        $head01Temp = $this->load->view('templates/head01',['loggedDisplay'=>$loggedDisplay],TRUE);
        $leftmenu01Temp = $this->load->view('templates/leftMenu01',['activeMenu'=>'hotels/hotels'],TRUE);  
        $this->load->view('hotels/hotels',[
            'head01Temp'=>$head01Temp,
            'leftmenu01Temp'=>$leftmenu01Temp,
            'timeSlotOptions' => timeSlotOptions(),
            'hotelTypeSlotOptions' => hotelTypeSlotOptions(),
            'companyOptions' => getCompanyOptions()
        ]);
    }
    public function ajaxAllHotelsDataTable() {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $hotels = $this->hotel->getHotels([]);
        $rows = [];
        foreach ($hotels as $k => $hotel) {
            $rows[] = [
                "DT_RowId" => "row_" . $hotel['hotel_id'],
                "hotel_id" => $hotel['hotel_id'],
                'comp_name' => ucwords(strtolower($hotel['comp_name'])),
                'hotel_name' => ucwords(strtolower($hotel['hotel_name'])),
                'hotel_type' => getHotelType($hotel['hotel_type']),
                'hotel_address' => $hotel['hotel_address'],
                'hotel_reg_number' => $hotel['hotel_reg_number'],
                'hotel_gst_number' => $hotel['hotel_gst_number'],
                'hotel_has_restaurant' => $hotel['hotel_has_restaurant'] == 'Y' ? "Yes" : "No",
                'hotel_has_bar' => $hotel['hotel_has_bar'] == 'Y' ? "Yes" : "No",
            ];
        }
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => count($hotels),
            "recordsFiltered" => count($hotels),
            "data" => $rows
        ]);
    }
    public function ajaxHotelDetails() {
        $params = [
            'where' => ['hotel_id' => $this->input->post('hotel_id')]
        ];
        $hotel = $this->hotel->getHotels($params);
        echo json_encode($hotel[0]);
    }

    public function ajaxHotelDelete() {
        $where = ['hotel_id' => $this->input->post('hotel_id')];
        $hotel = $this->hotel->deleteHotel($where);
        return json_encode(['true']);
    }

    public function ajaxHotelSubmit() {
        $post = $this->input->post();
        if (isset($post['hotel_id']) && !empty($post['hotel_id'])) {
            $this->hotel->putHotel($post);
        } else {
            $this->hotel->postHotel($post);
        }
    }
    public function ajaxUniqueHotelAttr(){
        $post = $this->input->post();
        $this->checkHotelAttrUnique([
            'comp_id'=>$post['comp_id'],
            'chkAttr' => $post['chkAttr'],
            'chkAttrVal' => $post['chkAttrVal']
            ]);
    }
    private function checkHotelAttrUnique($attr){
        $compAttr = "";
        if($attr['chkAttr'] == "hotel_reg_number"){  $compAttr = "comp_reg_no";   }
        if($attr['chkAttr'] == "hotel_gst_number"){  $compAttr = "comp_gst_no";   }
        $companies = $this->company->getCompany(['where'=>[
            'comp_id != '=>$attr['comp_id'],
            $compAttr => $attr['chkAttrVal']
                ]]);
        $hotels = $this->hotel->getHotels(['where'=>[
            'hm.comp_id != '=>$attr['comp_id'],
            $attr['chkAttr'] => $attr['chkAttrVal']
                ]]);
        if(empty($companies) && empty($hotels)){
            echo 0;
        }else{
            echo 1;
        }
    }
    public function ajaxGetCompany(){
         $comp = $this->company->getCompany(['where'=>['comp_id'=>$this->input->post('comp_id')]]);
         echo json_encode($comp[0]);
    }
}

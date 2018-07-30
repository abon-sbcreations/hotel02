<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Discounts extends CI_Controller {
    private $_discounts_list = "discounts_list";
    public function __construct() {
        parent::__construct();
        $this->load->helper('form', 'security');
        $this->load->helper('commonmisc_helper');
        $this->load->helper('validationmisc_helper');
        $this->load->library('form_validation', 'session');
        $this->load->model('Discount');
        $u1 = $this->session->userdata('admin_user_id');
        if (!isset($u1)) {
            redirect('/admins', 'refresh');
        }
    }
    public function index() {
        $loggedHotelAdmin = $this->session->all_userdata();
        $head02Temp = $this->load->view('templates/head02',['loggedHotelAdmin'=>$loggedHotelAdmin],TRUE);
        $leftmenu02Temp = $this->load->view('templates/leftMenu02',['activeMenu'=>'discounts'],TRUE);
        $moduleList = $this->Discount->getModuleList();
        $this->load->view('discounts/disc_list', [
            'head02Temp' => $head02Temp,
            'leftmenu02Temp' => $leftmenu02Temp,
            'moduleList' => $moduleList,
            'discount_type' =>['percent'=>'Percent','flat'=>'Flat']
        ]);
    }
    public function ajaxAllDiscountsDataTable() {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $discounts = $this->Discount->getDiscounts([]);
        $rows = [];
        foreach ($discounts as $k => $discount) {
            $rows[] = [
                "DT_RowId" => "row_" . $discount['discount_id'],
                "discount_id" => $discount['discount_id'],
                "discount_type" => $discount['discount_type'],
                "discount_price" => $discount['discount_price'],
                "discount_from" => $discount['discount_from'],
                "discount_to" => $discount['discount_to'],
                "discount_sub" => $discount['discount_sub'],
                "discount_sub_id" => $discount['discount_sub_id'],
                "module_name" =>$discount['module_name'],
                'sub_display' => $discount['sub_display']
            ];
        }
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => count($discounts),
            "recordsFiltered" => count($discounts),
            "data" => $rows
        ]);
    }
    public function ajaxDiscountDetails() {
        $params = [
            'where' => ['discount_id' => $this->input->post('discount_id')]
        ];
        $discount = $this->Discount->getDiscounts($params);
        echo json_encode($discount[0]);
    }
    public function ajaxDiscountDelete() {
        $where = ['where' => ['discount_id' => $this->input->post('discount_id')]];
        $comp = $this->Discount->deleteDiscount($where);
        return json_encode(['true']);
    }
    public function ajaxDiscountsMasterSubmit() {
        $post = $this->input->post();
        if (isset($post['discount_id']) && !empty($post['discount_id'])) {
            $this->Discount->putDiscount($post);
        } else {
            $this->Discount->postDiscount($post);
        }
    }
    public function ajaxUniqueDiscountAttr(){
        $post = $this->input->post();
        if (isset($post['primaryVal']) && !empty($post['primaryVal'])) {
            echo checkHotelUnique([
                'table' => $this->_discounts_list,
                'primary_id' => "discount_id",
                'primaryVal' => $post['primaryVal'],
                'hotel_id' => $this->session->userdata('hotel_id'),
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
                    ]);
        } else {
            echo checkTableUnique([
                'table' => $this->_discounts_list,
                'primary_id' => "discount_id",
                'primaryVal' => 0,
                'hotel_id' => $this->session->userdata('hotel_id'),
                'attr' => $post['attr'],
                'attrVal' => $post['attrVal']
                    ]);
        }        
    }
}
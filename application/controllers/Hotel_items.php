<?phpdefined('BASEPATH') OR exit('No direct script access allowed');class Hotel_items extends CI_Controller {private $_hotel_item_master = "hotel_item_master";    public function __construct() {        parent::__construct();        $this->load->helper('url');        $this->load->helper('commonmisc_helper');        $this->load->helper('validationmisc_helper');        $this->load->model('HotelItemMaster');        $u1 = $this->session->userdata('admin_user_id');         if(!isset($u1)){            redirect('/admins', 'refresh');        }    }    public function master() {        $loggedHotelAdmin = $this->session->all_userdata();        $head02Temp = $this->load->view('templates/head02',['loggedHotelAdmin'=>$loggedHotelAdmin],TRUE);        $leftmenu02Temp = $this->load->view('templates/leftMenu02',['activeMenu'=>'hotel_items/master'],TRUE);        $this->load->view('hotel_items/master', [            'head02Temp'=>$head02Temp,            'leftmenu02Temp'=>$leftmenu02Temp,            'timeSlotOptions' => timeSlotOptions(),            'itemCategory'=>roomItemCategories(),        ]);    }    public function ajaxAllHotelItemMasterDataTable() {        $draw = intval($this->input->get("draw"));        $start = intval($this->input->get("start"));        $length = intval($this->input->get("length"));        $hotelItems = $this->HotelItemMaster->getItemMaster(['where'=>['him.hotel_id'=>$this->session->userdata('hotel_id')]]);                 $cats = roomItemCategories();                 $rows = [];        foreach ($hotelItems as $k => $items) {            $rows[] = [                "DT_RowId" => "row_" . $items['item_id'],                "item_id" => $items['item_id'],                "hotel_name" => $items['hotel_name'],                 "item_cat" => $cats['category'][$items['item_cat']],                "item_subcat" => $cats['sub_category'][$items['item_cat']][$items['item_subcat']],                'item_name' => $items['item_name'],                'item_attr' =>$items['item_attr'],            ];        }        echo json_encode([            "draw" => $draw,            "recordsTotal" => count($hotelItems),            "recordsFiltered" => count($hotelItems),            "data" => $rows        ]);    }    public function ajaxRoomItemMasterDetails(){        $params = [            'where'=>['item_id' =>$this->input->post('item_id') ]         ];               $itemsMaster = $this->HotelItemMaster->getItemMaster($params);        echo json_encode($itemsMaster[0]);    }    public function ajaxHotelItemMasterDelete(){        $where = ['item_id'=>$this->input->post('item_id')];        $hotel = $this->HotelItemMaster->deleteitemMaster($where);        return json_encode(['true']);    }    public function ajaxRoomItemsMasterSubmit(){      $post = $this->input->post();       if(isset($post['item_id'])&& !empty($post['item_id'])){        $this->HotelItemMaster->putItemMaster($post);      }else{        $this->HotelItemMaster->postItemMaster($post);      }    }      public function ajaxUniqueItemsHotelAttr(){        $post = $this->input->post();        if (isset($post['primaryVal']) && !empty($post['primaryVal'])) {            echo checkHotelUnique([                'table' => $this->_hotel_item_master,                'primary_id' => "item_id",                'primaryVal' => $post['primaryVal'],                                'hotelIdValue' => $this->session->userdata('hotel_id'),                'attr' => $post['attr'],                'attrVal' => $post['attrVal']                    ]);        } else {            echo checkHotelUnique([                'table' => $this->_hotel_item_master,                'primary_id' => "item_id",                'primaryVal' => 0,                                'hotelIdValue' => $this->session->userdata('hotel_id'),                'attr' => $post['attr'],                'attrVal' => $post['attrVal']                    ]);        }       }}
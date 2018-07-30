<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hoteldashboards extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $u1 = $this->session->userdata('hotel_userid');
         if(!isset($u1)){
           redirect('/admins', 'refresh');
        }
    }
    public function admin_area(){
        $loggedHotelAdmin = $this->session->all_userdata();
        $head02Temp = $this->load->view('templates/head02',['loggedHotelAdmin'=>$loggedHotelAdmin],TRUE);
        $leftmenu02Temp = $this->load->view('templates/leftMenu02',['activeMenu'=>''],TRUE); 
        $this->load->view('hoteldashboard/hotel_dsbrd',[
            'head02Temp'=>$head02Temp,
            'leftmenu02Temp'=>$leftmenu02Temp,
            'loggedHotelAdmin'=>$loggedHotelAdmin
                ]);
    }
}
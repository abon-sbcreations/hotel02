<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboards extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $u1 = $this->session->userdata('logged_id');
         if(!isset($u1)){
            redirect('/admins', 'refresh');
        }
    }
    public function admin_area(){
        $loggedDisplay = $this->session->userdata('logged_display');
        $head01Temp = $this->load->view('templates/head01',['loggedDisplay'=>$loggedDisplay],TRUE);
        $leftmenu01Temp = $this->load->view('templates/leftMenu01',[],TRUE);        
        $this->load->view('dashboard/admn_dsbrd',[
            'head01Temp'=>$head01Temp,
            'leftmenu01Temp'=>$leftmenu01Temp
            ]);
    }
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Operators extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('form', 'security');
        $this->load->library('form_validation', 'session');
        $this->load->model('Operator');
        $validationRules = [
            [
                'field' => 'uname', 'label' => 'User Name',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s is required'
                ]
            ],
            [
                'field' => 'password', 'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s is required.'
                ]
            ]
        ];
        $this->form_validation->set_error_delimiters('<label class="error" >', '</label>');
        $this->form_validation->set_rules($validationRules);
    }
    public function authenticate() { //login function
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('operators/login');
        } else {
            if ($this->input->post()) {
                $user = $this->Admin->getAdmin(['where'=>[
                'operator_username' => $this->input->post('uname')  
                ]]);
                $this->session->set_userdata([
                    'operator_name' => $user[0]['operator_username'],
                    'operator_id' => $user[0]['operator_id'],
                    'operator_display' => $user[0]['operator_display_name']
                ]);
                redirect('/operators/operator_area', 'refresh');
            }
        }
    }
    public function ajaxCheckOperator(){
        
    }
    public function operator_area(){
        
    } 
    public function modify() {  //change attribute
        echo "change attr";
    }
    public function create() {  //create super admin
        echo "change attr";
    }
    public function change() {  //change super admin
        echo "change attr";
    }
    public function inactive() {  //make in-active
        echo "in active";
    }
}

<?php
function checkTableUnique($arr){
     $ci = & get_instance();
     $ci->load->database();     $ci->db->from($arr['table']);     $ci->db->select(" * ");     
     $ci->db->where([$arr['attr'] => $arr['attrVal']]);         
     $count = $ci->db->count_all_results();      
     if($count==0){
         return 0;
     }else{
         $ci->load->database();     $ci->db->from($arr['table']);     $ci->db->select(" * ");    
         $ci->db->where([$arr['attr'] => $arr['attrVal']]);
         $qry = $ci->db->get();      $res = $qry->result_array();
         if($res[0][$arr['primary_id']] === $arr['primaryVal']){
             return 0;
         }else{
             return 1;
         }
     } 
}
function checkHotelUnique($arr){ 
     $ci = & get_instance();
     $ci->load->database();     $ci->db->from($arr['table']);     $ci->db->select(" * "); 
     $ci->db->where([$arr['attr'] => $arr['attrVal'],'hotel_id'=>$arr['hotelIdValue']]); 
     $count = $ci->db->count_all_results();
     if($count == 0){
         return 0; 
     }else{
        $ci->load->database();     $ci->db->from($arr['table']);     $ci->db->select(" * ");    
         $ci->db->where([$arr['attr'] => $arr['attrVal'],'hotel_id'=>$arr['hotelIdValue']]);
         $qry = $ci->db->get();      $res = $qry->result_array();
         if($res[0][$arr['primary_id']] === $arr['primaryVal']){
             return 0;
         }else{
             return 1;
         }
     }
}
function getModulePermission($user_id){ //,$module_id,$permission
    $ci = & get_instance();
    $ci->load->database(); 
    $ci->db->from("hotel_admin_master");
    $ci->db->select("hotel_module_permission");  
    $ci->db->where(['admin_user_id'=>$user_id]);
    $qry = $ci->db->get();
    $res = $qry->result_array();
    $permissions = json_decode($res[0]['hotel_module_permission']);
}
<?php

/* 
 * ----------------------------------
 * 
 * Contatto_model
 * 
 * ----------------------------------
 * 
 */
class Contatto_model extends CI_Model{
    
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
       $this->load->database();
       // $this->caricaAzienda();
        
    }
    
  
    // Insert Query for  Form
    
    public function Insert($formdata){ 
          $this->db->insert('lm_contatto', $formdata);
          $this->db->last_query();
          $insert_id = $this->db->insert_id();        
    }
    
    // get all contatto
    public function Getall(){
        
        
        
            if(isset($_SESSION["LOGGEDIN"])){
               $sess=$this->session->get_userdata('LOGGEDIN');
               $sessuser=$sess["LOGGEDIN"]["userid"];
            } 
            $this->db->select('*');
           
            $this->db->from('lm_contatto');  
            
            $this->db->where('utente',$sessuser);  
            
            $query = $this->db->get();           
            return $query->result();
            
    }

    // get single contatto
    public function getsingle($id){
          $this->db->SELECT('*');
          $this->db->from('lm_contatto');
          $this->db->where('codcontatto',$id);       
          $query = $this->db->get();
          $this->db->last_query();
          return $query->row();
    }

    // insert csv 
        public function insertCSV($data){
          $this->db->insert('lm_contatto', $data);
          $this->db->last_query();
        }

    // update leads category
   public function update_contatto($id,$formdata){
        $this->db->where('codcontatto',$id);
        $this->db->update('lm_contatto',$formdata);
        $this->db->last_query();
    }
     function contatto_delete($id){
      $this->db->where('codcontatto', $id);
      $this->db->delete('lm_contatto');
    }
}
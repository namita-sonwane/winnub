<?php

/* 
 * ----------------------------------
 * 
 * Compito_model
 * 
 * ----------------------------------
 * 
 */
class Compito_model extends CI_Model{
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
       $this->load->database();
       // $this->caricaAzienda();
        
    }
    
  
    // Insert Query for  Form
    
    public function Insert($formdata){ 
          $this->db->insert('lm_task', $formdata);
          $this->db->last_query();
          $insert_id = $this->db->insert_id();        
    }
    // get all contatto
    public function Getall(){
            $this->db->select('*');
            $this->db->from('lm_task');          
            $query = $this->db->get();           
            return $query->result();

    }

    // get single contatto
    public function getsingle($task_id){
          $this->db->SELECT('*');
          $this->db->from('lm_task');
          $this->db->where('codcompito',$task_id);       
          $query = $this->db->get();
          $this->db->last_query();
          return $query->row();
    }

    // update leads category
   public function update_compito($taskid,$formdata){
        $this->db->where('codcompito',$taskid);
        $this->db->update('lm_task',$formdata);
         $this->db->last_query();
    }
     function compito_delete($id){
      $this->db->where('codcompito', $id);
      $this->db->delete('lm_task');
    }
}
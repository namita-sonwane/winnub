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
	
	function sub_task_delete($id){
      $this->db->where('sub_task_id', $id);
      $this->db->delete('lm_sub_task');
    }
	
	
	
	public function getProjectAndTasks()
	{
		$utente = intval($_SESSION["LOGGEDIN"]["userid"]);
		$sql="SELECT lm_sub_task.* FROM lm_sub_task WHERE lm_sub_task.utente = ".$utente." ORDER BY lm_sub_task.codcompito ASC";
        $query = $this->db->query($sql);
        $rows = $query->result();
        return $rows;
	}
	
	public function getSingleSubtask($edit_task_id){
          $this->db->SELECT('*');
          $this->db->from('lm_sub_task');
          $this->db->where('sub_task_id',$edit_task_id);       
          $query = $this->db->get();
          $this->db->last_query();
          return $query->row();
    }
	
	public function update_sub_tasks($taskid,$formdata){
        $this->db->where('sub_task_id',$taskid);
        $this->db->update('lm_sub_task',$formdata);
         $this->db->last_query();
    }
	
	
	
}
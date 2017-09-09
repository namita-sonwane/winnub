<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Messaggio_model extends CI_Model{
    
    var $idmessage;
    var $user;
    var $reciver;
    var $subject;
    var $message;
    var $data;
    var $esternalcode;
    var $replycode;
    var $obj_action;
    
    var $letto;
    
     public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        
    }
    
    
    
    public function getReplicheMessaggi(){
         $query = $this->db->query('SELECT * FROM lm_message WHERE esternalcode=? AND idmessage<>?  ORDER BY idmessage DESC',
                array(
                    $this->esternalcode,
                    $this->idmessage
         ));
         $dat=$query->result("Messaggio_model");
         
         
         return $dat;
    }
    
    public function getAll($qrs=""){
        
       
        $sess_user = $this->session->get_userdata('LOGGEDIN');
        //$this->session->set_userdata('language',"it");
        //print_r($sess_user["LOGGEDIN"]);
        
        
        
        $query = $this->db->query("SELECT * FROM lm_message WHERE reciver=? $qrs  ORDER BY data DESC ",
                array(
                    $sess_user["LOGGEDIN"]["userid"]
                ));
        
        return $query->result();
        
    }
    
    
    public function getNewMessage(){
        $sess_user = $this->session->get_userdata('LOGGEDIN');
        //$this->session->set_userdata('language',"it");
        //print_r($sess_user["LOGGEDIN"]);
        
        
        
        $query = $this->db->query('SELECT * FROM lm_message WHERE reciver=? AND letto = 0 ',
                array(
                    $sess_user["LOGGEDIN"]["userid"]
                ));
        
        return $query->result();
    }
    
    
    public function getSend($nascondi=""){
         $sess_user = $this->session->get_userdata('LOGGEDIN');
        //$this->session->set_userdata('language',"it");
        //print_r($sess_user["LOGGEDIN"]);
        
        
        
        $query = $this->db->query("SELECT * FROM lm_message WHERE user=? $nascondi ORDER BY data DESC",
                array(
                    $sess_user["LOGGEDIN"]["userid"]
                ));
        
        return $query->result();
    }
    
    public function get($id){
        
       
        $query = $this->db->query('SELECT * FROM lm_message WHERE idmessage=?  ',
                array(
                    $id
                ));
        
        $dat=$query->result("Messaggio_model");
        $dat=$dat[key($dat)];


        $sess_user = $this->session->get_userdata('LOGGEDIN');
        if( $sess_user["LOGGEDIN"]["userid"]==$dat->user || $sess_user["LOGGEDIN"]["userid"]==$dat->reciver){
            return $dat;
        }

        return array("Error access denied");
    }
    
    
    /**
     * Return user message
     * 
     * @param type $usercode
     * @return type
     */
    public function getMessage($usercode,$limits=8){
        
        $sess_user = $this->session->get_userdata('LOGGEDIN');
        
        //$this->session->set_userdata('language',"it");
        //print_r($sess_user["LOGGEDIN"]);
        $query = $this->db->query('SELECT * FROM '
                . ' lm_message '
                . ' '
                . ' WHERE ( reciver = ? AND user=? ) OR ( reciver = ? AND user=? ) ORDER BY idmessage DESC LIMIT '.$limits.' ',
                array(
                    $usercode,
                    $sess_user["LOGGEDIN"]["userid"],
                    $sess_user["LOGGEDIN"]["userid"],
                    $usercode
                )
        );
        
        return $query->result();
        
        
    }
    
    
    public function getRecentChat(){
        
        $sess_user = $this->session->get_userdata('LOGGEDIN');
        
        $query = $this->db->query('SELECT * FROM '
                . ' lm_message '
                . ' '
                . ' WHERE ( reciver = ? OR user=? ) GROUP BY reciver ORDER BY idmessage DESC  ',
                array(
                   
                    $sess_user["LOGGEDIN"]["userid"],
                    $sess_user["LOGGEDIN"]["userid"]
                    
                )
        );
        
        return $query->result();
        
        
        
    }
    
    
    public function remove(){
        
        $this->db->where('idmessage',$this->idmessage);
        $this->db->delete('lm_message');
    }
    
     public function removeexternal(){
        
        $this->db->where('esternalcode',$this->esternalcode);
        $this->db->delete('lm_message');
        
    }
            
    
    
    
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_category_name_by_id($cat_id){
    
    $ci=&get_instance();
    $utente=intval($_SESSION["LOGGEDIN"]["userid"]);
	$sql="SELECT * FROM lm_purchase_category WHERE utente=".$utente." AND purchase_category_id = ".$cat_id." ";
	$query = $ci->db->query($sql);
	$rows = $query->result();        
	return $rows;    
    
    
}
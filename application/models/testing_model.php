<?php

class Testing_model extends CI_Model {

	public function accuracy($filename, $class, $accuracy, $tokens) 
	{
	  
	  $data = array(
		'filename' => base64_decode(urldecode($filename)),
		'classification' => $class,
		'is_accurate' => $accuracy,
		'tokens' => $tokens,
		'date_tested' => @time()
	  );
	  
	  $this->db->insert(TABLE_TESTING, $data);
	  
	}
	
	public function get()
	{
		$query = $this->db->get(TABLE_TESTING);	
		
		return $query;
	}
	
}
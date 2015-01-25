<?php

class training_model extends CI_Model {
  
  public function save_entry($filename, $class, $tokens, $counted)
  {
    $data = array(
        'filename' => $filename,
        'classification' => $class,
        'tokens' => json_encode($tokens),
        'tokens_count' => json_encode($counted),
        'date_created' => @time()
    );
    
    $this->db->insert(TABLE_TRAINING, $data);
    
  }
  
} // End class training_model
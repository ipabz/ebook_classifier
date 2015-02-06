<?php

class training_model extends CI_Model {
  
  public function save_entry($filename, $class, $tokens="", $counted="", $removed_stop_words="", $corpus_counted="")
  {
    $data = array(
        'filename' => $filename,
        'classification' => $class,
        'date_created' => @time()
    );
    
    if (trim($tokens) !== '') {
      $data['tokens'] = json_encode($tokens);
    }
    
    if (trim($counted) !== '') {
      $data['tokens_count'] = json_encode($counted);
    }
    
    if (trim($removed_stop_words) !== '') {
      $data['removed_stop_words'] = json_encode($removed_stop_words);
    }
    
    if (trim($corpus_counted) !== '') {
      $data['corpus_count'] = json_encode($corpus_counted);
    }
    
    $this->db->insert(TABLE_TRAINING, $data);
    
    return $this->db->insert_id();
    
  }
  
  public function get_entries($ids=array(),$class="")
  {
    $custom_where = '';
    
    if (count($ids) > 0) {
      
      foreach ($ids as $id) {
        if ($custom_where === '') {
          $custom_where = 'id = "'.$id.'"';
        } else {
          $custom_where .= ' OR id = "'.$id.'"';
        }
      }
      
      if ($custom_where !== '') {
        $custom_where = '('.$custom_where.')';
      }
      
    }
    
    if ($class !== '') {
      $temp = 'classification = "'.$class.'"';
      
      if ($custom_where !== '') {
        $custom_where .= ' AND ('.$temp.')';
      } else {
        $custom_where = '('.$temp.')';
      }
    }
    
    $sql = "SELECT * FROM ".TABLE_TRAINING;
    
    if ($custom_where !== '') {
      $sql .= " WHERE ".$custom_where;
    }
    
    $query = $this->db->query($sql);
    
    return $query;
    
  }
  
  
  
} // End class training_model
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Initial_schema extends CI_Migration {
  
  public function up() {
    
    /**
     * Remove tables if exists
     */
    $this->dbforge->drop_table('classifications');
    $this->dbforge->drop_table('ebook');
    $this->dbforge->drop_table('ebooks');
    $this->dbforge->drop_table('logs');
    $this->dbforge->drop_table('training');
    
    /**
     * Create 'classifications' table
     */
    $this->dbforge->add_key('id', TRUE);
    
    $classifications_table = array(
      'id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE 
      ),
      'class_name' => array(
          'type' => 'VARCHAR', 'constraint' => 100, 'null' => FALSE
      ),
      'dictionary_file' => array(
          'type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE
      ),
      'date_created' => array(
          'type' => 'TEXT', 'null' => FALSE
      ),
      'last_updated' => array(
          'type' => 'TEXT', 'null' => FALSE
      )
    );
    
    $this->dbforge->add_field($classifications_table);
    $this->dbforge->create_table('classifications');
    
    $time = @time();
    
    $contents = array(
        array(
            'class_name' => '004',
            'dictionary_file' => 'class004.txt',
            'date_created' => $time,
            'last_updated' => $time
        ),
        array(
            'class_name' => '005',
            'dictionary_file' => 'class005.txt',
            'date_created' => $time,
            'last_updated' => $time
        ),
        array(
            'class_name' => '006',
            'dictionary_file' => 'class006.txt',
            'date_created' => $time,
            'last_updated' => $time
        )
    );
    
    $this->db->insert_batch('classifications', $contents);
    
    
    
    /**
     * Create 'ebooks' table
     */
    $this->dbforge->add_key('id', TRUE);
    
    $ebooks_table = array(
      'id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE 
      ),
      'filename' => array(
          'type' => 'TEXT', 'null' => FALSE
      ),
      'classification' => array(
          'type' => 'VARCHAR', 'constraint' => 10, 'null' => FALSE
      ),
      'meta_data' => array(
          'type' => 'TEXT', 'null' => TRUE
      ),
      'tokens' => array(
          'type' => 'TEXT', 'null' => TRUE
      ),
      'corpus_count' => array(
          'type' => 'TEXT', 'null' => TRUE
      ),
      'removed_stop_words' => array(
          'type' => 'TEXT', 'null' => TRUE
      ),
      'tokens_count' => array(
          'type' => 'TEXT', 'null' => TRUE
      ),
      'bigram_raw' => array(
          'type' => 'TEXT', 'null' => TRUE
      ),
      'bigram_counted' => array(
          'type' => 'TEXT', 'null' => TRUE
      ),
      'final_tokens' => array(
          'type' => 'TEXT', 'null' => TRUE
      ),
      'date_created' => array(
          'type' => 'TEXT', 'null' => FALSE
      )
    );
    
    $this->dbforge->add_field($ebooks_table);
    $this->dbforge->create_table('ebooks');
    
    
    
    $this->dbforge->add_key('id', TRUE);
    
    $training_table = array(
      'id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE 
      ),
      'class' => array(
          'type' => 'VARCHAR', 'constraint' => 20, 'null' => FALSE
      ),
      'item_raw' => array(
          'type' => 'VARCHAR', 'constraint' => 50, 'null' => FALSE
      ),
      'item_stemmed' => array(
          'type' => 'VARCHAR', 'constraint' => 50, 'null' => FALSE
      ),
      'count' => array(
          'type' => 'INT', 'constraint' => 11, 'null' => FALSE
      )
    );
    
    $this->dbforge->add_field($training_table);
    $this->dbforge->create_table('training');
    
    
  }
  
  public function down() {
    
  }
  
}

/* End of file 001_initial_schema.php */
/* Location: ./application/migrations/001_initial_schema.php */
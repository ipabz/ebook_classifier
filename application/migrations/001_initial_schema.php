<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Initial_schema extends CI_Migration {
  
  public function up() {
    
    /**
     * Remove tables if exists
     */
    /*$this->dbforge->drop_table('classifications');
    $this->dbforge->drop_table('ebook');
    $this->dbforge->drop_table('ebooks');
    $this->dbforge->drop_table('logs');
    $this->dbforge->drop_table('training');
	$this->dbforge->drop_table('testing');*/



    /**
     * Create 'training_models' table
     */

    $this->dbforge->add_key('id', TRUE);
    
    $training_model_table = array(
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
    
    $this->dbforge->add_field($training_model_table);
    $this->dbforge->create_table('training_models');


    
    
    $time = @time();
  
    
    
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
    
	/**
     * Create 'testing' table
     */
    $this->dbforge->add_key('testing_id', TRUE);
    
    $testing_table = array(
      'testing_id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE 
      ),
      'filename' => array(
          'type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE
      ),
      'classification' => array(
          'type' => 'VARCHAR', 'constraint' => 10, 'null' => FALSE
      ),
      'actual' => array(
          'type' => 'VARCHAR', 'constraint' => 10, 'null' => FALSE
      ),
      'tokens' => array(
          'type' => 'TEXT', 'null' => TRUE
      ),
      'date_tested' => array(
          'type' => 'TEXT', 'null' => FALSE
      )
    );
    
    $this->dbforge->add_field($testing_table);
    $this->dbforge->create_table('testing');
    
  }
  
  public function down() {
    $this->dbforge->drop_table('classifications');
    $this->dbforge->drop_table('ebook');
    $this->dbforge->drop_table('ebooks');
    $this->dbforge->drop_table('logs');
    $this->dbforge->drop_table('training');
	$this->dbforge->drop_table('testing');
  }
  
}

/* End of file 001_initial_schema.php */
/* Location: ./application/migrations/001_initial_schema.php */
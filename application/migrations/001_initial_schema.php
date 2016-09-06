<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Migration_Initial_schema extends CI_Migration
{
    public function up()
    {
    
    /**
     * Remove tables if exists
     */
    $this->dbforge->drop_table('ebook', true);
        $this->dbforge->drop_table('training', true);
        $this->dbforge->drop_table('training_model', true);
        $this->dbforge->drop_table('testing', true);
        $this->dbforge->drop_table('ebook_textfile', true);


     /**
     * Create 'training_models' table
     */

    $this->dbforge->add_key('id', true);
    
        $ebook_textfile = array(
      'id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true
      ),'ebook_id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => true
      ),
      'file' => array(
          'type' => 'VARCHAR', 'constraint' => 255, 'null' => false
      )
    );
    
        $this->dbforge->add_field($ebook_textfile);
        $this->dbforge->create_table('ebook_textfile');



    /**
     * Create 'training_models' table
     */

    $this->dbforge->add_key('model_id', true);
    
        $training_model_table = array(
      'model_id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true
      ),
      'class' => array(
          'type' => 'VARCHAR', 'constraint' => 20, 'null' => false
      ),
      'raw_dataset' => array(
          'type' => 'VARCHAR', 'constraint' => 50, 'null' => false
      ),
      'stemmed_dataset' => array(
          'type' => 'VARCHAR', 'constraint' => 50, 'null' => false
      ),
      'prior_probability' => array(
          'type' => 'TEXT', 'null' => false
      )
    );
    
        $this->dbforge->add_field($training_model_table);
        $this->dbforge->create_table('training_model');


    
    
        $time = @time();
  
    
    
    /**
     * Create 'ebooks' table
     */
    $this->dbforge->add_key('id', true);
    
        $ebooks_table = array(
      'id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true
      ),
      'filename' => array(
          'type' => 'TEXT', 'null' => false
      ),
      'classification' => array(
          'type' => 'VARCHAR', 'constraint' => 10, 'null' => false
      ),
      'meta_data' => array(
          'type' => 'TEXT', 'null' => true
      ),
      'file_num' => array(
          'type' => 'TEXT', 'null' => false
      )
    );
    
        $this->dbforge->add_field($ebooks_table);
        $this->dbforge->create_table('ebook');
    
    
    
        $this->dbforge->add_key('id', true);
    
        $training_table = array(
      'id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true
      ),
      'class' => array(
          'type' => 'VARCHAR', 'constraint' => 20, 'null' => false
      ),
      'item_raw' => array(
          'type' => 'VARCHAR', 'constraint' => 50, 'null' => false
      ),
      'item_stemmed' => array(
          'type' => 'VARCHAR', 'constraint' => 50, 'null' => false
      ),
      'count' => array(
          'type' => 'INT', 'constraint' => 11, 'null' => false
      )
    );
    
        $this->dbforge->add_field($training_table);
        $this->dbforge->create_table('training');
    
    /**
     * Create 'testing' table
     */
    $this->dbforge->add_key('testing_id', true);
    
        $testing_table = array(
      'testing_id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true
      ),
      'filename' => array(
          'type' => 'VARCHAR', 'constraint' => 255, 'null' => false
      ),
      'classifier_result' => array(
          'type' => 'VARCHAR', 'constraint' => 10, 'null' => false
      ),
      'actual_class' => array(
          'type' => 'VARCHAR', 'constraint' => 10, 'null' => false
      ),
      'dataset' => array(
          'type' => 'TEXT', 'null' => true
      ),
      'NB_classification' => array(
          'type' => 'TEXT', 'null' => true
      ),
      'file_num' => array(
          'type' => 'TEXT', 'null' => false
      ),
      'model_id' => array(
          'type' => 'INT', 'constraint' => 11, 'unsigned' => true
      )
    );
    
        $this->dbforge->add_field($testing_table);
        $this->dbforge->create_table('testing');
    }
  
    public function down()
    {
        $this->dbforge->drop_table('ebook');
        $this->dbforge->drop_table('training');
        $this->dbforge->drop_table('training_model');
        $this->dbforge->drop_table('testing');
    }
}

/* End of file 001_initial_schema.php */
/* Location: ./application/migrations/001_initial_schema.php */

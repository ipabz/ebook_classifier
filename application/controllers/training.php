<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Training extends CI_Controller {

	public function index()
	{
      define('TRAINING', true);
      $data['classifications'] = $this->classifications->get_all();
      
      $this->load->view('common/header', $data);
      $this->load->view('main_view');
      $this->load->view('common/footer');
	}
    
    public function train()
    {
      
      $this->session->unset_userdata('training_ids');
      
      define('TRAINING', true);
      $this->session->unset_userdata('class');
      
      $data['classifications'] = $this->classifications->get_all();
      
      $this->load->view('common/header', $data);
      $this->load->view('train_view_v2');
      $this->load->view('common/footer');
    }
    
    public function set_category($class)
    {
      $this->session->set_userdata('class', $class);
      print trim( $this->session->userdata('class') );
    }
    
    public function handle_file_training()
    {
      
      $data['contents'] = @$_POST['filename'];
      $data['date'] = @time();
      $data['type'] = 'File Upload';
      
      if ( trim($data['contents']) !== '[]' && trim($data['contents']) !== ''  && trim($data['contents']) !== 'null'  && trim($data['contents']) !== NULL) {
        
        $this->db->insert('logs', $data);

        
        $class = @$_POST['corpus'];
        
        $data2 = $this->string->train(
                    'server/php/files/'.$data['contents'],
                    $class
                    );
        
        
        $id = $this->training_model->save_entry(
                    $data['contents'],
                    $class,
                    $data2['tokens'],
                    $data2['counted']
                    );
        
        
        
      }
      
      
      
    }
    
    public function do_training()
    {
      
      $ids = trim($this->session->userdata('training_ids'));
      $data = array();
      
      if ($ids !== '') {
        $exp = explode(',', $ids);
        $query = $this->training_model->get_entries($exp);
        
        foreach($query->result() as $row) {
          $data = $this->string->train(
                    'server/php/files/'.$row->filename,
                    $row->classification
                    );
          
          $data[] = $this->training_model->save_entry(
                    $row->filename,
                    $row->classification,
                    $data['tokens'],
                    $data['counted']
                    );
          
          $this->db->where('id', $row->id);
          $this->db->delete(TABLE_TRAINING);
          
        }
        
        $this->session->unset_userdata('training_ids');
      }
      
      print implode(',', $data);
      
      
    }
    
    public function upload_files_v2()
    {
      require('server/php/UploadHandler.php');
      $upload_handler = new UploadHandler();
    }
    
    public function the_category()
    {
      print trim( $this->session->userdata('class') );
    }
    
    public function upload_files()
	{
		$class = trim( $this->session->userdata('class') );
        $this->session->unset_userdata('class');
        
        if ($class === '') {
          $class = '004';
        }
        
		$config['upload_path'] = './assets/uploads/pdf/'.$class.'/';
		$config['allowed_types'] = 'pdf';
		$config['overwrite'] = FALSE;
		$this->load->library('upload', $config);
		$d = array();
		
		if ( ! $d = $this->upload->do_multiple_upload() )
		{
			$d['message'] = $this->upload->display_errors();
		} else {
          
          $ids = array();
          
          foreach($d as $file) {
           
            $data = $this->string->train(
                    'assets/uploads/pdf/'.$class.'/'.$file['file_name'],
                    $class
                    );
            
             
            $ids[] = $this->training_model->save_entry(
                    $file['file_name'],
                    $class,
                    $data['tokens'],
                    $data['counted']
                    ); 
          }
          
          $d['inserted_ids'] = implode(',', $ids);
          
        }

		
		print json_encode($d);
		
	}
    
    
    
    public function show_results()
    {
      define('TRAINING', true);
      $ids = $this->input->get('ids');
      $exploded = explode(',', $ids);
      
      if (trim($ids) === '') {
        $exploded = array();
      }
      
      $corpus = trim( $this->input->get('corpus') );
      
      $data['query'] = $this->training_model->get_entries($exploded, $corpus);
      $data['classifications'] = $this->classifications->get_all();
      
      $this->load->view('common/header', $data);
      $this->load->view('training_results_view');
      $this->load->view('common/footer');
      
    }
	
}

/* End of file training.php */
/* Location: ./application/controllers/trainingss.php */
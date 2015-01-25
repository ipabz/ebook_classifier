<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Training extends CI_Controller {

	public function index()
	{
      $data['classifications'] = $this->classifications->get_all();
      
      $this->load->view('common/header', $data);
      $this->load->view('main_view');
      $this->load->view('common/footer');
	}
    
    public function train()
    {
      define('TRAINING', true);
      
      $data['classifications'] = $this->classifications->get_all();
      
      $this->load->view('common/header', $data);
      $this->load->view('train_view');
      $this->load->view('common/footer');
    }
    
    public function upload_files($class="004")
	{
		
		$config['upload_path'] = './assets/uploads/pdf/'.$class.'/';
		$config['allowed_types'] = 'pdf';
		$config['overwrite'] = TRUE;
		$this->load->library('upload', $config);
		$d = array();
		
		if ( ! $d = $this->upload->do_multiple_upload() )
		{
			$d['message'] = $this->upload->display_errors();
		} else {
          
          foreach($d as $file) {
           
            $data = $this->stringhandler->process(
                    'assets/pdf/'.$class.'/'.$file['file_name'],
                    'class'.$class.'.txt'
                    );
            
            
            
             
            $this->training_model->save_entry(
                    $file['file_name'],
                    $class,
                    $data['tokens'],
                    $data['counted']
                    ); 
          }
          
        }

		
		print json_encode($d);
		
	}
	
}

/* End of file training.php */
/* Location: ./application/controllers/trainingss.php */
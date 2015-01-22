<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Training extends CI_Controller {

	public function index()
	{
      $data['classifications'] = $this->classifications->get_all();
      
      $this->load->view('common/header', $data);
      $this->load->view('main_view');
      $this->load->view('common/footer');
	}
	
}

/* End of file training.php */
/* Location: ./application/controllers/trainingss.php */
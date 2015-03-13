<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class testing extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
	$this->load->model('testing_model');
  }
  
  public function index()
  {
    print 'Forbidden Access!';
  }

  public function test($error='')
  {
    $this->session->unset_userdata('training_ids');

    define('JUST_CSS', true);
    $this->session->unset_userdata('class');

    $data['classifications'] = $this->classifications->get_all();
    $data['error'] = $error;
    $data['sucess'] = '';

    $this->load->view('common/header', $data);
    $this->load->view('test_view');
    $this->load->view('common/footer');
  }
  
  /*
  function do_upload()
  {
      $config['upload_path'] = './assets/uploads/';
      $config['allowed_types'] = 'pdf';

      $this->load->library('upload', $config);

      if ( ! $this->upload->do_upload())
      {
        $error = $this->upload->display_errors(); 
        $this->test($error);
      }
      else
      {
        $data['file_data'] = $this->upload->data();
        
        $pdf_file = 'assets/uploads/'.$data['file_data']['file_name'];
        $data['datas'] = $this->string->process($pdf_file);
        
        define('JUST_CSS', true);
        $this->session->unset_userdata('class');

        $data['classifications'] = $this->classifications->get_all();
        $data['error'] = '';
        $data['sucess'] = 'yes';
        $data['class004'] = $this->training_model->get_training_set('004');
        $data['class005'] = $this->training_model->get_training_set('005');
        $data['class006'] = $this->training_model->get_training_set('006');
        $data['type'] = '+1';

        $this->load->view('common/header', $data);
        $this->load->view('test_view');
        $this->load->view('common/footer');
        
      }
  }
  */
  
  function do_upload()
  {
      $config['upload_path'] = './assets/uploads/';
      $config['allowed_types'] = 'pdf';

      $this->load->library('upload', $config);

      if ( ! $this->upload->do_upload())
      {
        $error = $this->upload->display_errors(); 
        $this->test($error);
      }
      else
      {
		error_reporting(1);
        $data['file_data'] = $this->upload->data();
        
        define('JUST_CSS', true);
        $this->session->unset_userdata('class');

        $data['classifications'] = $this->classifications->get_all();
        $data['error'] = '';
        $data['sucess'] = 'yes';
		$data['_data'] = $this->testing_model->test($data['file_data']);
		

        $this->load->view('common/header', $data);
        $this->load->view('test_view');
        $this->load->view('common/footer');
        
      }
  }
  
  public function accuracy($filename, $class, $accuracy) 
  {
	  
	  $this->testing_model->accuracy($filename, $class, $accuracy, $this->input->post('tokens'));
	  
  }
  
  public function testing_accuracy()
  {
	  define('TRAINING', true);
      $data['classifications'] = $this->classifications->get_all();
      $data['query'] = $this->testing_model->get();
	  
      $this->load->view('common/header', $data);
      $this->load->view('test_accuracy_view');
      $this->load->view('common/footer');
  }
  
  public function t()
  {/*
	  $num1 = "2";
	 $num2 = "6";
	 $r    = mysql_query("Select @sum:=$num1 * $num2");
	 $sumR = mysql_fetch_row($r);
	 $sum  = $sumR[0];
	 */
	 
	 $this->db->select('Select @sum:=$num1 * $num2');
	 $query=$this->db->get();
  }
    
}

/* End of file testing.php */
/* Location: ./application/controllers/testing.php */
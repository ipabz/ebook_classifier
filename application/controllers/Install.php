<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Install extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }
  
    public function index()
    {
        $this->load->library('migration');
        $success = $this->migration->current();
      
        $data['page_title'] = 'Install';
      
        define('JUST_CSS', true);
        $this->session->unset_userdata('class');

        $data['classifications'] = $this->classifications->get_all();
        $data['error'] = '';
        $data['sucess'] = '';
      
        if ($success) {
            $data['html'] = '<div class="alert alert-success">Database successfully migrated to the latest version.</div>';
        } else {
            $data['html'] = '<div class="alert alert-danger">An error occured while doing database migrations!</div>';
        }
      
        $this->load->view('common/header', $data);
        $this->load->view('main_view');
        $this->load->view('common/footer');
    }
}

/* End of file install.php */
/* Location: ./application/controllers/install.php */

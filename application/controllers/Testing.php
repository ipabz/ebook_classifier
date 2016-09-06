<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Testing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('classifier');
        $this->session->set_userdata('PDFxStreamInUse', 'no');
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
  
  
    public function do_upload()
    {
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'pdf';

        $this->load->library('upload', $config);

        if (! $this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            $this->test($error);
        } else {
            error_reporting(1);
            $data['file_data'] = $this->upload->data();
        
            define('JUST_CSS', true);
            $this->session->unset_userdata('class');

            $data['classifications'] = $this->classifications->get_all();
            $data['error'] = '';
            $data['sucess'] = 'yes';
            $data['_data'] = $this->classifier->test($data['file_data']);
          
            $data2 = $data['_data']['pre_process'];
            $this->classifier->save_entry(
                    $data['file_data']['file_name'], $class, $data2['tokens'], $data2['counted'], $data2['removed_stop_words'], $data2['corpus_count'], $data2['meta_data'], $data2['bigram_raw'], $data2['bigram_counted'], $data2['final_tokens'], $data2['all_text'], $data2['toc'], $data2['tokenized'], $data2['bigram_stemmed'], $data['_data']['unique_words_004_calculation'], $data['_data']['unique_words_005_calculation'], $data['_data']['unique_words_006_calculation']
            );

            $pdf_file = $data['file_data']['file_name'];
            $this->session->set_userdata('testing_pdf_file', $pdf_file);
        

            $this->load->view('common/header', $data);
            $this->load->view('test_view');
            $this->load->view('common/footer');
        }
    }
  
    public function accuracy($filename, $class, $accuracy)
    {
        $this->classifier->accuracy($filename, $class, $accuracy, $this->input->post('tokens'), $this->input->post('nb_classification'));
    }
  
    public function testing_accuracy()
    {
        define('TRAINING', true);
        $data['classifications'] = $this->classifications->get_all();
        $data['evaluation'] = $this->classifier->getEvaluation();
      
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

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Training extends CI_Controller {
  
    public function __construct() {
      parent::__construct();   
      //$this->training_model->train();
    }

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
    
    public function handle_file_training_v2()
    {
      
      $GLOBALS['uploadedfile'] = '';
      
      include 'server/php/UploadHandler.php';
      $upload_handler = new UploadHandler();
      $temp = (Object)($GLOBALS['uploadedfile'][0]);

      $data['contents'] = $temp->name;
      $data['date'] = '';
      $data['type'] = 'File Upload';
      
      if ( trim($data['contents']) !== '[]' && trim($data['contents']) !== ''  && trim($data['contents']) !== 'null'  && trim($data['contents']) !== NULL) {
        
        $class = @$_POST['corpus'];
        
        $data2 = $this->string->process(
                    'server/php/files/'.$data['contents'],
                    $class
                    );
        
        $id = $this->training_model->save_entry(
                    $data['contents'],
                    $class,
                    $data2['tokens'],
                    $data2['counted'],
                    $data2['removed_stop_words'],
                    $data2['corpus_count'],
                    $data2['meta_data'],
                    $data2['bigram_raw'],
                    $data2['bigram_counted'],
                    $data2['final_tokens'],
                    $data2['all_text']
                    );
        
        $dd[] = $id;

        $this->training_model->train($dd);

        
      }
      
    }
    
    public function handle_file_training()
    {
      
      $data['contents'] = @$_POST['uploadedfile_name'];
      $data['date'] = @time();
      $data['type'] = 'File Upload';
      
      if ( trim($data['contents']) !== '[]' && trim($data['contents']) !== ''  && trim($data['contents']) !== 'null'  && trim($data['contents']) !== NULL) {
        
        //$this->db->insert('logs', $data);
        
        $class = @$_POST['class'];
        
        $data2 = $this->string->process(
                    'server/php/files/'.$data['contents'],
                    $class
                    );
        
        $id = $this->training_model->save_entry(
                    $data['contents'],
                    $class,
                    $data2['tokens'],
                    $data2['counted'],
                    $data2['removed_stop_words'],
                    $data2['corpus_count'],
                    $data2['meta_data'],
                    $data2['bigram_raw'],
                    $data2['bigram_counted'],
                    $data2['final_tokens']
                    );
        
        $dd[] = $id;
        
        $this->training_model->train($dd);
        
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
          $data = $this->string->process(
                    'server/php/files/'.$row->filename,
                    $row->classification
                    );
          
          $data[] = $this->training_model->save_entry(
                    $row->filename,
                    $row->classification,
                    $data['tokens'],
                    $data['counted'],
                    $data['removed_stop_words']
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
    
    public function view_ebooks($corpus="004")
    {
      
      $data['ebooks'] = $this->training_model->get_entries(array(), trim($corpus));
      $data['classifications'] = $this->classifications->get_all();
      $data['corpus'] =  $corpus;
      
      $this->load->view('common/header', $data);
      $this->load->view('ebooks_view');
      $this->load->view('common/footer');
      
    }
    
    public function corpora_raw($type='raw')
    {
      $data['classifications'] = $this->classifications->get_all();
      $data['class004'] = $this->training_model->get_training_set('004');
      $data['class005'] = $this->training_model->get_training_set('005');
      $data['class006'] = $this->training_model->get_training_set('006');
      
      if ($type === 'plus1') {
        $type = '+1';
      }
      
      $data['type'] = $type;
      
      $max = $data['class004']->num_rows();
      
      if ($max < $data['class005']->num_rows()) {
        $max = $data['class005']->num_rows();
      }
      
      if ($max < $data['class006']->num_rows()) {
        $max = $data['class006']->num_rows();
      }
      
      $data['row_count'] = $max;
      
      
      $this->load->view('common/header', $data);
      $this->load->view('corpora_view');
      $this->load->view('common/footer');
    }
    
    public function view_tokens($id)
    {      error_reporting(1);
      $this->db->where('id', $id);
      $query = $this->db->get(TABLE_EBOOK);
      
      if ($query->num_rows() > 0) {
        
        $row = $query->row();
        $temp_tokens = ( $row->final_tokens );
        $tokens = array();
        $html = '';
        
        $json = preg_replace('/[^(\x20-\x7F)]*/','', $temp_tokens);   
        
        preg_match('/rhs:\s*"([^"]+)"/', $json, $m);
        $json = $m[1];
        
        $temp_tokens = json_decode($json);
        
        foreach($temp_tokens as $key => $val) {
          $tokens[] = $key;
          $html .= '<div style="float: left; margin: 10px;">'.$key.'</div>';
        }
        
        $html .= '<div style="clear: both;"></div>';
        
        print $html;
        
      } else {
        print 'empty';
      }
      
    }
	
}

/* End of file training.php */
/* Location: ./application/controllers/trainingss.php */
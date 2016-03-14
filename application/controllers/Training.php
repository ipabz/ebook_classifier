<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Training extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->training_model->train();
        //$this->session->set_userdata('PDFxStreamInUse', 'no');
    }

    public function index() {
        define('TRAINING', true);
		$this->session->set_userdata('PDFxStreamInUse', 'no');
        $data['classifications'] = $this->classifications->get_all();

        $this->load->view('common/header', $data);
        $this->load->view('main_view');
        $this->load->view('common/footer');
    }

    public function train() {

        $this->session->unset_userdata('training_ids');

        define('TRAINING', true);
        $this->session->unset_userdata('class');

        $data['classifications'] = $this->classifications->get_all();

        $this->load->view('common/header', $data);
        $this->load->view('train_view_v2');
        $this->load->view('common/footer');
    }

    public function handle_file_training_v2() {

        
        while( $this->session->userdata('PDFxStreamInUse') == 'yes' ) {
            usleep(500);
        }

        $this->session->set_userdata('PDFxStreamInUse', 'yes');

        $GLOBALS['uploadedfile'] = '';

        include 'server/php/UploadHandler.php';
        $upload_handler = new UploadHandler();
        $temp = (Object) ($GLOBALS['uploadedfile'][0]);

        $data['contents'] = $temp->name;
        $data['date'] = '';
        $data['type'] = 'File Upload';

        if (trim($data['contents']) !== '[]' && trim($data['contents']) !== '' && trim($data['contents']) !== 'null' && trim($data['contents']) !== NULL) {

            $class = @$_POST['corpus'];
            
            $theFileName = $data['contents'];
            $tempFile = @time() . '-' . (rand() * 100) . '.pdf';
            
            
            if ( @copy(FCPATH.'server/php/files/'.$data['contents'], FCPATH.'server/php/files/'.$tempFile) ) {
                $theFileName = $tempFile;
            }

            $data2 = $this->string->process(
                    'server/php/files/' . $theFileName, $class
            );

            $id = $this->training_model->save_entry(
                    $data['contents'], $class, $data2['tokens'], $data2['counted'], $data2['removed_stop_words'], $data2['corpus_count'], $data2['meta_data'], $data2['bigram_raw'], $data2['bigram_counted'], $data2['final_tokens'], $data2['all_text']
            );

            $dd[] = $id;

            $this->training_model->train($dd);
        }
        
        $this->session->set_userdata('PDFxStreamInUse', 'no');
    }

    public function show_results() {
        define('TRAINING', true);
        $ids = $this->input->get('ids');
        $exploded = explode(',', $ids);

        if (trim($ids) === '') {
            $exploded = array();
        }

        $corpus = trim($this->input->get('corpus'));

        $data['query'] = $this->training_model->get_entries($exploded, $corpus);
        $data['classifications'] = $this->classifications->get_all();

        $this->load->view('common/header', $data);
        $this->load->view('training_results_view');
        $this->load->view('common/footer');
    }

    public function view_ebooks($corpus = "all", $per_page = 25, $offset = 0) {
        $this->load->library('pagination');

        $this->session->set_userdata('PDFxStreamInUse', 'no');

        $config['base_url'] = site_url('training/view_ebooks/' . trim($corpus)) . '/' . $per_page . '/';
        $config['total_rows'] = $this->training_model->get_entries(array(), trim($corpus))->num_rows();
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 5;
        $config['full_tag_open'] = '<nav class="pull-left"><ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = '';
        $config['first_tag_open'] = '';
        $config['first_tag_close'] = '';
        $config['last_link'] = '';
        $config['last_tag_open'] = '';
        $config['last_tag_close'] = '';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</a></li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $data['ebooks'] = $this->training_model->get_entries(array(), trim($corpus), $config['per_page'], $offset);
        $data['classifications'] = $this->classifications->get_all();
        $data['corpus'] = $corpus;
        $data['per_page'] = $per_page;
        $data['offset'] = $offset + 1;

        $this->pagination->initialize($config);

        $this->load->view('common/header', $data);
        $this->load->view('ebooks_view');
        $this->load->view('common/footer');
    }

    public function corpora_raw($type = 'raw') {
        $this->session->set_userdata('PDFxStreamInUse', 'no');
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

    public function awp($type = 'raw') {

        $this->session->set_userdata('PDFxStreamInUse', 'no');
        
        $this->training_model->generate_awp();
        
        $data['classifications'] = $this->classifications->get_all();
        $data['class004'] = $this->training_model->get_training_set('004', TABLE_TRAINING_MODEL);
        $data['class005'] = $this->training_model->get_training_set('005', TABLE_TRAINING_MODEL);
        $data['class006'] = $this->training_model->get_training_set('006', TABLE_TRAINING_MODEL);

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
        $this->load->view('awp_view');
        $this->load->view('common/footer');
    }

    public function view_tokens($id) {

        $this->session->set_userdata('PDFxStreamInUse', 'no');
        $this->db->where('id', $id);
        $query = $this->db->get(TABLE_EBOOK);

        $preprocess = $this->training_model->get_preprocess_data($id);

        if ($query->num_rows() > 0) {

            $row = $query->row();
            $temp_tokens = json_decode($preprocess['final_tokens']);
            $tokens = array();
            $html = '';

            foreach ($temp_tokens as $key => $val) {
                $tokens[] = $key;
                $html .= '<div class="label label-info" style="float: left; margin: 5px;">' . $key . '</div>';
            }

            $html .= '<div style="clear: both;"></div>';

            print '<div style="height: 400px; overflow: auto;">' . $html . '</div>';
        }
    }



    public function generate_awp()
    {
        $this->training_model->generate_awp();

        define('JUST_CSS', true);

        $data['classifications'] = $this->classifications->get_all();

        $data['html'] = '<div class="alert alert-success">Training Model successfully generated.</div>';

        $this->load->view('common/header', $data);
        $this->load->view('main_view');
        $this->load->view('common/footer');
    }

}

/* End of file training.php */
/* Location: ./application/controllers/trainingss.php */
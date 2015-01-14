<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('stringhandler');
        $string = 'analog computers auxiliary storage broadband equipment computer programming analog computers this is ares';
        $array = $this->stringhandler->tokenize($string);
        $array = $this->stringhandler->remove_less_meaningful_words($array);
        
        print '<pre>';
        print_r($array);
        
        
        
        $this->load->library('stemmer');
        $word = "computers";
        print_r( $this->stemmer->stem_list($word) ); 
        
        $str = 'happy beautiful happy lines pear gin happy lines rock happy lines pear ';
        $words = $this->stringhandler->count_occurences($array, implode(' ', $array));
        print_r($words);
        
        $text = 'happy beautiful happy lines pear gin happy lines rock happy lines pear ';
        echo substr_count($text, 'happy beautiful');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
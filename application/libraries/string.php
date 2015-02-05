<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class String {
  
  private $ci = NULL;
  
  public function __construct() {
    $this->ci =& get_instance();
    $this->ci->load->model('stringhandler');
    include 'assets/vendor/autoload.php';
  }
  
  public function pdf_to_text($pdf_file)
  {   

    $parser = new \Smalot\PdfParser\Parser();
    $pdf    = $parser->parseFile($pdf_file);

    $pages  = $pdf->getPages();
    $text = '';
    $counter = 15;

    foreach ($pages as $page) {
      
      if ($counter <= 0) {
        break;
      }
      
      $temp_text = $page->getText();   
      $text .= $temp_text . "\n";
      $counter--;   
      
    }
    
    return $text;
  }
  
  public function tokenize_by_word($text)
  {
    $chars = "\\-=,?!':;_@#$&%^()[]{}/\"<>+*1234567890 ";
    
    $tok = strtok($text, $chars);
    $words = array();
    
    while ($tok !== false) {
        $words[] = strtolower($tok);
        $tok = strtok($chars);
    }
    
    return $words;
  }
  
  public function string_by_line($text)
  {
    $lines = array();
    
    foreach(preg_split("/((\r?\n)|(\r\n?))/", $text) as $line) {
      $line = trim($line);
      
      if ( $line !== '' ) {
        $lines[] = $line;
      }
    } 
    
    return $lines;
  }
  
  public function train($pdf_file, $category="004")
  {
    $text = $this->pdf_to_text($pdf_file);    
    $lines = $this->string_by_line($text);
    $words = $this->tokenize_by_word($text);
    $removed_stop_words = $this->ci->stringhandler->remove_stop_words($words);
    $removed_stop_words = $this->ci->stringhandler->remove_less_meaningful_words($removed_stop_words);
    $stemmed = $this->ci->stringhandler->stem_array($removed_stop_words);
    
    $count = $this->ci->stringhandler->count_occurences($stemmed, implode(' ', $stemmed));
    
    $data['tokens'] = $stemmed;
    $data['counted'] = $count;
    
    return $data;
  }
  
} // End class String

/* End of file string.php */
/* Location: ./application/libraries/string.php */
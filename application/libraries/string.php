<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class String {
  
  private $ci = NULL;
  
  public function __construct() {
    $this->ci =& get_instance();
    $this->ci->load->model('stringhandler');
    include 'assets/vendor/autoload.php';
  }
  
  public function get_pdf_metadata($pdf_file)
  {
    
    $parser = new \Smalot\PdfParser\Parser();
    $pdf    = $parser->parseFile($pdf_file);

    $details  = $pdf->getDetails();

    $data = array();
    
    foreach ($details as $property => $value) {
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        $data[strtolower($property)] = $value;
    }
    
    return $data;
    
  }
  
  public function pdf_to_text($pdf_file)
  {   

    $parser = new \Smalot\PdfParser\Parser();
    $pdf    = $parser->parseFile($pdf_file);

    $pages  = $pdf->getPages();
    $details  = $pdf->getDetails();
    
    $text = '';
    $counter = 30;
    $meta = array();

    foreach ($pages as $page) {
      
      if ($counter <= 0) {
        break;
      }
      
      $temp_text = $page->getText();   
      $text .= $temp_text . "\n";
      $counter--;   
      
      usleep(60000);
      
    }
    
    foreach ($details as $property => $value) {
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        $meta[strtolower(trim($property))] = $value;
    }
    
    $data['text'] = $text;
    $data['meta_data'] = $meta;
    
    return $data;
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
  
  private function intersection($a1,$a2,$a3)
  {
    $stemmed_file = $this->ci->stringhandler->stem_array($a1);
    $data = array();
    $counter = 0;
    
    foreach($stemmed_file as $word) {
      
      $count = 0;
      
      if (in_array($word, $a2) ) {
        $count = $a3[$word];
      }
      
      $data[$a1[$counter]] = $count;
              
      $counter++;
      
    }
    
    return $data;
    
  }
  
  public function train($pdf_file, $category="004")
  {
    $temp_d = $this->pdf_to_text($pdf_file);
    $text = $temp_d['text'];
    $lines = $this->string_by_line($text);
    $words = $this->tokenize_by_word($text);
    $removed_stop_words = $this->ci->stringhandler->remove_stop_words($words);
    $removed_stop_words = $this->ci->stringhandler->remove_less_meaningful_words($removed_stop_words);
    $stemmed = $this->ci->stringhandler->stem_array($removed_stop_words);
    
    $count = $this->ci->stringhandler->count_occurences($stemmed, implode(' ', $stemmed));
    
    $dictionary_file = "assets/dictionaries/class".$category.".txt";
    $file_lines = $this->ci->stringhandler->read_file($dictionary_file);
    
    
    $diction_with_count = $this->intersection($file_lines, $stemmed, $count);
    
    $data['tokens'] = $stemmed;
    $data['counted'] = $count;
    $data['removed_stop_words'] = $removed_stop_words;
    $data['corpus_count'] = $diction_with_count;
    $data['meta_data'] = $temp_d['meta_data'];
    
    return $data;
  }
  
} // End class String

/* End of file string.php */
/* Location: ./application/libraries/string.php */
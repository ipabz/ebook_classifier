<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class String {
  
  private $ci = NULL;
  
  //PDF Vars
  private $get_pdf_meta_data_cmd = 'C:\xampp\htdocs\xpdfbin-win-3.04\bin64\pdfinfo -f 1 -l 50 ';
  private $path_to_xpdf_pdftotext_cmd = 'C:\xampp\htdocs\xpdfbin-win-3.04\bin64\pdftotext.exe';
  
  public function __construct() {
    $this->ci =& get_instance();
    $this->ci->load->model('stringhandler');
    include 'assets/vendor/autoload.php';
    include 'assets/pdftotext/autoload.php';
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
    $pdf_file = realpath($pdf_file);
    
    $text = '';
    $counter = 50;
    $meta = array();    
    
    // Get meta data
    $content = shell_exec($this->get_pdf_meta_data_cmd.$pdf_file.' ');

    $temp = explode("\n", $content);

    foreach($temp as $row) {
        $t = str_replace(' ', '', $row);
        $exp = explode(":", $t);

        $meta[ strtolower( mb_convert_encoding( trim(@$exp[0]), 'UTF-8')) ] = mb_convert_encoding( trim(@$exp[1]), 'UTF-8' );
    }
    unset($meta['']);
    //-----------------------------------------------------------------
    
    
    // Get text
    try {
      $pdfToText = XPDF\PdfToText::create(array(
          'pdftotext.binaries' => $this->path_to_xpdf_pdftotext_cmd,
          'pdftotext.timeout' => 60,
      ), NULL);

      $text = mb_convert_encoding( $pdfToText->getText($pdf_file, 1, $counter), 'UTF-8' );
    } catch(Exception $e) {
      $text = $e->getMessage();
    }
    //-----------------------------------------------------------------
    
    
    
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
        $words[] = addslashes(utf8_encode(strtolower($tok)));
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
  
  public function build_tokens($text)
  {
    
  }
  
  public function process($pdf_file, $category="004")
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
    
    $bigram_temp = $this->build_bigram($removed_stop_words);
    $bigram_raw = $bigram_temp['bigram_raw'];
    $bigram_stemmed = $bigram_temp['bigram_stemmed'];
    $bigram_counted = $this->count_bigram($bigram_stemmed);
    
    $raws_temp = array_merge($removed_stop_words, $bigram_raw);
    
    $final_tokens = array_merge($count, $bigram_counted);
    
    $final_tokens_raw = array_merge($removed_stop_words, $bigram_raw);
    
    ksort($final_tokens);
    ksort($final_tokens_raw);
    
    $data['tokens'] = $stemmed;
    $data['counted'] = $count;
    $data['removed_stop_words'] = $removed_stop_words;
    $data['corpus_count'] = $diction_with_count;
    $data['meta_data'] = $temp_d['meta_data'];
    $data['bigram_raw'] = $bigram_raw;
    $data['bigram_stemmed'] = $bigram_stemmed;
    $data['bigram_counted'] = $bigram_counted;
    $data['final_tokens'] = $final_tokens;
    $data['final_tokens_raw'] = $final_tokens_raw;
    $data['all_text'] = $text;
    
    return $data;
  }
  
  public function build_bigram($words)
  {
    $bigrams = array();
    $stemmed = array();
    
    $this->ci->load->library('stemmer');
    
    for($x=1; $x < count($words); $x++) {
      $bigrams[] = utf8_encode($words[$x-1]) . ' ' . utf8_encode($words[$x]);
      $stemmed[] = $this->ci->stemmer->stem(utf8_encode($words[$x-1])) . ' ' . $this->ci->stemmer->stem(utf8_encode($words[$x]));
    }
    
    $data['bigram_raw'] = $bigrams;
    $data['bigram_stemmed'] = $stemmed;
    
    return $data;
  }
  
  public function count_bigram($bigram)
  {
    
    $counts = array_count_values($bigram);
    
    return $counts;
    
  }
  
  public function search($needle, $haystack) {
    
    $index = 0;
    
    foreach ($haystack as $key => $val) {
      if (strtolower($needle) === strtolower($val['item_stemmed'])) {
        break;
      }
      
      $index++;
    }
    
    return $index;
    
  }
  
} // End class String

/* End of file string.php */
/* Location: ./application/libraries/string.php */
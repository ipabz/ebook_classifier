<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class String {

  private $ci = NULL;

  //PDF Vars
  private $get_pdf_meta_data_cmd = 'C:\wamp\www\xpdfbin-win-3.04\bin64\pdfinfo ';

  //C:\Program Files (x86)\Java\jdk1.7.0_79\bin
  private $javaBin = 'C:\Program Files (x86)\Java\jdk1.7.0_79\bin';


  public function __construct() {
    $this->ci =& get_instance();
    $this->ci->load->model('stringhandler');
  }

  

  public function pdf_to_text($pdf_file)
  {
    $pdf_file = realpath($pdf_file);
    
    $text = '';
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
    chdir($this->javaBin);
    $text = shell_exec('java -jar '.FCPATH.'assets\pdftotext\TextToPdf.jar '.$pdf_file);
    $allText = mb_convert_encoding($text, 'UTF-8');
    $toc = $this->getOnlyToc($allText);
    //-----------------------------------------------------------------



    $data['text'] = $toc;
    $data['meta_data'] = $meta;
    $data['allTheText'] = $allText;

    return $data;
  }


  public function getOnlyToc($text)
  {
        $toc_begin = array(
          'table of contents',
          'table of content',
          'contents',
          'content'
        );

        $toc_end = array(
          'index',
          'appendixes',
          'bibliography',
          'author index',
          'glossary',
          'references'
        );

        $sub = array(
          'foreword',
          'about the authors',
          'acknowledgment',
          'acknowledgments',
          'copyright',
          'preface',
          'chapter',
          'chapters',
          'introduction',
          '1',
          'I',
          'about the author',
          'part'
        );
    
    
        $exp = explode(' ', $text);
        $_words = array();
        $start = false;
        $repeat = 0;
        $counter = 0;

        foreach($exp as $key => $val) {

          $__tmp = strtolower($val);

          if ($counter > 0) {

            if ($counter === 1 && $__tmp === 'at') {
              $counter++;
            } else if ($counter === 2 && $__tmp === 'a') {
              $counter++;
            } else if ($counter === 3 && $__tmp === 'glance') {
              $counter = 0;
            } else {
              if ( in_array($__tmp, $sub) ) {
                $start = true;
              }
            }
            
          }

          if ( in_array($__tmp, $toc_begin) ) {
            $counter = 1;
          }
          
          if ($start) {
            $_words[] = $__tmp;
          }
          
          if ( (in_array($__tmp, $toc_end) && $start && count($_words) > 0) ) {
                $start = false;
                break;
          }



        }

        $textTOC = trim( implode(' ', $_words) );

        if ( $textTOC === '') {
            print 'Error: TOC not Identified.';
        }

        return $textTOC;

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


  public function process($pdf_file, $category="004")
  {
    $temp_d = $this->pdf_to_text($pdf_file); 
    $text = $temp_d['text'];
    $words = $this->tokenize_by_word($text);
    $removed_stop_words = $this->ci->stringhandler->remove_stop_words($words);
    $removed_stop_words = $this->ci->stringhandler->remove_less_meaningful_words($removed_stop_words);
    $stemmed = $this->ci->stringhandler->stem_array($removed_stop_words);

    $count = $this->ci->stringhandler->count_occurences($stemmed, implode(' ', $stemmed));
    
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
    $data['corpus_count'] = '';
    $data['meta_data'] = $temp_d['meta_data'];
    $data['bigram_raw'] = $bigram_raw;
    $data['bigram_stemmed'] = $bigram_stemmed;
    $data['bigram_counted'] = $bigram_counted;
    $data['final_tokens'] = $final_tokens;
    $data['final_tokens_raw'] = $final_tokens_raw;
    $data['all_text'] = $temp_d['allTheText'];
    
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

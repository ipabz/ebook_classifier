<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * String Handler Class
 * 
 * Handles all string manipulations
 * 
 * @package CodeIgniter
 * @subpackage Models
 * @category Models
 */

class StringHandler extends CI_Model {
  
  /**
   * Set of characters used to trigger the splitting of words
   * 
   * @var string $tokens
   */
  private $tokens = ",?!.:;_@#$%^()[]{}/\"<>+*1234567890 ";
  
  /**
   *  Contains an array of words which carry less meaning
   * 
   * @var array
   */
  private $stop_words = '';
  
  /**
   * Path/to/dictionary
   * 
   * @var string
   */
  public $dictionary_file = 'assets/dictionaries/class004.txt';
  
  
  /**
   * Constructor
   * 
   * Initializes everything needed to process strings
   */
  public function __construct() {
    parent::__construct();
	
    // Load the needed libraries
	$this->load->library('pdf2text');
    $this->load->library('stemmer');
    
    $this->stop_words = array(
        'so',
        'and',
        'the'
    );
  }
  // --------------------------------------------------------------------
  
  
  /**
   * Gets all the text in a pdf file
   * 
   * @param string $pdf_file       - Path to the pdf file
   * @return string                - All the text from the pdf
   */
  public function pdf_to_text($pdf_file)
  {
    $this->pdf2text->setFilename($pdf_file);
    $this->pdf2text->decodePDF();
    
    return $this->pdf2text->output();
  } // End function pdf_to_text
  // --------------------------------------------------------------------
  
  
  /**
   * Splits a sentence into individual words
   * 
   * @param string $sentence
   * @return array returns an array of words
   */
  public function tokenize($sentence)
  {
    
    // Dictionary
    $file_lines = $this->read_file($this->dictionary_file);
    $stemmed_file = $this->stem_array($file_lines);
    
    $temp_dictionary = array();
    $temp_dictionary2 = array();
    
    for($x=0; $x < count($file_lines); $x++) {
      $temp_dictionary[trim($stemmed_file[$x])] = trim($file_lines[$x]);
      $temp_dictionary2[trim($file_lines[$x])] = trim($stemmed_file[$x]);
    }
    // ------------------------------------------------------------------
    
    // Sentence
    $stemmed_words = $this->stem($sentence);
    // ------------------------------------------------------------------
    
    // Count occurences of dictionary words
    $dictionary_words = $this->count_occurences($stemmed_file, $stemmed_words);
    $dw = array();
    
    foreach($dictionary_words as $word => $count) {
      for($x=0; $x < $count; $x++) {
        $dw[] = $temp_dictionary[ $word ];
      }
    }
    // ------------------------------------------------------------------
    
    // Sentence tokenize
    $tok = strtok($sentence, $this->tokens);
    $words1 = array();
    
    while ($tok !== false) {
        $words1[] = $tok;
        $tok = strtok($this->tokens);
    }
    
    $words = array_merge($words1, $dw);
    // ------------------------------------------------------------------
    
    return $words;
  } // End function tokenize
  // --------------------------------------------------------------------
  
  
  /**
   * Stopping: remove common words which are less informative
   * 
   * @param array $words
   * @return array returns an array of words
   */
  public function remove_stop_words($words)
  {
    $new_words = array();
    
    for($x=0; $x < count($words); $x++) {
      
      if ( ! in_array($words[$x], $this->stop_words) ) {
        $new_words[] = $words[$x];
      }      
      
    } // end foreach
    
    return $new_words;
  } // End function remove_stop_words
  // --------------------------------------------------------------------
  
  
  /**
   * Replace some characters with a space
   * 
   * @param string $text
   * @return string
   */
  public function replace_some_chars_with_space($text)
  {
    $tok = strtok($text, $this->tokens);
    $words = '';
    
    while ($tok !== false) {
        $words .= $tok . ' ';
        $tok = strtok($this->tokens);
    }
    
    $words = trim($words);
    
    return $words;
  } // End function replace_some_chars_with_space
  // --------------------------------------------------------------------
  
  
  /**
   * Get the contents of a file
   * 
   * @param type $file_name     - Path/to/filename
   * @return array              - File contents line by line
   */
  public function read_file($file_name)
  {
    $file = new SplFileObject($file_name);
    $dictionary = array();
    
    while (!$file->eof()) {
        $dictionary[] = trim($file->fgets());
    }
    
    return $dictionary;
  } // End function read_file
  // --------------------------------------------------------------------
  
  
  /**
   * Stemming using Porter's algorithm
   * 
   * @param mixed $words String or Array of word(s)
   * @return type
   */
  public function stem($words)
  {
    $w = $this->stemmer->stem_list($words);
    
    if ( is_array($w) ) {
      $w = implode(' ', $w);
    }
    
    return $w;
    //return implode(' ', $this->stemmer->stem_list($words));
  } // End function stem
  // --------------------------------------------------------------------
  
  
  /**
   * Stemming using Porter's algorithm
   * 
   * @param array $array_of_words
   * @return array
   */
  public function stem_array($array_of_words)
  {
    $file = array();
    
    foreach($array_of_words as $words) {
      $file[] = $this->stem($words);
    }
    
    return $file;
  } // End function stem_array
  // --------------------------------------------------------------------
  
  
  /**
   * 
   * @param mixed $words String or Array of word(s)
   * @param type $text
   * @return array
   */
  public function count_occurences($words, $text)
  {
    if ( ! is_array($words) ) {
      $words = explode(' ', $words);
    }
    
    $data = array();
    $text = ' '.trim($text).' ';
    
    foreach($words as $word) {
      if (trim($word) != '') {
        $count = substr_count($text, ' '.trim($word).' ');

        if ($count > 0) {
          $data[trim($word)] = $count;
        }
      }
    }
    
    return $data;
  } // End function count_occurences
  // --------------------------------------------------------------------
  
  
  /**
   * Remove words which are less than 3 characters in length
   * 
   * @param array $words
   * @return array
   */
  public function remove_less_meaningful_words($words)
  {
    $final_words = array();
    
    foreach($words as $word) {
      if (strlen($word) > 3) {
        $final_words[] = trim($word);
      }
    }
    
    return $final_words;
  } // End function remove_less_meaningful_words
  // --------------------------------------------------------------------
  
  
  public function process($pdf_file, $dictionary='class004.txt')
  {
    $this->dictionary_file = 'assets/dictionaries/'.$dictionary;
    $text = $this->pdf_to_text($pdf_file);
    $text = strtolower($text);
    $text = $this->replace_some_chars_with_space($text);
    $tokenized = $this->tokenize($text);
    $tokenized = $this->remove_less_meaningful_words($tokenized);
    $removed_stop_words = $this->remove_stop_words($tokenized);
    
    $counted = $this->count_occurences(
            $removed_stop_words, 
            implode(' ', $removed_stop_words));
    
    return $counted;
  }
  
} // End class StringHandler


/* File StringHandler.php */
/* ./application/models/StringHandler.php */
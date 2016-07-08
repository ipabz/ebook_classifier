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

class Stringhandler extends CI_Model {

  /**
   * Set of characters used to trigger the splitting of words
   *
   * @var string $tokens
   */
  private $tokens = ",?!.:;_@#$%^()[]{}/\"<>+*1234567890\n\r\t ";

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
  

  /**
   * Constructor
   *
   * Initializes everything needed to process strings
   */
  public function __construct() {
    parent::__construct();

    // Load the needed libraries
	//$this->load->library('pdf2text');
    $this->load->library('stemmer');

    $this->stop_words = $this->read_file('assets/stop_words.txt');
  }
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
   * Get the contents of a file
   *
   * @param type $file_name     - Path/to/filename
   * @return array              - File contents line by line
   */
  public function read_file($file_name)
  {
    $file_name = ($file_name);
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
      $word = utf8_encode( trim($word) );
      if ( strlen($word) > 3 && (!preg_match('/[^A-Za-z0-9]/', $word)) ) {
        $final_words[] = $word;
      }
    }

    return $final_words;
  } // End function remove_less_meaningful_words
  // --------------------------------------------------------------------


} // End class StringHandler


/* File StringHandler.php */
/* ./application/models/StringHandler.php */

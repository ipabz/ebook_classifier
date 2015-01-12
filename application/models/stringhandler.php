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
  private $tokens = ",?!.:;_@#$%^()[]{}/\"<>+* ";
  
  /**
   *  Contains an array of words which carry less meaning
   * 
   * @var array
   */
  private $stop_words = '';
  
  
  /**
   * Constructor
   * 
   * Initializes everything needed to process strings
   */
  public function __construct() {
    parent::__construct();
    
    $this->stop_words = array(
        'so',
        'and',
        'the'
    );
  }
  // --------------------------------------------------------------------
  
  
  /**
   * Splits a sentence into individual words
   * 
   * @param string $sentence
   * @return array returns an array of words
   */
  public function tokenize($sentence)
  {
    $tok = strtok($sentence, $this->tokens);
    $words = array();
    
    while ($tok !== false) {
        $words[] = $tok;
        $tok = strtok($this->tokens);
    }
    
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
  
  
} // End class StringHandler


/* File StringHandler.php */
/* ./application/models/StringHandler.php */
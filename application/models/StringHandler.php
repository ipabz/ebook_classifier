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
   * Constructor
   * 
   * Initializes everything needed to process strings
   */
  public function __construct() {
    parent::__construct();
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
  
} // End class StringHandler


/* File StringHandler.php */
/* ./application/models/StringHandler.php */
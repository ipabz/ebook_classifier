<?php  if (! defined('BASEPATH')) {
     exit('No direct script access allowed');
 }
/**
 * @package CodeIgniter
 * @subpackage Models
 * @category Models
 */

class Classifications extends CI_Model
{

    /**
   * Gets all the book classifications
   * 
   * @return object
   */
  public function get_all()
  {
      return [
        '004', '005', '006'
    ];
  } // End function get_all
} // End class Classifications


/* File classifications.php */
/* ./application/models/classifications.php */

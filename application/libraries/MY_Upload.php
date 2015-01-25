<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Upload extends CI_Upload {
	
	public function do_multiple_upload($field = 'userfile')
	{
		$upload_datas = FALSE;
		
		foreach ($_FILES as $key => $value) {
			if ( $this->do_upload($key) ) {
				$upload_datas[] = $this->data();	
			} else {
				
			}
		}
		
		return $upload_datas;
	}
		
}
// END Upload Class

/* End of file MY_Upload.php */
/* Location: ./application/libraries/MY_Upload.php */

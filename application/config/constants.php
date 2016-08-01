<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');



/**
 * Database Tables
 */

// define('TABLE_CLASSIFICATIONS', 'classifications');
define('TABLE_EBOOK', 'ebook');
define('TABLE_TRAINING', 'training');
define('TABLE_TESTING', 'testing');
define('TABLE_TRAINING_MODEL', 'training_model');
define('TABLE_EBOOK_TEXTFILE', 'ebook_textfile');

define('EBOOKS_DIR', 'assets/ebooks/');
define('DATA_SET', 'assets/dataset/');
define('TESTING_DIR', 'assets/testing/');
@ini_set('max_execution_time', 0);
//@set_time_limit(10000);
@ini_set('memory_limit', '1024M');
//@ini_set('post_max_size', '200M');
//@ini_set('upload_max_filesize', '200M');

define('THRESHOLD', 12);

//C:\Program Files (x86)\Java\jdk1.7.0_79\bin
define('JAVA_PATH', 'C:\Program Files\Java\jdk1.8.0_91\bin');

//C:\wamp\www\xpdfbin-win-3.04\bin64
define('XPDF_PATH', 'C:\Users\icpabelona\Desktop\Code\xpdfbin-win-3.04\bin64');

/* End of file constants.php */
/* Location: ./application/config/constants.php */
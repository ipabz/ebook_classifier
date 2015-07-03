<?php

include "assets/php-bignumbers/autoload.php";
use \Litipk\BigNumbers\Decimal as Decimal;

class Testing_model extends CI_Model {

	public function accuracy($filename, $class, $accuracy, $tokens)
	{

	  $data = array(
		'filename' => base64_decode(urldecode($filename)),
		'classification' => $class,
		'is_accurate' => $accuracy,
		'tokens' => $tokens,
		'date_tested' => @time()
	  );

	  $this->db->insert(TABLE_TESTING, $data);

	}

	public function get()
	{
		$query = $this->db->get(TABLE_TESTING);

		return $query;
	}

	public function test($file_data)
	{


		$pdf_file = 'assets/uploads/'.$file_data['file_name'];
		$datas = $this->string->process($pdf_file);
		$prior = array();
		$product = array();
		$final_tokens_raw = $datas['final_tokens_raw'];
		$final_tokens = $datas['final_tokens'];

		$this->db->where('classification', '004');
		$doc_count_004 = $this->db->count_all_results(TABLE_EBOOK);

		$this->db->where('classification', '005');
		$doc_count_005 = $this->db->count_all_results(TABLE_EBOOK);

		$this->db->where('classification', '006');
		$doc_count_006 = $this->db->count_all_results(TABLE_EBOOK);

		$doc_count_all = $this->db->count_all(TABLE_EBOOK);

		$prior['004'] = $doc_count_004 / $doc_count_all;
		$prior['005'] = $doc_count_005 / $doc_count_all;
		$prior['006'] = $doc_count_006 / $doc_count_all;

		$corpora_num_unique_words = $this->db->count_all(TABLE_TRAINING);

		$corpora_doc_count_004 = $this->training_model->frequency_sum('004');
      	$corpora_doc_count_005 = $this->training_model->frequency_sum('005');
      	$corpora_doc_count_006 = $this->training_model->frequency_sum('006');
		$t_count = 0;

		$product['004'] = Decimal::create(1, 5);
		$product['005'] = Decimal::create(1, 5);
		$product['006'] = Decimal::create(1, 5);

		$product_004 = 1;
		$product_005 = 1;
		$product_006 = 1;

		foreach($final_tokens_raw as $row) {

			$exploded = explode(' ', $row);
            $stemmed = '';

			foreach($exploded as $s) {
				$stemmed = $this->stemmer->stem($s). ' ';
		    }

		 	$stemmed = trim($stemmed);
			$t_count = 1;

			if (@$final_tokens[ $stemmed ]) {
				//$t_count = $final_tokens[ $stemmed ] + 1;
			}

            $t_count = (int)@$final_tokens[ $stemmed ] + 1;


            $product['004'] = $product['004'] * ($t_count / ($corpora_doc_count_004 + $corpora_num_unique_words));
            $product['005'] = $product['005'] * ($t_count / ($corpora_doc_count_005 + $corpora_num_unique_words));
            $product['006'] = $product['006'] * ($t_count / ($corpora_doc_count_006 + $corpora_num_unique_words));

            $_tmp = explode('E', $product['004']);
            $product['004'] = $_tmp[0];

            $_tmp = explode('E', $product['005']);
            $product['005'] = $_tmp[0];

            $_tmp = explode('E', $product['006']);
            $product['006'] = $_tmp[0];


		}

        $product['004'] = $product['004'] * $prior['004'];
        $product['005'] = $product['005'] * $prior['005'];
        $product['006'] = $product['006'] * $prior['006'];

        $_tmp = explode('E', $product['004']);
        $product['004'] = $_tmp[0];

        $_tmp = explode('E', $product['005']);
        $product['005'] = $_tmp[0];

        $_tmp = explode('E', $product['006']);
        $product['006'] = $_tmp[0];

		$_class = '004';


        if ($product['004'] > $product['005'] && $product['004'] > $product['006']) {
          $_class = '004';
        }

        if ($product['005'] > $product['004'] && $product['005'] > $product['006']) {
          $_class = '005';
        }

        if ($product['006'] > $product['005'] && $product['006'] > $product['004']) {
          $_class = '006';
        }

		$data['result'] = @$_class;
		$data['product_004'] = $product['004'];
		$data['product_005'] = $product['005'];
		$data['product_006'] = $product['006'];
		$data['prior_004'] = $prior['004'];
		$data['prior_005'] = $prior['005'];
		$data['prior_006'] = $prior['006'];
		$data['corpora_doc_count_004'] = $corpora_doc_count_004;
		$data['corpora_doc_count_005'] = $corpora_doc_count_005;
		$data['corpora_doc_count_006'] = $corpora_doc_count_006;
		$data['corpora_num_unique_words'] = $corpora_num_unique_words;
		$data['doc_count_all'] = $doc_count_all;
        $data['pre_process'] = $datas;

		return $data;

	} // end function test

}

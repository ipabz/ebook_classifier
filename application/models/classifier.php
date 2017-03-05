<?php

use \Litipk\BigNumbers\Decimal as Decimal;

class classifier extends CI_Model
{
    public function save_entry($filename, $class, $tokens = "", $counted = "", $removed_stop_words = "", $corpus_counted = "", $meta_data = array(), $bigram_raw = array(), $bigram_counted = array(), $final_tokens = array(), $all_text = '', $toc = '', $tokenized = '', $bigram_stemmed = '', $word004 = array(), $word005 = array(), $word006 = array(), $allUniqueWords = array())
    {
        $ebookDir = FCPATH . TESTING_DIR;

        if (trim($all_text) !== '') {
            $data = array(
                'filename' => $filename,
                'classification' => $class,
                'date_created' => @time()
            );

            if (count($meta_data) > 0) {
                $data['meta_data'] = json_encode($meta_data);
            }

            $ebook_id = $filename . '-' . (@time());

            if (count($final_tokens) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_final_tokens.txt";
                $this->create_file($_filename, json_encode($final_tokens));
            }

            if (count($bigram_counted) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_bigram_counted.txt";
                $this->create_file($_filename, json_encode($bigram_counted));
            }

            if (count($bigram_raw) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_bigram_raw.txt";
                $this->create_file($_filename, json_encode($bigram_raw));
            }

            if (count($corpus_counted) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_corpus_count.txt";
                $this->create_file($_filename, json_encode($corpus_counted));
            }

            if (count($removed_stop_words) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_removed_stop_words.txt";
                $this->create_file($_filename, json_encode($removed_stop_words));
            }

            if (count($counted) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_tokens_count.txt";
                $this->create_file($_filename, json_encode($counted));
            }

            if (count($tokens) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_tokens.txt";
                $this->create_file($_filename, json_encode($tokens));
            }

            if (trim($all_text) !== '') {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_all_text.txt";
                $this->create_file($_filename, $all_text);
            }

            if (trim($toc) !== '') {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_toc.txt";
                $this->create_file($_filename, $toc);
            }

            if (count($tokenized) > 0) {
                $_filename = $ebookDir . "testing" . $ebook_id . "_tokenized.txt";
                $this->create_file($_filename, json_encode($tokenized));
            }

            if (count($bigram_stemmed) > 0) {
                $_filename = $ebookDir . "testing" . $ebook_id . "_bigram_stemmed.txt";
                $this->create_file($_filename, json_encode($bigram_stemmed));
            }

            if (count($word004) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_004_conditional_probabilities.txt";
                $this->create_file($_filename, json_encode($word004));
            }

            if (count($word005) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_005_conditional_probabilities.txt";
                $this->create_file($_filename, json_encode($word005));
            }

            if (count($word006) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_006_conditional_probabilities.txt";
                $this->create_file($_filename, json_encode($word006));
            }

            if (count($allUniqueWords) > 0) {
                $_filename = $ebookDir . "testing-" . $ebook_id . "_unique_words.txt";
                $this->create_file($_filename, json_encode($allUniqueWords));
            }

            return $ebook_id;
        }

        return null;
    }

    private function create_file($filename, $contents)
    {
        $myfile = fopen($filename, "w") or die("Unable to open file!");
        $txt = $contents;
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function accuracy($filename, $class, $accuracy, $tokens, $nb_class)
    {

        // Get the latest training model
        $this->db->limit(1);
        $this->db->order_by('model_id', 'DESC');
        $trainingModelResult = $this->db->get(TABLE_TRAINING_MODEL);
        $trainingModel = $trainingModelResult->row();

        if ($accuracy === '1') {
            $accuracy = '004';
        } elseif ($accuracy === '2') {
            $accuracy = '005';
        } elseif ($accuracy === '3') {
            $accuracy = '006';
        }

        $pdf_file = $this->session->userdata('testing_pdf_file');

        if ($class === $accuracy) {
            @copy('assets/uploads/' . $pdf_file, 'classified_ebooks/' . $accuracy . '/' . $pdf_file);
        }

        $data = array(
            'filename' => base64_decode(urldecode($filename)),
            'classifier_result' => $class,
            'actual_class' => $accuracy,
            'dataset' => $tokens,
            'NB_classification' => $nb_class,
            'file_num' => @time(),
            'model_id' => $trainingModel->model_id
        );

        $this->db->insert(TABLE_TESTING, $data);
    }

    public function get()
    {
        $query = $this->db->get(TABLE_TESTING);

        return $query;
    }

    public function getLatestTrainingModel()
    {
        $this->db->limit(1);
        $this->db->order_by('model_id', 'DESC');
        $trainingModelResult = $this->db->get(TABLE_TRAINING_MODEL);

        return $trainingModelResult;
    }

    public function readTextFile($file)
    {
        $this->load->helper('file');

        $absFile = FCPATH . $file;
        $contents = read_file($absFile);

        return $contents;
    }

    public function getUniqueItemsOnly($items)
    {
        $temp = array();

        foreach($items as $key => $val) {
            if (!in_array($key, $temp)) {
                $temp[] = $key;
            } else {
                unset($items[$key]);
            }
        }

        return $items;
    }

    public function test($file_data)
    {
        $pdf_file = 'assets/uploads/' . $file_data['file_name'];
        $datas = $this->string->process($pdf_file);
        $prior = array();
        $product = array();
        $final_tokens_raw = $datas['final_tokens_raw'];
        $final_tokens = $datas['final_tokens'];

        // Get the latest training model
        $trainingModelResult = $this->getLatestTrainingModel();
        $trainingModel = $trainingModelResult->row();

        $prior_probability = (array) json_decode($trainingModel->prior_probability);
        extract($prior_probability);

        $trainingModelStemmedItems = (array) json_decode($this->readTextFile($trainingModel->stemmed_dataset));
        $uniqueWords = $this->getUniqueItemsOnly($final_tokens_raw);

        $t_count = 0;

        $product['004'] = Decimal::create(0, 5);
        $product['005'] = Decimal::create(0, 5);
        $product['006'] = Decimal::create(0, 5);

        $wordCalculation004 = array();
        $wordCalculation005 = array();
        $wordCalculation006 = array();

        $uniqueWordsWithCount = array();
        $classificationsArray = array(
            '004', '005', '006'
        );

        foreach($classificationsArray as $cls) {
            $cdcTemp = 0;

            if ($cls === '004') {
                $cdcTemp = $corpus_doc_count_004;
            } else if ($cls === '005') {
                $cdcTemp = $corpus_doc_count_005;
            } else if ($cls === '006') {
                $cdcTemp = $corpus_doc_count_006;
            }

            foreach ($uniqueWords as $row) {

                $exploded = explode(' ', $row);
                $stemmed = '';

                foreach ($exploded as $s) {
                    $stemmed = $this->stemmer->stem($s) . ' ';
                }

                $stemmed = trim($stemmed);

                $t_count = (int) @$trainingModelStemmedItems[$cls][$stemmed] + 1;
                $uniqueWordsWithCount[$stemmed] = (int) @$final_tokens[$stemmed];
                $product[$cls] = $product[$cls] * ($t_count / ($cdcTemp + $corpus_num_unique_words));

                $_tmp = explode('E', $product[$cls]);
                $product[$cls] = $_tmp[0];

                if ($cls === '004') {
                    $wordCalculation004[$stemmed] = number_format( (double)($t_count / ($corpus_doc_count_004 + $corpus_num_unique_words)), 4);
                } else if ($cls === '005') {
                    $wordCalculation005[$stemmed] = number_format( (double)($t_count / ($corpus_doc_count_005 + $corpus_num_unique_words)), 4);
                } else if ($cls === '006') {
                    $wordCalculation006[$stemmed] = number_format( (double)($t_count / ($corpus_doc_count_006 + $corpus_num_unique_words)), 4);
                }

            }
        }

        $product['004'] = $product['004'] * $prior_004;
        $product['005'] = $product['005'] * $prior_005;
        $product['006'] = $product['006'] * $prior_006;
        

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
        $data['nb_classification'] = [
            't_count' => $t_count,
            'product_004' => number_format($product['004'], 2, '.', ''),
            'product_005' => number_format($product['005'], 2, '.', ''),
            'product_006' => number_format($product['006'], 2, '.', '')
        ];
        $data['product_004'] = $product['004'];
        $data['product_005'] = $product['005'];
        $data['product_006'] = $product['006'];
        $data['prior_004'] = $prior_004;
        $data['prior_005'] = $prior_005;
        $data['prior_006'] = $prior_006;
        $data['corpora_doc_count_004'] = $corpus_doc_count_004;
        $data['corpora_doc_count_005'] = $corpus_doc_count_005;
        $data['corpora_doc_count_006'] = $corpus_doc_count_006;
        $data['corpora_num_unique_words'] = $corpus_num_unique_words;
        $data['doc_count_all'] = $doc_count_all;
        $data['pre_process'] = $datas;
        $data['unique_words_004_calculation'] = $wordCalculation004;
        $data['unique_words_005_calculation'] = $wordCalculation005;
        $data['unique_words_006_calculation'] = $wordCalculation006;
        $data['unique_words_with_count'] = $uniqueWordsWithCount;

        return $data;
    }

// end function test

    public function getEvaluation()
    {
        $query = $this->get();

        $pg_004_004 = 0;
        $pg_004_005 = 0;
        $pg_004_006 = 0;
        $pg_005_004 = 0;
        $pg_005_005 = 0;
        $pg_005_006 = 0;
        $pg_006_004 = 0;
        $pg_006_005 = 0;
        $pg_006_006 = 0;

        foreach ($query->result() as $row) {
            if ($row->classifier_result === '004' && $row->actual_class === '004') {
                $pg_004_004++;
            }

            if ($row->classifier_result === '004' && $row->actual_class === '005') {
                $pg_004_005++;
            }

            if ($row->classifier_result === '004' && $row->actual_class === '006') {
                $pg_004_006++;
            }


            if ($row->classifier_result === '005' && $row->actual_class === '004') {
                $pg_005_004++;
            }

            if ($row->classifier_result === '005' && $row->actual_class === '005') {
                $pg_005_005++;
            }

            if ($row->classifier_result === '005' && $row->actual_class === '006') {
                $pg_005_006++;
            }


            if ($row->classifier_result === '006' && $row->actual_class === '004') {
                $pg_006_004++;
            }

            if ($row->classifier_result === '006' && $row->actual_class === '005') {
                $pg_006_005++;
            }

            if ($row->classifier_result === '006' && $row->actual_class === '006') {
                $pg_006_006++;
            }
        }

        return [
            '004_004' => $pg_004_004,
            '004_005' => $pg_004_005,
            '004_006' => $pg_004_006,
            '005_004' => $pg_005_004,
            '005_005' => $pg_005_005,
            '005_006' => $pg_005_006,
            '006_004' => $pg_006_004,
            '006_005' => $pg_006_005,
            '006_006' => $pg_006_006,
            'TotalPredicted_004' => $pg_004_004 + $pg_004_005 + $pg_004_006,
            'TotalPredicted_005' => $pg_005_004 + $pg_005_005 + $pg_005_006,
            'TotalPredicted_006' => $pg_006_004 + $pg_006_005 + $pg_006_006,
            'TotalGoldLabel_004' => $pg_004_004 + $pg_005_004 + $pg_006_004,
            'TotalGoldLabel_005' => $pg_004_005 + $pg_005_005 + $pg_006_005,
            'TotalGoldLabel_006' => $pg_004_006 + $pg_005_006 + $pg_006_006
        ];
    }
}

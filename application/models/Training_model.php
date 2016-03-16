<?php

class Training_model extends CI_Model {

    public function save_entry($filename, $class, $tokens = "", $counted = "", $removed_stop_words = "", $corpus_counted = "", $meta_data = array(), $bigram_raw = array(), $bigram_counted = array(), $final_tokens = array(), $all_text = '') {
        
        $ebookDir = FCPATH . EBOOKS_DIR;

        if (trim($all_text) !== '') {

            $data = array(
                'filename' => $filename,
                'classification' => $class,
                'date_created' => @time()
            );

            /*
              if (trim($tokens) !== '') {
              $data['tokens'] = json_encode($tokens);
              }
             * 
             */
            /*
              if (trim($counted) !== '') {
              $data['tokens_count'] = json_encode($counted);
              }
             * 
             */
            /*
              if (trim($removed_stop_words) !== '') {
              $data['removed_stop_words'] = json_encode($removed_stop_words);
              }
             * 
             */

            /*
              if (trim($corpus_counted) !== '') {
              $data['corpus_count'] = json_encode($corpus_counted);
              }
             * 
             */

            if (count($meta_data) > 0) {
                $data['meta_data'] = json_encode($meta_data);
            }
            /*
              if ( count($bigram_raw) > 0 ) {
              $data['bigram_raw'] = json_encode(($bigram_raw));
              }
             * 
             */
            /*
              if ( count($bigram_counted) > 0 ) {
              $data['bigram_counted'] = json_encode(($bigram_counted));
              }
             * 
             */
            /*
              if ( count($final_tokens) > 0 ) {
              $data['final_tokens'] = json_encode($final_tokens);
              }
             * 
             */

            $this->db->insert(TABLE_EBOOK, $data);
            $ebook_id = $this->db->insert_id();

            if (count($final_tokens) > 0) {
                $_filename = $ebookDir . "ebook" . $ebook_id . "_final_tokens.txt";
                $this->create_file($_filename, json_encode($final_tokens));
            }

            if (count($bigram_counted) > 0) {
                $_filename = $ebookDir . "ebook" . $ebook_id . "_bigram_counted.txt";
                $this->create_file($_filename, json_encode($bigram_counted));
            }

            if (count($bigram_raw) > 0) {
                $_filename = $ebookDir . "ebook" . $ebook_id . "_bigram_raw.txt";
                $this->create_file($_filename, json_encode($bigram_raw));
            }

            if (count($corpus_counted) > 0) {
                $_filename = $ebookDir . "ebook" . $ebook_id . "_corpus_count.txt";
                $this->create_file($_filename, json_encode($corpus_counted));
            }

            if (count($removed_stop_words) > 0) {
                $_filename = $ebookDir . "ebook" . $ebook_id . "_removed_stop_words.txt";
                $this->create_file($_filename, json_encode($removed_stop_words));
            }

            if (count($counted) > 0) {
                $_filename = $ebookDir . "ebook" . $ebook_id . "_tokens_count.txt";
                $this->create_file($_filename, json_encode($counted));
            }

            if (count($tokens) > 0) {
                $_filename = $ebookDir . "ebook" . $ebook_id . "_tokens.txt";
                $this->create_file($_filename, json_encode($tokens));
            }

            if (trim($all_text) !== '') {
                $_filename = $ebookDir . "ebook" . $ebook_id . "_all_text.txt";
                $this->create_file($_filename, $all_text);
            }

            return $ebook_id;
        }

        return NULL;
    }

    public function get_preprocess_data($ebook_id) {
        $this->load->helper('file');
        
        $ebookDir = FCPATH . EBOOKS_DIR;

        $file_base = $ebookDir . "ebook" . $ebook_id . "_";

        $data['final_tokens'] = read_file($file_base . "final_tokens.txt");
        $data['bigram_counted'] = read_file($file_base . "bigram_counted.txt");
        $data['bigram_raw'] = read_file($file_base . "bigram_raw.txt");
        $data['corpus_count'] = read_file($file_base . "corpus_count.txt");
        $data['removed_stop_words'] = read_file($file_base . "removed_stop_words.txt");
        $data['tokens_count'] = read_file($file_base . "tokens_count.txt");
        $data['tokens'] = read_file($file_base . "tokens.txt");
        $data['all_text'] = read_file($file_base . "all_text.txt");

        return $data;
    }

    private function create_file($filename, $contents) {
        $myfile = fopen($filename, "w") or die("Unable to open file!");
        $txt = $contents;
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    private function stringify($array) {

        $string = '';

        foreach ($array as $key => $val) {
            if ($string === '') {
                $string = $key . '[=]' . $val;
            } else {
                $string .= '[_]' . $key . '[=]' . $val;
            }
        }

        return $string;
    }

    private function stringify_decode($string) {
        $temp = explode('[_]', $string);
        $array = array();

        foreach ($temp as $row) {
            $exp = explode('[=]', $row);

            $array[$exp[0]] = $exp[1];
        }

        return $array;
    }

    public function get_entries($ids = array(), $class = "all", $limit = 25, $offset = 0) {
        $custom_where = '';

        if (count($ids) > 0) {

            foreach ($ids as $id) {
                if ($custom_where === '') {
                    $custom_where = 'id = "' . $id . '"';
                } else {
                    $custom_where .= ' OR id = "' . $id . '"';
                }
            }

            if ($custom_where !== '') {
                $custom_where = '(' . $custom_where . ')';
            }
        }

        if ($class !== 'all') {
            $temp = 'classification = "' . $class . '"';

            if ($custom_where !== '') {
                $custom_where .= ' AND (' . $temp . ')';
            } else {
                $custom_where = '(' . $temp . ')';
            }
        }

        $sql = "SELECT * FROM " . TABLE_EBOOK;

        if ($custom_where !== '') {
            $sql .= " WHERE " . $custom_where;
        }

        $sql .= " LIMIT $offset, $limit";

        $query = $this->db->query($sql);

        return $query;
    }

    public function train($ebook_ids = array()) {
        $custom_where = "";

        if (count($ebook_ids) > 0) {
            foreach ($ebook_ids as $id) {
                if ($custom_where === "") {
                    $custom_where = "id = '" . $id . "'";
                } else {
                    $custom_where .= " OR id = '" . $id . "'";
                }
            }
        }

        $sql = "SELECT * FROM " . TABLE_EBOOK;

        if ($custom_where !== "") {
            $sql .= " WHERE " . $custom_where;
        }

        $query = $this->db->query($sql);

        $this->load->library('stemmer');

        $data = array();

        foreach ($query->result() as $row) {

            $preprocess = $this->get_preprocess_data($row->id);

            /*
              $raw = (array)json_decode($row->removed_stop_words);
              $raw = array_unique($raw);
              $bigram_raw = array_unique((array)json_decode(($row->bigram_raw)));
              $final_tokens = (array)json_decode($row->final_tokens);
             * 
             */

            $raw = (array) json_decode($preprocess['removed_stop_words']);
            $raw = array_unique($raw);
            $bigram_raw = array_unique((array) json_decode(($preprocess['bigram_raw'])));
            $final_tokens = (array) json_decode($preprocess['final_tokens']);

            $tokens_raw = array_merge($raw, $bigram_raw);
            sort($tokens_raw);

            foreach ($tokens_raw as $item) {
                $stemmed = $this->stemmer->stem_list($item);
                $stemmed = implode(" ", $stemmed);
                $f = 0;

                if (@$final_tokens[$stemmed]) {
                    $f = @$final_tokens[$stemmed];
                }

                $data[] = array(
                    'class' => $row->classification,
                    'item_stemmed' => $stemmed,
                    'item_raw' => $item,
                    'count' => $f
                );
            }
        }

        $this->insert_training_set($data);
    }

    public function insert_training_set($data) {

        $batchItems = array();
        $batchItemsToUpdate = array();

        foreach ($data as $item) {

            $this->db->where('item_stemmed', $item['item_stemmed']);
            $this->db->where('class', $item['class']);
            $this->db->limit(1);

            $query = $this->db->get(TABLE_TRAINING);

            if ($query->num_rows() > 0) {
                $row = $query->row();
                $item['count'] = $item['count'] + $row->count;
                $item['id'] = $row->id;

                $batchItemsToUpdate[] = $item;

                // $this->db->where('id', $row->id);
                // $this->db->update(TABLE_TRAINING, $item);
            } else {
                // $this->db->insert(TABLE_TRAINING, $item);
                $batchItems[] = $item;
            }
        }

        if (count($batchItems) > 0) {
            $this->db->insert_batch(TABLE_TRAINING, $batchItems);
        }

        if (count($batchItemsToUpdate) > 0) {
            $this->db->update_batch(TABLE_TRAINING, $batchItemsToUpdate, 'id');
        }
        
    }

    public function frequency_sum($class = "004", $table=TABLE_TRAINING, $awp=false) {
        $this->db->where('class', $class);

        if ($awp) {
            $this->db->where('count >', THRESSHOLD);
        }

        $query = $this->db->get($table);

        $sum = 0;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $sum += $row->count;
            }
        }

        return $sum;
    }

    public function get_training_set($class = "004", $table=TABLE_TRAINING, $awp=false) {
        $this->db->where('class', $class);

        if ($awp) {
            $this->db->where('count >', THRESSHOLD);
        }

        $this->db->order_by('item_stemmed');
        $query = $this->db->get($table);

        return $query;
    }



    public function generate_awp()
    {

        $result = $this->db->get(TABLE_TRAINING);
        $raw_dataset = [];
        $stemmed_dataset = [];

        foreach($result->result_array() as $model) {
            
            if ( $model['count'] > THRESSHOLD ) {

                $raw_dataset[] = [
                    $model['item_raw'] => $model['count']
                ];

                $stemmed_dataset[] = [
                    $model['item_stemmed'] => $model['count']
                ];
            }

        }


        $this->db->where('classification', '004');
        $doc_count_004 = $this->db->count_all_results(TABLE_EBOOK);

        $this->db->where('classification', '005');
        $doc_count_005 = $this->db->count_all_results(TABLE_EBOOK);

        $this->db->where('classification', '006');
        $doc_count_006 = $this->db->count_all_results(TABLE_EBOOK);

        $doc_count_all = $this->db->count_all(TABLE_EBOOK);

        $prior_004 = $doc_count_004 / $doc_count_all;
        $prior_005 = $doc_count_005 / $doc_count_all;
        $prior_006 = $doc_count_006 / $doc_count_all;

        $this->db->where('count >', THRESSHOLD);
        $corpus_num_unique_words = $this->db->count_all_results(TABLE_TRAINING);

        $corpus_doc_count_004 = $this->frequency_sum('004', TABLE_TRAINING, true);
        $corpus_doc_count_005 = $this->frequency_sum('005', TABLE_TRAINING, true);
        $corpus_doc_count_006 = $this->frequency_sum('006', TABLE_TRAINING, true);

        $prior_probability = [
            'doc_count_004' => $doc_count_004,
            'doc_count_005' => $doc_count_005,
            'doc_count_006' => $doc_count_006,
            'doc_count_all' => $doc_count_all,
            'prior_004' => $prior_004,
            'prior_005' => $prior_005,
            'prior_006' => $prior_006,
            'corpus_num_unique_words' => $corpus_num_unique_words,
            'corpus_doc_count_004' => $corpus_doc_count_004,
            'corpus_doc_count_005' => $corpus_doc_count_005,
            'corpus_doc_count_006' => $corpus_doc_count_006
        ];
        
        $this->db->insert(TABLE_TRAINING_MODEL, [
                'raw_dataset' => '',
                'stemmed_dataset' => '',
                'prior_probability' => json_encode($prior_probability)
            ]);

        $id = $this->db->insert_id();

        $this->create_file(DATA_SET.'raw_dataset_'.$id.'.txt', json_encode($raw_dataset));
        $this->create_file(DATA_SET.'stemmed_dataset_'.$id.'.txt', json_encode($stemmed_dataset));

        $this->db->where('model_id', $id);
        $this->db->update(TABLE_TRAINING_MODEL, [
                'raw_dataset' => DATA_SET.'raw_dataset_'.$id.'.txt',
                'stemmed_dataset' => DATA_SET.'stemmed_dataset_'.$id.'.txt'
            ]);

    }

}

// End class training_model

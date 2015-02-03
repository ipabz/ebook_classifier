<?php

include_once 'wordcount.php';
include_once 'categorymgr.php';

class trainer
{
	var $excludedWords = array ( 'dan',
								 'kepada',
								 'sebuah',
								 'untuk',
								 'dengan',
								 'ketika',
								 'pada',
								 'di',
								 'pada',
								 'walaupun',
								 'kalau',
								 'jika',
								 'adalah',
								 'maka'
							);
	var $ctgrmgr;
	var $arr_wc = array();
	var $debug = false;
	
	function trainer()
	{
		$this->ctgrmgr = new categoryMgr();
	}
	
	function makeCategory($ar_kat)
	{

		foreach($ar_kat as $val)
		{
			$this->trainNewCategory($val, $val);
		}
		

		foreach($ar_kat as $val)
		{
			foreach ($this->arr_wc[$val]->vocab as $key => $row)
			{
				$prob = (1 + $row) / ($this->ctgrmgr->listCategory[$val]->jumWordInCategory + $this->arr_wc[$val]->jumVocab);

				$this->ctgrmgr->listCategory[$val]->addWordProb($key, $prob);
			}
			if ($this->debug)
			{
				echo "<br/>";
				echo "jum in category : "; echo $this->ctgrmgr->listCategory[$val]->jumWordInCategory; echo "<br/>";
				echo "jum vocab : "; echo $this->arr_wc[$val]->jumVocab; echo "<br/>";
				echo "get cat prob $val : "; echo $this->ctgrmgr->getCatProb($val); echo "<br/>";
			}
		}
		$this->serializeCat();
	}
	
	function trainNewCategory($catname, $dir)
	{
		$this->ctgrmgr->addCategory($catname);
		
		if ($d = opendir('cat/'.$dir))
		{	
			$data = '';
			$jumfile = 0;
			while ($f1 = readdir($d))
			{
				$path = 'cat/'.$dir.'/'.$f1;
				$info = pathinfo($path);
				if (is_file($path) && ($info['extension'] == 'txt'))
				{
					$data = file_get_contents($path).$data;
					$jumfile++;
				}
			}
			if (($jumfile == 0) || (strlen($data) == 0))
			{
				die ("PHPTextClassifier error : Not found training folder 'cat/$dir' ");
			}
			$this->trainData($catname, $data);
			closedir($d);
		}
		else
		{
			die ("PHPTextClassifier error : Directory 'cat/$dir' not found!");
		}
	}
	
	function trainData($catname, $data)
	{
		$wc = new wordcount();
		$jumkata = 0; 
		
		$words = preg_split('/\s+/',$data,-1,PREG_SPLIT_NO_EMPTY);
		foreach ($words as $word) 
		{
			$temp = '';
			$i = 0;
			while ($i < strlen($word))
			{
				$c = $word[$i];
				if (($c>='a' && $c<='z') || ($c>='A' && $c<='Z') || ($c>='0' && $c<='9'))
				{
					$temp .= $c;
				}
				$i++;
			}
			$word = $temp;
			if (preg_match('/^[a-zA-Z0-9]+$/',$word) && (! in_array($word, $this->excludedWords)))
			{
				$wc->addWord($word);
				$jumkata++;
			}
		}
		
		$this->ctgrmgr->listCategory[$catname]->incJumWord($jumkata);

		$this->ctgrmgr->listCategory[$catname]->jumVocab = $wc->jumVocab;
		
		$this->arr_wc[$catname] = $wc;
	}
	
	function serializeCat()
	{
		$ser = serialize($this->ctgrmgr);
		$fp = fopen('wordprob.srl', 'w');
		if ($fp === false)
		{
			die('PHPTextClassifier error : Failed serialization of file wordprob.srl !');
		}
		else
		{
			$byte = fwrite($fp, $ser);
			fclose($fp);
		}
	}
}


?>
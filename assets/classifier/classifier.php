<?php

include_once 'categorymgr.php';

class classifier
{
	var $catmgr;
	
	function classifier()
	{
		$txt_catmgr = file_get_contents('wordprob.srl') or 
						die("PHPTextClassifier error : file wordprob.srl not found!");
		$this->catmgr = unserialize($txt_catmgr);
	}
	
	function classifyFile($path)
	{	
		$datafile = file_get_contents ($path);
		return $this->classifyText($datafile);
	}
	
	function classifyText($text)
	{
		$arr_nama = array();
		$arr_nilai = array();
		$arr_cat = $this->catmgr->listCategory;
		$i = 0;
		foreach ($arr_cat as $obj_cat)
		{
			$arr_nilai[$i] = $this->computeProb($text, $obj_cat->namaCat);
			$arr_nama[$i] = $obj_cat->namaCat;
			$i++;
		}
		
		$i = 1;
		$inmax = 0;
        $the_count = 0;
        
        if (is_array($arr_nilai)) {
          $the_count = count($arr_nilai);
        } else {
          $the_count = strlen($arr_nilai);
        }
        
        while ($i < $the_count)
		{
			if ($arr_nilai[$inmax] < $arr_nilai[$i])
			{
				$inmax = $i;
			}
			$i++;
		}
		
		return $arr_nama[$inmax];
	}
	
	function computeProb($text, $catname)
	{
		$arr_data = explode(' ',$text);
		if (!isset($this->catmgr->listCategory[$catname])) 
		{
			die ("PHPTextClassifier error : Category name '$catname' not found!");
		}
		$wordprb = $this->catmgr->listCategory[$catname]->wordProb->words;
		$hasil = 0; /*dalama logaritma*/
		
		foreach ($arr_data as $txt)
		{
			if (isset($wordprb[strtolower($txt)]))
			{
				$hasil += log($wordprb[strtolower($txt)]);
			}
			else
			{
				$hasil += log(1 / ($this->catmgr->listCategory[$catname]->jumWordInCategory + $this->catmgr->listCategory[$catname]->jumVocab));
			}
		}
		
		$hasil += log($this->catmgr->getCatProb($catname));
		
		return $hasil;
	}
}


?>
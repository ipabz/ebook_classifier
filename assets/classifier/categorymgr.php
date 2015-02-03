<?php

include_once 'category.php';

class categoryMgr
{
	var $listCategory = array();
	var $jumCategory;
	
	function categoryMgr()
	{
		$this->jumCategory = 0;
	}
	
	function addCategory($catname)
	{
		$cat = new category($catname);
		if (!isset($this->listCategory[$catname]))
		{
			$this->listCategory[$catname] = $cat;
			$this->jumCategory++;
		}
		else
		{
			die("Category name invalid!");
		}
	}
	
	function getAllJumlah()
	{
		$jum = 0;
		foreach ($this->listCategory as $obj)
		{
			$jum += $obj->jumWordInCategory;
		}
		return $jum;
	}
	
	function getCatProb($catname)
	{
		return $this->listCategory[$catname]->jumWordInCategory / $this->getAllJumlah();
	}
}

?>
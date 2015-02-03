<?php

include_once 'wordprob.php';

class category
{
	var $jumWordInCategory;
	var $jumVocab;
	var $categoryProb;
	var $namaCat;
	var $wordProb;
	
	function category($nama)
	{
		$this->wordProb = new wordprob();
		$this->jumWordInCategory = 0;
		$this->categoryProb = 0.5;
		$this->namaCat = $nama;
	}
	
	function incJumWord($inc)
	{
		$this->jumWordInCategory += $inc;
	}
	
	function addWordProb($word, $prob)
	{
		$this->wordProb->addProb($word, $prob);
	}
}

?>
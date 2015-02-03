<?php

class wordcount
{
	var $jumVocab;
	var $vocab = array();
	
	function wordcount()
	{
		$jumVocab = 0;
	}
	
	function addWord($word)
	{
		$word = strtolower($word);
		if (isset($this->vocab[$word]))
		{
			$this->vocab[$word]++;
		}
		else
		{
			$this->vocab[$word] = 1;
			$this->jumVocab++;
		}
	}
	
	function delVocab()
	{
		unset($vocab);
	}	
}

?>
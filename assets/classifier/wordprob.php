<?php

class wordprob
{
	var $words = array();
	
	function wordprob()
	{
	}
	
	function addProb($word, $prob)
	{
		$this->words[$word] = $prob;
	}
}

?>
<?php 

	function kode_random($length){
		$data = "123456";
		$string = "PJ-";

		for ($i=0; $i < $length ; $i++) { 
			$pos = rand(0, strlen($data) -1);
			$string .= $data[$pos];
		}
		return $string;
	}
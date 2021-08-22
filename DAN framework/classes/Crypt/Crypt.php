<?php
defined('AUTH') or die('Restricted access');

class Crypt
{
	public function encrypt($_str, $_vector = false){

		if(!$_vector){
			$rand = rand(0, 999999);
			$_vector = substr(md5($rand), 0, 16);
		}

		$hash = openssl_encrypt($_str, 'AES-256-CTR', $this->salt, 0, $_vector);
		return array('hash' => $hash, 'vector' => $_vector);
	}

	public function decrypt($_hash, $_vector = false){
		if(!$_vector) $_vector = $this->vector;
		return openssl_decrypt($_hash, 'AES-256-CTR', $this->salt, 0, $_vector);
	}
}
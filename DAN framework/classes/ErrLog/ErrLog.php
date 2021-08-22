<?php
defined('AUTH') or die('Restricted access');

class ErrLog
{
	public function write($_text){
		$this->err .= $_text;		
		$debug = debug_backtrace();
		$str = date("Y-m-d H:i:s")."\nTEXT => ".$_text."\nFILE => ".$debug[0]['file']."\nLINE => ".$debug[0]['line']."\n\n";
		$file = $_SERVER["DOCUMENT_ROOT"].'/log.txt';
		$f = fopen($file,"a+");
		fwrite($f,$str);
		fclose($f);
	}


	public function send ($err)
	{
		$subj = '=?utf-8?B?'.base64_encode('Ошибка CMS').'?=';

		$headers  = "MIME-Version: 1.0 \r\n";
		$headers .= "Date: ".date("D, d M Y h:i:s O")."\r\n";
		$headers .= "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "From: info@63s.ru <info@63s.ru> \r\n";
		$headers .= "To: info@63s.ru \r\n";

		mail('info@63s.ru', $subj, $err, $headers);
	}
}
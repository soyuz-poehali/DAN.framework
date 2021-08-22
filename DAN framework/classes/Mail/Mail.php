<?php
defined('AUTH') or die('Restricted access');

class Mail
{
	public static function send($to, $from, $subject, $message, $file='')
	{
		global $SITE;
		$data = date("d.m.Y H:i:s");

		$subject = '=?utf-8?B?'.base64_encode($subject).'?=';
		$from_encode = '=?UTF-8?B?'.base64_encode($from).'?=';

		$boundary = "--".md5(uniqid(time()));

		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Date: ". date('D, d M Y h:i:s O') ."\r\n";

		if(empty($file['tmp_name']))
		{
			$headers .="Content-Type: text/html; charset=utf-8; \r\n";
			$headers .= "From: ".$from_encode." <no-replay@".$SITE->domain."> \r\n";

			return mail($to, $subject, $message, $headers);
		}
		else
		{
			if(!preg_match("/^[a-zа-я0-9\-\ \_]*[\.]((png)|(gif)|(jpg)|(jpeg)|(pdf)|(txt)|(doc)|(docx)|(zip)|(rar)|(xls)|(xlsx)|(csv))$/ui", $file['name'])) 
			{
				$ip = self::ip();
				$m = "Дата: ".$data."\nIp: ".$ip."\n";
				$SITE->errLog("Попытка отправить запрещённый файл: ".$file['name']."\n".$m);
				return false;
			}

			$file_read = fopen($file['tmp_name'], "r");
			$file_content = fread($file_read, filesize($file['tmp_name']));
			fclose($file_read);

			$headers .="Content-Type: multipart/mixed; charset=utf-8; boundary=\"$boundary\"\r\n";
			$headers .= "From: ".$from_encode." <no-replay@".$SITE->domain."> \r\n";
			$message = $message.'<p>Дата: '.$data.'</p>'.'<p>IP: '.$ip.'</p>';

			$mess = "--$boundary\n";
			$mess .= "Content-Type: text/html; charset=utf-8\n";
			$mess .= "Content-Transfer-Encoding: Quot-Printed\n";
			$mess .= "$message\n";

			$message_part = "--$boundary\n";
			$message_part .= "Content-Type: application/octet-stream\n";
			$message_part .= "Content-Transfer-Encoding: base64\n";
			$message_part .= "Content-Disposition: attachment; filename = \"".$file['name']."\"\n\n";
			$message_part .= chunk_split(base64_encode($file_content))."\n";

			$mess .= $message_part."--$boundary--\n";

			return mail($to, $subject, $mess, $headers);
		}
		return false;
	}
	
	public static function ip()
	{
		if(isset($_SERVER['HTTP_CLIENT_IP'])){$ip = $_SERVER['HTTP_CLIENT_IP'];}
		elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
		else{$ip = $_SERVER['REMOTE_ADDR'];}
		return($ip);			
	}	
}

?>
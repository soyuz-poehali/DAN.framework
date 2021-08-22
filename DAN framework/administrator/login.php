<?php
defined('AUTH') or die('Restricted access');

// Проверка существования сессии и IP
if (isset($_SESSION['admin']) && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) 
	return;

// Если вошли методом POST - перезапрашиваем методом GET (метод пост при возврате требует повторную отправку формы)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$login = post_data('login');
	$pass = post_data('pass');
	$code = post_data('code');

	if (!$login || !$pass || !$code) {
		Header ('Location: /admin'); 
		exit;
	}

	if (isset($_SESSION['code'])) {
		if (($_SESSION['code'] == $code) && !empty($_SESSION['code'])) {
			include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/classes/AdminAuth.php';
			$AUTH = new AdminAuth;

			$user_id = $AUTH->login($login, $pass);

			if ($user_id) {
				$_SESSION['admin'] = $user_id;
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];	
			}
		}
	}

	Header ('Location: /admin'); 
	exit;
}



echo '
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="/administrator/templates/css/login.css" type="text/css" />
	<link rel="stylesheet" href="/lib/DAN/DAN.css" type="text/css" />
</head>
<body class="dan_flex_row a_wh_center">

<form class="a_form_login" method="post" action="/admin">
	<br>	
	<div class="a_form_control">
		<input class="dan_input" id="login" name="login" size="20" required>
		<label for="login">Имя пользователя</label>
	</div>
	<div class="a_form_control">
		<input id="pass" class="dan_input" name="pass" type="password" size="20" required>
		<label for="pass">Пароль</label>
	</div>
	<div>&nbsp;</div>
	<div class="a_form_control dan_flex_row_start">
		<img class="a_captcha" src="/administrator/captcha/pic.php?'.rand().' align="middle">
		<input id="code" class="dan_input" name="code" type="number" required size="4" maxlength="4">
		<label class="a_code_label" for="code">Код</label>
	</div>
	<div>&nbsp;</div>
	<input class="dan_button_blue a_enter_button" type="submit" value="Вход" name="but">
	<div>&nbsp;</div>
</form>
</body>
</html>

';

exit;



function post_data($name) {
	if (isset($_POST[$name]))
		return trim(htmlspecialchars(strip_tags($_POST[$name])));
	return false;
}



/*
$login_in = '';
$pass_in = '';

if(isset($_POST["login_in"])){$login_in = checkingeditor($_POST["login_in"]);}
if(isset($_POST["pass_in"])){$pass_in = checkingeditor($_POST["pass_in"]);}
if(isset($_POST["but"])){$but_in = $_POST["but"];} else {$but_in = '';}


// = Проверка кода на картинке ====================================================================
if(isset($_SESSION['code']) && isset($_POST['cod']))
{
	if($_SESSION['code'] == intval($_POST['cod']) && !empty($_SESSION['code']))
	{
		$cpt = 1;
	}
}

$stmt_users = $db->prepare("SELECT * FROM users WHERE login = :login LIMIT 1");
$stmt_users->execute(array('login' => $login_in));

if($stmt_users->rowCount() > 0)
{
	$m = $stmt_users->fetchAll();

	$users_id = $m['0']['id'];
	$users_login = $m['0']['login'];
	$users_psw = $m['0']['psw'];
}

$psw_in = 'dan'.$pass_in;
$pass = md5($psw_in);



// сессия
if(isset($users_psw))
{
	$ses = '5za'.$users_psw;
	$sess = md5($ses);

	if (isset($users_login) && $users_login != '') // Если данные формы переданы (значение логина не пустое)
	{
		if ($users_login === $login_in && $users_psw === $pass && $cpt == 1) // Проверяем логин, пароль, капчу
		{
			$_SESSION['s5za'] = $sess;
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

			// Если вошли методом POST - перезапрашиваем методом GET (метод пост при возврате требует повторную отправку формы)
			if($_SERVER['REQUEST_METHOD'] == 'POST'){Header ('Location: /admin'); exit;}

		}
		else
		{
			header('Location: /admin');
	  		exit;
		}
	}
}

if (isset($d) && $d[1] == 'logout') // Признак выхода. Уничтожаем сессии
{
  	session_destroy();
	header('Location: /');
	exit;
}


if (isset($_SESSION['s5za']) && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return; // Проверка существования сессии и IP
//if (isset($_SESSION['s5za'])) return; // Проверка существования сессии и IP
else {
	$rand_url = mt_rand();

	if(is_file($_SERVER['DOCUMENT_ROOT'].'/administrator/tmp/custom/login_form.php'))
	{
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/tmp/custom/login_form.php';
		echo $login_form;
	}
	else
	{
		echo '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru-ru" lang="ru-ru" >
		<head>
		  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		  <meta name="keywords" content="Вход в систему управления сайтом" />
		  <meta name="description" content="Система управления сайтом 5za" />
		  <title>Вход в систему управления сайтом</title>
		<link rel="stylesheet" href="/administrator/tmp/admin_style.css" type="text/css" />
		</head>
		<body class="bw">
		<table class="main_tab">
			<tr>
				<td class="w30pc-h100px">&nbsp;</td>
				<td class="w40pc-h100px">&nbsp;</td>
				<td class="w30pc-h100px">&nbsp;</td>
			</tr>
			<tr>
				<td class="w30pc-h220px">&nbsp;</td>
				<td class="w40pc-h220px">
					<div align="center">
						<table class="main-tab-lg">
							<tr>
								<td class="w120px-h80px">&nbsp;</td>
								<td class="vhod">Вход</td>
								<td >&nbsp;</td>
							</tr>
							<tr>
								<td class="w120px-h120px">&nbsp;</td>
								<td class="logintext">
									<form method="post" action="/admin">
										Имя пользователя<br/>
										<input class="inp" name="login_in" size="20"/>
										<div>&nbsp;</div>
										Пароль<br/>
										<input class="inp" name="pass_in" type="password" size="20"/>
										<div>&nbsp;</div>
										Введите число с картинки<br/>
										<img src="/administrator/captcha/pic.php?'.$rand_url.'" align="middle">
										<input class="inp" type="text" name="cod" size="4" maxlength="4">
										<div>&nbsp;</div>
										<input class="cursor-pointer" type="submit" value="Вход" name="but"/>
										<div>&nbsp;</div>
									</form>
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="h40px">&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</div>
				</td>
				<td class="w30pc-h220px">&nbsp;</td>
			</tr>
		</table>

		</body>
		</html>
		';
	}
}
exit;

*/
?>

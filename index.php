<?php 
	header("Content-Type:text/html;charset=utf-8");
	require_once("config.php");
	require_once("classes/Core.php");

	if ($_GET['option']) {
		$class = trim(strip_tags($_GET['option']));

	}
	else {
		$class = 'main';
	}

	if (file_exists("classes/".$class.".php")) {
		#code
		include("classes/".$class.".php");
		if(class_exists($class)) {
			$object = new $class;
			$object->get_body();

		}
		else { //Нет данных для входа
			header("Location: error.php");
		}
	}

	else { //Неправильный адрес 
		header("Location: error.php");
	}


?>